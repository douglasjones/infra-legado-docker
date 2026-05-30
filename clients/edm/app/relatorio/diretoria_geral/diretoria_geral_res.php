<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}


include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;

$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$qtdeli_ini = $_REQUEST['qtdeli_ini'];
$qtdeli_fim = $_REQUEST['qtdeli_fim'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$codstatusclassificacaolead_pk = "";
$qtdeli_ini = $_REQUEST['qtdeli_ini'];
$qtdeli_fim = $_REQUEST['qtdeli_fim'];
$cod_operadora = $_REQUEST['cod_operadora'];
$classificacao_claro_pk = $_REQUEST['classificacao_claro_pk'];
for($i = 0; $i<count($codstatusclassificacaolead);$i++){

        $codstatusclassificacaolead_pk.=$codstatusclassificacaolead[$i].", ";
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>

<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Relatório Geral</font>
	</td>
</tr>
</table>
<br>
<br>

<table border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
		<td class="parametros">
			Parâmetros 
			<br><br>
			
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
					p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			print  "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
        if(!empty($codgerenteconta)){
            $sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            ?>    
                Consultor: <?= $row['nome'];?>
            <?
            mysql_free_result($result);
        }
		?>        
		</td>
	</tr>
    
	<tr>
		<td class="parametros">
            <?
            if(!empty($codequipe)){
                $sql = "select t.tk_equipe cod_equipe, t.vc_nome nome_equipe from tb_equipesvendas t where tk_equipe = $codequipe ";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                ?>
                
                    Equipe: <?= $row['nome_equipe'];?>
                
                <?
                mysql_free_result($result);
            }
            ?>
                    
		</td>
            
	</tr>
        	<?	
	if(!empty($_REQUEST['data_cancelamento_ini'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Propsotas Canceladas:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['data_cancelamento_ini'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['data_cancelamento_fim'])));?></dd>
		</td>
	</tr>
	<?	
	}?>
		
		
	<tr>
		<td class="parametros">
				<br>
				Relatório gerado em 
				<?
				//Pegade geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>				
		</td>
	</tr>
</table>
<br>
    <table width="100%"  cellspacing="0" cellpadding="0"  align="center" border="1" >	
<?
print "	<tr>";
print "		<td class=titulo bgcolor=#8080FF align=center >Cód Lead</td>";
print "		<td class=titulo bgcolor=#8080FF align=center width=230>Lead</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >CNPJ</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Operadoras Contratadas</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Qtde de linhas</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Classificação Claro</td>";
print "		<td class=titulo bgcolor=#8080FF align=center >Consultor</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Status Gepros</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Contato</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Email</td>";

print "	</tr>";
        $sql = "SELECT l.codlead,
                l.RazaoSocial,
                l.CNPJ_CPF,
                l.qtde_linhas,
                l.classificacao_claro_pk,
                ui.Nome Consultor,
                sc.Descricao statusclassificacao
           FROM leads l
                LEFT JOIN usuariosinternos ui
                   ON l.CodGerenteConta = ui.CodUsuarioInterno
                INNER JOIN statusclassificacaolead sc
                   ON l.CodStatusClassificacaoLead = sc.CodStatusClassificacaoLead";
        $sql.="   WHERE 1=1";
	if(!empty($qtdeli_ini) && !empty($qtdeli_fim)){
			$sql.=" and l.qtde_linhas >=".$qtdeli_ini;
			$sql.=" and l.qtde_linhas <= ".$qtdeli_fim;
	}	 
	if($codgerenteconta > 0){
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	}else{
		if($codgerenteconta == '0'){
			$sql.=" and ui.codusuariointerno is null";
		}
		else{
			if(!permissao('visualizar_todos_consultores', 'cs'))
				//if(empty($busca))
					$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		}
	}	
	if($codstatusclassificacaolead_pk!=""){
		$sql.=" and l.codstatusclassificacaolead in (".$codstatusclassificacaolead_pk."0) ";
	}
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
        if($classificacao_claro_pk!=""){
		$sql.=" and l.classificacao_claro_pk =".$classificacao_claro_pk;
	}
        

	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		print "	<tr>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['codlead'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	echo "      <font size=2>;<a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['RazaoSocial']."</a></font>";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['CNPJ_CPF'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
                print "		<td class=detalhe width=90 align=center>";
                    $sql = "";
                    $sql.="SELECT o.dsc_operadora
                            FROM leads_operadoras lo
                                 INNER JOIN operadoras o ON lo.cod_operadora = o.cod_operadora
                           WHERE lo.CodLead = ".$row['codlead'];
                           $resultss = sql_query($sql);
                    	while($rowss = mysql_fetch_array($resultss)){
                            echo $rowss['dsc_operadora']."<br>";
                        }       
                         
                    mysql_free_result($resultss);
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align='right'>";
	   	print "      <font size=2>".$row['qtde_linhas'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";	
                print "		<td class=detalhe width=90 align='right'>";
                if(!empty($row['classificacao_claro_pk'])){
                        $sql = "";
                         $sql.="SELECT nco.pk classificacao_claro_pk, nco.dsc_classificacao
                                    FROM n_classificacao_operadora nco
                                   WHERE nco.operadora_pk = 5
                                   and nco.pk=".$row['classificacao_claro_pk'];
                         
                         	$results = sql_query($sql);
                                $rows = mysql_fetch_array($results);
                                if(!empty($rows['nco.dsc_classificacao'])){
                                    echo $rows['nco.dsc_classificacao'];
                                }
                         mysql_free_result($results);
                }
	   	print "		&nbsp;</td>";                
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['Consultor'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
                print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['statusclassificacao'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
                print "		<td class=detalhe width=90 align=center>";
                    $sql = "";
                    $sql.="SELECT cl.NomeContato
                                FROM contatoslead cl
                               WHERE cl.CodLead =".$row['codlead'];
                           $result1 = sql_query($sql);
                    	while($row1= mysql_fetch_array($result1)){
                            echo $row1['NomeContato']."<br>";
                        }       
                         
                    mysql_free_result($resultss);
	   	print "		&nbsp;</td>";
                                print "		<td class=detalhe width=90 align=center>";
                    $sql = "";
                    $sql.="SELECT cl.Email
                                FROM contatoslead cl
                               WHERE cl.CodLead =".$row['codlead'];
                           $result2 = sql_query($sql);
                    	while($row2 = mysql_fetch_array($result2)){
                            echo $row2['Email']."<br>";
                        }       
                         
                    mysql_free_result($resultss);
	   	print "		&nbsp;</td>";
		print "	</tr>";
	}
        mysql_free_result($result);
?>
</table>
