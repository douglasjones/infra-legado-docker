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
$data_cancelamento_ini = $_REQUEST['data_cancelamento_ini'];
$data_cancelamento_fim = $_REQUEST['data_cancelamento_ini'];

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
		<font size="+2">Relatório Propostas Perdidas</font>
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
print "		<td class=titulo bgcolor=#8080FF align=center width=230>Consultor</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >VL Proposta</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >DT Cancelamento</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Motico Cancel</td>";
print "	</tr>";
$sql = "SELECT l.CodLead,
                l.RazaoSocial,
                ui.Nome,
                np.vl_total_proposta,
                np.dt_cadastro,
                m.Descricao,
                DATE_FORMAT(np.dt_cancelamento , '%d/%m/%Y') dt_cancelamento
           FROM n_propostas np
                INNER JOIN leads l ON np.leads_pk = l.CodLead
                LEFT JOIN usuariosinternos ui
                   ON l.CodGerenteConta = ui.CodUsuarioInterno
                LEFT JOIN motivoslead m ON l.CodMotivo = m.CodMotivoLead";
                if(!empty($codequipe)){
                    $sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
                    $sql.=" left join tb_equipesvendas tbe on tbu.Fk_Equipe = tbe.Tk_Equipe ";
                }
        $sql.="   WHERE  l.CodStatusClassificacaoLead = (1)";
		 
	if(!empty($_REQUEST['cod_polo'])){
		$sql .= " and l.cod_polo=" . mysqlnull($_REQUEST['cod_polo']);
	}
        if(!empty($data_cancelamento_ini))
		$sql.="  and np.dt_cancelamento >= '".DataYMD($data_cancelamento_ini)." 00:00:00' "; 
        
        
        if(!empty($data_cancelamento_fim))
		$sql.="  and np.dt_cancelamento <= '".DataYMD($data_cancelamento_fim)." 23:59:59' ";
    
	if(!empty($codequipe))
		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);
		
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
	
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		print "	<tr>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['CodLead'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	echo "      <font size=2>;<a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['CodLead']."'>".$row['RazaoSocial']."</a></font>";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['Nome'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align='right'>";
	   	print "      <font size=2>".number_format($row['vl_total_proposta'],2,",",".");"</font>&nbsp;";
	   	print "		&nbsp;</td>";	
                print "		<td class=detalhe width=90 align='right'>";
	   	print "      <font size=2>".$row['dt_cancelamento'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";                
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['Descricao'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "	</tr>";
	}
?>
</table>
