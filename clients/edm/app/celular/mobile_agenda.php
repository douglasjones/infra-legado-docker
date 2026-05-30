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
            

			$sql ="Select  a.CodAgendaLead,
                                   a.CodLead,
                                   a.CodUsuarioInterno,
                                   s.Descricao Status,
                                   a.AgendadoPara,
                                   a.DataHorario,
                                   a.CodStatus,
                                   a.CodReagendamento,
                                   a.Descricao,
                                   t.Descricao Tipo,
                                   l.RazaoSocial,
                                   u1.Nome AgendadoPor,
                                   u2.Nome AgendadoPara,
                                   sc.Descricao AS statuslead,
                                   u3.nome AS AgendadoPor,
                                   a.endereco,
                                   a.cep,
                                   a.numero,
                                   a.complemento,
                                   a.bairro,
                                   a.cidade,
                                   a.uf";
                        $sql.="  from agendaslead a  ";
                        $sql.="       inner join leads l on a.CodLead = l.CodLead  ";
                        $sql.="       inner join usuariosinternos u1 on a.CodUsuarioInterno = u1.CodUsuarioInterno  ";
                        $sql.="       inner join tipoagendamento t on a.CodTipo = t.CodTipo ";
                        $sql.="       inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.CodStatusClassificacaoLead ";

                            if(!permissao('visualizar_todos_consultores', 'cs')){
                                if($codgerenteconta > "0")
                               	    $sql.=" inner join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
                                else
                                    $sql.=" left join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
                            }
                            else{
                                $sql.=" left join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
                            }                 	
                        
                            if(!empty($codgrupousuariointerno))
                            	$sql.=" inner join gruposusuariosinternos_usuariosinternos gu1 on gu1.CodUsuarioInterno = u1.CodUsuarioInterno ";
                            
                            if(!empty($codequipe))
                            	$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
                            
                            $sql.="       left join usuariosinternos u2 on a.AgendadoPara = u2.CodUsuarioInterno  ";
                            $sql.="       left join usuariosinternos u3 on a.CodUsuarioInterno = u3.CodUsuarioInterno  ";
                            $sql.="       left join statusagendamento s on a.CodStatus = s.CodStatus ";
                            $sql.="       where a.DataHorario Between '".$ano."-".$mes."-".$dia." 00:00:00' And '".$ano."-".$mes."-".$dia." 23:59:59'";
                            //Regras de visualização de equipe de consultores
                            if(!permissao('visualizar_todos_consultores', 'cs'))
                            	$sql .= " and agc.CodGerenteConta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";
                            
                            //regras de visualização de equipe de telemarketing
                            if(!permissao('visualizar_todos_atendentes','cs'))
                            	$sql .= " and a.CodUsuarioInterno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";
                            
                            //regras de visualização do polo
                            if(!empty($_SESSION['cod_polo']))
                            	$sql .= " and l.cod_polo = ".$_SESSION['cod_polo']." ";
                                
                            if($codgerenteconta == "0")
                            	$sql.="  and agc.codgerenteconta is null ";
                            elseif($codgerenteconta > 0)
                            	$sql.= " and agc.codgerenteconta = '".$codgerenteconta."'";

                            $sql.=" order by a.DataHorario";
                                                         
                        $result = mysql_query($sql);
                        $num = mysql_num_rows($result);	   
                        
                        
            ?>
	</head>         
<style type="text/css">	
	.status1 {
		background:rgb(150, 255, 150);
	}
	.status2 {
		background:rgb(255, 150, 150);
	}
	.status3 {
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
                    <li class="selected"><a href="mobile_agenda.php" class="menu"> Agenda </a></li>
                    <li class=""><a href="mobile_retorno.php" class="menu"> Retorno </a></li>
                </ul>
          </nav>    
        <form name="dados" method="post" action="mobile_novolead_form.php" >
        <input type="hidden" name="acao" value="" />
        <input type="Hidden" name="contato" value="">
        <input type="Hidden" name="acesso" value="1">
        <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0" >
            <tr>
				<td align="center">
					<!--Voltar Ano-->
                    &nbsp;<a href="mobile_agenda.php?dia=<?=$dia;?>&mes=<?=$mes;?>&ano=<?=$ano - 1;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" />Ano</a>
            		&nbsp;
                    <!--Voltar MES-->
            		<a href="mobile_agenda.php?dia=<?=$dia;?>&mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" border="1" />M&ecirc;s</a>
            		&nbsp;
                    <!--Voltar Dia-->
                    <a href="mobile_agenda.php?dia=<?=($dia == 1)?31:$dia - 1;?>&mes=<?=$mes;?>&ano=<?=($dia == 1)?$ano - 1:$ano;?><?=$filtro;?>"><img src="images/seta2.png" width="25" height="25" />Dia</a>
				</td>
            </tr>
            <tr>
				<td align="center" class="title5">
					<strong><?=$dia.'/'.$nomemes[$mes].'/'.$ano;?>&nbsp;-&nbsp;<?=$num;?> Visita(s)</strong>            		
				</td>
            </tr>
            <tr>
				<td align="center">					
                    <!--Voltar Dia-->
                    &nbsp;<a href="mobile_agenda.php?dia=<?=($dia == 1)?31:$dia + 1;?>&mes=<?=$mes;?>&ano=<?=($dia == 1)?$ano - 1:$ano;?><?=$filtro;?>">Dia<img src="images/seta1.png" width="25" height="25" /></a>
                    <!--Voltar MES-->
            		<a href="mobile_agenda.php?dia=<?=$dia;?>&mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?><?=$filtro;?>">M&ecirc;s <img src="images/seta1.png" width="25" height="25" /></a>
            		&nbsp;
                    <!--Voltar Ano-->
            		<a href="mobile_agenda.php?dia=<?=$dia;?>&mes=<?=$mes;?>&ano=<?=$ano + 1;?><?=$filtro;?>">Ano<img src="images/seta1.png" width="25" height="25" /></a>
				</td>
            </tr>
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
    						if($row['CodStatus']==1){
    							$cor = "class=status1 ";
    						}
    						if($row['CodStatus']==2){
    							$cor = "class=status2";
    						}
    						if($row['CodStatus']==3){
    							$cor = "class=status3";
    						}
    						if($row['CodStatus']==4){
    							$cor = "class=status4";
    						}
                    ?>    

                         <tr <?=$cor;?> class="top">                                                  

                             <td align="left">
								<a href="mobile_agenda_form.php?codagendalead=<?=$row['CodAgendaLead'];?>&codlead=<?=$row['CodLead'];?>"><label class="horarioagenda"><b><?=date('H:i', strtotime($row['DataHorario']));?></b></label></a>
                                <h1 class="textoagenda"><b><?=$row['Tipo'];?></b></h1>
                                <a href="mobile_dadoslead_form.php?codlead=<?=$row['CodLead'];?>"><h1 class="title2" ><b><?=agenda::razao_social($row['RazaoSocial']);?></b></h1></a>    
                                <h1 class="textoagenda" ><?= (!empty($row['cidade'])?' ('.capitalize($row['endereco']).','.capitalize($row['numero']).'-'.capitalize($row['Bairro']) .','.capitalize($row['complemento']) . " - " . $row['cep']. " - " . $agenda['cidade'] . ')':null);?></h1>                   
                                <h1 class="textoagenda"><?echo "<b>Status Lead: </b>".$row['statuslead'];?></h1>
                                <?
                                    
                                        if(!empty($row['CodAgendaLead'])){             
                                            $consultor = array();
                                            $sql = "Select
                                                      ui.Nome as gerente
                                                    from agendagerenteconta ag
                                                    inner join usuariosinternos ui on ag.CodGerenteConta = ui.CodUsuarioInterno
                                                    where ag.CodAgendaLead=".$row['CodAgendaLead'];
                                                
                                            $results = mysql_query($sql);
                                            while($rs = mysql_fetch_array($results)){
                                               $consultor[] = $rs['gerente'];     
                                            }
                                            $consultor = implode(" - ", $consultor);
                                            ?>
                                              <h1 class="textoagenda"><strong>Consultor: </strong><?=$consultor?></h1> 
                                            <?           
                                        }
                                        mysql_free_result($results);
        			            
                                ?>  
                                <h1 class="textoagenda"><strong>Agendado por:</strong><?=$row['AgendadoPor'];?></h1>   
                                                                <?$v_descricao=wordwrap($row['Descricao'], 30, "<br>", 1);?>
                                <h1 class="textoagenda"><strong>Observação:</strong><?=$v_descricao."\n";?></h1>
                             </td> 
                                                                                                    
                        </tr>
                        <tr class="final">
                            <td class="lateral" >
                               <a href='http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=<?=$row['endereco'];?>, <?= $row['numero'];?>, <?= $row['cidade'];?> - <?= $row['uf'];?>' target="_new"><img src="images/google_maps_tr.png" width="35" height="35" /></a>&nbsp;
                               <?if(empty($row['CodStatus'])){?><a href="mobile_agenda_classificar_form.php?codagendalead=<?=$row['CodAgendaLead'];?>"  class="link" title="CLASSIFICAR VISITA"><img src="images/classificacao_visita.png" width="35" height="35"/></a>&nbsp;
                               <a href="mobile_agenda_form.php?codagendalead=<?=$row['CodAgendaLead'];?>&codlead=<?=$row['CodLead'];?>&reagendar=Reagendar Visita"  class="link" title="REAGENDAR VISITA"><img src="images/reagendamento.png" width="35" height="35" /></a><?}?><br /> 
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
    
     
