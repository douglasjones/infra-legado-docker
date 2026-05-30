<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

//Verifica se o usuario é o administrador
if(!permissao("tabela_dinamica_ocorrencias", "cs")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}
?>
<html>
<head>
    <link rel="stylesheet"  href="../../extras/public.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />
    <?	include_once "../../libs/head.php";?>
    <script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script>
    function mascaraData() {
        mascara(this, datamask)

    }
    
    function validaForm(frm){
		
		self.close()
		return true;
	}
    
    $('document').ready(function() {
		
        //atribui os eventos ao controle.
        $('#dt_periodo_ini').keypress(mascaraData);
        $('#dt_periodo_fim').keypress(mascaraData);

        configurarCampo(document.getElementById("dt_periodo_ini"));
        configurarCampo(document.getElementById("dt_periodo_fim"));
    });
	</script>		
</head>
<body>
    <form name="dados" method="get" action="ocorrencia_res.php" onsubmit='return validaForm(this)' target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				 <td  class="titulo"> 
					Ocorrências - TB Dinâmica 
				</td>
			</tr>
		</thead>
	</table>	
	<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tr>
		<td width="35%">
			&nbsp;<label  for="datacadastro">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="razaosocial">Tipo Ocorrêcia:</&nbsp;<label></td>
		<td>
            <?	combo::padrao("tipoocorrenciaslead", "codtipoocorrencialead");?>
        </td>
	</tr>
    <tr>
        <td>&nbsp;<label for="datacadastrode">Data de Abertura:</&nbsp;<label></td>
        <td>
            &nbsp;<label for="datacadastrode">de&nbsp;</&nbsp;<label>
            <input type="text" id="datacadastrode" name="datacadastrode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
            &nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
            <input type="text" id="datacadastroate" name="datacadastroate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
        </td>
    </tr>
		<tr>
			<td>&nbsp;<label for="datavisitade">Data de Fechamento:</&nbsp;<label></td>
			<td>
                &nbsp;<label for="datafechamentode">de&nbsp;</label>
				<input type="text" id="datafechamentode" name="datafechamentode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datafechamentoate">&nbsp;até&nbsp;</label>
				<input type="text" id="datafechamentoate" name="datafechamentoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>

		<tr>
			<td>&nbsp;<label for="atendente">Aberto por:</label></td>
			<td>
				<?	combo::user("ocorrenciaslead");?>
			</td>
		</tr>		
		<tr>
			<td><label for="atendente">&nbsp;Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codusuariointerno">Consultor:</&nbsp;<label></td>
			<td>
                <?	combo::consultor($GerenteContas,$NomeUsuario);?>
			</td>
		</tr>

        <tr>
			<td>&nbsp;<label for="codgerenteconta">Grupo de Cadastro:</&nbsp;<label></td>
			<td>
                <?	combo::grupo();?>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type='submit' value='Enviar' >
				&nbsp;
				<input type="button" value="Fechar" onclick="window.close()" />
			</th>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
<?
    include_once "../libs/desconectar.php";

?>
