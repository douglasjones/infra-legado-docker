<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	include_once "../../libs/cla.combo.php";
	include_once( "../../libs/cla.comboajax.php" ) ;
	
	$Atendente = $_SESSION['codusuario'];

	if(!permissao('leads', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	
	$selects = new ComboAjax( $_SESSION['codusuario'] ) ;
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type: text/html; charset=ISO-8859-1" />
	<title>Pesquisar Leads</title>
	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <script type="text/javascript" language="JavaScript" src="leads.js"></script>    
<?	include_once "../../libs/head.php";?>

	<!--Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" language="javascript">
			
	//Função de Caixa de Sugestoes Leads
	function lookup(inputString)
	{
		
		inputString = remover_charespecial(inputString);
		
		if(inputString.length < 3) J('#suggestions').hide();
		else {
			J.post("../../libs/leads_sugestao.php", {queryString: ""+inputString+"", retorno: "sim"}, function(data){
				if(data.length >0) {
					J('#suggestions').show();
					J('#autoSuggestionsList').html(data);
				}
				else J('#suggestions').hide();				
			});
		}
	}
	
	function fill(thisValue) {
		J('#razaosocial').val(thisValue);
		setTimeout("J('#suggestions').hide();", 200);
	}		
			
		function enviar(){
			document.forms[0].submit();
			self.close();
		}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="get" target="pagina" action="leadres.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			&nbsp;Pesquisar Lead
		</td>
	</tr>
</table>
<? $selects->getCarregando() ; ?>
<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="2" class="form">
	<tbody>
		<tr>
		<td width="200">
			<label  for="cod_polo_dis">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'nenhum');
			?>
		</td>
	</tr>
		<tr>
			<td width="200"><label for="razaosocial">Razão Social:</label></td>
			<td>
				<input  class="input" id="razaosocial" name="razaosocial" size="50" onKeyUp="lookup(this.value);" onBlur="fill();"/><br />
				<!-- SUGESTOES -->
				<div class="caixa_sugestao" id="suggestions" style="display: none; width:263px;">
					<div class="lista_sugestao" id="autoSuggestionsList">
						&nbsp;
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td width="200"><label for="nomefantasia">Nome Fantasia:</label></td>
			<td>
				<input  class="input" id="nomefantasia" name="nomefantasia" size="50" />
			</td>
		</tr>
		<tr>
			<td width="200"><label for="cnpj">CNPJ/CPF:</label></td>
			<td>
				<input class="input" id="cnpj" name="cnpj" size="20" maxlength="20" validate="datatype=cnpj_cpf" />&nbsp;
			</td>
		</tr>
		<tr>
			<td width="200"><label for="cnpj">Tipo de Pessoa:</label></td>
			<td>
				<select id="tipo_pessoa" name="tipo_pessoa">
					<option value=""></option>
					<option value="0">Nenhum</option>
					<option value="PJ">CNPJ</option>
					<option value="PF">CPF</option>
				</select>
			</td>
		</tr>			
		<tr>
			<td width="200"><label for="idradio">ID Radio:</label></td>
			<td>
				<input class="input" id="id_radio" name="id_radio" size="20" maxlength="20"  />&nbsp;
			</td>
		</tr>
		<tr>
			<td width="200"><label for="celular">Celular:</label></td>
			<td>
				(
				<input type="text" id="ddd_cel" class="input" name="ddd_cel" size="2" maxlength="2" onKeyPress="mascara(this,soNumeros)" />
				)&nbsp;<input type="text" id="cel" class="input" name="cel" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" />
			</td>
		</tr>		
		<!--PARAMETRO DE PESQUISA CASO A EMPRESA TRABALHE COM BANDEIRA NEXTEL-->
		<tr>
			<td width="200"><label for="cnpj">Telefone:</label></td>
			<td>		
				(
				<input type="text" id="ddd" class="input" name="ddd" size="2" maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['ddd'];?>" />
				)&nbsp;<input type="text" id="tel" class="input" name="tel" maxlength="10" size="11" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['tel'];?>"  />		
			</td>
		</tr>		
		
		<tr>
			<td><label for="status">Status:</label></td>
			<td>
			<?	
				$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by codstatusclassificacaolead ";
				combo($sql,"codstatusclassificacaolead", "", " ", "");
			?>
			</td>
		</tr>
		<tr>
			<td><label for="gerentecontas">Equipe:</label></td>
			<td>
				<?combo::equipe($codequipe);?>
			</td>
		</tr>
		<tr>
			<td><label for="gerentecontas">Consultor:</label></td>
			<td>
                <?	combo::consultor_equipe1($_SESSION['codusuario']);?>
			</td>
		</tr>	
		<tr>
			<td><label for="atendente">Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
			</td>
		</tr>
		<tr>
			<td><label for="atendente">Mailing:</label></td>
			<td>			
				<?combo::combo_mailing($mailing_pk);?>			
			</td>
		</tr>
		<tr>
			<td><label for="atendente">Id Fornecedor:</label></td>
			<td>
			<input type='text' id='id_fornecedor' name='id_fornecedor' />
			</td>
		</tr>		
		<?
		//FUNCAO VERIFICA EMPRESA OPERADORA SE FOR EMBRATEL LIBERA O PARAMENTRO PARA FILTRO
		 if(empresa_operador(5) == 5){
		?>	
		<tr>
			<td width="200"> <label for="iluminado">Ponto Embratel:</label></td>
			<td>
				<input type="checkbox" name="iluminado" value="1">&nbsp;Iluminado
				&nbsp;<input type="checkbox" name="iluminado"  value="2">&nbsp;Não Iluminado
			</td>
		</tr>
		<?}?>
		<tr>
			<td><label for="atendente">Campanha:</label></td>
			<td>
			<?	
				$sql = "select cod_campanha, nome_campanha from campanha order by nome_campanha";
				combo($sql,"cod_campanha", "", " ", "");	
			?>
			</td>
		</tr>	
                 <tr>
                    <td align="center" colspan=2>
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="15" align="left"  class="titulo">&nbsp;Informações do lead / Oportunidade Identificada</td>
                          </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" align="left"  height="5"  cellpadding="0" cellspacing="0">
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
                                    <table width="100%" align="left"  height="5"  cellpadding="1" cellspacing="1">                                       
                                        <tr>
                                            <td valign="top">Cliente:</td>
                                            <td>
                                                <select name="status_cliente_pk" id="status_cliente_pk" class='formulario_select'   disabled >   
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
                                                <select name="status_base_pk" id="status_base_pk" class='formulario_select'   disabled >   
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
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                                 <tr>
                    <td align="center" colspan=2>
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="15" align="left"  class="titulo">&nbsp;</td>
                          </tr>
                        </table>
                    </td>
                </tr>


                
		<tr>
			<td>
				CEP: 
			</td>
			<td>
				<input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9"  onKeyPress="mascara(this,cep1)"  validate="datatype=cep"/>
			</td>
		</tr>		

		<tr>
			<td>
				Bairro: 
			</td>
			<td>
				<input type="Text" name="bairro" id="bairro">
			</td>
		</tr>		
		<tr>
			<td>
				Cidade: 
			</td>
			<td>
				<input type="Text" name="cidade" id="cidade">
			</td>
		</tr>
		<tr>
			<td>
				Segmento: 
			</td>
			<td>
				<input type="Text" name="segmento" id="segmento">
			</td>
		</tr>
		
		<tr>
			<td width="200"><label for="dataini">Data de Cadastro:</label></td>
			<td>&nbsp;<label for="dataini"> de </label><input class="input" id="dataini" name="dataini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input class="input" id="datafim" name="datafim" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" /></td>
		</tr>
		<tr>
			<td width="200"><label for="dataini">Data da Transferência:</label></td>
			<td>&nbsp;<label for="datatransfini"> de </label><input class="input" id="dt_transf_ini" name="dt_transf_ini" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;<label for="datafim">&nbsp; a </label><input class="input" id="dt_transf_fim" name="dt_transf_fim" size="12" maxlength="10"  onkeypress="mascara(this,datamask)" validate="datatype=date" /></td>
		</tr>		
	<td width="200"></tbody>
		<tr>
			<td colspan="2" align="center">
				<input type="Button" class="botao" value="Enviar" onclick="document.forms[0].submit();self.close();" />
				<input type="Button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
				
			</td>
		</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
