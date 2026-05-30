<?	setcookie('login_bp_000', '', time()-3600);
	session_start();
	$bd = $_SESSION['bd'];
	include_once "libs/conectar.php";
	mysql_select_db($bd);
	$sql = 'update login_table set IsOnline = 0, UltimaAcao = now() where CodUsuarioInterno = '.$_SESSION['codusuario'];
	mysql_query($sql) or die (mysql_error());
	session_destroy(); ?>
<script type="text/javascript" language="javascript">
	top.location.href = 'login.php'
</script>