<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.leads.php";
include_once "auditoria_cla.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.combo.php";
	
$acao = $_REQUEST['acao'];
$pk = $_REQUEST['auditoria_pk'];
$leads_pk = $_REQUEST['codlead'];
$agendavisita_pk = $_REQUEST['codagendalead'];

if($pk > 0){
	$auditoria = new auditoria($pk);
	$pk = $auditoria->getpk();
	$dt_cadastro = $auditoria->getdt_cadastro();
	$usuario_cadastro_nome_pk = $auditoria->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $auditoria->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $auditoria->getusuario_ult_atualizacao_nome_pk();
	$leads_pk = $auditoria->getleads_pk();
	$agendavisita_pk = $auditoria->getagendavisita_pk();
	$contatoslead_pk = $auditoria->getcontatoslead_pk();
	$tipo_visita_pk = $auditoria->gettipo_visita_pk();
	$dsc_auditoria = $auditoria->getdsc_auditoria();
	$tel_fixo = $auditoria->gettel_fixo();

}

$sql = "Select
			l.razaosocial,
			l.ddd,
			l.tel,
			l.dddfax,
			l.fax,
			l.qtde_linhas
		from leads l
		where l.codlead=".$leads_pk;
		
$result = mysql_query($sql);		
$row = mysql_fetch_array($result);

$razaosocial = $row['razaosocial'];
$tel = $row['ddd']."&nbsp;".$row['tel'];
$fax = $row['ddd_fax']."&nbsp;".$row['fax'];
$qtde_linhas = $row['qtde_linhas'];

mysql_free_result($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabeçalho-->
	<title>auditoria</title>	
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="JavaScript" src="auditoria_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="post" action="auditoria_cad_proc.php">
	<input type='hidden' name='acao' id='acao' value='' />
	<input type='hidden' name='pk' value='<?= $pk;?>' />
	<input type='hidden' name='leads_pk' value='<?= $leads_pk;?>' />
	<input type='hidden' name='agendavisita_pk' value='<?= $agendavisita_pk;?>' />

	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<tr>
				<td  class="titulo">
				 Auditoria
			</td>
		</tr>
	</table>
	<table width="100%" height="100%"  align="center" border="0" cellpadding="1" cellspacing="1" class="form">
		<tr>
			<td colspan="2">
				 
			</td>	
		</tr>
		<?if(!empty($pk)){?>
			<tr>
				<td  width="25%">
					Data Cadastro: 
				</td>
				<td>
					<?=$dt_cadastro;?>
				</td>
			</tr>
			<tr>
				<td  width="25%">
					Auditado por: 
				</td>
				<td>
					<?=$usuario_cadastro_nome_pk;?>
				</td>
			</tr>		
		<?}?>			
		<tr>
			<td  width="25%">
				Razão Social: 
			</td>
			<td>
				<?=$razaosocial;?>
			</td>
		</tr>
		<tr>
			<td  width="25%">
				Telefone: 
			</td>
			<td>
				<?if(!empty($pk)){					
					echo $tel_fixo;
				  }else{?>	
					<select nome="tel_fixo" id="tel_fixo">
						<option value=""></option>
						<option value="<?=$tel;?>"><?=$tel;?></option>
						<?if(empty($fax)){?>
							<option value="<?=$fax;?>"><?=$fax;?></option>
						<?}?>
					</select>
				<?}?>
			</td>
		</tr>

		<tr>
			<td  width="25%">
				Contato: 
			</td>
			<td>
				<?
					$sql ="";
					$sql.= "Select
								cl.codcontatolead,
								cl.nomecontato,
								cl.ddd_fone,
								cl.fone, 
								cl.ddd_cel,
								cl.cel,
								cl.email						
							from contatoslead cl
							where codlead=".$leads_pk;		
					$result = mysql_query($sql);			
					if(!empty($pk)){	
						$row = mysql_fetch_array($result);				
						if($row['codcontatolead']==$contatoslead_pk){
							echo  $row['nomecontato']." - Fone:(".$row['ddd_fone'].") ".$row['fone']." - Cel:(".$row['ddd_cel'].") ".$row['cel']." - Email:".$row['email'];
						}	
						
					}else{
						echo "<select name='contatoslead_pk' id='contatoslead_pk'>";
						echo 	"<option value=''></option>";
						
						while($row = mysql_fetch_array($result)){						
							echo "<option value='".$row['codcontatolead']."'>".$row['nomecontato']." - Fone:(".$row['ddd_fone'].") ".$row['fone']." - Cel:(".$row['ddd_cel'].") ".$row['cel']." - Email:".$row['email']."</option>";
						}	
						echo "</select>";
					}	
				?>
			</td>
		</tr>
		<tr>
			<td  width="25%">
				Operadora(s): 
			</td>
			<td>
			<?
				$sql = "select op.cod_operadora codigo, op.dsc_operadora nome
					from operadoras op
					inner join leads_operadoras lo ON lo.cod_operadora = op.cod_operadora
					where lo.CodLead = $leads_pk";
				$result = sql_query($sql);
				while($row = mysql_fetch_array($result))
				{
					echo $row["nome"]."&nbsp;&nbsp;&nbsp;";
				}
				mysql_free_result($result);
				?>	
			</td>
		</tr>		
		<tr>
			<td  width="25%">
				Qtde Linhas: 
			</td>
			<td>			
				<?=$qtde_linhas;?>
			</td>
		</tr>	
		<tr>
			<td   colspan="2" align="center">
				&nbsp;
			</td>		
		</tr>	
		<tr>
			<td   colspan="2" align="center">
				<b>Observação</b>
			</td>		
		</tr>	
		<tr>
			<td   colspan="2" align="center">
				<textarea id="dsc_auditoria" name="dsc_auditoria" style="width: 100%" rows="5"><?=$dsc_auditoria;?></textarea>
			</td>		
		</tr>				
		<tr>
			<td colspan="2" align="center" >
				<?if(empty($pk)){?>		
					<input type='button' name='cmdEnviar' id='cmdEnviar' value="Enviar" onclick="enviar();" />		
			    <?}?>		 
				<input type="button" name="cmdFechar" id='cmdFechar' value="Fechar" onclick="self.close()" />
			</td>
		</tr>							
	</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
