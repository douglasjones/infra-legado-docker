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
            include_once "../libs/cla.leads.php";            
            include_once "../libs/cla.combo.php";
            
            $codlead = $_REQUEST['codlead'];   

                    
        	$sql = "Select 
                        a.CodAgendaLead,
                        a.DataCadastro,      
                        a.DataHorario,                                           
                        t.Descricao Tipo,
                        s.Descricao Status,
                        ui.Nome agendadopor,
                        ui1.Nome AgendadoPara,
                        c.NomeContato Contato,
                        l.razaosocial,
                        l.cep,
                        l.endereco,
                        l.numero,
                        l.complemento,
                        l.bairro,
                        l.cidade,
                        l.uf                        
                    from agendaslead a 
                        inner join leads l on a.codlead = l.codlead
                        left join agendagerenteconta agc on a.CodAgendaLead = agc.CodAgendaLead
                        inner join tipoagendamento t on a.CodTipo = t.CodTipo 
                        left join statusagendamento s on a.CodStatus = s.CodStatus 
                        left join usuariosinternos ui on a.CodUsuarioInterno = ui.CodUsuarioInterno 
                        left join usuariosinternos ui1 on agc.codgerenteconta = ui1.CodUsuarioInterno 
                        inner join contatoslead c on a.CodContatoLead = c.CodContatoLead 
                    Where a.CodLead = $codlead 
                        And a.DataCancelamento Is Null
                    Order By a.CodAgendaLead Desc Limit 1";
                    
            $result = sql_query($sql);
        	if($row = mysql_fetch_array($result)){
                $codagendalead = $row['CodAgendaLead'];
                $datacadastro = $row['DataCadastro'];
                $datahorario = $row['DataHorario'];
                $tipo = $row['Tipo'];
                $status = $row['Status'];
                $agendadopor = $row['agendadopor'];
                $agendadopara = $row['AgendadoPara'];
                $contato = $row['Contato'];
                $razaosocial = $row['razaosocial'];
                $cep = $row['cep'];
                $endereco = $row['endereco'];
                $numero = $row['numero'];
                $complemento = $row['complemento'];
                $bairro = $row['bairro'];
                $cidade = $row['cidade'];
                $uf = $row['uf'];
               
        	}      
            mysql_free_result($result);     
        ?>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>
        <script type="text/javascript" language="JavaScript" src="../extras/mascaras.js"></script>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <?	include_once "../libs/head.php";?>
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
                  <li class="" ><a href="mobile_inicio_form.php" class="menu"> Inicio </a></li>
                  <li class="selected"><a href="mobile_vendas_form.php" class="menu" title="Vendas"> Vendas </a></li>
                    <li class=""><a href="mobile_agenda.php" class="menu"> Agenda </a></li>
                    <li class=""><a href="mobile_retorno.php" class="menu"> Retorno </a></li>
                </ul>
          </nav>    
        <div id="main" role="main" class="t-moda-p-news">	
			<ul class="news-list no-photo">
                <form name="dados" method="post" action="mobile_novolead_form.php">
                    <input type="hidden" name="acao" value="" />
                    <input type="Hidden" name="contato" value="">
                    <input type="Hidden" name="acesso" value="1">
                	<table align="left" width="100%" cellpadding="2" cellspacing="2" > 
                       <tr>
                            <td class="title">
                        	   <b>&Uacute;ltima Visita</b>
                            </td>
                       </tr>                       
                       <?if(!empty($codagendalead)){?>
                           <tr>
                                <td align="left" >
                            	   <h2>Cod Agenda</h2>
                                </td>
                            </tr>                            
                            <tr>
                                <td align="left">
                                   <h1><b><?if(!empty($codagendalead)){ echo $codagendalead; }else{ echo '&nbsp;';}?></b></h1>
                                </td>
                            </tr>
                           <tr>
                                <td align="left" >
                            	   <h2>Raz&auml;o Social</h2>
                                </td>
                            </tr>                        
                            <tr>
                                <td align="left">
                                   <h1><b><?if(!empty($razaosocial)){ echo $razaosocial; }else{ echo '&nbsp;';}?></b></h1>
                                </td>
                            </tr>                                         
                        	<tr>
                                <td align="left" >
                            	   <h2>Data e Hor&aacute;rio</h2>
                                </td>
                            </tr>                        
                            <tr>
                                <td align="left">
                            	   <?if(!empty($datahorario)){?>
                                    <h1><b><?=(!empty($datahorario)?date('d/m/Y \á\s H:i', strtotime($datahorario)):null);?></b></h1>
                                   <?}else{?>
                                    &nbsp;
                                   <?}?>                                
                                </td>
                            </tr>
                           <tr>
                                <td align="left" >
                            	   <h2>Endere&ccedil;o</h2>
                                </td>
                            </tr>                        
                            <tr>
                                <td align="left">
                                   <h1><b><?if(!empty($endereco)){ echo $endereco.",".$numero." - ".$complemento." - ".$bairro ; }else{ echo '&nbsp;';}?></b></h1>
                                </td>
                            </tr>                         
                            <tr>
                                <td align="left" >
                            	   <h2>Tipo Agendamento</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" >
                                    <h1><b><?if(!empty($tipo)){ echo $tipo; }else{ echo '&nbsp;';}?></b></h1>        							
                                </td>
                            </tr>
                            <tr>
                                <td align="left" >
                            	   <h2>Status</h2>
                                </td>
                            </tr>                        
                            <tr>
                                <td align="left">       							 
                                     <h1><b><?if(!empty($status)){ echo $status; }else{ echo '&nbsp;';}?></b></h1>
                                </td>
                            </tr>  
                            <tr>
                                <td align="left" >
                            	   <h2>Agendado Por</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" >                        	   
                                   <h1><b><?if(!empty($agendadopor)){ echo $agendadopor; }else{ echo '&nbsp;';}?></b></h1>
                                </td>
                            </tr>                         
                            <tr>
                                <td align="left" >
                            	   <h2>Consultor</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">                                
                                    <h1><b><?if(!empty($agendadopara)){ echo $agendadopara; }else{ echo '&nbsp;';}?></b></h1>							
                                </td>
                            </tr>                                             
                            <tr>
                                <td align="left" >
                            	   <h2>Contato</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
            					   <h1><b><?=$contato;?></b></h1>
                                   <h1><b><?if(!empty($agendadopara)){ echo $agendadopara; }else{ echo '&nbsp;';}?></b></h1>                                	    							
                                </td>
                            </tr> 
                        <?}?>
                        <?if(!empty($codagendalead)){?>
                            <tr>
                                <td>
                                   <a href='http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=<?= $endereco;?>, <?= $numero;?>, <?= $cidade;?> - <?= $uf;?>' target="_new"><img src="images/google_maps_tr.png" width="40" height="40" /></a>&nbsp;
                                   <a href="mobile_agenda_classificar_form.php?codagendalead=<?=$codagendalead;?>&codlead=<?=$codlead?>"  class="link" title="CLASSIFICAR VISITA"><img src="images/classificacao_visita.png" width="40" height="40"/></a>&nbsp;<a href="mobile_agenda_form.php?codagendalead=<?=$codagendalead;?>&codlead=<?=$codlead;?>&reagendar=Reagendar Visita"  class="link" title="REAGENDAR VISITA"><img src="images/reagendamento.png" width="40" height="40" /></a>
                                </td>
                            </tr> 
                        <?}?>                     
                       <tr>
                            <td align="left">
                                <?if(!empty($codagendalead)){?>
                                    <li>                                
            					      <a href="mobile_agenda_form.php?codlead=<?=$codlead;?>&codagendalead=<?=$codagendalead;?>" class="link" title="EDITAR VISITA"><img src="images/documento.png" width="30" height="30"><b>Editar visita</b></a>
                                    </li>                        
                                <?}?>             						    
                                <li>
        					      <a href="mobile_agenda_form.php?codlead=<?=$codlead;?>" class="link" title="NOVO AGENDAMENTO"><img src="images/adicionar.png" width="30" height="30"><b>agendar visita</b></a>
                                </li>  	
                                    <li>
            					     <a href="mobile_dadoslead_form.php?codlead=<?=$codlead;?>" class="link" title="Lead"><img src="images/documento.png" width="35" height="35"><b>Lead</b></a>
                                    </li>                         
                            </td>
                        </tr>                                                                                                                         
                    </table>
                </form>                                
           
			</ul>
		  </div> 
        <!--! end of #main -->	
	    </div> <!--! end of #container -->
<footer class="t-moda-p-footer">	
	<p class="back"><a href="javascript:history.go(-1)" class="link"></a></p>
</footer>     
