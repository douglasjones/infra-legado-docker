<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

$cod_empresa = $_SESSSION['cod_empresa'];
	
$excel = $_REQUEST['excel'];
$datarecebimentode = $_REQUEST['datarecebimentode'];
$datarecebimentoate = $_REQUEST['datarecebimentoate'];
$cod_polo = $_REQUEST['cod_polo'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$pendencia = $_REQUEST['pendencia'];

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";

?>
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?
if($excel != "S"){
?>    
	<title>Acompanhamento de Processo</title>
	<?	include_once "../../libs/head.php";?>
	<script src="../../extras/tabela.js"></script>
<?
}
?>	
	<script>
		function exportar_xls(){
			window.open(location.href+"&excel=S");
		}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
	<a name="link_excel" id="link_excel" href='javascript:exportar_xls();' title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
	<br>
<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Acompanhamento de Processo</font>
	</td>
</tr>
</table>
<br>
<br>
<table width="100%"   align="center" border="0" cellpadding="2" cellspacing="0" class="form">
	<tr>
		<td class="parametros">
			Parâmetros:
		</td>
	</tr>	
	<tr>
		<td class="parametros">
				Relatório gerado em <?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>	
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?	
			if(!empty($datarecebimentode) && !empty($datarecebimentoate)){?>
			<dt>Data de Recebimento da Assinatura: <?=$_REQUEST['datarecebimentode'];?> - <?=$_REQUEST['datarecebimentoate'];?></dt>
			<?	
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($cod_polo)){
			$sql = "Select n_polo  from polo p";
			$sql .= " where cod_polo=".$cod_polo;
			
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codgerenteconta)){
			$sql = "Select codusuariointerno, nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
			
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Consultor: ".$polo['nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?
		if(!empty($codatendente)){
			$sql = "Select codusuariointerno, nome from usuariosinternos where codusuariointerno = $codatendente ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Atendente: ".$polo['nome'];
		}
		?>
		</td>
	</tr>			
</table>
<br>
<br>
<?
$sql ="";
$sql.="select eo.cod_operador, o.dsc_operador ";
$sql.="  from empresa e ";
$sql.="       inner join empresa_operador eo on e.cod_empresa = eo.cod_empresa ";
$sql.="       inner join operador o on eo.cod_operador = o.cod_operador ";
if(!empty($cod_empresa)){
	$sql.=" where e.cod_empresa = ".$cod_empresa;
}
	
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){

$total_valor = 0;
$total_linhas = 0;

?>
<table width="100%"   align="center" border="0" cellpadding="2" cellspacing="0" class="form">
	<tr>
		<td class="parametros">
			<?= $row['dsc_operador']?>
		</td>
	</tr>	
</table>
<table cellspacing="0" cellpadding="0" align="center" border="1" width="3000">	
	<thead>
		<tr>
			<th align='center' class='titulo' bgcolor='#8080FF'>Consultor</th>
			<th align='center' class='titulo' bgcolor='#8080FF'>Atendente</th>
			<th align='center' class='titulo' bgcolor='#8080FF'>Razão Social</th>
			<th align='center' class='titulo' bgcolor='#8080FF'>Valor</th>
			<th align='center' class='titulo' bgcolor='#8080FF'>Qtde. Linhas</th>
			<?
			$total_datas = 0;
			// monta o cabeçalho com as datas
			$sql ="";
			$sql.="SELECT ndpo.pk, ndpo.ds_label_data,ndpo.ds_data
                    FROM n_data_proposta_operador ndpo
                   WHERE ndpo.operador_pk =".$row['cod_operador'];
            $sql.=" AND ndpo.dt_cancelamento IS NULL
                  ORDER BY ndpo.n_ordem";
			$result_data = mysql_query($sql);
			while($row_data = mysql_fetch_array($result_data)){
				echo "<th align='center' class='titulo' bgcolor='#8080FF'>";
				echo str_replace(":","",$row_data['ds_data']);
				$arrDatas[$row_data['ds_data']] = "";
				echo "</th>";
				$total_datas ++;
			}
			mysql_free_result($result_data);
			?>
		</tr>
	</thead>
	<tbody>
	
	<?
        $sql ="";
        $sql.="SELECT np.pk,
                        l.codlead,
                        l.razaosocial,
                        npr.ds_produto,
                        u.nome nomegerenteconta,
                        u1.nome atendente,
                        ndpo.pk data_pk
                   FROM n_propostas np
                        INNER JOIN leads l ON np.leads_pk = l.codlead
                        INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                        INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                        INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                        INNER JOIN n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk
                        LEFT JOIN usuariosinternos u
                           ON u.codusuariointerno = l.codgerenteconta
                        LEFT JOIN usuariosinternos u1 ON u1.codusuariointerno = l.codatendente
                  WHERE     np.dt_cancelamento IS NULL";
        $sql.="         AND np.operador_pk =".$row[cod_operador];
        $sql.="                AND ndp.vl_data_proposta >='".DataYMD($datarecebimentode)." 00:00:00'";
        $sql.="                AND ndp.vl_data_proposta <='".DataYMD($datarecebimentoate)." 23:59:59'";
        $sql.="                AND ndpo.statusclassificacaolead_pk=6";
                    
        if(!empty($cod_polo))
            $sql.=" and l.cod_polo = $cod_polo ";

        if(!empty($codgerenteconta))
            $sql.=" and l.codgerenteconta = $codgerenteconta ";

        if(!empty($codatendente))
            $sql.=" and l.codatendente = $codatendente ";


        if(!permissao('visualizar_todos_consultores', 'cs'))
            $sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";


        if(!empty($pendencia))
            $sql.=" and concat(codproposta,'-',versao) not in (select concat(codproposta,'-',versao) codigo from data_proposta where nome_data = '$pendencia') ";
        $sql.=" group by np.pk";
        $sql.="         ORDER BY u.nome";

	$result_dados = mysql_query($sql);
	while($row_dados = mysql_fetch_array($result_dados)){
		
		//limpa o array das datas.
        $sql ="";
        $sql.="SELECT ndpo.pk, ndpo.ds_label_data,ndpo.ds_data
                FROM n_data_proposta_operador ndpo
               WHERE ndpo.operador_pk =".$row['cod_operador'];
        $sql.=" AND ndpo.dt_cancelamento IS NULL
              ORDER BY ndpo.n_ordem";
		
		$result_data = mysql_query($sql);
		while($row_data = mysql_fetch_array($result_data)){
			$arrDatas[$row_data['ds_data']]="";
		}
		mysql_free_result($result_data);
		
		//imprime o valor do gerente de conta
		echo "<tr>";
		echo "<td class='form'>&nbsp;".$row_dados['nomegerenteconta']."</td>";
		echo "<td class='form'>&nbsp;".$row_dados['atendente']."</td>";
		echo "<td class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row_dados['codlead']."'>".$row_dados['razaosocial']."</a></td>";
		
        $sql ="";
        $sql.="SELECT sum(nip.n_qtde) linhas, np.vl_total_proposta
                FROM n_itens_propostas nip
                     INNER JOIN n_propostas np ON nip.propostas_pk = np.pk
              WHERE nip.propostas_pk =".$row_dados['pk'];
        $sql.="  GROUP BY nip.propostas_pk";
      

		$result_valor_qtde = mysql_query($sql);
		$contador = mysql_num_rows($result_valor_qtde);
		while($row_valor_qtde = mysql_fetch_array($result_valor_qtde)){
            
            echo "<td class='form' align='right'>&nbsp;".number_format($row_valor_qtde['vl_total_proposta'],2,",",".")."</td>";
            $total_valor += $row_valor_qtde['vl_total_proposta'];

            echo "<td class='form' align='center'>&nbsp;".$row_valor_qtde['linhas']."</td>";
            $total_linhas += $row_valor_qtde['linhas'];
        }
		mysql_fetch_array($result_valor_qtde);

        $sql ="";
        $sql.="SELECT ndpo.pk data_pk, ndpo.ds_label_data,ndpo.ds_data
                FROM n_data_proposta_operador ndpo
               WHERE ndpo.operador_pk =".$row['cod_operador'];
        $sql.=" AND ndpo.dt_cancelamento IS NULL
              ORDER BY ndpo.n_ordem";
        
        $results = mysql_query($sql);
        while($row1 = mysql_fetch_array($results)){
            $sql ="";
            $sql.="Select
                    DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') data
                    from n_datas_proposta ndp";
            $sql.=" where ndp.propostas_pk=".$row_dados['pk'];
            $sql.="  and ndp.data_proposta_operador_pk=".$row1['data_pk'];
            
            $results1 = mysql_query($sql);
            $row2 = mysql_fetch_array($results1);            
            echo "<td class='form' align='center'>&nbsp;";
            if(!empty($row2['data'])){
                echo $row2['data'];
            }else{
                echo "&nbsp";
            }   
            
            echo "</td>";
           
            mysql_free_result($result_data);
        }
        mysql_free_result($result_data);
     
		

		echo "</tr>";
	}
	mysql_free_result($result_dados);
	?>
	</tbody>
	<tfoot>
		<tr class="link_cinza">
			<tr>
				<td colspan="3" align='center' class='titulo' bgcolor='#8080FF'>
					Total
				</td>
				<td align='center' class='titulo' bgcolor='#8080FF'>
					<?= $total_valor;?>
				</td>
				<td align='center' class='titulo' bgcolor='#8080FF'>
					<?= $total_linhas;?>
				</td>
				<td align='center' class='titulo' bgcolor='#8080FF' colspan="<?=$total_datas;?>">
					&nbsp;
				</td>
			</tr>
		</tr>
	</tfoot>
</table>
<br>
<?
}
mysql_free_result($result);
?>
</body>
</html>
