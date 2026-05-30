<?session_start();
    include "../libs/pwcr.php";
    include_once "../libs/conectar.php";
    conectar(0);  
    $login = $_REQUEST['login'];
    $senha = $_REQUEST['senha'];    
    
    $bd = $_SESSION['bd'];
	mysql_select_db($bd);
    $bloqueado = 0;
    $sql = "select max(bloqueado) bloqueado from empresa ";

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $bloqueado = $row["bloqueado"];
    mysql_free_result($result);
    
    if($bloqueado == 1){  
        $_SESSION['bd'] = null;
        $_SESSION['codusuario'] = null;
        $_SESSION['cod_polo'] = null;
        $_SESSION['cod_empresa'] = null;
        $_SESSION['nomeusuario'] = null;
        $_SESSION['login'] = null;       
        
        echo "Msg=////"."bloqueado////";

    }else{

        $sql = "select 
					CodUsuarioInterno
					, Nome
					, Login
					,cod_polo 
					,cod_empresa
					from $bd.usuariosinternos 
					where login = '" .$login. "' 
					and senha = '" . pwcrypt(mysql_real_escape_string($senha)) . "' 
					And Desativado <> 1";
        
		$result = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$num = mysql_num_rows($result);
		if (!$row){
			$_SESSION['bd'] = null;
			$_SESSION['codusuario'] = null;
			$_SESSION['cod_polo'] = null;
			$_SESSION['cod_empresa'] = null;
			$_SESSION['nomeusuario'] = null;
			$_SESSION['login'] = null;
                        
            echo "Msg=////"."nlogin////";
            
         }else{
        	$permitido = 0;
            $horariopermitido = 0;
            $ip = "";
    		//Verifica se o horário está dentro da faixa permitida
    		$sql ="";
    		$sql ="select min(gui.horarioini) horarioini, max(gui.horariofim) horariofim, max(ip) ip ";
    		$sql.="  from gruposusuariosinternos gui ";
    		$sql.="	inner join gruposusuariosinternos_usuariosinternos guiu on gui.codgrupousuariointerno = guiu.codgrupousuariointerno ";
    		$sql.=" where guiu.codusuariointerno = ".$row['CodUsuarioInterno'];
    		$sql.="  having sysdate() >= concat(date_format(sysdate(),'%Y-%m-%d'), ' ', min(gui.horarioini)) ";
    		$sql.="     and sysdate() <= concat(date_format(sysdate(),'%Y-%m-%d'), ' ', max(gui.horariofim)) ";
    	 	$rs_horario = mysql_query($sql);	
    		while($row_horario = mysql_fetch_array($rs_horario)){
    			$ip = $row_horario["ip"];
    			$horariopermitido = 1;
    		}
    		mysql_free_result($rs_horario);
            //if($horariopermitido == 0){
                //echo "Msg=////"."nhorario////";    
            //}    
        	$_SESSION['bd'] = $bd;
			$_SESSION['codusuario'] = $row['CodUsuarioInterno'];
			$_SESSION['cod_polo']= $row['cod_polo']; 
			$_SESSION['cod_empresa']= $row['cod_empresa']; 
			$_SESSION['nomeusuario'] = $row['Nome'];
			$_SESSION['login'] = $row['Login'];
			$_SESSION['tempo'] = date( 'Hi' ) ;

            echo "Msg=////"."login////";
         }    
             
    }    

?>