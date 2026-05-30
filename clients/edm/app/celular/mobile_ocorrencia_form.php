<?
require "../libs/ajax/xajax_core/xajax.inc.php"; // XAJAX
require "../libs/funBuscarCep.php"; // Função que faz a busca do cep
require "../libs/naoperturbe.php"; // Função que faz a busca do nao perturbe procon

$checkedcpf = "";
$checkedcnpj = "checked";
$cnpjcpf_mask = "cnpj";

$ajax = new xajax();
$ajax->registerFunction("buscaCep");
$ajax->registerFunction("buscar_nao_perturbe");

function buscar_nao_perturbe($telefone, $descricao_bloqueado, $bloqueado){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');
	$resultado_busca = naoperturbe($telefone);

	$objResponse->assign($bloqueado, "value", $resultado_busca['bloqueado']);
	$objResponse->assign($descricao_bloqueado, "innerHTML", $resultado_busca['descricao']);

	return $objResponse;
}

##################################### BUSCA CEP #####################################
function buscaCep($cep, $endereco, $bairro, $cidade, $uf){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');

	if(empty($cep)){
		return $objResponse;
	}

	//$cep = str_replace("-", "", $cep);

	$resultado_busca = busca_cep($cep); // Retorna um array

	// Coloca os valores dos arrays nos campos do formulário
	$objResponse->assign($endereco, "value", $resultado_busca['tipo_logradouro']." ".$resultado_busca['logradouro']);
	$objResponse->assign($bairro, "value", $resultado_busca['bairro']);
	$objResponse->assign($cidade, "value", $resultado_busca['cidade']);
	$objResponse->assign($uf, "value", $resultado_busca['uf']);

	// Retorna a resposta de XML gerada pelo objeto do xajaxResponse
	return $objResponse;
}

// Manda o ajax processar os pedidos acima
$ajax->processRequest();
include_once "../libs/maininclude.php";
$ajax->printJavascript('../libs/ajax/');
include_once "../libs/cla.agendaslead.php";   
include_once "../libs/datas.php";      
include_once "../libs/cla.combo.php";  
include_once "../libs/cla.ocorrencias.php";    
?>
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
        <link rel="stylesheet" href="../extras/datepicker.css" type="text/css">
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>
        <script type="text/javascript" language="JavaScript" src="../extras/mascaras.js"></script>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script> 
		<?        	     
            include_once "../libs/head.php";
 
        
            $acao = 'ins';
            $codlead = $_REQUEST['codlead'];         
            $codocorrencialead = $_REQUEST['codocorrencialead'];
            $codusuariointerno = $_SESSION['codusuario'];
			$usuariointerno = $_SESSION['nomeusuario'];
            
            if(!empty($_REQUEST['acao'])){
				if(!empty($_REQUEST['datacadastro'])){
					if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1])){
						$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]) . ' ' . $_REQUEST['datacadastro'][1];
					}else{
						$_REQUEST['datacadastro'] = null;
					}
				}
					
				//DATA RETORNO
				if(!empty($_REQUEST['dt_retorno'])){
					if(!empty($_REQUEST['dt_retorno'][0]) && !empty($_REQUEST['dt_retorno'][1])){
						$_REQUEST['dt_retorno'] = dataYMD($_REQUEST['dt_retorno'][0]) . ' ' . $_REQUEST['dt_retorno'][1];
					}else{
						$_REQUEST['dt_retorno'] = null;
					}
				}
				//DATA RETORNO
				if(!empty($_REQUEST['vencimentocontrato'])){
					if(!empty($_REQUEST['vencimentocontrato'])){
						$_REQUEST['vencimentocontrato'] = dataYMD($_REQUEST['vencimentocontrato']) ;
					}else{
						$_REQUEST['vencimentocontrato'] = null;
					}
				}
				
				if(!empty($_REQUEST['datafechamento'])){
					if(!empty($_REQUEST['datafechamento'][0]) && !empty($_REQUEST['datafechamento'][1])){
						$_REQUEST['datafechamento'] = dataYMD($_REQUEST['datafechamento'][0]) . ' ' . $_REQUEST['datafechamento'][1];
					}else{
						$_REQUEST['datafechamento'] = null;
					}
				}
				if(!empty($_REQUEST['codocorrencialead'])){
					$codocorrencia = $_REQUEST['codocorrencialead'];
					$values = ocorrencias::alterar($codocorrencia, $_REQUEST);
				}else{	
					$values = ocorrencias::adicionar($_REQUEST);
				}
				 $codlead = $values['codlead'];				 
                ?>
                    <script>
                        location.href = "mobile_historico_ocorrencia_form.php?codlead=<?=$codlead;?>";
                    </script>
                <?   
			}
            
            if(!empty($codocorrencialead)){
           	     $sql = "SELECT o.*
					,t.Descricao TipoOcorrenciaLead
					,u.Nome UsuarioInterno 
					,ui1.nome as nome_agendadopara
    			FROM ocorrenciaslead o 
    			INNER JOIN tipoocorrenciaslead t ON o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead 
    			INNER JOIN usuariosinternos u ON o.CodUsuarioInterno = u.CodUsuarioInterno 
    			left join usuariosinternos ui1 on o.agendadopara = ui1.codusuariointerno
    			WHERE o.CodOcorrenciaLead = " . mysqlnull($codocorrencialead);
                
                $result = sql_query($sql);
            	if($row = mysql_fetch_array($result)){
            		$codocorrencialead = $row['CodOcorrenciaLead']; 
            		$codlead = $row['CodLead'];
            		$descricao = $row['Descricao'];
            		$codtipoocorrencialead = $row['CodTipoOcorrenciaLead'];
            		$tipoocorrencialead = $row['TipoOcorrenciaLead'];
            		$datacadastro = $row['DataCadastro'];
            		$datafechamento = $row['DataFechamento'];
            		$codusuariointerno = $row['CodUsuarioInterno'];
            		$usuariointerno = $row['UsuarioInterno'];
            		$ocorrenciasuperior = $row['OcorrenciaSuperior'];
            		$agendadopara = $row['agendadopara'];
            		$dt_retorno = $row['dt_retorno'];
            		$dsc_retorno = $row['dsc_retorno'];
            		$dt_retorno_fechamento = $row['dt_retorno_fechamento'];
            		$nome_agendadopara = $row['nome_agendadopara'];
            		
                    if(!empty($dt_retorno)){
                        if(!empty($dt_retorno_fechamento)){
                            $desabilita="";
                        }else{
                            $desabilita="disabled='disabled'";
                        }  
            		}            	
            	}else{
            		$codocorrencialead = 0;
            	}
            	mysql_free_result($result);
            }
            
            $sql = "SELECT RazaoSocial FROM leads WHERE CodLead = " . mysqlnull($codlead);
            $result = sql_query($sql);
            if($row = mysql_fetch_array($result))
            $razaosocial = $row['RazaoSocial'];
            mysql_free_result($result);

            if(!empty($datafechamento)){
            	if(!permissao('occamposespeciais', 'al')){
					        
                        ?> 
                            <script>
                                alert('A ocorrência esta fechada. Abra uma nova!')
                                history.go(-1);    
                            </script>                        
                        <?
					//echo "<script>";
					//echo "alert('A ocorrência ".$codocorrencialead."  esta fechada. Abra uma nova!')";
					//echo "windows.location = 'mobile_historico_ocorrencia_form.php?codlead='";
					//echo "</script>";                   
                   //javascriptalert('A ocorrência ' . $codocorrencialead . ' esta fechada. Abra uma nova!');
                  
                   
                   //header('Location: mobile_historico_ocorrencia_form.php?codlead='.$codlead);
                }
            }
            
            /*if(!(($acao == 'ins' && permissao('ocorrencias', 'ic')) || ($acao == 'upd' && permissao('ocorrencias', 'al')))){
            	javascriptalert('Você não tem permissão para acessar esta página!!!');
            	exit;
            }*/
            
            //VERIFICA SE O USUARIO É O DE CADASTRO DA OCORRENCIA
            if($_SESSION['codusuario']  == $agendadopara){
            
            }else{
            if($_SESSION['codusuario']  != $codusuariointerno){
            	//VERIFICA SE O GRUPO TEM ACESSO A PERMISSAO DE EDICAO DE OUTRO USUARIO
            	if(!permissao('ocorrenciaoutrousuario', 'al')){
          			  //javascriptalert('Você não tem permissão para alterar ocorrências de outro usuário!!!');
                        ?> 
                            <script>
                                alert('Você não tem permissão para alterar ocorrências de outro usuário!')
                                history.go(-1);    
                            </script>
                        
                        <?
            		}
            	}
            }
           
        ?>
       

        <script>
            function desativar (){
            	var d = document.forms.dados;
            	<?if(!empty($dt_retorno)){?>
            		document.getElementById('retorno').style.display = "inline";
            	<?}?>
            	if (d.elements.lembrete.checked==true){ 
            		document.getElementById('retorno').style.display = "inline";
            		d.elements.fecharagora.disabled=true;		
            	}else{
            		document.getElementById('retorno').style.display = "none";
            		d.elements.fecharagora.disabled=false;
            		//Limpa os campos de data do retorno, horario do retorno e agendado para.
             		document.forms[0].dt_retorno.value = "";
             		document.forms[0].horarioretorno.value = "";
            	}
            	if (d.elements.dt_retorno_fechamento.checked==true){
            		d.elements.dsc_retorno.disabled=false;
            		<?if($codtipoocorrencialead==5002){?>	
            			d.elements.qtde_dias_retorno.disabled=false;
            		<?}?>
            	}else{
            		d.elements.dsc_retorno.disabled=true;
            		<?if($codtipoocorrencialead==5002){?>	
            			d.elements.qtde_dias_retorno.disabled=true;
            		<?}?>
            	} 	
            }
            function desativar1 (){
				var d = document.forms.dados;
				if (d.elements.dt_retorno_fechamento.checked==true){
					d.elements.dsc_retorno.disabled=false;
					<?if($codtipoocorrencialead==5002){?>	
						d.elements.qtde_dias_retorno.disabled=false;
					<?}?>
					<?if($agendadopara == $codusuariointerno){?>
						d.elements.fecharagora.disabled=false;
						d.elements.descricao.disabled=false;
					<?}?>		
				}else{
					d.elements.dsc_retorno.disabled=true;
					<?if($codtipoocorrencialead==5002){?>	
						d.elements.qtde_dias_retorno.disabled=true;
					<?}?>
					d.elements.fecharagora.disabled=true;
					d.elements.descricao.disabled=true;
				} 
			}
            function exibe(id) {
				var d = document.forms.dados;
				
				if (id==5) {
					document.getElementById('seminteresse').style.display = "inline";
					d.elements.fecharagora.checked==true;
				}else{
					document.getElementById('seminteresse').style.display = "none";
					d.elements.fecharagora.checked==false;
				}
				//VERIFICA SE EXISTE OS DADOS DE CARTA DE APRESENTACAO PARA O ENVIO DO EMAIL
				<?if(!empty($cod_email_empresa)){?>
					//ENVIO DE CARTA DE APRESENTACAO POR EMAIL
					if (id==20) {			
						document.getElementById('enviacartaapresentacao').style.display = "inline";
						//d.elements.lembrete.disabled=true;
					}else{
						document.getElementById('enviacartaapresentacao').style.display = "none";
						//d.elements.lembrete.disabled=false;
					}
				<?}?>
			}
            function valida(){    
                
				var d = document.forms.dados;
				var combotipooc = document.getElementById("codtipoocorrencialead").value;

				/*if(document.getElementById("codtipoocorrencialead").value==""){			
					document.getElementById('codtipoocorrencialead').style.border = 'solid 3px red';
					document.getElementById('codtipoocorrencialead').focus();
					return false;
				}*/	
				
				if(d.descricao.value==""){
					document.getElementById('descricao').style.border = 'solid 3px red';
					d.descricao.focus();
					return false;
				}    
				
				//Quando tem retorno
				<?if(empty($dt_retorno)){?>				
					if (d.lembrete.checked==true){										
						if(d.dt_retorno.value==""){			
							document.getElementById('dt_retorno').style.border = 'solid 3px red';
							d.dt_retorno.focus();
							return false;
						}								
						if(d.horarioretorno.value==""){			
							document.getElementById('horarioretorno').style.border = 'solid 3px red';
							d.horarioretorno.focus();
							return false;
						}	
						if(d.agendadopara.value==""){			
							document.getElementById('agendadopara').style.border = 'solid 3px red';
							d.agendadopara.focus();
							return false;
						}		
					}
					else{						
						//d.agendadopara.options[0].selected = true;
						//d.horarioretorno.value = "";
						//d.dt_retorno.value = "";
					}
				<?}?>
				
				//Fecha retorno
				
				<?if(!empty($dt_retorno)){?>
					if (d.dt_retorno_fechamento.checked==true){
						if(d.dsc_retorno.value==""){			
							document.getElementById('dsc_retorno').style.border = 'solid 3px red';
							d.dsc_retorno.focus();
							return false;
						}	
						<?if($codtipoocorrencialead==5002){?>	
							if(d.qtde_dias_retorno.value==""){			
								document.getElementById('qtde_dias_retorno').style.border = 'solid 3px red';
								d.qtde_dias_retorno.focus();
								return false;
							}		
						<?}?>			
						
					}
				<?}?>
				
				//valida se o motivo de sem interesse foi selecionado
				if(combotipooc== "5"){
				   <?if(empty($codtipoocorrencialead)){?>
					if(d.codmotivolead.value==""){			
						document.getElementById('codmotivolead').style.border = 'solid 3px red';
						d.codmotivolead.focus();
						return false;
					}
					<?}?>	
					
				}		
				
                if(d.codocorrencialead.value==""){
                    d.acao.value = "ist";    
                }else{
                    d.acao.value = "alt";
                }
                
				d.submit();
			}
        </script>
	</head>         
    
<body class="home" onload="desativar();"> 		
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
        <div id="main" role="main" class="t-moda-p-news">	
			<ul class="news-list no-photo">
                <form name="dados" method="post" action="mobile_ocorrencia_form.php" onsubmit="return valida()">
					<input type="hidden" name="codlead" value="<?=$codlead;?>" />
					<input type="hidden" name="codocorrencialead" value="<?=$codocorrencialead;?>" />
					<input type="hidden" name="codtipoocorrencialead" value="<?=$codtipoocorrencialead;?>" />
                    <input type="hidden" name="acao" value="" /> 
                    <input type="hidden" name="acesso" value="1" /> 
                	<table align="left" width="90%" border=0  cellspacing="2" border="2"> 
                		<tr>
                            <td class="title">
                        	   <b>Ocorr&Ecirc;ncia</b>
                            </td>
                        </tr>   
                		<?	
                			if(!empty($codocorrencialead)){
                		?>
                			<tr>
                				<td align="left"><h2>C&Oacute;digo</h2></td>                				
                			</tr>
                            <tr>
                                <td align="left"><?=$codocorrencialead;?></td>
                            </tr>
                		<?}?> 
            
                       <tr>
                            <td align="left" >
                        	   <h2>Raz&Atilde;o Social</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <b><?=$razaosocial;?></b>
                            </td>
                        </tr>                      
                       <tr>
                            <td align="left" >
                        	   <h2>Dt cadastro</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <b><?=(!empty($datacadastro)?date('d/m/Y \à\s H:i:s', strtotime($datacadastro)):'');?></b>                       	   
                            </td>
                        </tr>  
                       <tr>
                            <td align="left" >
                        	   <h2>Dt fechamento</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	
                    			if(empty($datafechamento)){
                    			?>
                    				<b><label for="fecharagora"><input type="checkbox" <?=$desabilita;?> name="fecharagora" id="fecharagora" value="1" />Fechar Ocorr&ecirc;ncia</label></b>
                    			<?	
                    			}else{
                    			if($acao == 'ins' || permissao('occamposespeciais', 'al')){
                    			?>
                    				<b><input type="text" id="datafechamento" name="datafechamento[]" size="10" maxlength="10" value="<?=(!empty($datafechamento)?date('d/m/Y', strtotime($datafechamento)):'');?>" validate="datatype=date" />
                    				&nbsp;às&nbsp;
                    				<input type="text" id="horariofechamento" name="datafechamento[]" size="8" maxlength="8" value="<?=(!empty($datafechamento)?date('H:i:s', strtotime($datafechamento)):'');?>" validate="datatype=time" /></b>
                    			<?		
                    			}else{
                    			?>
                    				<b><?=(!empty($datafechamento)?date('d/m/Y \à\s H:i:s', strtotime($datafechamento)):null);?></b>
                    			<?		}
                    				}
                    			?>                      	   
                            </td>
                        </tr>
       
                       <tr>
                            <td align="left" >
                        	   <h2>Tipo de Ocorr&Ecirc;ncia</h2>
                            </td>
                        </tr>       
                        <tr>
                            <td align="left">
                                <?
                					if($acao == 'ins' || permissao('occamposespeciais', 'al')){
                						$sql = "SELECT CodTipoOcorrenciaLead, t.Descricao FROM tipoocorrenciaslead t";
                						$sql .= " where (t.cod_operador is null or t.cod_operador=0 or cod_operador in (Select cod_operador from empresa_operador) )";		
                						if(!$Root){
                							$sql .= " and Automatica = 0 or CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
                						}
                						$sql .= " Order by t.Descricao";
                						combo($sql, "codtipoocorrencialead", $codtipoocorrencialead, "", "onchange='exibe(this.value)' ");
                					}else{ 
                					?>
                						<b><?= $tipoocorrencialead;?></b>
                					<?
                					}
					               ?>                      	   
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Descri&Ccedil;&Atilde;o</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <textarea cols="40" rows="5" id="descricao" <?=$desabilita?> name="descricao" validate="required"><?=$descricao?></textarea>                    	   
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Usu&Aacute;rio</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	
                				if(!permissao('occamposespeciais', 'al')){
                				?>
                					<b><?=$usuariointerno;?></b>
                				<?	
                				}else{
                					$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($codusuariointerno) . " Order By ui.Nome";
                					combo($sql, "codusuariointerno", $codusuariointerno, "", 'validate="required"');
                				}?>                  	   
                            </td>
                        </tr>
                        <?if(empty($dt_retorno)){?>	
                            <tr>
                                <td align="left">
                                    <h2>Agendar Retorno</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <input type="Checkbox" name="lembrete" value="1" onclick="desativar(1);">              	   
                                </td>
                            </tr>
                        <?}?>   
						<tr>
							<td>
								<div id="retorno" style="display: none;">
									<table >
										<tr>
											<td align="left"  >
												<h2>Dt e Hr Retorno</h2>
											</td>
										</tr>
                            		   <tr>
											<td align="left" >
												<?if(!empty($dt_retorno)){?>
													<?=(!empty($dt_retorno)?date('d/m/Y', strtotime($dt_retorno)):'');?>&nbsp;&#224;s&nbsp;
													<?=(!empty($dt_retorno)?date('H:i:s', strtotime($dt_retorno)):'');?>
												<?}else{?>
													<input type="text" id="dt_retorno" class="input1" name="dt_retorno[]" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=(!empty($dt_retorno)?date('d/m/Y', strtotime($dt_retorno)):'');?>" validate="datatype=date;required" />
													&nbsp;&#224;s&nbsp;
													<input type="text" id="horarioretorno" class="input1" name="dt_retorno[]" size="8" maxlength="5" onkeypress="return horamask2(this,event)" value="<?=(!empty($dt_retorno)?date('H:i', strtotime($dt_retorno)):'');?>" validate="datatype=shorttime;required" />
												<?}?>
											</td>
										</tr>  
	
										<tr>
											<td align="left" >
												<h2>Agendado para</h2>
											</td>
										</tr>
										<tr>
											<td align="left" >
												<?if(empty($agendadopara)){				
													$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($agenda['AgendadoPara']) . " Order By ui.Nome";
													combo($sql, "agendadopara", $_SESSION['codusuario']," " , "");
												  }else{
													print $nome_agendadopara;
												  }
												?>
											</td>
										</tr>
										<?
										if(!empty($dt_retorno)){
										?>	
											<tr>
												<td align="left" >
													<h2>Fechar Retorno</h2>
												</td>
											</tr>
											<tr>
												<td align="left" >
													<?if(empty($dt_retorno_fechamento)){
														if($agendadopara == $_SESSION['codusuario'] or (!empty($Admin)) ){?>
															<input type="Checkbox" name="dt_retorno_fechamento" value="1"  onclick="desativar1(1);">
														<?}?>									
													<?}else{
														print (!empty($dt_retorno_fechamento)?date('d/m/Y \à\s H:i:s', strtotime($dt_retorno_fechamento)):'');
													}?>	
												</td>
											</tr>										
											<tr>
												<td align="left" >
													<h2>Descri&Ccedil;&Acirc;o Retorno</h2>
												</td>
											</tr>
											<tr>
												<td align="left" >
													<textarea cols="40" rows="5" id="dsc_retorno"  disabled="disabled"  name="dsc_retorno"><?=$dsc_retorno;?></textarea>
												</td>
											</tr>
										<?}?>
									</table>
								</div>
							</td>
						</tr>                                                                                                                    
                        <tr>
                            <td align="left">                        	   
                                <li>
                                    <!--<a href="javascript:valida()"><img src="images/seta4.png" width="30" height="30" ><h2 class="title"><b>enviar</b></h2></a>-->
									<input type="image" src="images/seta4.png"  value="ENVIAR" alt="Enviar">
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
