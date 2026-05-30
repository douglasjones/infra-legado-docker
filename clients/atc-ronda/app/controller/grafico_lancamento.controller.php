<?
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";
include_once "../model/lancamento.dao.php";
include_once "../model/lancamento.class.php";

$token = $_REQUEST['token'];
$lancamentodao = new lancamentodao();
$lancamentodao->setToken($token); 


$dt_periodo_ini = $_REQUEST['dt_periodo_ini'];
$dt_periodo_fim = $_REQUEST['dt_periodo_fim'];
$contas_pk = $_REQUEST['contas_pk'];

$resultado = "";
$queryReceita = $lancamentodao->listarValoresReceita($dt_periodo_ini,$dt_periodo_fim,$contas_pk);
$queryDespesas = $lancamentodao->listarValoresDespesas($dt_periodo_ini,$dt_periodo_fim,$contas_pk);

$strResultado.="{".'"'."series".'"'.": [";
if($contas_pk!=""){
    $arrCampos = array();
    $arrCampos['data_receita'] = ($queryReceita[0]['vl_lancamento'])==""?0:floatval(number_format($queryReceita[0]['vl_lancamento'],2,'.','')); 
    $arrCampos['data_despesa'] = ($queryDespesas[0]['vl_lancamento'])==""?0:floatval(number_format($queryDespesas[0]['vl_lancamento'],2,'.','')); 
    $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
}
else{
    $arrCampos = array();
    $arrCampos['data_receita'] = 0;
    $arrCampos['data_despesa'] = 0;
    $strResultado.= html_entity_decode(json_encode($arrCampos)).",";
}



$strResultado = substr($strResultado, 0, strlen($strResultado)-1)."]}";
echo $strResultado;
