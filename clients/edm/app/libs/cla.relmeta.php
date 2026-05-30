<?
class relmeta{
	function gconta($cod, $dti, $dtf, $dti2, $dtf2, $renov = 0){
		$sql = "SELECT SUM(mp.Valor) AS Res FROM modulosproposta mp
				INNER JOIN propostas p ON p.CodProposta = mp.CodProposta AND p.Versao = mp.Versao
				INNER JOIN leads l ON p.CodLead = l.CodLead
				WHERE l.CodGerenteConta = ".mysqlnull($cod);
		if($dti && $dtf){
			$sql .= " AND p.DataRecebimento BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}else if($dti){
			$sql .= " AND p.DataRecebimento >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
		}else if($dtf){
			$sql .= " AND p.DataRecebimento <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}
		if($dti2 && $dtf2){
			$sql .= " AND p.DataEntregaAparelho BETWEEN ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
		}else if($dti2){
			$sql .= " AND p.DataEntregaAparelho >= ". mysqlnull(date('Y-m-d', $dti2).' 00:00:00');
		}else if($dtf2){
			$sql .= " AND p.DataEntregaAparelho <= ". mysqlnull(date('Y-m-d', $dtf2).' 23:59:59');
		}
		if($renov) $sql .= " AND mp.ID = 'qtdelinhasrenovacao'";
		else $sql .= " AND mp.ID = 'qtdelinhasnovas'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$res = $row['Res'];
		mysql_free_result($result);
		return $res;
	}
	function atend($cod, $dti, $dtf){
		$sql = "SELECT COUNT(CodAgendaLead) AS Res FROM agendaslead
				WHERE CodStatus = 1
				AND (CodUsuarioInterno = ".mysqlnull($cod)." OR AgendadoPara = ".mysqlnull($cod).")";
		if($dti && $dtf){
			$sql .= " AND DataHorario BETWEEN ". mysqlnull(date('Y-m-d', $dti).' 00:00:00')." AND ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}else if($dti){
			$sql .= " AND DataHorario >= ". mysqlnull(date('Y-m-d', $dti).' 00:00:00');
		}else if($dtf){
			$sql .= " AND DataHorario <= ". mysqlnull(date('Y-m-d', $dtf).' 23:59:59');
		}
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$res = $row['Res'];
		mysql_free_result($result);
		return $res;
	}
	function get_dados($cod, $dti, $dtf, $dti2, $dtf2){
		$sql = "SELECT Atendente, GerenteContas FROM usuariosinternos WHERE CodUsuarioInterno = ".mysqlnull($cod);
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		if($row['Atendente'] == 1){
			$res = relmeta::atend($cod, $dti, $dtf);
		}
		if($row['GerenteContas'] == 1){
			$res = relmeta::gconta($cod, $dti, $dtf, $dti2, $dtf2);
		}
		mysql_free_result($result);
		return $res;
	}
	function get_renova($cod, $dti, $dtf, $dti2, $dtf2){
		$sql = "SELECT Atendente, GerenteContas FROM usuariosinternos WHERE CodUsuarioInterno = ".mysqlnull($cod);
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		if($row['Atendente'] == 1){
			$res = null;
		}
		if($row['GerenteContas'] == 1){
			$res = relmeta::gconta($cod, $dti, $dtf, $dti2, $dtf2, 1);
		}
		mysql_free_result($result);
		return $res;
	}
	function get_meta($cod){
		$sql = "SELECT Meta FROM usuariosinternos WHERE CodUsuarioInterno = ".mysqlnull($cod);
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($result);
		mysql_free_result($result);
		return $row['Meta'];
	}
}
?>