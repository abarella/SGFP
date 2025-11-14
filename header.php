<?php
   include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
   protegePagina(); // Chama a função que protege a página
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="<?php echo $_SG['rf'] ?>dist/img/LogoIpen.gif" >
  <title>SGFP | IPEN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/fontawesome-free/css/all.css">
  <link rel="stylesheet" xhref="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
  <link rel="stylesheet" xhref="https://cdn.jsdelivr.net/npm/icomoon@1.0.0/style.css" >
  


  <!-- overlayScrollbars toast & sweetalert -->
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/overlayScrollbars/css/OverlayScrollbars.css">
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/toastr/toastr.min.css">
  
    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  
  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $_SG['rf'] ?>dist/css/adminlte.css">
  
  
</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <!--<a class="nav-link" data-widget="pushmenu" data-auto-collapse-size="968" href="#" role="button"><i class="fas fa-bars"></i></a>-->
      </li>

    </ul>
    <div class="applicationname-light flex-grow-1 text-center">SGCR - Folha de Produção</div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" >
      <li class="nav-item" >
        <a class="nav-link fg-white" data-widget="username" href="#" role="button">
          <i class="fas fa-user"></i>&nbsp;<?php echo $_SESSION['usuarioNome']; ?>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link fg-white" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
	  
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="<?php echo $_SG['rf'] ?>index.php" class="brand-link">
		<img src="<?php echo $_SG['rf'] ?>img/logo_novopP1.png" class="brand-image" alt="" />
		<span class="brand-text font-weight-light" 
           style="position:absolute; top:15px;">
                <img src="<?php echo $_SG['rf'] ?>img/logo_novopP2.png" class="brand-image" alt="" />
    </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          
          <li class="nav-header"><a href='/'>Início</a></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Distribuição R.P.
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">5</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/lista.php?produto=rd_ga67" class="nav-link ">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>GAL-IPEN</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/lista.php?produto=rd_mo" class="nav-link disabled">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>GERADOR IPEN-TEC</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/lista.php?produto=rd_i131" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>IOD-IPEN-131</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/lista.php?produto=rd_caps" class="nav-link disabled">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>CAPS-IPEN</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/lista.php?produto=rd_tl" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>CARD-IPEN</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-star"></i>
              <p>
                Outros
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">1</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appOutros/verificacela.php" class="nav-link">
                  <i class="fa fa-arrow-right fa-solid nav-icon"></i>
                  <p>Verificação de Cela</p>
                </a>
              </li>
            </ul>
          </li>







          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                Escala
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">2</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/escala_tarefas.php" class="nav-link">
                  <i class="fa fa-arrow-right fa-solid nav-icon"></i>
                  <p>Tarefas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>app/escala_semanal.php" class="nav-link">
                  <i class="fa fa-arrow-right fa-solid nav-icon"></i>
                  <p>Escala Semanal</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-search"></i>
              <p>
                Consultas
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">1</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appOutros/blindagemXpasta.php" class="nav-link">
                  <i class="fa fa-arrow-right fa-solid nav-icon"></i>
                  <p>Blindagem X Pasta</p>
                </a>
              </li>
            </ul>
          </li>

          

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Gestão de Usuários
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">7</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/DireitosUsuario.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Direito por Usuário</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/DireitosGrupo.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Direitos por Grupo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/Sistema.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Sistema</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/Programas.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Programas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/Grupos.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Grupos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/Area.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Área</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $_SG['rf'] ?>appUsuarios/AlterarSenha.php" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Alterar Senha</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?php echo $_SG['rf'] ?>logout.php" class="nav-link">
              <i class="nav-icon fa fa-sign-out"></i>
              <p>Logout</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/docs/ProjetoEtiquetas/index.html" target="_etiq" class="nav-link">
              <i class="nav-icon fa fa-book"></i>
              <p>Documentação Etiquetas</p>
            </a>
          </li>


          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <!--<h5 class="m-0">Dashboard</h5>-->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a class="nav-linka" data-widget="pushmenu" data-auto-collapse-size="968" href="#" role="button"><i class="fas fa-bars"></i></a>
              &nbsp;<a href="/">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $_SESSION['nome_da_tela']; ?></li>
            </ol>
          </div>          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form1" name="form1" method="post" action="#" target="processa">
        	<input type="text" id="campo" name="campo" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="save" class="btn btn-primary" onclick="toastTeste()"  form="form1">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <!-- /.col -->
          <div class="col-12 col-sm-12 col-md-12">
            <div class="container-fluid mb-12">
				
			
