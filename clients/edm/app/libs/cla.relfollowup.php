<?
class relfollowup{
	function reltarg($gcon,$codpolo=null){
		$sql = "SELECT CodLead, RazaoSocial AS nome FROM leads WHERE ";
		if ($gcon != null){
			$sql .= "CodGerenteConta in ($gcon) AND ";
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= "cod_polo=" . mysqlnull($codpolo) . " and ";
		}
		$sql .= "CodStatusClassificacaoLead = 2";
		$sql .= " ORDER BY RazaoSocial";
		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			$num++;
		}
		mysql_free_result($result);
		return $ret;
	}
	function rellead0($gcon,$codpolo=null){
		$sql = "SELECT l.CodLead,
		l.RazaoSocial AS nome,
		DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data
		FROM leads l
		INNER JOIN ocorrenciaslead o ON l.CodLead = o.CodLead WHERE ";
		if ($gcon != null){
			$sql .= "CodGerenteConta in ($gcon) AND ";
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= "l.cod_polo=" . mysqlnull($codpolo) . " and ";
		}
		$sql .= "l.CodStatusClassificacaoLead = 3 GROUP BY l.CodLead";
		$sql .= " ORDER BY l.RazaoSocial";
		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['data'] = $row['data'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			$num++;
		}
		mysql_free_result($result);
		return $ret;
	}
	function rellead25($gcon,$codpolo=null){
		$sql = "SELECT l.CodLead,
		l.RazaoSocial AS nome,
		DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
		DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita
		FROM leads l
		INNER JOIN ocorrenciaslead o ON l.CodLead = o.CodLead
		INNER JOIN agendaslead ag ON l.CodLead = ag.CodLead WHERE ";
		if ($gcon != null){
			$sql .= "CodGerenteConta in ($gcon) AND ";
		}
		if($codpolo!=null&&$codpolo!=100){
			$sql .= "l.cod_polo=" . mysqlnull($codpolo) . " and ";
		}
		$sql .= "l.CodStatusClassificacaoLead = 4 GROUP BY l.CodLead";
		$sql .= " ORDER BY l.RazaoSocial";
		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['data'] = $row['data'];
			$ret[$num]['datavisita'] = $row['datavisita'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			$num++;
		}
		mysql_free_result($result);
		return $ret;
	}
	function rellead50($gcon,$codpolo=null){
		/*$sql = "SELECT l.CodLead,
		l.RazaoSocial AS nome,
		DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
		DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita
		FROM leads l
		INNER JOIN ocorrenciaslead o ON l.CodLead = o.CodLead
		INNER JOIN agendaslead ag ON l.CodLead = ag.CodLead
		INNER JOIN propostas p ON l.CodLead = p.CodLead
		WHERE ";
		if ($gcon != null)$sql .= "CodGerenteConta in ($gcon) AND ";
		if($codpolo!=null&&$codpolo!=100) $sql .= "l.cod_polo=" . mysqlnull($codpolo) . " and ";
		$sql .= "l.CodStatusClassificacaoLead = 5
		AND p.DataCancelamento IS null";
		$sql .= " GROUP BY l.CodLead";
		$sql .= " ORDER BY p.CodProposta DESC, p.Versao DESC";*/
		
		$sql = "select p.Codproposta, MAX(p.Versao) Versao, l.CodLead, l.RazaoSocial AS nome,
				DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
				DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita,
				DATE_FORMAT(p.DataPrevisaoRecebimento, '%d/%m/%Y') AS data_prev from propostas p
				left join leads l on (p.CodLead=l.CodLead)
				left join agendaslead ag on l.CodLead = ag.CodLead
				left join ocorrenciaslead o ON l.CodLead = o.CodLead
				where l.CodStatusClassificacaoLead = '5'
				and p.DataCancelamento is null
				and p.DataEstorno is null ";
		if ($gcon != null) $sql .= "and l.CodGerenteConta in ($gcon)";
		if ($codpolo!=null&&$codpolo!=100) $sql .= " and l.cod_polo=" . mysqlnull($codpolo);	
		$sql.= "group by p.Codproposta";
		$sql .= " ORDER BY l.RazaoSocial";

		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
			if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip' && $_SESSION['bd'] != 'bestpart_uniglobe' && $_SESSION['bd'] != 'bestpart_sorocaba_voip'){
				$codlead = $row['CodLead'];
				$codproposta =  $row['Codproposta'];
				$versao =  $row['Versao'];
				//SQL ANTIGO
				/*$sql = "SELECT mp.Valor AS qtdlinhas
						FROM modulosproposta mp
						INNER JOIN propostas p ON p.CodProposta = mp.CodProposta
						WHERE p.CodLead = $codlead
						AND p.DataCancelamento IS null
						AND (p.DataEnvioContrato IS null OR p.DataEnvioContrato = '')
						AND mp.ID = 'qtdelinhas'
						GROUP BY p.CodLead
						ORDER BY p.CodProposta DESC, p.Versao DESC";*/
				$sql = "select mp.valor as qtdlinhas from modulosproposta mp
						where mp.ID='qtdelinhas' and mp.Codproposta='$codproposta' and codlead='$codlead' and mp.Versao='$versao' order by mp.VERSAO desc limit 1;";
				
				$res1 = sql_query($sql);
				$res = mysql_fetch_array($res1);
			}
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['data'] = $row['data'];
			$ret[$num]['datavisita'] = $row['datavisita'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip' && $_SESSION['bd'] != 'bestpart_uniglobe' && $_SESSION['bd'] != 'bestpart_sorocaba_voip')
				$ret[$num]['qtdlinhas'] = number_format($res['qtdlinhas'], 0, ',', '.');
			$num++;
			mysql_free_result($res1);
		}
		mysql_free_result($result);
		return $ret;
	}
	function rellead75env($gcon,$codpolo=null){
		/*$sql = "SELECT l.CodLead,
		l.RazaoSocial AS nome,
		DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
		DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita,
		DATE_FORMAT(p.DataEnvioContrato, '%d/%m/%Y') AS data_envio,
		DATE_FORMAT(p.DataPrevisaoRecebimento, '%d/%m/%Y') AS data_prev
		FROM leads l
		INNER JOIN ocorrenciaslead o ON o.CodLead = l.CodLead
		INNER JOIN agendaslead ag ON l.CodLead = ag.CodLead
		INNER JOIN propostas p ON l.CodLead = p.CodLead
		WHERE ";
		if ($gcon != null)	$sql .= "CodGerenteConta in ($gcon) AND ";
		if($codpolo!=null&&$codpolo!=100) $sql .= "l.cod_polo=" . mysqlnull($codpolo) . " and ";
		$sql .= "l.CodStatusClassificacaoLead = 6
		AND p.DataEnvioContrato IS NOT null
		AND p.DataCancelamento IS null";
		$sql .= " GROUP BY l.CodLead";
		$sql .= " ORDER BY p.CodProposta DESC, p.Versao DESC";*/
		
		$sql = "select p.Codproposta, MAX(p.Versao) Versao, l.CodLead, l.RazaoSocial AS nome,
				DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
				DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita,
				DATE_FORMAT(p.DataEnvioContrato, '%d/%m/%Y') AS data_envio,
				DATE_FORMAT(p.DataPrevisaoRecebimento, '%d/%m/%Y') AS data_prev
				from propostas p
				left join leads l on (p.CodLead=l.CodLead)
				left join agendaslead ag on l.CodLead = ag.CodLead
				left join ocorrenciaslead o ON l.CodLead = o.CodLead
				where l.CodStatusClassificacaoLead = '6'
				and p.DataEnvioContrato is not null
				and p.DataCancelamento is null
				and p.DataEstorno is null ";
		if ($gcon != null) $sql .= "and l.CodGerenteConta in ($gcon)";
		if ($codpolo!=null&&$codpolo!=100) $sql .= " and l.cod_polo=" . mysqlnull($codpolo);	
		$sql.= "group by p.Codproposta";		
		$sql .= " ORDER BY l.RazaoSocial";
		
		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
			$codlead = $row['CodLead'];
			$codproposta =  $row['Codproposta'];
			$versao =  $row['Versao'];
			/*$sql = "SELECT mp.Valor AS qtdlinhas
					FROM modulosproposta mp
					INNER JOIN propostas p ON p.CodProposta = mp.CodProposta
					WHERE p.CodLead = $codlead
					AND p.DataEnvioContrato IS NOT null
					AND p.DataCancelamento IS null
					AND mp.ID = 'qtdelinhas'
					GROUP BY p.CodLead
					ORDER BY p.CodProposta DESC, p.Versao DESC";*/
			$sql = "select mp.valor as qtdlinhas from modulosproposta mp
					where mp.ID='qtdelinhas' and mp.CodProposta='$codproposta' and mp.Versao='$versao' and mp.CodLead ='$codlead' order by mp.VERSAO desc limit 1;";
			$res1 = sql_query($sql);
			$res = mysql_fetch_array($res1);
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['data'] = $row['data'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			$ret[$num]['data_envio'] = $row['data_envio'];
			$ret[$num]['datavisita'] = $row['datavisita'];
			$ret[$num]['data_prev'] = $row['data_prev'];
			$ret[$num]['qtdlinhas'] = number_format($res['qtdlinhas'], 0, ',', '.');
			$num++;
			mysql_free_result($res1);
		}
		mysql_free_result($result);
		return $ret;
	}
	function rellead75($gcon,$codpolo=null){
	
		/*$sql = "SELECT p.Codproposta, l.CodLead,
		l.RazaoSocial AS nome,
		DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
		DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita,
		DATE_FORMAT(p.DataPrevisaoRecebimento, '%d/%m/%Y') AS data_prev
		FROM leads l
		INNER JOIN ocorrenciaslead o ON l.CodLead = o.CodLead
		INNER JOIN agendaslead ag ON l.CodLead = ag.CodLead
		INNER JOIN propostas p ON l.CodLead = p.CodLead
		WHERE ";
		if ($gcon != null) $sql .= "CodGerenteConta in ($gcon) AND ";
		if($codpolo!=null&&$codpolo!=100) $sql .= "l.cod_polo=" . mysqlnull($codpolo) . " and ";
		$sql .= "l.CodStatusClassificacaoLead = 6";
		$sql .= " AND p.DataEnvioContrato IS null";
		$sql .= " AND p.DataCancelamento IS null";
		$sql .= " AND p.DataPrevisaoRecebimento IS NOT null";
		$sql .= " AND p.DataEstorno IS null";
		$sql .= " GROUP BY l.CodLead";
		$sql .= " ORDER BY p.CodProposta DESC, p.Versao DESC";*/
		
		$sql = "select p.Codproposta, MAX(p.Versao) Versao, l.CodLead, l.RazaoSocial AS nome,
				DATE_FORMAT(MAX(o.DataCadastro),'%d/%m/%Y-%H:%i') AS data,
				DATE_FORMAT(MAX(ag.DataHorario),'%d/%m/%Y-%H:%i') AS datavisita,
				DATE_FORMAT(p.DataPrevisaoRecebimento, '%d/%m/%Y') AS data_prev from propostas p
				left join leads l on (p.CodLead=l.CodLead)
				left join agendaslead ag on l.CodLead = ag.CodLead
				left join ocorrenciaslead o ON l.CodLead = o.CodLead
				where l.CodStatusClassificacaoLead = '6'
				and p.DataEnvioContrato is null
				and p.DataCancelamento is null
				and p.DataEstorno is null ";
		if ($gcon != null) $sql .= "and l.CodGerenteConta in ($gcon)";
		if ($codpolo!=null&&$codpolo!=100) $sql .= " and l.cod_polo=" . mysqlnull($codpolo);	
		$sql.= "group by p.Codproposta";
		$sql .= " ORDER BY l.RazaoSocial";
				
		$result = sql_query($sql);
		$ret = null;
		$num = 0;
		while($row = mysql_fetch_array($result)){
		if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip' && $_SESSION['bd'] != 'bestpart_uniglobe' && $_SESSION['bd'] != 'bestpart_sorocaba_voip'){
				$codlead = $row['CodLead'];
				$codproposta =  $row['Codproposta'];
				$versao =  $row['Versao'];
				//SQL ANTIGO
				/*$sql = "SELECT mp.Valor AS qtdlinhas
						FROM modulosproposta mp
						INNER JOIN propostas p ON p.CodProposta = mp.CodProposta
						WHERE p.CodLead = $codlead
						AND p.DataCancelamento IS null
						AND (p.DataEnvioContrato IS null OR p.DataEnvioContrato = '')
						AND mp.ID = 'qtdelinhas'
						GROUP BY p.CodLead
						ORDER BY p.CodProposta DESC, p.Versao DESC";*/
				$sql = "select mp.valor as qtdlinhas from modulosproposta mp
						where mp.ID='qtdelinhas' and mp.CodProposta='$codproposta' and mp.Versao='$versao' and mp.CodLead ='$codlead' order by mp.VERSAO desc limit 1;";
				$res1 = sql_query($sql);
				$res = mysql_fetch_array($res1);
				
			}
			$ret[$num]['nome'] = $row['nome'];
			$ret[$num]['data'] = $row['data'];
			$ret[$num]['CodLead'] = $row['CodLead'];
			$ret[$num]['datavisita'] = $row['datavisita'];
			$ret[$num]['data_prev'] = $row['data_prev'];
			if($_SESSION['bd'] != 'uniglobe' && $_SESSION['bd'] != 'sorocaba_voip' && $_SESSION['bd'] != 'bestpart_uniglobe' && $_SESSION['bd'] != 'bestpart_sorocaba_voip')
				$ret[$num]['qtdlinhas'] = number_format($res['qtdlinhas'], 0, ',', '.');
			$num++;
			mysql_free_result($res1);
		}
		mysql_free_result($result);
		return $ret;
	}
}
?>