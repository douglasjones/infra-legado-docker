<?

include_once "../../libs/maininclude.php";
include_once "combo_cla.php";
include_once "../../libs/combo.php";


$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$operador_pk = $_REQUEST['operador_pk'];
$produtos_tipo_pk = $_REQUEST['produtos_tipo_pk'];
$ds_combo = $_REQUEST['ds_combo'];
$vl_combo = $_REQUEST['vl_combo'];
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
$itens_produtos_combo = $_REQUEST['itens_produtos_combo'];
$n_vigencia_contrato = $_REQUEST['n_vigencia_contrato'];
	
if ($acao == "gravar"){	
 
	$combos = new combos(0);
	$combos->setpk($pk);	
	$combos->setoperador_pk ($operador_pk);
	$combos->setds_combo ($ds_combo);
	$combos->setvl_combo ($vl_combo);
	$combos->setdt_cancelamento($dt_cancelamento);
	$combos->setitens_produtos_combo($itens_produtos_combo);
	$combos->setn_vigencia_contrato($n_vigencia_contrato);	
   
	$pk = $combos->salvar();
	
	//ITENS PRODUTOS
	$combos->add_itens_produto($pk);	
	
	javascriptalert('Operação executada com sucesso!!!');
}
if($acao == "select"){
	switch($_REQUEST['tipo']){	
		case 1:		
			$sql  = " Select
						np.pk
						,np.ds_produto
					   from n_produtos np
					   where np.produtos_tipo_pk=".$_REQUEST['produto_tipo_pk'];
			if(!empty($_REQUEST['operador_pk'])){
				$sql.=" and np.operador_pk=".$_REQUEST['operador_pk'];
			}	
			$sql.=" and np.dt_cancelamento is null";
						
			combo($sql, "produto_pk"," ", null, " ");												
		break;
	}
}
if($acao == "excluir"){
	$produtos= new produtos($pk);
	$produtos->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
