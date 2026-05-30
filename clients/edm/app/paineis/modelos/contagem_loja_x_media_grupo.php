<?

include_once "../libs/maininclude.php";

$sites_pk = $_REQUEST['sites_pk'];

//Determina quais datas serão trabalhadas.
$arrDatas = array();
for ($i = 31; $i >= 0; $i-- ){
	$arrDatas[] = DataYMD(SubtrairData(hoje(),$i * (-1), 0, 0));
	
}
$dt_inicio = $arrDatas[0];
$dt_fim = $arrDatas[count($arrDatas)-1];



$strGrafico.="<chart lineThickness='1' showValues='0' formatNumberScale='0' anchorRadius='2'  divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' shadowAlpha='40' labelStep='2' numvdivlines='30' chartRightMargin='35'  bgAngle='270' bgAlpha='10,10' rotateNames='1' > \n";
$strGrafico.="<categories > \n";
foreach($arrDatas as $data){
	$strGrafico.="<category label='".DataDMY($data)."' /> \n";	
}
$strGrafico.="";
$strGrafico.="</categories> \n";

$strGrafico.="<dataset seriesName='Contagem Loja' color='1D8BD1' anchorBorderColor='1D8BD1' anchorBgColor='1D8BD1'> \n";

foreach($arrDatas as $data){
	$sql ="";
	$sql.="select sum(enters) total ";
	$sql.="  from count cc ";
	$sql.="       inner join cameras cm on cc.macaddress = cm.ds_macaddress ";
	$sql.=" where cc.starttime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$sql.="   and cm.sites_pk = $sites_pk ";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	$total = $row['total'];
	mysql_free_result($result);	
	
	$sql ="";
	$sql.="select n_qtde_desconto ";
	$sql.="  from sites_datas_descontos sdd ";
	$sql.=" where sdd.sites_pk = $sites_pk ";
	$sql.="   and dt_desconto = '".$data."' ";
	$rs_desconto = mysql_query($sql);
	$num = mysql_num_rows($rs_desconto);
	if($num > 0){
		$row_desconto = mysql_fetch_array($rs_desconto);
		$total -= $row_desconto['n_qtde_desconto'];
	}
	else{
		$sql ="";
		$sql.="select n_qtde_desconto ";
		$sql.="  from sites_desconto_padrao sdp ";
		$sql.=" where sdp.sites_pk = $sites_pk ";
		$sql.="   and '".$data."' between sdp.dt_desconto_ini and sdp.dt_desconto_fim ";
		$rs_desconto_padrao = mysql_query($sql);
		while($row_desconto_padrao = mysql_fetch_array($rs_desconto_padrao)){
			$total -= $row_desconto_padrao['n_qtde_desconto'];
			break;
		}
		mysql_free_result($rs_desconto_padrao);
	}
	mysql_free_result($rs_desconto);
		
	if($total > 0)
		$strGrafico.= "<set value='".$total."'/> \n";
	else
		$strGrafico.= "<set value='0'/> \n";	
	

}

$strGrafico.="</dataset> \n";
$strGrafico.="<dataset seriesName='Média Aritimética Grupo' color='#FFFF00' anchorBorderColor='#FFFF00' anchorBgColor='#FFFF00'> \n";

foreach($arrDatas as $data){

	

	$total = 0;

	$sql ="";
	$sql.="select s.pk, sum(enters) total ";
	$sql.="  from count cc ";
	$sql.="       inner join cameras cm on cc.macaddress = cm.ds_macaddress ";
	$sql.="       inner join sites s on cm.sites_pk = s.pk ";
	$sql.=" where cc.starttime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$sql.="   and s.pk <> $sites_pk ";
	$sql.="   and s.empresas_pk = ".$_SESSION['empresas_pk'];
	$sql.=" group by s.pk having sum(enters) > 0 ";
	
	$result = mysql_query($sql);
	$total_lojas = mysql_num_rows($result);	
	while($row = mysql_fetch_array($result)){
		$total += $row['total'];
		
		$sql ="";
		$sql.="select n_qtde_desconto ";
		$sql.="  from sites_datas_descontos sdd ";
		$sql.=" where sdd.pk = ".$row['pk'];
		$sql.="   and sdd.dt_desconto = '".$data."' ";
		
		$rs_desconto = mysql_query($sql);
		$num_desconto = mysql_num_rows($rs_desconto);
		if($num_desconto > 0){
			$row_desconto = mysql_fetch_array($rs_desconto);
			$total -= $row_desconto['n_qtde_desconto'];
		}
		else{
			$sql ="";
			$sql.="select n_qtde_desconto ";
			$sql.="  from sites_desconto_padrao sdp ";
			$sql.=" where sdp.sites_pk = ".$row['pk']." ";
			$sql.="   and '".$data."' between sdp.dt_desconto_ini and sdp.dt_desconto_fim ";
			$rs_desconto_padrao = mysql_query($sql);
			while($row_desconto_padrao = mysql_fetch_array($rs_desconto_padrao)){
				$total -= $row_desconto_padrao['n_qtde_desconto'];
				break;
			}
			mysql_free_result($rs_desconto_padrao);
		}
		mysql_free_result($rs_desconto);		
		
	}
	mysql_free_result($result);	
	
		
	if($total > 0)
		$strGrafico.= "<set value='".$total / $total_lojas."'/> \n";
	else
		$strGrafico.= "<set value='0'/> \n";	
	
}
$strGrafico.="	</dataset> \n";
$strGrafico.="";
$strGrafico.="	<styles> \n";
$strGrafico.="		<definition>";
$strGrafico.="";
$strGrafico.="			<style name='CaptionFont' type='font' size='12'/>";
$strGrafico.="		</definition>";
$strGrafico.="		<application>";
$strGrafico.="			<apply toObject='CAPTION' styles='CaptionFont' />";
$strGrafico.="			<apply toObject='SUBCAPTION' styles='CaptionFont' />";
$strGrafico.="		</application>";
$strGrafico.="	</styles>";
$strGrafico.="";
$strGrafico.="</chart>";


echo $strGrafico;

include_once "../libs/desconectar.php";

?>
