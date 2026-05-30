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
	        include_once("../libs/cla.comboajax.php" ) ;           
            
            
            if(!permissao('leads', 'cs')){
            	javascriptalert('Você não tem permissão para acessar esta página!!!');
            	exit;
            }         
            
            $pagina = 1;
            	$tam_pagina = 30;
            
            	//$cod_polo = $_REQUEST['cod_polo'];
            	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
            	$razaosocial = $_REQUEST['razaosocial'];
            	$nomefantasia = $_REQUEST['nomefantasia'];
            	$cnpj = $_REQUEST['cnpj'];
            	$id_radio = $_REQUEST['id_radio'];
            	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
            	$codgerenteconta = $_REQUEST['codgerenteconta'];
            	$codatendente = $_REQUEST['codatendente'];
            	$mailing = $_REQUEST['mailing'];
            	$cod_campanha = $_REQUEST['cod_campanha'];
            	$cod_operadora = $_REQUEST['cod_operadora'];
            	$cidade = $_REQUEST['cidade'];
            	$dataini = $_REQUEST['dataini'];
            	$datafim = $_REQUEST['datafim'];
            	$busca = $_REQUEST['busca'];
            	$tipo_pessoa = $_REQUEST['tipo_pessoa'];
            	$ddd = $_REQUEST["ddd"];
            	$tel = $_REQUEST["tel"];
            	$segmento = $_REQUEST["segmento"];
            	$cep = $_REQUEST['cep'];
            	$bairro = $_REQUEST["bairro"];
            	$pagina = $_REQUEST['pagina'];
            	$ddd_cel = $_REQUEST['ddd_cel'];
            	$cel = $_REQUEST['cel'];
				$codlead = $_REQUEST['codlead'];
            	
            	if(empty($pagina))
            		$pagina = 1;
            	
            	//calcula o registro de início e fim da página
            	if($pagina == 1){
            		$reg_inicio = 0;
            		$reg_fim = 0;
            	}
            	else{
            		$reg_inicio = ($pagina * $tam_pagina - $tam_pagina);
            		$reg_fim = $reg_inicio;
            	}
            	$reg_fim += $tam_pagina;
	
            
            $sql ="";
        	$sql.="select l.codlead, l.razaosocial,l.nomefantasia, scl.descricao statusclassificacaolead, ui.nome gerenteconta,ui1.nome as atendente,l.mailing ";
        	$sql.="  from leads l ";
        	$sql.="       inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
        	
        	if(!empty($codequipe))
        		$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
        	
        	// só utilizará inner join com a tabela de usuários se o parâmetro gerente de conta for enviado
        	if(!empty($codgerenteconta))
        		$sql.="       inner ";
        	else
        		$sql.="       left ";
        			
        	$sql.="             join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
        						left join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno";
        	
        	//fim do join com gerente de contas
        	
        	//faz join com contatos quando a o id do rádio for informado
        	if(!empty($id_radio) || !empty($ddd_cel) || !empty($cel))
        		$sql.=" inner join contatoslead cl on cl.codlead = l.codlead ";
        	
        	$sql.=" where 1=1 ";
        	
        	//COLOCA OS DEMAIS PARÂMETROS
        	if(!empty($codstatusclassificacaolead))
        		$sql.= " and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
        		
        	if(!empty($razaosocial))
        		$sql.="  and l.razaosocial like '%$razaosocial%' ";
        	
        	if(!empty($busca))
        		$sql.=" and (l.id_fornecedor like ".mysqlnull("%".$busca."%")." or l.razaosocial like " . mysqlnull("%".$busca."%") . " or l.nomefantasia Like " . mysqlnull("%".$busca."%") . " or l.cnpj_cpf Like " . mysqlnull("%{$_REQUEST['busca']}%")  . " or l.codlead = " . mysqlnull("".$busca."").") ";
        	
        	if(!empty($nomefantasia))
        		$sql.=" and l.nomefantasia like '%$nomefantasia%' ";
        	
        	if(!empty($id_fornecedor))
        		$sql.=" and l.id_fornecedor like '%".$id_fornecedor."%' ";
        	
        	if(!empty($cnpj))
        		$sql.=" and l.cnpj_cpf like '%$cnpj%' ";
        	
        	if(!empty($id_radio))
        		$sql.=" and cl.id_radio like '%$id_radio%' ";
        		
        	if(!empty($ddd_cel))
        		$sql.=" and cl.ddd_cel like '%$ddd_cel%' ";
        		
        	if(!empty($cel))
        		$sql.=" and cl.cel like '%$cel%' ";
        		
        	if(!empty($codequipe))
        		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);
        		
        	if($codgerenteconta > 0){
        		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
        	}else{
        		if($codgerenteconta == '0'){
        			$sql.=" and ui.codusuariointerno is null";
        		}
        		else{
        			if(!permissao('visualizar_todos_consultores', 'cs'))
        				//if(empty($busca))
        					$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
        		}
        	}			        		
        	if($codatendente > 0){
        		$sql.=" and l.codatendente = $codatendente ";
        	}else{
        		if($codatendente == '0'){
        			$sql.=" and l.codatendente is null ";
        		}
        	}
        	if(!empty($cod_campanha))
        		$sql.=" and l.codlead in (select codlead from campanha_leads where cod_campanha =  $cod_campanha) " ;	
        	
        	if(!empty($cod_operadora))
        		$sql.=" and l.codlead in (select codlead from leads_operadoras where cod_operadora = $cod_operadora) ";
        		
        	if(!empty($mailing))
        		$sql.=" and l.mailing = '$mailing' ";
			
			//codlead	
			if(!empty($codlead))
        		$sql.=" and l.codlead =". $codlead;
        		
        	if(!empty($dataini))
        		$sql.=" and l.datacadastro >= '".DataYMD($dataini)." 00:00:00' ";
        		
        	if(!empty($datafim))
        		$sql.=" and l.datacadastro <= '".DataYMD($datafim)." 23:59:59' ";
        	
        	if(!empty($cidade))
        		$sql.=" and l.cidade like '%".$cidade."%' ";
        	
        	if(!empty($tipo_pessoa))
        		$sql.=" and l.tipo_pessoa = '".$tipo_pessoa."' ";
        		
        	if(!empty($segmento))
        		$sql.=" and l.segmento like '%".$segmento."%' ";
        		
        	if(!empty($bairro))
        		$sql.=" and l.bairro like '%".$bairro."%' ";
        		
        	if(!empty($cep))
        		$sql.=" and l.cep like '".$cep."%' ";
        		
        	if($_REQUEST['cod_polo'] > 0){
        		$sql.=" and l.cod_polo=".$_REQUEST['cod_polo'];
        	}else{
        		if($_REQUEST['cod_polo'] == '0'){
        			$sql.=" and l.cod_polo=0";
        		}
        	}
        	
        	if(!empty($ddd)){
        		$sql.=" and l.ddd = '".$ddd."' ";
        	}
        	
        	if(!empty($tel)){
        		$sql.=" and l.tel like '%".$tel."%' ";
        	}
        	
        	if(!empty($dt_transf_ini) && !empty($dt_transf_fim))
        		$sql.=" and l.codlead in (select oc.codlead from ocorrenciaslead oc where oc.codtipoocorrencialead = 77 and oc.datacadastro between '".DataYMD($dt_transf_ini)." 00:00:00' and '".DataYMD($dt_transf_fim)." 23:59:59' ) ";
        	
        	$sql.=" order by l.razaosocial 
        	        limit 10";
           	
        	$result = mysql_query($sql);
        	$num = mysql_num_rows($result);	
        	
        	if($num < $reg_fim){
        		$reg_fim = $num;
        	}
        	
        	if($reg_fim == "0"){
        		$reg_inicio = 0;
        	}
        	else{
        		$reg_inicio++;
        	}
    
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
                	<table align="left" width="100%" cellpadding="0" cellspacing="0" border=0>
						<tr>
							<td class="title5">
								<b>Total de Leads <?=$num;?></b>
							</td>
						</tr>     
                    <?
                    	$cor = "#ffffff";
                    	$pagina_atual = 1;
                    	$registro = 1;
                    	while($row = mysql_fetch_array($result)){
                    	
                    		if ($pagina_atual == $pagina){
                    	
                    			if($cor=="#dfdfdf"){
                    				$cor = "#ffffff";
                    			}
                    			else{
                    				$cor = "#dfdfdf";
                    			}	
                      ?>
                            <tr class="top" bgcolor="<?=$cor?>">
                                <td  align="left" width="90%" >
                                    <h2>C&Oacute;d Lead</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <a href="mobile_dadoslead_form.php?codlead=<?=$row['codlead'];?>"><h1 class="title2"><strong><?=$row['codlead'];?></strong></h1></a>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Raz&Auml;o Social</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>"	>
                                <td align="left">
                                    <a href="mobile_dadoslead_form.php?codlead=<?=$row['codlead'];?>"><h1 class="title2"><strong><?=$row['razaosocial'];?></strong></h1></a>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Nome Fantasia</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>"	>
                                <td align="left">
                                    <h1 class="title2"><strong><?=$row['nomefantasia'];?></strong></h1></a>
                                </td>
                             </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Consultor</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">                                    
                                    <strong><?if(!empty($row['gerenteconta'])){ echo $row['gerenteconta']; }else{ echo '&nbsp;';}?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Atendente</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">                                    
                                    <strong><?if(!empty($row['atendente'])){ echo $row['atendente']; }else{ echo '&nbsp;';}?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Status</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?= $row['statusclassificacaolead'];?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td  align="left">
                                    <h2>Mailing</h2>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td align="left">
                                    <strong><?if(!empty($row['mailing'])){ echo $row['mailing']; }else{ echo '&nbsp;';}?></strong>
                                </td>
                            </tr>
                            <tr bgcolor="<?=$cor?>">
                                <td >
                                    &nbsp;
                                </td>
                            </tr>
                      <?
                		}
                		
                		if($registro == $tam_pagina){
                			$pagina_atual ++;
                			$registro = 1;
                		}
                		else{
                			$registro ++;
                		}
                		
                	}
                	mysql_free_result($result);
                	?>                                                                                                                                                                                                                                             
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
    
     
