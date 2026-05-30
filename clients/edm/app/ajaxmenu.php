<?php
/*
 * Created on 11/02/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start() ;
header('Content-Type: text/html; charset=ISO-8859-1');

$sessao  = ( isset( $_GET['sessao'] ) ) ? $_GET['sessao'] : null ; 
$retorno = "destroi" ;
if ( $sessao && isset( $_SESSION['tempo'] ) )
{
	if ( $sessao != 'destroi' )
	{
		$tempo = time() - $sessao ;
		$minutos = floor( ( ( $tempo / 86000 ) * 24 ) * 60 ) ;
		if ( $minutos < 20 )
			$retorno = "continua" ;
	}
	else
	{
		session_destroy() ;
		$retorno = "Sessão encerrada." ;
	}			
}

echo $retorno ;

?>