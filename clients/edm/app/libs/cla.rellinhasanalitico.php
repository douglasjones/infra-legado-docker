<?
class rellinhasanalitico {
	function listaValor($lista, $campo = 'valor'){
		$reg = array();
		$tmp = explode('|', $lista);
		$ret = null;
		foreach($tmp as $opt){
			ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);
			$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);
			if(!empty($reg[1])){
				$ret[] = array($reg[2], $reg[3]);
				break;
			}
		}
		switch($campo){
			case 'chave':
				return $ret[0][0];
				break;
			case 'valor':
				return $ret[0][1];
				break;
			default:
				return $ret;
				break;
		}
		break;
	}
	function getReport($usr, $dti, $dtf, $codpolo){
		$sql = "SELECT l.RazaoSocial AS nome,
		l.CodLead AS codlead,
		ui.Nome AS gerenteconta,
		mp.Valor AS valor,
		mp.ID AS id
		FROM leads AS l
		INNER JOIN usuariosinternos AS ui ON l.CodGerenteConta = ui.CodUsuarioInterno
		INNER JOIN propostas AS p ON p.CodLead = l.CodLead
		INNER JOIN modulosproposta AS mp ON p.CodProposta = mp.CodProposta
		WHERE (mp.ID = 'leadtipo'
		OR mp.ID = 'qtdelinhasnovas'
		OR mp.ID = 'qtdelinhasmigracao'
		OR mp.ID = 'qtdelinhasrenovacao')";
		if($usr){
			$sql .= " AND l.CodGerenteConta in ($usr)";
		}
		if($dti && $dtf){
			$sql .= " AND p.DataEntregaAparelho BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}else if($dti){
			$sql .= " AND p.DataEntregaAparelho >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
		}else if($dtf){
			$sql .= " AND p.DataEntregaAparelho <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}else{
			$sql .= " AND p.DataEntregaAparelho IS NOT null";
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= " AND l.cod_polo=" . mysqlnull($codpolo);
		}
		$sql .= " ORDER BY p.CodProposta, mp.ID";
		$query = sql_query($sql);
		$i = 0;
		$codlead = "";
		$ret = array();
		while($row = mysql_fetch_array($query)){
			if($codlead != $row['codlead']){
				if($codlead != "") $i++;
				$ret[$i]['nome'] = $row['nome'];
				$ret[$i]['gerenteconta'] = $row['gerenteconta'];
				$ret[$i]['codlead'] = $row['codlead'];
				$codlead = $row['codlead'];
			}
			if($row['id'] == 'leadtipo')
				$ret[$i]['tipo'] = rellinhasanalitico::listaValor($row['valor']);
			if($row['id'] == 'qtdelinhasnovas')
				$ret[$i]['lnovas'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasmigracao')
				$ret[$i]['lmigra'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasrenovacao')
				$ret[$i]['lrenova'] = (empty($row['valor'])?0:$row['valor']);
		}
		mysql_free_result($query);
		return $ret;
	}
}
?>