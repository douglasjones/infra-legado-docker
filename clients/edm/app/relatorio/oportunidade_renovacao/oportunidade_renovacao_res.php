<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.equipes.php";
include_once "../../libs/datas.php";

$cod_polo = $_REQUEST['cod_polo'];
$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$cod_operadora = $_REQUEST['cod_operadora'];
$vencimentocontratode = $_REQUEST['vencimentocontratode'];
$vencimentocontratoate = $_REQUEST['vencimentocontratoate'];
$qtde_dias = $_REQUEST['qtde_dias'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$cidade = $_REQUEST['cidade'];
$codstatusclassificacaolead_pk = "";




$acao = 'cs';
if(!(($acao == 'cs' && permissao('vencimento_contratos_pesq.php', 'cs')) || ($acao == 'upd' && permissao('vencimento_contratos_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

?>
<html>
<head>
<!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}
?>
</head>
<!--HTML-->
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<?
}
?>
<table align="center">
	<tr>
		<td class="form"><font size="4">Relatório de Renovações</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			
			<?if(!empty($cod_polo)){			?>
			Pólo: <?
				$sql = "select n_polo from polo where cod_polo = $cod_polo ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['n_polo'];
				mysql_free_result($result);
				echo "<br>";				
			}?>
			<?
			if(!empty($vencimentocontratode)){
				echo "Data Vencimento Contrato maior ou igual a $vencimentocontratode ";
				echo "<br>";
			}
			?>
			<?
			if(!empty($vencimentocontratoate)){
				echo "Data Vencimento Contrato menor ou igual a $vencimentocontratoate ";
				echo "<br>";				
			}
			?>
			<?		
			if(!empty($codgerenteconta)){
			?>
			Consultor: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
				echo "<br>";				
			}?>
			<?
			if($codgerenteconta == "0"){
				echo "Consultor: Nenhum ";
				echo "<br>";
			}
			?>
			<?if(!empty($codatendente)){?>
			Atendente:
			<?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);			
				echo "<br>";				
			}?>
			<?
			if($codatendente == "0"){
				echo "Atendente: Nenhum ";
				echo "<br>";				
			}
			?>
			<?if (!empty($cod_operadora)){?>
			Operadora:
			<?
				$sql = "select dsc_operadora from operadoras where cod_operadora = $cod_operadora ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['dsc_operadora'];
				mysql_free_result($result);
				echo "<br>";				
			}
			?>
			<?if(count($codstatusclassificacaolead)>0){?>
			Status:
			<?
				$sql = "select descricao from statusclassificacaolead where codstatusclassificacaolead in ( ";
				for($i = 0; $i<count($codstatusclassificacaolead);$i++){
					$sql.=$codstatusclassificacaolead[$i].", ";
					$codstatusclassificacaolead_pk.=$codstatusclassificacaolead[$i].", ";
				}
				$sql.="0) ";
				$codstatusclassificacaolead_pk.="0";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
					echo $row['descricao']."; ";
				mysql_free_result($result);			
				echo "<br>";
			}?>
			<?
			if(!empty($qtde_dias)){
				echo "Qtde Dias Ult. Ocorrência: $qtde_dias ";
				echo "<br>";				
			}
			?>
			<?
			if(!empty($cidade)){
				echo "Cidade: $cidade ";
				echo "<br>";				
			}
			?>			
		</td>
	</tr>
</table>
<br>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<thead>
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Pólo
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Consultor
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Atendente
		</th>	
		<th class="titulo" bgcolor="#8080FF">
			Cód. Cliente
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Razão Social
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Data Vencimento
		</th>
     
		<th class="titulo" bgcolor="#8080FF">
			Operadora
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Dt. Ult. Ocorrência
		</th>		
	</tr>
	</thead>
	<tbody>
<?
$where = "";
	if(!empty($_REQUEST['cod_polo']))
		$where.=" and l.cod_polo =". $_REQUEST['cod_polo'];
		
	if(!empty($cod_operadora)){
		$where.=" and l.codlead in (";
		$where.="  select lo.codlead ";
		$where.="    from leads_operadoras lo ";
		$where.="   where lo.cod_operadora = $cod_operadora ";
		$where.=" ) ";
	}
	
	if(!empty($codatendente)){
		$where.= " and l.codatendente = $codatendente ";
	}
	
	if(!empty($codgerenteconta)){
		$where.=" and l.codgerenteconta = $codgerenteconta ";
	}
	
	if($codgerenteconta == "0"){
		$where.=" and l.codgerenteconta is null ";
	}
	
	if($codatendente == "0"){
		$where.=" and l.codatendente is null ";
	}
	
	if($codstatusclassificacaolead_pk!=""){
		$where.=" and l.codstatusclassificacaolead in (".$codstatusclassificacaolead_pk.") ";
	}
	
	if(!empty($vencimentocontratode))
		$where.=" and l.vencimentocontrato >= '".DataYMD($vencimentocontratode)." 00:00:00' ";
	
	if(!empty($vencimentocontratoate))
		$where.=" and l.vencimentocontrato <= '".DataYMD($vencimentocontratoate)." 23:59:59' ";
		
	if(!empty($cidade))
		$where.=" and cidade like '%".$cidade."%' ";
		
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$where.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$where.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";

	$sql = "Select 
				pl.n_polo
				,ui.Nome consultor
				,ui1.nome atendente
				,l.codlead 
				,l.razaosocial
				 ,date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato				
				,p.pk codproposta
			from leads l 
				 LEFT JOIN n_propostas p ON l.CodLead = p.leads_pk
                LEFT JOIN n_datas_proposta dp  ON     p.pk = dp.propostas_pk  AND dp.data_proposta_operador_pk =15
                LEFT JOIN polo pl ON l.cod_polo = pl.cod_polo 
                LEFT JOIN usuariosinternos ui  ON l.CodGerenteConta = ui.CodUsuarioInterno
                LEFT JOIN usuariosinternos ui1 ON l.CodAtendente = ui.CodUsuarioInterno		
			where 1=1 ";
	$sql.=$where;
	$sql.=" group by l.codlead";
	
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		echo "<tr>";
		echo "<td align='center' class='form'>&nbsp;".$row['n_polo']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['consultor']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['atendente']."&nbsp;</td>";
		echo "<td align='center' class='form'>".$row['codlead']."</td>";
		echo "<td align='center' class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td align='center' class='form'>&nbsp;".$row['vencimentocontrato']."&nbsp;</td>";	
		echo "<td align='center' class='form'>&nbsp;";
		
		//pesquisa todas as operadoras do lead
		$sql ="";
		$sql.="select o.dsc_operadora ";
		$sql.="  from leads_operadoras lo ";
		$sql.="       inner join operadoras o on o.cod_operadora = lo.cod_operadora ";
		$sql.=" where lo.codlead = ".$row['codlead'];
		$rs_operadora = mysql_query($sql);
		while($row_operadora = mysql_fetch_array($rs_operadora)){
			echo $row_operadora['dsc_operadora']."<br>";
		}
		mysql_free_result($rs_operadora);
		echo "&nbsp;</td>";
		
		$sql = "Select 
				 date_format(max(oc.datacadastro), '%d/%m/%Y %H:%i:%s') ultcontato
				from ocorrenciaslead oc" ;
		$sql.=" where codlead=".$row['codlead'];

		

		$ocorrencia = sql_query($sql);
		  if($row_ocorrencia = mysql_fetch_array($ocorrencia)){
			$ultcontato = $row_ocorrencia['ultcontato'];
		  }
		
		echo "<td align='center' class='form'>&nbsp;".$ultcontato."&nbsp;</td>";
		echo "</tr>";
		$total ++;
	}
?>
	</tbody>
	<tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="10">
			<?= $total;?> registro(s)
		</th>
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>



