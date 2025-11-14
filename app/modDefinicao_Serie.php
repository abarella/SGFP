<style>
thead input {
    width: 100%;
}

table.dataTable tbody td {
    vertical-align: top;
}
</style>

<script>
const lote = sessionStorage.getItem('lote');
const produto = sessionStorage.getItem('produto');

document.addEventListener('DOMContentLoaded', function() {
    const produtoSelect = document.getElementById('cmbprod');
    // Garante que o select de lotes inicie vazio
    document.getElementById('loteContainer').innerHTML =
        "<select id='cmbLote' name='cmbLote' class='form-control'><option value='0'>Selecione um produto</option></select>";

    if (produtoSelect) {
        produtoSelect.addEventListener('change', atualizaLoteDefinicao);
    }
});

function atualizaLoteDefinicao() {
    const produtoSelect = document.getElementById('cmbprod');
    if (!produtoSelect) {
        console.error("Erro: 'produto' não encontrado no DOM.");
        return;
    }

    const produtoSelecionado = produtoSelect.value;
    console.log("Produto selecionado:", produtoSelecionado);

    if (!produtoSelecionado || produtoSelecionado === "0") {
        console.log("Nenhum produto selecionado, saindo da função.");
        return;
    }

    // Limpar o select antes de enviar a requisição*
    document.getElementById('loteContainer').innerHTML =
        "<select id='cmbLote' name='cmbLote' class='form-control'><option value='0'>Carregando...</option></select>";

    // Enviar como parâmetros individuais, não como uma query string
    var data = "produtoSelecionado=" + encodeURIComponent(produtoSelecionado);

    // Fazer a requisição AJAX para o servidor
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/functions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Resposta completa do servidor:", xhr.responseText); // Debug

            // Substituir o conteúdo do seletor com a resposta do servidor
            document.getElementById('loteContainer').innerHTML = xhr.responseText;
        }
    };

    xhr.send(data); // Enviar os parâmetros diretamente
}

function pesquisaListaSerie() {
    // Obter valores dos campos de pesquisa
    const produtoSelect = document.getElementById('cmbprod');
    const loteSelect = document.getElementById('cmbLote');

    // Verificar se os elementos existem
    if (!produtoSelect || !loteSelect) {
        console.error('Campos de pesquisa não encontrados.');
        return;
    }

    // Obter os valores selecionados
    const produtoSelecionado = produtoSelect.value.trim();
    const loteSelecionado = loteSelect.value.trim();

    // Criar um objeto com os parâmetros
    var params = new URLSearchParams();
    params.append("produtoSelecionado", produtoSelecionado);
    params.append("loteSelecionado", loteSelecionado);

    // Criar a requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/functions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                console.log('Resposta do servidor:', xhr.responseText);
                document.querySelector('#tblistadefinicao tbody').innerHTML = xhr.responseText;
            } else {
                console.error('Erro na requisição AJAX:', xhr.status);
            }
        }
    };

    // Enviar os dados no formato correto
    xhr.send(params.toString());
}

function definirSerieTable(event) {
    event.preventDefault();

    const p110serie = document.querySelector('.p110serie');
    const p110chve = document.querySelector('.p110chve');
    const cdusuario = document.getElementById('cdusuario');
    const senha = document.getElementById('txtSenha');

    var params = new URLSearchParams();
    params.append("p110chve", p110chve.value);
    params.append("p110serie", p110serie.value);
    params.append("cdusuario", cdusuario.value);
    params.append("senha", senha.value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/functions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                alert(xhr.responseText);
                window.location.href = window.location.pathname;
            } else {
                alert("Erro ao gravar a série. Tente novamente.");
            }
        }
    };
    xhr.send(params.toString());
}

// Função para validar os campos de produto e lote
function validarCampos() {
    const cmbprod = document.getElementById('cmbprod');
    const cmbLote = document.getElementById('cmbLote');

    if (cmbprod.value == 0) {
        alert("INFORME O PRODUTO.");
        cmbprod.focus();
        return false;
    }
    if (cmbLote.value == 0) {
        alert("INFORME O LOTE.");
        cmbLote.focus();
        return false;
    }

    return true;
}

// Função chamada ao clicar no botão
function chamaDefinirIntervalo() {

    if (!validarCampos()) {
        return false;
    }

    // Caso os campos sejam válidos, adia o redirecionamento com setTimeout
    const cmbprod = document.getElementById('cmbprod');
    const cmbLote = document.getElementById('cmbLote');

    // Log da URL com os parâmetros
    const url = "/app/Definicao_Serie_Intervalo.php?PRODUTO=" + cmbprod.value + "&LOTE=" + cmbLote.value;

    window.location.href = url;
}

// Função chamada ao clicar no botão
function chamaDefinirIntervaloLote() {

    if (!validarCampos()) {
        return false;
    }

    // Caso os campos sejam válidos, adia o redirecionamento com setTimeout
    const cmbprod = document.getElementById('cmbprod');
    const cmbLote = document.getElementById('cmbLote');

    // Log da URL com os parâmetros
    const url = "/app/Definicao_Serie_Intervalo_Lote.php?PRODUTO=" + cmbprod.value + "&LOTE=" + cmbLote.value;

    window.location.href = url;
}
</script>
</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formDefinicaoSerie' action="<?php echo $_SG['rf'] .'functions.php'; ?>" method="POST"
                    id="formDefinicaoSerie">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="produto" class="d-block">Produto:</label>
                            <div class="mt-2">
                                <?php echo RetornaCMBProdutosDefinicoes(); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="lote" class="d-block">Lote:</label>
                            <div class="mt-2" id="loteContainer">
                                <?php echo atualizaLoteDefinicao($produtoSelecionado); ?>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-primary"
                                onclick="pesquisaListaSerie()">Pesquisar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mt-5">
                            <a href="javascript:void(0);" class="btn btn-primary"
                                onclick="chamaDefinirIntervalo()">Definir
                                Série por Intervalo de Atividade</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-3">
                            <a href="javascript:void(0);" class="btn btn-primary"
                                onclick="chamaDefinirIntervaloLote()">Definir
                                Série por Intervalo de Lote/Número</a>
                        </div>
                    </div>
                    <br>
                    <div class=" row">
                        <div class="col-md-12">
                            <br>
                            <hr>
                            <input type="hidden" id="cdusuario" value="<?php echo $_SESSION['usuarioID']; ?>">
                            <table id="tblistadefinicao" class="display compact table-striped table-bordered"
                                style="width:100%; font-size:12px; font-family: Tahoma">
                                <thead style="background-color:#556295; color:#f2f3f7">
                                    <tr>
                                        <th>Lote/Número</th>
                                        <th>Médico Responsável</th>
                                        <th>UF</th>
                                        <th>Atividade(mCi)</th>
                                        <th>Série</th>
                                        <th>Produção</th>
                                        <th>Calibração</th>
                                        <th>Observação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo RetornaListaSerie($produto, $lote, $ordem); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Senha:</label>
                            <input type="password" name="txtSenha" id="txtSenha" class="form-control" maxlength="6"
                                size="7" required />
                        </div>
                        <div class="col-md-4">
                            <br>
                            <input type="submit" class="btn btn-primary" id="definirSerie" name="definirSerie"
                                onclick="definirSerieTable(event)" value="Gravar" required />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
include("../footer.php");
?>