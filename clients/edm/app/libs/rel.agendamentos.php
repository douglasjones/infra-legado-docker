<?php
/**
 * Created on 04/03/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 * 
 * @author Rogério Avelino da Silva
 * @package libs
 * @since version 1.0 - 04/03/2009
 * @copyright Gepros &copy; 2009, Rogério
 *
 */

include_once( "datas.php" ) ;

class RelAgendamento
{
	private $sql ;
	
	public function RelAgendamento( $values )
	{
		global $GerenteContas ;

		$gerequipe = self::getGerenteEquipe() ;
		
		if ( !is_array( $values ) )
			return false ;
			
		$this->sql = "" ;	
			
		if ( !empty( $values['cod_polo'] ) && $values['cod_polo'] != 100 ) 
			$this->sql .= " AND l.cod_polo=" . mysqlnull( $values['cod_polo'] ) ;
	
		if ( !empty( $values['razaosocial'] ) )
			$this->sql .= " AND l.RazaoSocial Like " . mysqlnull( "%{$values['razaosocial']}%" ) ;
			
		if ( !empty( $values['codstatusclassificacaolead'] ) ) 
			$this->sql .= " AND l.CodStatusClassificacaoLead = " . mysqlnull( $values['codstatusclassificacaolead'] ) ;
		
		if ( !empty( $values['codtipo'] ) ) 
			$this->sql .= " AND a.CodTipo = " . mysqlnull( $values['codtipo'] ) ;
		
		if( !empty($values['codstatus'] ) )
		{
			$codstatus = implode( ", " , $values['codstatus'] ) ;
			
			if ( $codstatus == 'sc' )
				$this->sql .= " AND a.CodStatus is null" ;
				
			elseif ( array_search( "sc" , $values['codstatus'] ) )
			{
				$codstatus = $values['codstatus'] ;
				array_pop( $codstatus ) ;
				$codstatus  = implode( ", " , $codstatus ) ;
				$this->sql .= " AND ( a.CodStatus IN (" . $codstatus . ") OR a.CodStatus is null )" ;
			}
			
			else
			{
				$codstatus = implode( ", " , $values['codstatus'] ) ;
				$this->sql.= " AND a.CodStatus IN (" . $codstatus . ")" ;
			}
		}
		
		if ( !empty( $values['datacadastrode'] ) && !empty( $values['datacadastroate'] ) )
			$this->sql.= " AND a.DataCadastro BETWEEN '" . dataYMD( $values['datacadastrode'] ) . " 00:00:00' AND '" . dataYMD($values['datacadastroate'] ) . " 23:59:59'" ;
			
		if ( !empty( $values['datavisitade'] ) && !empty( $values['datavisitaate'] ) )
			$this->sql .= " AND a.DataHorario BETWEEN '". dataYMD( $values['datavisitade'] ) ." 00:00:00' AND '" . dataYMD( $values['datavisitaate'] ) . " 23:59:59'" ;
		
		if ( !empty( $values['codgerenteconta'] ) )
			$this->sql .= " AND l.CodGerenteConta = "   . mysqlnull( $values['codgerenteconta'] ) . " AND agc.CodGerenteConta = " . mysqlnull( $values['codgerenteconta'] ) ;
		
		if( !empty( $values['codequipe'] ) )
			$this->sql .= " AND (agc.CodGerenteConta IN (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = {$values['codequipe']} ) 
						     OR u1.CodUsuarioInterno IN (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = {$values['codequipe']} ) 
							 OR u2.CodUsuarioInterno IN (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = {$values['codequipe']} ) ) " ;
		elseif ( $gerequipe )
			$this->sql .= " AND (agc.CodGerenteConta in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe in ( {$gerequipe} ) )
					   		 OR u1.CodUsuarioInterno in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe in ( {$gerequipe} ) )
					   		 OR u2.CodUsuarioInterno in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe in ( {$gerequipe} ) ) )" ;
		
		if ( !empty( $values['codusuariointerno'] ) )
			$this->sql .= " AND a.CodUsuarioInterno = " . mysqlnull( $values['codusuariointerno'] ) ;
			
		if ( !empty( $values['agendadopara'] ) )
			$this->sql .= " AND a.AgendadoPara = " . mysqlnull( $values['agendadopara'] ) ;
		
		if ( $GerenteContas && !permissao( 'leadoutrogerente' , 'al' ) )
			$this->sql .= " AND l.CodGerenteConta = "   . mysqlnull( $_SESSION['codusuario'] ) . " AND agc.CodGerenteConta = " . mysqlnull( $_SESSION['codusuario'] ) ;
			
		if ( !empty( $values['grupousuariointerno'] ) )
			$this->sql .= " AND (gu1.CodGrupoUsuarioInterno = " . mysqlnull( $values['grupousuariointerno'] ) . " OR gu2.CodGrupoUsuarioInterno = " . mysqlnull( $values['grupousuariointerno'] ) . ")" ;
		
	}
	
	public function getSqlAgendadoPara( $agendadoPara = null , $agendadoPor = null )
	{
		$para = ( $agendadoPara ) ? "  u1.Nome = '" . $agendadoPara . "' AND u2.Nome is null OR u2.Nome = '" . $agendadoPara . "'" 
								  : "  u1.Nome = '" . $agendadoPor  . "' AND u2.Nome is null OR u2.Nome = '" . $agendadoPor  . "'" ;  
		return " AND ( $para ) " . self::getSqlFinal() ;
	}
		
	public function setSql( $sintetico = false )
	{
		$campos = ( $sintetico ) ?  " s.CodStatus StatusAgendamento " 
								 :  " a1.CodAgendaLead Reagendado , 
									  a.DataCadastro , 
									  a.DataHorario ,
									  l.CodLead ,
									  l.RazaoSocial , 
									  u1.Nome AgendadoPor , 
									  u2.Nome AgendadoPara , 
									  u3.Nome GerenteContas , 
									  t.Descricao TipoAgendamento , 
									  s.Descricao StatusAgendamento " ;
		
		$sqlPrinc = "SELECT DISTINCT a.CodAgendaLead ,
									 {$campos}	
							    FROM agendaslead a 
						   LEFT JOIN agendagerenteconta agc on a.CodAgendaLead = agc.CodAgendaLead 
						   LEFT JOIN agendaslead a1 on a.CodAgendaLead = a1.CodReagendamento 
						   LEFT JOIN leads l on a.CodLead = l.CodLead 
						   LEFT JOIN usuariosinternos u1 on a.CodUsuarioInterno = u1.CodUsuarioInterno 
						   LEFT JOIN usuariosinternos u2 on a.AgendadoPara = u2.CodUsuarioInterno 
						   LEFT JOIN usuariosinternos u3 on l.CodGerenteConta = u3.CodUsuarioInterno 
						   LEFT JOIN gruposusuariosinternos_usuariosinternos gu1 on gu1.CodUsuarioInterno = u1.CodUsuarioInterno
						   LEFT JOIN gruposusuariosinternos_usuariosinternos gu2 on gu2.CodUsuarioInterno = u2.CodUsuarioInterno
						   LEFT JOIN tipoagendamento t on a.CodTipo = t.CodTipo 
						   LEFT JOIN statusagendamento s on a.CodStatus = s.CodStatus 
						 	   WHERE 1 " . $this->sql ;
		return $sqlPrinc ;			 	  
	}
	
	public static function getSqlFinal()
	{
		return " ORDER BY  a.DataHorario " ;
	}
	
	private function getGerenteEquipe()
	{
		$gerequipe = 0 ;
		$coduser   = $_SESSION['codusuario']  ;
		$result    = mysql_query( "SELECT Tk_Equipe FROM tb_equipesvendas WHERE Fk_Gerente = {$coduser} " ) ;
		
		while ( $row = mysql_fetch_array( $result ) )
			$gerequipe .= "," . $row['Tk_Equipe'] ;
		
		return $gerequipe ;	
	}
	
} 
 
 
?>
