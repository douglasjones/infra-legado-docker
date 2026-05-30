<?	include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.ocorrencias.php";
	include_once "../../libs/datas.php";

class preagendamento {
	function adicionar($value){
end;
		if(!isset($value['codlead'])) return false;
		if(!isset($value['codusuariointerno'])) $value['codusuariointerno'] = $_SESSION['codusuariointerno'];
		if(!isset($value['razaosocial'])) $value['termino'] = null;
		if(!isset($value['cnpj'])) $value['cnpj'] = null;
		if(!isset($value['plano_porp'])) $value['plano_porp'] = null;
		if(!isset($value['operadora'])) $value['operadora'] = null;
		if(!isset($value['tempo'])) $value['tempo'] = null;
		if(!isset($value['qtd_linhas'])) $value['qtd_linhas'] = null;
		if(!isset($value['dat_troca_aparelho'])) $value['dat_troca_aparelho'] = null;
		if(!isset($value['consumo_celular'])) $value['consumo_celular'] = null;
        if(!isset($value['consumo_fixo'])) $value['consumo_fixo'] = null;		
		
		$fields['codlead'] = $value['codlead'];
		$fields['codusuariointerno'] = $value['codusuariointerno'];
		$fields['cnpj'] = $value['cnpj'];
		$fields['plano_corp'] = $value['plano_corp'];		
        $fields['operadora'] = $value['operadora'];
		$fields['tempo'] = $value['tempo'];
		$fields['qtd_linhas'] = $value['qtd_linhas'];
		$fields['dat_troca_aparelho'] = $value['dat_troca_aparelho'];
		$fields['consumo_celular'] = $value['consumo_celular'];
		$fields['consumo_fixo'] = $value['consumo_fixo'];
		
		$sql = sqlinsert('preagendamento', $fields);
		sql_query($sql);
		$codpreagendamento = mysql_insert_id();

		if(!empty($_REQUEST['1'])) {
			$sql_motivopre_reducao = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['1'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_reducao);
			$codpreagendamento = mysql_insert_id();
		} 
		
		if(!empty($_REQUEST['2'])) {
			$sql_motivopre_tresg = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['2'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_tresg);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['3'])) {
			$sql_motivopre_aparelhos = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['3'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_aparelhos);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['4'])) {
			$sql_motivopre_ptt_claro = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['4'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_ptt_claro);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['5'])) {
			$sql_motivopre_descontente = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['5'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_descontente);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['6'])) {
			$sql_motivopre_smartphones = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['6'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_smartphones);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['7'])) {
			$sql_motivopre_gestor_online = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['7'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_gestor_online);
			$codpreagendamento = mysql_insert_id();
		}
		
		if(!empty($_REQUEST['8'])) {
			$sql_motivopre_interesse_operadora = sqlinsert('motivos_preagendamento', array('cod_motivo_preagendamento' => $_REQUEST['8'],'cod_preagendamento'=> $codpreagendamento));
			sql_query($sql_motivopre_interesse_operadora);
			$codpreagendamento = mysql_insert_id();
		}		return $codpreagendamento;
	}
}?>