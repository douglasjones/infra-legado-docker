<?

    include_once "../../libs/maininclude.php";
    include_once "../../libs/combo.php";
	include_once "../../libs/cla.ocorrencias.php";

	$values['codtipoocorrenciaLead'] = null ;
	$values['Descricao'] = null ;
	$values['Status'] = 0 ;
	$values['Automatica'] = 0 ;
	$values['Fechar'] = 0 ;
	$values['Minutos'] = 0 ;
	$values['cod_operador'] = 0 ;
	$acao = "ins" ;
    

	if (!empty($_REQUEST['codtipoocorrenciaLead'])){
		$values['codtipoocorrenciaLead'] = $_REQUEST['codtipoocorrenciaLead'] ;
		$acao = "upd" ;

		//Faz a pesquisa no banco de dados.
		$tipos = ocorrencias::gettipo( $values['codtipoocorrenciaLead'] ) ;

		if( $row = mysql_fetch_array( $tipos ) )
		{
			$values['Descricao' ] = $row['Descricao' ];
			$values['Status'    ] = $row['Status'	 ];
			$values['Automatica'] = $row['Automatica'];
			$values['Fechar'	] = $row['Fechar'	 ];
			$values['Minutos'	] = $row['Minutos'	 ];
			$values['cod_operador'	] = $row['cod_operador'	 ];
            $values['status_pk'	] = $row['status_pk'	 ];
		}
		mysql_free_result( $tipos ) ;
	}
	//if(!$Root && !$Admin){
		//javascriptalert('Você não tem permissão para acessar esta página!!!');
		//exit;
	//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Tipos de Ocorr&ecirc;ncias</title>


<?	include_once "../../libs/head.php";?>

<script language="JavaScript" type="text/javascript">
function numeros( e )
{
	var tecla = ( window.Event ) ? e.which : e.keyCode ;
	if ( tecla == 13 || tecla == 8 )
		return true ;
	return ( tecla < 48 || tecla > 57 ) ? false : true ;
}
</script>

</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" action="tipoocorrenciacad.php">
		<input type="hidden" name="codtipoocorrenciaLead" value="<?=$values['codtipoocorrenciaLead'];?>" />
		<input type="hidden" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo">
			Tipos de Ocorr&ecirc;ncias
		</td>
	</tr>
</table>
		<table border="0" cellpadding="0" cellspacing="0" class="form">
				<tr>
					<td>&nbsp;

					</td>
				</tr>
			<tbody>
				<tr>
					<td>&nbsp;<label for="Descricao">Descri&ccedil;&atilde;o:</label></td>
					<td><input type="text" name="Descricao" value="<?=$values['Descricao'];?>" maxlength="50" size="25" validate="required" /></td>
				</tr>
				<tr>
					<td>&nbsp;<label for="Status">Status Classificação:</label></td>
<!--					<td><input type="text" name="Status" value="<?=$values['Status'];?>" maxlength="50" size="25"/></td>-->
						<td><?
						$sql = "select CodStatusClassificacaoLead, Descricao from statusclassificacaolead where 1";
						combo($sql, "Status", $values['Status'], "-", "", 0);
						?>
						</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="Automatica">Automatica:</label></td>
					<td><select name="Automatica" id="Automatica">
							<option value="1" <?=($values['Automatica'] == 1?'selected="selected"':null);?>>Sim</option>
							<option value="0" <?=($values['Automatica'] != 1?'selected="selected"':null);?>>Não</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="Fechar">Fechar:</label></td>
					<td><select name="Fechar" id="Fechar">
							<option value="1" <?=(@$values['Fechar'] == 1?'selected="selected"':null);?>>Sim</option>
							<option value="0" <?=(@$values['Fechar'] != 1?'selected="selected"':null);?>>Não</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="Minutos">Minutos:</label></td>
					<td>
							<input type="text" name="Minutos" id="Minutos" value='<?= $values['Minutos'] ; ?>' size="5" onkeypress="return numeros( event );" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codmodelo">Operador:</label></td>
					<td>
					<?	$sql = "select
									op.cod_operador
									,op.dsc_operador
								from  operador op 
								  inner join empresa_operador eo on op.cod_operador = eo.cod_operador
								where eo.dat_canc is null
								and op.dat_canc is  null
								order by op.cod_operador";
						
						combo($sql, "cod_operador", $values['cod_operador'], " ", "");?>
					</td>
				</tr>
                <tr>
                    <td>
                        &nbsp;Status:
                    </td>
                    <td>
                        <?
                            $sql = "";
                            $sql.="Select
                                    s.cod_status status_pk
                                    ,s.dsc_status
                                    from status s";
                            
                            combo($sql, "status_pk", $values['status_pk'], " ", "");
                        ?>                        
                    </td>
                </tr>
			</tbody>
			<tfoot>
				<tr>
					<td>&nbsp;

					</td>
				</tr>
				<tr>
					<th colspan="2" align="right">
						<input type="submit" value="Enviar" />
						<input type="button" value="Fechar" onclick="self.close();" />&nbsp;
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<? include_once "../../libs/desconectar.php";?>
