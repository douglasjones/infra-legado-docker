<?

include_once "../../libs/maininclude.php";
include_once "produtos_cla.php";


$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$operador_pk = $_REQUEST['operador_pk'];
$produtos_tipo_pk = $_REQUEST['produtos_tipo_pk'];
$ds_produto = $_REQUEST['ds_produto'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
$valores_produto = $_REQUEST['valores_produto'];
$valor_tipo_pk = $_REQUEST['tipo_valor_pk'];



$vl_vc1_local = $_REQUEST['vl_vc1_local'];
$dsc_vc1_local = $_REQUEST['dsc_vc1_local'];
$visualiza_vc1_local = $_REQUEST['visualiza_vc1_local'];
$vl_vc1_Estad = $_REQUEST['vl_vc1_Estad'];
$dsc_vc1_Estad = $_REQUEST['dsc_vc1_Estad'];
$visualiza_vc1_Estad = $_REQUEST['visualiza_vc1_Estad'];
$vl_vc1_Nac = $_REQUEST['vl_vc1_Nac'];
$dsc_vc1_Nac = $_REQUEST['dsc_vc1_Nac'];
$visualiza_vc1_Nac = $_REQUEST['visualiza_vc1_Nac'];

$vl_vc2_local = $_REQUEST['vl_vc2_local'];
$dsc_vc2_local = $_REQUEST['dsc_vc2_local'];
$visualiza_vc2_local = $_REQUEST['visualiza_vc2_local'];
$vl_vc2_Estad = $_REQUEST['vl_vc2_Estad'];
$dsc_vc2_Estad = $_REQUEST['dsc_vc2_Estad'];
$visualiza_vc2_Estad = $_REQUEST['visualiza_vc2_Estad'];
$vl_vc2_Nac = $_REQUEST['vl_vc2_Nac'];
$dsc_vc2_Nac = $_REQUEST['dsc_vc2_Nac'];
$visualiza_vc2_Nac = $_REQUEST['visualiza_vc2_Nac'];

$vl_vc3_local = $_REQUEST['vl_vc3_local'];
$dsc_vc3_local = $_REQUEST['dsc_vc3_local'];
$visualiza_vc3_local = $_REQUEST['visualiza_vc3_local'];
$vl_vc3_Estad = $_REQUEST['vl_vc3_Estad'];
$dsc_vc3_Estad = $_REQUEST['dsc_vc3_Estad'];
$visualiza_vc3_Estad = $_REQUEST['visualiza_vc3_Estad'];
$vl_vc3_Nac = $_REQUEST['vl_vc3_Nac'];
$dsc_vc3_Nac = $_REQUEST['dsc_vc3_Nac'];
$visualiza_vc3_Nac = $_REQUEST['visualiza_vc3_Nac'];
$total_minutos = $_REQUEST['total_minutos'];
$total_internet = $_REQUEST['total_internet'];
$tipo_dados = $_REQUEST['tipo_dados'];
$produto_book_pk = $_REQUEST['produto_book_pk'];
$n_produtos_beneficio = $_REQUEST['n_produtos_beneficio'];



if ($acao == "gravar"){	
    
	$produtos = new produtos(0);
	$produtos->setpk($pk);	
	$produtos->setoperador_pk ($operador_pk);
	$produtos->setprodutos_tipo_pk ($produtos_tipo_pk);
	$produtos->setds_produto ($ds_produto);
	$produtos->setdt_cancelamento($dt_cancelamento);
	$produtos->setvalores_produto($valores_produto);
    $produtos->setvalor_tipo_pk($valor_tipo_pk);
	
	$produtos->setvl_vc1_local ($vl_vc1_local);
	$produtos->setdsc_vc1_local ($dsc_vc1_local);
	$produtos->setvisualiza_vc1_local ($visualiza_vc1_local);
	$produtos->setvl_vc1_Estad ($vl_vc1_Estad);
	$produtos->setdsc_vc1_Estad ($dsc_vc1_Estad);
	$produtos->setvisualiza_vc1_Estad ($visualiza_vc1_Estad);
	$produtos->setvl_vc1_Nac ($vl_vc1_Nac);
	$produtos->setdsc_vc1_Nac ($dsc_vc1_Nac);
	$produtos->setvisualiza_vc1_Nac ($visualiza_vc1_Nac);
	
	$produtos->setvl_vc2_local ($vl_vc2_local);
	$produtos->setdsc_vc2_local ($dsc_vc2_local);
	$produtos->setvisualiza_vc2_local ($visualiza_vc2_local);
	$produtos->setvl_vc2_Estad ($vl_vc2_Estad);
	$produtos->setdsc_vc2_Estad ($dsc_vc2_Estad);
	$produtos->setvisualiza_vc2_Estad ($visualiza_vc2_Estad);
	$produtos->setvl_vc2_Nac ($vl_vc2_Nac);
	$produtos->setdsc_vc2_Nac ($dsc_vc2_Nac);
	$produtos->setvisualiza_vc2_Nac ($visualiza_vc2_Nac);
	
	$produtos->setvl_vc3_local ($vl_vc3_local);
	$produtos->setdsc_vc3_local ($dsc_vc3_local);
	$produtos->setvisualiza_vc3_local ($visualiza_vc3_local);
	$produtos->setvl_vc3_Estad ($vl_vc3_Estad);
	$produtos->setdsc_vc3_Estad ($dsc_vc3_Estad);
	$produtos->setvisualiza_vc3_Estad ($visualiza_vc3_Estad);
	$produtos->setvl_vc3_Nac ($vl_vc3_Nac);
	$produtos->setdsc_vc3_Nac ($dsc_vc3_Nac);
	$produtos->setvisualiza_vc3_Nac ($visualiza_vc3_Nac);
    $produtos->settotal_minutos ($total_minutos);
    $produtos->settotal_internet ($total_internet);
    $produtos->settipo_dados ($tipo_dados);
    $produtos->setproduto_book_pk ($produto_book_pk);
    $produtos->setn_produtos_beneficio ($n_produtos_beneficio);
	
	$pk = $produtos->salvar();
	
	//VALORES PRODUTOS
	$produtos->add_produtos_valores($pk);
	
	//DADOS OPERADORAS
	$produtos->add_produtos_operadoras($pk);
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$produtos= new produtos($pk);
	$produtos->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}
if($acao == "select"){
  
        
        $sql = "";
        $sql.= "SELECT pk,n_dsc_book,operador_pk
                           from n_produtos_book
                       WHERE operador_pk = ".$_REQUEST['operador_pk'];
            
        $result = mysql_query($sql);    

        while($row = mysql_fetch_array($result)){
                echo $row["pk"]."##".$row["n_dsc_book"]."////";			
        }  
        mysql_free_result($result);
    }


include_once "../../libs/desconectar.php";

?>
