<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="javascript">
	function abrirGrid(campo, valor){
		switch(campo){
			case 'imagemaparelho':
				NewWindow("visualiza_aparelho.php?codaparelho=" + valor,400,400)
				break
		}
	}
	function numero_pagina(){
		var d = document.forms[0];
		var end = d.endereco.value
		if (d.npagina.value==""){
			alert('Pagina não foi preenchido !');
		}
		
		url = ( end + "&pagina=" + d.npagina.value  ) ;

		window.location.href=url ;
	}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
	$pagina = 1;
	$tam_pagina = 30;

	if(isset($_REQUEST['pagina']))
		$pagina = $_REQUEST['pagina'];
	if($pagina == 0)
		$pagina = 1;	
	$sql = "Select 
			  e.cod_email_empresa
			  ,te.n_tipoemail
			  ,e.email_saida
			  ,e.email_assunto
			  ,t.Descricao
			  ,e.anexo
			  ,e.status	
			  ,e.identificacao
			from email_empresa e
			  inner join tipo_email te on e.cod_tipoemail = te.cod_tipoemail
			  left join tipoocorrenciaslead t on e.codtipoocorrencialead = t.CodTipoOcorrenciaLead";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	
	if($num < $reg_fim){
		$reg_fim = $num;
	}
	
	if($reg_fim == "0"){
		$reg_inicio = 0;
	}
	else{
		$reg_inicio++;
	}

?>

<table class="borda_tabela" width="98%" align="center"  id="dados" border="1" cellpadding="0"  cellspacing="0" >
<form name="dados">
	<input type="Hidden" name="endereco" value="<?=$_SERVER['REQUEST_URI']?>">
	<tr>
		<td width="60%" nowrap class="font_grid">
			&nbsp;<strong>Exibindo <?=($reg_inicio);?> à <?=($reg_fim);?> de <?=$num;?> registros</strong>
		</td>

		<td valign="baseline" class="font_grid" align="right">
			<?if ($num >= $reg_fim) {?>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=1"><img src="../../images/start_off.gif" border="0"></a>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?=($pagina - 1);?>"><img src="../../images/previous_off.gif" border="0"></a>
				<?
				//calcula o total de páginas
				$total_paginas = intval($num/$tam_pagina)+1;
				
				if ($total_paginas < 10){
					for($i = 1; $i < $total_paginas; $i++){
						if($i == $pagina)
							echo "<b>$i</b>&nbsp;";
						else					
							echo "<a href='".$_SERVER['REQUEST_URI']."&pagina=$i'>$i</a>&nbsp;";
					}
				}
				else{
								
					if($pagina == 1){
						$pagina_inicio = 1;
						$pagina_fim = 10;
					}
					else{
						$pagina_inicio = $pagina - 5;
						$pagina_fim = $pagina_inicio + 10;
						
						if($pagina_inicio < 1){
							$pagina_inicio = 1;
							$pagina_fim = 10;
						}
						
						if($total_paginas < $pagina_fim){
							$pagina_fim = $total_paginas + 1;
							$pagina_inicio = $pagina_fim - 10;
						}
					}
					
					for($i = $pagina_inicio; $i < $pagina_fim; $i++){
						if($i == $pagina)
							echo "<b>$i</b>&nbsp;";
						else
							echo "<a href='".$_SERVER['REQUEST_URI']."&pagina=$i'>$i</a>&nbsp;";
					}
				}
				?>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?
				if($pagina == $total_paginas){
					echo $total_paginas;
				}
				else{
					echo $pagina + 1;
				}
				?>"><img src="../../images/next_off.gif" border="0"></a>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?=$total_paginas;?>"><img src="../../images/end_off.gif" border="0"></a>
			<?
			}
			?>
		</td>
	</tr>
</form>
</table>
<table class="borda_tabela" width="98%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
	<tr class="font_grid">
		<td align="center">#</td>
		<td align="center">
			Tipo Email
		</td>		
		<td align="center">
			Modelo
		</td>		
		<td align="center">
			Email de Saída
		</td>				
		<td align="center">
			Assunto
		</td>		
		<td align="center">
			Tipo da Ocorrência
		</td>		
		<td align="center">
			Status
		</td>		
		<!--<td align="center">
			Anexo
		</td>-->						
	</tr>	
	<?
	$cor = "#ffffff";
	$pagina_atual = 1;
	$registro = 1;
	while($row = mysql_fetch_array($result)){
		if($row['status']==1){
			$status = "Ativo";
		}else{
			$status = "Desativado";
		}
		if ($pagina_atual == $pagina){
	
			if($cor=="#dfdfdf"){
				$cor = "#ffffff";
			}
			else{
				$cor = "#dfdfdf";
			}	
			
			
		?>
		<tr class="link_cinza" bgcolor="<?=$cor?>" onclick="document.getElementsByName('rd')[<?= $registro-1;?>].checked=true">
			<td align="center" width="10">
				<input value="<?=$row['cod_email_empresa'];?>" type="radio" name="rd" />
			</td>
			<td align="center">
				<?= $row['n_tipoemail'];?>
			</td>
			<td align="center">
				<?= $row['identificacao'];?>
			</td>			
			<td align="center">
				<?= $row['email_saida'];?>
			</td>	
			<td align="center">
				<?= $row['email_assunto'];?>
			</td>
			<td align="center">
				<?= $row['Descricao'];?>
			</td>	
			<td align="center">
				<?=$status;?>
			</td>
			<!--<td>
				<a href="#" onclick="javascript:abrirGrid('imagemaparelho','<?//= $row['cod_email_empresa']?>')"><?//= $row['NomeAparelho'];?></a>
			</td>-->		
		</tr>
<?
		}
		
		if($registro == $tam_pagina){
			$pagina_atual ++;
			$registro = 1;
		}
		else{
			$registro ++;
		}
		
	}
	mysql_free_result($result);
	?>
</table>	
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
