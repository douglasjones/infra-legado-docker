<?
session_start();
include_once "libs/conectar.php";
include_once "libs/combo.php";
include_once "libs/head.php";
conectar(1);
?>
<html>
<head>
<title>Menu</title>
<link rel="stylesheet" href="extras/public1.css" type="text/css">
<script type="text/javascript" language="JavaScript" src="extras/prototype.js"></script>
<script type="text/javascript" language="JavaScript" src="extras/public.js"></script>
<script type="text/javascript" language="javascript">
<? if ($_SESSION['codusuario'] <> "") {?>

function alteraSenhaUsuario(codusuario){
	NewWindow("admnistracao/usuario/alterasenhausuario.php?codusuariointerno=" + codusuario,400,150)
}
var retornos
function init(){
	 retornos = new Ajax.PeriodicalUpdater('retornos', 'notificaretorno.php', {frequency: 600, evalScripts: true})
}
Event.observe(window, 'load', init);
<?}?>
var obj2 ;
var j = 999 ;
function modulo_link(obj,cod_menu,link,posMenu)
{
	var minhaTr = $( "menuTopo" ) ;
	
	for ( var i = 0 ; i < minhaTr.cells.length ; i++ )
	{		
		if ( posMenu == i )
			obj.className   = "m_horizontal_item" ;
		else if ( j == i )
			obj2.className   = "m_horizontal_item" ;
	}
	
	obj2 = obj ;
	j = posMenu ;	
	
	if ( link == 'blank.php' )
		top.frames['menu'].location = "menu_lateral.php?&cod_menu=" + cod_menu ;
	
	else
		top.frames['menu'].location = "menu_blank.php" ;
		
	top.frames['pagina'].location = link ;
}
function change_class( obj ) 
{
	if ( obj.className == "m_horizontal_item" ) 
	{
		obj.className = "m_horizontal_item_hover"
	} 
	else 
	{
		if ( obj.className == "m_horizontal_item_hover" ) 
		{
			obj.className = "m_horizontal_item"
		}
	}
}

</script>
</head>
<body background="images/fundo_horizontal4.png "  >
<form name="topo" method="post" action="login.php">
<div id="header">
<!--Menu Horizontal-->
<table width="100%" height="40"   border="0"  cellpadding="0" cellspacing="0">
    <?if ($_SESSION['codusuario'] == "") {?>
        <tr>
            <td align="right" class="texto_label" >
    				<font color="white">Login:</font>
    				<input type="text" class="input" name="login" value="" size="10" maxlength="50">
    				<font color="white">Password:</font>
    				<input type="password" class="input" name="senha" value="" size="10" maxlength="50">
    				<input  class="botao" type="submit" name="enviar" value="OK">&nbsp;
            </td>
        </tr>
    <?}else{?>
        <tr>
            <td>
                <table border="0"   cellpadding="0" cellspacing="0" height="90"  >
    				<tr height="20" id="menuTopo">
    					<?                               
    						$sql  = "Select m.cod_menu,m.dsc_menu,m.ordem,m.link";
    						$sql .= "  from menu m";
    						$sql .= "  inner join grupo_menu gm on m.cod_menu = gm.cod_menu and acessar<>0";
    						$sql .= "  inner join gruposusuariosinternos_usuariosinternos gu on gm.codgrupousuariointerno = gu.codgrupousuariointerno";
    						$sql .= "  inner join usuariosinternos ui on gu.codusuariointerno = ui.codusuariointerno";
    						$sql .= "  Where ui.codusuariointerno=".$_SESSION['codusuario'];
    						$sql .= "  and cod_status = 1 ";
    						$sql .= "  group by m.cod_menu";
    						$sql .= "  order by m.ordem";
						    
						    $result = mysql_query($sql) or die (mysql_error());
						    
						    ?>
						    
    				        <div id="retornos" style="display:none"></div>
						      <div class="menu_lateral"><?
						          $j = 0 ;
						          while($rs = mysql_fetch_array($result)){?>
            						<td valign="baseline" height="5">
            							<div class="m_horizontal_item" style="cursor:pointer;" onclick=modulo_link(this,"<?=$rs['cod_menu'];?>","<?=$rs['link'];?>","<?=$j;?>") onmouseover="change_class(this)" onmouseout="change_class(this)">
            							<?=$rs['dsc_menu'];?>
            							</div>
            						</td><?	
						            $j++ ;
						          }?>
                               </div>                                     
                      
                            

                        <td align="right" valign="baseline" width="90%" class="texto_label" >
                        <font color="white">Login:   <b><?=($_SESSION['login']);?></b>&nbsp;&nbsp;Usu&#225;rio:  <b><?=($_SESSION['nomeusuario']);?></b></font>&nbsp;&nbsp;
                            	<!--ref="javascript:alteraSenhaUsuario(<?=$_SESSION['codusuario']?>);" class="texto_label">Alterar Senha</a>-->
				                <input class="botao" type="submit" name="logoff" value="Logoff" onchange="">&nbsp;
                        </td>    
    				</tr>
                    
                </table>
            </td>
        </tr>
    <?}?>
</table>
</div>
</body>
</html>

