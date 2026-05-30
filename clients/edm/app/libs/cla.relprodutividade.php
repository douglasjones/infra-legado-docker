<?
class relprodutividade {
	function visitas($codgerenteconta = false, $cod_polo = false, $data = false, $tipos = false) {
		$cont = 0;
		$dbnames = get_dbnames();
		foreach($dbnames as $dbname => $dbname1) {
			$sql = '
			SELECT COUNT(AG.CodAgendaLead) AS Visitas
			FROM usuariosinternos AS UI
			INNER JOIN agendagerenteconta AS AG ON UI.CodUsuarioInterno=AG.CodGerenteConta
			INNER JOIN agendaslead AS AL ON AG.CodAgendaLead=AL.CodAgendaLead
			LEFT JOIN leads LD ON LD.CodLead = AL.CodLead
			WHERE AL.CodStatus IN (1 , 2)';
			if($cod_polo && $cod_polo != 100){
				$sql.= ' AND LD.cod_polo='.$cod_polo;
			}
			if($codgerenteconta){
				$sql.= ' AND UI.CodUsuarioInterno='.$codgerenteconta;
			}
			if($data) {
				$sql.= ' AND AL.DataHorario BETWEEN '. mysqlnull($data.' 00:00:00').' AND '. mysqlnull($data.' 23:59:59');
			}
			if($tipos) {
				$sql.= 'AND AL.CodTipo IN(';
				if(is_array($tipos)) {
					foreach($tipos as $tipo) {
						$sql.= $tipo.', ';
					}
				}
				else {
					$sql.= $tipos;
				}
				$sql.= ')';
			}
			$fields[$cont] = mysql_fetch_array(sql_query($sql, $dbname));
			$cont++;
		}
		$ret = 0;
		foreach($fields as $field => $v) {
			$ret += $v['Visitas'];
		}
		return $ret;
	}
	function ocorrencias($codusuariointerno = false, $cod_polo = false, $data = false, $codocorrencialead = false) {
		$cont = 0;
		$dbnames = get_dbnames();
		foreach($dbnames as $dbname => $dbname1) {
			$sql = '
			SELECT COUNT(OL.CodOcorrenciaLead) AS Ocorrencias
			FROM usuariosinternos AS UI
			INNER JOIN ocorrenciaslead AS OL ON UI.CodUsuarioInterno=OL.CodUsuarioInterno
			LEFT JOIN leads LD ON LD.CodLead = OL.CodLead WHERE 1';
			if($cod_polo && $cod_polo != 100){
				$sql.= ' AND LD.cod_polo='.$cod_polo;
			}
			if($codusuariointerno){
				$sql.= ' AND UI.CodUsuarioInterno='.$codusuariointerno;
			}
			if($data) {
				$sql.= ' AND OL.DataCadastro BETWEEN '. mysqlnull($data.' 00:00:00').' AND '. mysqlnull($data.' 23:59:59');
			}
			if($codocorrencialead) {
				$sql.= ' AND OL.CodTipoOcorrenciaLead='.$codocorrencialead;
			}
			$sql.= ' AND OL.CodUsuarioInterno != 1';
			$fields[$cont] = mysql_fetch_array(sql_query($sql, $dbname));
			$cont++;
		}
		$ret = 0;
		foreach($fields as $field => $o) {
			$ret += $o['Ocorrencias'];
		}
		return $ret;
	}
	function prospects($codgerenteconta = false, $cod_polo = false, $data = false) {
		$cont = 0;
		$dbnames = get_dbnames();
		foreach($dbnames as $dbname => $dbname1) {
			$sql = '
			SELECT COUNT(LD.CodLead) AS Prospects
			FROM usuariosinternos AS UI
			INNER JOIN leads AS LD ON UI.CodUsuarioInterno=LD.CodGerenteConta
			INNER JOIN contatoslead CL ON LD.CodLead=CL.CodLead
			WHERE ( LD.mailing NOT LIKE "%Mailing%"	OR LD.mailing IS NULL OR LD.mailing="" )
			AND LENGTH(CL.NomeContato)>1';
			if($cod_polo && $cod_polo != 100){
				$sql.= ' AND LD.cod_polo='.$cod_polo;
			}
			if($codgerenteconta){
				$sql.= ' AND UI.CodUsuarioInterno='.$codgerenteconta;
			}
			if($data) {
				$sql.= ' AND LD.DataCadastro BETWEEN '. mysqlnull($data.' 00:00:00').' AND '. mysqlnull($data.' 23:59:59');
			}
			$sql.= ' AND LD.CodGerenteConta != 1';
			$fields[$cont] = mysql_fetch_array(sql_query($sql, $dbname));
			$cont++;
		}
		$ret = 0;
		foreach($fields as $field => $p) {
			$ret += $p['Prospects'];
		}

		return $ret;

	}
	
	function getMinutos()
	{
		$sql = "SELECT Minutos FROM tipoagendamento" ;
		$qry = sql_query( $sql ) ;

		$res['prospects'  ] = mysql_result( $qry , 0 , 0 ) ;
		$res['visProspect'] = mysql_result( $qry , 1 , 0 ) ;
		$res['ocorrencias'] = mysql_result( $qry , 2 , 0 ) ;
		$res['fechamento' ] = mysql_result( $qry , 3 , 0 ) ;

		return $res ;
	}

}

?>