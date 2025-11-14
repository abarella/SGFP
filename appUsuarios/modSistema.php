<?php
require_once __DIR__ . '/../functionsUsuario.php';

$erros = [];
$mensagem = null;
$tipoMensagem = 'info';

// Inicializa filtros da sessão ou valores padrão
if (!isset($_SESSION['filtros_sistema'])) {
    $_SESSION['filtros_sistema'] = [
        'status' => 'A'
    ];
}

$statusFiltro = $_SESSION['filtros_sistema']['status'];
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// Processa filtros
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_POST['filtro_status'])) {
        $statusFiltro = $_POST['filtro_status'];
        $_SESSION['filtros_sistema']['status'] = $statusFiltro;
    } elseif (isset($_GET['filtro_status'])) {
        $statusFiltro = $_GET['filtro_status'];
        $_SESSION['filtros_sistema']['status'] = $statusFiltro;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_sistema'])
        && hash_equals((string) $_SESSION['csrf_sistema'], (string) $_POST['csrf_token']);

    if (!$tokenValido) {
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    }

    if ($tokenValido) {
        switch ($acao) {
            case 'filtrar':
                // Filtros já foram processados acima
                break;

            case 'criar':
            case 'editar':
                $nomeSistema = trim($_POST['sistema_nome'] ?? '');
                $statusSistema = $_POST['sistema_status'] ?? 'A';
                $senhaExecutor = trim($_POST['senha_executor'] ?? '');
                $usuarioExecutor = (int) ($_SESSION['usuarioID'] ?? 0);

                if ($nomeSistema === '') {
                    $erros[] = 'Informe o nome do sistema.';
                }

                if (!in_array($statusSistema, ['A', 'I'], true)) {
                    $erros[] = 'Selecione um status válido.';
                }

                if ($senhaExecutor === '') {
                    $erros[] = 'Informe a sua senha.';
                } elseif (!validarSenhaUsuario($usuarioExecutor, $senhaExecutor)) {
                    $erros[] = 'Senha informada não confere.';
                }

                $retornoProcedure = [];

                if (empty($erros)) {
                    try {
                        if ($acao === 'criar') {
                            $retornoProcedure = inserirSistema($nomeSistema, $usuarioExecutor, $senhaExecutor);
                        } else {
                            $sistemaId = (int) ($_POST['sistema_id'] ?? 0);
                            $dataUsuario = $_POST['sistema_datausu'] ?? '';

                            if ($sistemaId <= 0) {
                                $erros[] = 'Identificador do sistema inválido.';
                            } else {
                                $retornoProcedure = atualizarSistema(
                                    $sistemaId,
                                    $nomeSistema,
                                    $statusSistema,
                                    $dataUsuario,
                                    $usuarioExecutor,
                                    $senhaExecutor
                                );
                            }
                        }
                    } catch (Throwable $throwable) {
                        $erros[] = 'Falha ao processar solicitação: ' . $throwable->getMessage();
                    }
                }

                if (empty($erros) && !empty($retornoProcedure)) {
                    [$codigo, $mensa, $novaData] = interpretarRetornoProcedure($retornoProcedure);

                    if ($codigo !== 0) {
                        $erros[] = $mensa !== '' ? $mensa : 'A procedure retornou um código de erro.';
                    } else {
                        $mensagem = $mensa !== '' ? $mensa : 'Operação realizada com sucesso.';
                        $tipoMensagem = 'success';

                        if ($acao === 'editar' && $novaData !== null) {
                            $_POST['sistema_datausu'] = $novaData;
                        }
                    }
                }
                break;

            default:
                // Ação desconhecida
                break;
        }
    }
}

// SEMPRE carrega a lista de sistemas
try {
    $sistemas = listarSistemas($statusFiltro);
} catch (Throwable $throwable) {
    $erros[] = 'Não foi possível carregar a lista de sistemas: ' . $throwable->getMessage();
    $sistemas = [];
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
$_SESSION['csrf_sistema'] = $csrfToken;

function interpretarRetornoProcedure(array $resultado): array
{
    $linha = $resultado[0] ?? [];
    $codigo = (int) ($linha['resulta'] ?? $linha['RESULTA'] ?? 0);
    $mensagem = (string) ($linha['mensa'] ?? $linha['MENSA'] ?? '');
    $novaData = $linha['NovaData'] ?? $linha['NOVADATA'] ?? null;

    return [$codigo, $mensagem, $novaData];
}

function formatarData(?string $data): string
{
    if (!$data) {
        return '';
    }

    try {
        $dt = new DateTime($data);
        return $dt->format('d/m/Y H:i');
    } catch (Exception $exception) {
        return $data;
    }
}

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($mensagem)) : ?>
                    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem, ENT_QUOTES, 'UTF-8'); ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($erros)) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Erro!</h5>
                        <ul class="mb-0 pl-3">
                            <?php foreach ($erros as $erro) : ?>
                                <li><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Filtros -->
                <form method="post" class="row mb-3">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="filtrar">
                    
                    <div class="col-md-3">
                        <label for="filtroStatus" class="form-label">Status</label>
                        <select class="form-control" id="filtroStatus" name="filtro_status" onchange="this.form.submit()">
                            <option value="A" <?php echo $statusFiltro === 'A' ? 'selected' : ''; ?>>Ativo</option>
                            <option value="I" <?php echo $statusFiltro === 'I' ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                    </div>
                    
                    <div class="col-md-9 d-flex align-items-end">
                        <button type="button" class="btn btn-primary" onclick="abrirModalNovoSistema()">
                            <i class="fas fa-plus"></i> Novo Sistema
                        </button>
                    </div>
                </form>

                <!-- Tabela de sistemas -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead style="background-color: white; color: black;">
                            <tr>
                                <th>Sistema</th>
                                <th width="120">Status</th>
                                <th width="180">Atualizado em</th>
                                <th width="100" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($sistemas)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="fas fa-search"></i> Nenhum sistema encontrado.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($sistemas as $item) :
                                    $sistemaId = (int) ($item['P1104_sistemaid'] ?? $item['p1104_sistemaid'] ?? $item['P1104_SISTEMAID'] ?? 0);
                                    $nome = $item['p1104_Sistema'] ?? $item['P1104_SISTEMA'] ?? $item['p1104_sistema'] ?? '';
                                    $status = $item['p1104_Ativo'] ?? $item['P1104_ATIVO'] ?? 'A';
                                    $statusLabel = $status === 'A' ? 'Ativo' : 'Inativo';
                                    $dataUsu = $item['p1104_datausu'] ?? $item['DATAUSUARIO'] ?? $item['P1104_DATAUSU'] ?? '';
                                    $dataFormatada = formatarData($dataUsu);
                                ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars((string) $nome, ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $status === 'A' ? 'success' : 'secondary'; ?>">
                                                <i class="fas fa-<?php echo $status === 'A' ? 'check' : 'times'; ?>"></i>
                                                <?php echo htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                <?php echo htmlspecialchars($dataFormatada, ENT_QUOTES, 'UTF-8'); ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                onclick="abrirModalEdicaoSistema(
                                                    <?php echo $sistemaId; ?>,
                                                    '<?php echo htmlspecialchars((string) $nome, ENT_QUOTES, 'UTF-8'); ?>',
                                                    '<?php echo htmlspecialchars((string) $status, ENT_QUOTES, 'UTF-8'); ?>',
                                                    '<?php echo htmlspecialchars((string) $dataUsu, ENT_QUOTES, 'UTF-8'); ?>'
                                                )"
                                                title="Editar Sistema"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sistema -->
<div class="modal fade" id="modalSistema" tabindex="-1" role="dialog" aria-labelledby="modalSistemaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" id="formSistema">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalSistemaLabel">
                        <i class="fas fa-server"></i> Sistema
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="acao" value="" id="modal_acao">
                    <input type="hidden" name="sistema_id" value="0" id="modal_sistema_id">
                    <input type="hidden" name="sistema_datausu" value="" id="modal_sistema_datausu">
                    <input type="hidden" name="filtro_status" value="<?php echo htmlspecialchars((string) $statusFiltro, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="modal_sistema_nome">
                                    <i class="fas fa-tag"></i> Nome do Sistema <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="modal_sistema_nome" 
                                    name="sistema_nome" 
                                    maxlength="50" 
                                    required
                                    placeholder="Digite o nome do sistema"
                                >
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group" id="div_status_sistema" style="display: none;">
                                <label for="modal_sistema_status">
                                    <i class="fas fa-toggle-on"></i> Status
                                </label>
                                <select class="form-control" id="modal_sistema_status" name="sistema_status">
                                    <option value="A">Ativo</option>
                                    <option value="I">Inativo</option>
                                </select>
                                <input type="hidden" id="modal_sistema_status_hidden" value="A">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_senha_executor_sistema">
                                    <i class="fas fa-key"></i> Sua Senha <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="modal_senha_executor_sistema" 
                                    name="senha_executor" 
                                    maxlength="20" 
                                    required
                                    placeholder="Digite sua senha para confirmar"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Abre modal para novo sistema
function abrirModalNovoSistema() {
    document.getElementById('modalSistemaLabel').innerHTML = '<i class="fas fa-plus"></i> Novo Sistema';
    document.getElementById('modal_acao').value = 'criar';
    document.getElementById('modal_sistema_id').value = '0';
    document.getElementById('modal_sistema_nome').value = '';
    document.getElementById('modal_sistema_status').value = 'A';
    document.getElementById('modal_sistema_status_hidden').value = 'A';
    document.getElementById('modal_sistema_datausu').value = '';
    document.getElementById('modal_senha_executor_sistema').value = '';
    document.getElementById('div_status_sistema').style.display = 'none';
    
    $('#modalSistema').modal('show');
    setTimeout(function() {
        document.getElementById('modal_sistema_nome').focus();
    }, 500);
}

// Abre modal para edição de sistema
function abrirModalEdicaoSistema(id, nome, status, dataUsu) {
    document.getElementById('modalSistemaLabel').innerHTML = '<i class="fas fa-edit"></i> Editar Sistema';
    document.getElementById('modal_acao').value = 'editar';
    document.getElementById('modal_sistema_id').value = id;
    document.getElementById('modal_sistema_nome').value = nome;
    document.getElementById('modal_sistema_status').value = status;
    document.getElementById('modal_sistema_status_hidden').value = status;
    document.getElementById('modal_sistema_datausu').value = dataUsu;
    document.getElementById('modal_senha_executor_sistema').value = '';
    document.getElementById('div_status_sistema').style.display = 'block';
    
    $('#modalSistema').modal('show');
    setTimeout(function() {
        document.getElementById('modal_sistema_nome').focus();
    }, 500);
}

// Validação do formulário
document.getElementById('formSistema').addEventListener('submit', function(e) {
    var nome = document.getElementById('modal_sistema_nome').value.trim();
    var senha = document.getElementById('modal_senha_executor_sistema').value.trim();
    
    if (nome === '') {
        e.preventDefault();
        alert('Por favor, informe o nome do sistema.');
        document.getElementById('modal_sistema_nome').focus();
        return false;
    }
    
    if (senha === '') {
        e.preventDefault();
        alert('Por favor, informe sua senha.');
        document.getElementById('modal_senha_executor_sistema').focus();
        return false;
    }
    
    return true;
});

// Auto-submit do filtro
document.getElementById('filtroStatus').addEventListener('change', function() {
    this.form.submit();
});
</script>

