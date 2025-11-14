<?php
/**
* Sistema de segurança com acesso restrito
* Usado para restringir o acesso de certas páginas do seu site
* @author Alberto Barella Jr <alberto@abjinfo.com.br>
* @link https://abjinfo.com.br/
* @version 1.0
* @package SistemaSeguranca
*/

//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = false;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = false;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'alberto' é diferente de 'ALBERTO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['rf'] =  "http://".$_SERVER['HTTP_HOST']."/";
//$_SG['report_site'] = "'http://colibriapp:8084/'";
$_SG['report_site'] = "'http://hm-relatorios.ipen.br/gerenciador/report/SGCR/'";
$_SG['paginaLogin'] = $_SG['rf'].'login.php'; // Página de login

$_SG['tabela'] = 'usuario';       // Nome da tabela onde os usuários são salvos
// ==============================



// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
  //$_SG['link'] = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
  //mysqli_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
  //$_SG['link'] =  PDO("sqlsrv:server = $_SG['servidor'];  Encrypt=No;   Database=$_SG['banco'];", $_SG['usuario'], $_SG['senha']);

  //$tsql = "SELECT @@Version AS SQL_VERSION";

	//if ($conn->connect_error) {
	//die("Connection failed: " . $conn->connect_error);
	//}
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  $timeout = 8;
  ini_set( "session.gc_maxlifetime", $timeout );
  ini_set( "session.cookie_lifetime", $timeout );
  
  session_start();
  $_SESSION['PATH_RELATORIO'] = 'http://hm-relatorios.ipen.br/gerenciador/report/SGCR/';



  //echo "<script>alert(".$_SESSION["timeout"].")</script>";
  if(time() - $_SESSION["timeout"] > 10000){ 
    unset($_SESSION["timeout"]);
    expulsaVisitante();
  }

/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
  global $_SG;

  include('lib/DB.php');

  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);

  // Monta uma consulta SQL (query) para procurar um usuário

  //$sql = 'SELECT top 1 id, nome FROM usuario where usuario = \'' . $nusuario . '\' and senha = \'' . $nsenha . '\'';
  $sql = "exec crsa.uspP1110_Login  @login = '" . $nusuario . "' , @p1110_senha = '" . $nsenha . "', @grupo='', @resulta='', @mensa='' ";
  $stmt = $conn->query($sql);
  $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


  // Verifica se encontrou algum registro
  if (empty($resultado)) {
      return false;
  } else {
    $_SESSION['usuarioID'] = $resultado['cdusuario']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNome'] = $nusuario; // Pega o valor da coluna 'nome' do registro encontrado no MySQL

    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
        $_SESSION['usuarioLogin'] = $usuario;
        $_SESSION['usuarioSenha'] = $senha;
    }

    $_SESSION['nome_da_tela'] = 'inicial';

    return true;
  }
}



/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;

  if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;

  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);

  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}
