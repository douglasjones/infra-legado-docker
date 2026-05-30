<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

//Verifica se o usuario é o administrador
if(!permissao("tabela_dinamica_agendamento", "cs")){
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
<form name="dados" method="get" action="leads_res.php" onsubmit='return validaForm(this)' target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				 <td  class="titulo"> 
					Lead´s - TB Dinâmica 
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
			<td>&nbsp;<label for="codstatusclassificacaolead">Status Lead:</&nbsp;<label></td>
			<td>
			<?	combo::status_ld(); ?>
			</td>
		</tr>
        <tr>
			<td width="200">&nbsp;<label for="cnpj">Tipo de Pessoa:</label></td>
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
			<td>&nbsp;<label for="gerentecontas">Equipe:</label></td>
			<td>
				<?combo::equipe($codequipe);?>
			</td>
		</tr>
				<tr>
			<td>&nbsp;<label for="gerentecontas">Consultor:</label></td>
			<td>
			<?	combo::consultor_equipe1($_SESSION['codusuario']);?>
			</td>
		</tr>	
		<tr>
			<td>&nbsp;<label for="atendente">Atendente:</label></td>
			<td>
			<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="atendente">Mailing:</label></td>
			<td>			
				<?combo::combo_mailing($mailing_pk);?>			
			</td>
		</tr>
        <tr>
			<td valign="top">&nbsp;Operadora:</td>
			<td>
				<?php 				
				$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
				combo($sql,"cod_operadora", "", " ", "");	
				?>
			</td>
		</tr>
        <tr>
			<td>
				&nbsp;Cidade: 
			</td>
			<td>
				<input type="Text" name="cidade" id="cidade">
			</td>
		</tr>
        <tr>
            <td>									
                &nbsp;Cep:	
            </td>	
            <td>
                <input type="Text" name="cep" size="5" maxlength="5">
            </td>
        </tr>
		<tr>
			<td>
				&nbsp;Segmento: 
			</td>
			<td>
				<input type="Text" name="segmento" id="segmento">
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
