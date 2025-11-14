<?php
require_once __DIR__ . '/../functionsUsuario.php';

if (!function_exists('areasExtrairCampo')) {
    function areasExtrairCampo(array $linha, string $chave, $padrao = null)
    {
        if (array_key_exists($chave, $linha)) {
            return $linha[$chave];
        }

        $alternativa = strtoupper($chave);
        if (array_key_exists($alternativa, $linha)) {
            return $linha[$alternativa];
        }

        return $padrao;
    }
}

if (!function_exists('areasInterpretarRetorno')) {
    /**
     * @return array{0:int,1:string,2:array<string,mixed>}
     */
    function areasInterpretarRetorno(array $resultado): array
    {
        if (empty($resultado)) {
            return [0, '', []];
        }

        $linha = $resultado[0];
        $codigo = 0;

        foreach (['resulta', 'RESULTA', 'return_value', 'RETURN_VALUE'] as $campo) {
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

$erros = [];
$mensagem = null;
$tipoMensagem = 'info';

$statusFiltro = 'A';
$ordemFiltro = 0;
$modoFormulario = null;
$areaForm = [
    'id'           => null,
    'nome'         => '',
    'sigla'        => '',
    'status'       => 'A',
    'data_usuario' => null,
];

$acao = $_POST['acao'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_area'])
        && hash_equals((string) $_SESSION['csrf_area'], (string) $_POST['csrf_token']);

    if (!$tokenValido) {
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    }

    $statusFiltro = $_POST['filtro_status'] ?? $statusFiltro;
    $ordemFiltro = isset($_POST['filtro_ordem']) ? (int) $_POST['filtro_ordem'] : $ordemFiltro;

    if ($tokenValido) {
        switch ($acao) {
            case 'filtrar':
                break;

            case 'abrir_novo':
                // Modal será aberto via JavaScript
                break;

            case 'abrir_edicao':
                // Modal será aberto via JavaScript
                break;

            case 'salvar_area':
                $areaId = isset($_POST['area_id']) ? (int) $_POST['area_id'] : 0;
                $nome = trim((string) ($_POST['area_nome'] ?? ''));
                $sigla = trim((string) ($_POST['area_sigla'] ?? ''));
                $statusArea = (string) ($_POST['area_status'] ?? 'A');
                $senhaExecutor = trim((string) ($_POST['senha_executor'] ?? ''));
                $usuarioExecutor = (int) ($_SESSION['usuarioID'] ?? 0);
                $dataUsuario = $_POST['area_data_usuario'] ?? null;

                $areaForm = [
                    'id'           => $areaId,
                    'nome'         => $nome,
                    'sigla'        => $sigla,
                    'status'       => $statusArea,
                    'data_usuario' => $dataUsuario,
                ];

                if ($nome === '') {
                    $erros[] = 'Informe o nome da área.';
                }

                if ($sigla === '') {
                    $erros[] = 'Informe a sigla da área.';
                }

                if (!in_array($statusArea, ['A', 'I'], true)) {
                    $erros[] = 'Selecione um status válido.';
                }

                if ($senhaExecutor === '') {
                    $erros[] = 'Informe a sua senha para confirmar a operação.';
                } elseif (!validarSenhaUsuario($usuarioExecutor, $senhaExecutor)) {
                    $erros[] = 'Senha informada não confere.';
                }

                if (empty($erros)) {
                    try {
                        if ($areaId > 0) {
                            $resultado = atualizarArea(
                                $areaId,
                                $nome,
                                $sigla,
                                $statusArea,
                                $dataUsuario,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        } else {
                            $resultado = inserirArea(
                                $nome,
                                $sigla,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        }
                    } catch (Throwable $throwable) {
                        $erros[] = 'Falha ao salvar a área: ' . $throwable->getMessage();
                        $resultado = [];
                    }

                    if (empty($erros)) {
                        [$codigoRetorno, $mensagemRetorno, $linhaRetorno] = areasInterpretarRetorno($resultado);

                        if ($codigoRetorno !== 0) {
                            $erros[] = $mensagemRetorno !== '' ? $mensagemRetorno : 'A operação não pôde ser concluída.';
                        } else {
                            $novaData = areasExtrairCampo($linhaRetorno, 'NovaData');
                            if ($novaData !== null && $areaId > 0) {
                                $areaForm['data_usuario'] = $novaData;
                            }
                        }
                    }
                }

                if (empty($erros)) {
                    $mensagem = $areaId > 0 ? 'Área atualizada com sucesso.' : 'Área criada com sucesso.';
                    $tipoMensagem = 'success';
                }
                break;

            default:
                break;
        }
    }
} else {
    $statusFiltro = $_GET['filtro_status'] ?? $statusFiltro;
    $ordemFiltro = isset($_GET['filtro_ordem']) ? (int) $_GET['filtro_ordem'] : $ordemFiltro;
}

$areas = [];
try {
    $areas = listarAreasGerenciais($statusFiltro, $ordemFiltro);
} catch (Throwable $throwable) {
    $erros[] = 'Não foi possível listar as áreas: ' . $throwable->getMessage();
    $areas = [];
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
$_SESSION['csrf_area'] = $csrfToken;

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

                <form method="post" class="form-inline mb-3">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="filtrar">

                    <label class="mr-2" for="filtroStatus">Status</label>
                    <select class="form-control mr-3" id="filtroStatus" name="filtro_status" onchange="this.form.submit()">
                        <option value="A" <?php echo $statusFiltro === 'A' ? 'selected' : ''; ?>>Ativo</option>
                        <option value="I" <?php echo $statusFiltro === 'I' ? 'selected' : ''; ?>>Inativo</option>
                    </select>

                    <label class="mr-2" for="filtroOrdem">Ordenação</label>
                    <select class="form-control" id="filtroOrdem" name="filtro_ordem" onchange="this.form.submit()">
                        <option value="0" <?php echo $ordemFiltro === 0 ? 'selected' : ''; ?>>Nome</option>
                        <option value="1" <?php echo $ordemFiltro === 1 ? 'selected' : ''; ?>>Código</option>
                        <option value="2" <?php echo $ordemFiltro === 2 ? 'selected' : ''; ?>>Sigla</option>
                    </select>
                </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Área</th>
                                    <th>Sigla</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($areas)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhuma área encontrada.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($areas as $area) :
                                        $areaId = (int) areasExtrairCampo($area, 'p052_AreaID', 0);
                                        $nome = (string) areasExtrairCampo($area, 'p052_area', '');
                                        $sigla = (string) areasExtrairCampo($area, 'p052_area_sigla', '');
                                        $status = (string) areasExtrairCampo($area, 'Status', '');
                                        $statusInterno = strtoupper((string) areasExtrairCampo($area, 'p052_status', 'A'));
                                        $dataUsuario = (string) areasExtrairCampo($area, 'DataUsuario', '');
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string) $areaId, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($sigla, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $statusInterno === 'A' ? 'success' : 'secondary'; ?>">
                                                    <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="abrirModalEdicao(<?php echo htmlspecialchars((string) $areaId, ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars(addslashes($nome), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes($sigla), ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($statusInterno, ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes($dataUsuario), ENT_QUOTES, 'UTF-8'); ?>')">
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
                            <button type="button" class="btn btn-primary" onclick="abrirModalInclusao()">
                                <i class="fas fa-plus"></i> Incluir uma Área
                            </button>
                        </div>
                    </div>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para Edição/Inclusão de Área -->
<div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-labelledby="modalAreaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAreaLabel">Nova Área</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#e8eff9;">
                <form method="post" id="formArea" name="formArea">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="salvar_area">
                    <input type="hidden" name="area_id" id="modal_area_id" value="0">
                    <input type="hidden" name="area_data_usuario" id="modal_area_data_usuario" value="">
                    <input type="hidden" name="filtro_status" value="<?php echo htmlspecialchars($statusFiltro, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="filtro_ordem" value="<?php echo htmlspecialchars((string) $ordemFiltro, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="modal_area_nome" class="form-label">Área</label>
                                <input type="text" class="form-control form-control-sm" id="modal_area_nome" name="area_nome" maxlength="50" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_area_sigla" class="form-label">Sigla</label>
                                <input type="text" class="form-control form-control-sm" id="modal_area_sigla" name="area_sigla" maxlength="3" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="div_status" style="display:none;">
                            <div class="form-group">
                                <label for="modal_area_status" class="form-label">Status</label>
                                <select class="form-control form-control-sm" id="modal_area_status" onchange="document.getElementById('modal_area_status_hidden').value = this.value;" required>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_senha_executor" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-sm" id="modal_senha_executor" name="senha_executor" maxlength="20" required>
                            </div>
                        </div>
                    </div>
                    <!-- Campo status sempre presente para envio, mesmo quando oculto -->
                    <input type="hidden" id="modal_area_status_hidden" name="area_status" value="A">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="formArea">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
function abrirModalInclusao() {
    document.getElementById('modalAreaLabel').textContent = 'Incluir Área';
    document.getElementById('modal_area_id').value = '0';
    document.getElementById('modal_area_nome').value = '';
    document.getElementById('modal_area_sigla').value = '';
    document.getElementById('modal_area_status').value = 'A';
    document.getElementById('modal_area_status_hidden').value = 'A';
    document.getElementById('modal_senha_executor').value = '';
    document.getElementById('modal_area_data_usuario').value = '';
    document.getElementById('div_status').style.display = 'none';
    $('#modalArea').modal('show');
    setTimeout(function() {
        document.getElementById('modal_area_nome').focus();
    }, 500);
}

function abrirModalEdicao(id, nome, sigla, status, dataUsuario) {
    document.getElementById('modalAreaLabel').textContent = 'Alterar Área';
    document.getElementById('modal_area_id').value = id;
    document.getElementById('modal_area_nome').value = nome;
    document.getElementById('modal_area_sigla').value = sigla;
    document.getElementById('modal_area_status').value = status;
    document.getElementById('modal_area_status_hidden').value = status;
    document.getElementById('modal_senha_executor').value = '';
    document.getElementById('modal_area_data_usuario').value = dataUsuario || '';
    document.getElementById('div_status').style.display = 'block';
    $('#modalArea').modal('show');
    setTimeout(function() {
        document.getElementById('modal_area_nome').focus();
    }, 500);
}

// Limpar formulário ao fechar o modal
$('#modalArea').on('hidden.bs.modal', function () {
    document.getElementById('formArea').reset();
    document.getElementById('modal_area_id').value = '0';
});
</script>

