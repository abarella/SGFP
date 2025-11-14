<script>
    function abrePg(_pg){
        
        const params = new URLSearchParams(window.location.search)


        if(_pg=='f01'){window.open('LimpezaCela.php'+'?'+params, '_self')}
        if(_pg=='f02'){window.open('LiberaAreaTrab.php'+'?'+params, '_self')}
        if(_pg=='f03'){window.open('EmbPrimaria.php'+'?'+params, '_self')}
        if(_pg=='f04'){window.open('Equipamentos.php'+'?'+params, '_self')}
        if(_pg=='f05'){window.open('Materiais.php'+'?'+params, '_self')}
        if(_pg=='f06'){window.open('InfRadio.php'+'?'+params, '_self')}
        if(_pg=='f07'){window.open('PedidoInterno.php'+'?'+params, '_self')}
        if(_pg=='f08'){window.open('Diluicoes.php'+'?'+params, '_self')}
        if(_pg=='f09'){window.open('ReconMateriais.php'+'?'+params, '_self')}
        if(_pg=='f10'){window.open('RendProcesso.php'+'?'+params, '_self')}
        if(_pg=='f11'){window.open('Operadores.php'+'?'+params, '_self')}
        if(_pg=='f12'){window.open('Observacoes.php'+'?'+params, '_self')}
        if(_pg=='f13'){window.open('FracCliente.php'+'?'+params, '_self')}
        if(_pg=='f14'){window.open('Solicitadas.php'+'?'+params, '_self')}
        if(_pg=='f15'){window.open('RD.php'+'?'+params, '_self')}
        if(_pg=='f16'){window.open('GQ.php'+'?'+params, '_self')}

        if(_pg=='f17'){window.open('DiluicoesTalio.php'+'?'+params, '_self')} //diluição talio
        if(_pg=='f18'){window.open('GQ.php'+'?'+params, '_self')} //esterilização talio
        if(_pg=='f19'){window.open('Amostras.php'+'?'+params, '_self')} //Amostras talio
        if(_pg=='f20'){window.open('GQ.php'+'?'+params, '_self')} //Fracionamento Emb. Primaria talio
        if(_pg=='f21'){window.open('ReconMateriais.php'+'?'+params, '_self')} //Reconciliação de materiais talio

        if(_pg=='f22'){window.open('DiluicoesGalio.php'+'?'+params, '_self')}

    }
</script>


<?php if ($_GET['produto'] == 'rd_i131') { ?>
<!-- Nav tabs IODO -->
<div class="btn-group btn-block btn-flat ">
    <button type="button" id="f01" class="btn btn-outline-info btn-xs" onclick="abrePg('f01')">Verificação & Limpeza da Cela</button>
    <button type="button" id="f02" class="btn btn-outline-info btn-xs" onclick="abrePg('f02')">Liber. Área de Trabalho & Embalagem Primária</button>
    <button type="button" id="f04" class="btn btn-outline-info btn-xs" onclick="abrePg('f04')">Equipamentos</button>
    <button type="button" id="f05" class="btn btn-outline-info btn-xs" onclick="abrePg('f05')">Materiais</button>
    <button type="button" id="f06" class="btn btn-outline-info btn-xs" onclick="abrePg('f06')">Inf. Radioisótopos</button>
    <button type="button" id="f07" class="btn btn-outline-info btn-xs" onclick="abrePg('f07')">Pedido Interno</button>
    <button type="button" id="f19" class="btn btn-outline-info btn-xs" onclick="abrePg('f19')">Amostras</button>
    
</div>
<div class="btn-group btn-block btn-flat">
    <button type="button" id="f08" class="btn btn-outline-info btn-xs" onclick="abrePg('f08')">Procedimentos</button>
    <button type="button" id="f09" class="btn btn-outline-info btn-xs" onclick="abrePg('f09')">Reconciliação Materiais</button>
    <button type="button" id="f10" class="btn btn-outline-info btn-xs" onclick="abrePg('f10')">Rendimento do Processo</button>
    <button type="button" id="f11" class="btn btn-outline-info btn-xs" onclick="abrePg('f11')">Operadores Participantes</button>
    <button type="button" id="f12" class="btn btn-outline-info btn-xs" onclick="abrePg('f12')">Observações</button>
    <button type="button" id="f13" class="btn btn-outline-info btn-xs" onclick="abrePg('f13')">Fracionamento Cliente</button>
    <button type="button" id="f14" class="btn btn-outline-info btn-xs" onclick="abrePg('f14')">Solicitadas</button>
</div>

<?php } ?>



<?php if ($_GET['produto'] == 'rd_tl') { ?>
    <!-- Nav tabs TALIO -->
    <div class="btn-group btn-block btn-flat ">
        <button type="button" id="f01" class="btn btn-outline-info btn-xs" onclick="abrePg('f01')">Verificação & Limpeza da Cela</button>
        <button type="button" id="f02" class="btn btn-outline-info btn-xs" onclick="abrePg('f02')">Liber. Área de Trabalho & Embalagem Primária</button>
        <button type="button" id="f04" class="btn btn-outline-info btn-xs" onclick="abrePg('f04')">Equipamentos</button>
        <button type="button" id="f05" class="btn btn-outline-info btn-xs" onclick="abrePg('f05')">Materiais</button>
        <button type="button" id="f06" class="btn btn-outline-info btn-xs" onclick="abrePg('f06')">Inf. Radioisótopos</button>
        
    </div>
    <div class="btn-group btn-block btn-flat ">
        <button type="button" id="f17" class="btn btn-outline-info btn-xs" onclick="abrePg('f17')">Procedimentos</button>
        <button type="button" id="f19" class="btn btn-outline-info btn-xs" onclick="abrePg('f19')">Amostras</button>
        <button type="button" id="f21" class="btn btn-outline-info btn-xs" onclick="abrePg('f21')">Reconciliação</button>
        <button type="button" id="f11" class="btn btn-outline-info btn-xs" onclick="abrePg('f11')">Operadores Participantes</button>
        <button type="button" id="f12" class="btn btn-outline-info btn-xs" onclick="abrePg('f12')">Observações</button>
        <button type="button" id="f13" class="btn btn-outline-info btn-xs" onclick="abrePg('f13')">Fracionamento Cliente</button>
        <button type="button" id="f14" class="btn btn-outline-info btn-xs" onclick="abrePg('f14')">Solicitadas</button>

    </div>        
<?php } ?>


<?php if ($_GET['produto'] == 'rd_ga67') { ?>
<!-- Nav tabs IODO -->
<div class="btn-group btn-block btn-flat ">
    <button type="button" id="f01" class="btn btn-outline-info btn-xs" onclick="abrePg('f01')">Verificação & Limpeza da Cela</button>
    <button type="button" id="f02" class="btn btn-outline-info btn-xs" onclick="abrePg('f02')">Liber. Área de Trabalho & Embalagem Primária</button>
    <button type="button" id="f04" class="btn btn-outline-info btn-xs" onclick="abrePg('f04')">Equipamentos</button>
    <button type="button" id="f05" class="btn btn-outline-info btn-xs" onclick="abrePg('f05')">Materiais</button>
    <button type="button" id="f06" class="btn btn-outline-info btn-xs" onclick="abrePg('f06')">Inf. Radioisótopos</button>
    <button type="button" id="f07" class="btn btn-outline-info btn-xs" onclick="abrePg('f07')">Pedido Interno</button>
    <button type="button" id="f19" class="btn btn-outline-info btn-xs" onclick="abrePg('f19')">Amostras</button>
    
</div>
<div class="btn-group btn-block btn-flat">
    <button type="button" id="f22" class="btn btn-outline-info btn-xs" onclick="abrePg('f22')">Procedimentos</button>
    <button type="button" id="f09" class="btn btn-outline-info btn-xs" onclick="abrePg('f09')">Rend. Produção & Reconciliação</button>
    <button type="button" id="f10" class="btn btn-outline-info btn-xs" onclick="abrePg('f10')">Rendimento do Processo</button>
    <button type="button" id="f11" class="btn btn-outline-info btn-xs" onclick="abrePg('f11')">Operadores Participantes</button>
    <button type="button" id="f12" class="btn btn-outline-info btn-xs" onclick="abrePg('f12')">Observações</button>
    <button type="button" id="f13" class="btn btn-outline-info btn-xs" onclick="abrePg('f13')">Fracionamento Cliente</button>
    <button type="button" id="f14" class="btn btn-outline-info btn-xs" onclick="abrePg('f14')">Solicitadas</button>
</div>

<?php } ?>