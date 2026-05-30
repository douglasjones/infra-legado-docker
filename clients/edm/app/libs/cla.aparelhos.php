<?
class aparelhos{
	function salvar($value){				
		if(!$value['NomeAparelho']) return false;
		if(!$value['Imagem']) return false;
		if(!$value['Status']) $value['Status'] = 1;
		//VARIAVEL RECEBE VALOR DO OPERADOR SELECIONADO
		if(!$value['cod_operador']) return false;
		
		$fields['NomeAparelho'] = $value['NomeAparelho'];
		$fields['Imagem'] = $value['Imagem'];
		$fields['Status'] = $value['Status'];
		//VARIAVEL RECEBE VALOR DO OPERADOR SELECIONADO
		$fields['cod_operador'] = $value['cod_operador'];
		
		if($value['CodAparelho']==''){
			return aparelhos::adicionar($fields);
		}else{
			return aparelhos::alterar($value['CodAparelho'], $fields);
		}
	}
	function adicionar($fields){
		
		$table = 'aparelhos';
		$into = array();
		$values = array();
		foreach($fields as $field => $val){
			$into[] = $field;
			$values[] = mysqlnull($val);
		}
		$into = implode(", ", $into);
		$values = implode(", ", $values);
		$sql = "Insert Into $table ($into) Values (" . $values . ")";
		
		mysql_query($sql)or die(mysql_error());
		return true;
	}
	function alterar($codaparelho, $fields){
		$sql = sqlupdate('aparelhos', $fields, ' CodAparelho = ' . mysqlnull($codaparelho));
		sql_query($sql);
		return true;
	}
}
?>