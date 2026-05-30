<?php
/*
Pagina:estornores.php
modulo:Operações
submodulo: Transferencia de Leads
Dados de criação
Criação: 23/01/2009
Empresa: GEPROS
@autor: Rogério Avelino da Silva

*/

/*
 Includes
*/

    include_once( "../../libs/maininclude.php" ) ;
    include_once( "../../libs/combo.php" ) ;
    include_once( "../../libs/cla.logg.php" ) ;
    include_once( "../../libs/cla.ocorrencias.php" ) ;

	if( !permissao( 'produtos' , 'cs' ) )
	{
		javascriptalert( 'Você não tem permissão para acessar esta página!!!' ) ;
		exit ;
	}

	if ( !empty( $_REQUEST['enviar'] ) && !empty( $_REQUEST['codcontaDe'] ) && !empty( $_REQUEST['codcontaPara'] ) && !empty( $_REQUEST['status'] ) )
	{
		$consultorDe    = $_REQUEST['codcontaDe'   ] ;
		$consultorPara  = $_REQUEST['codcontaPara' ] ;

		$status = implode( ',' , $_REQUEST['status'] ) ;

		$sql = "UPDATE leads
				   SET CodGerenteConta = {$consultorPara}
				 WHERE CodGerenteConta = {$consultorDe}
				   AND CodStatusClassificacaoLead IN( {$status} )" ;

		sql_query( $sql ) ;

		$sql = "SELECT CodLead
				  FROM leads
				 WHERE CodGerenteConta = {$consultorDe}
				   AND CodStatusClassificacaoLead IN( {$status} )" ;
		$qry = sql_query( $sql ) ;

		while( $res = mysql_fetch_object( $qry ) )
		{
			$valores = array( 'codusuariointerno' => $_SESSION['codusuario'] , 'codlead' =>  $res->CodLead , 'codtipoocorrencialead' => 77 ) ;
			ocorrencias::adicionar( $valores ) ;
			$desc = "De $consultorDe para $consultorPara";
			logg::insert( 9 , $res->CodLead , $desc ) ;
		}

		javascriptalert( 'Alteração feita com sucesso.' , false ) ;
		exit() ;

	}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../libs/public1.css" type="text/css">
<?	include_once( "../../libs/head.php" ) ; ?>
<script language="JavaScript" type="text/javascript">
function valida( frm )
{
	var j = 0 ;
	for ( var i = 0 ; i < frm.elements.length ; i++ )
	{
		if ( frm.elements[i].type == 'select-one' && frm.elements[i].value == '' )
		{
			alert( 'Selecione o consultor.' ) ;
			return false ;
		}
		else if ( frm.elements[i].type == 'checkbox' && frm.elements[i].checked )
			j++ ;
	}
	if( j == 0 )
	{
		alert( 'Selecione o Status.' )
		return false ;
	}
	if( frm.codcontaDe.value == frm.codcontaPara.value )
	{
		alert( 'Os consultores são iguais.' ) ;
		return false ;
	}
}
</script>
</head>
<body class="corpo">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			Tranferir Leads
		</td>
	</tr>
</table>
<form action="transleadsres.php" method="POST" name="form" onsubmit="return valida( this );">
<table width="100%" height="100%"  align="center" cellpadding="1" cellspacing="2" class="form" style="margin-top:50px;">
   	<tr>
      	<td>
      		Tranferir de:
      	</td>

<?
	$sql = "SELECT DISTINCT CodUsuarioInterno , Nome , Desativado
			  FROM usuariosinternos u
		INNER JOIN leads l
		     	ON u.CodUsuarioInterno = l.CodGerenteConta
		     WHERE l.CodStatusClassificacaoLead
		        IN (4, 5, 6)
		  ORDER BY Desativado , Nome " ;

	$tipos[0]['valor'] = '-1';
	$tipos[1]['valor'] = 1;
	$tipos[0]['style'] = 'color:#009900';
	$tipos[1]['style'] = 'color:#990000';
	$tipos['max'] = 2;
?>
		<td>
<?
			combo_tipos( $sql , "codcontaDe" , $tipos , "" , "-- Selecione --" , "" ) ;
?>
		</td>
		<td>
			para
		</td>
		<td>
<?
			combo_tipos( $sql , "codcontaPara" , $tipos , "" , "-- Selecione --" , "" ) ;
?>
		</td>
	</tr>
	<tr>
		<th colspan="4">
			Status:
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center">
			<input name="status[]" id="tgt"   type="checkbox" value="2" />Tgt &nbsp;
			<input name="status[]" id="led0"  type="checkbox" value="3" />0% &nbsp;
			<input name="status[]" id="led25" type="checkbox" value="4" />25% &nbsp;
			<input name="status[]" id="led50" type="checkbox" value="5" />50% &nbsp;
<?
	if( $_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip' )
	{
?>
			<input name="status[]" id="for75env" type="checkbox" onclick="document.getElementById('for75nao').checked=false;" value="6" />75% (Enviado Claro) &nbsp;
<?
	}
?>
			<input name="status[]" id="for75nao" type="checkbox" onclick="document.getElementById('for75env').checked=false;" value="7" />75% <? if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip'){ ?>(N&atilde;o Enviado Claro)<? }else{ ?> &nbsp; <? } ?>

		</td>
	</tr>
	<tr>
		<td colspan="4" align="center" style="padding-top:25px;">
			<input type="submit" name="enviar" value="Enviar" />
		</td>
	</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
