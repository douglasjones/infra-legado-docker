
<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";

$cod_polo = $_REQUEST['cod_polo'];

$strGrafico ="";


$arrCor['5']="AFD8F8";
$arrCor['6']="F6BD0F";
$arrCor['10']="8BBA00";
$arrCor['12']="FF8E46";
$arrCor['15']="008E8E";


$strGrafico.="<graph caption='' xAxisName='' yAxisName='Quantidade Linha Proposta(s)' decimalPrecision='0' formatNumberScale='0'>	 ";
//for($i = 12; $i >= 0; $i--){
	//pega as ocorrencias
$sql ="";
$sql.="SELECT 
            s.descricao,
            sum(nip.n_qtde) valor,
            s.codstatusclassificacaolead
  FROM statusclassificacaolead s
       INNER JOIN leads l ON l.codstatusclassificacaolead = s.codstatusclassificacaolead
       inner join n_propostas np on l.CodLead = np.leads_pk
       inner join n_itens_propostas nip on np.pk = nip.propostas_pk
       inner join n_produtos npr on nip.produtos_pk = npr.pk
       inner join n_itens_propostas_operadoras nipo on nip.pk = nipo.itens_propostas_pk
 WHERE s.codstatusclassificacaolead IN (5,6,10,12,15)       
       AND np.dt_cancelamento is null
       AND npr.produtos_tipo_pk = 1
       AND nipo.tipo_linha_pk in (1,2,4)";

if($cod_polo != "")
	$sql.=" and l.cod_polo = $cod_polo ";
	
//COLOCA OS DEMAIS PARÃ?METROS
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
if(!permissao('visualizar_todos_atendentes', 'cs'))
	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	

$sql.=" group by s.descricao ";
$sql.=" order by s.CodStatusClassificacaoLead  ";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$strGrafico.="<set name='".$row['descricao']."' value='".$row['valor']."' color='".$arrCor[$row['codstatusclassificacaolead']]."'/> ";
   
    }
	mysql_free_result($result);
//}
$strGrafico.="</graph> ";
echo $strGrafico;
include_once "../../libs/desconectar.php";
?>
