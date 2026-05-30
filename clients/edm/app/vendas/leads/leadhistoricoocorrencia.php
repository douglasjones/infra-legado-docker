<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.usuarios.php";
include_once "../../libs/combo.php";

$dt_cadastro_ini = $_REQUEST['dt_cadastro_ini'];
$dt_cadastro_fim = $_REQUEST['dt_cadastro_fim'];
$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];
$codusuarioabertura = $_REQUEST['codusuarioabertura'];
$status_oc = $_REQUEST['status_oc'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">    
<script src="../../extras/tabela.js"></script>
    <!--Cabe�alho-->
	<title>Hist�rico Ocorr�ncias Lead</title>
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>        
<script type="text/javascript" language="javascript">
window.onload = function(){
	<?if($_REQUEST['origem'] != "resultado"){?>
	opener.top.pagina.location.reload() ;
	<?}?>
}
function window_OcorrenciaEdit(vCodOcorrenciaLead){
	NewWindow("leadocorrencianew.php?codocorrencialead="+vCodOcorrenciaLead,500,400);
}
function OcorrenciaFechada(vlr){
	alert('A Ocorr�ncia ' + vlr + ' esta fechada. Abra uma nova!!');
}
function OcorrenciaPermissao(){
	alert('Voc� n�o tem permiss�o para alterar essa Ocorr�ncia');
}
function enviar(){	
	var frm = document.forms[0];
	frm.submit();
        
}
	</script>
</head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
    <form id="dados" method="get"  action="leadhistoricoocorrencia.php">
        <input type="hidden" id="codlead" name="codlead" value="<?=$_REQUEST['codlead'];?>" />
        <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Hist�rico das Ocorr�ncias Leads
		</td>
	</tr>
</table>
        <table width="50%"   align="center" border="0" cellpadding="1" cellspacing="1" class="form">
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    Data de Abertura
                </td>
                <td>
                        <label for="dataini"> de </label>
                        
                        <input  class="input" id="dt_cadastro_ini" name="dt_cadastro_ini" size="12" maxlength="10" value="<?=$dt_cadastro_ini;?>" onkeypress="mascara(this,datamask)" validate="datatype=date" />&nbsp;
                        <label for="datafim">&nbsp; a </label>
                        <input class="input" id="dt_cadastro_fim" name="dt_cadastro_fim" size="12" maxlength="10" value="<?=$dt_cadastro_fim;?>" onkeypress="mascara(this,datamask)" validate="datatype=date" />
                </td>
            </tr>
            <tr>
                <td>
                    Tipo de Ocorr�ncia
                </td>
                <td>
                    <?
                        $sql = "SELECT CodTipoOcorrenciaLead, t.Descricao FROM tipoocorrenciaslead t";
                        $sql .= " where (t.cod_operador is null or t.cod_operador=0 or cod_operador in (Select cod_operador from empresa_operador) )";		
                        if(!$Root){
                                $sql .= " and Automatica = 0 or CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
                        }
                        $sql .= " Order by t.Descricao";
                        combo($sql, "codtipoocorrencialead",$codtipoocorrencialead, " ", "");
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    Usu�rio de Abertura
                </td>
                <td>
                    <?
                    
                     $tipos[0]['valor'] = '-1';
                    $tipos[1]['valor'] = 1;
                    $tipos[0]['style'] = 'color:#009900';
                    $tipos[1]['style'] = 'color:#990000';
                    $tipos['max'] = 2;	
                
                        $sql = "SELECT ui.CodUsuarioInterno, ui.Nome
                                    FROM usuariosinternos ui
                                ORDER BY ui.Nome";
                     
                        combo($sql,"codusuarioabertura", $codusuarioabertura, " ", "");
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    Status Ocorr�ncia
                </td>
                <td>
                    <select name="status_oc">
                        <option value=""></option>
                        <option value="1" <?if($status_oc==1){ echo "selected";}?>>Aberta</option>
                        <option value="2" <?if($status_oc==2){ echo "selected";}?>>Fechada</option>
                    </select>
                </td>
            </tr>   
            <tr>
                <td colspan="2" align="center">
                    <a href='#'><img width=40 height=30 src='../../images/pesquisar.png' onclick="enviar()"></a>&nbsp;&nbsp;

                    <a href='#' onclick="enviar()">Pesquisar</a>
               </td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;
                </td>
            </tr>
        </table>


<table id="dados" width="100%" align="center"  border=1  height="10"   cellpadding="0" cellspacing="0" class="sortable">
	<thead>
		<tr class="grid">
			<th>C�digo</th>
			<th>Data<br>Abertura</th>
			<th>Tipo<br>Ocorr�ncia</th>
			<th>Descri��o<br>OC</th>
			<th>Usu�rio</th>
			<th>Dt<br>Fechto OC</th>
			<th>Agendado<br>Para</th>
			<th>Dt<br>Retorno</th>
			<th>Descri��o<br>Retorno</th>
			<th>Dt Fechto<br>Retorno</th>
		</tr>
	</thead>
	<tbody>
		
<?

$codlead = mysqlnull($_REQUEST['codlead']);

$sql = "SELECT 
			o.CodOcorrenciaLead
			,o.DataCadastro
			,oc.Descricao TipoOcorrenciaLead
			,o.DataFechamento
			,o.codusuariointerno
			,DATE_FORMAT(o.dt_retorno, '%d/%m/%Y %H:%i') dt_retorno
			,o.dt_retorno_fechamento
			,o.dsc_retorno
			,u.Nome NomeUsuarioInterno
			,ui1.nome as retornopara
			, o.CodUsuarioInterno CodUsuarioInterno
			, o.Descricao
		FROM ocorrenciaslead o
			inner join tipoocorrenciaslead oc ON (o.CodTipoOcorrenciaLead=oc.CodTipoOcorrenciaLead)
			inner join usuariosinternos u ON (o.CodUsuarioInterno=u.CodUsuarioInterno)
			LEFT JOIN usuariosinternos ui1 on o.agendadopara = ui1.codusuariointerno
		WHERE o.CodLead=".$codlead;

                if(!permissao('visualiza_oc_outro_usuario', 'cs')){
                     $sql.=" and o.codusuariointerno = ".$_SESSION['codusuario'];
                }    
                if(!empty($dt_cadastro_ini))
                    $sql.=" and o.DataCadastro >= '".DataYMD($dt_cadastro_ini)." 00:00:00' ";
		
                if(!empty($dt_cadastro_fim))
                    $sql.=" and o.DataCadastro <= '".DataYMD($dt_cadastro_ini)." 23:59:59' ";  
                
                if(!empty($codtipoocorrencialead))
                    $sql.=" and o.codtipoocorrencialead = ".$codtipoocorrencialead; 
                
                if(!empty($codusuarioabertura))
                    $sql.=" and o.codusuariointerno = ".$codusuarioabertura;
                
                if(!empty($status_oc)){
                    if($status_oc=='1'){
                      $sql.=" and o.DataFechamento is null ";  
                    }elseif ($status_oc=='2'){
                       $sql.=" and o.DataFechamento is not null ";  
                    }                    
                }
                    
                
	$sql.="	ORDER BY o.datacadastro DESC ";

$result = sql_query($sql);
	
$cor = "#ffffff";
while($row = mysql_fetch_array($result)){
	if($cor=="#dfdfdf"){
		$cor = "#ffffff";
	}Else{
		$cor = "#dfdfdf";
	}
       //Permissao para Alterar 			
            if(empty($row['DataFechamento']) || $Root ){//VERIFICA SE A OCORRENCIA ESTA FECHADA E O USUARIO E ADMIN PARA EDITAR			
                    if(permissao('ocorrenciaoutrousuario', 'al') or $_SESSION['codusuario']  == $row['codusuariointerno'] ){//VERIFICA SE O USUARIO TEM A PERMISSAO DE EDICAO DE OCS DE OUTROS USUARIOS OU SE A OC PERTENCE AO USUARIO LOGADO
                            //ACESSA A EDICAO DA OC
                            $link1 = '<a href="javascript:window_OcorrenciaEdit('.$row["CodOcorrenciaLead"].')">'.$row["CodOcorrenciaLead"].'</a>';
                            $link2 = '<a href="javascript:window_OcorrenciaEdit('.$row["CodOcorrenciaLead"].')">'.str_replace(chr(13), '<br />', $row["Descricao"]).'</a>';
                    }
                    else{		
                            //BARRA AEDICAO DA OC						
                            $link1 = '<a href="javascript:OcorrenciaPermissao()">'.$row["CodOcorrenciaLead"].'</a>';
                            $link2 = '<a href="javascript:OcorrenciaPermissao()">'.str_replace(chr(13), '<br />', $row["Descricao"]).'</a>';
                    }	
            }else{	
                    //BARRA A EDICAO DA OC SE ESTIVER FECHADA
                    $link1 = '<a href="javascript:OcorrenciaFechada('.$row["CodOcorrenciaLead"].')">'.$row["CodOcorrenciaLead"].'</a>';
                    $link2 = '<a href="javascript:OcorrenciaFechada('.$row["CodOcorrenciaLead"].')">'.str_replace(chr(13), '<br />',$row["Descricao"]).'</a>';
            }
        
        
        
        
	//$link1 = '<a href="javascript:window_OcorrenciaEdit('.$row["CodOcorrenciaLead"].')">'.$row["CodOcorrenciaLead"].'</a>';
	//$link2 = '<a href="javascript:window_OcorrenciaEdit('.$row["CodOcorrenciaLead"].')">'.str_replace(chr(13), '<br />', $row["Descricao"]).'</a>';

?>
		<tr class="link_cinza" bgcolor="<?=$cor?>">
		
			<td align="center"><?=$link1;?></td>
			
			<td align="center"><?=date('d/m/Y \�\s H:i', strtotime($row["DataCadastro"]));?></td>
			<td align="center"><?=$row["TipoOcorrenciaLead"];?></td>
			<td align="center"><?=$link2;?></td>
			<td align="center"><?=$row["NomeUsuarioInterno"];?></td>
			<td align="center"><?=(empty($row['DataFechamento'])?'<strong style="color:red">Em aberto</strong>':date('d/m/Y \�\s H:i', strtotime($row["DataFechamento"])));?></td>
			<td align="center"><?=$row["retornopara"];?></td>
			<td align="center"><?=$row["dt_retorno"];?></td>
			<td align="center"><?=$row["dsc_retorno"];?></td>
			<td align="center"><?if(!empty($row['dt_retorno'])){?><?=(empty($row['dt_retorno_fechamento'])?'<strong style="color:red">Em aberto</strong>':date('d/m/Y \�\s H:i', strtotime($row["dt_retorno_fechamento"])));?><?}else{?>&nbsp;<?}?>
			</td>
<?	}?>
		</tr>
	</tbody>
</table>
<?
mysql_free_result($result);
?>
<p class="form">
<i>** Clique sobre o t�tulo da coluna para ordenar os dados</i>
</p>
<?
	include_once "../../libs/desconectar.php";?>
    </form>
</body>
</html>
