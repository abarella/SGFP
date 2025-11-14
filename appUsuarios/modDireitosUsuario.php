<?php
require_once __DIR__ . '/../functionsUsuario.php';

// Inicializar sessão se ainda não iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função auxiliar para extrair campos com diferentes variações de nomes
function extrairCampoDireitoUsuario(array $linha, string $campo, $padrao = '') {
    // Lista de variações comuns do nome do campo
    $variacoes = [
        $campo,
        strtolower($campo),
        strtoupper($campo),
        ucfirst(strtolower($campo))
    ];
    
    foreach ($variacoes as $variacao) {
        if (array_key_exists($variacao, $linha)) {
            return $linha[$variacao];
        }
    }
    
    return $padrao;
}

// Inicializar filtros na sessão
if (!isset($_SESSION['filtros_direitos_usuario'])) {
    $_SESSION['filtros_direitos_usuario'] = [
        'sistema' => null,
        'programa' => null,
        'grupo' => null,
        'usuario' => null
    ];
}

$mensagem = null;
$tipoMensagem = 'info';
$erros = [];

// Carregar dados iniciais
try {
    $sistemas = listarSistemas();
    $grupos = listarGrupos();
} catch (Exception $e) {
    $erros[] = 'Falha ao carregar dados iniciais: ' . $e->getMessage();
    $sistemas = [];
    $grupos = [];
}

// Definir valores padrão
if (!empty($sistemas) && ($_SESSION['filtros_direitos_usuario']['sistema'] === null || $_SESSION['filtros_direitos_usuario']['sistema'] === '')) {
    $_SESSION['filtros_direitos_usuario']['sistema'] = $sistemas[0]['P1104_sistemaid'] ?? $sistemas[0]['p1104_SistemaID'] ?? $sistemas[0]['P1104_SISTEMAID'] ?? '';
}

if (!empty($grupos) && ($_SESSION['filtros_direitos_usuario']['grupo'] === null || $_SESSION['filtros_direitos_usuario']['grupo'] === '')) {
    $_SESSION['filtros_direitos_usuario']['grupo'] = $grupos[0]['p052_GrupoCD'] ?? $grupos[0]['P052_GRUPOCD'] ?? '';
}

$programas = [];
$usuarios = [];
$direitos = [];

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar filtros
    if (isset($_POST['acao']) && $_POST['acao'] === 'filtrar') {
        $_SESSION['filtros_direitos_usuario']['sistema'] = $_POST['sistema'] ?? '';
        $_SESSION['filtros_direitos_usuario']['programa'] = $_POST['programa'] ?? '';
        $_SESSION['filtros_direitos_usuario']['grupo'] = $_POST['grupo'] ?? '';
        $_SESSION['filtros_direitos_usuario']['usuario'] = $_POST['usuario'] ?? '';
    }
    
    // Processar salvamento de direitos
    if (isset($_POST['acao']) && $_POST['acao'] === 'salvar') {
        $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_direitos_usuario'])
            && hash_equals($_SESSION['csrf_direitos_usuario'], (string) $_POST['csrf_token']);

        if (!$tokenValido) {
            $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
        } else {
            $senhaExecutor = trim($_POST['senha_executor'] ?? '');
            
            if (!isset($_SESSION['filtros_direitos_usuario']['usuario']) || $_SESSION['filtros_direitos_usuario']['usuario'] === '') {
                $erros[] = 'Selecione um usuário antes de salvar os direitos.';
            }
            
            if (!isset($_SESSION['filtros_direitos_usuario']['grupo']) || $_SESSION['filtros_direitos_usuario']['grupo'] === '') {
                $erros[] = 'Selecione um grupo válido.';
            }
            
            if (!isset($_SESSION['filtros_direitos_usuario']['sistema']) || $_SESSION['filtros_direitos_usuario']['sistema'] === '') {
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
                                (int)$_SESSION['filtros_direitos_usuario']['usuario'],
                                (int)$_SESSION['filtros_direitos_usuario']['grupo'],
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        } else {
                            inserirDireitoUsuario(
                                $direitoSelecionado,
                                $programaId,
                                (int)$_SESSION['filtros_direitos_usuario']['usuario'],
                                (int)$_SESSION['filtros_direitos_usuario']['grupo'],
                                $usuarioExecutor,
                                $senhaExecutor
                            );
                        }
                    } catch (Exception $e) {
                        $erros[] = 'Erro ao atualizar direitos do programa ' . $programaId . ': ' . $e->getMessage();
                    }
                }
                
                if (empty($erros)) {
                    $mensagem = 'Direitos atualizados com sucesso.';
                    $tipoMensagem = 'success';
                }
            }
        }
    }
}

// Carregar programas se sistema selecionado
if ($_SESSION['filtros_direitos_usuario']['sistema'] !== null && $_SESSION['filtros_direitos_usuario']['sistema'] !== '') {
    try {
        $programas = listarProgramas((int)$_SESSION['filtros_direitos_usuario']['sistema']);
    } catch (Exception $e) {
        $erros[] = 'Erro ao carregar programas: ' . $e->getMessage();
    }
}

// Carregar usuários se grupo selecionado
if (isset($_SESSION['filtros_direitos_usuario']['grupo']) && $_SESSION['filtros_direitos_usuario']['grupo'] !== '') {
    try {
        $usuarios = listarUsuariosPorGrupo((int)$_SESSION['filtros_direitos_usuario']['grupo']);
    } catch (Exception $e) {
        $erros[] = 'Erro ao carregar usuários: ' . $e->getMessage();
    }
}

// Carregar direitos se todos os filtros estiverem preenchidos
if (isset($_SESSION['filtros_direitos_usuario']['sistema']) && $_SESSION['filtros_direitos_usuario']['sistema'] !== '' && 
    isset($_SESSION['filtros_direitos_usuario']['grupo']) && $_SESSION['filtros_direitos_usuario']['grupo'] !== '' &&
    isset($_SESSION['filtros_direitos_usuario']['usuario']) && $_SESSION['filtros_direitos_usuario']['usuario'] !== '') {
    
    try {
        $programaFiltro = !empty($_SESSION['filtros_direitos_usuario']['programa']) ? (int)$_SESSION['filtros_direitos_usuario']['programa'] : null;
        $direitos = listarDireitosUsuario(
            $programaFiltro,
            (int)$_SESSION['filtros_direitos_usuario']['usuario'],
            (int)$_SESSION['filtros_direitos_usuario']['sistema'],
            (int)$_SESSION['filtros_direitos_usuario']['grupo'],
            0 // ordem = 0 (padrão)
        );
        
        // Exibir debug SQL se disponível
        if (isset($GLOBALS['debug_sql']) && !empty($GLOBALS['debug_sql'])) {
            foreach ($GLOBALS['debug_sql'] as $sql) {
                $erros[] = 'DEBUG SQL: ' . $sql;
            }
        }
        
    } catch (Exception $e) {
        $erros[] = 'Erro ao carregar direitos: ' . $e->getMessage();
    }
}

// Gerar token CSRF
$csrfToken = bin2hex(random_bytes(16));
$_SESSION['csrf_direitos_usuario'] = $csrfToken;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- início do conteúdo -->
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

                <!-- Filtros -->
                <form method="POST" class="mb-3">
                    <input type="hidden" name="acao" value="filtrar">
                    
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="sistema">Sistema</label>
                            <select name="sistema" id="sistema" class="form-control" onchange="this.form.submit()">
                                <option value="">Selecione</option>
                                <?php foreach ($sistemas as $sistema): ?>
                                    <option value="<?= htmlspecialchars($sistema['P1104_sistemaid'] ?? $sistema['p1104_SistemaID'] ?? $sistema['P1104_SISTEMAID']) ?>" 
                                            <?= ($_SESSION['filtros_direitos_usuario']['sistema'] == ($sistema['P1104_sistemaid'] ?? $sistema['p1104_SistemaID'] ?? $sistema['P1104_SISTEMAID'])) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sistema['p1104_Sistema'] ?? $sistema['P1104_SISTEMA']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="programa">Programa</label>
                            <select name="programa" id="programa" class="form-control" onchange="this.form.submit()">
                                <option value="">Todos</option>
                                <?php foreach ($programas as $programa): ?>
                                    <option value="<?= htmlspecialchars($programa['p1103_ProgramaID'] ?? $programa['P1103_PROGRAMAID']) ?>" 
                                            <?= ($_SESSION['filtros_direitos_usuario']['programa'] == ($programa['p1103_ProgramaID'] ?? $programa['P1103_PROGRAMAID'])) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($programa['p1103_Programa'] ?? $programa['P1103_PROGRAMA']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label for="grupo">Grupo</label>
                            <select name="grupo" id="grupo" class="form-control" onchange="this.form.submit()">
                                <option value="">Selecione</option>
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= htmlspecialchars($grupo['p052_GrupoCD'] ?? $grupo['P052_GRUPOCD']) ?>" 
                                            <?= ($_SESSION['filtros_direitos_usuario']['grupo'] == ($grupo['p052_GrupoCD'] ?? $grupo['P052_GRUPOCD'])) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grupo['p052_Grupo'] ?? $grupo['P052_GRUPO']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="usuario">Usuário</label>
                            <select name="usuario" id="usuario" class="form-control" onchange="this.form.submit()">
                                <option value="">Selecione</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= htmlspecialchars($usuario['p1110_usuarioid'] ?? $usuario['P1110_USUARIOID']) ?>" 
                                            <?= ($_SESSION['filtros_direitos_usuario']['usuario'] == ($usuario['p1110_usuarioid'] ?? $usuario['P1110_USUARIOID'])) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($usuario['p1110_nome'] ?? $usuario['P1110_NOME']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Lista de direitos -->
                <?php if (!empty($direitos)): ?>
                    <form method="POST">
                        <input type="hidden" name="acao" value="salvar">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Sistema</th>
                                        <th>Programa</th>
                                        <th class="text-center">Liberado</th>
                                        <th class="text-center">Consulta</th>
                                        <th class="text-center">Sem direitos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($direitos as $linha): 
                                        $programaId = (int) extrairCampoDireitoUsuario($linha, 'p1103_ProgramaID', 0);
                                        $direitoAtual = (int) extrairCampoDireitoUsuario($linha, 'p1106_Direito', 0);
                                        $direitoId = (int) extrairCampoDireitoUsuario($linha, 'p1106_DireitosID', 0);
                                        $sistemaNome = extrairCampoDireitoUsuario($linha, 'p1104_Sistema', '');
                                        $programaNome = extrairCampoDireitoUsuario($linha, 'p1103_Programa', '');
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($sistemaNome) ?></td>
                                            <td><?= htmlspecialchars($programaNome) ?></td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?= $programaId ?>]" value="1" <?= $direitoAtual === 1 ? 'checked' : '' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?= $programaId ?>]" value="2" <?= $direitoAtual === 2 ? 'checked' : '' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="direito[<?= $programaId ?>]" value="0" <?= $direitoAtual === 0 ? 'checked' : '' ?>>
                                            </td>
                                            <td class="d-none">
                                                <input type="hidden" name="direito_id[<?= $programaId ?>]" value="<?= $direitoId ?>">
                                                <input type="hidden" name="direito_origem[<?= $programaId ?>]" value="<?= $direitoAtual ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="senha_executor">Senha</label>
                                <input type="password" class="form-control" id="senha_executor" name="senha_executor" maxlength="20" required>
                            </div>
                            <div class="form-group col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Salvar Direitos</button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info">
                        Selecione os filtros acima para visualizar os direitos do usuário.
                    </div>
                <?php endif; ?>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>