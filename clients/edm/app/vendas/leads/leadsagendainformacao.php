<?

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.agendaslead.php";
include_once "../../libs/cla.leads.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.ocorrencias.php";

$acao = null;
$codagendalead = null;
$codlead = $_REQUEST['codlead'];
$lytebox = $_REQUEST['lytebox'];


if(!empty($_REQUEST['codagendalead']))
	$codagendalead = $_REQUEST['codagendalead'];

if(!empty($_REQUEST['enviar'])){	
    $lytebox = $_REQUEST['lytebox'];
    
    agendaslead::informacao($_REQUEST);
    
    
    if($lytebox==1){
        echo "<script>";
        echo "parent.location.reload()";
        echo "</script>";        
    }else{        
        javascriptalert('Operação executada com sucesso!!!');
    }    

    
}else{
	if(!empty($codagendalead)){
		//Traz os dados da agenda.
		$sql = "SELECT l.codlead codigo
                   ,a.CodAgendaLead
                   , a.Termino
                   , a.CodStatus
                   , a.CodOcorrenciaLead
                   , a.Informacoes
                   , s.Descricao Status
                   , date_format(l.vencimentocontrato, '%d/%m/%Y') vencimentocontrato
              FROM agendaslead a
                   INNER JOIN leads l
                      ON a.codlead = l.codlead
                   LEFT JOIN statusagendamento s
                      ON a.CodStatus = s.CodStatus";
		$sql .= " where a.CodAgendaLead = " . mysqlnull($codagendalead);
		$result = sql_query($sql);
		$agenda = mysql_fetch_array($result);
		if(!$agenda)
			exit();
		$acao = (empty($agenda['Informacoes'])?'ins':'upd');
		$vencimentocontrato = $agenda['vencimentocontrato'];
		$codlead = $agenda['codigo'];
        mysql_free_result($result);
        
        if($agenda['CodStatus']==2){
            $sql = "Select 
                        l.codmotivo
                    from leads l
                    where l.codlead=".$codlead;
              
            $result = sql_query($sql);
            $classificacaolead = mysql_fetch_array($result);
            if(!$classificacaolead)
			 exit();
            $codmotivolead = $classificacaolead['codmotivo'];                     
        }        	

	}

}

if(!(($acao == 'ins' && permissao('informacaovisita', 'ic')) || ($acao == 'upd' && permissao('informacaovisita', 'al')))){
	//javascriptalert('Você não tem permissão para acessar esta página!!!');
//	exit;
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">

    <!--Cabeçalho-->
	<title>Ativo - Classificação da Visita</title>
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" language="javascript">
function valida (){
    var d = document.forms.dados;
    //VERIFICA SE TERMINO DA VISITA ESTA VAZIO
	if(d.termino.value==""){			
		document.getElementById('termino').style.border = 'solid 3px red';
		d.termino.focus();
		return false;
	}
    
    var codstatus = document.getElementById("codstatus").value;
    if(codstatus==""){			
		document.getElementById('codstatus').style.border = 'solid 3px red';
		d.codstatus.focus();
		return false;
	}
    
    if(d.informacoes.value==""){			
		document.getElementById('informacoes').style.border = 'solid 3px red';
		d.informacoes.focus();
		return false;
	}
    
   /*if(codstatus==2){
        var codmotivolead = document.getElementById("codmotivolead").value;
        if(d.codmotivolead.value==""){			
		  document.getElementById('codmotivolead').style.border = 'solid 3px red';
		  d.codmotivolead.focus();
		  return false;
	   }       
    }*/
    
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
function validaCampos(){
	if(!validateForm(document.forms[0])) return false
	return true
}

function carregar(){
	var frm = document.forms[0];
	
	frm.termino.focus();

	
	
    <?if($agenda['CodStatus']==2){?>
        document.getElementById('seminteresse').style.display = "inline";
    <?}?>
    
}
function seminteresse (cod){
    if(cod==2){
        document.getElementById('seminteresse').style.display = "inline";
    }else{
        document.getElementById('seminteresse').style.display = "none";
    }
}

</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="post" action="leadsagendainformacao.php" onsubmit="return valida()">
	<input type="hidden" id="codagendalead" name="codagendalead" value="<?=$codagendalead;?>" />
	<input type="hidden" id="codlead" name="codlead" value="<?= $codlead;?>" />
	<input type="hidden" id="vencimentocontratoanterior" name="vencimentocontratoanterior" value="<?=$vencimentocontrato;?>" />
    <input type="hidden" id="codtipoocorrencialead" name="codtipoocorrencialead" value="5" />
    <input type="hidden" id="lytebox" name="lytebox" value="<?=$lytebox?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Ativo - Classificação da Visita
		</td>
	</tr>
</table>			
<table width="98%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
          <td>
              &nbsp;
          </td>
    </tr>
	<tr>
		<td>&nbsp;<label for="termino">Término:</label></td>
		<td>
			<input type="text" id="termino"     name="termino"       size="6" maxlength="8" onkeypress="return horamask2(this,event)" value="<?=(!empty($agenda['Termino'])?date('H:i', strtotime($agenda['Termino'])):null);?>" validate="datatype=shorttime" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codstatus">Status Agendamento:</label></td>
		<td>
            <?	
            $sql  = "SELECT CodStatus ,
            				Descricao
            		   FROM statusagendamento
            		  WHERE CodStatus NOT IN ( 3 , 4 , 5 ,6 )
            	   ORDER BY Descricao" ;
            	   
            combo( $sql , "codstatus" , $agenda['CodStatus'] , " " , "onchange='seminteresse(this.value);'" ) ; 	
            ?>
		</td>
	</tr>
	<tr>
		<th colspan="2">&nbsp;<label for="informacoes">Informação da visita:</label></th>
	</tr>
	<tr>
		<td colspan="2"><textarea cols="55" rows="5" id="informacoes" name="informacoes" style="width:100%" validate="required"><?=$agenda['Informacoes'];?></textarea></td>
	</tr>
    <tr>
			<td colspan="2">
				<div id="seminteresse" style="display: none;">				
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>
						<tr>
							<td align="center" class="topo_grid" colspan="2" >Lead Sem Interesse</td>
						</tr>
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>					
						<tr>
							<td width="155">
								&nbsp;Motivo Sem Interesse
							</td>
							<td>
								<?	
									$sql = "Select m.* ";
									$sql .= " from motivoslead m ";
									$sql .= " Order By m.Descricao ";
									combo($sql, "codmotivolead", $codmotivolead, " ", '');
								?>
							</td>
						</tr>
						<tr>
						<?
							$sql = "Select 
									l.codlead
									,DATE_FORMAT(l.VencimentoContrato, '%Y-%m-%d') as datavencimento
									,qtde_linhas
								  from leads l
								  where l.codlead=".$codlead;
                                  								  
							    $rs = mysql_query($sql);
				                $row_rs = mysql_fetch_array($rs);
				                $dt_vencimento= $row_rs["datavencimento"];
								$qtde_linha= $row_rs["qtde_linhas"];
				                mysql_free_result($rs);
								
								if(!empty($dt_vencimento)){?>								
									<input type="hidden" name="vencimento_contrato" value="<?=$dt_vencimento;?>" />			
								<?}
						?>
							<td>&nbsp;<label for="vencimentocontrato">Vencimento do Contrato:</label></td>
							<td>
								<input type="text" id="vencimentocontrato" name="vencimentocontrato" onKeyPress="mascara(this,datamask)" maxlength="10" size="12" value="<?= $vencimentocontrato;?>" validate="datatype=date" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;<label for="vencimentocontrato">Qtde de Linhas:</label></td>
							<td>
								<input type="text" id="qtde_linhas" name="qtde_linhas" onKeyPress="mascara(this,soNumeros)" maxlength="10" size="12" value="<?=$qtde_linha;?>" />
							</td>
						</tr>	
						<tr>
							<td>&nbsp;<label for="vencimentocontrato">Operadoras contratadas:</label></td>
							<td>
								<? 
									if(!empty($codlead))  $operadoras = leads::operadoras($codlead);									
									(empty($operadoras)? $estilo='visibility:visible;': $estilo='visibility:hidden; position: absolute;');
									
									$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
									$result = sql_query($sql);
									
									$i = 0;
									while($row = mysql_fetch_array($result))
									{
										(!empty($codlead)? (in_array($row['codigo'], $operadoras)? $checado='checked' : $checado='') : $checado='');
										echo "<div style='float:left; padding-right:10px;'>
											  <input type='checkbox' id='operadoras' name='operadoras[]' value='".$row["codigo"]."' ".$checado." />".$row["nome"]."
											  </div>";
										$i++;
									}
									echo "<input type='hidden' id='qtdop' name='qtdop' value='$i'>";
									mysql_free_result($result);	  
								?>
							</td>
						</tr>	
                        <tr>
                            <td colspan="2">
                                &nbsp;
                            </td>
                        </tr>					
					</table>
				</div>
			</td>            
		</tr>
    
	<!--<tr>
		<td>
			&nbsp;<label for="vencimento_contrato">Vencimento do Contrato:</label>
		</td>
		<td>
			<input type="text" id="vencimentocontrato" name="vencimentocontrato" onKeyPress="mascara(this,datamask)" maxlength="10" size="12" value="<?= $vencimentocontrato;?>" validate="datatype=date" />
		</td>
	</tr>-->
	<tr>
		<td colspan="2" align="right">
			<input type="submit" name="enviar" value="Enviar" />
			<input type="reset" name="limpar" value="Limpar" />
			<!--<input type="Button" value="Fechar" onclick="parent.myLytebox.end()">&nbsp;-->
		</td>
	</tr>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
