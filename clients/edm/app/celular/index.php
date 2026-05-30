<?
    include_once "../libs/conectar.php";  
    conectar(0);
        //acesso mobile
        $server = $_SERVER['SERVER_NAME']; 
        $endereco = $_SERVER ['REQUEST_URI']; 




    if ($_REQUEST['logoff'] == 1) {
		session_destroy();	
	}
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                
        <link rel="shortcut icon" href="http://demo.gepros2.com.br/favicon.ico">		
		<!-- <link rel="stylesheet" href="css/style.css?v=1"> -->
		
		<style type="text/css" media="screen">
		/*reset*/
		html, body { margin: 0; padding: 0;	border: 0; }
		body { font-family:Helvetica, Arial, sans-serif; line-height:1.5; font-size:16px; background: #fff; color: #000; word-wrap: break-word; -webkit-text-size-adjust: none; }
		h1, h2, h3, h4, h5, h6{ font-weight: normal; margin: 0;}
		p img { float: left; margin: 0 10px 5px 0; padding: 0; }
		img { border: 0; max-width: 100%; }
		table { width:auto; border-collapse: collapse;border-spacing: 0; }
		article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display: block; }

		/*Non-semantic helper classes*/
		.ir { display: block; border: 0; text-indent: -999em; overflow: hidden; background-color: transparent; background-repeat: no-repeat; text-align: left; direction: ltr; }
		.ir br { display: none; }
		/* -- add uppercase and more --*/

		/* photo theme */

		/*@font-face {
		    font-family: 'LeagueGothicRegular';
		    src: url('http://www.onbile.com/nbproject/private/blog_moda/media/font/league_gothic-webfont.eot');
		    src: url('http://www.onbile.com/nbproject/private/blog_moda/media/font/league_gothic-webfont.eot?#iefix') format('embedded-opentype'),
		         url('http://www.onbile.com/nbproject/private/blog_moda/media/font/league_gothic-webfont.woff') format('woff'),
		         url('http://www.onbile.com/nbproject/private/blog_moda/media/font/league_gothic-webfont.ttf') format('truetype'),
		         url('http://www.onbile.com/nbproject/private/blog_moda/media/font/league_gothic-webfont.svg#LeagueGothicRegular') format('svg');
		    font-weight: normal;
		    font-style: normal;
		}*/

		/* colors */ /* rojo # 251, 77, 76 */ /* azul 69, 173, 168 */ /* verde - 136, 196, 37 */

		/* fonts */ 
		#main { font-family: 'Times New Roman', Times, serif; }
		body, ul.news-list h2, #main time, #main.t-moda-p-post h2, 
		#main.t-moda-p-contact p, #main.t-moda-p-contact .address, 
		#main.t-moda-p-news p.more a { font-family: 'LeagueGothicRegular'; }
		
		h1 {
			font-size: 1em;
		}

/*		nav.t-moda-p-menu ul li a.left {
			text-align: left;
			padding-left: 5px;
			padding-right: 0;
			width: 23.4%;
		}
		nav.t-moda-p-menu ul li a.right {
			text-align: right;
			padding-right: 5px;
			padding-left: 0;
			width: 23.4%;
		}
		nav.t-moda-p-menu ul li a.center {
			text-align: center;
			padding-right: 0;
			padding-left: 0;
			width: 24.8%;
		}*/

		</style>
		
		<link rel="stylesheet" href="mobile.css">
        <link rel="stylesheet" href="celular.css">	
        	
		<!--[if gte IE 8.0]>
		<style type="text/css">
			#main.t-moda-p-collections ul.collections li a {
				width: 33%;
			}
		</style>
		<![endif]-->
		
		<?	include_once "../libs/head.php";?>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>	
	</head> 
  
	<body class="home"> 		
		<div id="container">
            <header id="header" class="t-moda-p-header">
                <h1 class=""><a href="http://www.gepros.com.br/" class="logo" id="logotype"><strong>GEPROS</strong></a></h1>		
            </header>
        <div id="main" role="main" class="t-moda-p-news">	
		  <ul class="news-list no-photo">            	    
        	    <br><br>
                <h3>Bem vindo ao Gepros Mobile!</h3>  
                <br> 
               <form method="post" action="index.php"> 
                <input type="hidden" name="acao" value="" />
                   <table width="20%" border="0" cellpadding="0" cellspacing="0" align="center" >
                            <tr >	
                                <td  align="left">
                                    Login		
                                </td>                          
                            </tr>   
                            <tr>
                                <td >								
                                    <h1><input type="Text" id="login" name="login" size="20"></h1>
                                </td>                            
                            </tr>
                            <tr>	
                                <td align="left">
                                    Senha		
                            	</td>
                                 
                            </tr>   
                            <tr>
                                <td >								
                                    <input type='password' id="senha" name="senha" size="20">
                                </td>
                            </tr>
                            <tr>
                            	<td>&nbsp;
                                	
                                </td>
                            </tr>                        
                            <tr>
                            	<td align="center">
                                	<input type="button" name="enviar" value="Login" onclick="valida_campos_login();">
                                </td>
                            </tr>
                            <tr>
                            	<td align="center">
                                	<label id="printms"></label>
                                </td>
                            </tr>
                            <tr>
                            	<td align="center">
                                	&nbsp;
                                </td>
                            </tr>                            
                            <tr>
                            	<td align="center">
                                	<a href="http://<?=$server;?>/index.php?acao=1">Acessar Vers&atilde;o Web</a>
                                </td>
                            </tr>
                   </table>  
               </form>	                                         
                  <!--<p class="more"><a href="index/?pag=2" class="link">More Articles</a></p>-->
			</ul>
		  </div> 
        <!--! end of #main -->	
		</div> <!--! end of #container -->
	<div style="height:51px;width:100%;clear:both">&nbsp;<br></div>  
	<div style="position:fixed; bottom:0px;margin-left:auto;margin-right:auto"><script type='text/javascript'><!--//<![CDATA[
  
