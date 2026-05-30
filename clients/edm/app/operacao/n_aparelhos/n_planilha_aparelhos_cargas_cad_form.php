<?
include_once "../../libs/maininclude.php";
include_once "n_planilha_aparelhos_cargas_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

if(!empty($pk)){
	$n_planilha_aparelhos_cargas = new n_planilha_aparelhos_cargas($pk);
	$pk = $n_planilha_aparelhos_cargas->getpk();
	$dt_cadastro = $n_planilha_aparelhos_cargas->getdt_cadastro();
	$usuario_cadastro_pk = $n_planilha_aparelhos_cargas->getusuario_cadastro_pk();
	$dt_ult_atualizacao = $n_planilha_aparelhos_cargas->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_pk = $n_planilha_aparelhos_cargas->getusuario_ult_atualizacao_pk();
    $dt_inicio = $n_planilha_aparelhos_cargas->getdt_inicio();
    $dt_cancelamento = $n_planilha_aparelhos_cargas->getdt_cancelamento();
    $planilha_carga = $n_planilha_aparelhos_cargas->getplanilha_carga();

    

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>Planilha</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="n_planilha_aparelhos_cargas_cad_form.js"></script>
</head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
        <form action="n_planilha_aparelhos_cargas_cad_proc.php" method="POST" enctype="multipart/form-data">
            <input type='hidden' name='acao' id='acao' value='' />
            <input type='hidden' name='pk' value='<?= $pk;?>' />



            <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                <tr>
                    <td  class="titulo">
                        Planilha
                    </td>
                </tr>
            </table>

            <table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
                <tr>
                    <td colspan="2">

                    </td>
                </tr>
                <tr>
                    <td>
                        Selecione o Arquivo:
                    </td>
                    <td>
                        <input size="60" type="File" name="planilha_carga">			
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" >
                        <?
                        if($pk != ''){
                            ?>
                            <input type='button' name="cmdExcluir" id='cmdExcluir' value='Excluir' onclick="excluir()" />

                            <?
                        }
                        ?>		
                        <input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />

                        <input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
                    </td>
                </tr>							
            </table>
        </form>
    </body>
</html>
<?	include_once "../../libs/desconectar.php";?>
