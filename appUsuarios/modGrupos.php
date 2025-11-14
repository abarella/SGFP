<?php
require_once __DIR__ . '/../functionsUsuario.php';

if (!function_exists('gruposExtrairCampo')) {
    function gruposExtrairCampo(array $linha, string $chave, $padrao = null)
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

if (!function_exists('gruposInterpretarRetorno')) {
    /**
     * @return array{0:int,1:string,2:array<string,mixed>}
     */
    function gruposInterpretarRetorno(array $resultado): array
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
            if (isset($linha[$campo]) && $linha[$campo] !== '') {
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

try {
    $areas = listarAreasCadastroGrupo();
} catch (Throwable $throwable) {
    $erros[] = 'Não foi possível carregar as áreas: ' . $throwable->getMessage();
    $areas = [];
}

try {
    $menus = listarMenusGrupo();
} catch (Throwable $throwable) {
    $erros[] = 'Não foi possível carregar os menus: ' . $throwable->getMessage();
    $menus = [];
}

$statusFiltro = 'A';
$ordemFiltro = 0;
$modoFormulario = null;
$grupoForm = [
    'id'          => null,
    'nome'        => '',
    'area_id'     => 0,
    'menu_id'     => 0,
    'status'      => 'A',
    'data_usuario'=> null,
];

$acao = $_POST['acao'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_grupos'])
        && hash_equals((string) $_SESSION['csrf_grupos'], (string) $_POST['csrf_token']);

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

            case 'salvar_grupo':
                $grupoId = isset($_POST['grupo_id']) ? (int) $_POST['grupo_id'] : 0;
                $nome = trim((string) ($_POST['grupo_nome'] ?? ''));
                $areaId = isset($_POST['grupo_area_id']) ? (int) $_POST['grupo_area_id'] : 0;
                $menuId = isset($_POST['grupo_menu_id']) ? (int) $_POST['grupo_menu_id'] : 0;
                $statusGrupo = (string) ($_POST['grupo_status'] ?? 'A');
                $senhaExecutor = trim((string) ($_POST['senha_executor'] ?? ''));
                $usuarioExecutor = (int) ($_SESSION['usuarioID'] ?? 0);
                $dataUsuario = $_POST['grupo_data_usuario'] ?? null;

                $grupoForm = [
                    'id'          => $grupoId,
                    'nome'        => $nome,
                    'area_id'     => $areaId,
                    'menu_id'     => $menuId,
                    'status'      => $statusGrupo,
                    'data_usuario'=> $dataUsuario,
                ];

                if ($nome === '') {
                    $erros[] = 'Informe o nome do grupo.';
                }

                if ($areaId <= 0) {
                    $erros[] = 'Selecione a área responsável.';
                }

                if ($menuId <= 0) {
                    $erros[] = 'Selecione o menu principal.';
                }

                if (!in_array($statusGrupo, ['A', 'I'], true)) {
                    $erros[] = 'Selecione um status válido.';
                }

                if ($senhaExecutor === '') {
                    $erros[] = 'Informe a sua senha para confirmar a operação.';
                } elseif (!validarSenhaUsuario($usuarioExecutor, $senhaExecutor)) {
                    $erros[] = 'Senha informada não confere.';
                }

                if (empty($erros)) {
                    try {
                        if ($grupoId > 0) {
                            $resultado = atualizarGrupo(
                                $grupoId,
                                $nome,
                                $areaId,
                                $menuId,
                                $statusGrupo,
                                $dataUsuario,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        } else {
                            $resultado = inserirGrupo(
                                $nome,
                                $areaId,
                                $menuId,
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        }
                    } catch (Throwable $throwable) {
                        $erros[] = 'Falha ao salvar o grupo: ' . $throwable->getMessage();
                        $resultado = [];
                    }

                    if (empty($erros)) {
                        [$codigoRetorno, $mensagemRetorno, $linhaRetorno] = gruposInterpretarRetorno($resultado);

                        if ($codigoRetorno !== 0) {
                            $erros[] = $mensagemRetorno !== '' ? $mensagemRetorno : 'A operação não pôde ser concluída.';
                        } else {
                            $novadata = gruposExtrairCampo($linhaRetorno, 'NovaData');
                            if ($novadata !== null && $grupoId > 0) {
                                $grupoForm['data_usuario'] = $novadata;
                            }
                        }
                    }
                }

                if (empty($erros)) {
                    $mensagem = $grupoId > 0 ? 'Grupo atualizado com sucesso.' : 'Grupo criado com sucesso.';
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

$grupos = [];
try {
    $grupos = listarGrupos($statusFiltro, $ordemFiltro);
} catch (Throwable $throwable) {
    $erros[] = 'Não foi possível listar os grupos: ' . $throwable->getMessage();
    $grupos = [];
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
$_SESSION['csrf_grupos'] = $csrfToken;

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
                            <option value="2" <?php echo $ordemFiltro === 2 ? 'selected' : ''; ?>>Menu</option>
                            <option value="3" <?php echo $ordemFiltro === 3 ? 'selected' : ''; ?>>Área</option>
                        </select>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Grupo</th>
                                    <th>Área</th>
                                    <th>Menu</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($grupos)) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum grupo encontrado.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($grupos as $grupo) :
                                        $grupoId = (int) gruposExtrairCampo($grupo, 'p052_GrupoCD', 0);
                                        $nome = (string) gruposExtrairCampo($grupo, 'p052_Grupo', '');
                                        $area = (string) gruposExtrairCampo($grupo, 'Area', '');
                                        $menu = (string) gruposExtrairCampo($grupo, 'Menu', '');
                                        $statusGrupo = (string) gruposExtrairCampo($grupo, 'Status', 'Ativo');
                                        $areaId = (int) gruposExtrairCampo($grupo, 'p052_AreaID', 0);
                                        $menuId = (int) gruposExtrairCampo($grupo, 'p052_menuid', 0);
                                        $statusInterno = strtoupper((string) gruposExtrairCampo($grupo, 'p052_status', 'A'));
                                        $dataUsuario = (string) gruposExtrairCampo($grupo, 'DataUsuario', '');
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string) $grupoId, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($area, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($menu, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $statusInterno === 'A' ? 'success' : 'secondary'; ?>">
                                                    <?php echo htmlspecialchars($statusGrupo, ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="abrirModalEdicaoGrupo(<?php echo htmlspecialchars((string) $grupoId, ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars(addslashes($nome), ENT_QUOTES, 'UTF-8'); ?>', <?php echo htmlspecialchars((string) $areaId, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars((string) $menuId, ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars($statusInterno, ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars(addslashes($dataUsuario), ENT_QUOTES, 'UTF-8'); ?>')">
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
                            <button type="button" class="btn btn-primary" onclick="abrirModalInclusaoGrupo()">
                                <i class="fas fa-plus"></i> Incluir um Grupo
                            </button>
                        </div>
                    </div>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para Edição/Inclusão de Grupo -->
<div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="modalGrupoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGrupoLabel">Novo Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#e8eff9;">
                <form method="post" id="formGrupo" name="formGrupo">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="salvar_grupo">
                    <input type="hidden" name="grupo_id" id="modal_grupo_id" value="0">
                    <input type="hidden" name="grupo_data_usuario" id="modal_grupo_data_usuario" value="">
                    <input type="hidden" name="filtro_status" value="<?php echo htmlspecialchars($statusFiltro, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="filtro_ordem" value="<?php echo htmlspecialchars((string) $ordemFiltro, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="modal_grupo_nome" class="form-label">Grupo</label>
                                <input type="text" class="form-control form-control-sm" id="modal_grupo_nome" name="grupo_nome" maxlength="50" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_grupo_area_id" class="form-label">Área</label>
                                <select class="form-control form-control-sm" id="modal_grupo_area_id" name="grupo_area_id" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($areas as $area) :
                                        $areaId = (int) gruposExtrairCampo($area, 'p052_AreaID', 0);
                                        $areaNome = (string) gruposExtrairCampo($area, 'p052_area', '');
                                        ?>
                                        <option value="<?php echo htmlspecialchars((string) $areaId, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($areaNome, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_grupo_menu_id" class="form-label">Menu Principal</label>
                                <select class="form-control form-control-sm" id="modal_grupo_menu_id" name="grupo_menu_id" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($menus as $menu) :
                                        $menuId = (int) gruposExtrairCampo($menu, 'p1102_menuid', 0);
                                        $menuNome = (string) gruposExtrairCampo($menu, 'p1102_menu', '');
                                        ?>
                                        <option value="<?php echo htmlspecialchars((string) $menuId, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($menuNome, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="div_status_grupo" style="display:none;">
                            <div class="form-group">
                                <label for="modal_grupo_status" class="form-label">Status</label>
                                <select class="form-control form-control-sm" id="modal_grupo_status" onchange="document.getElementById('modal_grupo_status_hidden').value = this.value;" required>
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_senha_executor_grupo" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-sm" id="modal_senha_executor_grupo" name="senha_executor" maxlength="20" required>
                            </div>
                        </div>
                    </div>
                    <!-- Campo status sempre presente para envio, mesmo quando oculto -->
                    <input type="hidden" id="modal_grupo_status_hidden" name="grupo_status" value="A">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="formGrupo">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
function abrirModalInclusaoGrupo() {
    document.getElementById('modalGrupoLabel').textContent = 'Incluir Grupo';
    document.getElementById('modal_grupo_id').value = '0';
    document.getElementById('modal_grupo_nome').value = '';
    document.getElementById('modal_grupo_area_id').value = '';
    document.getElementById('modal_grupo_menu_id').value = '';
    document.getElementById('modal_grupo_status').value = 'A';
    document.getElementById('modal_grupo_status_hidden').value = 'A';
    document.getElementById('modal_senha_executor_grupo').value = '';
    document.getElementById('modal_grupo_data_usuario').value = '';
    document.getElementById('div_status_grupo').style.display = 'none';
    $('#modalGrupo').modal('show');
    setTimeout(function() {
        document.getElementById('modal_grupo_nome').focus();
    }, 500);
}

function abrirModalEdicaoGrupo(id, nome, areaId, menuId, status, dataUsuario) {
    document.getElementById('modalGrupoLabel').textContent = 'Alterar Grupo';
    document.getElementById('modal_grupo_id').value = id;
    document.getElementById('modal_grupo_nome').value = nome;
    document.getElementById('modal_grupo_area_id').value = areaId;
    document.getElementById('modal_grupo_menu_id').value = menuId;
    document.getElementById('modal_grupo_status').value = status;
    document.getElementById('modal_grupo_status_hidden').value = status;
    document.getElementById('modal_senha_executor_grupo').value = '';
    document.getElementById('modal_grupo_data_usuario').value = dataUsuario || '';
    document.getElementById('div_status_grupo').style.display = 'block';
    $('#modalGrupo').modal('show');
    setTimeout(function() {
        document.getElementById('modal_grupo_nome').focus();
    }, 500);
}

// Limpar formulário ao fechar o modal
$('#modalGrupo').on('hidden.bs.modal', function () {
    document.getElementById('formGrupo').reset();
    document.getElementById('modal_grupo_id').value = '0';
});
</script>

