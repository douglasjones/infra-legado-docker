<?

include_once "../libs/maininclude.php";

$sites_pk = $_REQUEST['sites_pk'];

$arrCor = array();
$arrCor[0]="AFD8F8";
$arrCor[1]="F6BD0F";
$arrCor[2]="8BBA00";
$arrCor[3]="FF8E46";
$arrCor[4]="008E8E";
$arrCor[5]="D64646";
$arrCor[6]="8E468E";

$arrDiaSemana = array();
$arrDiaSemana[0] = "Dom";
$arrDiaSemana[1] = "Seg";
$arrDiaSemana[2] = "Ter";
$arrDiaSemana[3] = "Qua";
$arrDiaSemana[4] = "Qui";
$arrDiaSemana[5] = "Sex";
$arrDiaSemana[6] = "Sab";

//Determina quais datas serão trabalhadas.
$arrDatas = array();
for ($i = 31; $i >= 0; $i-- ){
	$arrDatas[] = DataYMD(SubtrairData(hoje(),$i * (-1), 0, 0));
	
}
$dt_inicio = $arrDatas[0];
$dt_fim = $arrDatas[count($arrDatas)-1];

//Pega o dia da semana do primeiro dia.
$sql ="";
$sql.="select DATE_FORMAT('".$dt_inicio."','%w') as tm_wday ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$indice_dia_semana = $row['tm_wday'];
$indice = $row['tm_wday'];
mysql_free_result($result);

$strGrafico.= "<graph caption='' PYAxisName='Tx. Conv. %' SYAxisName='Ticket Medio' numberPrefix='' showvalues='0' numDivLines='4' formatNumberScale='0' decimalPrecision='2' anchorSides='10' anchorRadius='3' anchorBorderColor='009900'  rotateNames='1' > \n";
$strGrafico.= "<categories> \n";
foreach($arrDatas as $data){
	$strGrafico.= "<category hoverText='".$arrDiaSemana[$indice_dia_semana]."' name='". DataDMY($data) ."'/> \n";	
	
	if($indice_dia_semana < 6)
		$indice_dia_semana ++;
	else
		$indice_dia_semana = 0;		
	
}
$strGrafico.= "</categories> \n";
$strGrafico.= "<dataset seriesName='Tx Conv. %' color='AFD8F8' showValues='0'> \n";
foreach($arrDatas as $data){
	$sql ="";
	$sql.="select ifnull(s.n_qtde_desconto_diario,0) n_qtde_desconto_diario, date_format(co.starttime,'%d/%m/%Y') data, t.n_qtde_transacoes, t.n_vl_transacoes, ifnull(sum(co.enters),0) entradas, ifnull(sum(co.exits),0) saidas ";
	$sql.="  from sites s ";
	$sql.="	    inner join cameras c on c.sites_pk = s.pk ";
	$sql.="     inner join count co on c.ds_macaddress = co.macaddress ";
	$sql.="      left join transacoes t on (date_format(co.starttime,'%Y-%m-%d') = t.dt_base and s.pk = t.sites_pk) ";
	$sql.=" where starttime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$sql.="  and s.pk = $sites_pk ";
	$sql.=" group by ifnull(s.n_qtde_desconto_diario,0), date_format(co.starttime,'%d/%m/%Y'), t.n_qtde_transacoes, t.n_vl_transacoes  ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['entradas'] > 0){
		
		
		$entradas = $row['entradas'];
		
		$sql ="";
		$sql.="select n_qtde_desconto ";
		$sql.="  from sites_datas_descontos sdd ";
		$sql.=" where sdd.sites_pk = $sites_pk ";
		$sql.="   and dt_desconto = '".$data."' ";
		$rs_desconto = mysql_query($sql);
		$num = mysql_num_rows($rs_desconto);
		if($num > 0){
			$row_desconto = mysql_fetch_array($rs_desconto);
			$entradas -= $row_desconto['n_qtde_desconto'];
		}
		else{
			
			$sql ="";
			$sql.="select n_qtde_desconto ";
			$sql.="  from sites_desconto_padrao sdp ";
			$sql.=" where sdp.sites_pk = $sites_pk ";
			$sql.="   and '".$data."' between sdp.dt_desconto_ini and sdp.dt_desconto_fim ";
			$rs_desconto_padrao = mysql_query($sql);
			while($row_desconto_padrao = mysql_fetch_array($rs_desconto_padrao)){
				$entradas -= $row_desconto_padrao['n_qtde_desconto'];
				break;
			}
			mysql_free_result($rs_desconto_padrao);				
			
		}
		mysql_free_result($rs_desconto);		
		
		$total = $row['n_qtde_transacoes'] / $entradas;
	}
	else{
		$total = 0;
	}
	mysql_free_result($result);
		
	$strGrafico.= "<set color='".$arrCor[$indice]."' value='".number_format($total * 100,2,".","") ."'/> \n";
	if($indice < 6)
		$indice ++;
	else
		$indice = 0;	
	
}
$strGrafico.= "</dataset> \n";

//xml com a taxa de conversao.
$strGrafico.= "<dataset seriesName='Ticket Medio' color='8BBA00' showValues='0' parentYAxis='S'>";
foreach($arrDatas as $data){
	$sql ="";
	$sql.="select date_format(co.starttime,'%d/%m/%Y') data, t.n_qtde_transacoes, t.n_vl_transacoes, ifnull(sum(co.enters),0) entradas, ifnull(sum(co.exits),0) saidas ";
	$sql.="  from sites s ";
	$sql.="	    inner join cameras c on c.sites_pk = s.pk ";
	$sql.="        inner join count co on c.ds_macaddress = co.macaddress ";
	$sql.="         left join transacoes t on (date_format(co.starttime,'%Y-%m-%d') = t.dt_base and t.sites_pk = s.pk) ";
	$sql.=" where starttime between '".$data." 00:00:00' and '".$data." 23:59:59' ";
	$sql.="  and s.pk = $sites_pk ";
	$sql.=" group by date_format(co.starttime,'%d/%m/%Y'), t.n_qtde_transacoes, t.n_vl_transacoes  ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	if($row['n_qtde_transacoes'] > 0)
		$total = $row['n_vl_transacoes'] / $row['n_qtde_transacoes'];
	else
		$total = 0;
		
	$strGrafico.= "<set value='".number_format($total,2,".","") ."'/> \n";
	mysql_free_result($result);
}
$strGrafico.= "</dataset>";
$strGrafico.= "</graph>";

echo $strGrafico;

include_once "../libs/desconectar.php";

?>
