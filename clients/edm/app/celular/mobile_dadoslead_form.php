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
            include_once "../libs/cla.leads.php";            
            include_once "../libs/cla.combo.php";
            
            
            if(!permissao('leads', 'dt')){
		      javascriptalert('Você não tem permissão para acessar esta página!!!');
		      exit;
	        }            
            
            $codlead = $_REQUEST['codlead'];
            
            $sql = "Select
                        l.codlead,  
                        l.cod_polo,
                        l.razaosocial,
                        l.nomefantasia,
                        l.ddd,
                        l.tel,
                        l.codgerenteconta,
                        l.mailing, 
                        sc.descricao status,
                        l.codstatusclassificacaolead,
                        l.cep,
                        l.endereco,
                        l.numero,
                        l.complemento,
                        l.bairro,
                        l.cidade,
                        l.uf, 
                        l.cnpj_cpf,
                        lc.nomecontato,
                        lc.ddd_fone,
                        lc.fone,
                        lc.id_radio,
                        lc.ddd_cel,
                        lc.cel,
                        lc.email,
                        l.tipo_pessoa                          
                    from leads l
                        inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.codstatusclassificacaolead
                        left join contatoslead lc on l.codlead = lc.codlead                      
                    where l.codlead=".$codlead;
                    if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){
            			if($equipe)
            				$sql .= " and l.CodGerenteConta in (select Fk_Usuario from tb_usuarioequipe where Fk_Equipe = $equipe)";
            			elseif($GerenteContas)
            				$sql .= " and l.CodGerenteConta = ".mysqlnull($_SESSION['codusuario']
            			);
            		}
   
            $result = sql_query($sql);
        	if($row = mysql_fetch_array($result)){        	    
                $cod_polo = $row['cod_polo'];                    
                $codlead = $row['codlead'];
                $razaosocial = $row['razaosocial'];
                $nomefantasia = $row['nomefantasia'];
                $ddd = $row['ddd'];
                $tel = $row{'tel'};                    
                $codgerenteconta = $row['codgerenteconta'];
                $mailing = $row['mailing'];
                $status = $row['status'];
                $codstatusclassificacaolead = $row['codstatusclassificacaolead'];
                $cep = $row['cep'];
                $endereco = $row['endereco'];
                $numero = $row['numero'];
                $complemento = $row['complemento'];
                $bairro = $row['bairro'];
                $cidade = $row['cidade'];
                $uf = $row['uf'];
                $cnpj_cpf = $row['cnpj_cpf'];
                $nomecontato = $row['nomecontato'];
                $ddd_fone = $row['ddd_fone'];
                $fone = $row['fone'];
                $ddd_cel = $row['ddd_cel'];
                $cel = $row['cel'];
                $id_radio = $row['id_radio']; 
                $email = $row['email'];     
                $tipo_pessoa = $row['tipo_pessoa'];              
        	}else{        	 
    			?>
    				<script>
    					alert('Você não tem permissão para acessar Lead de outro Consultor!!!!');
    					location.href=("mobile_inicio_form.php");
    				</script>
    			<?
		      exit;	
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
                <form name="dados" method="post" action="mobile_novolead_form.php" >
                    <input type="hidden" name="acao" value="" />
                    <input type="Hidden" name="contato" value="">
                    <input type="Hidden" name="acesso" value="1">
                	<table align="left" width="100%" cellpadding="2" cellspacing="2" >
                       <tr>
                            <td class="title">
                        	   <b>LEAD</b>
                            </td>
                        </tr>
                       <tr>
                            <td align="left" >
                        	   <h2>Cod Lead</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                               <h1><b><?=$codlead;?></b></h1>
                            </td>
                        </tr>                
                    	<tr>
                            <td align="left" >
                        	   <h2>Raz&auml;o Social</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <h1><b><?=$razaosocial;?></b></h1>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" >
                        	   <h2>Nome Fantasia</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <h1><b><?if(!empty($nomefantasia)){ echo $nomefantasia; }else{ echo '&nbsp;';}?></b></h1>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" >
                        	   <h2>Tel</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" >
        						(<b><?=$ddd;?></b>)&nbsp;<b><?=$tel;?></b>        							
                            </td>
                        </tr> <tr>
                            <td>
                                <div id="maiscamposlead" style="display: inline;">
                                    <table>
                                        <tr>
                                            <td width="10" class="title">
                                                <b>Dados</b>
                                            </td>
                                            <td>
                                                <img src="images/vs_mais.png" width="45" onclick="campos_lead(1);"/>        
                                            </td>
                                        </tr>
                                    </table>
                                </div>                              
                                <div id="menoscamposlead" style="display: none;">
                                    <table>
                                        <tr>
                                            <td width="10" class="title">
                                                <b>Dados</b>
                                            </td>
                                            <td>
                                                <img src="images/vs_menos.png" width="45"  onclick="campos_lead(0);"/>    
                                            </td>
                                        </tr>
                                    </table>
                                </div>                                 
                            </td>
                        </tr>                      
                        <tr>
                            <td align="left">
                                <div id="dadoslead" style="display: none;">
                                <table>
                                    <tr>
                                        <td align="left">
                                            <h2>CNPJ/CPF</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($tipo_pessoa)){ echo $tipo_pessoa; }else{ echo '&nbsp;';}?>&nbsp;<?if(!empty($cnpj_cpf)){ echo $cnpj_cpf; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td align="left">
                                            <h2>Cep</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($cep)){ echo $cep; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td align="left">
                                            <h2>Endere&ccedil;o</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($endereco)){ echo $endereco; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <h2>N&Uacute;mero</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($numero)){ echo $numero; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>    
                                    <tr>
                                        <td align="left">
                                            <h2>Complemento</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($complemento)){ echo $complemento; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td align="left">
                                            <h2>Bairro</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($bairro)){ echo $bairro; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <h2>Cidade</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">                                            
                                            <h1><b><?if(!empty($cidade)){ echo $cidade; }else{ echo '&nbsp;';}?></b></h1>
                                        </td>
                                    </tr>     
                                    <tr>
                                        <td align="left">
                                            <h2>Estado</h2>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">
                                            <?	
                                            $sql = "Select uf , nome from estados where uf='$uf' order by nome ";
  	                                        $result = sql_query($sql);
        	                                if($row = mysql_fetch_array($result)){
        	                                   echo "<h1><b>".$row['uf']."-".$row['nome']."</h1><b>";
                                            }
                                            mysql_free_result($result);      
                                            ?>
                                        </td>
                                    </tr>                                                                                                                                                                                                    
                                </table>
                                </div>
                        	   
                            </td>
                        </tr>                        
                        <tr>
                            <td align="left" >
                        	   <h2>Consultor</h2>
                            </td>
                        </tr>                        
                        <tr>
                            <td align="left">
        					   <?
                                
                                if(!empty($codgerenteconta)){
                                    $sql = "Select
                                                ui.nome,
                                                ui.codusuariointerno
                                            from usuariosinternos ui
                                            where ui.codusuariointerno=".$codgerenteconta;
                                    $sql .=" and ui.GerenteContas=1";

                                    $result = mysql_query($sql);
                                    if($row = mysql_fetch_array($result)){	                                   
                                        echo  "<h1><b>".$row['nome']."</b></h1>";                                     
                                    }
                                    mysql_free_result($result);         
                                }else{
                                    echo "&nbsp;";
                                }
                               ?>        							
                            </td>
                        </tr>  
                        <tr>
                            <td align="left" >
                        	   <h2>Status</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" >
                        	   <b><?=$status;?></b>
                            </td>
                        </tr>                         
                        <tr>
                            <td align="left" >
                        	   <h2>Mailing</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?if(!empty($mailing)){?>
        				        <h1><b><?=$mailing;?></b></h1>
                                <?}else{
                                    echo "&nbsp;";
                                }?>		    							
                            </td>
                        </tr> 
                        <tr>
                            <td >
                                <div id="mais_dados_contatos" style="display: inline;">
                                    <table>
                                        <tr>
                                            <td width="10" class="title">
                                        	   <strong>Contatos</strong>
                                            </td>
                                            <td>
                                                <img src="images/vs_mais.png" width="45"  onclick="campos_contato(1);"/>
                                            </td>
                                        </tr>                                        
                                     </table>
                                </div>
                                <div id="menos_dados_contatos" style="display:none;">
                                    <table >
                                        <tr>
                                            <td width="10" class="title">
                                        	   <strong>Contatos</strong>
                                            </td>
                                            <td>
                                                <img src="images/vs_menos.png" width="45" onclick="campos_contato(0);"/>
                                            </td>
                                        </tr>
                                        <?
                                            $sql = "Select
														c.codcontatolead 
														, c.nomecontato
														, c.fone 
														, c.ddd_fone 
														, c.id_radio 
														, c.cel
														, c.ddd_cel
														, c.email
														, c.CodSetorContato
														, c.CodFuncaoContato 
														, s.Descricao Setor 
														, f.Descricao Funcao
														, c.tel_contato_bloqueado
														, c.cel_contato_bloqueado
														, c.Ramal_Fone
                                                    from contatoslead c
                                                    left join setorcontatos s on c.CodSetorContato = s.CodSetorContato
                                                    left join funcaocontato f on c.CodFuncaoContato = f.CodFuncaoContato
                                                    where c.codlead=$codlead";
                                                    
                                            $v = 1;        
                                            $result = sql_query($sql);        
                                            while($row = mysql_fetch_array($result)){        
                                        ?>
                                           <tr class="top">
                                                <td  class="title2">
                                                    <b>CONTATO <?=$v;?></b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="left" colspan="2">
                                                    <h2>NOME</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="left" colspan="2">
                                                    <h1><b><?if(!empty($row['nomecontato'])){ echo $row['nomecontato']; }else{ echo '&nbsp;';}?></b></h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="left" colspan="2">
                                                    <h2>fone</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="left" colspan="2">
                                                    <h1><b><?if(!empty($row['fone'])){ echo '('.$row['ddd_fone'].') '.$row['fone']; }else{ echo '&nbsp;';}?></b></h1>
                                                </td>
                                            </tr>                                     
                                            <tr>
                                                <td align="left" colspan="2">
                                            	   <h2>ID Radio</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" colspan="2">
                                                   <h1><b><?if(!empty($row['id_radio'])){ echo $row['id_radio']; }else{ echo '&nbsp;';}?></b></h1>                                        	   
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td align="left" colspan="2">
                                            	   <h2>Celular</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" colspan="">
                                                    <h1><b><?if(!empty($row['cel'])){ echo '('.$row['ddd_cel'].') '.$row['cel']; }else{ echo '&nbsp;';}?></b></h1>                                        	   
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td align="left" colspan="2">
                                            	   <h2>E-mail</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" colspan="2">
                                                <h1><b><?if(!empty($row['email'])){ echo $row['email']; }else{ echo '&nbsp;';}?></b></h1>                                        	   
                                                </td>
                                            </tr>   
                                        <?
                                            $v ++;
                                          }
                                           mysql_free_result($result);  
                                        ?>                                       
                                     </table>
                                </div>                                                         
                            </td>
                        </tr>                                                           
                       <tr>
                            <td align="left">    						    
                                    <li>
            					     <a href="mobile_lead_form.php?codlead=<?=$codlead;?>" class="link" title="Editar Lead"><img src="images/documento.png" width="35" height="35"><b>Editar Lead</b></a>
                                    </li>  	
                                    <li>   
            					      <a href="mobile_dadosagenda_form.php?codlead=<?=$codlead;?>" class="link" title="Agenda de Visitas"><img src="images/agenda.jpeg" width="35" height="35"><b>Agenda</b></a>
                                    </li>
                                    <li>   
            					      <a href="mobile_historico_ocorrencia_form.php?codlead=<?=$codlead;?>" class="link" title="Histórico de Ocorrências"><img src="images/nova_ocorrencia.gif" width="30" height="30"><b>Ocorrências</b></a>
                                     </li>
                                     <li>   
            					      <a href="mobile_ocorrencia_form.php?codlead=<?=$codlead;?>" class="link" title="Nova Ocorrência"><img src="images/adicionar.png" width="30" height="30" ><b>Nova Ocorrência</b></a>
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
    
     
