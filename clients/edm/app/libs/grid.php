<?
include_once "datas.php";
?>
<script>
function change_class(obj) {

	if (obj.className == "g_horizontal_item") {
		obj.className = "g_horizontal_item_hover"
	} else {
		if (obj.className == "g_horizontal_item_hover") {
			obj.className = "g_horizontal_item"
		}
	}
}
</script>

<?
function grid($rs, $chave, $titulo, $campos, $style = null )
{
	$i = 1 ;
	$c = 0 ;

	$num = mysql_num_rows( $rs ) ;
	$strTitulo = split( "//" , $titulo ) ;
	$strCampos = split( "//" , $campos ) ;
	foreach( $strTitulo as $Valor )
		$i++ ;
		
	?>
	
	<table class="borda_tabela" width="98%" align="center"  id="dados" border="0" cellpadding="1"  cellspacing="2" >
		<tr class="font_grid">
			<td <?= ( $style ) ? $style : "style:text-align:center;" ; ?>>#</td>
				<?
					foreach( $strTitulo as $Valor ) 
					{
				?>
			<td <?= ( $style ) ? $style : "style:text-align:center;" ; ?>>
					<?= $Valor ; ?>
			</td>
				<?		
					}
				?>
		</tr>

<?

$cor = "#ffffff" ;	
while( $row = mysql_fetch_array( $rs , MYSQL_ASSOC ) )
{
	$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
?>
		<tr class="link_cinza" bgcolor="<?= $cor ; ?>" onclick="document.getElementsByName('rd')[<?= $c ; ?>].checked=true">
				<td <?= ( $style ) ? $style : "" ; ?>><input value="<?= $row[$chave] ; ?>" type="radio" name="rd" /></td>
<?		foreach( $strCampos as $valor_col )
		{
			
?>
				<td <?= ( $style ) ? $style : "style:text-align:center;" ; ?>><?= $row[$valor_col] ; ?></td>
<?		
		}
?>
		</tr>
			
<?		$c++ ;
}
?>
		</tr>
		<tr>			
			<th class="link_cinza" colspan="<?= $i ; ?>">Registro(s):&nbsp;<?= $num ; ?></th>
		</tr>
		</tbody>
	</table>
<? }

function pagegrid($sql, $chave, $titulos, $campos, $pagesize = 30, $pagina = 1, $link = null){
	$myurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$sql = stripslashes($sql);
	$myurl .= '?sql=' . urlencode($sql);
	$i = count($titulos) + 1;
	$c = 0;
	$result = sql_query($sql);
	$num = mysql_num_rows($result);
	mysql_free_result($result);

	$pagecount = ceil($num / $pagesize);
	$pgini = $pagina - 10;
	$pgini = ($pgini < 1?1:$pgini);
	$pgfim = $pgini + 19;
	$pgfim = ($pgfim > $pagecount?$pagecount:$pgfim);
	$pgini = ($pgfim == $pagecount?$pgfim - 19:$pgini);
	$pgini = ($pgini < 1?1:$pgini);
	
	$recini = ($pagina - 1) * $pagesize;
	$recfim = ($pagina * $pagesize) - 1;

	if($recfim > $num)
		$recfim = $num;
	$sql .= " limit $recini, $pagesize";
	if($recfim == $num)
		$recfim = $num - 1;
	$result = sql_query($sql);

	if($pagecount > 1){?>
		
		<table class="borda_tabela" width="98%" align="center"  id="dados" border="1" cellpadding="0"  cellspacing="0" >
			<tr>
				<td width="60%"  class="font_grid">
					&nbsp;<strong>Exibindo <?=($recini + 1);?> à <?=($recfim + 1);?> de <?=$num;?> registros</strong>
				</td>
				<td valign="baseline" class="font_grid" align="right">
				<?	}
					if($pagecount > 1){?>

				<?		if($pagina > 1){?>
							<a href="<?=htmlentities($myurl);?>&pagina=1"><img src="../../images/start_off.gif" border="0"></a>&nbsp;&nbsp;
							<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina - 1);?>"><img src="../../images/previous_off.gif" border="0"></a>&nbsp;
				<?		}else{?>
										<img src="../../images/start_off.gif" border="0" v>&nbsp;&nbsp;<img src="../../images/previous_off.gif" border="0">&nbsp;
				<?		}
						for($tmppg = $pgini; $tmppg <= $pgfim; $tmppg++){
							if($tmppg == $pagina){?>
							&nbsp;<?=$tmppg;?>&nbsp;
				<?			}else{?>
							&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=$tmppg;?>"><?=$tmppg;?></a>&nbsp;
				<?			}
						}
						if($pagina < $pagecount){?>
							&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina + 1);?>"><img src="../../images/next_off.gif" border="0"></a>&nbsp;&nbsp;
							<a href="<?=htmlentities($myurl);?>&pagina=<?=$pagecount;?>"><img src="../../images/end_off.gif" border="0"></a>
				<?		}else{?>
							&nbsp;<img src="../../images/next_off.gif" border="0">&nbsp;&nbsp;
							<img src="../../images/end_off" border="0">
				<?		}?>
						&nbsp;
				<?	}?>			
				</td>
			</tr>
		</table>
		<table class="borda_tabela" width="98%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
			<tr class="font_grid">
				<td align="center">#</td>
					<?	foreach($titulos as $titulo){?>
						<td align="center">
							<?=$titulo;?>&nbsp;
						</td>
					<?	}?>
				</tr>	
				<?	
				$cor = "#ffffff";
					while($row = mysql_fetch_array($result)){
					if($cor=="#dfdfdf"){
						$cor = "#ffffff";
					}Else{
						$cor = "#dfdfdf";
					}
				?>
				
				<tr  class="link_cinza" bgcolor="<?=$cor?>"  onclick="document.getElementsByName('rd')[<?=$c;?>].checked=true" >
					<td align="center" width="10">
						<input value="<?=$row[$chave];?>" type="radio" name="rd" />
					</td>
					<?foreach($campos as $campo){?>
						<?if(!empty($link[$campo]) && !empty($row[$link[$campo]])){?>
						<td align="left">
						<?}
						  else{?>
						  <td align="center">
						  <?}
							?>
						
							<?if(!empty($link[$campo]) && !empty($row[$link[$campo]])){?>
								<a href="javascript:abrirGrid('<?=$campo;?>','<?=$row[$link[$campo]];?>')">
							<?}?>
							<?=str_replace(chr(13), '<br />', htmlentities($row[$campo]));?>
							<?if(!empty($link[$campo]) && !empty($link[$campo])){?>	</a>
							<?}?>
						</td>
					<?}?>
				</tr>
				<?$c++;	} mysql_free_result($result);?>
			</tbody>
		</table>
		<table class="borda_tabela" width="98%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
			<tr>		
				<td align="center" class="link_cinza" colspan="<?=$i;?>">
				Registro(s):&nbsp;<?=($recfim - $recini + 1);?>
				</td>		
			</tr>
		</table>
<?}?>
<!--Função minigrid-->
<?

function minigrid($sql, $chave, $titulos, $campos, $pagesize = 30, $pagina = 1, $link = null){
	$myurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$sql = stripslashes($sql);
	$myurl .= '?sql=' . urlencode($sql);
	$i = count($titulos) + 1;
	$c = 0;
	$result = sql_query($sql);
	$num = mysql_num_rows($result);
	mysql_free_result($result);

	$pagecount = ceil($num / $pagesize);
	$pgini = $pagina - 10;
	$pgini = ($pgini < 1?1:$pgini);
	$pgfim = $pgini + 19;
	$pgfim = ($pgfim > $pagecount?$pagecount:$pgfim);
	$pgini = ($pgfim == $pagecount?$pgfim - 19:$pgini);
	$pgini = ($pgini < 1?1:$pgini);
	
	$recini = ($pagina - 1) * $pagesize;
	$recfim = ($pagina * $pagesize) - 1;

	if($recfim > $num)
		//$recfim = $num;
	$sql .= " limit $recini, $pagesize";
	if($recfim == $num)
		$recfim = $num - 1;
	$result = sql_query($sql);
	
	if($pagecount > 1){?>
		
		<table class="borda_tabela" width="100%" align="left"  id="dados" border="1" cellpadding="0"  cellspacing="0" >
			<tr>
				<td width="60%"  class="font_grid">
					&nbsp;<strong>Exibindo <?=($recini + 1);?> à <?=($recfim + 1);?> de <?=$num;?> registros</strong>
				</td>
				<td valign="baseline" class="font_grid" align="right">
				<?	}
					if($pagecount > 1){?>

				<?		if($pagina > 1){?>
							<a href="<?=htmlentities($myurl);?>&pagina=1"><img src="../images/start_off.gif" border="0"></a>&nbsp;&nbsp;
							<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina - 1);?>"><img src="../images/previous_off.gif" border="0"></a>&nbsp;
				<?		}else{?>
										<img src="../images/start_off.gif" border="0" v>&nbsp;&nbsp;<img src="../images/previous_off.gif" border="0">&nbsp;
				<?		}
						for($tmppg = $pgini; $tmppg <= $pgfim; $tmppg++){
							if($tmppg == $pagina){?>
							&nbsp;<?=$tmppg;?>&nbsp;
				<?			}else{?>
							&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=$tmppg;?>"><?=$tmppg;?></a>&nbsp;
				<?			}
						}
						if($pagina < $pagecount){?>
							&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina + 1);?>"><img src="../images/next_off.gif" border="0"></a>&nbsp;&nbsp;
							<a href="<?=htmlentities($myurl);?>&pagina=<?=$pagecount;?>"><img src="../images/end_off.gif" border="0"></a>
				<?		}else{?>
							&nbsp;<img src="../images/next_off.gif" border="0">&nbsp;&nbsp;
							<img src="../images/end_off" border="0">
				<?		}?>
						&nbsp;
				<?	}?>			
				</td>
			</tr>
		</table>
		<div class="iframe1">		
			<table class="borda_tabela" width="98%"   id="dados" border="0" cellpadding="0"  cellspacing="0" >
				<tr class="font_grid">
					<td align="center">#</td>
						<?	foreach($titulos as $titulo){?>
							<td align="center">
								<?=$titulo;?>&nbsp;
							</td>
						<?	}?>
					</tr>	
					<?	
					$cor = "#ffffff";
						while($row = mysql_fetch_array($result)){
						if($cor=="#dfdfdf"){
							$cor = "#ffffff";
						}Else{
							$cor = "#dfdfdf";
						}
					?>
					
					<tr  class="link_cinza" bgcolor="<?=$cor?>"  onclick="document.getElementsByName('rd')[<?=$c;?>].checked=true" >
						<td align="center" width="10">
							<input value="<?=$row[$chave];?>" type="radio" name="rd" />
						</td>
						<?foreach($campos as $campo){?>
							<td align="center">
								<?if(!empty($link[$campo]) && !empty($row[$link[$campo]])){?>
									<a href="javascript:abrirGrid('<?=$campo;?>','<?=$row[$link[$campo]];?>')">
								<?}?>
								<?=str_replace(chr(13), '<br />', htmlentities($row[$campo]));?>
								<?if(!empty($link[$campo]) && !empty($link[$campo])){?>	</a>
								<?}?>
							</td>
						<?}?>
					</tr>
					<?$c++;	} mysql_free_result($result);?>
				</tbody>
			</table>
		</div>
		<table class="borda_tabela" width="100%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
			<tr>		
				<td align="center" class="link_cinza" colspan="<?=$i;?>">
				Registro(s):&nbsp;<?=($recfim - $recini + 1);?>
				</td>		
			</tr>
		</table>
<?}?>





<?
function pagegrid2($sql, $chave, $titulos, $campos, $pagesize = 30, $pagina = 1, $link = null){
	$myurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$sql = stripslashes($sql);
	$myurl .= '?sql=' . urlencode($sql);
	$i = count($titulos) + 1;
	$c = 0;
	$result = sql_query($sql);
	$num = mysql_num_rows($result);
	mysql_free_result($result);

	$pagecount = ceil($num / $pagesize);
	$pgini = $pagina - 10;
	$pgini = ($pgini < 1?1:$pgini);
	$pgfim = $pgini + 19;
	$pgfim = ($pgfim > $pagecount?$pagecount:$pgfim);
	$pgini = ($pgfim == $pagecount?$pgfim - 19:$pgini);
	$pgini = ($pgini < 1?1:$pgini);
	
	$recini = ($pagina - 1) * $pagesize;
	$recfim = ($pagina * $pagesize) - 1;
	if($recfim > $num)
		$recfim = $num;
	$sql .= " limit $recini, $pagesize";
	if($recfim == $num)
		$recfim = $num - 1;
	$result = sql_query($sql);

	if($pagecount > 1){?>

	<table cellspacing="0" cellpadding="0" style="width:100%" border="0" >
		<tr>
			<td class="font_grid">
				<span>
					<strong>Exibindo <?=($recini + 1);?> à <?=($recfim + 1);?> de <?=$num;?> registros</strong>
				</span><br /><br />
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" style="width:100%" border="0" >
		<tr>
			<td class="font_grid">
			<?	}
				if($pagecount > 1){?>
				<span>
					<strong>
			<?		if($pagina > 1){?>
						<a href="<?=htmlentities($myurl);?>&pagina=1">&lt;&lt;</a>&nbsp;&nbsp;
						<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina - 1);?>">&lt;</a>&nbsp;
			<?		}else{?>
						&lt;&lt;&nbsp;&nbsp;&lt;&nbsp;
			<?		}
					for($tmppg = $pgini; $tmppg <= $pgfim; $tmppg++){
						if($tmppg == $pagina){?>
						&nbsp;<?=$tmppg;?>&nbsp;
			<?			}else{?>
						&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=$tmppg;?>"><?=$tmppg;?></a>&nbsp;
			<?			}
					}
					if($pagina < $pagecount){?>
						&nbsp;<a href="<?=htmlentities($myurl);?>&pagina=<?=($pagina + 1);?>">&gt;</a>&nbsp;&nbsp;
						<a href="<?=htmlentities($myurl);?>&pagina=<?=$pagecount;?>">&gt;&gt;</a>
			<?		}else{?>
						&nbsp;&gt;&nbsp;&nbsp;
						&gt;&gt;
			<?		}?>
					<br />&nbsp;</strong></span>
			<?	}?>
			</td>
		</tr>
	</table>

<table class="borda_tabela" width="98%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
	<tr class="font_grid">
		<td align="center">#</td>
<?	foreach($titulos as $titulo){?>
				<td align="center"><?=$titulo;?>&nbsp;</td>
<?	}?>
			</tr>		

<?	
$cor = "#ffffff";
	while($row = mysql_fetch_array($result)){
	if($cor=="#dfdfdf"){
		$cor = "#ffffff";
	}Else{
		$cor = "#dfdfdf";
	}
?>
			<tr class="link_cinza" bgcolor="<?=$cor?>"  onclick="document.getElementsByName('rd')[<?=$c;?>].checked=true">
				<td align="center" width="10">
					<input value="<?=$row[$chave];?>" type="radio" name="rd" />
				</td>
<?		foreach($campos as $campo){?>
				<td align="center">
<?			if(!empty($link[$campo]) && !empty($row[$link[$campo]])){?>
					<a href="javascript:abrirGrid('<?=$campo;?>','<?=$row[$link[$campo]];?>')">
<?			}
			if($campo == 'Fechamento'){ ?>
					<?=($row[$campo]==1?"Fechado":"Aberto");?>
<?			}else{?>
					<?=str_replace(chr(13), '<br />', htmlentities($row[$campo]));?>
<?			}
			if(!empty($link[$campo]) && !empty($link[$campo])){?>
					</a>
<?			}?>
			</td>
<?		}?>
		</tr>
<?		$c++;
	}
	mysql_free_result($result);?>
	</tr>
		<tr>			
			<th class="link_cinza" colspan="<?=$i;?>">Registro(s):&nbsp;<?=($recfim - $recini + 1);?>
		</th>
		</tr>
	</tbody>
</table>

<?}?>
