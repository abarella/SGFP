<?php
require_once __DIR__ . '/../functionsUsuario.php';

// Inicializar sessão se ainda não iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função auxiliar para extrair campos com diferentes variações de nomes
function extrairCampo(array $linha, string $campo, $padrao = '') {
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
if (!isset($_SESSION['filtros_direitos_grupo'])) {
    $_SESSION['filtros_direitos_grupo'] = [
        'sistema' => '',
        'programa' => '',
        'grupo' => ''
    ];
}

$mensagem = '';
$tipoMensagem = 'info';
$erros = [];

// Processar requisições
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'filtrar':
            $_SESSION['filtros_direitos_grupo']['sistema'] = $_POST['sistema'] ?? '';
            $_SESSION['filtros_direitos_grupo']['programa'] = $_POST['programa'] ?? '';
            $_SESSION['filtros_direitos_grupo']['grupo'] = $_POST['grupo'] ?? '';
            break;
            
        case 'salvar':
            try {
                $sistemaId = (int) ($_POST['sistema'] ?? 0);
                $grupoId = (int) ($_POST['grupo'] ?? 0);
                $senhaExecutor = trim($_POST['senha_executor'] ?? '');
                $usuarioExecutorId = (int) $_SESSION['usuarioID'];
                
                if (empty($senhaExecutor)) {
                    throw new Exception('Informe sua senha para confirmar a operação.');
                }
                
                if (!validarSenhaUsuario($usuarioExecutorId, $senhaExecutor)) {
                    throw new Exception('Senha informada não confere.');
                }
                
                $direitosRecebidos = $_POST['direito'] ?? [];
                $direitoIds = $_POST['direito_id'] ?? [];
                $direitosOriginais = $_POST['direito_origem'] ?? [];
                
                foreach ($direitosRecebidos as $programaId => $direitoSelecionado) {
                    $programaId = (int) $programaId;
                    $direitoSelecionado = (int) $direitoSelecionado;
                    $direitoId = isset($direitoIds[$programaId]) ? (int) $direitoIds[$programaId] : 0;
                    $direitoOriginal = isset($direitosOriginais[$programaId]) ? (int) $direitosOriginais[$programaId] : -1;
                    
                    if ($direitoSelecionado === $direitoOriginal) {
                        continue;
                    }
                    
                    if ($direitoId > 0) {
                        atualizarDireitoGrupo(
                            $direitoId,
                            $grupoId,
                            $programaId,
                            $direitoSelecionado,
                            $usuarioExecutorId,
                            $senhaExecutor
                        );
                    } else {
                        inserirDireitoGrupo(
                            $grupoId,
                            $programaId,
                            $direitoSelecionado,
                            $usuarioExecutorId,
                            $senhaExecutor
                        );
                    }
                }
                
                $mensagem = 'Direitos do grupo atualizados com sucesso!';
                $tipoMensagem = 'success';
                
            } catch (Exception $e) {
                $mensagem = 'Erro: ' . $e->getMessage();
                $tipoMensagem = 'danger';
            }
            break;
    }
}

// Buscar dados para os filtros
try {
    $sistemas = listarSistemas();
    $grupos = listarGrupos();
} catch (Exception $e) {
    $sistemas = [];
    $grupos = [];
    $erros[] = 'Erro ao carregar dados: ' . $e->getMessage();
}

// Buscar programas baseado no sistema selecionado
$programas = [];
if (!empty($_SESSION['filtros_direitos_grupo']['sistema'])) {
    try {
        $programas = listarProgramas((int)$_SESSION['filtros_direitos_grupo']['sistema']);
    } catch (Exception $e) {
        $erros[] = 'Erro ao carregar programas: ' . $e->getMessage();
    }
}

// Buscar direitos baseado nos filtros
$direitos = [];
if (!empty($_SESSION['filtros_direitos_grupo']['sistema']) && !empty($_SESSION['filtros_direitos_grupo']['grupo'])) {
    try {
        $programaFiltro = !empty($_SESSION['filtros_direitos_grupo']['programa']) ? (int)$_SESSION['filtros_direitos_grupo']['programa'] : null;
        $direitos = listarDireitosGrupo(
            (int)$_SESSION['filtros_direitos_grupo']['grupo'],
            $programaFiltro,
            (int)$_SESSION['filtros_direitos_grupo']['sistema'],
            0 // Reverter para ordem = 0 (padrão)
        );
    } catch (Exception $e) {
        $erros[] = 'Erro ao carregar direitos: ' . $e->getMessage();
    }
}
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
                
                <form method="post" id="formFiltro" class="mb-3">
                    <input type="hidden" name="acao" value="filtrar">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroSistema">Sistema</label>
                                <select class="form-control" id="filtroSistema" name="sistema" onchange="this.form.submit()" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($sistemas as $sistema): 
                                        $sistemaId = extrairCampo($sistema, 'p1104_SistemaID');
                                        if (empty($sistemaId)) $sistemaId = extrairCampo($sistema, 'P1104_sistemaid');
                                        $sistemaNome = extrairCampo($sistema, 'p1104_Sistema');
                                        $selected = $_SESSION['filtros_direitos_grupo']['sistema'] == $sistemaId ? 'selected' : '';
                                    ?>
                                        <option value="<?= htmlspecialchars($sistemaId) ?>" <?= $selected ?>>
                                            <?= htmlspecialchars($sistemaNome) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroPrograma">Programa</label>
                                <select class="form-control" id="filtroPrograma" name="programa" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <?php foreach ($programas as $programa): 
                                        $programaId = extrairCampo($programa, 'p1103_ProgramaID');
                                        if (empty($programaId)) $programaId = extrairCampo($programa, 'P1103_PROGRAMAID');
                                        $programaNome = extrairCampo($programa, 'p1103_Programa');
                                        $selected = $_SESSION['filtros_direitos_grupo']['programa'] == $programaId ? 'selected' : '';
                                    ?>
                                        <option value="<?= htmlspecialchars($programaId) ?>" <?= $selected ?>>
                                            <?= htmlspecialchars($programaNome) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroGrupo">Grupo</label>
                                <select class="form-control" id="filtroGrupo" name="grupo" onchange="this.form.submit()" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($grupos as $grupo): 
                                        $grupoId = extrairCampo($grupo, 'p052_GrupoCD');
                                        if (empty($grupoId)) $grupoId = extrairCampo($grupo, 'P052_GRUPOCD');
                                        $grupoNome = extrairCampo($grupo, 'p052_Grupo');
                                        $selected = $_SESSION['filtros_direitos_grupo']['grupo'] == $grupoId ? 'selected' : '';
                                    ?>
                                        <option value="<?= htmlspecialchars($grupoId) ?>" <?= $selected ?>>
                                            <?= htmlspecialchars($grupoNome) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" title="Consultar">
                                <i class="fas fa-search"></i> Consultar
                            </button>
                        </div>
                    </div>
                </form>

                <?php if (!empty($direitos)): ?>
                <form method="post" onsubmit="return validarFormulario()">
                    <input type="hidden" name="acao" value="salvar">
                    <input type="hidden" name="sistema" value="<?= htmlspecialchars($_SESSION['filtros_direitos_grupo']['sistema']) ?>">
                    <input type="hidden" name="grupo" value="<?= htmlspecialchars($_SESSION['filtros_direitos_grupo']['grupo']) ?>">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead style="background-color: white; color: black;">
                                <tr>
                                    <th>Sistema</th>
                                    <th>Programa</th>
                                    <th class="text-center">Atualização</th>
                                    <th class="text-center">Consulta</th>
                                    <th class="text-center">Sem direitos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($direitos as $linha): 
                                    $programaId = (int) extrairCampo($linha, 'p1103_ProgramaID', 0);
                                    $direitoAtual = (int) extrairCampo($linha, 'p1106_Direito', 0);
                                    $direitoId = (int) extrairCampo($linha, 'p1106_DireitosID', 0);
                                    $sistemaNome = extrairCampo($linha, 'p1104_Sistema', '');
                                    $programaNome = extrairCampo($linha, 'p1103_Programa', '');
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
                                    </tr>
                                    <input type="hidden" name="direito_id[<?= $programaId ?>]" value="<?= $direitoId ?>">
                                    <input type="hidden" name="direito_origem[<?= $programaId ?>]" value="<?= $direitoAtual ?>">
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="form-row align-items-end mt-3">
                        <div class="form-group col-md-3">
                            <label for="senha_executor">Senha</label>
                            <input type="password" class="form-control" name="senha_executor" id="senha_executor" maxlength="20" required>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Salvar Direitos
                            </button>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                <div class="alert alert-info">
                    Selecione um sistema e um grupo para visualizar os direitos disponíveis.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function validarFormulario() {
    const senha = document.querySelector('#senha_executor');
    if (!senha.value.trim()) {
        alert('Digite sua senha para confirmar a operação.');
        senha.focus();
        return false;
    }
    return true;
}
</script>

