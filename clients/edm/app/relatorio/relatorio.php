<?
	//Variaveis
	//$codgerenteconta = null;
	//$mailing  = null;
	//$datastatusde = null;
	//$datastatusate = null;
	//Recebe valor
	//$codgerenteconta = $_REQUEST['codgerenteconta'];
	//$mailing  = $_REQUEST['mailing'];
	//$datastatusde = $_REQUEST['datastatusde'];
	//$datastatusate = $_REQUEST['datastatusate'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE></TITLE>
<FRAMESET ROWS="60,*">
<?	$link = "rel_top.php?Acao=CONS";
	foreach($_GET as $nome => $parametro){
		if($nome != 'Acao') $link .= "&".$nome."=".$parametro;
	}
	?>
	<FRAME SRC="<?=$link;?>" NAME="topo" frameborder=no>
	<FRAME SRC="../branco.html" NAME="Resultado" frameborder=no>
</FRAMESET><noframes></noframes>
</HEAD>
</HTML>

