<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.propostas.php";

	$usr = (@$_REQUEST['usr']?$_REQUEST['usr']:null);
	$dti = (@$_REQUEST['dti']?$_REQUEST['dti']:null);
	$dtf = (@$_REQUEST['dtf']?$_REQUEST['dtf']:null);
	$dti2 = (@$_REQUEST['dti2']?$_REQUEST['dti2']:null);
	$dtf2 = (@$_REQUEST['dtf2']?$_REQUEST['dtf2']:null);

	$det = propostas::getDetVendas($usr, $dti, $dtf, $dti2, $dtf2);
?>
<table>
	<thead>
		<th>Detalhes</th>
	</thead>
	<tbody>
<?	//for($i = 0; $i<$det['maxbd'];$i++){
//		while($row = mysql_fetch_array($det[$i])){
		while($row = mysql_fetch_array($det)){ ?>
		<tr>
			<td><? print $row['data'];?> - <a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row['CodLead']?>" target="pagina"><?=htmlentities($row['lead'])?></a></td>
		</tr>
<?		}
		mysql_free_result($det);
//	}
?>
	</tbody>
	<tfoot>
		<th><input type="button" value="Fechar" onclick="javascript:closeDetVendas();" /></th>
	</tfoot>
</table>
