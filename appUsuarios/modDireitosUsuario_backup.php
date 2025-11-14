<?php
require_once __DIR__ . '/../functionsUsuario.php';

$mensagem = null;
$tipoMensagem = 'info';
$erros = [];

try {
    $sistemas = listarSistemas();
    $grupos = listarGrupos();
} catch (Throwable $throwable) {
    $erros[] = 'Falha ao carregar dados iniciais: ' . $throwable->getMessage();
    $sistemas = [];
    $grupos = [];
}

$selectedSistemaId = null;
$selectedProgramaId = null;
$selectedGrupoId = null;
$selectedUsuarioId = null;
$direitos = [];

$senhaExecutor = '';

if (!empty($sistemas)) {
    $selectedSistemaId = (int) ($sistemas[0]['p1104_SistemaID'] ?? $sistemas[0]['P1104_SISTEMAID'] ?? 0);
}

if (!empty($grupos)) {
    $selectedGrupoId = (int) ($grupos[0]['p052_GrupoCD'] ?? $grupos[0]['P052_GRUPOCD'] ?? 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_direitos_usuario'])
        && hash_equals($_SESSION['csrf_direitos_usuario'], (string) $_POST['csrf_token']);

    if (!$tokenValido) {
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    }

    $selectedSistemaId = isset($_POST['sistema']) ? (int) $_POST['sistema'] : $selectedSistemaId;
    $selectedProgramaId = isset($_POST['programa']) ? (int) $_POST['programa'] : $selectedProgramaId;
    $selectedGrupoId = isset($_POST['grupo']) ? (int) $_POST['grupo'] : $selectedGrupoId;
    $selectedUsuarioId = isset($_POST['usuario']) ? (int) $_POST['usuario'] : $selectedUsuarioId;
    $senhaExecutor = trim($_POST['senha_executor'] ?? '');

    if ($tokenValido && isset($_POST['acao']) && $_POST['acao'] === 'salvar') {
        if ($selectedUsuarioId <= 0) {
            $erros[] = 'Selecione um usuário antes de salvar os direitos.';
        }

        if ($selectedGrupoId <= 0) {
            $erros[] = 'Selecione um grupo válido.';
        }

        if ($selectedSistemaId <= 0) {
            $erros[] = 'Selecione um sistema válido.';
        }

        if ($senhaExecutor === '') {
            $erros[] = 'Informe a sua senha para confirmar a alteração de direitos.';
        } elseif (!validarSenhaUsuario((int) $_SESSION['usuarioID'], $senhaExecutor)) {
            $erros[] = 'Senha informada não confere.';
        }

        if (empty($erros)) {
            $direitosRecebidos = $_POST['direito'] ?? [];
            $direitoIds = $_POST['direito_id'] ?? [];
            $direitosOriginais = $_POST['direito_origem'] ?? [];
            $usuarioExecutor = (int) $_SESSION['usuarioID'];

            foreach ($direitosRecebidos as $programaId => $direitoSelecionado) {
                $programaId = (int) $programaId;
                $direitoSelecionado = (int) $direitoSelecionado;
                $direitoId = isset($direitoIds[$programaId]) ? (int) $direitoIds[$programaId] : 0;
                $direitoOriginal = isset($direitosOriginais[$programaId]) ? (int) $direitosOriginais[$programaId] : -1;

                if ($direitoSelecionado === $direitoOriginal) {
                    continue;
                }

                try {
                    if ($direitoId > 0) {
                        atualizarDireitoUsuario(
                            $direitoId,
                            $direitoSelecionado,
                            $programaId,
                            $selectedUsuarioId,
                            $selectedGrupoId,
                            $usuarioExecutor,
                            $senhaExecutor
                        );
                    } else {
                        inserirDireitoUsuario(
                            $direitoSelecionado,
                            $programaId,
                            $selectedUsuarioId,
                            $selectedGrupoId,
                            $usuarioExecutor,
                            $senhaExecutor
                        );
                    }
                } catch (Throwable $throwable) {
                    $erros[] = 'Erro ao atualizar direitos do programa ' . $programaId . ': ' . $throwable->getMessage();
                }
            }

            if (empty($erros)) {
                $mensagem = 'Direitos atualizados com sucesso.';
                $tipoMensagem = 'success';
            }
        }
    }
} else {
    $selectedSistemaId = isset($_GET['sistema']) ? (int) $_GET['sistema'] : $selectedSistemaId;
    $selectedProgramaId = isset($_GET['programa']) ? (int) $_GET['programa'] : $selectedProgramaId;
    $selectedGrupoId = isset($_GET['grupo']) ? (int) $_GET['grupo'] : $selectedGrupoId;
    $selectedUsuarioId = isset($_GET['usuario']) ? (int) $_GET['usuario'] : $selectedUsuarioId;
}

$programas = [];
$usuarios = [];

if ($selectedSistemaId) {
    try {
        $programas = listarProgramas($selectedSistemaId);
        if ($selectedProgramaId === null && !empty($programas)) {
            $selectedProgramaId = (int) ($programas[0]['p1103_ProgramaID'] ?? $programas[0]['P1103_PROGRAMAID'] ?? 0);
        }
    } catch (Throwable $throwable) {
        $erros[] = 'Falha ao carregar programas: ' . $throwable->getMessage();
    }
}

if ($selectedGrupoId) {
    try {
        $usuarios = listarUsuariosPorGrupo($selectedGrupoId);
        if ($selectedUsuarioId === null && !empty($usuarios)) {
            $selectedUsuarioId = (int) ($usuarios[0]['p1110_usuarioid'] ?? $usuarios[0]['P1110_USUARIOID'] ?? 0);
        }
    } catch (Throwable $throwable) {
        $erros[] = 'Falha ao carregar usuários: ' . $throwable->getMessage();
    }
}

if ($selectedProgramaId && $selectedUsuarioId && $selectedSistemaId && $selectedGrupoId) {
    try {
        $direitos = listarDireitosUsuario($selectedProgramaId, $selectedUsuarioId, $selectedSistemaId, $selectedGrupoId);
    } catch (Throwable $throwable) {
        $erros[] = 'Não foi possível listar os direitos: ' . $throwable->getMessage();
    }
}

function renderOpcoes(array $dados, string $valueKey, string $labelKey, $selecionado): string
{
    $html = '';
    foreach ($dados as $item) {
        $valor = $item[$valueKey] ?? ($item[strtoupper($valueKey)] ?? null);
        $rotulo = $item[$labelKey] ?? ($item[strtoupper($labelKey)] ?? $valor);

        if ($valor === null) {
            continue;
        }

        $valorInt = (int) $valor;
        $selecionadoAttr = $valorInt === (int) $selecionado ? ' selected' : '';
        $html .= '<option value="' . htmlspecialchars((string) $valorInt, ENT_QUOTES, 'UTF-8') . '"' . $selecionadoAttr . '>'
            . htmlspecialchars((string) $rotulo, ENT_QUOTES, 'UTF-8') . '</option>';
    }

    return $html;
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
$_SESSION['csrf_direitos_usuario'] = $csrfToken;

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Direitos por Usuário</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
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

            <div class="card">
                <div class="card-body">
                    <form method="post" class="mb-3">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="cmbSistema">Sistema</label>
                                <select class="form-control" name="sistema" id="cmbSistema" onchange="this.form.submit()">
                                    <option value="">Selecione</option>
                                    <?php echo renderOpcoes($sistemas, 'p1104_SistemaID', 'p1104_Sistema', $selectedSistemaId); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cmbPrograma">Programa</label>
                                <select class="form-control" name="programa" id="cmbPrograma" onchange="this.form.submit()">
                                    <option value="">Selecione</option>
                                    <?php echo renderOpcoes($programas, 'p1103_ProgramaID', 'p1103_Programa', $selectedProgramaId); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cmbGrupo">Grupo</label>
                                <select class="form-control" name="grupo" id="cmbGrupo" onchange="this.form.submit()">
                                    <option value="">Selecione</option>
                                    <?php echo renderOpcoes($grupos, 'p052_GrupoCD', 'p052_Grupo', $selectedGrupoId); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cmbUsuario">Usuário</label>
                                <select class="form-control" name="usuario" id="cmbUsuario" onchange="this.form.submit()">
                                    <option value="">Selecione</option>
                                    <?php echo renderOpcoes($usuarios, 'p1110_usuarioid', 'p1110_nome', $selectedUsuarioId); ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <?php if (!empty($direitos)) : ?>
                        <form method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="acao" value="salvar">
                            <input type="hidden" name="sistema" value="<?php echo htmlspecialchars((string) $selectedSistemaId, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="programa" value="<?php echo htmlspecialchars((string) $selectedProgramaId, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="grupo" value="<?php echo htmlspecialchars((string) $selectedGrupoId, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="usuario" value="<?php echo htmlspecialchars((string) $selectedUsuarioId, ENT_QUOTES, 'UTF-8'); ?>">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sistema</th>
                                            <th>Programa</th>
                                            <th class="text-center">Liberado</th>
                                            <th class="text-center">Apenas Consulta</th>
                                            <th class="text-center">Bloqueado</th>
                                            <th class="d-none"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($direitos as $linha) :
                                            $programaId = (int) ($linha['p1103_ProgramaID'] ?? $linha['P1103_PROGRAMAID'] ?? 0);
                                            $direitoAtual = (int) ($linha['p1106_Direito'] ?? $linha['P1106_DIREITO'] ?? 0);
                                            $direitoId = (int) ($linha['p1106_DireitosID'] ?? $linha['P1106_DIREITOSID'] ?? 0);
                                            $sistemaNome = $linha['p1104_Sistema'] ?? $linha['P1104_SISTEMA'] ?? '';
                                            $programaNome = $linha['p1103_Programa'] ?? $linha['P1103_PROGRAMA'] ?? '';
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars((string) $sistemaNome, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars((string) $programaNome, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center">
                                                    <input type="radio" name="direito[<?php echo $programaId; ?>]" value="1" <?php echo $direitoAtual === 1 ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" name="direito[<?php echo $programaId; ?>]" value="2" <?php echo $direitoAtual === 2 ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="text-center">
                                                    <input type="radio" name="direito[<?php echo $programaId; ?>]" value="0" <?php echo $direitoAtual === 0 ? 'checked' : ''; ?>>
                                                </td>
                                                <td class="d-none">
                                                    <input type="hidden" name="direito_id[<?php echo $programaId; ?>]" value="<?php echo $direitoId; ?>">
                                                    <input type="hidden" name="direito_origem[<?php echo $programaId; ?>]" value="<?php echo $direitoAtual; ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-row align-items-end">
                                <div class="form-group col-md-3">
                                    <label for="senhaExecutor">Senha</label>
                                    <input type="password" class="form-control" id="senhaExecutor" name="senha_executor" maxlength="20" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-primary">Salvar Direitos</button>
                                </div>
                            </div>
                        </form>
                    <?php else : ?>
                        <div class="alert alert-warning">
                            Ajuste os filtros acima para listar os direitos disponíveis.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

