<?

include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;
include_once( "../../libs/cla.equipes.php" ) ;

$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$recebe_assinaturade = $_REQUEST['recebe_assinaturade'];
$recebe_assinaturaate = $_REQUEST['recebe_assinaturaate'];
$envio_contrato_operadorade = $_REQUEST['envio_contrato_operadorade'];
$envio_contrato_operadoraate = $_REQUEST['envio_contrato_operadoraate'];

//Define qual data será utilizada.
if(!empty($recebe_assinaturade))
	$nome_data = "recebe_assinatura";
else
	$nome_data = "envio_contrato_operadora";
	
//pega as datas;
if($nome_data == 'recebe_assinatura'){
	$dataini = DataYMD($recebe_assinaturade);
	$datafim = DataYMD($recebe_assinaturaate);
}
else{
	$dataini = DataYMD($envio_contrato_operadorade);
	$datafim = DataYMD($envio_contrato_operadoraate);
}

$arrTotal = array();

$arrDiaSemana = array();

$arrDiaSemana[1] = "Dom";
$arrDiaSemana[2] = "Seg";
$arrDiaSemana[3] = "Ter";
$arrDiaSemana[4] = "Qua";
$arrDiaSemana[5] = "Qui";
$arrDiaSemana[6] = "Sex";
$arrDiaSemana[7] = "Sáb";

?>
<html>
<head>
	<title>Quadro de Vendas Consultor</title>
	<meta http-equiv="Refresh" content="600" />
</head>

<body leftmargin="0" bottommargin="0" rightmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="White">
	<tr nowrap>
		<td bgcolor='#003163' align='center'>
			<font color='White' face='Arial' style='font-size : 20px;'><b>Consultor</b></font>
		</td>
		<?
		//carrega todos os dias do intervalo das datas.
		$sql ="";
		$sql.=" SELECT DATEDIFF('$datafim 23:59:59','$dataini') diferenca ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$qtde_dias = $row['diferenca'];
		mysql_free_result($result);
		
		for($i = 0; $i<=$qtde_dias;$i++){
			echo "<td bgcolor='#003163' align='center'>";
			
			//pega os dias da semana.
			$sql ="";
			$sql.=" SELECT DAYOFWEEK(DATE_ADD('$dataini', INTERVAL $i DAY)) dia, DATE_FORMAT(DATE_ADD('$dataini', INTERVAL $i DAY),'%d/%m') diames ";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$dia = $arrDiaSemana[$row['dia']]."<br>(".$row['diames'].")";
			mysql_free_result($result);
			
			echo "<font color='White' face='Arial' style='font-size : 20px;'><b>$dia</b></font>";
			echo "</td>";
			
			//zera os totais;
			$arrTotal[$i] = 0;
			
		}
		
		?>
		<td bgcolor='#003163' align='center'>
			<font color='White' face='Arial' style='font-size : 20px;'><b>Total</b></font>
		</td>		
	</tr>
	<?
	
	$indice = 0;
	$total_geral = 0;
	
	//carrega todos os consultores
	$sql ="";
	$sql.="Select ui.nome consultor, ui.codusuariointerno ";
	$sql.="  from usuariosinternos ui ";
	$sql.=" where gerentecontas = 1 ";
	//$sql.="   and codusuariointerno in (select fk_usuario from tb_usuarioequipe  where fk_equipe =  ".$row_equipe['cod_equipe'].") ";
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	if(!empty($codgerenteconta))
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";

	if($status_usuario != ""){
		$sql.=" and ui.desativado = $status_usuario ";
	}

	$sql.=" order by ui.nome ";

	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		if($indice == 0){
			$tr = "<tr bgcolor='Yellow'>";
			$font = "<font face='Arial' style='font-size : 26px;'>";
		}
		if($indice == 1){
			$tr = "<tr bgcolor='#FFFF63'>";
			$font = "<font face='Arial' style='font-size : 24px;'>";
		}
			
		if($indice == 2){
			$tr = "<tr bgcolor='#FFFF9C'>";
			$font = "<font face='Arial' style='font-size : 22px;'>";
		}
		if($indice == 3){
			$tr = "<tr bgcolor='#FFFFCE'>";
			$font = "<font face='Arial' style='font-size : 20px;'>";
		}
		
		if($indice > 3){
			$tr = "<tr>";
			$font = "<font face='Arial' style='font-size : 18px;'>";
		}
		
		echo $tr;
		echo "<td>$font".$row['consultor']."</font></td>";
		
		//adiciona os totais por data.
		for($i = 0; $i<=$qtde_dias;$i++){
			
			//pega os dias da semana.
			$sql ="";
			$sql.=" SELECT DATE_FORMAT(DATE_ADD('$dataini', INTERVAL $i DAY),'%Y-%m-%d') data ";
			$rs_data = mysql_query($sql);
			$row_data = mysql_fetch_array($rs_data);
			$data = $row_data['data'];
			mysql_free_result($rs_data);
			
			//pequisa o total do consultor por dia.
			/*$sql ="";
			$sql.="select ui.codusuariointerno, sum(mp.calculado) total ";
			$sql.="  from usuariosinternos ui ";
			$sql.="       inner join leads l on l.codgerenteconta = ui.codusuariointerno ";
			$sql.="       inner join propostas p on l.codlead = p.codlead ";
			$sql.="       inner join data_proposta dp on (dp.codproposta = p.codproposta and dp.codlead = p.codlead and dp.versao = p.versao) ";
			$sql.="       inner join modulosproposta mp on (mp.codproposta = p.codproposta and mp.codlead = p.codlead and mp.versao = p.versao) ";
			$sql.=" where mp.id = 'qtdelinhas' ";
			$sql.="   and dp.nome_data = '$nome_data' ";
			$sql.="   and dp.valor_data = '$data' ";
			$sql.="   and ui.codusuariointerno = ".$row['codusuariointerno'];
			$sql.=" group by ui.codusuariointerno ";*/
			
			$sql ="";
			$sql.="SELECT ui.codusuariointerno, sum(nip.n_qtde) total
				  FROM usuariosinternos ui
					   INNER JOIN leads l ON l.codgerenteconta = ui.codusuariointerno
					   INNER JOIN n_propostas np ON l.CodLead = np.leads_pk
					   INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
					   INNER JOIN n_data_proposta_operador ndpo
						  ON ndp.data_proposta_operador_pk = ndpo.pk
					   INNER JOIN n_itens_propostas nip ON nip.propostas_pk = np.pk
					   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk					   
				 WHERE     ndpo.ds_label_data = 'previsao_recebe_assinatura'
					   AND ndp.vl_data_proposta = '$data' 
					   npr.produtos_tipo_pk = 1";
			$sql.="   and ui.codusuariointerno = ".$row['codusuariointerno'];
			$sql.=" group by ui.codusuariointerno ";
			echo $sql."<br><br>";

			//echo $sql."<br><br>";
			$rs_valor = mysql_query($sql);
			$row_valor = mysql_fetch_array($rs_valor);
			$total_dia = $row_valor['total'];
			mysql_free_result($rs_valor);
			
			$arrTotal[$i] += $total_dia;
		
			echo "<td align='center'>$font $total_dia</font></td>";
			
			$total_geral += $total_dia;
			
		}
		
		echo "<td align='center'>$font".$row['total']."</font></td>";
		echo "</tr>";
		$indice ++;
	}
	mysql_free_result($result);
	?>
	<tr>
		<td bgcolor="#003163" align="center">
			<font color="White" face="Arial" style='font-size : 20px;'><b>Total</b></font>
		</td>
		<?
		for($i = 0; $i<=$qtde_dias;$i++){
			echo "<td bgcolor='#003163' align='center'>";
			echo "<font color='White' face='Arial' style='font-size : 20px;'><b>".$arrTotal[$i]."</b></font>";
			echo "</td>";
		}
		?>
		<td bgcolor='#003163' align='center'>
			<font color='White' face='Arial' style='font-size : 20px;'><b><?= $total_geral;?></b></font>
		</td>				
	</tr>
</table>


</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
