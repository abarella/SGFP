<?php
require_once __DIR__ . '/../functionsUsuario.php';

if (!function_exists('programasExtrairCampo')) {
    /**
     * Obtém valor de um campo ignorando diferenças de capitalização.
     * Tenta várias variações do nome do campo automaticamente.
     */
    function programasExtrairCampo(array $linha, string $chave, $padrao = null)
    {
        // Primeira tentativa: nome exato
        if (array_key_exists($chave, $linha)) {
            return $linha[$chave];
        }

        // Segunda tentativa: uppercase
        $alternativa = strtoupper($chave);
        if (array_key_exists($alternativa, $linha)) {
            return $linha[$alternativa];
        }
        
        // Terceira tentativa: lowercase
        $alternativa = strtolower($chave);
        if (array_key_exists($alternativa, $linha)) {
            return $linha[$alternativa];
        }
        
        // Quarta tentativa: primeira letra maiúscula
        $alternativa = ucfirst(strtolower($chave));
        if (array_key_exists($alternativa, $linha)) {
            return $linha[$alternativa];
        }
        
        // Para casos específicos conhecidos
        $mapeamentos = [
            'p1104_SistemaID' => ['P1104_sistemaid', 'p1104_sistemaid', 'P1104_SISTEMAID'],
            'p1104_sistemaid' => ['P1104_sistemaid', 'p1104_SistemaID', 'P1104_SISTEMAID'],
            'P1104_sistemaid' => ['p1104_SistemaID', 'p1104_sistemaid', 'P1104_SISTEMAID']
        ];
        
        if (isset($mapeamentos[$chave])) {
            foreach ($mapeamentos[$chave] as $tentativa) {
                if (array_key_exists($tentativa, $linha)) {
                    return $linha[$tentativa];
                }
            }
        }

        return $padrao;
    }
}

if (!function_exists('programasInterpretarRetornoProcedure')) {
    /**
     * Normaliza o retorno das procedures utilizadas nas operações de programas.
     *
     * @return array{0:int,1:string,2:array<string,mixed>}
     */
    function programasInterpretarRetornoProcedure(array $resultado): array
    {
        if (empty($resultado)) {
            return [0, '', []];
        }

        $linha = $resultado[0];
        $codigo = 0;

        foreach (['resulta', 'RESULTA', 'RETURN_VALUE', 'return_value'] as $campo) {
            if (isset($linha[$campo])) {
                $codigo = (int) $linha[$campo];
                break;
            }
        }

        $mensagem = '';
        foreach (['mensa', 'MENSA', 'mensagem', 'MENSAGEM'] as $campo) {
            if (!empty($linha[$campo])) {
                $mensagem = (string) $linha[$campo];
                break;
            }
        }

        return [$codigo, $mensagem, $linha];
    }
}

if (!function_exists('programasMontarDireitosFormulario')) {
    /**
     * Produz a estrutura de direitos exibida no formulário a partir dos grupos.
     *
     * @param array<int, array<string, mixed>> $grupos
     * @param array<int, array<string, mixed>> $direitosExistentes
     * @return array<int, array<string, mixed>>
     */
    function programasMontarDireitosFormulario(array $grupos, array $direitosExistentes = []): array
    {
        $mapa = [];

        foreach ($direitosExistentes as $linha) {
            $grupoId = (int) programasExtrairCampo($linha, 'p052_grupocd', 0);
            if ($grupoId <= 0) {
                continue;
            }

            $mapa[$grupoId] = [
                'direito'    => (int) programasExtrairCampo($linha, 'p1106_direito', 0),
                'direito_id' => (int) programasExtrairCampo($linha, 'p1106_direitosid', 0),
                'origem'     => (int) programasExtrairCampo($linha, 'p1106_direito', 0),
            ];
        }

        foreach ($grupos as $grupo) {
            $grupoId = (int) programasExtrairCampo($grupo, 'p052_GrupoCD', 0);
            if ($grupoId <= 0) {
                continue;
            }

            if (!isset($mapa[$grupoId])) {
                $mapa[$grupoId] = [
                    'direito'    => 0,
                    'direito_id' => 0,
                    'origem'     => 0,
                ];
            }

            $mapa[$grupoId]['nome'] = (string) programasExtrairCampo($grupo, 'p052_Grupo', '');
        }

        ksort($mapa);

        return $mapa;
    }
}

if (!function_exists('programasMontarDireitosDePost')) {
    /**
     * Reconstrói a estrutura de direitos usando os dados enviados via POST.
     *
     * @param array<int, array<string, mixed>> $grupos
     * @param array<int, string|int> $direitos
     * @param array<int, string|int> $direitosId
     * @param array<int, string|int> $direitosOrigem
     * @return array<int, array<string, mixed>>
     */
    function programasMontarDireitosDePost(
        array $grupos,
        array $direitos,
        array $direitosId,
        array $direitosOrigem
    ): array {
        $mapa = [];

        foreach ($grupos as $grupo) {
            $grupoId = (int) programasExtrairCampo($grupo, 'p052_GrupoCD', 0);
            if ($grupoId <= 0) {
                continue;
            }

            $mapa[$grupoId] = [
                'nome'       => (string) programasExtrairCampo($grupo, 'p052_Grupo', ''),
                'direito'    => isset($direitos[$grupoId]) ? (int) $direitos[$grupoId] : 0,
                'direito_id' => isset($direitosId[$grupoId]) ? (int) $direitosId[$grupoId] : 0,
                'origem'     => isset($direitosOrigem[$grupoId]) ? (int) $direitosOrigem[$grupoId] : 0,
            ];
        }

        ksort($mapa);

        return $mapa;
    }
}

$erros = [];
$mensagem = null;
$tipoMensagem = 'info';

// Carrega sistemas apenas uma vez na primeira entrada (armazena na sessão)
if (!isset($_SESSION['programas_sistemas']) || empty($_SESSION['programas_sistemas'])) {
    try {
        $_SESSION['programas_sistemas'] = listarSistemas();
    } catch (Throwable $throwable) {
        $erros[] = 'Falha ao carregar os sistemas: ' . $throwable->getMessage();
        $_SESSION['programas_sistemas'] = [];
    }
}
$sistemas = $_SESSION['programas_sistemas'];

try {
    $grupos = listarGrupos();
} catch (Throwable $throwable) {
    $erros[] = 'Falha ao carregar os grupos: ' . $throwable->getMessage();
    $grupos = [];
}

$statusFiltro = 'A';
$modoFormulario = null;
$programaForm = [
    'id'         => null,
    'nome'       => '',
    'codigo'     => '',
    'sistema_id' => 0,
    'status'     => 'A',
];
$direitosForm = [];

$acao = $_POST['acao'] ?? null;

// Valores padrão para primeira entrada
$selectedSistemaFiltro = 0;
$statusFiltro = 'A';

// Flag para detectar primeira entrada (quando não há valores na sessão)
$primeiraEntrada = !isset($_SESSION['programas_filtro_sistema']);

// Se há valores na sessão (não é primeira entrada), usa eles
if (!$primeiraEntrada) {
    $selectedSistemaFiltro = (int) $_SESSION['programas_filtro_sistema'];
    $statusFiltro = $_SESSION['programas_filtro_status'] ?? 'A';
}

// Processa valores vindos via POST/GET (formulário de filtro)
if (isset($_POST['filtro_sistema']) && $_POST['filtro_sistema'] !== '') {
    $selectedSistemaFiltro = (int) $_POST['filtro_sistema'];
    $_SESSION['programas_filtro_sistema'] = $selectedSistemaFiltro;
}

if (isset($_POST['filtro_status']) && $_POST['filtro_status'] !== '') {
    $statusFiltro = $_POST['filtro_status'];
    $_SESSION['programas_filtro_status'] = $statusFiltro;
}

if (isset($_GET['filtro_sistema']) && $_GET['filtro_sistema'] !== '') {
    $selectedSistemaFiltro = (int) $_GET['filtro_sistema'];
    $_SESSION['programas_filtro_sistema'] = $selectedSistemaFiltro;
}

if (isset($_GET['filtro_status']) && $_GET['filtro_status'] !== '') {
    $statusFiltro = $_GET['filtro_status'];
    $_SESSION['programas_filtro_status'] = $statusFiltro;
}

// Se ainda não tem sistema (primeira entrada ou valor inválido), usa o primeiro da lista
if ($selectedSistemaFiltro === 0 && !empty($sistemas)) {
    $selectedSistemaFiltro = (int) programasExtrairCampo($sistemas[0], 'P1104_sistemaid', 0);
    $_SESSION['programas_filtro_sistema'] = $selectedSistemaFiltro;
    $_SESSION['programas_filtro_status'] = $statusFiltro; // Garante que status também é salvo na primeira entrada
}

// Validação final: se ainda não tem sistema válido, algo está errado com os dados
if ($selectedSistemaFiltro === 0 && empty($sistemas)) {
    $erros[] = 'Nenhum sistema encontrado. Verifique a configuração do banco de dados.';
}

$programaForm['sistema_id'] = $selectedSistemaFiltro;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_programas'])
        && hash_equals((string) $_SESSION['csrf_programas'], (string) $_POST['csrf_token']);

    if (!$tokenValido) {
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    }

    if ($tokenValido) {
        switch ($acao) {
            case 'filtrar':
                // Apenas atualiza os filtros - o valor já foi processado acima
                // Não redefine o sistema aqui, mantém o que veio do POST
                break;

            case 'abrir_novo':
                // Modal será aberto via JavaScript
                break;

            case 'abrir_edicao':
                // Modal será aberto via JavaScript
                break;

            case 'carregar_direitos':
                // Retorna JSON com os direitos do programa
                header('Content-Type: application/json');
                $programaIdDireitos = isset($_POST['programa_id']) ? (int) $_POST['programa_id'] : 0;
                $direitosRetorno = [];
                
                if ($programaIdDireitos > 0) {
                    try {
                        $direitosExistentes = listarDireitosPrograma($programaIdDireitos);
                        
                        foreach ($direitosExistentes as $linha) {
                            // Tenta diferentes variações dos campos
                            $grupoId = (int) programasExtrairCampo($linha, 'p052_grupocd', 0);
                            if ($grupoId === 0) {
                                $grupoId = (int) programasExtrairCampo($linha, 'P052_GRUPOCD', 0);
                            }
                            if ($grupoId === 0) {
                                $grupoId = (int) programasExtrairCampo($linha, 'p052_GrupoCD', 0);
                            }
                            
                            if ($grupoId > 0) {
                                $direitoValor = (int) programasExtrairCampo($linha, 'p1106_direito', 0);
                                $direitoId = (int) programasExtrairCampo($linha, 'p1106_direitosid', 0);
                                
                                $direitosRetorno[$grupoId] = [
                                    'direito' => $direitoValor,
                                    'direito_id' => $direitoId,
                                    'origem' => $direitoValor,
                                ];
                            }
                        }
                    } catch (Throwable $throwable) {
                        echo json_encode(['success' => false, 'error' => $throwable->getMessage()]);
                        exit;
                    }
                }
                
                echo json_encode(['success' => true, 'direitos' => $direitosRetorno]);
                exit;
                break;

            case 'salvar_programa':
                $programaId = isset($_POST['programa_id']) ? (int) $_POST['programa_id'] : 0;
                $nome = trim((string) ($_POST['programa_nome'] ?? ''));
                $codigo = trim((string) ($_POST['programa_codigo'] ?? ''));
                $codigo = $codigo === '' ? null : $codigo;
                $sistemaDestino = isset($_POST['programa_sistema_id']) ? (int) $_POST['programa_sistema_id'] : 0;
                $statusPrograma = (string) ($_POST['programa_status'] ?? 'A');
                $senhaExecutor = trim((string) ($_POST['senha_executor'] ?? ''));
                $usuarioExecutor = (int) ($_SESSION['usuarioID'] ?? 0);

                $direitosPost = $_POST['direito'] ?? [];
                $direitosIdPost = $_POST['direito_id'] ?? [];
                $direitosOrigemPost = $_POST['direito_origem'] ?? [];

                $programaForm = [
                    'id'         => $programaId,
                    'nome'       => $nome,
                    'codigo'     => $codigo ?? '',
                    'sistema_id' => $sistemaDestino,
                    'status'     => $statusPrograma,
                ];
                $direitosForm = programasMontarDireitosDePost($grupos, $direitosPost, $direitosIdPost, $direitosOrigemPost);

                if ($nome === '') {
                    $erros[] = 'Informe o nome do programa.';
                }

                if ($sistemaDestino <= 0) {
                    $erros[] = 'Selecione o sistema ao qual o programa pertence.';
                }

                if (!in_array($statusPrograma, ['A', 'I'], true)) {
                    $erros[] = 'Selecione um status válido.';
                }

                if ($senhaExecutor === '') {
                    $erros[] = 'Informe a sua senha para confirmar a operação.';
                } elseif (!validarSenhaUsuario($usuarioExecutor, $senhaExecutor)) {
                    $erros[] = 'Senha informada não confere.';
                }

                $resultadoPrograma = [];

                if (empty($erros)) {
                    try {
                        if ($programaId > 0) {
                            $resultadoPrograma = atualizarPrograma(
                                $programaId,
                                $nome,
                                $codigo,
                                $sistemaDestino,
                                $statusPrograma,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        } else {
                            $resultadoPrograma = inserirPrograma(
                                $nome,
                                $codigo,
                                $sistemaDestino,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        }
                    } catch (Throwable $throwable) {
                        $erros[] = 'Falha ao salvar o programa: ' . $throwable->getMessage();
                    }
                }

                if (empty($erros)) {
                    [$codigoRetorno, $mensagemRetorno, $linhaRetorno] = programasInterpretarRetornoProcedure($resultadoPrograma);

                    if ($codigoRetorno !== 0) {
                        $erros[] = $mensagemRetorno !== '' ? $mensagemRetorno : 'A operação não pôde ser concluída.';
                    } else {
                        if ($programaId === 0) {
                            $programaId = (int) programasExtrairCampo($linhaRetorno, 'p1103_programaid', 0);
                            if ($programaId <= 0) {
                                $erros[] = 'Programa incluído, porém o identificador retornado é inválido.';
                            }
                        }
                    }
                }

                if (empty($erros) && $programaId > 0) {
                    foreach ($direitosForm as $grupoId => $valores) {
                        $direitoSelecionado = (int) ($direitosPost[$grupoId] ?? 0);
                        $direitoId = (int) ($direitosIdPost[$grupoId] ?? 0);

                        try {
                            if ($direitoId > 0) {
                                atualizarDireitoGrupo(
                                    $direitoId,
                                    $grupoId,
                                    $programaId,
                                    $direitoSelecionado,
                                    $usuarioExecutor,
                                    $senhaExecutor
                                );
                            } else {
                                inserirDireitoGrupo(
                                    $grupoId,
                                    $programaId,
                                    $direitoSelecionado,
                                    $usuarioExecutor,
                                    $senhaExecutor
                                );
                            }
                        } catch (Throwable $throwable) {
                            $erros[] = 'Falha ao gravar direitos do grupo ' . $valores['nome'] . ': ' . $throwable->getMessage();
                            break;
                        }
                    }
                }

                if (empty($erros)) {
                    $mensagem = $programaId > 0 ? 'Programa atualizado com sucesso.' : 'Programa criado com sucesso.';
                    $tipoMensagem = 'success';
                }
                break;

            default:
                // Ação desconhecida, ignora.
                break;
        }
    }
}

$programas = [];

// SEMPRE faz a consulta de programas se houver um sistema válido selecionado
if ($selectedSistemaFiltro > 0) {
    try {
        $programas = listarProgramas($selectedSistemaFiltro, $statusFiltro);
    } catch (Throwable $throwable) {
        $erros[] = 'Não foi possível listar os programas: ' . $throwable->getMessage();
        $programas = [];
    }
}

if ($modoFormulario !== null && empty($direitosForm)) {
    $direitosForm = programasMontarDireitosFormulario($grupos);
}

$csrfToken = (function () {
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes(16));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
    return bin2hex(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 16));
})();
$_SESSION['csrf_programas'] = $csrfToken;

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <?php if (!empty($mensagem)) : ?>
                    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($erros)) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($erros as $erro) : ?>
                                <li><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                    <form method="post" id="formFiltro" class="form-inline mb-3">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="acao" value="filtrar">
                        <label class="mr-2" for="filtroSistema">Sistema</label>
                        <select class="form-control mr-3" id="filtroSistema" name="filtro_sistema" required>
                            <?php 
                            foreach ($sistemas as $index => $sistema) :
                                $sistemaId = (int) programasExtrairCampo($sistema, 'P1104_sistemaid', 0);
                                $sistemaNome = (string) programasExtrairCampo($sistema, 'p1104_Sistema', '');
                                // Comparação simples - se o ID do sistema corresponde ao selecionado
                                $isSelected = ($sistemaId == $selectedSistemaFiltro);
                                ?>
                                <option value="<?php echo htmlspecialchars((string) $sistemaId, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $isSelected ? 'selected="selected"' : ''; ?>>
                                    <?php echo htmlspecialchars($sistemaNome, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label class="mr-2" for="filtroStatus">Status</label>
                        <select class="form-control mr-3" id="filtroStatus" name="filtro_status">
                            <option value="A" <?php echo $statusFiltro === 'A' ? 'selected' : ''; ?>>Ativo</option>
                            <option value="I" <?php echo $statusFiltro === 'I' ? 'selected' : ''; ?>>Inativo</option>
                        </select>

                        <button type="submit" class="btn btn-primary" title="Consultar">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Programa</th>
                                    <th>Código</th>
                                    <th>Sistema</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($programas)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum programa encontrado.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($programas as $programa) :
                                        $programaId = (int) programasExtrairCampo($programa, 'p1103_ProgramaID', 0);
                                        $programaNome = (string) programasExtrairCampo($programa, 'p1103_Programa', '');
                                        $programaCodigo = (string) programasExtrairCampo($programa, 'p1103_Programacd', '');
                                        $sistemaIdPrograma = (int) programasExtrairCampo($programa, 'P1104_sistemaid', $selectedSistemaFiltro);
                                        $sistemaNome = (string) programasExtrairCampo($programa, 'p1104_Sistema', '');
                                        // Tenta diferentes variações do nome do campo de status
                                        $statusRaw = (string) programasExtrairCampo($programa, 'p1103_ativo', '');
                                        if ($statusRaw === '') {
                                            $statusRaw = (string) programasExtrairCampo($programa, 'p1103_Ativo', '');
                                        }
                                        if ($statusRaw === '') {
                                            $statusRaw = (string) programasExtrairCampo($programa, 'P1103_ATIVO', '');
                                        }
                                        if ($statusRaw === '') {
                                            $statusRaw = (string) programasExtrairCampo($programa, 'Status', '');
                                        }
                                        
                                        // Debug temporário: mostra o valor bruto e todos os campos disponíveis
                                        if (empty($statusRaw)) {
                                            echo "<!-- Debug Status: Campo não encontrado. Campos disponíveis: " . json_encode(array_keys($programa)) . " -->";
                                        }
                                        
                                        // Normaliza o status: se vier como texto, converte para código
                                        $statusRawUpper = strtoupper(trim($statusRaw));
                                        if ($statusRawUpper === 'ATIVO' || $statusRawUpper === 'A') {
                                            $status = 'A';
                                            $statusLabel = 'Ativo';
                                        } elseif ($statusRawUpper === 'INATIVO' || $statusRawUpper === 'I') {
                                            $status = 'I';
                                            $statusLabel = 'Inativo';
                                        } else {
                                            // Se não encontrou ou valor inválido, usa padrão 'A'
                                            $status = 'A';
                                            $statusLabel = 'Ativo';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($programaNome, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($programaCodigo, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($sistemaNome, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo strtoupper($status) === 'A' ? 'success' : 'secondary'; ?>">
                                                    <?php echo htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="abrirModalEdicaoPrograma(<?php echo htmlspecialchars((string) $programaId, ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars(addslashes($programaNome), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes($programaCodigo), ENT_QUOTES, 'UTF-8'); ?>', <?php echo htmlspecialchars((string) $sistemaIdPrograma, ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars(strtoupper($status) === 'A' ? 'A' : 'I', ENT_QUOTES, 'UTF-8'); ?>')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary" onclick="abrirModalInclusaoPrograma()">
                                <i class="fas fa-plus"></i> Incluir um Programa
                            </button>
                        </div>
                    </div>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para Edição/Inclusão de Programa -->
<div class="modal fade" id="modalPrograma" tabindex="-1" role="dialog" aria-labelledby="modalProgramaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProgramaLabel">Novo Programa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#e8eff9;">
                <form method="post" id="formPrograma" name="formPrograma">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="salvar_programa">
                    <input type="hidden" name="programa_id" id="modal_programa_id" value="0">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modal_programa_nome" class="form-label">Programa</label>
                                <input type="text" class="form-control form-control-sm" id="modal_programa_nome" name="programa_nome" maxlength="50" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modal_programa_codigo" class="form-label">Código</label>
                                <input type="text" class="form-control form-control-sm" id="modal_programa_codigo" name="programa_codigo" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modal_programa_sistema_id" class="form-label">Sistema</label>
                                <select class="form-control form-control-sm" id="modal_programa_sistema_id" name="programa_sistema_id" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($sistemas as $sistema) :
                                        $sistemaId = (int) programasExtrairCampo($sistema, 'P1104_sistemaid', 0);
                                        $sistemaNome = (string) programasExtrairCampo($sistema, 'p1104_Sistema', '');
                                        ?>
                                        <option value="<?php echo htmlspecialchars((string) $sistemaId, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($sistemaNome, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="div_status_programa" style="display:none;">
                            <div class="form-group">
                                <label for="modal_programa_status" class="form-label">Status</label>
                                <select class="form-control form-control-sm" id="modal_programa_status" onchange="document.getElementById('modal_programa_status_hidden').value = this.value;" required>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Campo status sempre presente para envio, mesmo quando oculto -->
                    <input type="hidden" id="modal_programa_status_hidden" name="programa_status" value="A">

                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Grupo</th>
                                    <th class="text-center">Atualização</th>
                                    <th class="text-center">Consulta</th>
                                    <th class="text-center">Sem direitos</th>
                                </tr>
                            </thead>
                            <tbody id="modal_direitos_tbody">
                                <?php if (empty($grupos)) : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhum grupo cadastrado.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($grupos as $grupo) :
                                        $grupoId = (int) programasExtrairCampo($grupo, 'p052_GrupoCD', 0);
                                        $nomeGrupo = (string) programasExtrairCampo($grupo, 'p052_Grupo', '');
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($nomeGrupo, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?php echo $grupoId; ?>]" value="1" checked>
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?php echo $grupoId; ?>]" value="2">
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?php echo $grupoId; ?>]" value="0">
                                                <input type="hidden" name="direito_id[<?php echo $grupoId; ?>]" value="0">
                                                <input type="hidden" name="direito_origem[<?php echo $grupoId; ?>]" value="0">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="modal_senha_executor_programa" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-sm" id="modal_senha_executor_programa" name="senha_executor" maxlength="20" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="formPrograma">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
var gruposData = <?php echo json_encode($grupos); ?>;
var direitosPrograma = {};

function abrirModalInclusaoPrograma() {
    document.getElementById('modalProgramaLabel').textContent = 'Incluir Programa';
    document.getElementById('modal_programa_id').value = '0';
    document.getElementById('modal_programa_nome').value = '';
    document.getElementById('modal_programa_codigo').value = '';
    // Mantém o sistema atualmente selecionado no filtro
    var sistemaAtualFiltro = document.getElementById('filtroSistema').value;
    document.getElementById('modal_programa_sistema_id').value = sistemaAtualFiltro;
    document.getElementById('modal_programa_status').value = 'A';
    document.getElementById('modal_programa_status_hidden').value = 'A';
    document.getElementById('modal_senha_executor_programa').value = '';
    document.getElementById('div_status_programa').style.display = 'none';
    
    // Limpa direitos
    direitosPrograma = {};
    atualizarTabelaDireitos();
    
    $('#modalPrograma').modal('show');
    setTimeout(function() {
        document.getElementById('modal_programa_nome').focus();
    }, 500);
}

function abrirModalEdicaoPrograma(id, nome, codigo, sistemaId, status) {
    document.getElementById('modalProgramaLabel').textContent = 'Alterar Programa';
    document.getElementById('modal_programa_id').value = id;
    document.getElementById('modal_programa_nome').value = nome;
    document.getElementById('modal_programa_codigo').value = codigo;
    document.getElementById('modal_programa_sistema_id').value = sistemaId;
    document.getElementById('modal_programa_status').value = status;
    document.getElementById('modal_programa_status_hidden').value = status;
    document.getElementById('modal_senha_executor_programa').value = '';
    document.getElementById('div_status_programa').style.display = 'block';
    
    // Carrega direitos do programa
    carregarDireitosPrograma(id);
    
    $('#modalPrograma').modal('show');
    setTimeout(function() {
        document.getElementById('modal_programa_nome').focus();
    }, 500);
}

function carregarDireitosPrograma(programaId) {
    // Carrega direitos via AJAX
    var formData = new FormData();
    formData.append('acao', 'carregar_direitos');
    formData.append('programa_id', programaId);
    formData.append('csrf_token', '<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>');
    
    fetch('Programas.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.success) {
            direitosPrograma = data.direitos || {};
            atualizarTabelaDireitos();
        } else {
            direitosPrograma = {};
            atualizarTabelaDireitos();
        }
    })
    .catch(error => {
        console.error('Erro ao carregar direitos:', error);
        direitosPrograma = {};
        atualizarTabelaDireitos();
    });
}

function atualizarTabelaDireitos() {
    var tbody = document.getElementById('modal_direitos_tbody');
    tbody.innerHTML = '';
    
    if (gruposData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum grupo cadastrado.</td></tr>';
        return;
    }
    
    gruposData.forEach(function(grupo) {
        var grupoId = grupo.p052_GrupoCD || grupo.P052_GRUPOCD || 0;
        var nomeGrupo = grupo.p052_Grupo || grupo.P052_GRUPO || '';
        var direito = direitosPrograma[grupoId] || {};
        var direitoAtual = direito.direito || 0;
        var direitoId = direito.direito_id || 0;
        var direitoOrigem = direito.origem || direitoAtual;
        
        var tr = document.createElement('tr');
        tr.innerHTML = 
            '<td>' + nomeGrupo + '</td>' +
            '<td class="text-center"><input type="radio" name="direito[' + grupoId + ']" value="1" ' + (direitoAtual === 1 ? 'checked' : '') + '></td>' +
            '<td class="text-center"><input type="radio" name="direito[' + grupoId + ']" value="2" ' + (direitoAtual === 2 ? 'checked' : '') + '></td>' +
            '<td class="text-center">' +
                '<input type="radio" name="direito[' + grupoId + ']" value="0" ' + (direitoAtual === 0 ? 'checked' : '') + '>' +
                '<input type="hidden" name="direito_id[' + grupoId + ']" value="' + direitoId + '">' +
                '<input type="hidden" name="direito_origem[' + grupoId + ']" value="' + direitoOrigem + '">' +
            '</td>';
        tbody.appendChild(tr);
    });
}

// Limpar formulário ao fechar o modal
$('#modalPrograma').on('hidden.bs.modal', function () {
    document.getElementById('formPrograma').reset();
    document.getElementById('modal_programa_id').value = '0';
    direitosPrograma = {};
});
</script>

