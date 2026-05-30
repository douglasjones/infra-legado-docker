<?
class equipes {
	function ins_equipe($nome, $lider, $gerente){
		$sql = "SELECT Tk_Equipe FROM tb_equipesvendas WHERE Vc_nome LIKE ".mysqlnull($nome);
		$exists = mysql_num_rows(sql_query($sql));
		if ($exists){
			return "Já existe uma equipe com esse nome.";
		}else{
			$sql = "INSERT INTO tb_equipesvendas (Vc_Nome, Fk_Lider, Fk_Gerente) VALUES (".mysqlnull($nome).", ".mysqlnull($lider).", ".mysqlnull($gerente).")";
			sql_query($sql);
			return "Equipe cadastrada com sucesso.";
		}
	}
	function ins_usuario($equipe, $usuario){
		$sql = "SELECT Fk_Equipe FROM tb_usuarioequipe WHERE Fk_Usuario = ".mysqlnull($usuario);
		$exists = mysql_num_rows(sql_query($sql));
		if ($exists){
			return "Este vendedor já está cadastrado em uma equipe.";
		}else{
			$sql = "INSERT INTO tb_usuarioequipe (Fk_Equipe, Fk_Usuario) VALUES ($equipe, $usuario)";
			sql_query($sql);
			return "Usuário cadastrado com sucesso.";
		}
	}
	function get_equipes($polo = null){
		$sql = "SELECT eq.Tk_Equipe AS cod, eq.Vc_nome AS equipe, u.Nome AS lider, u2.Nome AS gerente FROM tb_equipesvendas eq INNER JOIN usuariosinternos u ON u.CodUsuarioInterno = eq.Fk_lider LEFT JOIN usuariosinternos u2 ON u2.CodUsuarioInterno = eq.Fk_Gerente WHERE 1";
		if($polo && $polo != 100) $sql .= " and u.cod_polo = $polo";
		$ret = sql_query($sql);
		return $ret;
	}
	function get_equipe($equipe){
		$sql = "SELECT eq.Vc_nome AS equipe, ui.Nome AS usuario, ue.Fk_Usuario AS codusr FROM tb_equipesvendas eq 
				INNER JOIN tb_usuarioequipe ue ON ue.Fk_Equipe = eq.Tk_Equipe 
				INNER JOIN usuariosinternos ui ON ui.CodUsuarioInterno = ue.Fk_Usuario 
				WHERE ui.Desativado = -1
				AND eq.Tk_Equipe = ".mysqlnull($equipe);
		$ret = sql_query($sql);
		return $ret;
	}
/*	function get_usuarios(){
		$sql = "SELECT ue.Fk_equipe AS codeqp, ui.Nome AS usuario, ue.Fk_Usuario AS codusr FROM tb_usuarioequipe ue INNER JOIN usuariosinternos ui ON ui.CodUsuarioInterno = ue.Fk_Usuario WHERE 1";
		$ret = sql_query($sql);
		return $ret;
	} */
	function upd_equipe($cod, $nome, $lider, $gerente){
		$sql = "UPDATE tb_equipesvendas
				SET Vc_Nome = ".mysqlnull($nome).", Fk_Lider = ".mysqlnull($lider).", Fk_Gerente = ".mysqlnull($gerente)."
				WHERE Tk_Equipe = ".mysqlnull($cod);
		sql_query($sql);
		return "Equipe atualizada com sucesso.";
	}
	function del_equipe($cod){
		$sql = "DELETE FROM tb_equipesvendas WHERE Tk_Equipe = ".mysqlnull($cod);
		sql_query($sql);
		$sql = "DELETE FROM tb_usuarioequipe WHERE Fk_Equipe = ".mysqlnull($cod);
		sql_query($sql);
		return "Equipe excluida com sucesso.";
	}
	function del_usuario($cod){
		$sql = "DELETE FROM tb_usuarioequipe WHERE Fk_Usuario = ".mysqlnull($cod);
		sql_query($sql);
		return "Usuário excluido com sucesso.";
	}
	function is_gerente($codusuario){
                
		$gerequipe = 0;
		$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where Fk_Gerente = $codusuario");
		while($row = mysql_fetch_array($result)){
			$gerequipe .= ",".$row['Tk_Equipe'];
		}
                
		@mysql_free_result($result);
		return $gerequipe;
	}
	function is_supervisor($codusuario){
		$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
		@$equipe = mysql_result($result,0);
		@mysql_free_result($result);
		return $equipe;
	}
	
	function getEquipe($codusuario){
		
		$strRetorno = "";
		$sql = "";
		$sql.="select e.fk_equipe fk_equipe ";
		$sql.="  from tb_usuarioequipe e ";
		$sql.="        inner join tb_equipesvendas ev on e.fk_equipe = ev.tk_equipe ";
		$sql.=" where 1=1 ";
		$sql.=" and (ev.fk_lider = $codusuario ";
		$sql.=" or ev.fk_gerente = $codusuario or e.fk_usuario = $codusuario) ";
		$sql.="union ";
		$sql.="select ev.tk_equipe fk_equipe ";
		$sql.="  from tb_usuarioequipe e ";
		$sql.="       inner join tb_equipesvendas ev on e.fk_equipe = ev.tk_equipe ";
		$sql.="  where 1=1 ";
		$sql.="    and (ev.fk_gerente = $codusuario) ";
		
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno.=$row['fk_equipe'].",";
		}
		mysql_free_result($result);
		$strRetorno.="0";
		
		return $strRetorno;
		
	}
	
	function getCodUsuariosEquipe($codusuario){
		
		$strRetorno = "";
		
		$sql ="";
		$sql.="select e.fk_usuario fk_usuario	";
		$sql.="  from tb_usuarioequipe e ";
		$sql.="        inner join tb_equipesvendas ev on e.fk_equipe = ev.tk_equipe	 ";
		$sql.=" where 1=1 ";
		$sql.=" and (ev.fk_lider = $codusuario ";
		$sql.=" or ev.fk_gerente = $codusuario or e.fk_usuario = $codusuario) ";
		$sql.="union ";
		$sql.="select ev.fk_lider fk_usuario ";
		$sql.="  from tb_usuarioequipe e ";
		$sql.="       inner join tb_equipesvendas ev on e.fk_equipe = ev.tk_equipe ";
		$sql.="  where 1=1 ";
		$sql.="    and (ev.fk_gerente = $codusuario) ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno.=$row['fk_usuario'].", ";
		}
		$strRetorno.="$codusuario";
		mysql_free_result($result);
		
		return $strRetorno;
		
	}
	
}
?>