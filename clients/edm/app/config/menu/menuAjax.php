<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";

switch($_REQUEST['tipo']){
	case 1:?>
		<table width="800"  id="submenu" cellpadding="0" cellspacing="0" >
		<tr class="grid">
			<td>#</td>
			<td>Menu</td>
			<td>Menu Pai</td>
			<td>Status</td>
			<td>Link</td>
			<td>Tipo Chamada</td>		
			<td>Ordem</td>
		</tr>						
		<?		
		
		$sql = "Select sm.cod_submenu,sm.dsc_submenu,m.dsc_menu,s.dsc_status,sm.link,t.dsc_target,sm.ordem";
		$sql .= " from submenu sm";
		$sql .= " inner Join menu m on m.cod_menu =sm.cod_menu";
		$sql .= " left join status s on sm.status = s.cod_status";
		$sql .= " left join target t on sm.target = t. target";
		if(!empty($_REQUEST['cod_menulateral'] )){
			$sql .= " where sm.cod_menu= ".$_REQUEST['cod_menulateral'];
		}
		$sql .= " order by m.ordem, sm.ordem";
		$result = sql_query($sql);
		$maxcont = mysql_num_rows($result);
		$cont = 0;
		?><input type="hidden" name="rd1_cont" id="rd1_cont" value="<?=$maxcont;?>"><?
		while($row = mysql_fetch_array($result)){
		?>
		<tr class="font_grid">
			<td align="center" >
				<input type="radio" name="rd1" id="rd1-<?=$cont;?>" value="<?=$row['cod_submenu'];?>" />
			</td>
		
			<td align="center"><?=$row['dsc_submenu'];?></td>
			<td align="center"><?=$row['dsc_menu'];?></td>
			<td align="center"><?=$row['dsc_status'];?></td>
			<td align="center"><?=$row['link'];?></td>
			<td align="center"><?=$row['dsc_target'];?></td>
			<td align="center"><?=$row['ordem'];?></td>
		</tr>
		<?
			$cont++;
		}
		mysql_free_result($result);
		?>
		</table>
<?	break;
	case 2:?>
		<table width="800"  id="submenu" cellpadding="0" cellspacing="0" >
			<tr class="grid">
				<td>#</td>
				<td>Menu</td>
				<td>Menu Pai</td>
				<td>Status</td>
				<td>Link</td>
				<td>Tipo Chamada</td>
				<td>Ordem</td>
			</tr>						
			<?		
			
			$sql = "Select sm.cod_submenu,sm.dsc_submenu,sm2.dsc_submenu menu_pai,s.dsc_status,sm.link,t.dsc_target,sm.ordem";
			$sql .= " from submenu sm";
			$sql .= " inner Join submenu sm2 on sm2.cod_submenu =sm.cod_submenu_pai";
			$sql .= " inner Join menu m on m.cod_menu =sm2.cod_menu";
			$sql .= " left join status s on sm.status = s.cod_status";
			$sql .= " left join target t on sm.target = t. target";
			$sql .= " where 1";
			if(!empty($_REQUEST['cod_sub_menu'] )){
				$sql .= " and m.cod_menu= ".$_REQUEST['cod_sub_menu'];
			}
			if(!empty($_REQUEST['cod_sublateral'] )){
				$sql .= " and sm.cod_submenu_pai = ".$_REQUEST['cod_sublateral'];
			}
			$sql .= " order by m.ordem, sm2.ordem, sm.ordem";													
			$result = sql_query($sql);
			$maxcont = mysql_num_rows($result);
			$cont = 0;
			?><input type="hidden" name="rd2_cont" id="rd2_cont" value="<?=$maxcont;?>"><?
			while($row = mysql_fetch_array($result)){
			?>
			<tr class="font_grid">
				<td align="center" >
					<input type="radio" name="rd2" id="rd2-<?=$cont;?>" value="<?=$row['cod_submenu'];?>" />
				</td>
		
				<td align="center"><?=$row['dsc_submenu'];?></td>
				<td align="center"><?=$row['menu_pai'];?></td>
				<td align="center"><?=$row['dsc_status'];?></td>
				<td align="center"><?=$row['link'];?></td>
				<td align="center"><?=$row['dsc_target'];?></td>
				<td align="center"><?=$row['ordem'];?></td>
			</tr>
			<?
				$cont++;
			}
			mysql_free_result($result);
			?>
		</table>
<?	break;
	case 3:
		if(!empty($_REQUEST['cod_sub_menu'] )){
		$sql = "Select sm.cod_submenu as cod_sublateral ,sm.dsc_submenu";
		$sql .= " from submenu sm";
		$sql .= " inner Join menu m on m.cod_menu =sm.cod_menu";
		$sql .= " left join status s on sm.status = s.cod_status";
		$sql .= " left join target t on sm.target = t. target";
		$sql .= " where sm.cod_menu= ".$_REQUEST['cod_sub_menu'];
		combo($sql, "cod_sublateral", @$_REQUEST['cod_sublateral'], " ", "onchange=reload_submenu(2);");
		}else{
			?>
			<select>
				<option></option>
			</select>
			<?
		}												
	break;
}
?>