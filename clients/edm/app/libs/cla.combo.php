<?
include_once "combo.php";
include_once "cla.equipes.php";

class combo{
	function consultor($GerenteContas,$NomeUsuario)
	{
	
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;

		if($gerequipe = equipes::is_gerente($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe in ($gerequipe)
					Order By Desativado, Nome";
			
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}elseif($equipe = equipes::is_supervisor($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe = $equipe
					Order By Desativado, Nome";
			
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}
		elseif ( $GerenteContas && !permissao('leadoutrogerente', 'al' ) || $GerenteContas && !permissao('leadoutrogerente', 'dt' ) )
			echo $NomeUsuario;
		else
		{
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado";
			$sql .= " from agendagerenteconta a inner join usuariosinternos u on a.CodGerenteConta = u.CodUsuarioInterno";
			$sql .= " Order By Desativado, Nome";
			
			// Fun&#231;&#227;o combo tipos*/
			combo_tipos($sql,"codgerenteconta", $tipos, "", "-- Todos --");
		}
	}
	
	//exibe todos os consultores
	function consultor_all(){
	
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
	
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where gerentecontas = 1 ";
		
		
		
		combo_tipos($sql,"codgerenteconta", $tipos, "", "-- Todos --");
	}
	
	//exibe todos os consultores
	function consultor_all_cad($codgerenteconta){
	
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
	
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where gerentecontas = 1 ";
		
		combo_tipos($sql,"codgerenteconta", $tipos, $codgerenteconta, " ");
	}	
	
	function consultor_equipe($codusuariointerno, $valordefault, $primeirovalor){
		
		$bol_exibetodos = true;
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where gerentecontas = 1 ";
		if(!permissao('visualizar_todos_consultores', 'cs')){
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			$bol_exibetodos = false;
		}
		
		if($_SESSION['cod_polo'] > 0){
			$sql.="  and u.cod_polo = ".$_SESSION['cod_polo']." ";
		}
		
		$sql.=" order by u.desativado, u.nome ";
		
		if(!permissao('visualizar_todos_consultores', 'cs'))
			combo_tipos($sql,"codgerenteconta", $tipos, $codusuariointerno, "");
		else
			combo_tipos($sql,"codgerenteconta", $tipos, $codusuariointerno, " ");
	}
	//
	function consultor_equipe1($codusuariointerno){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where gerentecontas = 1 ";
		if(!permissao('visualizar_todos_consultores', 'cs'))
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
		if($_SESSION['cod_polo'] > 0){
			//$sql.="  and u.cod_polo = ".$_SESSION['cod_polo']." ";
		}
		
		$sql.=" order by u.desativado, u.nome ";
        
		if(!permissao('visualizar_todos_consultores', 'cs'))				
			combo_nenhum($sql,"codgerenteconta", $tipos, $codusuariointerno, "");
		else			
			combo_nenhum($sql,"codgerenteconta", $tipos, $codusuariointerno," ","","","Nenhum");		
	}
	function atendente_equipe($codusuariointerno){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
	
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where atendente = 1 ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
		if($_SESSION['cod_polo'] > 0){
			$sql.="  and u.cod_polo = ".$_SESSION['cod_polo']." ";
		}
		$sql.=" order by u.desativado, u.nome ";
		
		combo_tipos($sql,"codatendente", $tipos, $codusuariointerno, " ");
	}
	


	 function atendente_equipe1($codusuariointerno){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
	
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where atendente = 1 ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		if($_SESSION['cod_polo'] > 0){
			$sql.="  and u.cod_polo = ".$_SESSION['cod_polo']." ";
		}
			
		$sql.=" order by u.desativado, u.nome ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			combo_nenhum($sql,"codatendente", $tipos, $codusuariointerno, "");
		else
			combo_nenhum($sql,"codatendente", $tipos, $codusuariointerno," ","","", "Nenhum");
		
	}	
	
	//Uduario
	function usuario1($AgendadoPara,$NomeUsuario)
	{
	
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;

		if($gerequipe = equipes::is_gerente($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe in ($gerequipe)
					Order By Desativado, Nome";
			
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}elseif($equipe = equipes::is_supervisor($_SESSION['codusuario'])){
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u
					inner join leads l on u.CodUsuarioInterno = l.CodGerenteConta
					join tb_usuarioequipe ue on ue.Fk_Usuario = u.CodUsuarioInterno
					Where l.CodStatusClassificacaoLead In (4, 5, 6)
					and ue.Fk_Equipe = $equipe
					Order By Desativado, Nome";
			
			combo_tipos($sql, "codgerenteconta", $tipos, null, "-- Todos --");
		}
		elseif ( $AgendadoPara && !permissao('AgendaRetorno', 'al' ) || $AgendadoPara && !permissao('AgendaRetorno', 'dt' ) )
			
			echo $NomeUsuario;
		else
		{
			$sql = "select distinct u.CodUsuarioInterno, u.Nome, u.Desativado";
			$sql .= " from usuariosinternos u ";
			$sql .= " Order By Desativado, Nome";
			
			// Fun&#231;&#227;o combo tipos*/
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
		
		// Fun&#231;&#227;o combo tipos
		combo_tipos($sql,"CodGerenteConta", $tipos, "", "");
	}
	//FUNCAO COMBO POLO
	function polo($polo,$local){
		$tipos['max'] = 1;	
		$sql .= "Select 
					p.cod_polo
					,p.n_polo
				from polo p
				where p.dat_canc is null ";
		if(!empty($_SESSION['cod_polo'])){
			$sql .= " and p.cod_polo=".$_SESSION['cod_polo'];
		}
		
		$sql .= " Order By p.n_polo ";
		if(empty($_SESSION['cod_polo'])){
			if(!empty($local)){
				combo_nenhum($sql,"cod_polo", $tipos, ""," ","","","Nenhum");	
				//combo($sql, "cod_polo", $polo," " , "validate='required'");
			}else{
				combo($sql, "cod_polo", $polo, " ", "");
			}
		}else{
			combo($sql, "cod_polo", $polo, "", "");
			
		}
	}	
	function atendente($Atendente, $NomeUsuario){
		$Atendente = $_SESSION['codusuario'];
		
		$sql = "SELECT codusuariointerno ";
		$sql .= "FROM gruposusuariosinternos_usuariosinternos g";
		$sql .= " Where codusuariointerno=".$Atendente;
		$sql .= " and codgrupousuariointerno=2";
	
		$result = sql_query($sql);
		$usuario = mysql_fetch_array($result);

		if($Atendente && !permissao('leadoutrogerente', 'al')){
			echo $NomeUsuario;
		}else{
			$sql = "SELECT DISTINCT CodUsuarioInterno, Nome, Desativado";
			$sql .= "  FROM usuariosinternos";
			$sql .= " WHERE Atendente=1"; 
			if(!empty($usuario['codusuariointerno'])){
				$sql .= " and codusuariointerno=".$usuario['codusuariointerno']; 
			}
			
			$sql .= " ORDER BY Desativado, Nome";
		
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			// Fun&#231;&#227;o combo_tipos
			if(!empty($usuario['codusuariointerno'])){
				combo_tipos($sql,"codatendente", $tipos, "", "", "");
			}else{
			combo_tipos($sql,"codatendente", $tipos, "", "-- Todos --", "");
			}
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
		// Fun&#231;&#227;o combo_tipos
		combo_tipos($sql, "codusuariointerno", $tipos, "", "-- Todos --", "");
	}
	
	function log_acao()
	{
		$sql = "SELECT cod_acao , dsc_acao FROM log_acao WHERE 1" ;
		// Fun&#231;&#227;o combo_tipos
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
			// Fun&#231;&#227;o combo tipos
			combo_meta($sql,"codgerenteconta", $tipos, "", "-- Todos --", "", "all", "allat", "allgc", "Todos Atendentes", "Todos Consultores");
		}
	}

	function padrao($tabela, $nome, $default = ""){
		$sql = "select * from $tabela Order By Descricao";
		// Fun&#231;&#227;o combo
		combo($sql, $nome, $default, "-- Todos --");
	}

	function tipo($default = ""){
		$sql = "select * from tipoagendamento Order By Descricao";
		// Fun&#231;&#227;o combo
		combo($sql, "codtipo", "", "-- Todos --");
	}
	
	function status_ag($default = ""){
		$sql = "select * from statusagendamento Order By Descricao";
		//Fun&#231;&#227;o combo
		combo($sql, "codstatus", "", "-- Todos --");
	}

	function status_ld($default = ""){
		$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead";
		// Fun&#231;&#227;o combo
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
		// Fun&#231;&#227;o combo
		combo($sql,"codequipe", "", " ", $d);
	}
	//Gangenda
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
		// Fun&#231;&#227;o combo tipos
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
		// Fun&#231;&#227;o combo tipos
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
	
	function mailing_cad($mailing){
		$sql = "select Distinct Mailing, Mailing from leads Order By Mailing";
		combo($sql,"mailing", $mailing, " ", "");
	}
	function combo_mailing($mailing_pk){
		
		$sql ="";
		$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						ORDER BY m.dsc_mailing";	
						
		combo( $sql, "mailing_pk" , $mailing_pk , " " ) ;
	}
	function cons_eqp($GerenteContas , $todos = "Todos"){
		$sql = "select * from tb_equipesvendas where Fk_Lider = ".$_SESSION['codusuario'];
		$query = mysql_query($sql);
		if ( $todos == "nao" ) $todos = " " ;
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;
		
		if($row = mysql_fetch_array($query)){
			$sql = "select Distinct CodUsuarioInterno, Nome, Desativado ";
			$sql .= " from usuariosinternos u ";
//			$sql .= " inner join leads l ";
//			$sql .= " on u.CodUsuarioInterno = l.CodGerenteConta ";
			$sql .= " inner join tb_usuarioequipe ue ";
			$sql .= " on u.CodUsuarioInterno = ue.Fk_Usuario ";
			$sql .= " where ue.Fk_Equipe = ".$row['Tk_Equipe'] . " AND u.GerenteContas = 1" ;
			$sql .= " or u.CodUsuarioInterno = ".$row['Fk_Lider'];
			$sql .= " Order By Desativado, Nome";
			
			combo_tipos($sql,"codgerenteconta", $tipos, ($GerenteContas && !permissao('leadoutrogerente', 'al')?$_SESSION['codusuario']:null), "Todos da equipe", "", "eqp");
			
		}elseif($GerenteContas && !permissao('leadoutrogerente', 'al')){
			?><input type="hidden" name="codgerenteconta" id="codgerenteconta" value="<?=$_SESSION['codusuario'];?>"><?					
			echo $_SESSION['nomeusuario'];
		}else{
			$sql = "select Distinct CodUsuarioInterno, Nome, Desativado ";
			$sql .= " from usuariosinternos u ";
			$sql .= " WHERE u.GerenteContas = 1 ";
			$sql .= " Order By Desativado, Nome";
		
			combo_tipos($sql,"codgerenteconta", $tipos, ($GerenteContas && !permissao('leadoutrogerente', 'al')?$_SESSION['codusuario']:null), $todos , "");
		}
		
	}
	function gerente(){
		$sql = "select distinct Fk_Gerente, Nome FROM usuariosinternos u
				INNER JOIN tb_equipesvendas e ON e.Fk_Gerente = u.CodUsuarioInterno";
		combo($sql, "codgerente", "", "-- Todas --", "");
	}
	function motivo(){
		$sql = "select CodMotivoLead, Descricao from motivoslead";
		combo($sql, "codmotivo", "", "-- Todos --", "");
	}
		function mobile_usuario($GerenteContas,$NomeUsuario){
		if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		?>
			<input type="hidden" name="gerentecontas" value="<?=$_SESSION['codusuario']?>">
		<?
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
			// Fun&#231;&#227;o combo tipos
			combo_meta($sql,"gerentecontas", $tipos, "", "-- Todos --", "", "", "allat", "allgc", "Todos Atendentes", "Todos Consultores");
		}
	}
	
	function backoffice($codusuariointerno){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.CodUsuarioInterno, u.Nome, u.Desativado from usuariosinternos u where ";
		$sql.=" u.codusuariointerno in (select gup.codusuariointerno from gruposusuariosinternos_usuariosinternos gup where codgrupousuariointerno = 4) ";
		$sql.=" order by u.desativado, u.nome ";
		
		combo_nenhum($sql,"codbackoffice", $tipos, $codusuariointerno," ","","","Nenhum");
	}
	
}?>
