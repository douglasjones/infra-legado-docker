<?
class produtos {
	function gravaModulos($modulos, $codproduto){
		$sql = "delete from modulosproduto where codproduto=" . mysqlnull($codproduto);
		sql_query($sql);
		foreach($modulos as $id => $modulo){
			$modulo['codproduto'] = $codproduto;
			$modulo['id'] = $id;
			$modulo['valor'] = str_replace(chr(13).chr(10), '|', $modulo['valor']);
			$modulo['valorfixo'] == ($modulo['eval'] == 1?1:$modulo['valorfixo']);
			$sql = sqlinsert('modulosproduto', $modulo);
			sql_query($sql);
		}
	}
}
?>
