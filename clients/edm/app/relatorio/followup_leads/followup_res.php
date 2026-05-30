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
$tipo_pessoa = $_REQUEST["tipo_pessoa"];
$bairro = $_REQUEST['bairro'];
$mailing_pk = $_REQUEST['mailing_pk'];
$cod_campanha = $_REQUEST['cod_campanha'];
$qtdeli_ini = $_REQUEST['qtdeli_ini'];
$qtdeli_fim = $_REQUEST['qtdeli_fim'];
$codequipe = $_REQUEST['codequipe'];

$acao = 'cs';
if(!(($acao == 'cs' && permissao('relfollowupleadspesq.php', 'cs')) || ($acao == 'upd' && permissao('relfollowupleadspesq.php', 'al')))){
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
		<td class="form"><font size="4">Follow-up Leads</font></td>
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
            <?if(!empty($tipo_pessoa)){            ?>
            Tipo Pessoa: <?
            	echo $tipo_pessoa;
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
		<?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?>
			<?if (!empty($cod_campanha)){?>
			Campanha:
			<?
				$sql = "select nome_campanha from campanha where cod_campanha =  $cod_campanha ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome_campanha'];
				mysql_free_result($result);
				echo "<br>";				
			}
			?>            
			<?if (!empty($bairro)){?>
			Bairro:
			<?
                echo $bairro;
				echo "<br>";				
			}
			?>
            <?if (!empty($qtdeli_ini) && !empty($qtdeli_fim) ){?>
			Qtde Linhas:
			<?
               echo "De&nbsp;". $qtdeli_ini ."&nbsp;Até&nbsp;". $qtdeli_fim;
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
			Status
		</th>		
       <th class="titulo" bgcolor="#8080FF">
			Equipe
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Cód. Cliente
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Razão Social
		</th>	
		<th class="titulo" bgcolor="#8080FF">
			Bairro
		</th>	        	
		<th class="titulo" bgcolor="#8080FF">
			Data Vencimento
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Mailing
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Operadora
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Qtde Linha(s)
		</th>	        		
		<th class="titulo" bgcolor="#8080FF">
			Dt. Ult. Ocorrência
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Qtde Dias Ult. Ocorrência
		</th>		
		
	</tr>
	</thead>
	<tbody>
<?	
	//Efetua o calculo da data de corte
	if($qtde_dias <> ""){
		$sql ="SELECT date_format(DATE_ADD(sysdate(), INTERVAL -".$qtde_dias." DAY),'%Y-%m-%d') dt_fim ";
	}
	else{
		$sql ="SELECT date_format(sysdate(),'%Y-%m-%d') dt_fim ";
	}
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$dt_fim = $row['dt_fim'];
	mysql_free_result($result);
	
	$total = 0;
	
	$sql ="";
	$sql.="select l.codlead, l.razaosocial, l.bairro, m.dsc_mailing mailing, l.qtde_linhas, l.dt_ult_ocorrencia, date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato, date_format(l.dt_ult_ocorrencia, '%d/%m/%Y %H:%i:%s') ultcontato, DATEDIFF(sysdate(), l.dt_ult_ocorrencia) qtde_dias,tbe.Vc_Nome Equipe, ";
	$sql.="       ui.nome consultor, ui1.nome atendente, scl.descricao status, p.n_polo ";
	$sql.="  from leads l  ";
	$sql.="	      inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
	$sql.="	       left join polo p on l.cod_polo = p.cod_polo ";
	$sql.="	       left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
	$sql.="	       left join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno ";
	$sql.=" 	   left join mailing m on l.mailing_pk = m.pk ";
    $sql.="        LEFT JOIN tb_usuarioequipe tbu ON ui.CodUsuarioInterno = tbu.Fk_Usuario";
    $sql.="        left JOIN tb_equipesvendas tbe ON tbu.Fk_Equipe = tbe.Tk_Equipe";
	$sql.=" where 1=1 ";
	
	if(!empty($qtdeli_ini) && !empty($qtdeli_fim)){
			$sql.=" and l.qtde_linhas >=".$qtdeli_ini;
			$sql.=" and l.qtde_linhas <= ".$qtdeli_fim;
	}
	
	if($cod_operadora > 0){
		$sql.=" and l.codlead in (";
		$sql.="  select lo.codlead ";
		$sql.="    from leads_operadoras lo ";
		$sql.="   where lo.cod_operadora = $cod_operadora ";
		$sql.=" ) ";
	}
	
   	if(!empty($mailing_pk)){
   		$sql.=" and l.mailing_pk =".$mailing_pk;
   	}
   	
	if(!empty($bairro)){
		$sql.=" and l.bairro like '%".$bairro."%' ";
	}
	
	if(!empty($vencimentocontratode))
		$sql.=" and l.vencimentocontrato >= '".DataYMD($vencimentocontratode)." 00:00:00' ";
	
	if(!empty($vencimentocontratoate))
		$sql.=" and l.vencimentocontrato <= '".DataYMD($vencimentocontratoate)." 23:59:59' ";
	
	if(!empty($cidade))
		$sql.=" and l.cidade like '%".$cidade."%' ";
	
	if(!empty($tipo_pessoa))
		$sql.=" and l.tipo_pessoa = '".$tipo_pessoa."' ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	
	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and ui1.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";	
	
	if($codgerenteconta == "0"){
		$sql.=" and l.codgerenteconta is null ";
	}
	if($codgerenteconta > 0){
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	}
	
	if($codatendente == "0"){
		$sql.=" and l.codatendente is null ";
	}
	if($codatendente > 0 ){
		$sql.=" and ui1.codusuariointerno = $codatendente ";
	}
	
	if(!empty($cod_polo))
		$sql.=" and l.cod_polo =".$cod_polo." ";
	
	if($codstatusclassificacaolead_pk!=""){
		$sql.=" and l.codstatusclassificacaolead in (".$codstatusclassificacaolead_pk.") ";
	}
	
	if(!empty($cod_campanha))
		$sql.=" and l.codlead in (select codlead from campanha_leads where cod_campanha =  $cod_campanha) " ;	
	    
    
	$sql.="  and l.dt_ult_ocorrencia <= '".$dt_fim." 23:59:59' order by 9 desc ";
	
     if(!empty($codequipe)){
		$sql.="  and ui.codusuariointerno in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}

    

    
    
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	while($row = mysql_fetch_array($result)){
		
		echo "<tr>";
		echo "<td align='center' class='form'>&nbsp;".$row['n_polo']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['consultor']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['atendente']."&nbsp;</td>";
        echo "<td align='center' class='form'>&nbsp;".$row['Equipe']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['status']."&nbsp;</td>";
		echo "<td align='center' class='form'>".$row['codlead']."</td>";
		echo "<td align='center' class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td align='center' class='form'>&nbsp;".$row['bairro']."&nbsp;</td>";
        	echo "<td align='center' class='form'>&nbsp;".$row['vencimentocontrato']."&nbsp;</td>";
        	echo "<td align='center' class='form'>&nbsp;".$row['mailing']."&nbsp;</td>";
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
		//fim da pesquisa por operadora.
		
		echo "&nbsp;</td>";
        	echo "<td align='center' class='form'>&nbsp;".$row['qtde_linhas']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['ultcontato']."&nbsp;</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['qtde_dias']."&nbsp;</td>";
		echo "</tr>";
		
		$total ++;
		if($total == 5000){
			break;
		}
	}
	mysql_free_result($result);
?>
	</tbody>
	<tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="14">
			<?
			
			if ($num > $total){
				echo $num." registro(s) - Serão exibidos somente os 5000 primeiros ";
			}
			else{
				echo $total." registro(s)";
			}
			?>
		</th>
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>



