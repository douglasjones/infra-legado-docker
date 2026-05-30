<?
include_once "../../libs/maininclude.php";
include_once "n_produtos_book_cla.php";
include_once "../../libs/combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

if(!empty($pk)){
	$n_produtos_book = new n_produtos_book($pk);
	$pk = $n_produtos_book->getpk();
    $dt_cadastro = $n_produtos_book->getdt_cadastro();
    $usuario_cadastro_pk = $n_produtos_book->getusuario_cadastro_pk();
    $dt_ult_atualizacao = $n_produtos_book->getdt_ult_atualizacao();
    $usuario_ult_atualizacao_pk = $n_produtos_book->getusuario_ult_atualizacao_pk();
    $dt_cancelamento = $n_produtos_book->getdt_cancelamento();
    $operador_pk = $n_produtos_book->getoperador_pk();
    $n_dsc_book = $n_produtos_book->getn_dsc_book();
    $dt_inicio = $n_produtos_book->getdt_inicio();
    $dt_fim = $n_produtos_book->getdt_fim();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>Book de Ofertas</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="n_produtos_book_cad_form.js"></script>
</head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
        <form name="dados" method="post" action="n_produtos_book_cad_proc.php">
        <input type='hidden' name='acao' id='acao' value='' />
        <input type='hidden' name='pk' value='<?=$pk;?>' />

            <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                <tr>
                    <td  class="titulo">
                         Book de ofertas
                    </td>
                </tr>
            </table>
            <table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
                <tr>
                    <td colspan="2">

                    </td>
                </tr>
                <tr>
                    <td  width="25%">
                        Operadora: 
                    </td>
                    <td>
                        <? $sql =  "Select 
                                        o.cod_operador
                                        ,o.dsc_operador
                                    from operador o
                                    inner join empresa_operador ep on o.cod_operador = ep.cod_operador
                                    group by o.dsc_operador
                                    order by o.dsc_operador";
                            combo($sql,"operador_pk", $operador_pk, "", " ");
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Book:
                    </td>
                    <td>
                        <input type='text' id='n_dsc_book' size ="35" name='n_dsc_book' value='<?=$n_dsc_book;?>' />
                    </td>
                </tr>
                <tr>
                    <td>
                        Data de inicio:
                    </td>
                    <td>
                        <input type="text" id="dt_inicio" name="dt_inicio" maxlength="10" size="12" onKeyPress="mascara(this,datamask)" value='<?=$dt_inicio;?>' validate="datatype=date" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Data de cancelamento:
                    </td>
                    <td>
                        <input type="text" id="dt_fim" name="dt_fim" maxlength="10" size="12" onKeyPress="mascara(this,datamask)" value='<?=$dt_fim;?>' validate="datatype=date" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <?if(!empty($pk)){ ?>
                            <?if(DataYMD($dt_fim) >= date('Y-m-d')){
                                ?>
                                <input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />
                            <?}?>
                        <?}else{?> 
                            <input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />  
                        <?}?>        
							<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
                    </td>
                </tr>							
            </table>
        </form>
    </body>
</html>
<?	include_once "../../libs/desconectar.php";?>
