<?require "../libs/ajax/xajax_core/xajax.inc.php"; // XAJAX
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
include_once "../libs/cla.leads.php";            
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
        	
		<!--[if gte IE 8.0]>
		<style type="text/css">
			#main.t-moda-p-collections ul.collections li a {
				width: 33%;
			}
		</style>
		<![endif]-->
		
		<?
                       
            $codlead = $_REQUEST['codlead']; 
            
            if(!empty($_REQUEST['acao'])){   
     
                if($_REQUEST['acao']=='ist'){
                    $codlead = leads::adicionar($_REQUEST);
                }elseif ($_REQUEST['acao']=='alt') {

                   $codlead = leads::alterar($_REQUEST['codlead'],$_REQUEST); 
                }
                ?>
                    <script>
                        location.href = "mobile_dadoslead_form.php?codlead=<?=$codlead;?>" ;
                    </script>
                <?   
            } 
            if(!empty($_REQUEST['codlead'])){                   
                $sql = "Select
                            l.codlead,  
                            l.cod_polo,
                            l.razaosocial,
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
                        
                $result = sql_query($sql);
            	if($row = mysql_fetch_array($result)){
            	    
                    $cod_polo = $row['cod_polo'];                    
                    $codlead = $row['codlead'];
                    $razaosocial = $row['razaosocial'];
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
                            
            	}      
                mysql_free_result($result);     
            }else{
                $_REQUEST['CodGerenteConta'] = ($GerenteContas?$_SESSION['codusuario']:null);
				$_REQUEST['CodAtendente'] = ($Atendente?$_SESSION['codusuario']:null);
				$_REQUEST['CodStatusClassificacaoLead'] = 2;
				$_REQUEST['StatusClassificacaoLead'] = 'Target';
            }          
             
        ?>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <script type="text/javascript" language="javascript" src="mobile_form.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/datepicker.js"></script>
        <script type="text/javascript" language="javascript" src="../extras/prototype.js"></script>
        <script type="text/javascript" language="JavaScript" src="../extras/mascaras.js"></script>
        <script type="text/javascript" src="../extras/jquery-1.2.1.pack.js"></script>
        <?	include_once "../libs/head.php";?>
        <script>
            function obrigatorio(){
                document.getElementById('razaosocial').style.border = 'solid 3px blue';
                document.getElementById('ddd').style.border = 'solid 3px blue';
                document.getElementById('tel').style.border = 'solid 3px blue';
                	var frm = document.forms[0];
                	
                	<?
                	
					if($tipo_pessoa != ""){
						echo "frm.tipo_pessoa.value = '".$tipo_pessoa."';";
					}
					?>				
		
            }
            
        </script>
	</head>         
    
<body class="home" onload="obrigatorio()"> 		
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
                <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
                <form name="dados" method="post" action="mobile_lead_form.php" onsubmit="return salvar_lead()">
                    <input type="hidden" name="acao" value="" />
                    <input type="Hidden" name="contato" value="">
                    <input type="Hidden" name="acesso" value="1">
                    <input type="Hidden" name="codlead" value="<?=$codlead;?>">
                    <input type="Hidden" name="codstatusclassificacaolead" value="<?=$codstatusclassificacaolead;?>">
                    
                	<table align="left" width="90%">
                       <tr>
                            <td class="title">
                        	   <b>LEAD</b>
                            </td>
                        </tr>                    
                    	<tr>
                            <td align="left">
                        	   <h2>polo</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   	<?
                                	//PARAMETRO DO POLO
                                   
                                	$polo = "";
                                	if(!empty($cod_polo)){
                                		$polo = $cod_polo;
                                	}else{
                                		$polo = $_SESSION['cod_polo'];
                                	}
                                	combo::polo($polo,'');
                                ?>
                            </td>
                        </tr>                    
                    	<tr>
                            <td align="left">
                        	   <h2>Raz&Atilde;o Social</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <input type="text" id="razaosocial" name="razaosocial" size="30" maxlength="150" value="<?=$razaosocial;?>"  validate="required" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                        	   <h2>Tel</h2>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
        						(<input type="text" id="ddd" class="input1" name="ddd" size="2" maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=$ddd;?>"  validate="required;regexp=/^\d{2}$/" />)
                                &nbsp;<input type="text" id="tel" class="input1" name="tel" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=$tel;?>"  validate="required;datatype=tel" />
        							
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                <div id="maiscamposlead" style="display: inline;">
                                    <table >
                                        <tr>
                                            <td width="10%" class="title">
                                                <b>Dados</b>
                                            </td>
                                            <td align=left>
                                                <img src="images/vs_mais.png"  width="45" onclick="campos_lead(1);" border="1">         
                                            </td>
                                        </tr>
                                    </table>
                                </div>                              
                                <div id="menoscamposlead" style="display: none;">
                                    <table>
                                        <tr>
                                            <td width="10%" class="title">
                                                <b>Dados</b>
                                            </td>                                        
                                            <td>
                                                &nbsp;<img src="images/vs_menos.png" width="45" onclick="campos_lead(0);">      
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
                                           <select name='tipo_pessoa' onchange="cpfoucnpj(this.value)">
                    							<option></option>
                    							<option value='PJ'>CNPJ</option>
                    							<option value='PF'>CPF</option>
                    						</select>
                                            <input type="text" id="cnpj_cpf" name="cnpj_cpf" size="22" maxlength="18" value="<?=$cnpj_cpf;?>" validate="datatype=cnpj_cpf" />
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
                                </table>
                                </div>                        	   
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
									print "<input type=hidden name=codgerenteconta value=".$consultor['CodUsuarioInterno']." />";
									print $consultor['Nome'];
								}
							}else{	

								if(!empty($codgerenteconta)){
									$ConsultorDefault = $codgerenteconta;
								}else{
									$ConsultorDefault = $_SESSION['codusuario'];
								}		
								
								combo::consultor_equipe1($ConsultorDefault);
							}
						?>      							
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
        						if($GerenteContas){
        							if($acao == ""){
        								$mailing = "Prospeccao";
        							}
        
        							$mailing_complemento = "readonly";
        						}
        						?>
        						<input type="text" id="mailing" name="mailing" maxlength="100" size="30" value="<?=$mailing;?>" <?= $mailing_complemento; ?> />    							
                            </td>
                        </tr>                                             
                        <tr>
                            <td>
                                <div id="mais_dados_contatos" style="display: inline;">
                                    <table>
                                        <tr>
                                            <td width="10%" class="title">
                                        	   <strong>Contatos</strong>
                                            </td>                                        
                                            <td>
                                                <img src="images/vs_mais.png" width="45"  onclick="campos_contato(1);">      
                                            </td>
                                        </tr>
                                        <!--<tr>
                                            <td align="left" colspan="2">
                                        	   <h2>Contato</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                        						<input type="text" id="nomecontato" name="nomecontato"  maxlength="50" size="30" value="<?=$nomecontato;?>" />    							
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <h2>Tel Contato</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                        						(<input type="text" id="ddd_fone" class="input1" name="ddd_fone" size="2"  maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=$ddd_fone;?>"  validate="required;regexp=/^\d{2}$/" />)
                                                &nbsp;<input type="text" id="fone" class="input1" name="fone" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=$fone;?>"  validate="required;datatype=tel1" />        							
                                            </td>
                                        </tr> -->                                       
                                    </table>
                                </div>                              
                                <div id="menos_dados_contatos" style="display: none;">
                                    <table>
                                        <tr>
                                            <td  width="10" class="title">
                                        	   <strong>Contatos</strong>
                                            </td>                                        
                                            <td>
                                                &nbsp;<img src="images/vs_menos.png" width="45" onclick="campos_contato(0);">      
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2"> 
                                        	   <h2>Contato</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                        						<input type="text" id="nomecontato" name="nomecontato"  maxlength="50" size="30" value="<?=$nomecontato;?>" />    							
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <h2>Tel Contato</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                        						(<input type="text" id="ddd_fone" class="input1" name="ddd_fone" size="2"  maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=$ddd_fone;?>"  validate="required;regexp=/^\d{2}$/" />)
                                                &nbsp;<input type="text" id="fone" class="input1" name="fone" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=$fone;?>"  validate="required;datatype=tel1" />        							
                                            </td>
                                        </tr>                                         
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <h2>ID Radio</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">                                        
                                        	   <input type="text" id="id_radio" name="id_radio"  size="10" maxlength="10" value="<?=$id_radio;?>" />
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <h2>Celular</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   (<input type='text' id="ddd_cel" name='ddd_cel'  size="2"  onKeyPress="mascara(this,soNumeros)" maxlength="2" value="<?=$ddd_cel;?>" validate="regexp=/^\d{2}$/" />
    				                           )&nbsp;<input type="text" id="cel" name="cel"  size="11" maxlength="10"  onKeyPress="mascara(this,telefone1)" value="<?=$cel;?>" validate="datatype=tel" />
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <h2>E-mail</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2">
                                        	   <input type='text' id="email" size="25" maxlength="50" name="email" value="<?=$email;?>" validate="datatype=email" />
                                            </td>
                                        </tr>  
                                    </table>
                                </div>                                   
                            </td>
                        </tr>
                        <?if(empty($codlead)){?> 
                            <tr>
                                <td align="left">
                            	   <h2>Info Prospec&Ccedil;&Atilde;o</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
            						<textarea id="txtocorrenciaini" name="txtocorrenciaini" style="width: 90%" rows="5"></textarea>    							
                                </td>
                            </tr>
                        <?}?> 
                        <tr>
                            <td align="left">                        	   
								<li>
									<!--<img src="images/seta4.png" width="30" height="30" onclick="document.dados.submit();">-->
									<input type="image" src="images/seta4.png"  value="ENVIAR" alt="Enviar">
								</li>  
                            </td>
                        </tr>                                                                                                    
                    </table>
                </form>
                </body>                             
            <!--<p class="more"><a href="index/?pag=2" class="link">More Articles</a></p>-->
			</ul>
		  </div> 
        <!--! end of #main -->	
	    </div> <!--! end of #container -->
<footer class="t-moda-p-footer">	
	<p class="back"><a href="javascript:history.go(-1)" class="link"></a></p>
</footer>
