<?

	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once "maininclude.php";

	//Criando a Lista de Sugestoes NeawLeads
	if(isset($_POST['queryString'])) 
	{
		$sql = "SELECT codlead, SUBSTRING(RazaoSocial,1,40) RazaoSocial, RazaoSocial RazaoSocial2 FROM leads 
				WHERE RazaoSocial LIKE '".$_POST['queryString']."%' order by RazaoSocial LIMIT 12";
		$res = sql_query($sql);
				
		if($res) 
		{		
			while($rs = mysql_fetch_array($res))
			if(isset($_POST['retorno'])) echo '<p>'.$rs['codlead'].' - '.$rs["RazaoSocial"].'</p>';
			else echo '<p>'.$rs['codlead'].' - '.$rs["RazaoSocial"].'</p>';
		
			mysql_free_result($res);
		}
	}

	include_once "desconectar.php";
?>
