<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
include_once "../../libs/cla.equipes.php";
$cod_polo = $_REQUEST['cod_polo'];

?>
<html>
<head>
	<title>Gepros</title>
	<script src="../../extras/FusionCharts.js" type="text/javascript"></script>
	
	<style>
	.titulo{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 12px;
		color : #ffffff;
		font-weight : bold;
		text-align : center ;
		background-image: url("../../images/barra_topo.png");*/
	}	
	.form{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 12px;
		font-weight : bold;
		text-align : center ;
	}		
	
	.linha{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 12px;
	}
	
	.linha1{
		background-color: #E5E5E5;
		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 12px;
	}	
	
	.grid{
		background-image: url("../../images/header_bg.gif");
		width:100%;
		height:30;
		text-decoration:none;

		font-family: Verdana, Arial, Helvetica, sans-serif;
		FONT-SIZE: 10px;
		color : #000000;
		font-weight : bold;
		text-align : center ;
	}
	
	</style>
	<script>
		function selecionaPolo(vlr){
			var frm = document.forms[0];
			frm.submit();
		}
		
		function carregarGraficos(v_cod_polo){
                      
           var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("valor_proposta_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_valor_proposta");
            
            var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("quantidade_linhas_proposta_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_quantidade_linhas_proposta");
            
			var chart = new FusionCharts("../swf/FCF_Funnel.swf", "ChartId", "250", "300");
			chart.setDataURL("funil_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_funil");
			           
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("contratos_fechados_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_contratos_fechados");
			
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("oportunidades_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_oportunidades");
			
			var chart = new FusionCharts("../swf/FCF_Column3D.swf", "ChartId", "500", "350");
			chart.setDataURL("oportunidades_a_vencer_xml.php?cod_polo="+v_cod_polo);		   
			chart.render("div_oportunidades_a_vencer");
			
			var chart = new FusionCharts("../swf/FCF_StackedColumn3D.swf", "ChartId", "500", "350");
			chart.setDataURL("agendamento_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_agendamento");
			
			var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "500", "350");
			chart.setDataURL("ocorrencias_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_ocorrencias");

			var chart = new FusionCharts("../swf/FCF_StackedBar2D.swf", "ChartId", "500", "350");
			chart.setDataURL("ocorrencias_xml.php?cod_polo="+v_cod_polo);
			chart.render("div_produtividade_comercial");
			
		}
		
	</script>
</head>

<body onload="carregarGraficos('<?= $cod_polo?>')">
<form method="get">
<table width="100%">
	<TR>
		<TD class='titulo'>
		Painéis
		</TD>
	</TR>
	<tr>
		<Td>
			<table align="center">
				<TR>
					<TD class='form'>Pólo: </TD>
					<TD class='form'>
						<?
						$sql = "select cod_polo, n_polo from polo where dat_canc is null order by 2 asc";
            					combo($sql, "cod_polo", $cod_polo, " ", " onchange=selecionaPolo(this.value) ");
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="100%">
	<TR>
		<TD class='titulo'>
		Meu Dia - 
		<?
		$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') hoje ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo $row['hoje'];
		}
		mysql_free_result($result);
		?>
		</TD>
	</TR>
	<tr>
		<Td>
			<table align="center">
				<TR>
					<TD class='form'>Visitas do Dia: </TD>
					<TD class='form'>
						<?
						$sql ="";
						$sql.="select count(*) total ";
						$sql.="  from agendaslead ag ";
						$sql.="       inner join leads l on ag.codlead = l.codlead ";
						$sql.=" where ag.datahorario between date_format(sysdate(),'%Y-%m-%d 00:00:00') ";
						$sql.="   and date_format(sysdate(),'%Y-%m-%d 23:59:59') ";
						$sql.="   and ag.codtipo = 1 ";
						$sql.="   and (ag.codstatus is null or ag.codstatus in (1,2)) ";
						$sql.="   and ag.codreagendamento is null ";						
						if($cod_polo != "")
							$sql.=" and l.cod_polo = $cod_polo ";
							
						//COLOCA OS DEMAIS PARÂMETROS
						if(!permissao('visualizar_todos_consultores', 'cs'))
							$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
						if(!permissao('visualizar_todos_atendentes', 'cs'))
							$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
							
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);
						echo $row['total'];
						mysql_free_result($result);
						?>
					</TD>
				</TR>
				<TR>
					<TD class='form'>Agendamentos: </TD>
					<Td class='form'>
						<?
						$sql ="";
						$sql.="select count(*) total ";
						$sql.="  from agendaslead ag ";
						$sql.="       inner join leads l on ag.codlead = l.codlead ";
						$sql.=" where (ag.datacadastro between date_format(sysdate(),'%Y-%m-%d 00:00:00') ";
						$sql.="   and date_format(sysdate(),'%Y-%m-%d 23:59:59')) ";
						$sql.="   and ag.codtipo = 1 ";
						$sql.="   and ag.cod_motivo_reagendamento is null ";
						$sql.="   and ag.codreagendamento is null ";
						if($cod_polo != "")
							$sql.=" and l.cod_polo = $cod_polo ";
							
						//COLOCA OS DEMAIS PARÂMETROS
						if(!permissao('visualizar_todos_consultores', 'cs'))
							$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
						if(!permissao('visualizar_todos_atendentes', 'cs'))
							$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
						
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);
						echo $row['total'];
						mysql_free_result($result);
						?>
					</td>
				</TR>
				<TR>
					<TD class='form'>Prospecções: </TD>
					<Td class='form'>
						<?
						$sql ="";
						$sql.="select count(*) total ";
						$sql.="  from leads l ";
						$sql.="       inner join contatoslead cl on l.codlead = cl.codlead ";
						$sql.=" where l.datacadastro between date_format(sysdate(),'%Y-%m-%d 00:00:00') ";
						$sql.="   and date_format(sysdate(),'%Y-%m-%d 23:59:59') ";
						if($cod_polo != "")
							$sql.=" and l.cod_polo = $cod_polo ";
						
						//COLOCA OS DEMAIS PARÂMETROS
						if(!permissao('visualizar_todos_consultores', 'cs'))
							$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
						if(!permissao('visualizar_todos_atendentes', 'cs'))
							$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
						
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);
						echo $row['total'];
						mysql_free_result($result);
						?>
					</td>
				</TR>				
				<TR>
					<TD class='form'>Oportunidades Identificadas: </TD>
					<Td class='form'>
						<?
						$sql ="";
						$sql.="select count(*) total ";
						$sql.="  from ocorrenciaslead oc ";
						$sql.="       inner join leads l on oc.codlead = l.codlead ";
						$sql.=" where oc.datacadastro between date_format(sysdate(),'%Y-%m-%d 00:00:00') ";
						$sql.="   and date_format(sysdate(),'%Y-%m-%d 23:59:59') ";
						$sql.="   and oc.codtipoocorrencialead = 5000 ";
						if($cod_polo != "")
							$sql.=" and l.cod_polo = $cod_polo ";
							
						//COLOCA OS DEMAIS PARÂMETROS
						if(!permissao('visualizar_todos_consultores', 'cs'))
							$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
							
						if(!permissao('visualizar_todos_atendentes', 'cs'))
							$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
						
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);
						echo $row['total'];
						mysql_free_result($result);
						?>
					</td>
				</TR>	
			</table>
		</TD>
	</Tr>
</table>
<table border="0" width="100%" cellpadding="1" cellspacing="1">
    	<tr>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Valor Proposta(s)</TD></TR>
    			</table>		
    			<div id="div_valor_proposta" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Linhas Novas</TD></TR>
    			</table>		
    			<div id="div_quantidade_linhas_proposta" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>	
	</tr>
	<tr>
    		<td valign="top" class="text" align="center"> <div id="chartdiv" align="center"> 
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Funil de Vendas</TD></TR>
    			</table>
    			<div id="div_funil" align="center"></div>
			<script type="text/javascript">
			</script> 
		</td>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Contratos Fechados - Últimos 3 meses</TD></TR>
    			</table>		
    			<div id="div_contratos_fechados" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>
	</tr>
	<tr>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Oportunidades Identificadas - Últimos 12 meses</TD></TR>
    			</table>		
    			<div id="div_oportunidades" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Vencimento de Contratos - Próximos 6 meses</TD></TR>
    			</table>		
    			<div id="div_oportunidades_a_vencer" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>	
	</tr>
	<tr>
    		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class="titulo">Agendamentos</TD></TR>
    			</table>		
    			<div id="div_agendamento" align="center"></div>
			<script type="text/javascript">
			</script> 	
		</td>
		<td valign="top" class="text" align="center">
    			<table align="center" width="100%">
    				<TR><TD align="center" class='titulo'>Ocorrências do Dia</TD></TR>
    			</table>				
    			<div id="div_ocorrencias" align="center"></div>
			<script type="text/javascript">
			</script> 		
		</td>
	</tr>	
</table>
</form>
</body>
</html>
<?
include_once "../../libs/desconectar.php";
?>
