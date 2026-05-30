<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 14/10/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/

  include_once "../../libs/maininclude.php";
  include_once "../../libs/cla.menu.php";
  include_once "../../libs/combo.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Sub Menu</title>
<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="JavaScript" src="../../extras/prototype.js"></script>
<script type="text/javascript" language="javascript">
function reload_menulateral() {
	var v = $('cod_menulateral').value;
	var d = $('div_menu_lateral');
	var pars = 'tipo=1' + '&cod_menulateral=' + v;

	new Ajax.Updater('div_menu_lateral', 'menuAjax.php', { method: 'post', parameters: pars } );
}

function reload_submenu(num) {
	var v = $('cod_sub_menu').value;
	if(num==1){
		var pars = 'tipo=3' + '&cod_sub_menu=' + v;
		new Ajax.Updater('submenus', 'menuAjax.php', { method: 'post', parameters: pars } );
		var pars = 'tipo=2' + '&cod_sub_menu=' + v;
	}else if(num==2){
		var v2 = $('cod_sublateral').value;
		var pars = 'tipo=2' + '&cod_sub_menu=' + v + '&cod_sublateral=' + v2;
	}
	new Ajax.Updater('div_submenu', 'menuAjax.php', { method: 'post', parameters: pars } );
}
	
function validaForm(frm){
	if(!validateForm(frm)) return false
	if(!confirm("Deseja enviar os dados digitados?")){
		return false
	}
	return true
}
function menuins() {
	NewWindow("menunew.php",400, 200);
}
function menuedit() {
	var rdcont = $('rd_cont').value;
	var codmenu = false;
	for(var a=0; a < rdcont; a++) {
		var radio = $('rd-'+a);
		if(radio.checked) {
			codmenu = radio.value;
		}
	}
	if(codmenu)
		NewWindow("menunew.php?codmenu="+codmenu,400, 200);
	else
		alert('Selecione um item na lista.');
}
function menudel() {
	var rdcont = $('rd_cont').value;
	var codmenu = false;
	for(var a=0; a < rdcont; a++) {
		var radio = $('rd-'+a);
		if(radio.checked) {
			codmenu = radio.value;
		}
	}
	if(codmenu)
	{
		if ( confirm( "Tem certeza que deseja excluir?" ) ) 
			NewWindow("menunew.php?acao=del&codmenu="+codmenu,400, 200);
	}	
			
	else
		alert('Selecione um item na lista.');
}

function submenuins(menu) {
	NewWindow("submenunew.php?menu="+menu,550, 350);
}
function submenuedit(menu) {
	var codmenu = false;
	if(menu=='lat'){
		var rdcont = $('rd1_cont').value;
		for(var a=0; a < rdcont; a++) {
			var radio = $('rd1-'+a);
			if(radio.checked) {
				codmenu = radio.value;
			}
		}
	}else if(menu=='sub'){
		var rdcont = $('rd2_cont').value;
		for(var a=0; a < rdcont; a++) {
			var radio = $('rd2-'+a);
			if(radio.checked) {
				codmenu = radio.value;
			}
		}
	}
	if(codmenu)
		NewWindow("submenunew.php?codsubmenu="+codmenu+"&menu="+menu,550, 350);
	else
		alert('Selecione um item na lista.');
}

function submenudel(menu) {
	var codmenu = false;
	if(menu=='lat'){
		var rdcont = $('rd1_cont').value;
		for(var a=0; a < rdcont; a++) {
			var radio = $('rd1-'+a);
			if(radio.checked) {
				codmenu = radio.value;
			}
		}
	}else if(menu=='sub'){
		var rdcont = $('rd2_cont').value;
		for(var a=0; a < rdcont; a++) {
			var radio = $('rd2-'+a);
			if(radio.checked) {
				codmenu = radio.value;
			}
		}
	}
	if(codmenu){
		if ( confirm( "Tem certeza que deseja excluir?" ) ) 
			NewWindow("submenunew.php?acao=del&codsubmenu="+codmenu+"&menu="+menu,400, 200);
	}	
	else
		alert('Selecione um item na lista.');
}
</script>
	

</head>
<!-- Tags HTML -->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Menu
		</td>
	</tr>
</table>		
<table width="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<!-- Menu Horizontal-->
	<tr>
		<td>
			<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" height="100%"  class="modulo1" >
							<tr>
								<td width="120" valign="middle"> &nbsp;<label for="nome">Menu Horizontal:</label></td>
								<td>
									<table>
										<tr>
											<td>
												<div class="iframe1">
					<form id="menu" name="menu" method="post" action="menunew.php" onsubmit="return validaForm(this)">
													<table width="800"  id="submenu" cellpadding="0" cellspacing="0" >
														<tr class="grid">
															<td>#</td>
															<td>Menu</td>
															<td>Status</td>
															<td>Ordem</td>
														</tr>						
														<?		
														
														$sql = "Select m.cod_menu,m.dsc_menu,s.dsc_status,m.ordem";
														$sql .= " from menu m";
														$sql .= " left join status s on m.cod_status = s.cod_status";
														$sql .= " order by ordem";
																								
														$result = sql_query($sql);
														$maxcont = mysql_num_rows($result);
														$cont = 0;
														?><input type="hidden" name="rd_cont" id="rd_cont" value="<?=$maxcont;?>"><?
														while($row = mysql_fetch_array($result)){
														?>
														<tr class="font_grid">
															<td align="center" >
																<input type="radio" name="rd" id="rd-<?=$cont;?>" value="<?=$row['cod_menu'];?>" />

															</td>
															<td align="center"><?=$row['dsc_menu'];?></td>
															<td align="center"><?=$row['dsc_status'];?></td>
															<td align="center"><?=$row['ordem'];?></td>
														</tr>
														<?
															$cont++;
														}
														mysql_free_result($result);
														?>
						
													</table>
						</form>
												</div>							
												
											</td>	
										</tr>	
										<tr>
											<td align="right">
												<input type="button" id="menuincluir" value="Incluir" onClick="menuins()" />&nbsp;
												<input type="button" id="editarmenu"  value="Editar"  onClick="menuedit()"/>&nbsp;
												<input type="button" id="excluirmenu" value="Excluir" onClick="menudel()"/>&nbsp;
												
											</td>
										</tr>		
									</table>			
								</td>		
							</tr>				
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;
			
		</td>
	</tr>
	<!--SubMenu-->	
	<tr>
		<td>
			<form id="menu_lateral" name="menu_lateral" method="post" action="submenunew.php" onsubmit="return validaForm(this)">
				<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td >
							<table width="100%" height="100%"  class="modulo1" >
								<tr >
									<td width="120" valign="middle" > &nbsp;<label for="nome">Menu Lateral:</label></td>
									<td>
										<table>
											<tr>
												<td>
													<?	
													
														$sql = "Select m.cod_menu as cod_menulateral,dsc_menu"; 
														$sql .= " from menu m";
														$sql .= " where m.cod_status=1";
														$sql .= " order by m.ordem";
														
														combo($sql, "cod_menulateral", @$_REQUEST['cod_menulateral'], " ", "onchange=reload_menulateral();");
													?>
														<script>		
															document.menu_lateral.cod_menu.value = "<?=$_REQUEST['cod_menulateral']?>";
														</script>	
													
												</td>		
											</tr>
											<tr>
												<td>
													<div class="iframe1" id="div_menu_lateral">
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
														
														$sql  = "Select sm.cod_submenu,sm.dsc_submenu,m.dsc_menu,s.dsc_status,sm.link,t.dsc_target,sm.ordem";
														$sql .= " from submenu sm";
														$sql .= " inner Join menu m on m.cod_menu =sm.cod_menu";
														$sql .= " left join status s on sm.status = s.cod_status";
														$sql .= " left join target t on sm.target = t. target";
														if(!empty($_REQUEST['cod_menulateral'] )){
														   $sql .= " where sm.cod_menu= ".$_REQUEST['cod_menulateral'];
														}
														$sql    .= " order by m.ordem, sm.ordem";
														$result  = sql_query($sql);
														$maxcont = mysql_num_rows($result);
														$cont    = 0;
														?><input type="hidden" name="rd1_cont" id="rd1_cont" value="<?=$maxcont;?>"><?
														while($row = mysql_fetch_array($result)){
														?>
														<tr class="font_grid">
															<td align="center" >
																<input type="radio" name="rd1" id="rd1-<?=$cont;?>" value="<?=$row['cod_submenu'];?>" />
															</td>
														
															<td align="center"><?=$row['dsc_submenu'];?></td>
															<td align="center"><?=$row['dsc_menu'   ];?></td>
															<td align="center"><?=$row['dsc_status' ];?></td>
															<td align="center"><?=$row['link'       ];?></td>
															<td align="center"><?=$row['dsc_target' ];?></td>
															<td align="center"><?=$row['ordem'      ];?></td>
														</tr>
														<?
															$cont++;
														}
														mysql_free_result($result);
														?>
														</table>
													</div>							
													
												</td>	
											</tr>	
											<tr>
												<td align="right">
													<input type="button" id="menuincluir" value="Incluir" onClick="submenuins('lat')"  />&nbsp;
													<input type="button" id="editarmenu"  value="Editar"  onClick="submenuedit('lat')" />&nbsp;
													<input type="button" id="excluirmenu" value="Excluir" onClick="submenudel('lat')"  />&nbsp;
													
												</td>
											</tr>				
										</table>	
									</td>
								</tr>				
							</table>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<!--Sub Menu-->
	<tr>
		<td>
			<form id="sub_menu" name="sub_menu" method="post" action="submenunew.php" onsubmit="return validaForm(this)">
				<table width="98%" height="60" border="1" class="modulo" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td >
							<table width="100%" height="100%"  class="modulo1" >
								<tr >
									<td width="120" valign="middle"> &nbsp;<label for="nome">Sub-Menu:</label></td>
									<td>
										<table>
											<tr>
												<td>
													<?	
													$sql = "Select m.cod_menu as cod_sub_menu,dsc_menu"; 
													$sql .= " from menu m";
													$sql .= " where m.cod_status=1";
													$sql .= " order by m.ordem";
													
													combo($sql, "cod_sub_menu", @$_REQUEST['cod_sub_menu'], " ", "onchange='reload_submenu(1);'");
													?>
												</td>		
											</tr>
											<tr>
												<td>
												<div id="submenus">
													<?		if(!empty($_REQUEST['cod_sub_menu'] )){
															$sql = "Select sm.cod_submenu as cod_sublateral ,sm.dsc_submenu";
															$sql .= " from submenu sm";
															$sql .= " inner Join menu m on m.cod_menu =sm.cod_menu";
															$sql .= " left join status s on sm.status = s.cod_status";
															$sql .= " left join target t on sm.target = t. target";
															$sql .= " where sm.cod_menu= ".$_REQUEST['cod_sub_menu'];
															combo($sql, "cod_sublateral", @$_REQUEST['cod_sublateral'], " ", "onchange='reload_submenu(2);'");
															}else{
															?>
															<select>
																<option></option>
															</select>
															<?
															}												
															
													?>
													</div>	
												</td>		
											</tr>
											<tr>
												<td>
													<div class="iframe1" id="div_submenu">
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
															
															$sql  = "Select sm.cod_submenu,sm.dsc_submenu,sm2.dsc_submenu menu_pai,s.dsc_status,sm.link,t.dsc_target,sm.ordem";
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
															$sql    .= " order by m.ordem, sm2.ordem, sm.ordem";													
															$result  = sql_query($sql);
															$maxcont = mysql_num_rows($result);
															$cont    = 0;
															?><input type="hidden" name="rd2_cont" id="rd2_cont" value="<?=$maxcont;?>"><?
															while($row = mysql_fetch_array($result)){
															?>
															<tr class="font_grid">
																<td align="center" >
																	<input type="radio" name="rd2" id="rd2-<?=$cont;?>" value="<?=$row['cod_submenu'];?>" />
																</td>
														
																<td align="center"><?=$row['dsc_submenu'];?></td>
																<td align="center"><?=$row['menu_pai'   ];?></td>
																<td align="center"><?=$row['dsc_status' ];?></td>
																<td align="center"><?=$row['link'       ];?></td>
																<td align="center"><?=$row['dsc_target' ];?></td>
																<td align="center"><?=$row['ordem'      ];?></td>
															</tr>
															<?
																$cont++;
															}
															mysql_free_result($result);
															?>
														</table>
													</div>							
													
												</td>	
											</tr>	
											<tr>
												<td align="right">
													<input type="button" id="menuincluir" value="Incluir" onClick="submenuins('sub')"  />&nbsp;
													<input type="button" id="editarmenu"  value="Editar"  onClick="submenuedit('sub')" />&nbsp;
													<input type="button" id="excluirmenu" value="Excluir" onClick="submenudel('sub')"  />&nbsp;
													
												</td>
											</tr>		
										</table>			
									</td>		
								</tr>				
							</table>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">&nbsp;
			
		</td>
	</tr>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
