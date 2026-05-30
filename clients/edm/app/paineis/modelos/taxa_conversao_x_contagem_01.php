<?

include_once "../libs/maininclude.php";

//Determina quais datas serão trabalhadas.
$arrDatas = array();
for ($i = 31; $i >= 0; $i-- ){
	$arrDatas[] = DataYMD(SubtrairData(DataDMY(hoje()),$i * (-1), 0, 0));
	
}
$dt_inicio = $arrDatas[0];
$dt_fim = $arrDatas[count($arrDatas)-1];

$strGrafico.= "<graph caption='' PYAxisName='Contagem' SYAxisName='Tx Conver. %' numberPrefix='' showvalues='0' numDivLines='4' formatNumberScale='0' decimalPrecision='2' anchorSides='10' anchorRadius='3' anchorBorderColor='009900'  rotateNames='1' > \n";
$strGrafico.= "<categories> \n";
foreach($arrDatas as $data){
	$strGrafico.= "<category name='". DataDMY($data) ."'/> \n";	
}
$strGrafico.= "</categories> \n";
$strGrafico.= "<dataset seriesName='Contagem' color='AFD8F8' showValues='0'> \n";
foreach($arrDatas as $data){
	$sql ="";
	$sql.="select ifnull(sum(co.enters),0) total ";
	$sql.="  from sites s ";
	$sql.="	    inner join cameras c on c.sites_pk = s.pk ";
	$sql.="        inner join contagem co on c.ds_macaddress = co.macaddress ";
	$sql.=" where startime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$total = $row['total'];
	$strGrafico.= "<set value='".$total."'/> \n";
	mysql_free_result($result);
}
$strGrafico.= "</dataset> \n";

//xml com a taxa de conversao.
$strGrafico.= "<dataset seriesName='Taxa de Conversão' color='8BBA00' showValues='0' parentYAxis='S'>";
foreach($arrDatas as $data){
	$sql ="";
	$sql.="select date_format(co.startime,'%d/%m/%Y') data, t.n_qtde_transacoes, t.n_vl_transacoes, ifnull(sum(co.enters),0) entradas, ifnull(sum(co.exits),0) saidas ";
	$sql.="  from sites s ";
	$sql.="	    inner join cameras c on c.sites_pk = s.pk ";
	$sql.="        inner join contagem co on c.ds_macaddress = co.macaddress ";
	$sql.="        left join transacoes t on date_format(co.startime,'%Y-%m-%d') = t.dt_base ";
	$sql.=" where startime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$sql.=" group by date_format(co.startime,'%d/%m/%Y'), t.n_qtde_transacoes, t.n_vl_transacoes  ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['entradas'] > 0)
		$total = $row['n_qtde_transacoes'] / $row['entradas'];
	else
		$total = 0;
		
	$strGrafico.= "<set value='".number_format($total * 100,2,".","") ."'/> \n";
	mysql_free_result($result);
}
$strGrafico.= "</dataset>";
$strGrafico.= "</graph>";

echo $strGrafico;

include_once "../libs/desconectar.php";

?>
