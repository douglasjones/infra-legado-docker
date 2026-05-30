<?
class paginas {
	function salvarPaginas($codgrupousuariointerno){
		$sql = "Delete From gruposusuariosinternos_paginas Where CodGrupoUsuarioInterno = " . mysqlnull($codgrupousuariointerno);
		sql_query($sql);
		$sql = "Select * from paginas";
		$rs = sql_query($sql);
		while($row = mysql_fetch_array($rs)){
			$ic = 0;
			$al = 0;
			$ex = 0;
			$cs = 0;
			$dt = 0;
			if(isset($_REQUEST['ic'.$row['CodPagina']])) $ic = $_REQUEST['ic'.$row['CodPagina']];
			if(isset($_REQUEST['al'.$row['CodPagina']])) $al = $_REQUEST['al'.$row['CodPagina']];
			if(isset($_REQUEST['ex'.$row['CodPagina']])) $ex = $_REQUEST['ex'.$row['CodPagina']];
			if(isset($_REQUEST['cs'.$row['CodPagina']])) $cs = $_REQUEST['cs'.$row['CodPagina']];
			if(isset($_REQUEST['dt'.$row['CodPagina']])) $dt = $_REQUEST['dt'.$row['CodPagina']];
			$sql = "Insert Into gruposusuariosinternos_paginas (CodGrupoUsuarioInterno, CodPagina, IC, AL, EX, CS, DT) ";
			$sql .= " Values (" . mysqlnull($codgrupousuariointerno) . ", {$row['CodPagina']}, $ic, $al, $ex, $cs, $dt)";
			sql_query($sql);
		}
		mysql_free_result($rs);
	}
}
?>