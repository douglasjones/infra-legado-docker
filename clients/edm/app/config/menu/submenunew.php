<?
  include_once "../../libs/maininclude.php";
  include_once "../../libs/cla.menu.php";
  include_once "../../libs/combo.php" ;
  
  	$menu = $_REQUEST['menu'] ;
	$acao = ($_REQUEST['acao']?$_REQUEST['acao']:'ins');
	if($acao == 'del'){
		if( menu::excluir_sub_menu($_REQUEST['codsubmenu'])){
			javascriptalert('Operação executada com sucesso.');
			?><script type="text/javascript" language="javascript">
				if(opener){
					if(opener.top.pagina)
						opener.top.pagina.refresh();
				}
				self.close();
			</script><?
		}
	}
	if(!empty($_REQUEST['Enviar'])){
		if(empty($_REQUEST['codsubmenu'])){
			if( $codmenu = menu::adicionar_sub_menu($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}else{
			if( menu::alterar_sub_menu($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}		
	}
	
	if($_REQUEST['codsubmenu']){
		$acao = 'upd';
		$sql = "SELECT * FROM submenu WHERE cod_submenu = ".$_REQUEST['codsubmenu'];
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result))
		{
			$cod_menu			= $row['cod_menu'        ];
			$dsc_submenu		= $row['dsc_submenu'     ];
			$cod_submenu_pai	= $row['cod_submenu_pai' ];
			$link				= $row['link'            ];
			$target				= $row['target'          ];
			$cod_modulo_menu	= $row['cod_modulo_menu' ];
			$width				= $row['width'           ];
			$height				= $row['height'          ];
			$cod_acao			= $row['cod_acao'        ];
			$cod_relacionador	= $row['cod_relacionador'];
			$ordem				= $row['ordem'           ];
			$status 			= $row['status'          ];
			
			mysql_free_result($result);
		}
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<script language="javascript"></script></script>
	<title>Sub Menu</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaForm(frm){
	if(!validateForm(frm)) return false
	if(!confirm("Deseja enviar os dados digitados?")){
		return false
	}
	return true
}
function insRelacionador(){
	NewWindow("relacionadornew.php",300, 200);
}
function numeros( n )
{
	var num = document.getElementById( n ).value ;
	var tam = num.length ;
	if ( isNaN( num ) )
	{
		tam -= 1 ;
		document.getElementById( n ).value = num.substring( 0 , tam ) ; 
	}
}

	</script>
	
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<!-- Tags HTML -->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="dados" method="post" action="submenunew.php" onsubmit="return validaForm(this)">
	<input type="hidden" id="codsubmenu" name="codsubmenu" value="<?=@$_REQUEST['codsubmenu'];?>" />
	<input type="hidden" id="acao" name="acao" value="<?=$acao?>"/>
	
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Menu
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="3" cellspacing="3" class="form">
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tr>
		<td> &nbsp;<label for="dsc_submenu">Nome:</label></td>
		<td>
			<input type="text" id="dsc_submenu" name="dsc_submenu" value="<?=$dsc_submenu;?>" size="43" maxlength="43" />
		</td>
	</tr>
<?	if($menu == 'lat'){?>
	<tr>
		<td> &nbsp;<label for="cod_menu">Menu Pai:</label></td>
		<td>
		<?
				$sql = "SELECT cod_menu , dsc_menu FROM menu WHERE 1" ;

				combo( $sql , "cod_menu" , $cod_menu , "" , "" , "" );
		?>
		</td>
<?	}else{  ?>
	<tr>
		<td> &nbsp;<label for="sub_menu_pai">Menu Pai:</label></td>
		<td> 
		<?
				$sql = "SELECT cod_submenu , dsc_submenu FROM submenu WHERE cod_submenu_pai is null order by dsc_submenu";

			combo( $sql , "cod_submenu_pai", $cod_submenu_pai, "", "", "");
		?>
		</td>
	</tr>
<?	
	}	
?>
	
	<tr>
		<td> &nbsp;<label for="status">Status:</label></td>
		<td>
<?
				$sql = "SELECT cod_status , dsc_status FROM status WHERE 1" ;
				combo( $sql , "status" , $status , "" , "" , "" ) ;
?>
			
		</td>
	</tr>
		<tr>
			<td> &nbsp;<label for="link">Link:</label></td>
			<td>
				<input type="text" id="link" name="link" value="<?= $link ; ?>" size="70" maxlength="200" />
			</td>
		</tr>
		<tr>
			<td> &nbsp;<label for="target">Tipo Chamada:</label></td>
			<td>
				<? 
					$sql = "SELECT target , dsc_target FROM target WHERE 1" ;
					combo( $sql , "target" , $target , "" , "" , "" ) ;
				?>	
		</tr>
		<tr>
			<td> &nbsp;<label for="cod_modulo_menu">Módulo Menu:</label></td>
			<td>
				<? 
					$sql = "SELECT cod_modulo_menu , dsc_mudulo_menu FROM modulo_menu WHERE 1" ;
					combo( $sql , "cod_modulo_menu" , $cod_modulo_menu , "" , "" , "" ) ;
				?>	
		</tr>
		
	<?	if( $acao == "upd" )
		{?>
			<tr>				<td> &nbsp;<label for="ordem">Ordem:</label></td>
				<td>
						<input onkeyup="numeros( this.id )" type="text" id="ordem" name="ordem" value="<?=$ordem;?>" size="5" maxlength="5" />
					</td>
			</tr>
	<?	} ?>

		<tr>

			<td> &nbsp;<label for="width">Largura:</label></td>

			<td>

				<input onkeyup="numeros( this.id );" type="text" id="width" name="width" value="<?=($width?$width:0);?>" size="5" maxlength="5" />

			</td>

		</tr>

		<tr>

			<td> &nbsp;<label for="height">Altura:</label></td>

			<td>

				<input onkeyup="numeros( this.id );" type="text" id="height" name="height" value="<?=($height?$height:0);?>" size="5" maxlength="5" />

			</td>

		</tr>

		<tr>

			<td> &nbsp;<label for="acao">Ação:</label></td>

			<td>

			<?

				$sql = "SELECT cod_acao, dsc_acao, status FROM acao WHERE 1" ;

				$tipos[0]['valor'] = '0';

				$tipos[1]['valor'] = 1;

				$tipos[0]['style'] = 'color:#990000';

				$tipos[1]['style'] = 'color:#000000';

				$tipos['max'] = 2;

				combo_meta( $sql , "cod_acao" , $tipos ,$cod_acao , "" , "" , "", 10 , 0 , 'Padrão' , 'Nenhuma' ) ;

			?>	

			</td>

		</tr>

		<tr>

			<td> &nbsp;<label for="cod_relacionador">Relacionador:</label></td>

			<td>

			<?

				$sql = "SELECT cod_relacionador , CONCAT_WS(' - ', dsc_tabela, dsc_relacionador), status FROM relacionador WHERE 1" ;

				$tipos[0]['valor'] = '0';

				$tipos[1]['valor'] = 1;

				$tipos[0]['style'] = 'color:#990000';

				$tipos[1]['style'] = 'color:#000000';

				$tipos['max'] = 2;				combo_meta( $sql , "cod_relacionador" , $tipos, $cod_relacionador , "" , "" , "", 0, null, 'Nenhum', null ) ;

			?>	

			<a href="javascript:insRelacionador();"><img src="../../images/add.gif" alt="inserir relacionadores" height="15" border="0" style='border: 0px; padding: 1px;'></a>

			</td>

		</tr>			



	<tr>

		<td colspan="2" align="right">

			<input type="submit" class="botao" name="Enviar" value="Enviar" />&nbsp;

			<input type="button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;

		</td>

	</tr>

	

</table>

	</form>

</body>

</html>

<?	include_once "../../libs/desconectar.php";?>

