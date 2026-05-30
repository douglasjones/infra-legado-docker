<?php

/**
 *	Created on 09/02/2009 by Rog&#233;rio Avelino da Silva
 *
 */

header('Content-Type: text/html; charset=ISO-8859-1');

include_once( "maininclude.php" ) ;
include_once( "combo.php" ) ;
include_once( "cla.combo.php" ) ;

$campo  = ( isset( $_GET['campo' ] ) ) ? $_GET['campo' ] : null ;
$campo2 = ( !empty( $_GET['campo2'] ) && $_GET['campo2'] != 'undefined' ) ? $_GET['campo2'] : null  ;
$campo3 = ( !empty( $_GET['campo3'] ) && $_GET['campo3'] != 'undefined' ) ? $_GET['campo3'] : null  ;

if ( $campo )
{	
	switch ( $campo )
	{			
		case 'polo' :
			combo::polo();
		break ;
		
		case 'mailing' :
			combo::mailing() ;
		break ;
		
		case 'status' :
			combo::status_ld() ;
		break ;
		
		case 'statusag' :
			combo::status_ag() ;
		break ;
		
		case 'gerente' :
			combo::gerente() ;
		break ;
		
		case 'atendente' :
			combo::atendente( $campo2 , $campo3 ) ;
		break ;
		
		case 'tipo' :
			combo::tipo() ;
		break ;
		
		case 'equipe' :
			combo::equipe() ;
		break ;
		
		case 'consultor' :
			combo::consultor( $campo2 , $campo3 ) ;
		break ;
		
		case 'conseq' :
			combo::cons_eqp( $campo2 ) ;
		break ;
		
		case 'estado' :
			combo::getEstado( $campo2 ) ;
		break ;
		
		case 'agendadopor' :
			combo::agdo_por() ;
		break ;
		
		case 'agendadopara' :
			combo::agdo_para() ;
		break ;		
		
		case 'grupo' :
			combo::grupo() ;
		break ;
		
		case 'user' :
			combo::user( $campo2 , $campo3 ) ;
		break ;
		
		case 'produto' :
			combo::getProduto() ;
		break ;
		
	}	
}

include_once( "desconectar.php" ) ;

?>