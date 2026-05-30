<?
class logg{
	function insert( $acao , $rel, $desc = null )
	{
		$desc = ($desc!=null?"'$desc'":'null'); 
		$time = date( 'Y-m-d H:i:s' ) ;
		$usr  = $_SESSION['codusuario'] ;
		$sql  = "INSERT INTO log_table( dat_cad   , codusuariointerno, cod_acao, cod_rel, dsc_rel )
				 			   VALUES ( sysdate()   , $usr 			 , $acao   , '$rel' , $desc )" ;	 			   
		mysql_query( $sql ) ;
	}
	
	public static function checarConsultorAgenda( $codigoLead , $gerentes )
	{
		$gerenteConta = array_pop($gerentes);
		$sql = "SELECT CodGerenteConta FROM leads WHERE CodLead = {$codigoLead}" ;	
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs  = mysql_result( $qry , 0 , 0 ) ;
			if ( $rs != $gerenteConta && $rs != null ){
				$desc = "De ".$rs." para ".$gerenteConta;
				self::insert( 12 , $codigoLead, $desc) ;
			}
		}		
	}
	
	public static function checarAgendadoPara( $codigoAgenda , $agendadoPara )
	{
		$sql = "SELECT AgendadoPara, CodLead FROM agendaslead WHERE CodAgendaLead = {$codigoAgenda}" ;
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs  = mysql_fetch_array( $qry ) ;
			if ( $rs['AgendadoPara'] != $agendadoPara && $rs['AgendadoPara'] != null )
				$desc = "De ".$rs['AgendadoPara']." para ".$agendadoPara;
				self::insert( 13 , $rs['CodLead'], $desc ) ;
		}		
	}
	
	public static function checaGerenteConta( $codigoLead , $gerenteConta )
	{
		$sql = "SELECT CodGerenteConta FROM leads WHERE CodLead = {$codigoLead}" ;	
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs  = mysql_result( $qry , 0 , 0 ) ;
			if ( $rs != $gerenteConta && $rs != null )
				self::insert( 8 , $codigoLead ) ;
		}		
	}
	
	public static function checaTelefone( $codLead , $ddd , $tel )
	{
		$sql = "SELECT ddd , tel  FROM leads WHERE CodLead = {$codLead} " ;
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs1 = mysql_result( $qry , 0 , 0 ) ;
			$rs2 = mysql_result( $qry , 0 , 1 ) ;
			if ( $rs1 != null && $rs1 != $ddd || $rs2 != null && $rs2 != $tel )
				self::insert( 14 , $codLead ) ;
		}		
	}
	
	public static function checaContato( $codLead , $contatoNome )
	{
		$sql = "SELECT NomeContato FROM contatoslead WHERE CodLead = {$codLead} " ;
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs  = mysql_result( $qry , 0 , 0 ) ;
			if ( $rs != null && $rs != $contatoNome )
				self::insert( 16 , $codLead ) ;
		}		
	}
	
	public static function checaAtendente( $codLead , $codAtendente )
	{
		$sql = "SELECT CodAtendente FROM leads WHERE CodLead = {$codLead} " ;
		$qry = sql_query( $sql ) ;
		if ( mysql_num_rows( $qry ) > 0 )
		{
			$rs  = mysql_result( $qry , 0 , 0 ) ;
			if ( $rs != null && $rs != $codAtendente )
				self::insert( 15 , $codLead ) ;
		}		
	}
	
}
?>