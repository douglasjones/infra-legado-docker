<?
include_once "../libs/maininclude.php";

$sites_pk = $_REQUEST['sites_pk'];

$arrMes = array();
$arrMes[] = "Jan";
$arrMes[] = "Fev";
$arrMes[] = "Mar";
$arrMes[] = "Abr";
$arrMes[] = "Mai";
$arrMes[] = "Jun";
$arrMes[] = "Jul";
$arrMes[] = "Ago";
$arrMes[] = "Set";
$arrMes[] = "Out";
$arrMes[] = "Nov";
$arrMes[] = "Dez";

$arrCor = array();
$arrCor[] = 'AFD8F8';
$arrCor[] = 'F6BD0F';
$arrCor[] = '8BBA00';
$arrCor[] = 'FF8E46';
$arrCor[] = '008E8E';
$arrCor[] = 'D64646';
$arrCor[] = '8E468E';
$arrCor[] = '588526';
$arrCor[] = 'B3AA00';
$arrCor[] = '008ED6';
$arrCor[] = '9D080D';
$arrCor[] = 'A186BE';

$strGrafico ="";
$strGrafico.="<graph caption='' xAxisName='Mês' yAxisName='Qtde' decimalPrecision='0' formatNumberScale='0'> \n";
for($i = 12; $i >= 0;$i--){

	$totalgeral = 0;
	
	$hoje = SubtrairData(hoje(), 0, $i, 0);
	$dt_inicio = primeiroDiaMes($hoje);
	$dt_fim = ultimoDiaMes($hoje);
	$mes = (int) pegarMes($hoje);
	
	$arrDataIni = split("/", $dt_inicio);
	$arrDataFim = split("/", $dt_fim);
	
	for($j = 1; $j <= $arrDataFim[0] ; $j++){

		$desconto = 0;
		$total = 0;

		$sql ="";
		$sql.="select ifnull(sum(n_qtde_desconto),0) n_qtde_desconto ";
		$sql.="  from sites_datas_descontos sdd ";
		$sql.=" where sdd.sites_pk = $sites_pk ";
		$sql.="   and sdd.dt_desconto = '".$arrDataIni[2]."-".$arrDataIni[1]."-".$j."' ";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if($row['n_qtde_desconto'] > 0){
			$desconto = $row['n_qtde_desconto'];
		}
		else{
			$sql ="";
			$sql.="select sdp.n_qtde_desconto ";
			$sql.="  from sites_desconto_padrao sdp ";
			$sql.=" where '".$arrDataIni[2]."-".$arrDataIni[1]."-".$j."' between sdp.dt_desconto_ini and sdp.dt_desconto_fim ";
			$sql.="   and sdp.sites_pk = $sites_pk ";
			$rs = mysql_query($sql);
			while($row_padrao = mysql_fetch_array($rs)){
				$desconto = $row_padrao['n_qtde_desconto'];
			}
			mysql_free_result($rs);
			
		}
		mysql_free_result($result);
		
		$sql ="";
		$sql.="select ifnull(sum(co.enters),0) total ";
		$sql.="  from sites s ";
		$sql.="	    inner join cameras c on c.sites_pk = s.pk ";
		$sql.="        inner join count co on c.ds_macaddress = co.macaddress ";
		$sql.=" where starttime between '".$arrDataIni[2]."-".$arrDataIni[1]."-".$j." 00:00:00' and '".$arrDataIni[2]."-".$arrDataIni[1]."-".$j." 23:59:59' ";
		$sql.="   and s.pk = $sites_pk ";
		$result = mysql_query($sql);	
		while($row = mysql_fetch_array($result)){	
			$total = $row['total'];
		}
		mysql_free_result($result);	
		
		if($total > 0){
			$total -= $desconto;
		}
		else{
			$total = 0;
		}
		$totalgeral += $total;
		
	}
	$strGrafico.="<set name='".$arrMes[$mes -1]."' value='".($totalgeral)."' color='".$arrCor[$mes -1]."'/>  \n";	
}
$strGrafico.="</graph>  \n";

echo $strGrafico;

include_once "../libs/desconectar.php";

?>
