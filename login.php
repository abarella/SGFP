<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Sistema de Gerenciamento de Produtos e Serviços - Módulo Rejeitos</title>
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link xhref="bootstrap-ext/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link xhref="css/bootbox.custom.css" rel="stylesheet" type="text/css"/>
    <link xhref="css/fullcalendar.css" rel="stylesheet" type="text/css"/>
    <link xhref="css/fullcalendar.print.css" type="text/css" rel='stylesheet' media='print'/>
    <!--[if IE]>
    <link href="/ css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    <link xhref="css/googlefonts.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        xvar baseUrl = '';
        xvar moduleName = 'sca';
        xvar defaultModuleName = 'rejeitos';
        xvar cdGrupo = '';
    </script>

    <script type="text/javascript" xsrc="js/jquery/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" xsrc="js/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" xsrc="js/jquery/ui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" xsrc="js/jquery/ui/1.9.2/i18n/jquery.ui.datepicker-pt-BR.js"></script>
    <script type="text/javascript" xsrc="js/files/bootstrap.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/ui/jquery.bootbox.min.js"></script>

    <script type="text/javascript" xsrc="js/plugins/ui/jquery.easytabs.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/ui/jquery.collapsible.min.js"></script>

    <script type="text/javascript" xsrc="js/plugins/ui/jquery.fancybox.js"></script>


    <script type="text/javascript" xsrc="js/plugins/ui/jquery.timepicker.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/ui/fullcalendar/lib/moment.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/ui/fullcalendar/lang/pt-br.js"></script>

    <script type="text/javascript" xsrc="js/plugins/forms/jquery.uniform.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.inputlimiter.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.inputmask.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.validation.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.validationEngine-pt_BR.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.validationEngine.ext.js"></script>

    <script type="text/javascript" xsrc="js/plugins/forms/jquery.form.js"></script>
    <script type="text/javascript" xsrc="js/plugins/forms/jquery.maskMoney.js"></script>

    <script type="text/javascript" xsrc="js/plugins/tables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" xsrc="js/plugins/tables/jquery.dataTables.pt-br.js"></script>


    <script type="text/javascript" xsrc="js/phpjs/strings/number_format.min.js"></script>

    <script type="text/javascript" xsrc="js/files/functions.js"></script>
</head>

<body class="clean">

<!-- Fixed top -->
<div id="top">
    <div class="fixed">
        <a class="pull-left" href="#"><img
                src="img/logo_novo.png"></a>
        <div style="text-align: center; position: absolute; width: 100%; left: 0; top: 50%; transform: translateY(-50%);">
            <h4 class="hidden-phone" style="margin: 0; color: #fff; font-size: 1.8rem;">SGCR - Folha de Produção</h4>
        </div>
        <ul class="top-menu">
            <li>
            </li>
                    </ul>
    </div>
</div>
<!-- /fixed top -->


<!-- Content container -->
<div id="container">
        <!-- Content -->
    <div id="content">
                <!-- Conteúdo -->
        <div id="content-inner"><!-- Login block -->
<div class="login">
    <div class="navbar">
        <div class="navbar-inner">
            <h6><i class="icon-user"></i>Login</h6>
            <a title="Ajuda" href="#" class="pull-right label label-info" target="_top">
                <i class="icon-question-sign"></i>
            </a>
        </div>
    </div>
    <div class="well">
        <form action="valida.php" method="POST" class="row-fluid">
            <input type="hidden" name="redirect" value="/" id="redirect">            <div class="list">
                            </div>

            

            <div class="tab-content" style="border:0px;">
                <div class="tab-pane active" id="usuario-ipen" >
                    <input type="hidden" name="tipo_usuario" value="ipen" id="tipo_usuario"><input type="text" name="usuario" id="usuario" value="" class="span12" maxlength="60" placeholder="Usuário">                </div>
                <div class="tab-pane " id="cliente-externo">
                    <ul class="row-fluid">
                        <li class="span8">
                            <input type="hidden" name="tipo_usuario_externo" value="cliente_externo" disabled="disabled" id="tipo_usuario_externo"><input type="text" name="cod_cliente" id="cod_cliente" value="" class="span12" disabled="disabled" placeholder="Cód. Cliente" maxlength="60">                        </li>
                        <li class="span1 align-center">-</li>
                        <li class="span3">
                            <input type="text" name="cod_responsavel" id="cod_responsavel" value="" class="span12" disabled="disabled" placeholder="Respons." maxlength="2">                        </li>
                    </ul>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <input type="password" name="senha" id="senha" value="" class="span12" maxlength="60" placeholder="Senha">                </div>
            </div>
            <div class="login-btn"><input type="submit" value="Login" class="btn btn-danger btn-block" /></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="js/sca/login/index.js"></script>
<!-- /login block --></div>
        <!-- /Conteúdo -->
    </div>
    <!-- /content -->
</div>
<!-- /content container -->

<!-- Footer -->
<div id="footer">
    <div class="copyrights">&copy; 2024 IPEN - Instituto de Pesquisas Energéticas e Nucleares.</div>
</div>
<!-- /footer -->
</body>


</html>