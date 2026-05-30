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
	$codagendalead = $_REQUEST['codagendalead'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE></TITLE>
<FRAMESET ROWS="60,*">
	<FRAME SRC="formularioprint_top.php?Acao=CONS&codagendalead=<?=$codagendalead?>" NAME="topo" frameborder=no>
	<FRAME SRC="formularioprint_res.php?Acao=CONS&codagendalead=<?=$codagendalead?>" NAME="Resultado" frameborder=no>
</FRAMESET>
</HEAD>
</HTML>
