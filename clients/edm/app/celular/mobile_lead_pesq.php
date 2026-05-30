<!DOCTYPE html> 

<html> 
	<head> 
		<meta charset="utf-8">		
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
        	require "../libs/cla.equipes.php";
            include_once "../libs/maininclude.php";
            include_once "../libs/combo.php";
	        include_once "../libs/cla.combo.php";
	        include_once("../libs/cla.comboajax.php" ) ;;
            
            
            if(!permissao('leads', 'dt')){
		      javascriptalert('Você não tem permissão para acessar esta página!!!');
		      exit;
	        }            
            
            $codlead = $_REQUEST['codlead'];
            
            
    
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
                <form name="dados" method="post" action="mobile_leadres_form.php" >
                    <input type="hidden" name="acao" value="" />
                    <input type="Hidden" name="contato" value="">
                    <input type="Hidden" name="acesso" value="1">
                	<table align="left" width="100%" cellpadding="2" cellspacing="2" >
                       <tr>
                            <td class="title">
                        	   <b>Pesquisar Lead</b>
                            </td>
                        </tr>       
                        <tr>
                            <td align="left">
                                <h2>C&Oacute;d Lead</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <input type="text" name="codlead" size="12" maxlength="12" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Raz&Auml;o Social</h2>
                            </td>
                        </tr>    
                        <tr>
                            <td align="left">
                                <input type="text" id="razaosocial" name="razaosocial" size="30" maxlength="150"  />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Celular</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <input type="text" id="ddd_cel" class="input" name="ddd_cel" size="2" maxlength="2">&nbsp;
                                <input type="text" id="cel" class="input" name="cel" maxlength="10" size="11">
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Telefone</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <input type="text" id="ddd_tel" class="input" name="ddd_tel" size="2" maxlength="2">&nbsp;
                                <input type="text" id="tel" class="input" name="tel" maxlength="10" size="11">
                            </td>
                        </tr>   
                        <tr>
                            <td align="left">
                                <h2>Status</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	
                    				$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by codstatusclassificacaolead ";
                    				combo($sql,"codstatusclassificacaolead", "", " ", "");
			                     ?>
                            </td>
                        </tr>   
                        <tr>
                            <td align="left">
                                <h2>Consultor</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	combo::consultor_equipe1($_SESSION['codusuario']);?>
                            </td>
                        </tr>       
                        <tr>
                            <td align="left">
                                <h2>Atendente</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	combo::atendente_equipe1($_SESSION['codusuario']);?>
                            </td>
                        </tr>     
                        <tr>
                            <td align="left">
                                <h2>Mailing</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
								<?	
									$sql = "select Mailing, Mailing from leads group By Mailing";
									combo($sql,"mailing", "", " ", "");	
								?>
                            </td>
                        </tr>     
                        <tr>
                            <td align="left">
                                <h2>Operadora</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                				<?php 				
                				$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
                				combo($sql,"cod_operadora", "", " ", "");	
                				?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <h2>Cep</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
	                           <input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9"  onKeyPress="mascara(this,cep1)"  validate="datatype=cep"/>
                            </td>
                        </tr>   
                        <tr>
                            <td align="left">
                                <h2>Bairro</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
	                           <input type="Text" name="bairro" id="bairro">
                            </td>
                        </tr>   
                        <tr>
                            <td align="left">
                                <h2>Cidade</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
	                           <input type="Text" name="cidade" id="cidade">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <li>
									<a href="javascript:pesq_lead()"><img src="images/seta4.png" width="30" height="30" ><h2 class="title"><b>enviar</b></h2></a>
								</li>  
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
    
     
