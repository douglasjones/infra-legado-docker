<?
class relfatura{
	function get_leads($usr, $cod_polo = false, $dataenviode = false, $dataenvioate = false, $dataativade = false, $dataativaate = false, $dataestornode = false, $dataestornoate = false){
		$sql = "SELECT 
		l.CodLead AS codlead,
		l.CNPJ_CPF AS cnpj,
		l.RazaoSocial AS razaosocial,
		pr.Nome AS plano,
		pr.CodProduto AS codplano,
		p.TotalProposta AS valorplano,
		p.DataEnvioContrato AS dtenvio,
		p.DataAtivacao AS dtatv,
		p.DataEstorno AS estorno,
		p.CodProposta AS codproposta,
		p.NumPVC AS pvc,
		mp.Valor AS valor,
		mp.ID AS id
		FROM leads AS l
		INNER JOIN propostas AS p ON p.CodLead = l.CodLead
		INNER JOIN modulosproposta AS mp ON p.CodProposta = mp.CodProposta
		LEFT JOIN produtos pr ON pr.CodProduto = p.CodProduto
		WHERE (mp.ID = 'qtdelinhasnovas'
		OR mp.ID = 'qtdelinhasmigracao'
		OR mp.ID = 'qtdelinhasrenovacao'
		OR mp.ID = 'qtdepacoteinternet10'
		OR mp.ID = 'qtdepacoteinternet40'
		OR mp.ID = 'qtdepacoteinternet100'
		OR mp.ID = 'qtdepacoteinternet500'
		OR mp.ID = 'qtdepacoteinternet2000'
		OR mp.ID = 'qtdepacoteinternet2000a'
		OR mp.ID = 'qtdepacoteinternetlimitado20'
		OR mp.ID = 'qtdepacoteinternetlimitado20a'
		OR mp.ID = 'qtdeintellicorp'
		OR mp.ID = 'qtdeintellipro'
		OR mp.ID = 'qtdebes'
		OR mp.ID = 'qtdebis'
		OR mp.ID = 'pacote')
		AND p.DataEntregaAparelho IS NOT null";

		if($usr){
			$sql .= " AND l.CodGerenteConta = $usr";
		}
		if($dataenviode && $dataenvioate){
			$sql .= " AND p.DataEnvioContrato BETWEEN ". mysqlnull(date('Y-m-d', $dataenviode).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataenvioate).' 23:59:59');
		}else if($dataenviode){
			$sql .= " AND p.DataEnvioContrato >= ". mysqlnull(date('Y-m-d', $dataenviode).' 00:00:00');
		}else if($dataenvioate){
			$sql .= " AND p.DataEnvioContrato <= ". mysqlnull(date('Y-m-d', $dataenvioate).' 23:59:59');
		}
		if($dataativade && $dataativaate){
			$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dataativade).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataativaate).' 23:59:59');
		}else if($dataativade){
			$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dataativade).' 00:00:00');
		}else if($dataativaate){
			$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dataativaate).' 23:59:59');
		}
		if($dataestornode && $dataestornoate){
			$sql .= " AND p.DataEstorno BETWEEN ". mysqlnull(date('Y-m-d', $dataestornode).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataestornoate).' 23:59:59');
		}else if($datestornoade){
			$sql .= " AND p.DataEstorno >= ". mysqlnull(date('Y-m-d', $dataestornode).' 00:00:00');
		}else if($dataestornoate){
			$sql .= " AND p.DataEstorno <= ". mysqlnull(date('Y-m-d', $dataestornoate).' 23:59:59');
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= " AND l.cod_polo=" . mysqlnull($codpolo);
		}
		$sql .= " ORDER BY p.CodProposta, mp.ID";
		$query = sql_query($sql);
		$codproposta = '';
		$codlead = '';
		$ret = array();
		while($row = mysql_fetch_array($query)){
			if($row['id'] == 'qtdelinhasnovas')
				$ret[$i]['lnovas'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasmigracao')
				$ret[$i]['lmigr'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasrenovacao')
				$ret[$i]['lrenov'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet10'||$row['id'] == 'qtdepacoteinternet40'||$row['id'] == 'qtdepacoteinternet100'||$row['id'] == 'qtdepacoteinternet500'||$row['id'] == 'qtdepacoteinternet2000'||$row['id'] == 'qtdepacoteinternet2000a'||$row['id'] == 'qtdepacoteinternetlimitado20'||$row['id'] == 'qtdepacoteinternetlimitado20a')
				$ret[$i]['dados'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdebis'||$row['id'] == 'qtdebes')
				$ret[$i]['bberry'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdeintellicorp'||$row['id'] == 'qtdeintellipro')
				$ret[$i]['intellis'] = (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'pacote'&&$row['codplano']==32){
				$plano = explode("|", $row['valor']);
				if(substr($plano[0],0,1)=='*') $ret[$i]['bl250'] += 1;
				if(substr($plano[1],0,1)=='*') $ret[$i]['bl500'] += 1;
				if(substr($plano[2],0,1)=='*') $ret[$i]['bl1mb'] += 1;
			}
			if($codproposta != $row['codproposta']){
				if($codproposta != "") $i++;
				$ret[$i]['cnpj'] = $row['cnpj'];
				$ret[$i]['razaosocial'] = $row['razaosocial'];
				$ret[$i]['plano'] = $row['plano'];
				$ret[$i]['valorplano'] = $row['valorplano'];
				$ret[$i]['mediactr'] = faixa::media($row['codproposta'], $row['codlead']);
				$ret[$i]['fxremun'] = faixa::doValor2($ret[$i]['mediactr']);
				$ret[$i]['dtenvio'] = (empty($row['dtenvio'])?'':date("d/m/Y",strtotime($row['dtenvio'])));
				$ret[$i]['dtatv'] = (empty($row['dtatv'])?'':date("d/m/Y",strtotime($row['dtatv'])));
				$ret[$i]['estorno'] = ($row['estorno']=='0000-00-00'||empty($row['estorno'])?0:date("d/m/Y",strtotime($row['estorno'])));
				$ret[$i]['pvc'] = $row['pvc'];
			}
			$codproposta = $row['codproposta'];
		}
		mysql_free_result($query);
		return $ret;
	}
	function sintetico($usr, $cod_polo = false, $dataenviode = false, $dataenvioate = false, $dataativade = false, $dataativaate = false, $dataestornode = false, $dataestornoate = false){
		$sql = "SELECT 
		p.DataEstorno AS estorno,
		p.CodProposta AS codproposta,
		p.CodProduto AS codplano,
		mp.Valor AS valor,
		mp.ID AS id
		FROM leads AS l
		INNER JOIN propostas AS p ON p.CodLead = l.CodLead
		INNER JOIN modulosproposta AS mp ON p.CodProposta = mp.CodProposta
		WHERE (mp.ID = 'qtdelinhasnovas'
		OR mp.ID = 'qtdelinhasmigracao'
		OR mp.ID = 'qtdelinhasrenovacao'
		OR mp.ID = 'qtdepacoteinternet10'
		OR mp.ID = 'qtdepacoteinternet40'
		OR mp.ID = 'qtdepacoteinternet100'
		OR mp.ID = 'qtdepacoteinternet500'
		OR mp.ID = 'qtdepacoteinternet2000'
		OR mp.ID = 'qtdepacoteinternet2000a'
		OR mp.ID = 'qtdepacoteinternetlimitado20'
		OR mp.ID = 'qtdepacoteinternetlimitado20a'
		OR mp.ID = 'qtdeintellicorp'
		OR mp.ID = 'qtdeintellipro'
		OR mp.ID = 'qtdebes'
		OR mp.ID = 'qtdebis'
		OR mp.ID = 'pacote')
		AND p.DataEntregaAparelho IS NOT null";
		if($usr){
			$sql .= " AND l.CodGerenteConta = $usr";
		}
		if($dataenviode && $dataenvioate){
			$sql .= " AND p.DataEnvioContrato BETWEEN ". mysqlnull(date('Y-m-d', $dataenviode).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataenvioate).' 23:59:59');
		}else if($dataenviode){
			$sql .= " AND p.DataEnvioContrato >= ". mysqlnull(date('Y-m-d', $dataenviode).' 00:00:00');
		}else if($dataenvioate){
			$sql .= " AND p.DataEnvioContrato <= ". mysqlnull(date('Y-m-d', $dataenvioate).' 23:59:59');
		}
		if($dataativade && $dataativaate){
			$sql .= " AND p.DataAtivacao BETWEEN ". mysqlnull(date('Y-m-d', $dataativade).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataativaate).' 23:59:59');
		}else if($dataativade){
			$sql .= " AND p.DataAtivacao >= ". mysqlnull(date('Y-m-d', $dataativade).' 00:00:00');
		}else if($dataativaate){
			$sql .= " AND p.DataAtivacao <= ". mysqlnull(date('Y-m-d', $dataativaate).' 23:59:59');
		}
		if($dataestornode && $dataestornoate){
			$sql .= " AND p.DataEstorno BETWEEN ". mysqlnull(date('Y-m-d', $dataestornode).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dataestornoate).' 23:59:59');
		}else if($datestornoade){
			$sql .= " AND p.DataEstorno >= ". mysqlnull(date('Y-m-d', $dataestornode).' 00:00:00');
		}else if($dataestornoate){
			$sql .= " AND p.DataEstorno <= ". mysqlnull(date('Y-m-d', $dataestornoate).' 23:59:59');
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= " AND l.cod_polo=" . mysqlnull($codpolo);
		}
		$sql .= " ORDER BY p.CodProposta, mp.ID";
		$query = sql_query($sql);
		$codproposta = '';
		$ret = array();
		$ret['lnovas'] = 0;
		$ret['lmigr'] = 0;
		$ret['lrenov'] = 0;
		$ret['10mb'] = 0;
		$ret['40mb'] = 0;
		$ret['100mb'] = 0;
		$ret['500mb'] = 0;
		$ret['2000mb'] = 0;
		$ret['20gb'] = 0;
		$ret['bberry'] = 0;
		$ret['intellis'] = 0;
		$ret['bl250'] = 0;
		$ret['bl500'] = 0;
		$ret['bl1mb'] = 0;
		$ret['estorno'] = 0;
		while($row = mysql_fetch_array($query)){
			if($row['id'] == 'qtdelinhasnovas')
				$ret['lnovas'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasmigracao')
				$ret['lmigr'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdelinhasrenovacao')
				$ret['lrenov'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet10')
				$ret['10mb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet40')
				$ret['40mb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet100')
				$ret['100mb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet500')
				$ret['500mb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternet2000'||$row['id'] == 'qtdepacoteinternet2000a')
				$ret['2000mb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdepacoteinternetlimitado20'||$row['id'] == 'qtdepacoteinternetlimitado20a')
				$ret['20gb'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdebis'||$row['id'] == 'qtdebes')
				$ret['bberry'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'qtdeintellicorp'||$row['id'] == 'qtdeintellipro')
				$ret['intellis'] += (empty($row['valor'])?0:$row['valor']);
			if($row['id'] == 'pacote'&&$row['codplano']==32){
				$plano = explode("|", $row['valor']);
				if(substr($plano[0],0,1)=='*') $ret['bl250'] += 1;
				if(substr($plano[1],0,1)=='*') $ret['bl500'] += 1;
				if(substr($plano[2],0,1)=='*') $ret['bl1mb'] += 1;
			}
			if($codproposta != $row['codproposta'])
				$ret['estorno'] += ($row['estorno']=='0000-00-00'?0:1);
			$codproposta = $row['codproposta'];
		}
		$ret['i']=0;
		foreach($ret as $campo => $valor){
			$ret['i'] += $valor;
		}
		mysql_free_result($query);
		return $ret;
	}
}
?>