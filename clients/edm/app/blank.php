<?
include_once "libs/conectar.php";

conectar(0);

if($_SESSION['codusuario'] != ""){
	if($_SESSION['primeirologin'] == ""){
		//Verifica se o grupo do usu�rio logado � administrador do sistema.
		$sql ="";
		$sql.="select * from gruposusuariosinternos_usuariosinternos where codusuariointerno = ".$_SESSION['codusuario']." and codgrupousuariointerno = 1 ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo "<script>location.href = 'paineis/home/home.php'</script>";
			$_SESSION['primeirologin'] = 1;
		}
		mysql_free_result($result);
	}
}

$sql = "Select e.largura, e.altura ";
$sql.= "  from empresa e ";
$sql.= " where e.cod_tipo_empresa=1";
$result = mysql_query($sql);
if($row = mysql_fetch_array($result)){
	array_merge($row, $_REQUEST);
	$_REQUEST = $row;
}	


mysql_free_result($result);

?>
<html>
<head>
	<title>Gepros</title>
</head>
<body>
<table border="0" width="100%" height="90%">
	<tr valign="middle">
		<td width="25%" >&nbsp;
			
		</td>	
		<td valign="middle" >

				<?
				
				if ($_SESSION['codusuario'] == "") {?>
					&nbsp;&nbsp;&nbsp;<img src='images/logo/logo.png' width='<?=@$_REQUEST['largura'];?>' height="<?=@$_REQUEST['altura'];?>" >
				<?}else{?>		
						<img src='images/logo/logo.png'  width='<?=@$_REQUEST['largura'];?>' height="<?=@$_REQUEST['altura'];?>" >	
				<?}?>		
			</td>
	  <td>&nbsp;			
		</td>	
	</tr>
</table>
</body>
</html>

