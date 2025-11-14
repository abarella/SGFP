<style>
thead input {
    width: 100%;
}

table.dataTable tbody td {
    vertical-align: top;
}
</style>

<script>
function obterParametro(nomeParametro) {
    const urlParams = new URLSearchParams(window.location.search);
    // Pegando o valor do parâmetro diretamente, se existir
    const valor = urlParams.get(nomeParametro);

    return valor;
}

// Define os valores corretamente quando a página carrega
document.addEventListener("DOMContentLoaded", function() {

    let txtProduto = document.getElementById('txtProduto');
    let txtLote = document.getElementById('txtLote');

    // Apenas define se os elementos existirem no DOM
    if (txtProduto) {
        txtProduto.value = obterParametro('PRODUTO');
        console.log("Produto atribuído:", txtProduto.value);
    } else {
        console.warn("Elemento txtProduto não encontrado no DOM.");
    }

    if (txtLote) {
        txtLote.value = obterParametro('LOTE');
        console.log("Lote atribuído:", txtLote.value);
    } else {
        console.warn("Elemento txtLote não encontrado no DOM.");
    }
});

function buscaSerie() {
    // Obter os parâmetros 'PRODUTO' e 'LOTE' da URL
    const produto = obterParametro('PRODUTO');
    const lote = obterParametro('LOTE');

    // Verificar se os parâmetros estão presentes
    if (!produto || !lote) {
        alert("Produto ou Lote não especificados na URL!");
        return;
    }

    // Obter os valores dos campos
    const produtoSelecionado = produto;
    const loteSelecionado = lote;

    // Verificar se os campos estão preenchidos
    if (produtoSelecionado == 0 || loteSelecionado == 0) {
        console.log("Produto ou Lote não selecionado. Exibindo alerta.");
        alert("Por favor, selecione o produto e o lote.");
        return;
    }

    // Criar objeto com os dados
    const dados = new FormData();
    dados.append('produtoSelecionado', produtoSelecionado);
    dados.append('loteSelecionado', loteSelecionado);
    dados.append('procurarSerie', '1');

    // Criar a requisição AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/functions.php', true);

    // Função de callback para tratar a resposta
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            console.log("Requisição finalizada.");
            if (xhr.status === 200) {
                // Exibir a resposta do servidor (sucesso ou erro)
                console.log('Resposta do servidor:', xhr.responseText);
                alert(xhr.responseText);
            } else {
                console.error('Erro na requisição AJAX:', xhr.status);
                alert('Ocorreu um erro ao processar sua solicitação.');
            }
        }
    };
    // Enviar os dados para o PHP
    xhr.send(dados);
}

function definirSerieAtividadeLoteTable(event) {
    event.preventDefault();

    // if (!validarCampos()) {
    //     return;
    // }

    let forca;
    const produto = txtProduto.value;
    const lote = txtLote.value;
    const serie = document.getElementById('cmbSerie').value;
    const tipo = 2;
    const inicio = document.getElementById('cmbLoteIni').value;
    const fim = document.getElementById('cmbLoteFim').value;
    const rdFiltro = document.getElementsByName('rdFiltro');
    const cdusuario = document.getElementById('cdusuario').value;
    const senha = document.getElementById('txtSenha').value;

    for (let i = 0; i < rdFiltro.length; i++) {
        if (rdFiltro[i].checked) {
            forca = rdFiltro[i].value;
            break;
        }
    }

    var params = new URLSearchParams();
    params.append("produto", produto);
    params.append("lote", lote);
    params.append("serie", serie);
    params.append("tipo", tipo);
    params.append("inicio", inicio);
    params.append("fim", fim);
    params.append("forca", forca);
    params.append("cdusuario", cdusuario);
    params.append("senha", senha);

    console.log(params.toString());

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/functions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                alert(xhr.responseText);
                window.history.back();
            } else {
                alert("Erro ao definir a série por data. Tente novamente.");
            }
        }
    };
    xhr.send(params.toString());
}

function paraTodos() {
    rdFiltro[0].checked = true;
    rdFiltro[1].checked = false;
}

function semSerie() {
    rdFiltro[0].checked = false;
    rdFiltro[1].checked = true;
}

function validarCampos() {
    // Validar Produto
    if (txtProduto.value.trim() === "") {
        alert("INFORME O PRODUTO!");
        txtProduto.focus();
        return false;
    }

    // Validar Lote
    if (txtLote.value.trim() === "") {
        alert("INFORME O LOTE!");
        txtLote.focus();
        return false;
    }

    // Validar Série
    const serie = document.getElementById('cmbSerie').value;
    if (serie === "" || serie == 0) {
        alert("INFORME A SÉRIE!");
        document.getElementById('cmbSerie').focus();
        return false;
    }

    // Validar Atividade Inicial
    const inicio = document.getElementById('cmbLoteIni').value;
    if (inicio === "") {
        alert("INFORME A ATIVIDADE INICIAL!");
        document.getElementById('cmbLoteIni').focus();
        return false;
    }

    // Validar Atividade Final
    const fim = document.getElementById('cmbLoteFim').value;
    if (fim === "") {
        alert("INFORME A ATIVIDADE FINAL!");
        document.getElementById('cmbLoteFim').focus();
        return false;
    }

    // Validar se Atividade Inicial não é maior que a Final
    if (inicio > fim) {
        alert("A ATIVIDADE INICIAL NÃO PODE SER MAIOR DO QUE A FINAL!");
        document.getElementById('cmbLoteIni').focus();
        return false;
    }

    // Validar Força (um dos rádios precisa ser selecionado)
    const rdFiltro = document.getElementsByName('rdFiltro');
    let forcaValidada = false;
    for (let i = 0; i < rdFiltro.length; i++) {
        if (rdFiltro[i].checked) {
            forcaValidada = true;
            break;
        }
    }
    if (!forcaValidada) {
        alert("INFORME O FILTRO!");
        rdFiltro[0].focus();
        return false;
    }

    // Validar Técnico
    const cmbTecnico = document.getElementById('cmbTecnico').value;
    if (cmbTecnico === "") {
        alert("INFORME O TÉCNICO OPERADOR!");
        document.getElementById('cmbTecnico').focus();
        return false;
    }

    // Validar Senha
    const senha = document.getElementById('txtSenha').value;
    if (senha === "") {
        alert("INFORME A SENHA!");
        document.getElementById('txtSenha').focus();
        return false;
    }

    return true;
}
</script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- inicio do conteúdo -->
                <form name='formDefinicaoSerie' action="<?php echo $_SG['rf'] .'functions.php'; ?>" method="POST"
                    id="formDefinicaoSerie">
                    <input type="hidden" id="cdusuario" value="<?php echo $_SESSION['usuarioID']; ?>">
                    <input type="hidden" id="txtProduto" />
                    <input type="hidden" id="txtLote" />
                    <div class=" row">
                        <div class="col-md-3">
                            <label for="produto" class="d-block">Série:</label>
                            <div class="mt-2">
                                <?php echo carregaSerie($produtoSelecionado, $loteSelecionado); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-4">
                            <label for="cmbLoteIni" class="d-block">Lote/Número Inicial:</label>
                            <select id="cmbLoteIni" class="form-control mt-2">
                                <?php
                                    for ($i = 1; $i <= 200; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mt-4">
                            <label for="cmbLoteFim" class="d-block">Lote/Número Final:</label>
                            <select id="cmbLoteFim" class="form-control mt-2">
                                <?php
                                    for ($i = 1; $i <= 200; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-4">
                            <label class="d-block" style="display: inline-block; margin-right: 10px;">Filtro:</label>
                            <div class="mt-2" style="display: inline-block;">
                                <div class="form-check" style="display: inline-block; margin-right: 10px;">
                                    <input class="form-check-input" type="radio" name="rdFiltro" id="rdFiltro" value="S"
                                        onclick="paraTodos()">
                                    <label class="form-check-label" for="rdFiltro">
                                        Para todos
                                    </label>
                                </div>
                                <div class="form-check" style="display: inline-block;">
                                    <input class="form-check-input" type="radio" name="rdFiltro" id="rdFiltro" value="N"
                                        checked onclick="semSerie()">
                                    <label class="form-check-label" for="rdFiltro">
                                        Somente os sem série
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mt-4">
                            <label for="tecnico" class="d-block">Técnico Operador:</label>
                            <div class="mt-2">
                                <?php echo carregaTecnicoDefinicao(); ?>
                            </div>
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
                            <input type="submit" class="btn btn-primary" id="definirSerieAtividadeLote"
                                name="definirSerieAtividadeLote" onclick="definirSerieAtividadeLoteTable(event)"
                                value="Gravar" required />
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