
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title></title>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" xhref="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />  



  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="topo-login">
	<img src="LogoIpenDocB.svg" style="position:absolute;  height: 6.0vw; 6.0vw; top:-21px" />
	<span class="program-login">S.G.F.P.</span>
</div>


  
  <div class="container">
    <div class="szlogin border">&nbsp;<i class="fa fa-user"></i>&nbsp;Login</div>
    <span class="error animated tada" id="msg"></span>
    <form id="form_login" name="form1" class="form-control row-fluid" method="post" action="valida.php" >
        <input type="text" name="usuario" placeholder="Usuário" class="box" autocomplete="off"><br><br>
        <i class="typcn typcn-eye" id="eye"></i>
        <input type="password" name="senha" placeholder="Senha" id="pwd" autocomplete="off"><br><br>
        <input type="submit" value="Login" class="btn btn-danger btn-sm btn-block w-100 ">
      </form>
  </div>
  



  


<div class="footer">Sistema Gerenciador de Folha de Produção</div>

<script  src="login.js"></script>
  <?php include('include/script.php'); ?>
</body>
</html>
