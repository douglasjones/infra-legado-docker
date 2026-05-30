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
        include_once "../libs/cla.combo_relatorios.php";
        include_once "../libs/cla.agenda.php";
        include_once "../libs/cla.equipes.php";
        include_once "../libs/cla.usuarios.php";           
          
    
        ?>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>
        <script type="text/javascript" language="JavaScript" src="../extras/mascaras.js"></script>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <?	include_once "../libs/head.php";
            
            $codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];
            //acesso da pagina inicial com todos os retornos abertos
            $acesso = $_REQUEST['acesso'];
            $agendadopara = $_REQUEST['agendadopara'];            
            $agendadopor = $_REQUEST['agendadopor'];
            if($agendadopara == ""){
	           $agendadopara = $_SESSION['codusuario'];
            }

            $data = explode("/",date("d/m/Y"));
            $nomemes = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
            
            if(!empty($_REQUEST['dia'])){
              $dia=$_REQUEST['dia'];  
            }else{
              $dia = $data[0];  
            }
            
            if(!empty($_REQUEST['mes'])){
              $mes=$_REQUEST['mes'];  
            }else{
              $mes = $data[1];  
            }
            if(!empty($_REQUEST['ano'])){
               $ano=$_REQUEST['ano']; 
            }else{
               $ano = $data[2];     
            }      
      
            ?>
	</head>         
</script>
	<style type="text/css">
	a:link {
		text-decoration:none;
	}
	a:visited {
		text-decoration:none;
	}
	a:hover {
		text-decoration:underline;
	}
	.agendamento {
		margin-top:3px;
		margin-bottom:5px;
		border-bottom:solid 3px #FFFFFF;
	}
	.outrabase {
		background-color: rgb(100, 100, 100);
		color: white;
	}
	.outromes {
		color:gray;
	}
	.concluido {
		background:rgb(150, 255, 150);
	}
	.atrasado {
		background:rgb(255, 150, 150);
	}
	.retorno {
		background:rgb(100, 100, 255);
	}
	.retorno a {
		color: white;
	}
	.respondido {
		background:rgb(255, 255, 150);
	}
	.status4 {
		background:rgb(255, 50, 50);
		color:white;
	}
	.status4 a {
		color:white;
	}
	.style1 {color: #FFFFFF}
    </style>   
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
                  <li class=""><a href="mobile_vendas_form.php" class="menu" title="Vendas"> Vendas </a></li>
                    <li class=""><a href="mobile_agenda.php" class="menu"> Agenda </a></li>
                    <li class="selected"><a href="mobile_retorno.php" class="menu"> Retorno </a></li>
                </ul>
          </nav>    
        <form name="dados" method="post" action="mobile_novolead_form.php" >
        <input type="hidden" name="acao" value="" />
        <input type="Hidden" name="contato" value="">
        <input type="Hidden" name="acesso" value="1">
        <?
            $sql ="select 
                                oc.dt_retorno_fechamento,
                                l.RazaoSocial,
                                l.codlead,
                                ui1.nome agendadopor,
                                ui.Nome agendadopara,
                                tc.descricao,
                                oc.codocorrencialead,
                                DATE_FORMAT(oc.dt_retorno, '%d/%m/%Y') dtretorno,
                                DATE_FORMAT(oc.dt_retorno, '%H:%i') dt_retorno,
                                (SYSDATE() > oc.dt_retorno AND oc.dt_retorno_fechamento IS NULL) atrasado,
                                (oc.datafechamento IS NOT NULL) concluido,
                                (oc.dt_retorno_fechamento is not null and oc.datafechamento is null) respondido,
                                date_format(oc.dt_retorno, '%Y%m%d') chave";
                        $sql.="  from ocorrenciaslead oc ";
                        $sql.="       inner join leads l ON oc.codlead = l.codlead ";
                        $sql.="       inner join usuariosinternos ui on oc.agendadopara = ui.CodUsuarioInterno ";
                        $sql.="	      inner join usuariosinternos ui1 on oc.codusuariointerno = ui1.codusuariointerno ";
                        $sql.="       inner join tipoocorrenciaslead tc on oc.codtipoocorrencialead = tc.codtipoocorrencialead ";                        
                        $sql.="  where oc.agendadopara = ".$agendadopara ;

                        if(empty($acesso)){
							$sql.="  and oc.dt_retorno Between '".$ano."-".$mes."-".$dia." 00:00:00' And '".$ano."-".$mes."-".$dia." 23:59:59'";
                        }else{	
							$sql.="  and oc.dt_retorno is not null";
							$sql.="  and oc.dt_retorno_fechamento is null";
						}
                        
                        //if(!permissao('visualizar_todos_consultores', 'cs'))
                        //	$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
                        
                        if(!permissao('visualizar_todos_atendentes', 'cs'))
                        	$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
                        

                        if($agendadopor != ""){
                        	$sql.=" and oc.codusuariointerno = ".$agendadopor." ";
                        }
                        if($codtipoocorrencialead != ""){
                        	$sql.=" and oc.codtipoocorrencialead = ".$codtipoocorrencialead." ";
                        }
                        if($status != ""){
                        	if($status == 1){
                        		$sql.=" and (SYSDATE() > oc.dt_retorno AND oc.dt_retorno_fechamento IS NULL) ";
                        	}
                        	if($status == 2){
                        		$sql.=" and (oc.dt_retorno_fechamento is not null and oc.datafechamento is null) ";
                        	}
                        	if($status == 3){
                        		$sql.=" and (oc.datafechamento IS NOT NULL) ";
                        	}
                        }
                        $sql .= " order by oc.dt_retorno ";
                                       
                        $result = mysql_query($sql);
                        $num = mysql_num_rows($result);	
        ?>        
        <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0" >
			<?if(empty($acesso)){?>
				<tr>
					<td align="center">
						<!--Voltar Ano-->
						&nbsp;<a href="mobile_retorno.php?dia=<?=$dia;?>&mes=<?=$mes;?>&ano=<?=$ano - 1;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" />Ano</a>
						&nbsp;
						<!--Voltar MES-->
						<a href="mobile_retorno.php?dia=<?=$dia;?>&mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" border="1" />M&ecirc;s</a>
						&nbsp;
						<!--Voltar Dia-->
						<a href="mobile_retorno.php?dia=<?=($dia == 1)?31:$dia - 1;?>&mes=<?=$mes;?>&ano=<?=($dia == 1)?$ano - 1:$ano;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" />Dia</a>
					</td>
				</tr>
				<tr>
					<td align="center" class="title5">
						<strong><?=$dia.'/'.$nomemes[$mes].'/'.$ano;?>&nbsp;-&nbsp;<?=$num;?> Retornos(s)</strong>            		
					</td>
				</tr>
				<tr>
					<td align="center">					
						<!--Voltar Dia-->
						&nbsp;<a href="mobile_retorno.php?dia=<?=($dia == 1)?31:$dia + 1;?>&mes=<?=$mes;?>&ano=<?=($dia == 1)?$ano - 1:$ano;?><?=$filtro;?>">Dia<img src="images/seta1.png" width="25" height="25" /></a>
						<!--Voltar MES-->
						<a href="mobile_retorno.php?dia=<?=$dia;?>&mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?><?=$filtro;?>">M&ecirc;s <img src="images/seta1.png" width="25" height="25" /></a>
						&nbsp;
						<!--Voltar Ano-->
						<a href="mobile_retorno.php?dia=<?=$dia;?>&mes=<?=$mes;?>&ano=<?=$ano + 1;?><?=$filtro;?>">Ano<img src="images/seta1.png" width="25" height="25" /></a>
					</td>
				</tr>
            <?}else{?>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td align="center" class=title2>
						<b>Retono(s) <?=$num;?> Pendente(s)</b>
					</td>
				</tr>
			<?}?>
        </table>

        <br />  
        <br />
        <br />
        <br />           
        <div id="main" role="main" class="t-moda-p-news">            	
			<ul class="news-list no-photo">         	
                        

                	<table align="left" width="100%" cellpadding="0" cellspacing="0" >

                     <? 
                           
                        while($row = mysql_fetch_array($result)){
                            
                            $cor= '';
    						if($row['concluido']==1){
    							$cor = "class=concluido ";
    						}
    						if($row['atrasado']==1){
    							$cor = "class=atrasado";
    						}
    						if($row['respondido']==1){
    							$cor = "class=respondido";
    						}   					
                            
                    ?>    

                         <tr <?=$cor;?> class="top">                                                  
                             <td align=left>								 
								<?if(!empty($acesso)){?>
									<label class="horarioagenda"><a href="mobile_ocorrencia_form.php?codocorrencialead=<?=$row['codocorrencialead'];?>&codlead=<?=$row['codlead'];?>"><b><?=$row['dtretorno'];?> às <?=date('H:i', strtotime($row['dt_retorno']));?></b></a></label>
								<?}else{?>
									<label class="horarioagenda"><a href="mobile_ocorrencia_form.php?codocorrencialead=<?=$row['codocorrencialead'];?>&codlead=<?=$row['codlead'];?>"><b><?=date('H:i', strtotime($row['dt_retorno']));?></b></a></label>
                                <?}?>
                                <h1 class="textoagenda"><b><?=$row['descricao'];?></b></h1>
                                <a href="mobile_dadoslead_form.php?codlead=<?=$row['codlead'];?>"><h1 class="title2" ><b><?=agenda::razao_social($row['RazaoSocial']);?></b></h1></a>
                                <h1 class="textoagenda"><strong>Agendado para:</strong><?=$row['agendadopara'];?></h1>                                
                                <h1 class="textoagenda"><strong>Agendado por:</strong><?=$row['agendadopor'];?></h1>   
                            </td>                                                                                                    
                        </tr>
                        <tr class="final">
                            <td class="lateral" >                               
                               <?if(empty($row['concluido'])){?><a href="mobile_ocorrencia_form.php?codlead=<?=$row['codlead'];?>&codocorrencialead=<?=$row['codocorrencialead'];?>"  class="link" title="FINALIZAR OCORRENCIA"><img src="images/documento.png" width="35" height="35"/></a> 
                               <?}?><br />  
                            </td>   
                        </tr  
                        <tr class="top"    >
                            <td >
                                &nbsp;
                            </td>
                        </tr>                            
                                             	
            <?}?>                                                                                                                        
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
    
     
