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
<form name="dados" method="get" action="agendamento_res.php" onsubmit='return validaForm(this)' target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				 <td  class="titulo"> 
					Agendamentos - TB Dinâmica 
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
            <td>&nbsp;<label for="codtipo">Tipo Agendamento:</&nbsp;<label></td>
            <td>
            <?	combo::tipo(); ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="codstatus">Status:</&nbsp;<label></td>
            <td>
            <?	
            $sql = "select * from statusagendamento Order By Descricao";
            extras::checkbox2($sql, "codstatus", "all", array("Sem Classificação" => "0"));
            ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="datacadastrode">Data do Agendamento:</&nbsp;<label></td>
            <td>
                &nbsp;<label for="datacadastrode">de&nbsp;</&nbsp;<label>
                <input type="text" id="datacadastrode" name="datacadastrode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
                &nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
                <input type="text" id="datacadastroate" name="datacadastroate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="datavisitade">Data da visita:</&nbsp;<label></td>
            <td>
                &nbsp;<label for="datavisitade">de&nbsp;</&nbsp;<label>
                <input type="text" id="datavisitade" name="datavisitade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
                &nbsp;<label for="datavisitaate">&nbsp;até&nbsp;</&nbsp;<label>
                <input type="text" id="datavisitaate" name="datavisitaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
            </td>
        </tr>
        <!--<tr>
            <td>&nbsp;<label for="codequipe">Equipe:</label></td>
            <td>
            <?combo::equipe();?>
            </td>
        </tr>-->
        <tr>
            <td>&nbsp;<label for="atendente">Mailing:</label></td>
            <td>
                <?combo::combo_mailing($mailing_pk);?>
            </td>
        </tr>		
        <tr>
            <td>&nbsp;<label for="codgerenteconta">Consultor:</&nbsp;<label></td>
            <td>
            <?	combo::consultor_equipe($codgerenteconta);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="codusuariointerno">Agendado por:</&nbsp;<label></td>
            <td>
            <?	combo::agdo_por();?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="agendadopara">Agendado para operadora:</&nbsp;<label></td>
            <td>
            <?	combo::agdo_para();?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;<label for="grupousuariointerno">Grupo de Usuário de Cadastro:</&nbsp;<label></td>
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
