<?
    /*
Pagina:leadocorrenciadet.php
modulo:Vendas
submodulo: Ocorrencias / Detalhes da Ocorrência

Dados de criação
Criação:
Empresa:
Executor

Histórico das Revisões:
 Criação: 26/06/2008
 Empresa:
 Executor RINALDO PELIGRINELI

Histórico de Auditorias:
 Criação: 16/04/2008
 Empresa:
 Executor FELIPE SANTOS
 */

/*
 Includes
*/

    include_once "../../libs/maininclude.php";

		$sql = "SELECT   	a.codagendalead ,
							ui.nome operador ,
							ui1.nome consultor ,
							DATE_FORMAT(a.datahorario,'%d/%m/%Y') data ,
							DATE_FORMAT(a.datahorario,'%H:%i') hora ,
							l.razaosocial,
							cl.nomecontato ,
							cl.cel ,
							cl.email ,
							l.tel ,
							l.endereco ,
							l.numero ,
							l.complemento ,
							l.bairro ,
							l.cep ,
							l.cidade ,
							l.PontoRef
				FROM     	agendaslead a
				LEFT JOIN 	usuariosinternos ui
				ON       	a.codusuariointerno = ui.codusuariointerno
				LEFT JOIN 	agendagerenteconta ag
				ON        	a.codagendalead = ag.codagendalead
				LEFT JOIN 	usuariosinternos ui1
				ON       	ag.codgerenteconta = ui1.codusuariointerno
				LEFT JOIN 	leads l
				ON       	a.codlead = l.codlead
				LEFT JOIN 	contatoslead cl
				ON       	a.codcontatolead =  cl.codcontatolead
				WHERE    	a.codagendalead =".$_REQUEST['codagendalead'] ;

	/*$sql = "";
	$sql .= "Select a.codagendalead, ui.nome operador, ui1.nome consultor, DATE_FORMAT(a.datahorario,'%d/%m/%Y') data, DATE_FORMAT(a.datahorario,'%H:%i') hora,";
	$sql .= " l.razaosocial, cl.nomecontato, cl.cel, cl.email, l.tel, pre.cnpj, l.endereco, l.numero, l.complemento, l.bairro, l.cep, l.cidade, pre.plano_corp, pre.tempo,";
	$sql .= " l.PontoRef,";
	$sql .= " op.dsc_operadora, pre.qtd_linhas quantidade, DATE_FORMAT(pre.dat_troca_aparelho,'%d/%m/%Y') data_troca, pre.consumo_celular, pre.consumo_fixo";
	$sql .= " from agendaslead a";
	$sql .= " left join usuariosinternos ui on a.codusuariointerno = ui.codusuariointerno";
	$sql .= " left join agendagerenteconta ag on a.codagendalead = ag.codagendalead";
	$sql .= " left join usuariosinternos ui1 on ag.codgerenteconta = ui1.codusuariointerno";
	$sql .= " inner join leads l on a.codlead = l.codlead";
	$sql .= " left join contatoslead cl on a.codcontatolead =  cl.codcontatolead";
	$sql .= " inner join preagendamento pre on a.codagendalead = pre.codagendalead";
	$sql .= " left join operadoras op on pre.operadora = op.cod_operadora";
	$sql .= " where a.codagendalead =".$_REQUEST['codagendalead'];
	*/
	
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
   <!--Include CSS-->
   <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Formulário</title>
<?	include_once "../../libs/head.php";?>
</head>

<script>
	function Imprimir(){
		//reseta as alterações de FONTE!
		//resetaCorpo();
		
		window.print();
	}

</script>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="formulario" name="formulario" method="post" />
<table width="650"  align="center" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<td align=left width="50%">			
			&nbsp;<img src='../../imagens/logo_claro.png'>
		</td>
		<td align="right">
			<img src='../../imagens/logo_ok.png' >
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	   
	<tr>
		<td width="90"><b><label for="operador">Operador:</label></b></td>
		<td width="150"> <?=$row['operador'];?> </td>
		<td width="100"><b><label for="consultor">Consultor:</label></b></td>
		<td > <?=$row['consultor'];?> </td>
	</tr>
</table>	
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td width="130"><b><label for="datavisita">Data da Visita:</label></b></td>
		<td width="110"> <?=$row['data'];?> </td>
		<td width="100"><b><label for="horario">Horário:</label></b></td>
		<td> <?=$row['hora'];?> </td>

	</tr>
</table>	
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr>
		<td width="90"><b><label for="razaosocial">Razão Social:</label></b></td>
		<td collspan="3">&nbsp;<?=$row['razaosocial'];?></td>

	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td width="90"><b><label for="responsavel">Responsável:</label></b></td>
        <td width="150">&nbsp;<?=$row['nomecontato'];?></td>
	</tr>	
</table>	
<table width="650"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr> 
		<td width="90"><b><label for="tel">Telefone:</label></b> </td>
<?	/*	if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){?>
		<td width="150">[[restrito]]</td>
<? 		}else{*/?>
		<td width="150"> <?=$row['tel'];?> </td>
<?	/*	}*/?>
		<td width="100"><b><label for="cel">Celular:</label></b></td>
<?	/*	if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){?>
		<td>[[restrito]]</td>
<? 		}else{*/?>
		<td> <?=$row['cel'];?></td>
<?	/*	}*/?>
	    <td width="80"><b><label for="email">E-mail:</label></b></td>
<?	/*	if($GerenteContas && $_SESSION['codusuario'] != $lead['CodGerenteConta'] && !permissao('leadoutrogerente', 'al')){?>
		<td>[[restrito]]</td>
<? 		}else{*/?>
	    <td> <?=$row['email'];?></td>
<?	/*	}*/?>
    </tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
   <tr>
	  <td width="90"><b><label for="endereco">Endereço:</label></b></td>
	  <td width="150"> <?=$row['endereco'];?></td>
	  <td width="100"><b><label for="numero">Número:</label></b></td>
	  <td> <?=$row['numero'];?> </td>
	  <td width="80"><b><label for="complemento">Complemento:</label></b></td>
	  <td> <?=$row['complemento'];?></td>
	</tr>
</table>	
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr> 
		<td width="90"><b><label for="bairro">Bairro:</label></b></td>
		<td width="150"> <?=$row['bairro'];?></td>
	    <td width="100"><b><label for="cep">CEP:</label></b></td>
	    <td> <?=$row['cep'];?></td>
		<td width="80"><b><label for="cidade">Cidade:</label></b></td>
	    <td> <?=$row['cidade'];?></td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr> 
		<td width="100"><b><label for="pontoref">Ponto de Referência:</label></b></td>
		<td width="320"> <?=$row['PontoRef'];?></td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
	<!--<tr>
		<td width="190"><b><label for="cnpj">CNPJ (+ 6 meses) :</label><b></td>
        <td width="50"> 		< ?
		if ($row['cnpj']) echo "SIM";
		else echo "NÃO";
		?></td>
		<td width="160"><b><label for="plano_corp">Possui Plano Corporativo:</label></b></td>
		<td width="50">
		< ?
		if($row['plano_corp']) echo "SIM";
		else echo "NÃO";
		?>
		</td>
		<td width="130"><b><label for="qtde_tempo">Há Quanto Tempo:</label></b></td>
		<td>< ?=$row['tempo'];?></td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">		
	<tr>
		<td width="130"><b><label for="operadora">Qual Operadora:</label></b></td>
		<td collspan="3">< ?=$row['dsc_operadora'];?> <td/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">		
	<tr>
		<td width="190"><b><label for="linhas_celular">Qtde. Linhas Celular:</label></b></td>
		<td width="80"> < ?=$row['quantidade'];?> </td>
	    <td width="190"><b><label for="data_troca">Dt.Ult.Troca de Apar.:</label></b></td>
	    <td> < ?=$row['data_troca'];?>  </td>	
	</tr>
</table> 
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">		
   <tr>
		<td width="210"><b><label for="consumo_fixo">Consumo de Fixo para Celular:</label></b></td>
		<td width="60"> < ?=$row['consumo_fixo'];?> </td> -
		<td width="210"><b><label for="consumo_celular">Consumo de Celular em R$:</label></b></td>
		<td> < ?=$row['consumo_celular'];?> </td>	
   </tr>
  </table> -->
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	 
    <tr>
		<td>&nbsp;</td>
		<td>&nbsp; </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td>&nbsp; </td>
		<td>&nbsp;</td>			
   </tr> 
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">	 
  <!-- <tr>
		<td collspan=3> <label for="motivo_agendamento"> &nbsp;<b> Motivos Agendamento: </b></label> </td>
   </tr> 
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>  
	<tr>
		<td>
	   < ?
	   	mysql_free_result($result);

           	$sql ="";
			$sql .= "Select mpp.cod_motivo_preagendamento,mpp.dsc_motivo_preagendamento";
			$sql .= " from agendaslead a";
			$sql .= " left join preagendamento p on a.codagendalead = p.codagendalead";
			$sql .= " left join motivos_preagendamento mp on p.codpreagendamento = mp.cod_preagendamento";
			$sql .= " left join motivo_preagendamento mpp on mp.cod_motivo_preagendamento = mpp.cod_motivo_preagendamento";
			$sql .= " where a.codagendalead= " . $_REQUEST['codagendalead'];
			$result = mysql_query($sql) or die (mysql_error());
			while($rs = mysql_fetch_array($result)){
			?>
			&nbsp;<input type="checkbox" checked disabled id="motivo_agendamento" name="motivo_agendamento" value="<?=$rs['cod_motivo_preagendamento'];?>">&nbsp;<?=$rs['dsc_motivo_preagendamento'];?><br>
			< ? }? >  
		</td>-->
	</tr>
   <tr>
		<td collspan=3> <label for="nada"> <b>&nbsp; </b></label> </td>
   </tr>  	
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">
			<label for="detalhes"> &nbsp;<b>DETALHE AS TRATATIVAS DA VISITA E NEGOCIAÇÃO (Preenchimento obrigatório):</b></label>
		</td>
	</tr>
</table>	
<table width="650"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td width="100">
			&nbsp;<label focr="qtdelinha">Qde de linhas:</label>
		</td>
		<td width="110" align="left">
			________________			
		</td>
		<td width="45">
			&nbsp;<label for="plano">Plano:</label>
		</td>
		<td width="100"align="left">
			_____________________			
		</td>
		<td width="130">
			&nbsp;<label focr="valorproposta">Valor da Proposta: R$ </label>
		</td>
		<td align="left">
			_________________________
		</td>
	</tr>

</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td >
			&nbsp;<label for="modulos">Módulos: (   ) Gestor online  (   ) Tarifa Zero  (   )   Claro Direto   (    ) Dados __________________________</label>
		</td>
	</tr>
</table>	
<table width="650"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="modulos">Fechamento:  (    ) 25%  (    ) 50%   (     ) 75%    (     ) 100%</label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="obs"><b>OBS: (Retorno e motivos das tratativas)</b></label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td>
			&nbsp;_______________________________________________________________________________________________
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;_______________________________________________________________________________________________
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;_______________________________________________________________________________________________
		</td>
	</tr>
<table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="motivosreagendamento"><b>Motivos de reagendamento: </b></label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="ausente">(   ) Ausente        (   ) Não Disponível       (   ) Consultor não compareceu       (   ) Atraso do consultor  </label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="data">Data de Retorno:  _____/ _____ / _____</label>      
		</td>
		<td>
			&nbsp;<label for="hora">Hora: ____________________</label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="fechamento"><b>Motivos de não fechamento/sem interesse:</b></label>      
		</td>
	</tr>
</table>
<table width="650"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="multa">(  )&nbsp;Multa da concorrência&nbsp;&nbsp;&nbsp;(  )&nbsp;Manter o N° Celular&nbsp;&nbsp;&nbsp;(  )&nbsp;Restrição no CNPJ/CPF		</label>      
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="recepcao">(  )&nbsp;Recepção de Sinal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(  )&nbsp;Consome pouco&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(  )&nbsp;Aparelhos ( Não tem no portfolio )</label>      
		</td>
	</tr>
	<tr>	
		<td>
			&nbsp;<label for="desacordo">(  )&nbsp;Desacordo entre sócios&nbsp;(  )&nbsp;Outros: Especificar:  ______________________________________</label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="fechamento"><b>Problemas de agendamento:</b></label>      
		</td>
	</tr>
</table>
<table width="650"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
		<td collspan="4">&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="multa">(   )&nbsp;Não agendou&nbsp;&nbsp;&nbsp;(    )&nbsp;Não agendou com responsável&nbsp;&nbsp;&nbsp;   (    )&nbsp;Insistência da operadora&nbsp;&nbsp;&nbsp;  (   )&nbsp;Dados incorretos

</label>      
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="recepcao">(   )&nbsp;Consumo abaixo de R$200,00&nbsp;&nbsp;&nbsp;(    )&nbsp;Plano em Vigência&nbsp;&nbsp;&nbsp; (    )&nbsp;Uso de termo indevido 

</label>      
		</td>
	</tr>
</table>
  </form>	
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
