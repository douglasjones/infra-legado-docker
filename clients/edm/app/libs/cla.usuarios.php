<?	
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/pwcr.php";
include_once "../../libs/cla.logg.php";

class usuarios {
	function salvar($value){
		if(!$value['CodUsuarioInterno']){
			return usuarios::adicionar($value);
		}else{
			return usuarios::alterar($value['CodUsuarioInterno'], $value);
		}
	}
	
	function adicionar($value){
		if(empty($value['coddepartamento'])) $value['coddepartamento'] = null;
		if(empty($value['nome'])) return false;
		if(empty($value['login'])) return false;
		$value['senha'] = 'gepros';
		if(empty($value['codusuariosuperior'])) $value['codusuariosuperior'] = 0;
		if(empty($value['desativado'])) $value['desativado'] = -1;
		if(empty($value['gerentecontas'])) $value['gerentecontas'] = 0;		
		if(empty($value['atendente'])) $value['atendente'] = 0;
		if(empty($value['meta'])) $value['meta'] = 0;
		if(empty($value['cod_polo'])) $value['cod_polo'] = null;
		if(empty($value['cod_atividade_profissional'])) $value['cod_atividade_profissional'] = 0;
		if(empty($value['cod_classificacao'])) $value['cod_classificacao'] = 0;
		if(empty($value['cod_regime'])) $value['cod_regime'] = null;
		//if(empty($value['meta_moeda'])) $value['meta_moeda'] = 0;
		if(!$value['dat_adm']) $value['dat_adm']  = 'NOW()';
		if(!$value['dat_dem']) $value['dat_dem']  = null;
		if(!$value['ddd_tel']) $value['ddd_tel']  = null;
		if(!$value['tel']) $value['tel']  = null;
		if(!$value['emei']) $value['emei']  = null;
		if(!$value['email']) $value['email']  = null;
		if(!$value['cod_empresa']) $value['cod_empresa']  = null;
		if(empty($value['meta_moeda'])) $value['meta_moeda'] = 0;
		if(!$value['codigosa3']) $value['codigosa3']  = null;

		$fields = array();
		$fields['coddepartamento'] = $value['coddepartamento'];
		$fields['nome'] = $value['nome'];
		$fields['login'] = $value['login'];
		$fields['senha'] = pwcrypt($value['senha']);
		$fields['codusuariosuperior'] = $value['codusuariosuperior'];
		$fields['desativado'] = $value['desativado'];
		$fields['gerentecontas'] = $value['gerentecontas'];
		$fields['atendente'] = $value['atendente'];
		$fields['meta'] = $value['meta'];
		if(!empty($value['cod_polo'])){
			$fields['cod_polo'] = $value['cod_polo'];
		}else{
			$fields['cod_polo'] = "null";
		}
		$fields['cod_atividade_profissional'] = $value['cod_atividade_profissional'];
		$fields['cod_classificacao'] = $value['cod_classificacao'];
		$fields['cod_regime'] = $value['cod_regime'];
		//$fields['meta_moeda'] = $value['meta_moeda'];
		$fields['dat_adm'] = ($value['dat_adm']!='NOW()'?substr($value['dat_adm'],6,4)."-".substr($value['dat_adm'],3,2)."-".substr($value['dat_adm'],0,2):'NOW()');
		$fields['dat_dem'] = ($value['dat_dem']?substr($value['dat_dem'],6,4)."-".substr($value['dat_dem'],3,2)."-".substr($value['dat_dem'],0,2):'null');
		$fields['ddd_tel'] = $value['ddd_tel'];
		$fields['tel'] = $value['tel'];
		$fields['emei'] = $value['emei'];
		$fields['email'] = $value['email'];
		$fields['cod_empresa'] = $value['cod_empresa'];
		$fields['meta_moeda'] = $value['meta_moeda'];
		$fields['codigosa3'] = $value['codigosa3'];
		
		$table = 'usuariosinternos';
		$into = array();
		$values = array();
		foreach($fields as $field => $val){
			$into[] = $field;
			$values[] = mysqlnull($val);
		}
		$into = implode(", ", $into);
		$values = implode(", ", $values);
		$sql = "Insert Into $table ($into) Values (" . $values . ")";
		mysql_query($sql) or die(mysql_error());
	
		$codusuariointerno = mysql_insert_id();
		//Atribui o novo usuario a uma equipe					
		if(!empty($value['TK_equipe'])){
			$equipe = $value['TK_equipe'];				
			$sql = "insert into tb_usuarioequipe (Fk_Usuario,Fk_Equipe)values($codusuariointerno,$equipe)";
		mysql_query($sql) or die(mysql_error());	
		}
		if(isset($value['codgrupousuariointerno']))
			usuarios::salvarGrupos($codusuariointerno, $value['codgrupousuariointerno']);
	
		logg::insert(5, $codusuariointerno);
		return $codusuariointerno;

	}

	function alterar($codusuariointerno, $value){
		
		if(empty($value['coddepartamento'])) $value['coddepartamento'] = 0;
		if(empty($value['nome'])) return false;
		if(empty($value['login'])) return false;
		if(empty($value['codusuariosuperior'])) $value['codusuariosuperior'] = 0;
		if(empty($value['desativado'])) $value['desativado'] = -1;
		if(empty($value['gerentecontas'])) $value['gerentecontas'] = 0;
		if(empty($value['atendente'])) $value['atendente'] = 0;
		if(empty($value['meta'])) $value['meta'] = 0;
		if(empty($value['cod_polo'])) $value['cod_polo'] = null;
		if(empty($value['cod_atividade_profissional'])) $value['cod_atividade_profissional'] = 0;
		if(empty($value['cod_classificacao'])) $value['cod_classificacao'] = 0;
		if(empty($value['cod_regime'])) $value['cod_regime'] = null;
		if(!$value['dat_adm']) $value['dat_adm']  = 'NOW()';
		if(!$value['dat_dem']) $value['dat_dem']  = 0;
		if(!$value['ddd_tel']) $value['ddd_tel']  = null;
		if(!$value['tel']) $value['tel']  = null;
		if(!$value['emei']) $value['emei']  = null;
		if(!$value['email']) $value['email']  = null;
		if(!$value['cod_empresa']) $value['cod_empresa']  = null;
		if(empty($value['meta_moeda'])) $value['meta_moeda'] = 0;
		if(!$value['codigosa3']) $value['codigosa3']  = null;

		$fields = array();
		$fields['coddepartamento'] = $value['coddepartamento'];
		$fields['nome'] = $value['nome'];
		$fields['login'] = $value['login'];
		if(!empty($value['senha'])){
			$fields['senha'] = pwcrypt('gepros');
		}
		$fields['codusuariosuperior'] = $value['codusuariosuperior'];
		$fields['desativado'] = $value['desativado'];
		$fields['gerentecontas'] = $value['gerentecontas'];
		$fields['atendente'] = $value['atendente'];
		$fields['meta'] = $value['meta'];
		if(!empty($value['cod_polo'])){
			$fields['cod_polo'] = $value['cod_polo'];
		}else{
			$fields['cod_polo'] = "null";
		}
		$fields['cod_atividade_profissional'] = $value['cod_atividade_profissional'];
		$fields['cod_classificacao'] = $value['cod_classificacao'];
		$fields['cod_regime'] = $value['cod_regime'];
		$fields['dat_adm'] = ($value['dat_adm']!='NOW()'?substr($value['dat_adm'],6,4)."-".substr($value['dat_adm'],3,2)."-".substr($value['dat_adm'],0,2):'NOW()');
		$fields['dat_dem'] = ($value['dat_dem']?substr($value['dat_dem'],6,4)."-".substr($value['dat_dem'],3,2)."-".substr($value['dat_dem'],0,2):'null');
		$fields['ddd_tel'] = $value['ddd_tel'];
		$fields['tel'] = $value['tel'];
		$fields['emei'] = $value['emei'];
		$fields['email'] = $value['email'];
		$fields['cod_empresa'] = $value['cod_empresa'];
		$fields['meta_moeda'] = $value['meta_moeda'];
		$fields['codigosa3'] = $value['codigosa3'];
		
		$sql = sqlupdate('usuariosinternos', $fields, ' CodUsuarioInterno = ' . mysqlnull($codusuariointerno));
		
		sql_query($sql);
		
		if(!empty($value['codgrupousuariointerno'])){
			usuarios::salvarGrupos($codusuariointerno, $value['codgrupousuariointerno']);
		}
		
		//Atribui o novo usuario a uma equipe
	
						
		if(!empty($value['TK_equipe'])){
			$equipe = $value['TK_equipe'];	
			$sql =  "Select Fk_Equipe
					 from tb_usuarioequipe
					 where Fk_Usuario=$codusuariointerno";
			$result = sql_query($sql);
			$row = mysql_fetch_array($result);
			$TK_equipe = $row['Fk_Equipe'];			
			if(!empty($TK_equipe)){	
				$sql = "update tb_usuarioequipe set Fk_Equipe=$equipe  where Fk_Usuario=$codusuariointerno";
				mysql_query($sql) or die(mysql_error());			
			}else{	
				//Correзгo Equipe Seleзгo 20/01/2010										
				$sql = "insert into tb_usuarioequipe (Fk_Usuario,Fk_Equipe)values($codusuariointerno,$equipe)";
				mysql_query($sql) or die(mysql_error());	
			}
		}else{
			//Limpa a a equipe retirando o vinculo da equipe			
			$sql = "delete from tb_usuarioequipe where Fk_Usuario=$codusuariointerno";
			
			mysql_query($sql) or die(mysql_error());
		}
		
		
		logg::insert(6, $codusuariointerno);
		return $codusuariointerno;
	}

	

	function salvarGrupos($codusuariointerno, $grupos){

		$sql = "delete from gruposusuariosinternos_usuariosinternos where codusuariointerno = " . mysqlnull($codusuariointerno);

		sql_query($sql);

		foreach($grupos as $grupo){

			$sql = sqlinsert('gruposusuariosinternos_usuariosinternos', array('codgrupousuariointerno' => $grupo, 'codusuariointerno' => $codusuariointerno));

			sql_query($sql);

		}

	}
	
	#Essa Funзгo Retorna Lista de Dependentes do Usuario, Respeitando regras bбsicas de Hierarquia por Equipes (Renato 22-05-09).
	function dependentes($CodUsuarioInterno, $tipo){

		$result = sql_query("SELECT * FROM ((SELECT ue.Fk_Usuario FROM tb_usuarioequipe ue 
							 LEFT JOIN tb_equipesvendas ev on (ue.Fk_Equipe =ev.Tk_Equipe)
							 LEFT JOIN usuariosinternos ui on (ue.Fk_Usuario=ui.CodUsuarioInterno) 
							 WHERE ev.Fk_Gerente = '".$CodUsuarioInterno."') 
							 UNION ALL
							 (SELECT ue.Fk_Usuario FROM tb_usuarioequipe ue
							 LEFT JOIN tb_equipesvendas ev ON (ue.Fk_Equipe =ev.Tk_Equipe)
							 LEFT JOIN usuariosinternos ui on (ue.Fk_Usuario=ui.CodUsuarioInterno)
							 WHERE ev.Fk_Lider = '".$CodUsuarioInterno."')
							 UNION ALL(SELECT ev.Fk_Lider Fk_Usuario from tb_equipesvendas ev WHERE ev.Fk_Gerente='".$CodUsuarioInterno."')
							 UNION ALL(SELECT '".$CodUsuarioInterno."' Fk_Usuario)) dependentes group by Fk_Usuario;");
							   
		$i=0; $lista = Array();
		while($row = mysql_fetch_array($result))
		{
			$lista[$i] = $row['Fk_Usuario'];
			$i++;
		}
		
			switch ($tipo)
			{
				case '1': //Retorna Modo Vetor.
				{
						return $lista;
				break;
				}
			
				case '2': //Retorna Mode String para Select WHERE IN
				{
						$dep = '';
						foreach($lista as $dependente)
						((!empty($dep))? $dep.= ",'".$dependente."'": $dep= "'".$dependente."'");
	
						return $dep;
				break;
				}
			}
	}
	
	#Essa Funзгo Retorna True se o Usuario for pertencente ao grupo Administrador de Sistemas caso contrбrio retorna False (Renato 22-05-09).
	function administrador($CodUsuarioInterno){
		$result = sql_query("SELECT COUNT(*) FROM gruposusuariosinternos_usuariosinternos 
							WHERE CodUsuarioInterno='".$CodUsuarioInterno."' AND CodGrupoUsuarioInterno='2';");
		$retorno= mysql_result($result,0);
		($retorno>0? $administrador = true: $administrador = false);
		return $administrador;		
	}
	
	function telemarketing($CodUsuarioInterno){
		$result = sql_query("SELECT COUNT(*) FROM gruposusuariosinternos_usuariosinternos 
							WHERE CodUsuarioInterno='".$CodUsuarioInterno."' AND CodGrupoUsuarioInterno='2';");
		$retorno= mysql_result($result,0);
		($retorno>0? $telemarketing = true: $telemarketing = false);
		return $telemarketing;
	}
}
?>