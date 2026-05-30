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
            
            if(!empty($_REQUEST['acao'])){
                if($_REQUEST['acao']=='ist'){
                  $values = agendaslead::informacao($_REQUEST); 

                  $codlead = $values['codlead']; 
                ?>
                    <script>
                        location.href = "mobile_dadosagenda_form.php?codlead=<?=$codlead;?>";
                    </script>
                <?   
                }    
            }     
            
            ?>   
        <script>
            function seminteresse (cod){
    if(cod==2){
        document.getElementById('seminteresse').style.display = "inline";
    }else{
        document.getElementById('seminteresse').style.display = "none";
    }
}
        </script>   
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
                  <li class=""><a href="mobile_vendas_form.php" class="menu" title="Vendas"> Vendas </a></li>
                    <li class="selected"><a href="mobile_agenda.php" class="menu"> Agenda </a></li>
                    <li class=""><a href="mobile_retorno.php" class="menu"> Retorno </a></li>
                </ul>
          </nav>    
        <div id="main" role="main" class="t-moda-p-news">	
			<ul class="news-list no-photo">
                <form name="dados" method="post" action="mobile_agenda_classificar_form.php" onsubmit="return salvar_classificacaoagenda()">
                    <input type="hidden" name="acao" value="" /> 
                    <input type="Hidden" name="codlead" value="<?=$codlead;?>">                   
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
                	<table align="left" width="100%" cellpadding="2" cellspacing="2" > 
                       <tr>
                            <td class="title">
                        	   <b>classifica&Ccedil;&Atilde;o</b>
                            </td>
                       </tr>                       
                       <tr>
                            <td align="left" >
                        	   <h2>T&eacute;rmino</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <input type="text" id="termino"     name="termino"       size="6" maxlength="8" onkeypress="return horamask2(this,event)" value="<?=(!empty($agenda['Termino'])?date('H:i', strtotime($Termino)):null);?>" validate="datatype=shorttime" />
                            </td>
                        </tr>                      
                       <tr>
                            <td align="left" >
                        	   <h2>Status Agendamento</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?	
                                $sql  = "SELECT CodStatus ,
                                				Descricao
                                		   FROM statusagendamento
                                		  WHERE CodStatus NOT IN ( 3 , 4 , 5 )
                                	   ORDER BY Descricao" ;                                	   
                                combo( $sql , "codstatus" , $agenda['CodStatus'] , " " , "onchange='seminteresse(this.value);'" ) ; 	
                                ?>                        	   
                            </td>
                        </tr>  
                       <tr>
                            <td align="left" >
                        	   <h2>Informa&Ccedil;&Atilde;o da visita</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <textarea cols="55" rows="5" id="informacoes" name="informacoes" style="width: 90%" rows="5" validate="required"><?=$agenda['Informacoes'];?></textarea>                       	   
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="seminteresse" style="display: none;">				
                					<table cellpadding="2" cellspacing="2" border="0" >
                						<tr>		
                							<td >
                								&nbsp;
                							</td>			
                						</tr>
                						<tr>
                							<td align="center" class="title"  ><b>Lead Sem Interesse</b></td>
                						</tr>
                						<tr>		
                							<td >
                								&nbsp;
                							</td>			
                						</tr>					
                						<tr>
                							<td align="left"> 
                								<h2>Motivo Sem Interesse</h2>
                							</td>
                						</tr>
                                        <tr>	
                                            <td align="left">
                								<?	
                									$sql = "Select m.* ";
                									$sql .= " from motivoslead m ";
                									$sql .= " Order By m.Descricao ";
                									combo($sql, "codmotivolead", $codmotivolead, " ", '');
                								?>
                							</td>
                						</tr>
                						<tr>
                							<td align="left"><h2>Vencimento do Contrato:</h2></td>
                                        </tr>
                                        <tr>
                                            <?
                							$sql = "Select 
                									l.codlead
                									,DATE_FORMAT(l.VencimentoContrato, '%Y-%m-%d') as datavencimento
                									,qtde_linhas
                								  from leads l
                								  where l.codlead=".$codlead;
                                                  								  
                							    $rs = mysql_query($sql);
                				                $row_rs = mysql_fetch_array($rs);
                				                $dt_vencimento= $row_rs["datavencimento"];
                								$qtde_linha= $row_rs["qtde_linhas"];
                				                mysql_free_result($rs);
                								
                								if(!empty($dt_vencimento)){?>								
                									<input type="hidden" name="vencimento_contrato" value="<?=$dt_vencimento;?>" />			
                								<?}?>    
                							<td align="left">
                								<input type="text" id="vencimentocontrato" name="vencimentocontrato" onKeyPress="mascara(this,datamask)" maxlength="10" size="12" value="<?= $vencimentocontrato;?>" validate="datatype=date" />
                							</td>
                						</tr>
                						<tr>
                							<td align="left">
                                                <h2>Qtde de Linhas:</h2>
                                            </td>
                						</tr>
                                        <tr>	
                                            <td align="left">
                								<input type="text" id="qtde_linhas" name="qtde_linhas" onKeyPress="mascara(this,soNumeros)" maxlength="10" size="12" value="<?=$qtde_linha;?>" />
                							</td>
                						</tr>	
                						<tr>
                							<td align="left">
                                                <h2>Operadoras contratadas:</h2>                       
                                            </td>
                						</tr>
                                        <tr>	
                                            <td>
                								<?                                                     
                									if(!empty($codlead))  $operadoras = leads::operadoras($codlead);
                                                    									
                									(empty($operadoras)? $estilo='visibility:visible;': $estilo='visibility:hidden; position: absolute;');
                									
                									$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
                									
                                                    $result = sql_query($sql);
                									
                									$i = 0;
                									while($row = mysql_fetch_array($result))
                									{
                										(!empty($codlead)? (in_array($row['codigo'], $operadoras)? $checado='checked' : $checado='') : $checado='');
                										echo "<div style='float:left; padding-right:10px;'>
                											  <input type='checkbox' id='operadoras' name='operadoras[]' value='".$row["codigo"]."' ".$checado." />".$row["nome"]."
                											  </div>";
                										$i++;
                									}
                									echo "<input type='hidden' id='qtdop' name='qtdop' value='$i'>";
                									mysql_free_result($result);	  
                								?>
                							</td>
                						</tr>	
                                        <tr>
                                            <td>
                                                &nbsp;
                                            </td>
                                        </tr>					
                					</table>
                				</div>                                
                            </td>
                        </tr>                                                   
                        <tr>
                            <td align="left">                        	   
								<li>
									<!--<a href="javascript:salvar_classificacaoagenda()"><img src="images/seta4.png" width="30" height="30" ><h2 class="title"><b>enviar</b></h2></a>-->
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
