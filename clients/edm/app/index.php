<?
    //acesso mobile
        $server = $_SERVER['SERVER_NAME']; 
        $endereco = $_SERVER ['REQUEST_URI']; 
        
    if(empty($_REQUEST['acao'])){
        include('libs/mobile_device_detect.php');   
        mobile_device_detect(true,true,true,true,true,true,"http://".$server."/celular",false);
    }
?>
<frameset rows="30,*, 22" border="1"  frameborder="NO" marginwidth="0" marginheight="0" noresize scrolling="NO" name="top">
	<frame src="topo.php" name="topo" noresize scrolling="no" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0">
	<frameset cols="180,*" border="0" frameborder="0" framespacing="0" noresize scrolling="NO">
		<frame src="menu_blank.php" name="menu" noresize scrolling="auto" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0">
		<frame src="blank.php" name="pagina" noresize scrolling="auto" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0">
	</frameset>
	<frame src="rodape.php" name="rodape" noresize scrolling="no">
</frameset>

