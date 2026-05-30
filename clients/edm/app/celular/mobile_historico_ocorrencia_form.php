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
        	require "../libs/cla.equipes.php";
            include_once "../libs/maininclude.php";
            include_once "../libs/combo.php";
	        include_once "../libs/cla.combo.php";
	        include_once("../libs/cla.comboajax.php" ) ;           
               
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
                	<table align="left" width="100%" cellpadding="0" cellspacing="0">     
                        <tr>
                            <td class="title" >
                        	   <b>HISTÓRICO OC</b>
                            </td>
                        </tr>   

                    <?
                        $codlead = mysqlnull($_REQUEST['codlead']);
                        	
                        $sql = "SELECT 
                        			o.CodOcorrenciaLead
                        			,o.DataCadastro
                        			,oc.Descricao TipoOcorrenciaLead
                        			,o.DataFechamento
                        			,o.codusuariointerno
                        			,DATE_FORMAT(o.dt_retorno, '%d/%m/%Y %H:%i') dt_retorno
                        			,o.dt_retorno_fechamento
                        			,o.dsc_retorno
                        			,u.Nome NomeUsuarioInterno
                        			,ui1.nome as retornopara
                        			, o.CodUsuarioInterno CodUsuarioInterno
                        			, o.Descricao
                        			, l.razaosocial
                        		FROM ocorrenciaslead o
                        			inner join tipoocorrenciaslead oc ON (o.CodTipoOcorrenciaLead=oc.CodTipoOcorrenciaLead)
                        			inner join usuariosinternos u ON (o.CodUsuarioInterno=u.CodUsuarioInterno)
                        			LEFT JOIN usuariosinternos ui1 on o.agendadopara = ui1.codusuariointerno
                                    inner join leads l on o.codlead = l.codlead
                        		WHERE o.CodLead=".$codlead."";
                                //COLOCA OS DEMAIS PARÂMETROS
                        		if(!permissao('visualizar_todos_consultores', 'cs'))
                        			$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
                        			
                        		if(!permissao('visualizar_todos_atendentes', 'cs'))
                        			$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
                        
                        		$sql.=" ORDER BY o.datacadastro DESC ";
                        		
                        $result = sql_query($sql);
                        $rs = mysql_fetch_array($result);
                        ?>
                        <tr>
                            <td align="left" >
                        	   <h2>Razão Social</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <h1 class="title2"><b><a href="mobile_dadoslead_form.php?codlead=<?=$codlead;?>"><?=$rs['razaosocial'];?></a></b></h1><br>
                        	     
                            </td>
                        </tr> 
                        <?	
                        $cor = "#ffffff";
                        while($row = mysql_fetch_array($result)){
                            	if($cor=="#dfdfdf"){
                            		$cor = "#ffffff";
                            	}Else{
                            		$cor = "#dfdfdf";
                            	}
                    ?>                           

                            <tr class="top" bgcolor="<?=$cor?>">								
                                <td  align="left" width="90%">
                                    <h2>C&Oacute;d Oc</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><a href="mobile_ocorrencia_form.php?codocorrencialead=<?=$row['CodOcorrenciaLead'];?>"><h1 class="title2"><strong><?=$row['CodOcorrenciaLead'];?></strong></h1></a></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>DT Cadastro</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?=date('d/m/Y \à\s H:i', strtotime($row["DataCadastro"]));?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Tipo Oc</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?=$row["TipoOcorrenciaLead"];?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Descri&Ccedil;&Atilde;o Oc</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><a href="mobile_ocorrencia_form.php?codocorrencialead=<?=$row['CodOcorrenciaLead'];?>"><h1 class="title2"><strong><?=str_replace(chr(12), '<br />', htmlentities($row["Descricao"]))?></strong></h1></a></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Dt Fechto OC</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?=(empty($row['DataFechamento'])?'<strong style="color:red">Em aberto</strong>':date('d/m/Y \à\s H:i', strtotime($row["DataFechamento"])));?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Agendado<br>Para</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?=$row["retornopara"];?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Dt Retorno</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?=$row["dt_retorno"];?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                    <?
                        }
                    ?>  
				     <tr>
						<td>
							
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
    
     
