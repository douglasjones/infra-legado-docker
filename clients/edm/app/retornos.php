<?	
include_once "libs/maininclude.php";?>
<html>
<head>
<!-- CSS -->
    <link rel="stylesheet" href="extras/public.css" type="text/css">
    <link rel="stylesheet" href="extras/datepicker.css" type="text/css">
	<?	include_once "libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="extras/prototype.js"></script>
<!-- Javascripts -->
<script type="text/javascript" language="javascript">
function abrirRetorno(codag){
	window.open('retorno.php?codagendaretorno='+codag, 
		'retorno'+ codag,
		'top=100,left=100,height=150,width=300,scrollbars=yes');
}

function fecha(){
window.close();
}

function espera()
{
	setTimeout( "fecha()" , 1000 ) ;
}

</script>
</head>
<body>
    <?php 
        date_default_timezone_set('America/Sao_Paulo');
        $data =  date('d/m/y');
        $hora = date('H:i:s');			

        $data =  date('y-m-d');
        $horarioverao = $data." ".$hora; 
        $sql = "Select 
                                oc.dt_retorno
                                ,oc.CodLead
                                ,oc.Descricao
                                ,l.RazaoSocial 
                                ,ui1.Nome
                                ,tc.descricao as tipo
                        from ocorrenciaslead oc 
                                inner join leads l on oc.CodLead = l.CodLead 
                                inner join usuariosinternos ui on oc.agendadopara = ui.CodUsuarioInterno 
                                inner join usuariosinternos ui1 on oc.CodUsuarioInterno = ui1.CodUsuarioInterno
                                left join tipoocorrenciaslead tc on oc.codtipoocorrencialead = tc.codtipoocorrencialead ";
        $sql .= " where oc.dt_retorno <='$horarioverao'";
        $sql .= " And oc.agendadopara = " . mysqlnull($_SESSION['codusuario']);
        $sql .= " And oc.dt_retorno_fechamento Is Null";
        $sql .= " Order By oc.dt_retorno";

        $rs = sql_query($sql, null, false);
        $total = mysql_num_rows ($rs);    
    ?>
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Retornos - <?= $total;?> registro(s)
		</td>
	</tr>
</table>
<table width="98%" border="0" align="center" class="borda_tabela" cellpadding="0" cellspacing="0">
	<tr>
		<td>
				<table  width="100%"  height="%"    cellpadding="0" cellspacing="0"  >
					
						<tr  class="font_grid">						
							<td width="120" align="center" >Horário:</td>
							<td width="200" align="center">Lead:</td>
							<td width="150" align="center">Descrição:</td>
							<td width="150" align="center">Tipo OC:</td>							
							<td width="120"align="center">Atraso:</td>
							<td width="120"align="center">User de Abertura:</td>   
						</tr> 
					
					<?php

					$left = 0;
					
					//set a variavel cor para o branco
					$cor = "#ffffff";
					while($row = mysql_fetch_array($rs)){ 
						//muda a cor a cada passagem do loop
						if($cor=="#dfdfdf"){
							$cor = "#ffffff";
						}Else{
							$cor = "#dfdfdf";
						}
						
						//$satraso = time() - strtotime($row['DataRetorno']);
						$satraso = strtotime('+0 hours') - strtotime($row['dt_retorno']);
						$datraso = floor($satraso/(60*60*24));
						$hatraso = floor(($satraso/(60*60*24)-$datraso)*24);
						$matraso = floor(($satraso/60)-($hatraso*60)-($datraso*24*60));
						$atraso = ($datraso?$datraso."d ":'').($hatraso?$hatraso."h ":'').($matraso?$matraso."min":'')
						?>
					<tr class="link_cinza" bgcolor="<?=$cor?>" >
						<td align="center"><?=date( "d/m/Y - H:i",strtotime($row['dt_retorno']));?></td>
						<td align="center"><a href="vendas/leads/leadgerenciamentores.php?codlead=<?=$row['CodLead'];?>"  target="pagina" onClick="espera();" ><?=$row['RazaoSocial'];?></a></td>
						<td align="center"><?=$row['Descricao'];?></td>
						<td align="center"><?=$row['tipo'];?></td>
						<td align="center"><?=$atraso;?></td>
						<td align="center"><?=$row['Nome'];//Inclus�o de campo usuario de abertura  01/02/2010?></td>
					</tr>
					</tbody>
				<?	}
					mysql_free_result($rs); 
?>				<table>	
		</td>
	</tr>		
</table>
</body>
</html>