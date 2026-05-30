<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html> 
	<head> 
		<meta http-equiv="Content-Type: text/html; charset=ISO-8859-1" />	
		<title>GEPROS MOBILE</title>
		
        <meta name="keywords" content="Law, Policy, Documents"><meta name="description" content="">	
		<meta name="HandheldFriendly" content="True">
	  	<meta name="MobileOptimized" content="320">
	  	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	    <meta name="format-detection" content="telephone=no"/> 
	    <meta name="format-detection" content="address=no"/>  
        
<!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
		<meta http-equiv="cleartype" content="on">
                <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://www.onbile.com/nbproject/private/blog_moda/media/img/h/apple-touch-icon.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://www.onbile.com/nbproject/private/blog_moda/media/img/m/apple-touch-icon.png">
		<link rel="apple-touch-icon-precomposed" href="http://www.onbile.com/nbproject/private/blog_moda/media/img/l/apple-touch-icon-precomposed.png">
		<link rel="shortcut icon" href="http://www.onbile.com/nbproject/private/blog_moda/media/img/l/apple-touch-icon.png">
		
        <link rel="shortcut icon" href="http://demo.gepros2.com.br/favicon.ico">		
		<!-- <link rel="stylesheet" href="css/style.css?v=1"> -->
		
		<style type="text/css" media="screen">
		/*reset*/
        	html, body { margin: 0; padding: 0;	border: 0; }
        	body { font-family:Helvetica, Arial, sans-serif; line-height:1.5; font-size:16px; background: #fff; color: #000; word-wrap: break-word; -webkit-text-size-adjust: none; }
        	h1, h2, h3, h4, h5, h6{ font-weight: normal; margin: 0;}
        	p img { float: left; margin: 0 10px 5px 0; padding: 0; }
        	img { border: 0; max-width: 100%; }
        	table { width:100%; border-collapse: collapse;border-spacing: 0; }
        
        	.ir { display: block; border: 0; text-indent: -999em; overflow: hidden; background-color: transparent; background-repeat: no-repeat; text-align: left; direction: ltr; }
        	.ir br { display: none; }
        
        	#main { font-family: 'Times New Roman', Times, serif; }
        	body, ul.news-list h2, #main time, #main.t-moda-p-post h2, 
        	#main.t-moda-p-contact p, #main.t-moda-p-contact .address, 
        	#main.t-moda-p-news p.more a { font-family: 'LeagueGothicRegular'; }
        	
        	h1 {
        		font-size: 1em;
        	}
		</style>
		
		<link rel="stylesheet" href="mobile.css">
        <link rel="stylesheet" href="celular.css">	

		<?
        	include_once "../libs/maininclude.php";
                     
        ?>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>	

	</head>         
    
<body class="home"> 		
		<div id="container">
        <header id="header" class="t-moda-p-header">
			<table  width="100%">
				<tr>
					<td width="90%">
					<h1 class=""><a href="http://www.gepros.com.br/" class="logo" id="logotype"><strong>GEPROS</strong></a></h1>
					</td>
					<td valign=top>
						<li>
							<a href="javascript:logoff()" tittle="LOGOFF" class="logo"><img src="images/logoff2.png" width="35"  height="35" /></a>
						</li>						
					</td>
				</tr>
			</table>
                   	
       </header>
             <nav class="t-moda-p-menu">
             	<ul >
                    <li class="selected" ><a href="mobile_inicio_form.php" class="menu"> Inicio </a></li>
                    <li class=""><a href="mobile_vendas_form.php" class="menu" title="Vendas"> Vendas </a></li>
                    <li class=""><a href="mobile_agenda.php" class="menu"> Agenda </a></li>
                    <li class=""><a href="mobile_retorno.php" class="menu"> Retorno </a></li>
                </ul>
              </nav>    
        <div id="main" role="main" class="t-moda-p-news">	
			<ul class="news-list no-photo">
				<form name="dados" method="post" action="mobile_leadres_form.php" >
					<table align="left" width="100%" cellpadding="0" cellspacing="0" border=0>
						<tr>
							<td >
								<?
									//VISITAS DO DIA                    
									$sql = "Select
												count(ag.CodAgendaLead) visitasdia
											from agendaslead ag
											inner join agendagerenteconta agc on ag.CodAgendaLead = agc.CodAgendaLead
											where agc.codgerenteconta=".$_SESSION['codusuario'];                           
									$sql .=" and ag.DataHorario >='".date(Y."-".m."-".d)." 00:00:00'";
									$sql .=" and ag.DataHorario <='".date(Y."-".m."-".d)." 23:59:59'";
									
									$result = mysql_query($sql);
									if($row = mysql_fetch_array($result)){	
										$qtde_visitas = $row['visitasdia'];
									}
									mysql_free_result($result);
								?>
								<li>
									
									<h2 class="title"><strong><?=$qtde_visitas?> visitas do dia</strong></h2>
								</li>
							</td>
						</tr>
						<tr>
							<td>
								<?
									//RETORNOS DO DIA                    
									$sql = "Select
												count(oc.codocorrencialead) retornos_dia
											from ocorrenciaslead oc
											inner join usuariosinternos ui1 on oc.codusuariointerno = ui1.codusuariointerno";
									$sql .="  where oc.agendadopara=".$_SESSION['codusuario'];
									$sql .=" and oc.dt_retorno is not null  
											and oc.dt_retorno_fechamento is null";
									
									$result = mysql_query($sql);
									if($row = mysql_fetch_array($result)){	
										$qtde_visitas = $row['retornos_dia'];
									}
									mysql_free_result($result);
								?>
								 <li>
									<a href="mobile_retorno.php?acesso=1" class="link" title="Editar Lead"><h1 class="title2"><strong><?=$qtde_visitas?> <b>retorno(s)</strong></h1></a>						
								 </li>
							</td>
						</tr>
						<tr>
							<td>	
							    <li>					
									<h2 class="title2"<strong>Buscar Lead <strong></h2>		
								</li>	
							</td>							
						</tr>
						<tr>
							<td align=left>
								
								<input class="input" type="text" name="busca" id="txtbusca" size="18" />&nbsp;<a href="javascript:pesq_lead()"><img src="images/seta4.png" width="35" height="35"  class="imgdireita"></a>
								
							</td>
						</tr>
					</table>
				</form>                                                     
            <!--<p class="more"><a href="index/?pag=2" class="link">More Articles</a></p>-->
			</ul>
		  </div> 
        <!--! end of #main -->	
	    </div> <!--! end of #container -->
<footer class="t-moda-p-footer">	
	<p class="back"><a href="javascript:history.go(-1)" class="link"></a></p>
</footer>   
