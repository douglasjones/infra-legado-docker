<?

$arquivo = date("Ymd_His").".sa3";

header ("Content-type: application/x-msexcel");
header ("Cache-control: no-cache,max-age=0,must-revalidate");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );

include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;
include_once( "../../libs/cla.ocorrencias.php" ) ;

//Recebe os codigos dos agendamentos para exportação
$codagendalead = $_REQUEST['codagendalead'];

echo count($codagendalead)."\n";

for($i = 0; $i < count($codagendalead); $i++){
	$sql ="";
	$sql.="select l.endereco, l.numero, l.bairro, l.cep, l.codlead, al.codagendalead, l.razaosocial, l.cnpj_cpf, l.cidade, l.uf, cl.nomecontato, cl.email, l.ddd, l.tel, ui.nome gerenteconta, ui.codigosa3, date_format(al.datahorario,'%d/%m/%Y') dataagendamento, date_format(al.datahorario,'%H:%i') horaagendamento, date_format(al.termino,'%H:%i') termino, al.informacoes, date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato, l.qtde_linhas, (l.vencimentocontrato > sysdate()) vencimentovalido ";
	$sql.="  from leads l ";
	$sql.="		inner join agendaslead al on l.codlead = al.codlead ";
	$sql.="         inner join contatoslead cl on al.codcontatolead = cl.codcontatolead ";
	$sql.="         inner join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno ";
	$sql.=" where al.codagendalead = ".$codagendalead[$i];
	$sql.="   order by l.razaosocial ";

	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){

		echo formatarSA3($row["cnpj_cpf"]).";";
		echo formatarSA3($row["razaosocial"]).";";
		echo formatarSA3($row["cidade"]).";";
		echo formatarSA3($row["uf"]).";";
		echo formatarSA3($row["nomecontato"]).";";
		echo "(".$row["ddd"].")".$row["tel"].";";
		echo formatarSA3($row["gerenteconta"]).";";
		echo formatarSA3($row["codigosa3"]).";";
		echo formatarSA3($row["email"]).";";
		echo formatarSA3($row["dataagendamento"]).";";
		echo formatarSA3($row["horaagendamento"]).";";
		echo formatarSA3($row["termino"]).";";
		echo formatarSA3($row["informacoes"]).";";

		//---------------------------
		//Pega a primeira operadora
		$sql ="";
		$sql.="select o.cod_operadora, o.cod_sa3 ";
		$sql.="  from leads_operadoras lo ";
		$sql.="       inner join operadoras o on lo.cod_operadora = o.cod_operadora";
		$sql.=" where lo.codlead = ".$row["codlead"]. " and o.cod_sa3 > 0  limit 1 ";

		$rs_operadora = mysql_query($sql);
		$row_operadora = mysql_fetch_array($rs_operadora);
		$cod_sa3 = $row_operadora["cod_sa3"];
		mysql_free_result($rs_operadora);
		//fim da primeira Operadora

		echo formatarSA3($cod_sa3).";";
		echo formatarSA3($row["qtde_linhas"]).";";

		if($row['vencimentovalido'] == 1)
			echo formatarSA3($row["vencimentocontrato"]).";";
		elseif ($row["vencimentovalido"] == 0)
			echo formatarSA3(date('d/m/Y',mktime(0,0,0,date('m'),date('d')+1,date('Y')))).";";

		echo formatarSA3($row["endereco"]).";";
		echo formatarSA3($row["numero"]).";";
		echo formatarSA3($row["bairro"]).";";
		echo formatarSA3($row["cep"]).";";
		
		echo "\n";
		
		$sql = "update agendaslead set ic_arquivogerado = 1, dt_arquivogerado = sysdate() where codagendalead = ".$row["codagendalead"];
		
		mysql_query($sql);
		
		//gera a ocorrencia
 		$ocorrencia = array();
 		$ocorrencia['codlead']=$row['codlead'];
 		$ocorrencia['descricao'] = "Arquivo gerado para integração com SA3";
 		$ocorrencia['codtipoocorrencialead'] = 3005;
		
		ocorrencias::adicionar($ocorrencia);
	}
}

?>
<?	include_once "../../libs/desconectar.php";?>