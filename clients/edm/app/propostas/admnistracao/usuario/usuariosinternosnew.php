<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	include_once "../../libs/cla.usuarios.php";

	$acao = INS;
	$_REQUEST['CodUsuarioInterno'] = @$_REQUEST['codusuariointerno'];
	$_REQUEST['Desativado'] = -1;
	if(!empty($_REQUEST['enviar'])){
		if(usuarios::salvar($_REQUEST)){
			javascriptalert('Operação executada com sucesso!!!');
		}
	}
	if(!empty($_REQUEST['codusuariointerno'])){
		$sql = "select 
					ui.* 
					,tb.Fk_Equipe
				from usuariosinternos ui
				left join tb_usuarioequipe tb on ui.codusuariointerno = tb.Fk_Usuario
				where ui.codusuariointerno = " . mysqlnull($_REQUEST['codusuariointerno']);
		$result = sql_query($sql);
		if($row = mysql_fetch_assoc($result)){
			$_REQUEST = array_merge($_REQUEST, $row);
		}
		mysql_free_result($result);
	}
	
	$codusuariointerno = $_REQUEST['CodUsuarioInterno'];
	
	//se a acao enviada pelo menu for cp (Copiar) irá carregar o registro e inserir um novo com os dados já selecionados.
	if($_REQUEST['acao'] == 'cp'){
		$codusuariointerno = "";
		$_REQUEST['Nome']="";
		$_REQUEST['Login']="";
		
	}
	
	if(!(($acao == INS && permissao('usuarios', 'ic')) || ($acao == UPD && permissao('usuarios', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
     <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Usuários Internos</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
<script>

function gerarlogin(){
	var frm = document.forms[0];
	if(frm.login.value == ""){
		var arr = frm.nome.value.split(" ");
		if(arr.length > 1)
			frm.login.value = arr[0].toLowerCase()+"."+arr[arr.length-1].toLowerCase();
		else
			frm.login.value = frm.nome.value.toLowerCase();
	}
}
function novoDocumento(){
	NewWindow("documentos_cad_form.php?codusuariointerno=<?=$codusuariointerno?>", 600, 400)
}
function abrirDocumentos(){
	NewWindow("documentosres.php?codusuariointerno=<?=$codusuariointerno?>", 1000, 400)
}
function reload_combo(num) {

	var v = $('cod_polo').value;
	if(num==1){
		var pars = 'tipo=1' + '&cod_polo=' + v;		
		new Ajax.Updater('empresa', 'reloadcomboAjax.php', { method: 'post', parameters: pars } );		
		//var pars = 'tipo=2' + '&cod_polo=' + v;
	}
	new Ajax.Updater('div_empresa', 'reloadcomboAjax.php', { method: 'post', parameters: pars } );
}

function Limpar(valor, validos) {
// retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;
}
}
return result;
}

//Formata número tipo moeda usando o evento onKeyDown

function Formata(campo,tammax,teclapres,decimal) {
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal

if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }
if (tecla == 8 )
{ tam = tam - 1 ; }
if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
{
if ( tam <= dec )
{ campo.value = vr ; }
if ( (tam > dec) && (tam <= 5) ){
campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 6) && (tam <= 8) ){
campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
}
if ( (tam >= 9) && (tam <= 11) ){
campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 12) && (tam <= 14) ){
campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 15) && (tam <= 17) ){
campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
} 
}
	function validaForm(frm){
		if(!validateForm(frm)){
		return false;
		}
		if(frm.codgrupousuariointerno.options.length == 0){
			alert("Selecione o Grupo.");
			frm.codgrupousuariointerno.focus();
			return false;
		}
		var grupousuariointerno = document.getElementById('codgrupousuariointerno');
		for(var i = 0; i < grupousuariointerno.options.length; i++){
			grupousuariointerno.options[i].selected = true;
		}
		return true;
	}
	function excluirGrupo(){
		var d = document.forms[0];
		var indice = d.codgrupousuariointerno.selectedIndex;
		if (indice == -1){
			alert('Selecione um item na lista!!!');
		}else{
			d.codgrupousuariointerno.remove(indice)	;
		}
	}
	function incluirGrupo(){
		var strSelecionados = "";
		var d = document.forms[0];
		for(i=0;i<d.codgrupousuariointerno.options.length;i++){
			strSelecionados += d.codgrupousuariointerno.options[i].value + ',';
		}
		NewWindow('usuariosinternosgrupos.php?CodGrupoUsuarioInterno=' + strSelecionados,300,100);
	}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" name="frm" action="usuariosinternosnew.php" onsubmit="return validaForm(this)">
<input type="hidden" name="codusuariointerno" value="<?=$codusuariointerno;?>" />
<input type="hidden" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"   height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Usuários
		</td>
	</tr>
</table>		
<table width="98%" height="60" border="0"  class="modulo1" cellpadding="0" cellspacing="0" align="center">
	<tr>
    	<td>
			<table width="100%" height="100%" border="0" >
				<tr>
					<td width="120" valign="middle">
						Dados Usuarios
					</td>
					<td>
						<td>
						<table width="100%" border=1 bordercolor="808080" cellpadding="0" cellspacing="0">
						    <tr bordercolor="f5f5f5">
						        <td width="150" >&nbsp;<label for="nome">Nome Completo:</label></td>
						        <td><input type="text" id="nome"  onblur="gerarlogin()" name="nome" value="<?=@$_REQUEST['Nome'];?>" maxlength="50" size="50" validate="required" /></td>
						    </tr>
						    <tr bordercolor="f5f5f5">
						        <td>&nbsp;<label for="login">Login:</label></td>
						        <td><input type="text" id="login" name="login" value="<?=@$_REQUEST['Login'];?>" maxlength="50" size="30" validate="required" /></td>
						    </tr>
						    <tr bordercolor="f5f5f5">
						        <td>&nbsp;<label for="senha">Resetar Senha:</label></td>
						        <td>
						            <input type="checkbox" id="senha" name="senha" value="1"/>
						        </td>
						    </tr>
						</table>					
					</td>					
				</tr> 
				<tr>
					<td width="120" valign="middle">
						Dados Cadastrais
					</td>
					<td>
						<td>
						<table width="100%" border=1 bordercolor="808080" cellpadding="0" cellspacing="0"  >
							<tr bordercolor="f5f5f5">
								<td width="150">&nbsp;<label for="desativado">Status:</label></td>
								<td>
									<select name="desativado" id="desativado">
										<option value="1" <?=(@$_REQUEST['Desativado'] == 1?'selected="selected"':null);?>>Desativado</option>
										<option value="0" <?=(@$_REQUEST['Desativado'] != 1?'selected="selected"':null);?>>Ativo</option>
									</select>
							</tr>
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="Regime">Regime Contratação:</label>
								</td>					
								<td bordercolor="f5f5f5">
									<select name="cod_regime" id="regime">
										<option value="0"></option>					
										<option value="1" <?=(@$_REQUEST['cod_regime'] == 1?'selected="selected"':null);?>>CLT</option>
										<option value="2" <?=(@$_REQUEST['cod_regime'] != 1?'selected="selected"':null);?>>PJ</option>
									</select>
								</td>
							</tr>														
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="dat_adm">Data admissão:</label>
								</td>
								<td>
									<input class="input" id="dat_adm" name="dat_adm"   value="<?=(!empty($_REQUEST['dat_adm'])?date('d/m/Y', strtotime($_REQUEST['dat_adm'])):null);?>"  size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
								</td>
							</tr>	
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="dat_dem">Data Demissão:</label>
								</td>
								<td>
									<input class="input" id="dat_dem" name="dat_dem" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
								</td>
							</tr>	
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="dat_dem">Nº Celular:</label>
								</td>
								
								<td>
									(<input type='text' id="ddd_tel" name='ddd_tel' value="<?=@$_REQUEST['ddd_tel'];?>" size="2" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,soNumeros)" maxlength="2" validate="regexp=/^\d{2}$/" />
									)&nbsp;<input type="text" id="tel" name="tel" value="<?=@$_REQUEST['tel'];?>" size="11" maxlength="10" onblur="consulta_np_celular_contato()" onKeyPress="mascara(this,telefone1)" validate="datatype=tel" />
									
								</td>
							</tr>
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="emei">Nº IMEI:</label>
								</td>
								<td>
									<input class="input" id="emei" name="emei" size="30" maxlength="30" value="<?=@$_REQUEST['emei'];?>" />
								</td>
							</tr>	
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="email">E-mail:</label></td>
								<td>
									<input type='text' id="email" size="30" maxlength="50" name="email" value="<?=@$_REQUEST['email'];?>" validate="datatype=email" />
								</td>
							</tr>
                                                        <?if(!empty($codusuariointerno)){?>
                                                        <tr bordercolor="f5f5f5">
                                                            <td>&nbsp;<label for="email">Documentos:</label></td>
                                                            <td>
                                                                <?	$sql = "Select count(*) Total From documentos_usuario Where codusuariointerno = ".$_REQUEST['codusuariointerno']." and ic_ativo = 1";
                    
                                                                        $rs = sql_query($sql);
                                                                        $row = mysql_fetch_array($rs);
                                                                        $totaldocumentos = $row['Total'];
                                                                        mysql_free_result($rs);
                                                                ?>
                                                                    <a href="javascript:abrirDocumentos()">(<?=$totaldocumentos;?>) Histórico Documentos</a>
                                                                &nbsp;<input type="button" class="botao" value="+" onClick="novoDocumento()" title="Novo Documento" />
                                                            </td>
							</tr>
                                                        <?}?>
						</table>					
					</td>					
				</tr> 
								<tr>
					<td width="120" valign="middle">
						Dados Profissionais
					</td>
					<td>
						<td>
						<table width="100%" border=1 bordercolor="808080" cellpadding="0" cellspacing="0" >
							<tr bordercolor="f5f5f5">
								<td width="150">
									&nbsp;<label for="coddepartamento">Polo:</label>
								</td>					
								<td>
								<?	
									$sql  = " Select p.cod_polo,p.n_polo";
									$sql .= " from polo p";
									$sql .= " order by p.n_polo";
								    //Função combo
									combo($sql, "cod_polo", @$_REQUEST['cod_polo'], " ", "onchange='reload_combo(1);'");
								?>
								</td>
							</tr>
							<tr bordercolor="f5f5f5">
								<td width="150">
									&nbsp;<label for="coddepartamento">Empresa:</label>
								</td>					
								<td>	
								<div id="empresa">							
								<?	
									if(!empty($_REQUEST['cod_polo'] )){
									$sql  = " Select 
											e.cod_empresa
											,case  when e.bairro is null then
												e.razao_social
											else
												concat(e.razao_social, '- ',e.bairro)
											end as empresa	
											from empresa e
												where e.cod_polo=".$_REQUEST['cod_polo'];
								    //Função combo
									combo($sql, "cod_empresa", @$_REQUEST['cod_empresa'], null, "onchange='reload_combo(1);'");
									}else{
											?>
											<select>
												<option></option>
											</select>
											<?
									}	
									?>
									</div>
								</td>
							</tr>
							<tr bordercolor="f5f5f5">					
								<td>					
									&nbsp;<label for="coddepartamento">Departamento:</label>					
								</td>					
								<td>					
								<?	$sql = "Select coddepartamento, Nome from departamento order by Nome;";
									    //Função combo
									combo($sql, "coddepartamento", @$_REQUEST['CodDepartamento'], " ", null);?>
								</td>					
							</tr>
							<tr bordercolor="f5f5f5">					
								<td>					
									&nbsp;<label for="coddepartamento">Atividade Profissional:</label>					
								</td>										
								<td>					
								<?	$sql = "Select cod_atividade_profissional, dsc_atividade from atividade_profissional order by dsc_atividade ;";													
								    //Função combo
									combo($sql, "cod_atividade_profissional", @$_REQUEST['cod_atividade_profissional'], " ", null);?>
								</td>
							</tr>								
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="codgrupousuariointerno">Grupo:</label></td>
								<td>
								<select id="codgrupousuariointerno" name="codgrupousuariointerno[]" size="5" style="width:150px" multiple="multiple">
								<?	
								if(!empty($_REQUEST['CodUsuarioInterno'])){
										$sql = "select gui.CodGrupoUsuarioInterno, gui.Nome from gruposusuariosinternos_usuariosinternos guiui, gruposusuariosinternos gui where guiui.codgrupousuariointerno=gui.codgrupousuariointerno";
										$sql .= " and guiui.codusuariointerno = " . mysqlnull($_REQUEST['CodUsuarioInterno']) . " order by gui.Nome";
										$result = sql_query($sql);
										while ($row = mysql_fetch_array($result)){?>
															<option value="<?=$row['CodGrupoUsuarioInterno'];?>" ><?=$row['Nome'];?></option>
								<?		}
										mysql_free_result($result);
									}?>
									</select>
									<br />
									<input type="button" value="Incluir" onclick="incluirGrupo()" />&nbsp;
									<input type="Button" value="Excluir" onclick="excluirGrupo()" />
								</td>
							</tr>		
							<tr bordercolor="f5f5f5">
			                	<td>&nbsp;<label for="atendente">Equipe</label></td>
			                    <td>
			                    <?	$sql = "SELECT tb.TK_equipe,tb.VC_Nome
											FROM tb_equipesvendas tb
											order by tb.VC_Nome ;";
			
									combo($sql, "TK_equipe", @$_REQUEST['Fk_Equipe'], " ", null);?>
			
			                    </td>
			                </tr>	
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="codusuariosuperior">Superior:</label></td>
								<td>
									<?	
										$sql = "Select codusuariointerno, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
										$tipos[0]['valor'] = '-1';
										$tipos[1]['valor'] = 1;
										$tipos[0]['style'] = 'color:#009900';
										$tipos[1]['style'] = 'color:#990000';
										$tipos['max'] = 2;
										combo_tipos($sql, "codusuariosuperior", $tipos, @$_REQUEST['CodUsuarioSuperior'], " ", null);
									?>
								</td>
							</tr>		
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="gerentecontas">Gerente de contas:</label></td>
								<td><select name="gerentecontas" id="gerentecontas">
										<option value="1" <?=(@$_REQUEST['GerenteContas'] == 1?'selected="selected"':null);?>>Sim</option>
										<option value="0" <?=(@$_REQUEST['GerenteContas'] != 1?'selected="selected"':null);?>>Não</option>
									</select>
								</td>
							</tr>
							<tr bordercolor="f5f5f5">
								<td>
									&nbsp;<label for="coddepartamento">Classificação:</label>
								</td>					
								<td>
									<?	$sql = "Select cod_classificacao,dsc_classificacao from classificacao_atividade_profissional order by dsc_classificacao ;";
								    //Função combo
									combo($sql, "cod_classificacao", @$_REQUEST['cod_classificacao'], " ", null);?>
								</td>
							</tr>	
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="atendente">Atendente:</label></td>
								<td><select name="atendente" id="atendente">
										<option value="1" <?=(@$_REQUEST['Atendente'] == 1?'selected="selected"':null);?>>Sim</option>
										<option value="0" <?=(@$_REQUEST['Atendente'] != 1?'selected="selected"':null);?>>Não</option>
									</select>
								</td>
							</tr>	
							<?		
						   	//FUNCAO VERIFICA EMPRESA OPERADORA SE FOR CLARO LIBERA O PARAMENTRO PARA FILTRO, ESTA FUNCAO ESTA NA MANINCLUDE
					 		if(empresa_operador(1) == 1){
							?>																
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="meta">Meta Claro R$:</label></td>
								<td><input type="text" id="meta_moeda" name="meta_moeda"  onKeydown="Formata(this,20,event,2)" value="<?=@$_REQUEST['meta_moeda'];?>" maxlength="15" size="15" /></td>
							</tr>	
							<?}
							if(empresa_operador(2) == 2 or empresa_operador(3) == 3 or empresa_operador(4) == 4){
							?>	
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="meta">Meta:</label></td>
								<td><input type="text" id="meta" name="meta" value="<?=@$_REQUEST['Meta'];?>" maxlength="15" size="15" /></td>
							</tr>	
							<?
							}	
							?>			
							<?
							if(empresa_operador(6) == 6){
							?>	
							<tr bordercolor="f5f5f5">
								<td>&nbsp;<label for="meta">Código SA3:</label></td>
								<td><input type="text" id="codigosa3" name="codigosa3" value="<?=@$_REQUEST['codigosa3'];?>" maxlength="15" size="15" /></td>
							</tr>	
							<?
							}	
							?>										
						</table>					
					</td>					
				</tr> 
		    </table>
		</td>
	</tr>			
	<tr>
		<th colspan="2" align="right">
			<input type="submit" value="Enviar" name="enviar" />
			<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
		</th>
	</tr>
</table>	
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
