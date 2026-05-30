<?
    include_once "../../libs/maininclude.php";	
	
	//VARIAVEIS
    $codproduto = $_REQUEST['codproduto'];

    
$sql.="Select
		 dt.cod_data_proposta_operador
		 , dt.dsc_data
		from data_proposta_operador dt
		inner join produtos p  on dt.cod_operador = p.cod_operador
		where p.codproduto=".$codproduto;   

    echo "teste";
	//echo "Msg=////".$row['cod']."////".$row['it_cx']."////".$row['peso']."////".$valor_item."////".$row['grupo_pk']."////".$qtde_desconto;

mysql_free_result($result);
?>
