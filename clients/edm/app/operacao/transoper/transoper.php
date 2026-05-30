<?php
include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/combo.php" ) ;
include_once( "../../libs/cla.logg.php" ) ;
include_once( "../../libs/cla.combo.php" ) ;
include_once( "../../libs/cla.ocorrencias.php" ) ;
include_once "../../libs/datas.php";

//VELIDA PERMISSAO DE ACESSO
if(!permissao( 'transoper' , 'cs' )){
	javascriptalert( 'Você não tem permissão para acessar esta página!!!' ) ;
	exit();
}
$passo = $_REQUEST['passo'];
$codlead = $_REQUEST['codlead'];
$cod_polos = $_REQUEST['cod_polo'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$mailing_pk = $_REQUEST['mailing_pk'];
$cod_campanha = $_REQUEST['cod_campanha'];
$cidade = $_REQUEST['cidade'];
$cep = $_REQUEST['cep'];
$cod_operadora = $_REQUEST['cod_operadora'];
$dataini = $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];
$codstatusclassificacaolead_pk = "";

$cod_operadora = $_REQUEST['cod_operadora'];
$status_cliente_pk = $_REQUEST['status_cliente_pk'];
$status_base_pk = $_REQUEST['status_base_pk'];
$dt_ativacao_ini = $_REQUEST['dt_ativacao_ini'];
$dt_ativacao_fim = $_REQUEST['dt_ativacao_fim'];
$dt_venc_contrato_ini = $_REQUEST['dt_venc_contrato_ini']; 
$dt_venc_contrato_fim = $_REQUEST['dt_venc_contrato_fim']; 
$qtdeli_ini = $_REQUEST['qtdeli_ini']; 
$qtdeli_fim = $_REQUEST['qtdeli_fim'];
$qtdeli_dados_ini = $_REQUEST['qtdeli_dados_ini'];
$qtdeli_dados_fim = $_REQUEST['qtdeli_dados_fim'];
?>

<html>
<head>
<!--Include CSS-->
<style>
div.tabela{
color:#ffffffff; 
padding:0px; 
width:1050px; 
height:250px; 
overflow:auto; 
}
</style>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">

<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
<?	include_once "../../libs/head.php";?>
<script>
function paginainicial(){

    window.location = "transoper.php"

}   
function valida(){
	if (document.atendente.codatendentepara.value==""){
		alert('Atendente não foi preenchido !');
		document.atendente.codatendentepara.focus();
		return false;
	}
}
function exibirAjuda(){
	strMensagem ="";
	strMensagem+="Objetivo: Transferência de leads entre operadores\n"
	strMensagem+="Abrangência: Supervisores de Telemarketing, Gerentes e Administradores\n"
	strMensagem+="Funcionalidade: Transferir leads de operadores que sairam da empresa, transferir leads para reciclar a carteira.\n"
	strMensagem+="Parâmetros:\n"
	strMensagem+=" - Operadores: Quando selecionado o operador, o sistema tranferirá TODOS os leads do determinado status selecionado (target, O%, etc...) deste operador para outro;\n"
	strMensagem+=" - Operadores: Quando selecionada a opção 'nenhum', o sistema transferirá APENAS os leads sem operador designado (carteira nova);\n"
	strMensagem+=" - Consultor: Permite a seleção combinada entre Operador e Consultor. (transferência de prospecção para operador);\n"
	strMensagem+=" - Mailing: Permite a seleção combinada entre Operador e Mailing ou Consultor e Mailing ou os três. (transferência de mailing novo para operador);\n"
	
	alert(strMensagem);	
}
function desativa(v){	
	var d = document.forms.frm;

	if (d.selecao[0].checked==true){	
		for (i = 0; i < d.elements["codlead[]"].length; i++){
			d.elements["codlead[]"][i].disabled = true;
			d.elements["codlead[]"][i].checked	 = false;
		}
		//SEM INTERESSE
		if (d.status1){			
			d.elements.status1.disabled=false;
		}		
		//LEAD TARGET
		if (d.status2){			
			d.elements.status2.disabled=false;
		}	
		//LEAD 0%
		if (d.status3){			
			d.elements.status3.disabled=false;
		}	
		//LEAD 25%
		if (d.status4){			
			d.elements.status4.disabled=false;
		}	
		//LEAD 50%
		if (d.status5){			
			d.elements.status5.disabled=false;
		}	
		//LEAD 75%
		if (d.status6){			
			d.elements.status6.disabled=false;
		}	
		//LEAD 80%
		if (d.status10){			
			d.elements.status10.disabled=false;
		}	
		//LEAD 90%
		if (d.status12){			
			d.elements.status12.disabled=false;
		}	
		//CLIENTE%
		if (d.status12){			
			d.elements.status12.disabled=false;
		}	
	}

	if (d.selecao[1].checked==true){	
		for (i = 0; i < d.elements["codlead[]"].length; i++){
			d.elements["codlead[]"][i].disabled = false;
		}
		//SEM INTERESSE
		if (d.status1){			
			d.elements.status1.disabled=true;
			d.elements.status1.value="";
		}		
		//LEAD TARGET
		if (d.status2){			
			d.elements.status2.disabled=true;
			d.elements.status2.value="";			
		}	
		//LEAD 0%
		if (d.status3){			
			d.elements.status3.disabled=true;
			d.elements.status3.value="";			
		}	
		//LEAD 25%
		if (d.status4){			
			d.elements.status4.disabled=true;
			d.elements.status4.value="";			
		}	
		//LEAD 50%
		if (d.status5){			
			d.elements.status5.disabled=true;
			d.elements.status5.value="";			
		}	
		//LEAD 75%
		if (d.status6){			
			d.elements.status6.disabled=true;
			d.elements.status6.value="";			
		}	
		//LEAD 80%
		if (d.status10){			
			d.elements.status10.disabled=true;
			d.elements.status10.value="";			
		}	
		//LEAD 90%
		if (d.status12){			
			d.elements.status12.disabled=true;
			d.elements.status12.value="";			
		}	
		//CLIENTE%
		if (d.status15){			
			d.elements.status15.disabled=true;
			d.elements.status15.value="";			
		}	
	}	
	
}

</script>
</head>

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			Tranferir Leads Atendente <?if(!empty($passo))print "Passo".$passo;?>
		</td>
	</tr>
</table>

<table width="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
<?if(empty($passo)){?>
	<!--ORIENTAÇOES PASSO 0-->
	<form name="dados" method="post">
		<input type="Hidden" name="passo" value="1" onload=(desativa(1))>
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>PASSO 1:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>									
												Deve ser definido a origem dos Leads que serão transferidos, através da dos filtros.  
											</td>	
										</tr>											
									</table>			
								</td>		
							</tr>				
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="=2">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>PASSO 2:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>									
												Deve ser indicado a quantidade de leads que serão transferidos, através de uma quantidade ou por seleção dos leads.
											</td>	
										</tr>											
									</table>			
								</td>		
							</tr>				
						</table>
					</td>
				</tr>
					<tr>
					<td colspan="=2">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>PASSO 3:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>									
												Deve ser especificado o Atendente que recebera os leads.
											</td>	
										</tr>											
									</table>			
								</td>		
							</tr>				
						</table>
					</td>
				</tr>	
				<tr>
					<td colspan="=2">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>PASSO 4:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td >									
												Conclusão da transferência de leads.
											</td>	
										</tr>											
									</table>			
								</td>		
							</tr>				
						</table>
					</td>
				</tr>		
			</table>			
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" height="100%"  >
				<tr>
					<td align="right" >
						<input type="submit" name="passo1" value="Avançar" />&nbsp;
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	</form>
<?
}
if($passo==1){
?>
	<!--PASSO 1-->
	<form name="dados1" method="post">
		<input type="Hidden" name="passo" value="2">
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>Origem da Informação:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>									
												Cod Lead:	
											</td>	
											<td>
												<input type="text" name="codleads" size="8" maxlength="8">
											</td>
										</tr>	
										<tr>
											<td>									
												Razão Social:	
											</td>	
											<td>
												<input type="text" name="razaosocial" size="80" maxlength="80">
											</td>
										</tr>	
										<tr>
											<td>									
												Tipo Pessoa:	
											</td>	
											<td>
												<select name='tipo_pessoa' >
													<option></option>
													<option value='PJ'>CNPJ</option>
													<option value='PF'>CPF</option>
												</select>
											</td>
										</tr>																														
										<tr>
											<td>									
												Polo:	
											</td>	
											<td>
												<?//COMBO DE POLO
													$polo = $_SESSION['cod_polo'];
													combo::polo($polo,'nenhum');
												?>
											</td>
										</tr>	
										<tr>
											<td>									
												Status Lead:	
											</td>	
											<td>
												<?
													$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by 1 ";
													$result = mysql_query($sql);
													while($row = mysql_fetch_array($result)){
														echo "<input type='checkbox' name='codstatusclassificacaolead[]' id='codstatusclassificacaolead[]' value='".$row['codstatusclassificacaolead']."'"; 
															echo "checked";
														echo " > "."".$row['descricao']."<br>"; 
													}
													mysql_free_result($result);
												?>
											</td>
										</tr>	
										<tr>
											<td>									
												Atendente:	
											</td>	
											<td>
												<select id="cod_atendente" name="cod_atendente">
			                                        <option value="0">Nenhum</option>
			                                        <?
														$sql = "SELECT 
																DISTINCT l.CodAtendente
																,case  when ifnull(u.cod_polo,0) = 0 then
						                         				 	u.Nome
						                        				else
						                         					concat(p.n_polo,' - ',u.Nome)  
						                        				end polo 
																,u.Desativado 
															FROM usuariosinternos u
															LEFT JOIN leads l ON u.CodUsuarioInterno = l.CodAtendente
															left join polo p on u.cod_polo = p.cod_polo
															WHERE l.CodAtendente IS NOT NULL
															ORDER BY Desativado , polo,Nome" ;
													
														$tipos[0]['valor'] = '-1';
														$tipos[1]['valor'] = 1;
														$tipos[0]['style'] = 'color:#009900';
														$tipos[1]['style'] = 'color:#990000';
														$tipos['max'] = 2;
			                                            $result = mysql_query($sql);
				                                        while($row = mysql_fetch_array($result)){
			                                                if($row["Desativado"] == 1)
			                                                    echo "<option value='".$row["CodAtendente"]."' style='color:#990000'>".$row["polo"]."</option>";
			                                                else
			                                                    echo "<option value='".$row["CodAtendente"]."' style='color:#009900'>".$row["polo"]."</option>";
			                                            }   
			                                            mysql_free_result($result);
			                                        ?>
			                                    </select>
												<img src="../../images/lampada_64x64.png" width="16" height="16" onclick="exibirAjuda()" title="Exibe o conceito da transferência de leads" style="cursor:hand">
											</td>
										</tr>	
										<tr>
											<td>									
												Consultor:	
											</td>	
											<td>
												<?	combo::consultor_equipe1($_SESSION['codusuario']);?>
											</td>
										</tr>	
										<tr>
											<td>									
												Mailing:	
											</td>	
											<td>
												<?combo::combo_mailing($mailing_pk);?>
											</td>
										</tr>
										<tr>
											<td>									
												Campanha:	
											</td>	
											<td>
												<?	
													$sql = "select cod_campanha, nome_campanha from campanha order by nome_campanha";
													combo($sql,"cod_campanha", "", " ", "");	
												?>
											</td>
										</tr>	
										<tr>
											<td>									
												Cidade:	
											</td>	
											<td>
												<?	
													$sql = "Select distinct cidade, cidade from leads l where l.cidade is not null order by cidade";
													
													combo($sql,"cidade", "", " ", "");	
												?>
											</td>
										</tr>	
                                                                                <tr>
											<td>									
												Cidade:	
											</td>	
											<td>
												<?	
													$sql = "Select distinct cidade, cidade from leads l where l.cidade is not null order by cidade";
													
													combo($sql,"cidade", "", " ", "");	
												?>
											</td>
										</tr>	
										<tr>
											<td>									
												DDD:	
											</td>	
											<td>
												<input type="Text" name="ddd" size="3" maxlength="2">
 											</td>
										</tr>	
										<!--<tr>
											<td>									
												Operadora(s):	
											</td>	
											<td>
	                                        
			                                        <?
													$sql="select op.cod_operadora, op.dsc_operadora nome from operadoras op";
													$result = mysql_query($sql);
													while($row = mysql_fetch_array($result)){
														echo "<input type='checkbox' name='cod_operadora[]' id='cod_operadora[]' value='".$row['cod_operadora']."'"; 
															
														echo " > "."".$row['nome']."&nbsp;&nbsp;"; 
													}
													mysql_free_result($result);
			                                        ?>

 											</td>
										</tr>-->
                                                                                <tr>
                                                                                    <td colspan="2">
                                                                                        <table width="100%" align="left"  height="5"  cellpadding="0" cellspacing="0" class="form">
                                                                                            <tr>
                                                                                                <td  width="200">Operadora(s):</td>
                                                                                                <td valign="middle" width="100">
                                                                                                        <?php 				
                                                                                                        $sql="Select
                                                                                                                op.cod_operadora
                                                                                                                ,op.dsc_operadora
                                                                                                                from operadoras op
                                                                                                                inner join operador o on op.dsc_operadora = o.dsc_operador
                                                                                                                INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                                                                                                                group by op.cod_operadora";

                                                                                                        combo($sql,"cod_operadora", "", " ", "onchange='sl_operadora(this.value)'");	
                                                                                                        ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <table width="100%" align="left"  height="5"  cellpadding="1" cellspacing="1" class="form">                                       
                                                                                                        <tr>
                                                                                                            <td valign="top">Cliente:</td>
                                                                                                            <td>
                                                                                                                <select name="status_cliente_pk" id="status_cliente_pk" class='formulario_select'  >   
                                                                                                                    <option value=""></option>
                                                                                                                    <option value="1" <?if($cliente_operadora_pk==1){echo "selected";}?>>Sim</option>
                                                                                                                    <option value="2" <?if($cliente_operadora_pk==2){echo "selected";}?> >Não</option>
                                                                                                                    <option value="3" <?if($cliente_operadora_pk==2){echo "selected";}?> >Não Atualizado</option>
                                                                                                                </select>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td valign="top">Base:</td>
                                                                                                            <td>
                                                                                                                <select name="status_base_pk" id="status_base_pk" class='formulario_select'   >   
                                                                                                                    <option value=""></option>
                                                                                                                    <option value="1" >Sim</option>
                                                                                                                    <option value="2"  >Não</option>
                                                                                                                    <option value="3"  >Não Atualizado</option>
                                                                                                                </select>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td valign="top">DT Ativação:</td>
                                                                                                            <td>
                                                                                                                <label for="dataini"> de </label><input disabled class="input" id="dt_ativacao_ini" name="dt_ativacao_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;
                                                                                                                <label for="datafim"> a </label><input disabled class="input" id="dt_ativacao_fim" name="dt_ativacao_fim" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" />
                                                                                                            </td>
                                                                                                        </tr>  
                                                                                                        <tr>
                                                                                                            <td valign="top">DT Venc Contrato:</td>
                                                                                                            <td>
                                                                                                                <label for="dataini"> de </label><input disabled class="input" id="dt_venc_contrato_ini" name="dt_venc_contrato_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;
                                                                                                                <label for="datafim"> a </label><input disabled class="input" id="dt_venc_contrato_fim" name="dt_venc_contrato_fim" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" />
                                                                                                            </td>
                                                                                                        </tr> 
                                                                                                        <tr>
                                                                                                            <td valign="top">Qtde de linhas voz:</td>
                                                                                                            <td>
                                                                                                                De&nbsp;<input disabled type="text" name="qtdeli_ini" id="qtdeli_ini" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>&nbsp;Até&nbsp;<input disabled type="text" name="qtdeli_fim" id="qtdeli_fim" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>
                                                                                                            </td>
                                                                                                        </tr>  
                                                                                                        <tr>
                                                                                                            <td valign="top">Qtde de linhas Dados:</td>
                                                                                                            <td>
                                                                                                                De&nbsp;<input disabled type="text" name="qtdeli_dados_ini" id="qtdeli_dados_ini" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>&nbsp;Até&nbsp;<input disabled type="text" name="qtdeli_dados_fim" id="qtdeli_dados_fim" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>
                                                                                                            </td>
                                                                                                        </tr>                         
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>                            
                                                                                        </table>    
                                                                                    </td>
                                                                                </tr>
										<tr>
											<td>
												Qtde Dias Ult. Ocorrência
											</td>		
											<td>
												<input type="text" id="qtde_dias" name="qtde_dias" size="12" maxlength="10" onKeyPress="mascara(this,soNumeros)"/>
											</td>								
										</tr>
                                                                                <!--<tr>
                                                                                        <td valign="top">Qtde Linha(s):</td>
                                                                                        <td>
                                                                                        De&nbsp;<input type="text" name="qtdeli_ini" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>&nbsp;Até&nbsp;<input type="text" name="qtdeli_fim" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/> 
                                                                                        </td>
                                                                                </tr>										                                          	
										<tr>
											<td>									
												Oportunidade(s):	
											</td>	
											<td>
												<input class="input" id="dataini" name="dataini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input class="input" id="datafim" name="datafim" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" />
 											</td>
										</tr>
                                    
										<tr>
											<td>									
												Renovações:	
											</td>	
											<td>
												<input class="input" id="dataini1" name="dataini1" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input class="input" id="datafim1" name="datafim1" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" />
 											</td>
										</tr>-->
										<tr>
											<td>									
												Motivo(s) Sem Interesse:	
											</td>	
											<td>
											    <?	
													$sql = "Select 
                                                            ms.CodMotivoLead
                                                            ,descricao
                                                            from motivoslead ms";
													combo($sql,"CodMotivoLead", "", " ", "");	
												?>
 											</td>
										</tr>                                        												
									</table>			
								</td>		
							</tr>			
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" height="100%" border1 >
				<tr>
					<td align="right" >
						<input type="button" value="Cancelar" onClick="paginainicial();">&nbsp;
						<input type="submit" name="passo1" value="Avançar"  />&nbsp; 						
					</td>
				</tr>				
			</table>
		</td>
	</tr>	
	</form>	
<?
}
if($passo==2){
	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$cod_operadora = $_REQUEST['cod_operadora'];
?>
	<!--PASSO 2-->
	<form name="frm" method="post" onload="desativa(1)">
		<input type="Hidden" name="passo" value="3">
		<input type="Hidden" name="codleads" value="<?=$_REQUEST['codleads']?>">
		<input type="Hidden" name="razaosocial" value="<?=$_REQUEST['razaosocial']?>">		
		<input type="Hidden" name="cod_polo" value="<?=$_REQUEST['cod_polo']?>">
	<?

		for($i = 0; $i<count($codstatusclassificacaolead);$i++){		
	?>
		<input type="Hidden" name="ccodstatusclassificacaolead[]" value="<?=$codstatusclassificacaolead[$i]?>">	
	<?
		}
	?>	
		<input type="Hidden" name="cod_atendente" value="<?=$_REQUEST['cod_atendente']?>">
		<input type="Hidden" name="codgerenteconta" value="<?=$_REQUEST['codgerenteconta']?>">
		<input type="Hidden" name="mailing_pk" value="<?=$_REQUEST['mailing_pk']?>">
		<input type="Hidden" name="cod_campanha" value="<?=$_REQUEST['cod_campanha']?>">
		<input type="Hidden" name="cidade" value="<?=$_REQUEST['cidade']?>">
                <input type="Hidden" name="ddd" value="<?=$_REQUEST['ddd']?>">
		<input type="Hidden" name="cep" value="<?=$_REQUEST['cep']?>">
	<?

		for($i = 0; $i<count($cod_operadora);$i++){		
	?>
		<input type="Hidden" name="cod_operadora[]" value="<?=$cod_operadora[$i]?>">	
	<?
		}
	?>	
		<input type="Hidden" name="dataini" value="<?=$_REQUEST['dataini']?>"/>		
		<input type="Hidden" name="datafim" value="<?=$_REQUEST['datafim']?>"/>		
		<input type="Hidden" name="dataini1" value="<?=$_REQUEST['dataini1']?>"/>		
		<input type="Hidden" name="datafim1" value="<?=$_REQUEST['datafim1']?>"/>	
		<input type="Hidden" name="tipo_pessoa" value="<?=$_REQUEST['tipo_pessoa']?>">	
        <input type="Hidden" name="CodMotivoLead" value="<?=$_REQUEST['CodMotivoLead']?>"/>

        
 <input type="Hidden" name="cod_operadora" value="<?=$_REQUEST['cod_operadora'];?>">
<input type="Hidden" name="status_cliente_pk" value="<?=$_REQUEST['status_cliente_pk'];?>">
<input type="Hidden" name="status_base_pk" value="<?=$_REQUEST['status_base_pk'];?>">
<input type="Hidden" name="dt_ativacao_ini" value="<?=$_REQUEST['dt_ativacao_ini'];?>">
<input type="Hidden" name="dt_ativacao_fim" value="<?=$_REQUEST['dt_ativacao_fim'];?>">
<input type="Hidden" name="dt_venc_contrato_ini" value="<?=$_REQUEST['dt_venc_contrato_ini']; ?>">
<input type="Hidden" name="dt_venc_contrato_fim" value="<?=$_REQUEST['dt_venc_contrato_fim']; ?>">
<input type="Hidden" name="qtdeli_ini" value="<?=$_REQUEST['qtdeli_ini']; ?>">
<input type="Hidden" name="qtdeli_fim" value="<<?=$_REQUEST['qtdeli_fim'];?>">
<input type="Hidden" name="qtdeli_dados_ini" value="<?=$_REQUEST['qtdeli_dados_ini'];?>">
<input type="Hidden" name="qtdeli_dados_fim" value="<?=$_REQUEST['qtdeli_dados_fim'];?>">
		
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<tr>
					<td>
						&nbsp;<input type="Radio" name="selecao" value=1 onclick="desativa(1);" checked>&nbsp;Transferência por Quantidade
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>Resultado do filtro status:</b></label></td>
								<td>
									<table class="modulo1">
										<?
											//Efetua o calculo da data de corte
											//if($_REQUEST['qtde_dias'] <> ""){
											//	$sql ="SELECT date_format(DATE_ADD(sysdate(), INTERVAL -".$_REQUEST['qtde_dias']." DAY),'%Y-%m-%d') dt_fim ";
											//}
											//else{
											//	$sql ="SELECT date_format(sysdate(),'%Y-%m-%d') dt_fim ";
											//}
											if(!empty($_REQUEST['qtde_dias'])){ 
											
												$sql ="SELECT date_format(DATE_ADD(sysdate(), INTERVAL -".$_REQUEST['qtde_dias']." DAY),'%Y-%m-%d') dt_fim ";
											
												$result = mysql_query($sql);
												$row = mysql_fetch_array($result);
												$dt_fim = $row['dt_fim'];
												mysql_free_result($result);											
												$total = 0;	
											}
											?>
												<input type="Hidden" name="dt_ult_ocorrencia" value="<?=$dt_fim;?>"/>	
											<?
											$sql = "select 
														descricao 
														,codstatusclassificacaolead
													from statusclassificacaolead
													where codstatusclassificacaolead in ( ";
											for($i = 0; $i<count($codstatusclassificacaolead);$i++){
												$sql.=$codstatusclassificacaolead[$i].", ";
												$codstatusclassificacaolead_pk.=$codstatusclassificacaolead[$i].", ";
											}
											$sql.="0) ";
											$codstatusclassificacaolead_pk.="0";
											$result = mysql_query($sql);
											
											while($row = mysql_fetch_array($result)){
												print "<tr>";
												print 	"<td>";
												print 	"<b>".$row['descricao'].":"."</b>";
												print 	"</td>";
												print   "<td>";						
														$sql = "Select	
																 count(l.codlead) qtd														
																from leads l																
																where l.codstatusclassificacaolead=".$row['codstatusclassificacaolead'];
														if(!empty($_REQUEST['codleads'])){
															$sql .= " and l.codlead=".$_REQUEST['codleads'];
														}
														if(!empty($_REQUEST['razaosocial'])){
															$sql .= " and l.razaosocial like  '%".$_REQUEST['razaosocial']."'";
														}														
														if(!empty($_REQUEST['cod_polo'])){
															$sql .= " and l.cod_polo=".$_REQUEST['cod_polo'];
														}
														if($_REQUEST['cod_atendente'] > 0){
															$sql.=" and l.codatendente = ".$_REQUEST['cod_atendente'];
														}else{														
															if($_REQUEST['cod_atendente'] == '0'){
																$sql.=" and l.codatendente is null ";
															}
														}
														if($_REQUEST['codgerenteconta']>0){
															$sql .= " and l.codgerenteconta=".$_REQUEST['codgerenteconta'];
														}else{
															if($_REQUEST['codgerenteconta'] == '0'){
																$sql.=" and l.codgerenteconta is null ";
															}
														}
														if(!empty($_REQUEST['mailing_pk'])){
															$sql .= " and l.mailing_pk=".$_REQUEST['mailing_pk'];
														}
														if(!empty($_REQUEST['cod_campanha'])){
															$sql .= " and lc.cod_campanha in (Select
																								ca.codlead as codlead
																							from leads ll
																								inner join campanha_leads ca on ll.codlead = ca.codlead
																								where ca.cod_campanha =". $_REQUEST['cod_campanha'].")";
														}
														if(!empty($_REQUEST['cidade'])){
															$sql .= " and l.cidade='".$_REQUEST['cidade']."'";
														}
                                                                                                                if(!empty($_REQUEST['ddd'])){
															$sql .= " and l.ddd='".$_REQUEST['ddd']."'";
														}
														if(!empty($_REQUEST['cep'])){
															$sql .= " and l.cep like '".$_REQUEST['cep']."%'";
														}
														if(!empty($_REQUEST['cod_operadora'])){
                                                                                                                
                                                                                                                    //SE É CLIENTE DA OPERADORA OU NÃO OU SE FOI ATUALIZADO OU NÃO
                                                                                                                    if($_REQUEST['status_cliente_pk']==1 or $_REQUEST['status_cliente_pk']==2){
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente=".$_REQUEST['status_cliente_pk']." )";
                                                                                                                    }elseif ($_REQUEST['status_cliente_pk']==3){                
                                                                                                                        $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                                                                                                                    }
                                                                                                                    //SE É DA BASE OU NÃO POR OPERADORA
                                                                                                                    if($_REQUEST['status_base_pk']==1 or $_REQUEST['status_base_pk']==2){
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente_base=".$_REQUEST['status_base_pk']." )";
                                                                                                                    }elseif ($_REQUEST['status_base_pk']==3){ 
                                                                                                                        $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                                                                                                                    }            

                                                                                                                    if(!empty($_REQUEST['dt_ativacao_ini']) and !empty($_REQUEST['dt_ativacao_fim'])){                 
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_ativacao where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_ativacao >= '".DataYMD($_REQUEST['dt_ativacao_ini'])." 00:00:00' and dt_ativacao <= '".DataYMD($_REQUEST['dt_ativacao_fim'])." 23:59:59' )";  
                                                                                                                    }
                                                                                                                    if(!empty($_REQUEST['dt_venc_contrato_ini']) and !empty($_REQUEST['dt_venc_contrato_fim'])){
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_vencimento where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_vencimento >= '".DataYMD($_REQUEST['dt_venc_contrato_ini'])." 00:00:00' and dt_vencimento <= '".DataYMD($_REQUEST['dt_venc_contrato_fim'])." 23:59:59' )";                
                                                                                                                    }

                                                                                                                    if(!empty($_REQUEST['qtdeli_ini']) && !empty($_REQUEST['qtdeli_fim'])){
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_voz where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_voz >=".$_REQUEST['qtdeli_ini']." and qtde_voz <= ".$_REQUEST['qtdeli_fim'].")";
                                                                                                                    }
                                                                                                                    if(!empty($_REQUEST['qtdeli_dados_ini']) && !empty($_REQUEST['qtdeli_dados_fim'])){
                                                                                                                        $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_dados where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_dados >=".$_REQUEST['qtdeli_dados_ini']." and qtde_dados <= ".qtdeli_dados_fim.")";
                                                                                                                    }  
														}
														/*if(!empty($_REQUEST['dataini'])){
															$sql .= " and l.VencimentoContrato >='".DataYMD($_REQUEST['dataini'])."'";
														}
														if(!empty($_REQUEST['datafim'])){
															$sql .= " and l.VencimentoContrato <='".DataYMD($_REQUEST['datafim'])."'";
														}	*/	
														if(!empty($_REQUEST['tipo_pessoa'])){
															$sql .= " and l.tipo_pessoa ='".$_REQUEST['tipo_pessoa']."'";
														}														
														
														
														if(!empty($_REQUEST['dataini1'])){
                                                                                                                    $sql .=" and l.codlead in (Select
                                                                                                                    p.codlead
                                                                                                                    from propostas p
                                                                                                                    where p.DataCancelamento is null";
                                                                                                                    $sql .= " and p.dt_vencimentocontrato >='".DataYMD($_REQUEST['dataini1'])."'";
                                                                                                                    $sql .= " and p.dt_vencimentocontrato <='".DataYMD($_REQUEST['datafim1'])."')";
														}
														if(!empty($_REQUEST['CodMotivoLead'])){
                                                                                                                     $sql .=" and l.CodMotivo=".$_REQUEST['CodMotivoLead'];
														}
                                                                                                                if(!empty($_REQUEST['qtdeli_ini']) && !empty($_REQUEST['qtdeli_fim'])){
                                                                                                                    $sql.=" and l.qtde_linhas >=".$_REQUEST['qtdeli_ini'];
                                                                                                                    $sql.=" and l.qtde_linhas <= ".$_REQUEST['qtdeli_fim'];
                                                                                                                }
														if(!empty($dt_fim)){	
                                                                                                                    $sql.="  and l.dt_ult_ocorrencia <= '".$dt_fim." 23:59:59' ";
														}
																									    
														$result1 = mysql_query($sql);	
														while($row1 = mysql_fetch_array($result1)){
															$disable = "";
															if($row1['qtd'] == 0){
																$disable = "disabled";
															}
															print "&nbsp;Total=&nbsp;<b>".$row1['qtd']."</b>&nbsp;&nbsp;";
															print "&nbsp;&nbsp;<input type=Text ".$disable."   name=status".$row['codstatusclassificacaolead']." size=8 maxlength=8>";												
															
														}
												print 	"</td>";
												print "</tr>";
											}
										?>
									</table>			
								</td>		
							</tr>			
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<tr>
					<td>
						&nbsp;<input type="Radio" name="selecao" value=2 onclick="desativa(2);" >&nbsp;Transferência por Seleção
					</td>
				</tr>
				<tr>
					<td >
						<div class="tabela">
							<table class="borda_tabela"   width="100%" align="center"   id="dados" border="0" cellpadding="0"  cellspacing="0" >
								<tr class="font_grid">
									<td align="center">#</td>
									<td align="center" >
										<b>Razao Social</b>
									</td>
									<td align="center">
										<b>Polo</b>
									</td>		
									<td align="center">
										<b>Status</b>
									</td>				
									<td align="center">
										<b>Consultor</b>
									</td>		
									<td align="center">
										<b>Atendente</b>
									</td>				
									<td align="center">
										<b>Mailing</b>
									</td>	
									<td align="center">
										<b>Cidade</b>
									</td>	
                                                                        <td align="center">
										<b>DDD</b>
									</td>	
									<td align="center">
										<b>Bairro</b>
									</td>			
									<td align="center">
										<b>Vencimento Contrato</b>
									</td>			
								</tr>						
								<?
								$sql = "Select	
											l.codlead
											,l.razaosocial
											,p.n_polo
											,sc.descricao
											,ui.nome as Atendente
											,ui1.nome as ngerenteconta
											,m.dsc_mailing mailing										
											,l.cidade
											,l.Bairro
											,date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato
										from leads l
											left join leads_operadoras lo on l.codlead = lo.codlead
											left join polo p on l.cod_polo = p.cod_polo
											inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.codstatusclassificacaolead
											left join usuariosinternos ui on l.codatendente = ui.codusuariointerno
											left join usuariosinternos ui1 on l.codgerenteconta = ui1.codusuariointerno
											left join mailing m on l.mailing_pk = pk
										where l.codstatusclassificacaolead in ( ";	
										for($i = 0; $i<count($codstatusclassificacaolead);$i++){
											$sql.=$codstatusclassificacaolead[$i].", ";
											$codstatusclassificacaolead_pk.=$codstatusclassificacaolead[$i].", ";
										}
										$sql.="0) ";
										$codstatusclassificacaolead_pk.="0";
                                                                    if(!empty($_REQUEST['codleads'])){
                                                                            $sql .= " and l.codlead=".$_REQUEST['codleads'];
                                                                    }
                                                                    if(!empty($_REQUEST['razaosocial'])){
                                                                            $sql .= " and l.razaosocial like  '%".$_REQUEST['razaosocial']."'";
                                                                    }														
                                                                    if(!empty($_REQUEST['cod_polo'])){
                                                                            $sql .= " and l.cod_polo=".$_REQUEST['cod_polo'];
                                                                    }
                                                                    if($_REQUEST['cod_atendente'] > 0){
                                                                            $sql.=" and l.codatendente = ".$_REQUEST['cod_atendente'];
                                                                    }else{														
                                                                            if($_REQUEST['cod_atendente'] == '0'){
                                                                                    $sql.=" and l.codatendente is null ";
                                                                            }
                                                                    }
                                                                    if($_REQUEST['codgerenteconta']>0){
                                                                            $sql .= " and l.codgerenteconta=".$_REQUEST['codgerenteconta'];
                                                                    }else{
                                                                            if($_REQUEST['codgerenteconta'] == '0'){
                                                                                    $sql.=" and l.codgerenteconta is null ";
                                                                            }
                                                                    }
                                                                    if(!empty($_REQUEST['mailing_pk'])){
                                                                            $sql .= " and l.mailing_pk=".$_REQUEST['mailing_pk'];
                                                                    }
                                                                    if(!empty($_REQUEST['cod_campanha'])){
                                                                            $sql .= " and lc.cod_campanha in (Select
                                                                                                                                                    ca.codlead as codlead
                                                                                                                                            from leads ll
                                                                                                                                                    inner join campanha_leads ca on ll.codlead = ca.codlead
                                                                                                                                                    where ca.cod_campanha =". $_REQUEST['cod_campanha'].")";
                                                                    }
                                                                    if(!empty($_REQUEST['cidade'])){
                                                                            $sql .= " and l.cidade='".$_REQUEST['cidade']."'";
                                                                    }
                                                                    if(!empty($_REQUEST['ddd'])){
                                                                            $sql .= " and l.ddd='".$_REQUEST['ddd']."'";
                                                                    }
                                                                    if(!empty($_REQUEST['cep'])){
                                                                            $sql .= " and l.cep like '".$_REQUEST['cep']."%'";
                                                                    }
                                                                    if(!empty($_REQUEST['cod_operadora'])){

                                                                        //SE É CLIENTE DA OPERADORA OU NÃO OU SE FOI ATUALIZADO OU NÃO
                                                                        if($_REQUEST['status_cliente_pk']==1 or $_REQUEST['status_cliente_pk']==2){
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente=".$_REQUEST['status_cliente_pk']." )";
                                                                        }elseif ($_REQUEST['status_cliente_pk']==3){                
                                                                            $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                                                                        }
                                                                        //SE É DA BASE OU NÃO POR OPERADORA
                                                                        if($_REQUEST['status_base_pk']==1 or $_REQUEST['status_base_pk']==2){
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente_base=".$_REQUEST['status_base_pk']." )";
                                                                        }elseif ($_REQUEST['status_base_pk']==3){ 
                                                                            $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                                                                        }            

                                                                        if(!empty($_REQUEST['dt_ativacao_ini']) and !empty($_REQUEST['dt_ativacao_fim'])){                 
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_ativacao where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_ativacao >= '".DataYMD($_REQUEST['dt_ativacao_ini'])." 00:00:00' and dt_ativacao <= '".DataYMD($_REQUEST['dt_ativacao_fim'])." 23:59:59' )";  
                                                                        }
                                                                        if(!empty($_REQUEST['dt_venc_contrato_ini']) and !empty($_REQUEST['dt_venc_contrato_fim'])){
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_vencimento where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_vencimento >= '".DataYMD($_REQUEST['dt_venc_contrato_ini'])." 00:00:00' and dt_vencimento <= '".DataYMD($_REQUEST['dt_venc_contrato_fim'])." 23:59:59' )";                
                                                                        }

                                                                        if(!empty($_REQUEST['qtdeli_ini']) && !empty($_REQUEST['qtdeli_fim'])){
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_voz where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_voz >=".$_REQUEST['qtdeli_ini']." and qtde_voz <= ".$_REQUEST['qtdeli_fim'].")";
                                                                        }
                                                                        if(!empty($_REQUEST['qtdeli_dados_ini']) && !empty($_REQUEST['qtdeli_dados_fim'])){
                                                                            $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_dados where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_dados >=".$_REQUEST['qtdeli_dados_ini']." and qtde_dados <= ".qtdeli_dados_fim.")";
                                                                        }  
                                                                    }
                                                                    /*if(!empty($_REQUEST['dataini'])){
                                                                            $sql .= " and l.VencimentoContrato >='".DataYMD($_REQUEST['dataini'])."'";
                                                                    }
                                                                    if(!empty($_REQUEST['datafim'])){
                                                                            $sql .= " and l.VencimentoContrato <='".DataYMD($_REQUEST['datafim'])."'";
                                                                    }	*/	
                                                                    if(!empty($_REQUEST['tipo_pessoa'])){
                                                                            $sql .= " and l.tipo_pessoa ='".$_REQUEST['tipo_pessoa']."'";
                                                                    }														


                                                                    if(!empty($_REQUEST['dataini1'])){
                                                                        $sql .=" and l.codlead in (Select
                                                                        p.codlead
                                                                        from propostas p
                                                                        where p.DataCancelamento is null";
                                                                        $sql .= " and p.dt_vencimentocontrato >='".DataYMD($_REQUEST['dataini1'])."'";
                                                                        $sql .= " and p.dt_vencimentocontrato <='".DataYMD($_REQUEST['datafim1'])."')";
                                                                    }
                                                                    if(!empty($_REQUEST['CodMotivoLead'])){
                                                                         $sql .=" and l.CodMotivo=".$_REQUEST['CodMotivoLead'];
                                                                    }
                                                                    if(!empty($_REQUEST['qtdeli_ini']) && !empty($_REQUEST['qtdeli_fim'])){
                                                                        $sql.=" and l.qtde_linhas >=".$_REQUEST['qtdeli_ini'];
                                                                        $sql.=" and l.qtde_linhas <= ".$_REQUEST['qtdeli_fim'];
                                                                    }
                                                                    if(!empty($dt_fim)){	
                                                                        $sql.="  and l.dt_ult_ocorrencia <= '".$dt_fim." 23:59:59' ";
                                                                    }
								                     
								$sql .= " group by l.codlead
										  Order by sc.codstatusclassificacaolead
										  limit 100";
                                                                
								$result2 = mysql_query($sql);	
								$desativa = "disabled";
								$total = 0;
								while($row2 = mysql_fetch_array($result2)){
								$total ++;
								if($cor=="#dfdfdf"){
									$cor = "#ffffff";
								}
								else{
									$cor = "#dfdfdf";
								}	
								?>					
								<tr class="link_cinza" bgcolor="<?=$cor?>" >
									<td align="center"><input type="Checkbox" name="codlead[]" id"codlead[]" value="<?=$row2['codlead'];?>" <?=$desativa;?> ></td>
									<td align="center">
										<?=$row2['razaosocial'];?>
									</td>
									<td align="center">
										<?=$row2['n_polo'];?>
									</td>		
									<td align="center">
									<b><?=$row2['descricao'];?></b>
									</td>	
									<td align="center">
										<?=$row2['ngerenteconta'];?>
									</td>				
									<td align="center">
										<?=$row2['Atendente'];?>
									</td>		
									<td align="center">
										<?=$row2['mailing'];?>
									</td>	
									<td align="center">
										<?=$row2['Cidade'];?>
									</td>
                                                                        <td align="center">
										<?=$row2['ddd'];?>
									</td>	
									<td align="center">
										<?=$row2['Bairro'];?>
									</td>			
									<td align="center">
										<?=$row2['vencimentocontrato'];?>
									</td>			
								</tr>	
			
								<?
								}
								?>
							</table>
						</div>
					</td>
				</tr>	
				<tr>
					<td align="center">
						Total de Leads = <?=$total;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
		<tr>
		<td>
			<table width="100%" height="100%" border1 >
				<tr>
					<td align="right" >
						<input type="button" value="Cancelar" onClick="paginainicial();">&nbsp;
						<input type="submit" name="passo1" value="Avançar" />&nbsp;
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	</form>	
<?
}
if($passo==3){
?>
	<!--PASSO 3-->
	<form name="atendente"  method="post"  onsubmit="return valida(this);">
	<input type="Hidden" name="passo" value="4">
	<input type="Hidden" name="codleads" value="<?=$_REQUEST['codleads']?>">
	<input type="Hidden" name="razaosocial" value="<?=$_REQUEST['razaosocial']?>">			
	<input type="Hidden" name="cod_polo" value="<?=$_REQUEST['cod_polo']?>">
	<?

		for($i = 0; $i<count($codstatusclassificacaolead);$i++){		
	?>
		<input type="Hidden" name="ccodstatusclassificacaolead[]" value="<?=$codstatusclassificacaolead[$i]?>">	
	<?
		}
	?>	
	<input type="Hidden" name="cod_atendente" value="<?=$_REQUEST['cod_atendente']?>">
	<input type="Hidden" name="codgerenteconta" value="<?=$_REQUEST['codgerenteconta']?>">
	<input type="Hidden" name="mailing_pk" value="<?=$_REQUEST['mailing_pk']?>">
	<input type="Hidden" name="cod_campanha" value="<?=$_REQUEST['cod_campanha']?>">
	<input type="Hidden" name="cidade" value="<?=$_REQUEST['cidade']?>">
        <input type="Hidden" name="ddd" value="<?=$_REQUEST['ddd']?>">
	<input type="Hidden" name="cep" value="<?=$_REQUEST['cep']?>">
	<?

		for($i = 0; $i<count($cod_operadora);$i++){		
	?>
		<input type="Hidden" name="cod_operadora[]" value="<?=$cod_operadora[$i]?>">	
	<?
		}
	?>	
	<input type="Hidden" name="dataini" value="<?=$_REQUEST['dataini']?>">		
	<input type="Hidden" name="datafim" value="<?=$_REQUEST['datafim']?>">		
	<input type="Hidden" name="dataini1" value="<?=$_REQUEST['dataini1']?>">		
	<input type="Hidden" name="datafim1" value="<?=$_REQUEST['datafim1']?>">			
	<input type="Hidden" name="status1" value="<?=$_REQUEST['status1']?>">	
	<input type="Hidden" name="status2" value="<?=$_REQUEST['status2']?>">		
	<input type="Hidden" name="status3" value="<?=$_REQUEST['status3']?>">		
	<input type="Hidden" name="status4" value="<?=$_REQUEST['status4']?>">		
	<input type="Hidden" name="status5" value="<?=$_REQUEST['status5']?>">		
	<input type="Hidden" name="status6" value="<?=$_REQUEST['status6']?>">		
	<input type="Hidden" name="status10" value="<?=$_REQUEST['status10']?>">		
	<input type="Hidden" name="status12" value="<?=$_REQUEST['status12']?>">	
	<input type="Hidden" name="status15" value="<?=$_REQUEST['status15']?>">	
	<input type="Hidden" name="tipo_pessoa" value="<?=$_REQUEST['tipo_pessoa']?>">
        <input type="Hidden" name="CodMotivoLead" value="<?=$_REQUEST['CodMotivoLead']?>"/>
        <input type="Hidden" name="cod_operadora" value="<?=$_REQUEST['cod_operadora'];?>">
        <input type="Hidden" name="status_cliente_pk" value="<?=$_REQUEST['status_cliente_pk'];?>">
        <input type="Hidden" name="status_base_pk" value="<?=$_REQUEST['status_base_pk'];?>">
        <input type="Hidden" name="dt_ativacao_ini" value="<?=$_REQUEST['dt_ativacao_ini'];?>">
        <input type="Hidden" name="dt_ativacao_fim" value="<?=$_REQUEST['dt_ativacao_fim'];?>">
        <input type="Hidden" name="dt_venc_contrato_ini" value="<?=$_REQUEST['dt_venc_contrato_ini']; ?>">
        <input type="Hidden" name="dt_venc_contrato_fim" value="<?=$_REQUEST['dt_venc_contrato_fim']; ?>">
        <input type="Hidden" name="qtdeli_ini" value="<?=$_REQUEST['qtdeli_ini']; ?>">
        <input type="Hidden" name="qtdeli_fim" value="<<?=$_REQUEST['qtdeli_fim'];?>">
        <input type="Hidden" name="qtdeli_dados_ini" value="<?=$_REQUEST['qtdeli_dados_ini'];?>">
        <input type="Hidden" name="qtdeli_dados_fim" value="<?=$_REQUEST['qtdeli_dados_fim'];?>">
        <input type="Hidden" name="dt_ult_ocorrencia" value="<?=$_REQUEST['dt_ult_ocorrencia']?>"/>
	<?
		$codlead =  $_REQUEST['codlead'];		
		for($i = 0; $i<count($codlead);$i++){		
	?>
		<input type="Hidden" name="codlead[]" value="<?=$codlead[$i]?>">	
	<?
		}
	?>	
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>Destino do(s) Lead(s):</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>
												Atendente:
											</td>
											<td>
												<?			
													$sql2 = "SELECT u.CodUsuarioInterno
																,case  when ifnull(u.cod_polo,0) = 0 then
					                         					 	u.Nome
					                        					else
					                         						concat(p.n_polo,' - ',u.Nome)  
					                        					end polo
																,u.Desativado
														    FROM usuariosinternos u
														    	left join polo p on u.cod_polo = p.cod_polo
													 	  	WHERE u.atendente = 1
														  	ORDER BY u.Desativado ,polo , u.Nome " ;
															
															$tipos[0]['valor'] = '-1';
															$tipos[1]['valor'] = 1;
															$tipos[0]['style'] = 'color:#009900';
															$tipos[1]['style'] = 'color:#990000';
															$tipos['max'] = 2;										
													combo_tipos( $sql2 , "codatendentepara" , $tipos , "" , " " , "" ) ;
												?>
											</td>
										</tr>
									</table>			
								</td>		
							</tr>			
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" height="100%" border1 >
				<tr>
					<td align="right" >
						<input type="button" value="Cancelar" onClick="paginainicial();">&nbsp;
						<input type="submit" name="passo4" value="Avançar" />&nbsp;
					</td>
				</tr>				
			</table>
		</td>
	</tr>
	</form>		
<?
}
if($passo==4){	


	$vcodlead=$_REQUEST['codleads'];
	$vrazaosocial=$_REQUEST['razaosocial'];
	$vcod_polo=$_REQUEST['cod_polo'];
	$vcodstatusclassificacaolead=$_REQUEST['codstatusclassificacaolead'];
	$vcod_atendente=$_REQUEST['cod_atendente'];
	$vcodgerenteconta=$_REQUEST['codgerenteconta'];
	$vmailing_pk=$_REQUEST['mailing_pk'];
	$vcod_campanha=$_REQUEST['cod_campanha'];
	$vcidade=$_REQUEST['cidade'];
        $vddd=$_REQUEST['ddd'];
	$vcep=$_REQUEST['cep'];
	$vcod_operadora=$_REQUEST['cod_operadora'];
	$vdataini=$_REQUEST['dataini'];
	$vdatafim=$_REQUEST['datafim'];
	$vdataini1=$_REQUEST['dataini1'];
	$vdatafim1=$_REQUEST['datafim1'];	
	$tipo_pessoa=$_REQUEST['tipo_pessoa'];
        $codmotivolead = $_REQUEST['CodMotivoLead'];
        $vstatus_cliente_pk = $_REQUEST['cod_operadora'];
        $vstatus_cliente_pk = $_REQUEST['status_cliente_pk'];
        $vstatus_base_pk = $_REQUEST['status_base_pk'];
        $vdt_ativacao_ini = $_REQUEST['dt_ativacao_ini'];
        $vdt_ativacao_fim = $_REQUEST['dt_ativacao_fim'];
        $vdt_venc_contrato_ini = $_REQUEST['dt_venc_contrato_ini']; 
        $vdt_venc_contrato_fim = $_REQUEST['dt_venc_contrato_fim']; 
        $vqtdeli_ini = $_REQUEST['qtdeli_ini']; 
        $vqtdeli_fim = $_REQUEST['qtdeli_fim'];
        $vqtdeli_dados_ini = $_REQUEST['qtdeli_dados_ini'];
        $vqtdeli_dados_fim = $_REQUEST['qtdeli_dados_fim'];
        $vdt_ult_ocorrencia = $_REQUEST['dt_ult_ocorrencia'];

	$total_transferido = "";
	$selecao = $_REQUEST['selecao'];

	$codoperador = $_REQUEST['codatendentepara'];
	$codlead = $_REQUEST['codlead'];
	//DADOS USUARIO

	$fields['codatendente'] = $codoperador ;
	$fields1['CodUsuarioInterno'] = $codoperador;
	$fields2['AgendadoPara'] = $codoperador;
	$fields2['CodUsuarioInterno'] = $codoperador;

	$sql = "Select 
				ui.nome
				,ui.cod_polo
			from usuariosinternos ui 
			where codusuariointerno=".$_REQUEST['codatendentepara'];

  	$rs = sql_query($sql);
    $row = mysql_fetch_array($rs);
    $Para = $row['nome'];
	if(!empty($row['cod_polo'])){
		$Atendente_polo['cod_polo'] = $row['cod_polo'];
	}else{
		$Atendente_polo['cod_polo'] = "0";
	}
    mysql_free_result($rs);	
//if($selecao==2){
	//UPDATE PODE SELECAO
	
	for($i = 0; $i<count($codlead);$i++){	
		$total_transferido ++;

		//IDENTIFICA O ATENDENTE DO LEAD
		$sql = "Select
				ui.nome 
			from leads l
			inner join usuariosinternos ui on l.codatendente = ui.codusuariointerno
			where l.codlead =".$codlead[$i];
			$sql.="  and l.dt_ult_ocorrencia <= '".$dt_ult_ocorrencia." 23:59:59' ";
		$result = sql_query($sql);
		if($De = mysql_fetch_array($result)){
			array_merge($De, $_REQUEST);
			$_REQUEST = $De;
		}	

		//UPDATE ATENDENTE LEAD
		$sql = sqlupdate('leads', $fields, ' CodLead = ' . mysqlnull($codlead[$i]));
		sql_query($sql);

		//UPDATE POLO LEAD PARA O DO ATENDENTE
		$sql = sqlupdate('leads', $Atendente_polo, ' CodLead = ' . mysqlnull($codlead[$i]).' and cod_polo=0');
		sql_query($sql);		

		//VERIFICA AS OCORRENCIAS DO QUE SAO DE ATENDENTE
		$sql = "Select   
				  oc.CodOcorrenciaLead
				  ,oc.dt_retorno
				  ,oc.dt_retorno_fechamento
				  ,oc.codusuariointerno
				from ocorrenciaslead oc
				  inner join usuariosinternos ui on oc.CodUsuarioInterno = ui.CodUsuarioInterno
				where oc.CodLead=".$codlead[$i];
				$sql .= " and ui.Atendente=1
				and oc.DataFechamento is null";
				
		$result3 = mysql_query($sql);
		while($rss1 = mysql_fetch_array($result3)){					
			//UPDATE USUARIO DAS OCORRENCIAS
			$sql = sqlupdate('ocorrenciaslead', $fields1, ' CodOcorrenciaLead = ' . mysqlnull($rss1['CodOcorrenciaLead']));			
			sql_query($sql);
			
			if(!empty($rss1['dt_retorno'])){
				if(empty($rss1['dt_retorno_fechamento'])){
					$fielduser['agendadopara']=$codoperador;
					$sql = sqlupdate('ocorrenciaslead', $fielduser, ' CodOcorrenciaLead = ' . mysqlnull($rss1['CodOcorrenciaLead']), 'and agendadopara=' .$rss1['codusuariointerno'] );
					sql_query($sql);
				}
			}	
		}		
		
		//INCLUI A OCORRENCIA
		if(!empty($De['nome'])){
			$descricaoreagendamento = "Transferência de Lead Atendente=".$De['nome']." para o Atendente=".$Para ;
		}else{
			$descricaoreagendamento = "Transferência de Lead para Atendente=".$Para ;
		}
		$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $codlead[$i],'CodUsuarioInterno' =>  $_SESSION['codusuario'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  77,'descricao' => $descricaoreagendamento));
		sql_query($sql);		
	}
//}else{
	//UPDATE POR QUANTIDADE
	$status[1] = $_REQUEST['status1'];
	$status[2]   = $_REQUEST['status2'];
	$status[3]   = $_REQUEST['status3'];
	$status[4]   = $_REQUEST['status4'];
	$status[5]   = $_REQUEST['status5'];
	$status[6]   = $_REQUEST['status6'];
	$status[10]   = $_REQUEST['status10'];
	$status[12]   = $_REQUEST['status12'];
	$status[15]   = $_REQUEST['status15'];	
	
	foreach($status as $stat => $qtd){
		if($qtd > 0){	
			$total_transferido = $total_transferido + $qtd;
			$sql = "Select	
					l.codlead												
				from leads l
				where l.codstatusclassificacaolead=".$stat;	
			if(!empty($vcodlead)){
				$sql .= " and l.codlead=".$vcodlead;
			}
			if(!empty($vrazaosocial)){
				$sql .= " and l.razaosocial like  '%".$vrazaosocial."'";
			}	
			if(!empty($vcod_polo)){
				$sql .= " and l.cod_polo=".$vcod_polo;
			}
			if(!empty($vcodstatusclassificacaolead)){
				$sql .= " and l.codstatusclassificacaolead=".$vcodstatusclassificacaolead;
			}
			if(!empty($tipo_pessoa)){
				$sql .= " and l.tipo_pessoa ='".$tipo_pessoa."'";
			}					
			if($vcod_atendente > 0){
				$sql.=" and l.codatendente = ".$vcod_atendente;
			}else{														
				if($vcod_atendente == '0'){
					$sql.=" and l.codatendente is null ";
				}
			}
			if($vcodgerenteconta > 0){
				$sql .= " and l.codgerenteconta=".$vcodgerenteconta;
			}else{
				if($vcodgerenteconta == '0'){
					$sql.=" and l.codgerenteconta is null ";
				}
			}
			if(!empty($vmailing_pk)){
				$sql .= " and l.mailing_pk=".$vmailing_pk;
			}
			if(!empty($vcod_campanha)){
				$sql .= " and l.codlead in (Select
					c.codlead as codlead
					from  campanha_leads c 
					where c.cod_campanha = ".$_REQUEST['cod_campanha'];
			}
			if(!empty($vcidade)){
				$sql .= " and l.cidade='".$vcidade."'";
			}
                        if(!empty($vddd)){
				$sql .= " and l.ddd='".$vddd."'";
			}
			if(!empty($vcep)){
				$sql .= " and l.cep like '".$vcep."%'";
			}
			if(!empty($vcod_operadora)){
                                                                                                      
                            //SE É CLIENTE DA OPERADORA OU NÃO OU SE FOI ATUALIZADO OU NÃO
                            if($_REQUEST['status_cliente_pk']==1 or $_REQUEST['status_cliente_pk']==2){
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente=".$_REQUEST['status_cliente_pk']." )";
                            }elseif ($_REQUEST['status_cliente_pk']==3){                
                                $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                            }
                            //SE É DA BASE OU NÃO POR OPERADORA
                            if($_REQUEST['status_base_pk']==1 or $_REQUEST['status_base_pk']==2){
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora']." and lead_cliente_base=".$_REQUEST['status_base_pk']." )";
                            }elseif ($_REQUEST['status_base_pk']==3){ 
                                $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$_REQUEST['cod_operadora'].")";
                            }            

                            if(!empty($_REQUEST['dt_ativacao_ini']) and !empty($_REQUEST['dt_ativacao_fim'])){                 
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_ativacao where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_ativacao >= '".DataYMD($_REQUEST['dt_ativacao_ini'])." 00:00:00' and dt_ativacao <= '".DataYMD($_REQUEST['dt_ativacao_fim'])." 23:59:59' )";  
                            }
                            if(!empty($_REQUEST['dt_venc_contrato_ini']) and !empty($_REQUEST['dt_venc_contrato_fim'])){
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_vencimento where operadora_pk = ".$_REQUEST['cod_operadora']." and dt_vencimento >= '".DataYMD($_REQUEST['dt_venc_contrato_ini'])." 00:00:00' and dt_vencimento <= '".DataYMD($_REQUEST['dt_venc_contrato_fim'])." 23:59:59' )";                
                            }

                            if(!empty($_REQUEST['qtdeli_ini']) && !empty($_REQUEST['qtdeli_fim'])){
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_voz where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_voz >=".$_REQUEST['qtdeli_ini']." and qtde_voz <= ".$_REQUEST['qtdeli_fim'].")";
                            }
                            if(!empty($_REQUEST['qtdeli_dados_ini']) && !empty($_REQUEST['qtdeli_dados_fim'])){
                                $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_dados where operadora_pk = ".$_REQUEST['cod_operadora']." and qtde_dados >=".$_REQUEST['qtdeli_dados_ini']." and qtde_dados <= ".qtdeli_dados_fim.")";
                            }                        
			}
			if(!empty($vdataini)){
				$sql .= " and l.VencimentoContrato >='".DataYMD($vdataini)."'";
			}
			if(!empty($vdatafim)){
				$sql .= " and l.VencimentoContrato <='".DataYMD($vdatafim)."'";
			}
			if(!empty($vdataini1)){
				$sql .=" and l.codlead in (Select
										p.codlead
										from propostas p
										where p.DataCancelamento is null";
										$sql .= " and p.dt_vencimentocontrato >='".DataYMD($vdataini1)."'";
										$sql .= " and p.dt_vencimentocontrato <='".DataYMD($vdatafim1)."')";
			}
            if(!empty($codmotivolead)){
                $sql .=" and l.CodMotivo=".$_REQUEST['CodMotivoLead'];
            }
            if(!empty($qtdeli_ini) && !empty($qtdeli_fim)){
            		$sql.=" and l.qtde_linhas >=".$qtdeli_ini;
            		$sql.=" and l.qtde_linhas <= ".$qtdeli_fim;
            } 
            if(!empty($dt_ult_ocorrencia)){
				$sql.="  and l.dt_ult_ocorrencia <= '".$dt_ult_ocorrencia." 23:59:59' ";
			}
			$sql .= " group by l.CodLead";
			$sql .= "  limit ".$qtd;	
		                  
			$result1 = mysql_query($sql);	
			while($row = mysql_fetch_array($result1)){

				//IDENTIFICA O ATENDENTE DO LEAD
				$sql = "Select
						ui.nome 
					from leads l
					inner join usuariosinternos ui on l.codatendente = ui.codusuariointerno
					where l.codlead =".$row['codlead'];
				$result = sql_query($sql);
				
				if($De = mysql_fetch_array($result)){
					array_merge($De, $_REQUEST);
					$_REQUEST = $De;
				}	
					
				//UPDATE ATENDENTE LEAD
				
				$sqll = sqlupdate('leads', $fields, ' CodLead = ' . $row['codlead']);				
			
                sql_query($sqll);
				
				//UPDATE POLO LEAD PARA O DO ATENDENTE				
				$sql = sqlupdate('leads', $Atendente_polo, ' CodLead = ' . mysqlnull($row['codlead']).' and cod_polo=0');
				sql_query($sql);				
				//VERIFICA AS OCORRENCIAS DO QUE SAO DE ATENDENTE
				$sql = "Select   
						  oc.CodOcorrenciaLead
						  ,oc.dt_retorno
						  ,oc.dt_retorno_fechamento
						  ,oc.codusuariointerno
						from ocorrenciaslead oc
						  inner join usuariosinternos ui on oc.CodUsuarioInterno = ui.CodUsuarioInterno
						where oc.CodLead=".$row['codlead']; 
						$sql .= " and ui.Atendente=1
						and oc.DataFechamento is null";
				$result3 = mysql_query($sql);
				while($rss1 = mysql_fetch_array($result3)){					
					//UPDATE USUARIO DAS OCORRENCIAS

					$sql = sqlupdate('ocorrenciaslead', $fields1, ' CodOcorrenciaLead = ' . mysqlnull($rss1['CodOcorrenciaLead']));
					
					sql_query($sql);					

						if(!empty($rss1['dt_retorno'])){
							if(empty($rss1['dt_retorno_fechamento'])){
								$fielduser['agendadopara']=$codoperador;
								$sql = "update ocorrenciaslead set agendadopara=".$codoperador." where CodOcorrenciaLead=".$rss1['CodOcorrenciaLead']." and agendadopara=".$rss1['codusuariointerno'];
								//$sql = sqlupdate('ocorrenciaslead', $fielduser, 'agendadopara=' .$rss1['codusuariointerno'], ' CodOcorrenciaLead = ' . mysqlnull($rss1['CodOcorrenciaLead']));
								sql_query($sql);
							}
						}					
				}	
				//INCLUI A OCORRENCIA
				if(!empty($De['nome'])){
					$descricaoreagendamento = "Transferência de Lead Atendente=".$De['nome']." para o Atendente=".$Para ;
				}else{
					$descricaoreagendamento = "Transferência de Lead para Atendente=".$Para ;
				}
				$sql = sqlinsert('ocorrenciaslead', array('codlead' =>  $row['codlead'],'CodUsuarioInterno' =>  $_SESSION['codusuario'] ,'DataCadastro' => "SYSDATE()",'DataFechamento' => "SYSDATE()",'codtipoocorrencialead' =>  77,'descricao' => $descricaoreagendamento));
				sql_query($sql);
			}         
          
		}	
        
}

?>
	<!--PASSO 4-->
	<form name="dados2" method="post"  onsubmit="return valida(this);">
	<input type="Hidden" name="passo" value="4">
	
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="250" valign="middle"> &nbsp;<label for="origem"><b>Resultado da Trasferencia Leads:</b></label></td>
								<td>
									<table class="modulo1">
										<tr>
											<td>
												Transferencia Executada com sucesso&nbsp;<b>Total de Leads Transferidos <?=$total_transferido;?></b>
											</td>
											<td>
											</td>
										</tr>
									</table>			
								</td>		
							</tr>			
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</form>		
<?}?>
</table>
</html>

	
