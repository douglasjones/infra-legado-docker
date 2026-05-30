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
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";

$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$dt_cadastro_lead_ini = $_REQUEST['dt_cadastro_lead_ini'];
$dt_cadastro_lead_fim = $_REQUEST['dt_cadastro_lead_fim'];
$dt_ocorrencia_ini = $_REQUEST['dt_ocorrencia_ini'];
$dt_ocorrencia_fim = $_REQUEST['dt_ocorrencia_fim'];
$mailing_pk = $_REQUEST['mailing_pk'];
$qtdeli_ini = $_REQUEST['qtdeli_ini'];
$qtdeli_fim = $_REQUEST['qtdeli_fim'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];

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
<script>
	function abrirOC(v_codlead){
		NewWindow('../../vendas/leads/leadhistoricoocorrencia.php?codlead='+v_codlead,800,600);
	}
</script>
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
<br>
<?
}
?>
<table>
	<tr>
		<td class="form"><font size="4">Leads Contactados</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
				Relatório gerado em <?
							$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') data_geracao ";
							$rs_geracao = mysql_query($sql);
							$row_geracao = mysql_fetch_array($rs_geracao);
							echo $row_geracao['data_geracao'];
							mysql_free_result($rs_geracao);
						    ?>
		</td>
	</tr>	
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			<?
			
			if(!empty($dt_cadastro_lead_ini) || !empty($dt_cadastro_lead_fim)){
				echo "Data Cadastro Lead: ".$dt_cadastro_lead_ini." à ".$dt_cadastro_lead_fim;
			}
			
			if(!empty($dt_ocorrencia_ini) || !empty($dt_ocorrencia_fim)){
				echo "Data Ocorrência: ".$dt_ocorrencia_ini." à ".$dt_ocorrencia_fim;
			}
						
			if(!empty($codgerenteconta)){
			?>
			Consultor: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?><br>
			<?if(!empty($codatendente)){?>
			Atendente:
			<?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?>
			<br>
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

			<br>

		</td>
	</tr>
</table>
<?

$sql ="";
$sql.="select codusuariointerno, nome ";
$sql.="  from usuariosinternos ui ";
$sql.=" where desativado = -1 ";
$sql.="   and atendente = 1  ";
if(!empty($codatendente))
	$sql.=" and ui.codusuariointerno = $codatendente ";
$sql.=" order by nome ";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){
	
	echo "<br>";
	echo "<font size=4 face=arial>".$row['nome']."</font><br>";
	
?>
<table width="90%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<thead>
	<tr>
        <th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
                Lead
        </th>
        <th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
                Endereço
        </th>
        <th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
                Cidade
        </th>
    	<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Status
		</th>    
        <th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Qtde Linha(s)
		</th>
		<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Qtde Ocorrências
		</th>		
	</tr>
	</thead>
	<tbody>
		<?
		
		$total_empresas = 0;
		$total_oc = 0;
		
		$sql ="";
		$sql.="select l.codlead,l.qtde_linhas, l.razaosocial, count(0) total, sc.descricao, l.endereco, l.cidade ";
		$sql.="  from leads l ";
		$sql.="       inner join ocorrenciaslead oc on l.codlead = oc.codlead ";
        $sql.="       inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.codstatusclassificacaolead ";
		$sql.=" where oc.datacadastro between '".DataYMD($dt_ocorrencia_ini)." 00:00:00' and '".DataYMD($dt_ocorrencia_fim)." 23:59:59' ";
		$sql.="   and oc.codusuariointerno = ".$row['codusuariointerno'];

		if(!permissao('visualizar_todos_atendentes', 'cs'))
			$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		
		if(!empty($dt_cadastro_lead_ini))
			$sql.=" and l.datacadastro >= '".DataYMD($dt_cadastro_lead_ini)." 00:00:00' ";
			
		if(!empty($dt_cadastro_lead_fim))
			$sql.=" and l.datacadastro <= '".DataYMD($dt_cadastro_lead_fim)." 23:59:59' ";			
			
		if(!empty($dt_ocorrencia_ini))
			$sql.=" and oc.datacadastro >= '".DataYMD($dt_ocorrencia_ini)." 00:00:00' ";
			
		if(!empty($dt_ocorrencia_fim))
			$sql.=" and oc.datacadastro <= '".DataYMD($dt_ocorrencia_fim)." 23:59:59' ";						
			

		if(!empty($mailing_pk))
			$sql.=" and l.mailing_pk = ".$mailing_pk;
			
		if(!empty($codgerenteconta))
			$sql.=" and l.codgerenteconta = $codgerenteconta ";
			
        if(!empty($qtdeli_ini) && !empty($qtdeli_fim)){
			$sql.=" and l.qtde_linhas >=".$qtdeli_ini;
			$sql.=" and l.qtde_linhas <= ".$qtdeli_fim;
        }
        
        if(!empty($codstatusclassificacaolead))
            $sql.= " and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
        

        
		$sql.=" group by l.codlead, l.razaosocial ";
		$sql.=" order by 3, 2 ";
		                
		$rs = mysql_query($sql);
		while($row_oc = mysql_fetch_array($rs)){
			echo "<tr>";
			echo "<td class='form'>".$row_oc['razaosocial']."</td>";
                        echo "<td class='form'>".$row_oc['endereco']."</td>";
                        echo "<td class='form'>".$row_oc['cidade']."</td>";
                        echo "<td class='form' align='center'>".$row_oc['descricao']."</td>";
                        echo "<td class='form' align='center'>".$row_oc['qtde_linhas']."</td>";
			echo "<td class='form' align='center'><a href='javascript:abrirOC(".$row_oc['codlead'].")' >".$row_oc['total']."</a></td>";
			echo "</tr>";
			
			$total_empresas ++;
			$total_oc += $row_oc['total'];
			
		}
		mysql_free_result($rs);
		?>
    </tbody>
    <tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Total Empresas: <?=$total_empresas;?>
		</th>
        
        <th class="titulo" colspan="4" bgcolor="#8080FF">
            &nbsp;
		</th>        
		<th class="titulo" bgcolor="#8080FF">
			<?= $total_oc;?>
		</th>			
	</tr>
	</tfoot>
</table>
<?
}
?>
</body>
<?
include_once "../../libs/desconectar.php";
?>



