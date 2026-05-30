<?
include_once "../../libs/combo.php";
include_once "../../libs/cla.equipes.php";
class combo{
	function consultor($GerenteContas,$NomeUsuario){
		if($gerequipe = equipes::is_gerente($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe in ($gerequipe)
					Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}elseif($equipe = equipes::is_supervisor($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe = $equipe
					Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
			echo $NomeUsuario;
		}else{
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado";
			$sql .= " from agendagerenteconta a inner join usuariosinternos u on a.CodGerenteConta = u.CodUsuarioInterno";
			$sql .= " Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			// Funчуo combo tipos
			combo_tipos($sql,"codgerenteconta", $tipos, "", "-- Todos --");
		}
	}

	function consultor_ag($GerenteContas,$NomeUsuario, $codgerenteconta){
		$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
				join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
				where codusuariointerno not in ($codgerenteconta 0)";
		if($_SESSION['cod_polo']<>100){
				$sql .= " and cod_polo=".$_SESSION['cod_polo'];
		}
		if($gerequipe = equipes::is_gerente($_SESSION['codusuario'])){
			$sql .= "and ue.Fk_Equipe in ($gerequipe)
					Order By Desativado, Nome";
		}elseif($equipe = equipes::is_supervisor($_SESSION['codusuario'])){
			$sql .=	"and ue.Fk_Equipe = $equipe
					Order By Desativado, Nome";
		}else{
			$sql .= " Order By Desativado, Nome";
		}
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		// Funчуo combo tipos
		combo_tipos($sql,"CodGerenteConta", $tipos, "", "");
	}

	function polo(){
		if(!empty($_SESSION['cod_polo']) && $_SESSION['cod_polo'] != 100){
			//Usuario Padrao
			$sql = "";
			$sql .= "Select p.cod_polo, c.dsc_cidade from polo p";
			$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
			$sql .= " where p.cod_polo=".$_SESSION['cod_polo'];
			$sql .= " Order By c.dsc_cidade ";

			$result = sql_query($sql);

			$lead = mysql_fetch_array($result);

			echo $lead['dsc_cidade'];

			?><input type="Hidden" name="cod_polo" value="<?=$_SESSION['cod_polo']?>"><?

		}else{
			//Usuario Diferenciado
			$sql = "";
			$sql .= "Select p.cod_polo, c.dsc_cidade from polo p";
			$sql .= " inner join cidade c on p.cod_cidade = c.cod_cidade ";
			$sql .= " Order By c.dsc_cidade ";
			combo($sql, "cod_polo", @$_SESSION['cod_polo'], " ", "");
		}
	}
	
	function atendente($Atendente, $NomeUsuario){
		if($Atendente && !permissao('leadoutrogerente', 'al')){
			echo $NomeUsuario;
		}else{
			$sql = "SELECT DISTINCT CodUsuarioInterno, Nome, Desativado
			FROM usuariosinternos
			WHERE Atendente=1
			ORDER BY Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			// Funчуo combo_tipos
			combo_tipos($sql,"codatendente", $tipos, "", "-- Todos --", "");
		}
	
	}

	function user($tabela){
		$sql = "select distinct o.CodUsuarioInterno, u.Nome, u.Desativado ";
		$sql .= " from $tabela o";
		$sql .= " inner join usuariosinternos u on o.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		// Funчуo combo_tipos
		combo_tipos($sql, "codusuariointerno", $tipos, "", "-- Todos --", "");
	}
	
	function log_acao()
	{
		$sql = "SELECT cod_acao , dsc_acao FROM log_acao WHERE 1" ;
		// Funчуo combo_tipos
		combo( $sql, "acao" , "" , "-- Todos --" ) ;
	}

	function usuario($GerenteContas,$NomeUsuario){
		if($GerenteContas && !permissao('leadoutrogerente', 'al')){
			echo $NomeUsuario;
		}else{
			$sql = "select CodUsuarioInterno, Nome, Desativado ";
			$sql .= " from usuariosinternos u ";
			$sql .= " where Atendente = 1 or GerenteContas = 1";
			$sql .= " Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			// Funчуo combo tipos
			combo_meta($sql,"codgerenteconta", $tipos, "", "-- Todos --", "", "all", "allat", "allgc", "Todos Atendentes", "Todos Consultores");
		}
	}

	function padrao($tabela, $nome, $default = ""){
		$sql = "select * from $tabela Order By Descricao";
		// Funчуo combo
		combo($sql, $nome, $default, "-- Todos --");
	}

	function tipo($default = ""){
		$sql = "select * from tipoagendamento Order By Descricao";
		// Funчуo combo
		combo($sql, "codtipo", "", "-- Todos --");
	}
	
	function status_ag($default = ""){
		$sql = "select * from statusagendamento Order By Descricao";
		//Funчуo combo
		combo($sql, "codstatus", "", "-- Todos --");
	}

	function status_ld($default = ""){
		$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead";
		// Funчуo combo
		combo($sql,"codstatusclassificacaolead", "", " ", "");
	}

	function equipe($GerenteContas = 0){	
		$d = "";
		$sql = "SELECT eq.Tk_Equipe AS cod, eq.Vc_nome AS equipe FROM tb_equipesvendas eq
				INNER JOIN usuariosinternos u ON u.CodUsuarioInterno = eq.Fk_lider WHERE 1";
		if($gerequipe = equipes::is_gerente($_SESSION['codusuario']))
			$sql .= " AND Tk_Equipe in ($gerequipe)";
		elseif($equipe = equipes::is_supervisor($_SESSION['codusuario']))
			$sql .= " AND Tk_Equipe = $equipe";
		elseif($GerenteContas)
			$d = "disabled";
		// Funчуo combo
		combo($sql,"codequipe", "", "-- Todas --", $d);
	}

	function agdo_por(){
		$sql = "select distinct a.CodUsuarioInterno, u.Nome, u.Desativado ";
		$sql .= " from agendaslead a";
		$sql .= " inner join usuariosinternos u on a.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		// Funчуo combo tipos
		combo_tipos($sql,"codusuariointerno", $tipos, "", "-- Todos --");
	}

	function agdo_para(){	
		$sql = "select distinct a.AgendadoPara, u.Nome, u.Desativado ";
		$sql .= " from agendaslead a";
		$sql .= " inner join usuariosinternos u on a.AgendadoPara = u.CodUsuarioInterno";
		$sql .= " Order By Desativado, Nome";
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		// Funчуo combo tipos
		combo_tipos($sql, "agendadopara", $tipos, "", "-- Todos --");
	}
	function grupo(){
		$sql = "select distinct g.CodGrupoUsuarioInterno, g.Nome ";
		$sql .= " from agendaslead a";
		$sql .= " left join usuariosinternos u on a.AgendadoPara = u.CodUsuarioInterno Or a.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos_usuariosinternos gu on gu.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos g on gu.CodGrupoUsuarioInterno = g.CodGrupoUsuarioInterno";
		$sql .= " Where g.CodGrupoUsuarioInterno Is Not Null";
		$sql .= " Order By g.Nome";
		combo($sql,"grupousuariointerno", "", "-- Todos --");
	}
	function mailing(){
		$sql = "select Distinct Mailing, Mailing from leads Order By Mailing";
		combo($sql,"mailing", "", " ", "");
	}
	
	function cons_eqp($GerenteContas){
		$sql = "select * from tb_equipesvendas where Fk_Lider = ".$_SESSION['codusuario'];
		$query = mysql_query($sql);
		if($row = mysql_fetch_array($query)){
			$sql = "select Distinct CodUsuarioInterno, Nome, Desativado ";
			$sql .= " from usuariosinternos u ";
			$sql .= " inner join leads l ";
			$sql .= " on u.CodUsuarioInterno = l.CodGerenteConta ";
			$sql .= " inner join tb_usuarioequipe ue ";
			$sql .= " on u.CodUsuarioInterno = ue.Fk_Usuario ";
			$sql .= " where ue.Fk_Equipe = ".$row['Tk_Equipe'];
			$sql .= " or u.CodUsuarioInterno = ".$row['Fk_Lider'];
			$sql .= " Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			combo_tipos($sql,"codgerenteconta", $tipos, ($GerenteContas && !permissao('leadoutrogerente', 'al')?$_SESSION['codusuario']:null), "Todos da equipe", "", "eqp");
		}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
			?><input type="hidden" name="codgerenteconta" id="codgerenteconta" value="<?=$_SESSION['codusuario'];?>"><?					
			echo $_SESSION['nomeusuario'];
		}else{
			$sql = "select Distinct CodUsuarioInterno, Nome, Desativado ";
			$sql .= " from usuariosinternos u ";
			$sql .= " inner join leads l ";
			$sql .= " on u.CodUsuarioInterno = l.CodGerenteConta ";
			$sql .= " Order By Desativado, Nome";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			combo_tipos($sql,"codgerenteconta", $tipos, ($GerenteContas && !permissao('leadoutrogerente', 'al')?$_SESSION['codusuario']:null), "Todos", "");
		}
	}
}?>