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
		<font size="+2">Relatório de Ocorrências</font>
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
		if(!empty($_REQUEST['codtipoocorrencialead'])){
			$sql = "Select Descricao
					From tipoocorrenciaslead
					Where CodTipoOcorrenciaLead = ".mysqlnull($_REQUEST['codtipoocorrencialead']);
			$sql .= " Order By Descricao";
			$result = mysql_query($sql);
			$tipo = mysql_fetch_array($result);
			echo "Tipo Ocprrencia = ".$tipo['Descricao'];
		}
		?>
		</td>
	</tr>		
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['datacadastrode']) && !empty($_REQUEST['datacadastroate'])){?>
			<dt>Data de Abertura: <? echo $_REQUEST['datacadastrode'];?> - <? echo $_REQUEST['datacadastroate'];?></dt>
		<?}?>	
		</td>
	</tr>
	<tr>
		<td class="parametros">
	<?	
	if(!empty($_REQUEST['datafechamentode']) && !empty($_REQUEST['datafechamentoate'])){?>
			<dt>Data de Fechamento: <? echo $_REQUEST['datafechamentode'];?> - <? echo $_REQUEST['datafechamentoate'];?></dt>
	<?}?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codusuariointerno'])){
			$sql = "Select nome
					From usuariosinternos
					Where codusuariointerno = ".mysqlnull($_REQUEST['codusuariointerno']);
			$result = mysql_query($sql);
			$apor = mysql_fetch_array($result);
			echo "Aberta Por = ".$apor['nome'];
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['grupousuariointerno'])){
			$sql = "Select 
						nome 
					from gruposusuariosinternos
					where CodGrupoUsuarioInterno = ".mysqlnull($_REQUEST['grupousuariointerno']);
			$result = mysql_query($sql);
			$grupo = mysql_fetch_array($result);
			echo "Equipe = ".$grupo['nome'];
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codgerenteconta'])){
			$sql = "Select nome
					From usuariosinternos
					Where codusuariointerno = ".mysqlnull($_REQUEST['codgerenteconta']);
			$result = mysql_query($sql);
			$consultor = mysql_fetch_array($result);
			echo "Consultor = ".$consultor['nome'];
		}
		?>
		</td>
	</tr>	
		
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
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="1" >	
<?
print "	<tr>";
print "		<td class=titulo bgcolor=#8080FF align=center >Cód OC</td>";
print "		<td class=titulo bgcolor=#8080FF align=center width=230>Lead</td>";
print "		<td class=titulo bgcolor=#8080FF align=center width=230>Tipo de Ocorrência</td>";
print "		<td class=titulo bgcolor=#8080FF align=center width=230>Mailing</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Abertura</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Fechamento</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Aberto Por</td>";
print "		<td class=titulo bgcolor=#8080FF align=center  >Status</td>";
print "	</tr>";
$sql = "Select
 			o.codocorrencialead
			,DATE_FORMAT(o.DataCadastro, '%d/%m/%Y ás %H:%i' ) as abertura
			,DATE_FORMAT(o.DataFechamento, '%d/%m/%Y ás %H:%i') as fechamento
			,l.RazaoSocial
			,t.Descricao Tipo
			,u.Nome
                        ,sl.descricao statuslead
                        ,m.dsc_mailing
		 From ocorrenciaslead o
			 inner join leads l on o.CodLead = l.CodLead
                         inner join statusclassificacaolead sl on l.codstatusclassificacaolead = sl.codstatusclassificacaolead
			 inner join tipoocorrenciaslead t on o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead
			 inner join usuariosinternos u on o.CodUsuarioInterno = u.CodUsuarioInterno
                         left join mailing m on l.mailing_pk = m.pk
			 left join gruposusuariosinternos_usuariosinternos gu on gu.CodUsuarioInterno = u.CodUsuarioInterno
		 Where 1 ";
		 
	if(!empty($_REQUEST['cod_polo'])){
		$sql .= " and l.cod_polo=" . mysqlnull($_REQUEST['cod_polo']);
	}
        
        if(!empty($_REQUEST['mailing_pk'])){
		$sql .= " and l.mailing_pk=" . mysqlnull($_REQUEST['mailing_pk']);
	}
	if(!empty($_REQUEST['razaosocial'])){
		$razaosocial = $_REQUEST['razaosocial'];
		$sql .= " And l.RazaoSocial Like " . mysqlnull("%$razaosocial%");
	}
	if(!empty($_REQUEST['mailing'])){
		$mailing = $_REQUEST['mailing'];
		$sql .= " and l.Mailing Like " . mysqlnull("%{$_REQUEST['mailing']}%");
	}
	if(!empty($_REQUEST['codtipoocorrencialead'])){
		$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];
		$sql .= " And o.CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
	}
	if(!empty($_REQUEST['datacadastrode']) && !empty($_REQUEST['datacadastroate'])){
		$datacadastrode = dataYMD($_REQUEST['datacadastrode']);
		$datacadastroate = dataYMD($_REQUEST['datacadastroate']);
		$sql .= " And o.DataCadastro Between '$datacadastrode 00:00:00' And '$datacadastroate 23:59:59'";
	}
	if(!empty($_REQUEST['datafechamentode']) && !empty($_REQUEST['datafechamentoate'])){
		$datafechamentode = dataYMD($_REQUEST['datafechamentode']);
		$datafechamentoate = dataYMD($_REQUEST['datafechamentoate']);
		$sql .= " And o.DataFechamento Between '$datafechamentode 00:00:00' And '$datafechamentoate 23:59:59'";	
	}
	if(!empty($_REQUEST['codusuariointerno'])){
		$codusuariointerno = $_REQUEST['codusuariointerno'];
		$sql .= " And o.CodUsuarioInterno = ".$codusuariointerno;
	}
	if(!empty($_REQUEST['grupousuariointerno'])){
		$grupousuariointerno = $_REQUEST['grupousuariointerno'];
		$sql.= " And gu.CodGrupoUsuarioInterno = " . mysqlnull($grupousuariointerno);
	}
	if(!empty($_REQUEST['codgerenteconta'])){
		$codgerenteconta = $_REQUEST['codgerenteconta'];
		$sql.= " And l.CodGerenteConta = " . mysqlnull($codgerenteconta);
	}
	if($GerenteContas && !permissao('leadoutrogerente', 'al')){
		$gerenteconta = $_SESSION['codusuario'];
		$sql .= " and l.CodGerenteConta = ".$gerenteconta;
	}
        $sql.=" group by o.codocorrencialead";
	$sql .= " Order By o.DataCadastro";
       
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		print "	<tr>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['codocorrencialead'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['RazaoSocial'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['Tipo'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
                print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['dsc_mailing'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['abertura'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";	
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['fechamento'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";		
		print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['Nome'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";	
                print "		<td class=detalhe width=90 align=center>";
	   	print "      <font size=2>".$row['statuslead'];"</font>&nbsp;";
	   	print "		&nbsp;</td>";	
		print "	</tr>";
	}
?>
</table>
