<?
class faixa{
	function doValor($valor){
		$sql = "select CodFaixa from faixa_remuneracao where FaixaDe < ".mysqlnull($valor)." and FaixaAte > ".mysqlnull($valor);
		$result = mysql_query($sql) or die(mysql_error());
		return mysql_result($result);
	}
	function doValor2($valor){
		$sql = "select * from faixa_remuneracao where FaixaDe < ".mysqlnull($valor)." and FaixaAte > ".mysqlnull($valor);
		$result = mysql_query($sql) or die(mysql_error());
		$ret = mysql_fetch_array($result);
		return $ret[1]." à ".$ret[2];
	}
	function daProposta($codproposta){
		$sql = "select CodFaixa from faixa_remuneracao f
				left join propostas p on p.TotalProposta BETWEEN f.FaixaDe AND f.FaixaAte
				WHERE CodProposta = ".mysqlnull($codproposta);
		$result = mysql_query($sql) or die(mysql_error());
		return mysql_result($result);
	}
	function media($codproposta, $codlead){
		$sql = "select p.TotalProposta valor, mp.Valor linhas FROM propostas p
				JOIN modulosproposta mp ON p.CodProposta = mp.CodProposta
				WHERE mp.ID = 'qtdelinhas' AND p.CodProposta = ".mysqlnull($codproposta)." AND mp.CodLead = ".mysqlnull($codlead);

		$result = mysql_query($sql) or die(mysql_error());
		$valores = mysql_fetch_array($result);
		mysql_free_result($result);
		$valores['linhas'] = ( $valores['linhas'] == 0 ) ? 1 : $valores['linhas'] ;
		$ret = number_format($valores['valor'] / $valores['linhas'],2,',','.');
		return $ret;
	}
	function listar(){
		$sql = "select * from faixa_remuneracao";
		$result = sql_query($sql);
		return $result;
	}
	function add($values){
		$sql = "insert into faixa_remuneracao ( FaixaDe , FaixaAte )";
		$sql .= "values (".mysqlnull($values['FaixaDe']).", ".mysqlnull($values['FaixaAte']). ")";
		sql_query($sql);
		return "Faixa cadastrada com sucesso.";

	}
	function get($cod){
		$sql = "select * from faixa_remuneracao where CodFaixa = $cod";
		$result = sql_query($sql);
		return $result;
	}
	function edit($values){
		$sql = "update faixa_remuneracao set ";
		$sql .= "FaixaDe = ".mysqlnull($values['FaixaDe']);
		$sql .= ", FaixaAte = ".mysqlnull($values['FaixaAte']);
		$sql .= " where CodFaixa = ".$values['CodFaixa'];
		sql_query($sql);
		return "Faixa editada com sucesso.";
	}
	function del($cod){
		$sql = "delete from faixa_remuneracao where CodFaixa = ".mysqlnull($cod);
		sql_query($sql);
		return "Faixa excluida com sucesso.";
	}
}
?>