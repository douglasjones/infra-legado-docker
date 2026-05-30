<?
class checklist {
	function buscar($codlead){
			$sql	= '
		SELECT RA, RAOutros, NF, NFQuantos, PF, PFQuantas, NTA, NTAQuantos, NTD, NTDQuantos, NRA, NRAQuantos, NRD, NRDQuantos, DPA, DPAQuantos, AI, AIOutros, AIBanda, AICompRedeVoip, PFR, PABX, PABXOutros, OF, OFOutros, GMMLLFF, GMMLLFC, GMMLLDDD, GMMLLDDI, CLDDDDentroEstado, CLDDDDentroEstadoPM, CLDDDForaEstado, CLDDDForaEstadoPM, UASInterfaceCelular, UASInterfaceCelularOP, UASVoip, UASVoipOP, PCM, PCMEmpresa, PCMEstaSatisfeito
			FROM leads
			WHERE CodLead='.$codlead;
					
		$leads = mysql_fetch_array(sql_query($sql));

		return $leads;
	}
	
	function editar($request, $codlead){
		$RA						= emptynull($request['RA']);
		$RAOutros				= emptynull($request['RAOutros']);
		$NF						= emptynull($request['NF']);
		$NFQuantos				= emptynull($request['NFQuantos']);
		$PF						= emptynull($request['PF']);
		$PFQuantas				= emptynull($request['PFQuantas']);
		$NTA					= emptynull($request['NTA']);
		$NTAQuantos				= emptynull($request['NTAQuantos']);
		$NTD					= emptynull($request['NTD']);
		$NTDQuantos				= emptynull($request['NTDQuantos']);
		$NRA					= emptynull($request['NRA']);
		$NRAQuantos				= emptynull($request['NRAQuantos']);
		$NRD					= emptynull($request['NRD']);
		$NRDQuantos				= emptynull($request['NRDQuantos']);
		$DPA					= emptynull($request['DPA']);
		$DPAQuantos				= emptynull($request['DPAQuantos']);
		$AI						= emptynull($request['AI']);
		$AIOutros				= emptynull($request['AIOutros']);
		$AIBanda				= emptynull($request['AIBanda']);
		$AICompRedeVoip			= emptynull($request['AICompRedeVoip']);
		$PFR					= emptynull($request['PFR']);
		$PABX					= emptynull($request['PABX']);
		$PABXOutros				= emptynull($request['PABXOutros']);
		$OF						= emptynull($request['OF']);
		$OFOutros				= emptynull($request['OFOutros']);
		$GMMLLFF				= emptynull($request['GMMLLFF']);
		$GMMLLFC				= emptynull($request['GMMLLFC']);
		$GMMLLDDD				= emptynull($request['GMMLLDDD']);
		$GMMLLDDI				= emptynull($request['GMMLLDDI']);
		$CLDDDDentroEstado		= emptynull($request['CLDDDDentroEstado']);
		$CLDDDForaEstado		= emptynull($request['CLDDDForaEstado']);
		$CLDDDDentroEstadoPM	= emptynull($request['CLDDDDentroEstadoPM']);
		$CLDDDForaEstadoPM		= emptynull($request['CLDDDForaEstadoPM']);
		$UASInterfaceCelular	= emptynull($request['UASInterfaceCelular']);
		$UASInterfaceCelularOP	= emptynull($request['UASInterfaceCelularOP']);
		$UASVoip				= emptynull($request['UASVoip']);
		$UASVoipOP				= emptynull($request['UASVoipOP']);
		$PCM					= emptynull($request['PCM']);
		$PCMEmpresa				= emptynull($request['PCMEmpresa']);
		$PCMEstaSatisfeito		= emptynull($request['PCMEstaSatisfeito']);
		
		$sql = '
		UPDATE leads
			SET RA='.$RA.', RAOutros='.$RAOutros.', NF='.$NF.', NFQuantos='.$NFQuantos.', PF='.$PF.', PFQuantas='.$PFQuantas.', NTA='.$NTA.', NTAQuantos='.$NTAQuantos.', NTD='.$NTD.', NTDQuantos='.$NTDQuantos.', NRA='.$NRA.', NRAQuantos='.$NRAQuantos.', NRD='.$NRD.', NRDQuantos='.$NRDQuantos.', DPA='.$DPA.', DPAQuantos='.$DPAQuantos.', AI='.$AI.', AIOutros='.$AIOutros.', AIBanda='.$AIBanda.', AICompRedeVoip='.$AICompRedeVoip.', PFR='.$PFR.', PABX='.$PABX.', PABXOutros='.$PABXOutros.', OF='.$OF.', OFOutros='.$OFOutros.', GMMLLFF='.$GMMLLFF.', GMMLLDDD='.$GMMLLDDD.', GMMLLDDI='.$GMMLLDDI.', CLDDDDentroEstado='.$CLDDDDentroEstado.', CLDDDForaEstado='.$CLDDDForaEstado.', CLDDDDentroEstadoPM='.$CLDDDDentroEstadoPM.', CLDDDForaEstadoPM='.$CLDDDForaEstadoPM.', UASInterfaceCelular='.$UASInterfaceCelular.', UASInterfaceCelularOP='.$UASInterfaceCelularOP.', UASVoip='.$UASVoip.', UASVoipOP='.$UASVoipOP.', PCM='.$PCM.', PCMEmpresa='.$PCMEmpresa.', PCMEstaSatisfeito='.$PCMEstaSatisfeito.'
			WHERE CodLead='.$codlead;
		
		sql_query($sql);
	}
}
?>