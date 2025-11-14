<?php
require_once __DIR__ . '/../functionsUsuario.php';

if (!function_exists('alterarSenhaInterpretarRetorno')) {
    /**
     * @return array{0:int,1:string}
     */
    function alterarSenhaInterpretarRetorno(array $resultado): array
    {
        if (empty($resultado)) {
            return [0, ''];
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

        return [$codigo, $mensagem];
    }
}

$erros = [];
$mensagem = null;
$tipoMensagem = 'info';

$usuarioId = (int) ($_SESSION['usuarioID'] ?? 0);
$usuarioDados = null;

if ($usuarioId <= 0) {
    $erros[] = 'Sessão expirada. Faça login novamente.';
} else {
    try {
        $usuarioDados = buscarUsuarioPorId($usuarioId);
        if ($usuarioDados === null) {
            $erros[] = 'Usuário não encontrado.';
        }
    } catch (Throwable $throwable) {
        $erros[] = 'Falha ao carregar dados do usuário: ' . $throwable->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuarioId > 0) {
    $tokenValido = isset($_POST['csrf_token'], $_SESSION['csrf_alterar_senha'])
        && hash_equals((string) $_SESSION['csrf_alterar_senha'], (string) $_POST['csrf_token']);

    if (!$tokenValido) {
        $erros[] = 'Sessão expirada. Atualize a página e tente novamente.';
    } else {
        $senhaAtual = trim((string) ($_POST['senha_atual'] ?? ''));
        $senhaNova = trim((string) ($_POST['senha_nova'] ?? ''));
        $senhaConfirma = trim((string) ($_POST['senha_confirma'] ?? ''));

        if ($senhaAtual === '') {
            $erros[] = 'Informe a senha atual.';
        }

        if ($senhaNova === '') {
            $erros[] = 'Informe a nova senha.';
        }

        if ($senhaConfirma === '') {
            $erros[] = 'Confirme a nova senha.';
        }

        if ($senhaNova !== '' && $senhaAtual === $senhaNova) {
            $erros[] = 'A nova senha deve ser diferente da senha atual.';
        }

        if ($senhaNova !== $senhaConfirma) {
            $erros[] = 'A nova senha e a confirmação não coincidem.';
        }

        if (empty($erros)) {
            try {
                $resultado = alterarSenhaUsuarioBasico($usuarioId, $senhaAtual, $senhaNova);
            } catch (Throwable $throwable) {
                $erros[] = 'Falha ao alterar a senha: ' . $throwable->getMessage();
                $resultado = [];
            }

            if (empty($erros)) {
                [$codigoRetorno, $mensagemRetorno] = alterarSenhaInterpretarRetorno($resultado);

                if ($codigoRetorno !== 0) {
                    $erros[] = $mensagemRetorno !== '' ? $mensagemRetorno : 'Não foi possível alterar a senha.';
                } else {
                    $mensagem = $mensagemRetorno !== '' ? $mensagemRetorno : 'Senha alterada com sucesso.';
                    $tipoMensagem = 'success';
                    // Atualiza a senha na sessão para que validaUsuario use a nova senha
                    if (isset($_SESSION) && isset($senhaNova)) {
                        $_SESSION['usuarioSenha'] = $senhaNova;
                    }
                }
            }
        }
    }
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
$_SESSION['csrf_alterar_senha'] = $csrfToken;

$nomeUsuario = $usuarioDados['p1110_nome'] ?? $usuarioDados['P1110_NOME'] ?? '';
$username = $usuarioDados['p1110_username'] ?? $usuarioDados['P1110_USERNAME'] ?? '';
$email = $usuarioDados['p1110_email'] ?? $usuarioDados['P1110_EMAIL'] ?? '';

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

                <form method="post" name="formAlterarSenha" id="formAlterarSenha">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados do usuário</h5>
                            <p class="mb-1"><strong>Login:</strong> <?php echo htmlspecialchars((string) $username, ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="mb-1"><strong>Nome:</strong> <?php echo htmlspecialchars((string) $nomeUsuario, ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="mb-0"><strong>E-mail:</strong> <?php echo htmlspecialchars((string) $email, ENT_QUOTES, 'UTF-8'); ?></p>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senhaAtual" class="form-label">Senha Atual</label>
                                <input type="password" class="form-control form-control-sm" id="senhaAtual" name="senha_atual" maxlength="20" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senhaNova" class="form-label">Senha Nova</label>
                                <input type="password" class="form-control form-control-sm" id="senhaNova" name="senha_nova" maxlength="20" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senhaConfirma" class="form-label">Confirmar Senha Nova</label>
                                <input type="password" class="form-control form-control-sm" id="senhaConfirma" name="senha_confirma" maxlength="20" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <button type="submit" class="btn btn-primary">Alterar Senha</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </div>
                </form>
                <!-- fim do conteúdo -->
            </div>
        </div>
    </div>
</div>

