<?
class os {
// Insert
	function insert($request){
		$codproposta		= mysql_real_escape_string($request['codproposta']);
		$versaoproposta		= mysql_real_escape_string($request['versaoproposta']);
		$dataos				= mysql_real_escape_string($request['dataos']);
		$periodo			= mysql_real_escape_string($request['periodo']);
		$status				= mysql_real_escape_string($request['status']);
		$osacao				= mysql_real_escape_string($request['osacao']);
		$codinstalador		= mysql_real_escape_string($request['codinstalador']);
		$codconsultor		= mysql_real_escape_string($request['codconsultor']);
		$responsavel		= mysql_real_escape_string($request['responsavel']);
		$respctt			= mysql_real_escape_string($request['respctt']);
		$descinst			= mysql_real_escape_string($request['descinst']);
		$serialgateway		= mysql_real_escape_string($request['serialgateway']);
		$enderecoip			= mysql_real_escape_string($request['enderecoip']);
		$login				= mysql_real_escape_string($request['login']);
		$senha				= mysql_real_escape_string($request['senha']);
		$canais				= mysql_real_escape_string($request['canais']);
		$datatrybuyde		= mysql_real_escape_string($request['datatrybuyde']);
		$datatrybuyate		= mysql_real_escape_string($request['datatrybuyate']);
		$observacoes		= mysql_real_escape_string($request['observacoes']);
		$infuteis			= mysql_real_escape_string($request['infuteis']);
		
		$dataos				= explode('/', $dataos);
		$dataos				= date('Y-m-d',strtotime($dataos[1].'/'.$dataos[0].'/'.$dataos[2]));
		$datatrybuyde		= explode('/', $datatrybuyde);
		$datatrybuyde		= date('Y-m-d',strtotime($datatrybuyde[1].'/'.$datatrybuyde[0].'/'.$datatrybuyde[2]));
		$datatrybuyate		= explode('/', $datatrybuyate);
		$datatrybuyate		= date('Y-m-d',strtotime($datatrybuyate[1].'/'.$datatrybuyate[0].'/'.$datatrybuyate[2]));
		
		$sql = '
		INSERT 
		INTO ordemservico(
			CodProposta, VersaoProposta, DataOS, Periodo, Status, OSAcao, CodInstalador, CodConsultor, Responsavel, RespCtt, DescInst, 
			SerialGateway, EnderecoIP, Login, Senha, Canais, DataTryBuyDe, DataTryBuyAte, Observacoes, InfUteis
		) 
		VALUES(
			'.mysqlnull($codproposta).', '.mysqlnull($versaoproposta).', '.mysqlnull($dataos).', '.mysqlnull($periodo).', '.mysqlnull($status).', '.mysqlnull($osacao).', '.mysqlnull($codinstalador).', '.mysqlnull($codconsultor).', '.mysqlnull($responsavel).' , '.mysqlnull($respctt).', '.mysqlnull($descinst).', '.mysqlnull($serialgateway).', '.mysqlnull($enderecoip).', '.mysqlnull($login).', '.mysqlnull($senha).', '.mysqlnull($canais).', '.mysqlnull($datatrybuyde).', '.mysqlnull($datatrybuyate).', '.mysqlnull($observacoes).', '.mysqlnull($infuteis).'
		)
		';
		sql_query($sql);
	}
// Update
	function update($request){
		$codos				= mysql_real_escape_string($request['codos']);
		$codproposta		= mysql_real_escape_string($request['codproposta']);
		$versaoproposta		= mysql_real_escape_string($request['versaoproposta']);
		$dataos				= mysql_real_escape_string($request['dataos']);
		$periodo			= mysql_real_escape_string($request['periodo']);
		$status				= mysql_real_escape_string($request['status']);
		$osacao				= mysql_real_escape_string($request['osacao']);
		$codinstalador		= mysql_real_escape_string($request['codinstalador']);
		$codconsultor		= mysql_real_escape_string($request['codconsultor']);
		$responsavel		= mysql_real_escape_string($request['responsavel']);
		$respctt			= mysql_real_escape_string($request['respctt']);
		$descinst			= mysql_real_escape_string($request['descinst']);
		$serialgateway		= mysql_real_escape_string($request['serialgateway']);
		$enderecoip			= mysql_real_escape_string($request['enderecoip']);
		$login				= mysql_real_escape_string($request['login']);
		$senha				= mysql_real_escape_string($request['senha']);
		$canais				= mysql_real_escape_string($request['canais']);
		$datatrybuyde		= mysql_real_escape_string($request['datatrybuyde']);
		$datatrybuyate		= mysql_real_escape_string($request['datatrybuyate']);
		$observacoes		= mysql_real_escape_string($request['observacoes']);
		$infuteis			= mysql_real_escape_string($request['infuteis']);
		
		$dataos				= explode('/', $dataos);
		$dataos				= date('Y-m-d',strtotime($dataos[1].'/'.$dataos[0].'/'.$dataos[2]));
		$datatrybuyde		= explode('/', $datatrybuyde);
		$datatrybuyde		= date('Y-m-d',strtotime($datatrybuyde[1].'/'.$datatrybuyde[0].'/'.$datatrybuyde[2]));
		$datatrybuyate		= explode('/', $datatrybuyate);
		$datatrybuyate		= date('Y-m-d',strtotime($datatrybuyate[1].'/'.$datatrybuyate[0].'/'.$datatrybuyate[2]));
		
		$sql = '
		UPDATE ordemservico
		SET CodProposta='.mysqlnull($codproposta).', VersaoProposta='.mysqlnull($versaoproposta).', DataOS='.mysqlnull($dataos).', Periodo='.mysqlnull($periodo).', Status='.mysqlnull($status).', OSAcao='.mysqlnull($osacao).', CodInstalador='.mysqlnull($codinstalador).', CodConsultor='.mysqlnull($codconsultor).', Responsavel='.mysqlnull($responsavel).', RespCtt='.mysqlnull($respctt).', DescInst='.mysqlnull($descinst).', SerialGateway='.mysqlnull($serialgateway).', EnderecoIP='.mysqlnull($enderecoip).', Login='.mysqlnull($login).', Senha='.mysqlnull($senha).', Canais='.mysqlnull($canais).', DataTryBuyDe='.mysqlnull($datatrybuyde).', DataTryBuyAte='.mysqlnull($datatrybuyate).', Observacoes='.mysqlnull($observacoes).', InfUteis='.mysqlnull($infuteis).'
		WHERE CodOS='.mysqlnull($codos);
		sql_query($sql);
	}
//New
	function newos($codlead){
		$sql			= 'SELECT MAX(CodProposta) AS CodProposta FROM propostas WHERE CodLead='.$codlead;
		$codp			= mysql_fetch_array(sql_query($sql));
		$ret['codproposta']	= $codp['CodProposta'];
		
		$sql			= 'SELECT MAX(Versao) AS Versao FROM propostas WHERE CodLead='.$codlead.' AND CodProposta='.$ret['codproposta'];
		$versao			= mysql_fetch_array(sql_query($sql));
		$ret['versaoproposta']	= $versao['Versao'];
		
		$data 			= getdate();
		$ret['dataos']	= $data['mday'].'/'.$data['mon'].'/'.$data['year'];
		
		if($data['hours']>12 && $data['hours']<18) 	$ret['periodo'] = 1;
		else 										$ret['periodo'] = 0;
				
		$sql = 'SELECT NomeContato, Fone FROM contatoslead WHERE CodLead='.$codlead.' ORDER BY CodSetorContato DESC';
		if(mysql_num_rows(sql_query($sql))>0) {
			$resp				= mysql_fetch_array(sql_query($sql));
			$ret['responsavel']	= $resp['NomeContato'];
			$ret['respctt']		= $resp['Fone'];
		}
		
		$sql = 'SELECT CodGerenteConta FROM leads WHERE CodLead='.$codlead;
		$codc = mysql_fetch_array(sql_query($sql));
		$ret['codconsultor'] = $codc['CodGerenteConta'];
		
		$sql = 'SELECT CodInstalador FROM leads WHERE CodLead='.$codlead;
		$codi = mysql_fetch_array(sql_query($sql));
		$ret['codinstalador'] = $codi['CodInstalador'];
		
		return $ret;
	}
	function edit($request){
		$ret['codos']	= $request['codos'];
		
		$sql	= 'SELECT * FROM ordemservico WHERE CodOS='.$ret['codos'];
		$res	= sql_query($sql);
		$os		= mysql_fetch_array($res);
		mysql_free_result($res);
		
		$ret['codproposta']		= $os['CodProposta'];
		$ret['versaoproposta']	= $os['VersaoProposta'];
		$ret['dataos']			= $os['DataOS'];
		$ret['periodo']			= $os['Periodo'];
		$ret['status']			= $os['Status'];
		$ret['osacao']			= $os['OSAcao'];
		$ret['codinstalador']	= $os['CodInstalador'];
		$ret['codconsultor']	= $os['CodConsultor'];
		$ret['responsavel']		= $os['Responsavel'];
		$ret['respctt']			= $os['RespCtt'];
		$ret['descinst']		= $os['DescInst'];
		$ret['serialgateway']	= $os['SerialGateway'];
		$ret['enderecoip']		= $os['EnderecoIP'];
		$ret['login']			= $os['Login'];
		$ret['senha']			= $os['Senha'];
		$ret['canais']			= $os['Canais'];
		$ret['datatrybuyde']	= $os['DataTryBuyDe'];
		$ret['datatrybuyate']	= $os['DataTryBuyAte'];
		$ret['observacoes']		= $os['Observacoes'];
		$ret['infuteis']		= $os['InfUteis'];
		
		return $ret;
	}
	function imprimir($codos){
		$sql	= '
		SELECT OS.*, UI1.Nome AS NomeInstalador, UI2.Nome AS NomeConsultor, LD.RazaoSocial, LD.Endereco, LD.Numero, LD.Bairro, LD.Cep, LD.cidade, LD.uf, LD.ddd, LD.tel, LD.Site
			FROM ordemservico AS OS
			LEFT JOIN usuariosinternos AS UI1 ON OS.CodInstalador=UI1.CodUsuarioInterno
			LEFT JOIN usuariosinternos AS UI2 ON OS.CodConsultor=UI2.CodUsuarioInterno
			LEFT JOIN propostas AS PR ON OS.CodProposta=PR.CodProposta
			LEFT JOIN leads AS LD ON PR.CodLead=LD.CodLead
			WHERE CodOS='.$codos;
	
		$res	= sql_query($sql);
		$os		= mysql_fetch_array($res);
		mysql_free_result($res);
		
		$ret['codos']			= $codos;
		$ret['codproposta']		= $os['CodProposta'];
		$ret['versaoproposta']	= $os['VersaoProposta'];
		$ret['dataos']			= date('d/m/Y', strtotime($os['DataOS']));
		$ret['periodo']			= $os['Periodo'];
		$ret['status']			= $os['Status'];
		$ret['osacao']			= $os['OSAcao'];
		$ret['nomeinstalador']	= $os['NomeInstalador'];
		$ret['nomeconsultor']	= $os['NomeConsultor'];
		$ret['responsavel']		= $os['Responsavel'];
		$ret['respctt']			= $os['RespCtt'];
		$ret['descinst']		= $os['DescInst'];
		$ret['serialgateway']	= $os['SerialGateway'];
		$ret['enderecoip']		= $os['EnderecoIP'];
		$ret['login']			= $os['Login'];
		$ret['senha']			= $os['Senha'];
		$ret['canais']			= $os['Canais'];
		$ret['datatrybuyate']	= date('d/m/Y', strtotime($os['DataTryBuyAte']));
		$ret['observacoes']		= $os['Observacoes'];
		$ret['infuteis']		= $os['InfUteis'];
		$ret['ldrazaosocial']	= $os['RazaoSocial'];
		$ret['ldendereco']		= $os['Endereco'];
		$ret['ldnumero']		= $os['Numero'];
		$ret['ldbairro']		= $os['Bairro'];
		$ret['ldcep']			= $os['Cep'];
		$ret['ldcidade']		= $os['cidade'];
		$ret['lduf']			= $os['uf'];
		$ret['ldddd']			= $os['ddd'];
		$ret['ldtel']			= $os['tel'];
		$ret['ldsite']			= $os['Site'];
		
		if($ret['periodo']==0) $ret['periodo']='Manhã';
		else $ret['periodo']='Tarde';
		
		if($ret['status']==0) $ret['status']='Não realizado';
		else $ret['status']='Realizado';
		
		if($ret['osacao']==0) $ret['osacao']='Instalação';
		else $ret['osacao']='Retirada';
		
		return $ret;
	}
}
?>