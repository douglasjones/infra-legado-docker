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
 
            $codlead = $_REQUEST['codlead'];
            $codagendalead = $_REQUEST['codagendalead'];
            $codtipo = "1"; 
            if(!empty($_REQUEST['reagendar']))
	           $reagendar = $_REQUEST['codagendalead'];                      
                        
           
            if(!empty($_REQUEST['acao'])){
				if(!empty($_REQUEST['codgerenteconta'])){
					$_REQUEST['gerentecontas'] = $_REQUEST['codgerenteconta'];
			    }

                if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1]))
            		$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]).' '.$_REQUEST['datacadastro'][1];
            	if(!empty($_REQUEST['datahorario'][0]) && !empty($_REQUEST['datahorario'][1]))
            		$_REQUEST['datahorario'] = dataYMD($_REQUEST['datahorario'][0]).' '.$_REQUEST['datahorario'][1];
            	if(!empty($_REQUEST['datacancelamento'][0]) && !empty($_REQUEST['datacancelamento'][1]))
            		$_REQUEST['datacancelamento'] = dataYMD($_REQUEST['datacancelamento'][0]).' '.$_REQUEST['datacancelamento'][1];
            		else
            			$_REQUEST['datacancelamento'] = 'null';                        

                if(isset($_REQUEST['reagendar'])){                    
                   $values = agendaslead::adicionar($_REQUEST, $_REQUEST['reagendar']);  
                }        
                if($_REQUEST['acao']=='ist'){  
                      
                
                   $values = agendaslead::adicionar($_REQUEST);
                  
                  
                }elseif ($_REQUEST['acao']=='alt') {
                   $values = agendaslead::alterar($_REQUEST['codagendalead'],$_REQUEST); 
                }
                
                
                
                    $codlead = $values['codlead'];
                    $reagendar = $values['reagendar'];

                    ?>
                        <script>
                            location.href = "mobile_dadosagenda_form.php?codlead=<?=$codlead;?>";
                        </script>
                    <?  
                
  
            }   
          if(!empty($codagendalead)){ 
            $sql = "SELECT
                        l.razaosocial,
                        a.cep,
                        a.endereco,
                        a.numero,
                        a.complemento,
                        a.bairro,
                        a.cidade,                       
                        a.uf,
                        agc.CodGerenteConta,
                        l.codgerenteconta as gerente_lead,
                        ui.nome as visita_agendadopor,
                        a.datahorario,
                        a.cod_tamanho_visita ,
                        a.codtipo,
                        ta.descricao as tipo,
                        a.linha_nova,
                        a.linha_adicao,
                        a.linha_portabilidade,
                        a.linha_renovacao,
                        a.linha_migracao,
                        a.linha_transferencia,
                        a.descricao
                    FROM agendaslead a
                        INNER JOIN leads l on a.codlead = l.codlead
                        LEFT JOIN agendagerenteconta agc on a.codagendalead = agc.codagendalead 
                        INNER JOIN usuariosinternos ui on a.codusuariointerno = ui.codusuariointerno
                        INNER JOIN tipoagendamento ta on a.codtipo = ta.codtipo
                    WHERE a.codagendalead=$codagendalead";
            $result = sql_query($sql);
        	if($row = mysql_fetch_array($result)){
        	        
        	        $razaosocial = $row['razaosocial'];
                    $cep = $row['cep'];
                    $endereco = $row['endereco'];
                    $numero = $row['numero'];
                    $complemento = $row['complemento'];
                    $bairro = $row['bairro'];
                    $cidade = $row['cidade'];
                    $uf = $row['uf'];            				   
					$codgerenteconta = $row['CodGerenteConta'];
					$codgerentecontalead = $row['gerente_lead'];
                    $agendadopor = $row['visita_agendadopor'];
                    if(empty($reagendar)){
                        $datahorario = $row['datahorario'];
                    }
                    $cod_tamanho_visita = $row['cod_tamanho_visita'];
                    $codtipo =$row['codtipo']; 
                    $tipo=$row['tipo'];
                    $linha_nova = $row['linha_nova'];
                    $linha_adicao = $row['linha_adicao'];
                    $linha_portabilidade = $row['linha_portabilidade'];
                    $linha_renovacao = $row['linha_renovacao'];
                    $linha_migracao = $row['linha_migracao'];
                    $linha_transferencia = $row['linha_transferencia'];
                    $descricao = $row['descricao'];

            }
          }else{  
              if(!empty($codlead)){      
            	$sql = "SELECT
                            l.razaosocial,
                                l.cep,
                                l.endereco,
                                l.numero,
                                l.complemento,
                                l.bairro,
                                l.cidade,
                                l.uf,
                                l.codgerenteconta
                        FROM leads l
                        where l.codlead=$codlead";
                        
                $result = sql_query($sql);
            	if($row = mysql_fetch_array($result)){
                    $razaosocial = $row['razaosocial'];
                    $cep = $row['cep'];
                    $endereco = $row['endereco'];
                    $numero = $row['numero'];
                    $complemento = $row['complemento'];
                    $bairro = $row['bairro'];
                    $cidade = $row['cidade'];
                    $uf = $row['uf'];    
                    $codgerentecontalead = $row['codgerenteconta'];
                              
            	}      
                mysql_free_result($result);  
              }
          }
           
        ?>      
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
                <form name="dados" method="post" action="mobile_agenda_form.php" onsubmit="return salvar_agenda()">
                <?if(isset($reagendar)){?>
                    <input type="hidden" id="reagendar" name="reagendar" value="<?=$reagendar;?>" />
                <?}?>
                    <input type="hidden" name="acao" value="" />                    
                    <input type="Hidden" name="acesso" value="1">
                    <?if(isset($reagendar)){?>
                        <input type="hidden" id="reagendar" name="reagendar" value="<?=$reagendar;?>" />
                    <?}?> 
                    <?if(empty($reagendar)){?>                   
                        <input type="hidden" name="codagendalead" value="<?=$codagendalead?>" />    
                    <?}else{?>
                        <input type="hidden" name="codagendalead" value="" />
                    <?}?>
                    <input type="hidden" name="codlead" value="<?=$codlead?>" />
                    <input type="hidden" name="acesso" value="1" /> 
                    <input type="hidden" name="gerentecontas" value="1" /> 
                	<table align="left" width="100%" cellpadding="2" cellspacing="2" > 
                    
                       <tr>
                            <td class="title">
                        	   <b>agendamento</b>
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
                            <td align="left">
                                <h2>Cep</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9" onkeyup="if(this.value.length == 9) xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" onblur="xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" value="<?=$cep;?>" onKeyPress="mascara(this,cep1)"  validate="datatype=cep"/>
                            </td>
                        </tr>                                    
                        <tr>
                            <td align="left">
                                <h2>Endere&ccedil;o</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input type="text" id="endereco" name="endereco" size="30" maxlength="150" value="<?=$endereco;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>N&Uacute;mero</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input type="text" id="numero" name="numero" size="5" maxlength="5" onKeyPress="mascara(this,soNumeros)" value="<?=$numero;?>" />
                            </td>
                        </tr>    
                        <tr>
                            <td align="left">
                                <h2>Complemento</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input type="text" id="complemento" name="complemento" size="20" value="<?=$complemento;?>" />
                            </td>
                        </tr>  
                        <tr>
                            <td align="left">
                                <h2>Bairro</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input type="text" id="bairro" name="bairro" maxlength="63" size="30" value="<?=$bairro;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Cidade</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <input type="text" id="cidade" name="cidade" maxlength="29" size="29" value="<?=$cidade;?>" />
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
                                $sql = "Select uf , nome from estados order by nome";
                                    combo($sql, "uf", $uf , "Selecione um Estado", "");
                                ?>                                
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <h2>contato</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <?//if(empty($agenda['DataCancelamento']) || $Root){
                                		$sql = "select CodContatoLead, NomeContato ";
                                		$sql .= " from contatoslead ";
                                		$sql .= " where CodLead = $codlead";
                                		combo($sql, "codcontatolead", @$agenda['CodContatoLead'], "", " validate='required'");?>
                                		<!--<input type="button" value="Incluir" onclick="incluirContato()" />-->
                                <?//}else{?>
                				<?//=$agenda['Contato'];?>
                                <?//}?>
                            </td>
                        </tr>   

                        <tr>
                            <td align="left">
                                <h2>Consultor</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
        						<?                                   
        							if(!permissao("alteraconsultor",  "al")){                                
                                        $consuldefault = ($acao==''&&$GerenteContas?$_SESSION['codusuario']:$codgerenteconta);        
        								if(!empty($consuldefault)){        								    
        									$sql = "Select
        												l.CodUsuarioInterno
        												, l.Nome
        											from usuariosinternos l
        											where l.codusuariointerno=".$consuldefault;
        									$rs1 = sql_query($sql);
        									$consultor = mysql_fetch_array($rs1);
        									echo "<input type=hidden name=gerentecontas value=".$consultor['CodUsuarioInterno']." />";
        									echo "<h1><b>".$consultor['Nome']."<b></h1>";
        								}
        							}else{	
        								
										$sql = "Select Distinct u.CodUsuarioInterno
												, u.Nome
												, l.CodGerenteConta
										from usuariosinternos u 
											left Join agendagerenteconta agc on u.CodUsuarioInterno = agc.CodGerenteConta
											Left Join agendaslead a on a.codagendalead = agc.codagendalead
											Left Join leads l on a.CodLead = l.CodLead    
										 Where 1";
										if(!empty($codgerenteconta)){
											$sql .= " And agc.CodAgendaLead = " . $codgerenteconta;
										}elseif(!empty($codgerentecontalead)){
											$sql .= " And u.CodUsuarioInterno = " . $codgerentecontalead;
										}else{
											$sql .= " And 0";
										}		
										$sql .=" group by u.CodUsuarioInterno";    
										
										$result = sql_query($sql);
										$row = mysql_fetch_array($result);										

										if($row['CodUsuarioInterno']==$row['CodGerenteConta']){											
											combo::consultor_equipe1($row['CodGerenteConta']);
										}else{											
											combo::consultor_equipe1($row['CodUsuarioInterno']);
										}
										mysql_free_result($result);        							
        							}
        						?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <h2>Agendado Por</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <?
                                    if(!empty($codagendalead)){
                                        echo "<input type='hidden' name='AgendadoPor' value=".$agendadopor." />";
                                        echo "<h1><b>".$agendadopor."</b></h1>";                                            
                                    }else{
                                        echo "<input type='hidden' name='AgendadoPor' value=".$_SESSION['codusuario']." />";
                                        echo "<h1<b>".$_SESSION['nomeusuario']."</b></h1";
                                    }    
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <h2>Data e hor&Aacute;rio</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <?if($acao == '' || $Root){?>
            					   <input type="text" id="datahorario" class="input1" name="datahorario[]" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=(!empty($datahorario)?date('d/m/Y', strtotime($datahorario)):'');?>" validate="datatype=date;required" />
            					   &nbsp;às&nbsp;
            					   <input type="text" id="horariovisita" class="input1" name="datahorario[]" size="8" maxlength="5" onkeypress="return horamask2(this,event)" value="<?=(!empty($datahorario)?date('H:i', strtotime($datahorario)):'');?>" validate="datatype=shorttime;required" />
                                <?}else{?>
            						<?=(!empty($datahorario)?date('d/m/Y \à\s H:i', strtotime($datahorario)):null);?>
                                <?}?>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <h2>Tamanho da Visita</h2>
                            </td>      
                        </tr> 
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td width="15%" align="left">
                                            Pequena 1 a 5
                                        </td>
                                        <td>
                                            <input type="radio" class="input1" name="cod_tamanho_visita" 
                	                    	<? if($cod_tamanho_visita==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
                	                    	<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
                	                    		<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
                	                    	<?}?>   value="1" />
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">
                                            M&eacute;dia 6 a 10&nbsp;
                                        </td>
                                        <td>
                                            <input type="radio" class="input1" name="cod_tamanho_visita" 
                	                  		<? if($cod_tamanho_visita==2){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
                	                    	<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
                	                    		<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
                	                    	<?}?>   value="2" />
                                        </td>
                                    </tr>                       
                                    <tr>
                                        <td align="left">
                                            Grande Acima de 10&nbsp;
                                        </td>
                                        <td>
                                            <input type="radio" class="input1" name="cod_tamanho_visita" 
                	                    	<? if($cod_tamanho_visita==3){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
                	                    	<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
                	                    		<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
                	                    	<?}?>   value="3" />
                                            <?
                                            $s = 3;
	                    		            echo "<input type='hidden' id='qtv' name='qtv' value='$s'>";                                        
                                            ?>
                                        </td>
                                    </tr>                                      
                                </table>
                            </td>                            
                        </tr>               
                        <tr>
                            <td align="left">
                                <h2>Tipo Agendamento</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <?if(empty($reagendar)){
                                		$sql = "Select CodTipo, Descricao" ;
                                		$sql .= " From tipoagendamento";
                                		$sql .= " Order by Descricao";
                                		combo($sql, "codtipo",$codtipo, "", 'validate="required"');                               
                                	}else{
                           	   ?>
                						<input type="hidden" id="Codtipo" name="Codtipo" value="<?=$codtipo;?>" />
                						<h1><b><?=$tipo;?></b></h1>
                                <?}?>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <h2>Linhas</h2>
                            </td>      
                        </tr>                        
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td  width="15%" align="left">
                                            Linhas Novas
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input1" name="linha_nova" 
                                        	<? if($linha_nova==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />        	                    			
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">
                                            Linhas Adi&ccedil;&atilde;o
                                        </td>
                                        <td>
                                        	<input type="checkbox" class="input1" name="linha_adicao" 
                                        	<? if($linha_adicao==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />
        	                    			
                                        </td>
                                    </tr>                       
                                    <tr>
                                        <td align="left">
                                            Linhas Portabilidade
                                        </td>
                                        <td>
        									<input type="checkbox" class="input1" name="linha_portabilidade" 
        									<? if($linha_portabilidade==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />
        	                    			
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td align="left">
                                            Linhas Renova&ccedil;&atilde;o
                                        </td>
                                        <td>
                                        	<input type="checkbox" class="input1" name="linha_renovacao" 
                                            <? if($linha_renovacao==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />
        	                    			
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td align="left">
                                            Linhas Migra&ccedil;&atilde;o
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input1" name="linha_migracao" 
                                        	<? if($linha_migracao==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />
        	                    			
                                        </td>
                                    </tr>    
                                    <tr>
                                        <td align="left">
                                            Linhas Transfer&ecirc;ncia
                                        </td>
                                        <td>
                                        	<input type="checkbox" class="input1" name="linha_transferencia" 
                                            <? if($linha_transferencia==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
        	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
        	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
        	                    			<?}?>   value="1" />
        	                    			
                                        </td>
                                    </tr>                                                                                                            
                                </table>
                            </td>                            
                        </tr>
                         <?if(!empty($reagendar)){?> 
							<tr>
								<td align="left">
									<h2>Motivo Reagendamento</h2>
								</td>
							</tr>
							<tr>
								<td>
										<? 	$sql = "Select m.cod_motivo_reagendamento,m.dsc_motivo_reagendamento" ;
									$sql .= " From motivo_reagendamento m";
									$sql .= " Order by dsc_motivo_reagendamento";
									combo($sql, "cod_motivo_reagendamento", $agenda['cod_motivo_reagendamento'], "", 'validate="required"');?><br />
									<textarea cols="50" rows="5" class="input1" name="dsc_reagendamento" validate="required"></textarea>

								</td>
							</tr>
                        <?}?>
                        <tr>
                            <td align="left">
                                <h2>descri&Ccedil;&Atilde;o</h2>
                            </td>
                        </tr> 
                        <tr>
                            <td align="left">
                                <textarea id="descricao" name="descricao" style="width:25%" rows="5"><?=$descricao;?></textarea>
                            </td>
                        </tr>
                        <?
                            if(!empty($codlead))  $operadoras = leads::operadoras($codlead);                            
                            (empty($operadoras)? $estilo='visibility:visible;': $estilo='visibility:hidden; position: absolute;');
                        ?>
                            <tr>
                                <td align="left">
									<br><br>
                                <div class="div_operadoras" style="<?=$estilo?>">
                                    <table>
                                        <?                                            
                                            
                                            $sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
    			                            $result = sql_query($sql);
    
                                            $i = 0;
                            				while($row = mysql_fetch_array($result))
                            				{
                            					(!empty($codlead)? (in_array($row['codigo'], $operadoras)? $checado='checked' : $checado='') : $checado='');
                            					   echo "<tr>";
                                                   echo     "<td width=15%>";
                                                   echo         $row['nome'];
                                                   echo      "</td>";
                                                   echo     "<td  >";                                                
                                                    echo "<div style='float:left; padding-right:10px;'>
                                						  <input type='checkbox' id='operadoras' name='operadoras[]' value='".$row["codigo"]."' ".$checado." />
                                						  </div>";
                                                    echo "</td>";
                                                   echo  "</tr>";     
                            					$i++;
                            				}
                            				echo "<input type='hidden' id='qtdop' name='qtdop' value='$i'>";
                            				mysql_free_result($result);	
                                        ?>
                                    </table>
                                 </div>   
                                </td>
                            </tr>
                       
                        <tr>
                            <td align="left">                        	  
                                <li>
                                    <!--<a href="javascript:salvar_agenda()"><img src="images/seta4.png" width="30" height="30" ><h2 class="title"><b>enviar</b></h2></a>-->
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
