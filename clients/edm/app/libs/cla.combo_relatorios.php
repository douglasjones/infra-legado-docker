<?
include_once "combo.php";
include_once "cla.equipes.php";

class combo{

	function mailing(){
		$sql = "select Distinct Mailing, Mailing from leads Order By Mailing";
		combo($sql,"mailing", "", " ", "");
	}
	
	function consultor_equipe($codusuariointerno){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.codusuariointerno, concat(ifnull(p.n_polo,''),' - ', u.nome), u.desativado ";
		$sql.="  from usuariosinternos u ";
		$sql.="       left join polo p on u.cod_polo = p.cod_polo ";
		$sql.=" where gerentecontas = 1 ";
		if(!permissao('visualizar_todos_consultores', 'cs'))
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";		
		$sql.=" order by 3, 2 ";
		
		if(!permissao('visualizar_todos_consultores', 'cs'))
			combo_nenhum($sql,"codgerenteconta", $tipos, $codusuariointerno, " ");
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
		$sql.="select u.codusuariointerno, concat(ifnull(p.n_polo,''),' - ', u.nome), u.desativado ";
		$sql.="  from usuariosinternos u ";
		$sql.="	      left join polo p on u.cod_polo = p.cod_polo ";
		$sql.=" where atendente = 1 ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		$sql.=" order by  3, 2  ";
		
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			combo_nenhum($sql,"codatendente", $tipos, $codusuariointerno, " ");
		else
			combo_nenhum($sql,"codatendente", $tipos, $codusuariointerno," ","","", "Nenhum");
	}
	
	function polo($cod_polo){
		$tipos['max'] = 1;	
		$sql = "";
		$sql .= "Select p.cod_polo, p.n_polo from polo p where p.dat_canc is null ";
		$sql .= " Order By p.n_polo ";
		if(empty($_SESSION['polo_pk'])){
			if(!empty($local)){
				combo_nenhum($sql,"cod_polo", $tipos, $cod_polo," ","","","Nenhum");	
			}else{
				combo($sql, "cod_polo", $cod_polo, " ", "");
			}
		}else{
			combo($sql, "cod_polo", $cod_polo, " ", "");
			
		}
	}	

	function tipo_agendamento($default){
		$sql = "select * from tipoagendamento Order By Descricao";
		// Fun&#231;&#227;o combo
		combo($sql, "codtipo", $default, " ");
	}
	
	function status_ag($default){
		$sql = "select * from statusagendamento 
                where not CodStatus = 6
                Order By Descricao";
		$result = mysql_query($sql);
		echo "<select name='codstatus'>";
		echo "<option value=''></option>";
		if($default == "0")
			echo "<option value='0' selected>Sem Classificação</option>";
		else
			echo "<option value='0'>Sem Classificação</option>";
			
		echo "<option value=''>-------------------------------</option>";
		while($row = mysql_fetch_array($result))
			if($default == $row[0])
				echo "<option value='".$row[0]."' selected>".$row[1]."</option>";
			else
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
		echo "</select>";
			
	}

	function equipe($codequipe){	
		$d = "";
		$sql = "SELECT eq.Tk_Equipe AS cod, eq.Vc_nome AS equipe FROM tb_equipesvendas eq
				INNER JOIN usuariosinternos u ON u.CodUsuarioInterno = eq.Fk_lider WHERE 1";
		if(!empty($codequipe)){
            $sql.=" and eq.Tk_Equipe=".$codequipe;
        }       
         
        
        if(!empty($codequipe)){
            combo($sql,"codequipe", $codequipe, "", "");
        }else{
            combo($sql,"codequipe", $codequipe, " ", "");
        }
	}
	
	//Gangenda
	function agdo_por($agendadopor){
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.codusuariointerno, concat(ifnull(p.n_polo,''),' - ', u.nome), u.desativado ";
		$sql.="  from usuariosinternos u ";
		$sql.="	      left join polo p on u.cod_polo = p.cod_polo ";
		$sql.=" where 1 = 1 ";
		//if(!permissao('visualizar_todos_atendentes', 'cs'))
		//	$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		$sql.=" order by  3, 2  ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			combo_nenhum($sql,"agendadopor", $tipos, $agendadopor, " ");
		else
			combo_nenhum($sql,"agendadopor", $tipos, $agendadopor," ","","", "Nenhum");
				
	}

	function agdo_para($agendadopara){	
		
		$tipos[0]['valor'] = '-1';
		$tipos[1]['valor'] = 1;
		$tipos[0]['style'] = 'color:#009900';
		$tipos[1]['style'] = 'color:#990000';
		$tipos['max'] = 2;	
		
		$sql ="";
		$sql.="select u.codusuariointerno, concat(ifnull(p.n_polo,''),' - ', u.nome), u.desativado ";
		$sql.="  from usuariosinternos u ";
		$sql.="	      left join polo p on u.cod_polo = p.cod_polo ";
		$sql.=" where 1 = 1 ";
		//if(!permissao('visualizar_todos_atendentes', 'cs'))
		//	$sql.="   and u.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
			
		$sql.=" order by  3, 2  ";
		if(!permissao('visualizar_todos_atendentes', 'cs'))
			combo_nenhum($sql,"agendadopara", $tipos, $agendadopara, " ");
		else
			combo_nenhum($sql,"agendadopara", $tipos, $agendadopara," ","","", "Nenhum");
			
	}
	function grupo($codgrupousuariointerno){
		$sql = "select distinct g.CodGrupoUsuarioInterno, g.Nome ";
		$sql .= " from agendaslead a";
		$sql .= " left join usuariosinternos u on a.AgendadoPara = u.CodUsuarioInterno Or a.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos_usuariosinternos gu on gu.CodUsuarioInterno = u.CodUsuarioInterno";
		$sql .= " left join gruposusuariosinternos g on gu.CodGrupoUsuarioInterno = g.CodGrupoUsuarioInterno";
		$sql .= " Where g.CodGrupoUsuarioInterno Is Not Null";
		$sql .= " Order By g.Nome";
		combo($sql,"codgrupousuariointerno", $codgrupousuariointerno, " ");
	}
	
	function motivo_seminteresse($codmotivo){
		$sql = "select CodMotivoLead, Descricao from motivoslead";
		combo($sql, "codmotivo", $codmotivo, " ", "");
	}
	function combo_mailing($mailing_pk){
		$sql ="";
		$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						ORDER BY m.dsc_mailing";
		
		combo( $sql, "mailing_pk" , $mailing_pk , " " ) ;
	}
}?>
