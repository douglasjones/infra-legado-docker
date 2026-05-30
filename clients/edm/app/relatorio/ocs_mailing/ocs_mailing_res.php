<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';

	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";

$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codusuariointerno = $_REQUEST['codusuariointerno'];
$dt_ocorrencia_ini = $_REQUEST['dt_ocorrencia_ini'];
$dt_ocorrencia_fim = $_REQUEST['dt_ocorrencia_fim'];
$mailing_pk = $_REQUEST['mailing_pk'];

?>
<html>
<head>
<!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}
?>
</head>
<!--HTML-->
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<br>
<?
}
?>
<table>
	<tr>
		<td class="form"><font size="4">Ocorrências X Mailing</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			Data Cadastro O.C.: <?= $dt_ocorrencia_ini; ?> à <?= $dt_ocorrencia_fim;?><br>
			<?
			if(!empty($codusuariointerno)){
			?>
			Usuário Cadastro: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codusuariointerno ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?><br>			
			<?
			if(!empty($codgerenteconta)){
			?>
			Consultor: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?><br>

			<?if(!empty($codatendente)){?>
			Atendente:
			<?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?>
			<br>

			<?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?>

			<br>

		</td>
	</tr>
</table>
<?

//Query com a consulta no banco de dados.
$sql ="";
$sql.="select m.dsc_mailing mailing, tol.descricao, count(*) total ";
$sql.="  from leads l ";
$sql.="       inner join ocorrenciaslead oc on l.codlead = oc.codlead ";
$sql.="       inner join tipoocorrenciaslead tol on oc.codtipoocorrencialead = tol.codtipoocorrencialead ";
$sql.=" 	  inner join mailing m on l.mailing_pk = pk";
$sql.=" where 1=1 ";

//Passagem dos parâmetros
if(!empty($codatendente))
	$sql.="   and l.codatendente = $codatendente ";
	
if(!empty($codgerenteconta))
	$sql.="   and l.codgerenteconta = $codgerenteconta ";
	
if(!empty($codusuariointerno))
	$sql.="   and oc.codusuariointerno = $codusuariointerno ";

if(!empty($dt_ocorrencia_ini))
	$sql.="   and oc.datacadastro >='".DataYMD($dt_ocorrencia_ini)." 00:00:00' ";

if(!empty($dt_ocorrencia_fim))
	$sql.="   and oc.datacadastro <='".DataYMD($dt_ocorrencia_fim)." 23:59:59' ";
	
if(!empty($mailing_pk))
	$sql.="   and l.mailing_pk = ".$mailing_pk;
	
$sql.=" group by tol.descricao, l.mailing ";


$results = array();
$locais  = array();

$res = mysql_query($sql);

//Montagem dos arrays
while($row = mysql_fetch_assoc($res)){
	$results[$row['mailing']][$row['descricao']] = $row;
	if(!in_array($row['descricao'], $locais)){
		$locais[] = $row['descricao'];
	}
}

?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<thead>
	<tr>
		<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Mailing
		</th>
        <?php
         foreach($locais as $local){
         	echo "<th class='titulo' bgcolor='#8080FF'>", $local, "</th>";
         }
         ?>		
	</tr>
	</thead>
	<tbody>
      <?
      
      $arrTotal = array();
                       
      foreach($results as $data => $row): 
      ?>
      <tr>
         <td class='form'><?php echo $data; ?></td>
         <?
         foreach($locais as $local){
         	if(array_key_exists($local, $row)){
         		echo '<td nowrap=true width=150 align="center" class="form">', $row[$local]['total'], '</td>';
         		//Calcula o total do relatório
         		$arrTotal[$local] += $row[$local]['total'];
         	} 
         	else{
         		echo '<td nowrap=true width=150 align="center">&nbsp;</td>';
         	}
         }
         ?>
      </tr>
      <?
      endforeach; 
      ?>
    </tbody>
    <tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Total: 
		</th>	
		<?
		foreach($locais as $local){
			echo "<th  class='titulo' bgcolor='#8080FF'>".$arrTotal[$local]."</th>";
		}
		?>
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>



