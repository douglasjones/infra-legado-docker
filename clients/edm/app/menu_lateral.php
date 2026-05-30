<?


include_once "libs/maininclude.php";
include_once "libs/combo.php";

?>
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="extras/public1.css" type="text/css">
<title>Menu Lateral</title>

<!--Comandos Javascript-->
<script>
function change_class(obj) {
if (obj.className == "m_lateral_item") {
	obj.className = "m_lateral_item_hover"
} else {
	if (obj.className == "m_lateral_item_hover") {
		obj.className = "m_lateral_item"
	}
}
}
function getSel(){
var rd = top.frames['pagina'].document.getElementsByName('rd')
var retorno = ""
if(rd)
	if(rd.length)
		for(i=0;i<rd.length;i++)
			if(rd[i].checked)
				retorno = rd[i].value
	else
		if(rd.checked)
			retorno = rd.value
return retorno
}
function openWin(cURL,target,acao,cod,w,h,relacionador,cod_submenu){

if(target==1){
	
	if(acao=='dt'){
		if(cod!=""){
			url=(cURL+"?acao="+acao+"&"+relacionador+"="+cod);

			parent.location.href="blank.php"+""

		}else{
			alert('Selecione um item por favor !');
			return
		}
		}
		//Editar Registro
	if(acao=='al' || acao=='cp'){
		if(cod!=""){
			url=(cURL+"?acao="+acao+"&"+relacionador+"="+cod);
			parent.pagina.location.href=url ;
			//window.open(url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=no")
		}else{
			alert('Selecione um item por favor !');
			return
		}
	}
	//Excluir Registro Função correção excluir item 08.03.10
   	if(acao=='ex')	{
   
		if( cod != "" )
		{
		
			//if( cod_submenu == 31 || cod_submenu == 35 || cod_submenu == 39 || cod_submenu == 75 )
			//{
			
				if( confirm( "Deseja excluir o registro selecionado?" ) )
				{
					url = ( cURL + "?acao=" + acao + "&" + relacionador + "=" +  cod ) ;
					parent.pagina.location.href=url ;
				}
			//}
			//else
			//{
			//	url = ( cURL + "?acao=" + acao + "&" + relacionador + "=" + cod ) ;
			//	window.open( url , "" , "toolbar=no,status=no,menubar=no,scrollbars=yes,width=" + w + ",height=" + h + " ,resizable=no" ) ;
			//}
		}
		else
		{
			alert( 'Selecione um item por favor !' ) ;
		return ;
		}
	}	

	if(acao=='cs'){
		url=(cURL+"?acao="+acao);
		parent.pagina.location.href=url
	}
	if(acao==''){
		url=(cURL+"?acao="+acao);
		parent.pagina.location.href=url
	}
}else{
//popup
	//Novo Registro
	if(acao=='ic'){
		window.open(cURL,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
	}
	//Pesquisar

	if(acao=='cs'){
		url=(cURL+"?acao="+acao)
		window.open(url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
	}

	//Editar Registro
	if(acao=='al' || acao=='cp'){
		if(cod!=""){
			url=(cURL+"?acao="+acao+"&"+relacionador+"="+cod);
			window.open(url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
		}else{
			alert('Selecione um item por favor !');
			return
		}
	}
	//Visualizar Registro
   	if(acao=='dt'){
		if(cod!=""){
			url=(cURL+"?acao="+acao+"&"+relacionador+"="+cod);
			window.open(url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
		}else{
			alert('Selecione um item por favor !');
			return
		}
	}	
	//imprimir
	if(acao=='ip'){
		if(cod!=""){
			if (relacionador=='codproposta'){
				var v = cod.split('.')
				url=(cURL+"?acao="+acao+"&codproposta="+v[0]+"&versao="+v[1]+"&codlead="+v[2]);
				window.open(url,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
			}
		}else{
			alert('Selecione um item por favor !');
			return
		}
	}
	if(acao==''){
		window.open(cURL,"","toolbar=no,status=no,menubar=no,scrollbars=yes,width="+w+",height="+h+",resizable=yes,maximized=yes")
	}
}
}

function mudaLinha (rowIndex) {
	var l = "2"
	var i = 0
	for (i=0;i<=4;i++) {
    	var linha = document.getElementById('tabelaEsconde').rows[l];
		if (linha){
		linha.style.display ='none';
		}
		l = ((new Number(l)) + (new Number("3")));
	}
		var linha = ( document.all ? document.all.tabelaEsconde : document.getElementById('tabelaEsconde')).rows[rowIndex];
		linha.style.display = ( linha.style.display == 'none' ? '' : 'none' );
}
function escondelinha() {
	var l = "2"
	var i = 30
	for (i=0;i<=30;i++) {
    	var linha = document.getElementById('tabelaEsconde').rows[l];
		try{
			linha.style.display ='none';
		}
		catch(e){
			//em caso de erro, não faz nada
			//alert(e.message);
		}
		l = ((new Number(l)) + (new Number("3")))
	}
}
</script>
<style >
   <!--
      body {scrollbar-face-color: #FFFFFF; scrollbar-shadow-color: #ffffff; scrollbar-highlight-color: #ffffff; scrollbar-3dlight-color: white; scrollbar-darkshadow-color: white; scrollbar-track-color: white; scrollbar-arrow-color: #315599}
   //-->
 </style>
</head>
<body scroll="yes" onload="escondelinha();" background="images/">
<!--HTML-->
<table align="left  ">
 <tr>
 	<td class="texto_label">
&nbsp;
<?
$mes_num = date("m");// Nome do mês em número. Ex.: 01 =&gt; January, 02 =&gt; February
$mes_port = $mes_num;// Atribuição de variáveis
echo date(" d  ");
if($mes_port == '01'){
print("Janeiro");
}elseif($mes_port == '02'){
print("Fevereiro");
}elseif($mes_port == '03'){
print("Março");
}elseif($mes_port == '04'){
print("Abril");
}elseif($mes_port == '05'){
print("Maio");
}elseif($mes_port == '06'){
print("Junho");
}elseif($mes_port == '07'){
print("Julho");
}elseif($mes_port == '08'){
print("Agosto");
}elseif($mes_port == '09'){
print("Setembro");
}elseif($mes_port == '10'){
print("Outubro");
}elseif($mes_port == '11'){
print("Novembro");
}elseif($mes_port == '12'){
print("Dezembro");
}
echo date(" , Y");
?>
		</td>
	</tr>
</table>
<?
$modulo = "";
if(isset($_REQUEST['cod_menu']))
	{
	$cod_menu = $_REQUEST['cod_menu'];
	}
else
	{
	$cod_menu = 0;
	}
$sql = "select sm.*,a.dsc_acao from submenu sm left join acao a on sm.cod_acao = a.cod_acao where cod_menu = ";
$sql .= $cod_menu." and sm.status=1 order by sm.ordem";
$result = mysql_query($sql) or die (mysql_error());

?>
<table width="100%" border="0" id="tabelaEsconde" cellpadding="0" cellspacing="0" >
<?
$line = 2;
while($rs = mysql_fetch_array($result)){?>
	<tr>
		<td>
		</td>
		<td width="93%">
			<HR WIDTH=70% ALIGN=LEFT NOSHADE color="#000066">
		</td>
		<td>
		</td>
	</tr>
	<tr>
		<td colSpan="5"   ONCLICK="mudaLinha(<?=$line;?>);" >

			<div id="<?=$rs1['dsc_submenu'];?>" class="m_lateral_principal_item" style="cursor:pointer;" onclick="openWin('<?=$rs['link'];?>','<?=$rs['target'];?>','<?=$rs['dsc_acao'];?>',getSel(), '<?=$rs['width'];?>','<?=$rs['height'];?>','<?=$rs['dsc_relacionador'];?>')"  onmouseover="change_class(this)" onmouseout="change_class(this)">
				&nbsp;<?=$rs['dsc_submenu'];?>
			</div>
		</td>
	</tr>
	    <tr>
			<td>
			</td>
			<td>
<?
				$cod_submenu_pai = $rs['cod_submenu'];
				$hir_pai = 0;
				$hir_pai = $hir_pai +1;

				$sql = "SELECT sm.link ,
							   sm.target ,
							   ac.dsc_acao ,
							   sm.cod_submenu ,
							   sm.width ,
							   sm.height ,
							   r.dsc_relacionador ,
							   sm.dsc_submenu
						  FROM submenu sm
					INNER JOIN acao ac
							ON sm.cod_acao = ac.cod_acao
					 LEFT JOIN relacionador r
					 		ON sm.cod_relacionador = r.cod_relacionador
					 	 WHERE cod_submenu_pai = {$cod_submenu_pai}
					 	   AND sm.status = 1
					  ORDER BY sm.ordem " ;

				$result1 = mysql_query($sql) or die (mysql_error());
				$num1 = mysql_num_rows($result1);
				if($num1 == 0) $cod_submenu_pai="";
				while($rs1 = mysql_fetch_assoc($result1)){
?>
				<div id="<?=$rs1['dsc_submenu'];?>" class="m_lateral_item" style="cursor:pointer;" onclick="openWin('<?=$rs1['link'];?>','<?=$rs1['target'];?>','<?=$rs1['dsc_acao'];?>',getSel(), '<?=$rs1['width'];?>','<?=$rs1['height'];?>','<?=$rs1['dsc_relacionador'];?>','<?=$rs1['cod_submenu'];?>')"  onmouseover="change_class(this)" onmouseout="change_class(this)">
					&nbsp;&nbsp;&nbsp;<?=$rs1['dsc_submenu'];?>
				</div>

<?
	$cod_submenu_pai = $rs1['cod_submenu'];

	}
?>
			</td>
		</tr>

<?

$line = $line + 3;
}
?>
  </table>
</body>
</html>
<?	include_once "libs/desconectar.php";?>
