<?
include_once "../../libs/maininclude.php";
include_once "propostas_cla.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.email.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "classifcacao_visita_cla.php";





$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];
$produto_pk = $_REQUEST['produto_pk'];
$versao = $_REQUEST['versao'];
$leads_pk= $_REQUEST['leads_pk'];
$codproduto = $_REQUEST['codproduto'];
$agendalead_pk = $_REQUEST['agendalead_pk'];
$produto_tipo_linha = $_REQUEST['produto_tipo_linha'];
$dt_envio_proposta = $_REQUEST['dt_envio_proposta'];
$dt_previsao_pedido = $_REQUEST['dt_previsao_pedido'];
$ds_obs_proposta = $_REQUEST['ds_obs_proposta'];
$itens_voz = $_REQUEST['itens_voz'];
$itens_combo = $_REQUEST['itens_combo'];
$itens_dados = $_REQUEST['itens_dados'];
$itens_modulos = $_REQUEST['itens_modulos'];
$itens_aparelhos = $_REQUEST['itens_aparelhos'];
$datas_proposta = $_REQUEST['datas_proposta'];
$operador_pk = $_REQUEST['operador_pk'];
$motivo_cancelamento_pk = $_REQUEST['motivo_cancelamento_pk'];
$dsc_cancelamento_proposta = $_REQUEST['dsc_cancelamento_proposta'];
$dt_validade = $_REQUEST['dt_validade'];
$vl_total_proposta = $_REQUEST['vl_total_proposta'];
$trade_in = $_REQUEST['trade_in'];
$ddd = $_REQUEST['ddd'];
$vl_desconto_claro = $_REQUEST['vl_desconto_claro'];
$vl_ult_conta = $_REQUEST['vl_ult_conta'];
$h_termino_visita = $_REQUEST['h_termino_visita'];
$status_classificacao_pk = $_REQUEST['status_classificacao_pk'];
$email_contato = $_REQUEST['email_contato'];

$informacoes1 = $_REQUEST['informacoes1'];


if ($acao == "gravar"){	

	$propostas = new propostas(0);
	$propostas->setpk($pk);
	$propostas->setleads_pk($leads_pk);
	$propostas->setn_pedido($n_pedido);	
	$propostas->setagendalead_pk($agendalead_pk);
	$propostas->setds_obs_proposta($ds_obs_proposta);
	$propostas->setitens_voz($itens_voz);
	$propostas->setitens_combo($itens_combo);
	$propostas->setitens_dados($itens_dados);
	$propostas->setitens_modulos($itens_modulos);
	$propostas->setitens_aparelhos($itens_aparelhos);
	$propostas->setdatas_proposta($datas_proposta);
	$propostas->setoperador_pk($operador_pk);
	$propostas->setdt_validade($dt_validade);
	$propostas->setvl_total_proposta($vl_total_proposta);
	$propostas->settrade_in($trade_in);
	$propostas->setddd($ddd);
        
    $propostas->setemail_contato($email_contato);
    
    $propostas->setvl_desconto_claro($vl_desconto_claro);
    $propostas->setvl_ult_conta($vl_ult_conta);
    $propostas->seth_termino_visita($h_termino_visita);
		
	//Salvar Proposta
	$pk = $propostas->salvar();
	
	//Salvar itens propota
	$propostas->add_itens_proposta($pk);
			
	//Salvar aparelhos proposta
	$propostas->add_proposta_aparelhos($pk);
	
	//Salvar datas proposta
	$propostas->proposta_datas($pk);
    
    //Classifica o agendamento como produtivo
    if(!empty($agendalead_pk)){
   
        $classifcacao_visita = new classifcacao_visita(0);
        $classifcacao_visita->setagenda_visita_pk($agendalead_pk);
        $classifcacao_visita->setleads_pk($leads_pk);
        $classifcacao_visita->settermino_visita($h_termino_visita);
        $classifcacao_visita->setstatus_classificacao_pk($status_classificacao_pk);
        $classifcacao_visita->setdescricao($informacoes1); 
        
        $classifcacao_visita->salvar();
    }
	
  javascriptalert('Operação executada com sucesso!!!');
        

   
}
if($acao == "select"){	
	if($_REQUEST['tipo']=="vlproduto"){
		if($_REQUEST['tipo_produto'] != "Combo"){	
			$sql = "Select 
						npv.pk,
						npv.vl_produto,
                        npv.valor_tipo_pk
					from n_produtos_valores npv
						where npv.produtos_pk=".$produto_pk;
			$sql .= " ORDER BY npv.vl_produto desc";	
			
			$result = mysql_query($sql);
		}else{
			$sql = "Select
					 nc.pk,
					 nc.vl_combo as vl_produto,
                     nc.valor_tipo_pk
					from n_combos nc
					where nc.pk=".$produto_pk;
			
			$result = mysql_query($sql);
		}		
		while($row = mysql_fetch_array($result)){
			echo $row["pk"]."##".$row["vl_produto"]."##".$row["valor_tipo_pk"]."////";			
		}
	}elseif($_REQUEST['tipo']=="tarifa"){
		$sql = "Select
					npo.visualiza_vc1_local,
					npo.dsc_vc1_local,
					npo.vl_vc1_local,
					npo.visualiza_vc2_local,
					npo.dsc_vc2_local,
					npo.vl_vc3_local,
					npo.visualiza_vc3_local,
					npo.dsc_vc3_local,
					npo.vl_vc2_local,
					npo.visualiza_vc1_Estad,
					npo.dsc_vc1_Estad,
					npo.vl_vc1_Estad,
					npo.visualiza_vc2_Estad,
					npo.dsc_vc2_Estad,
					npo.vl_vc2_Estad,
					npo.visualiza_vc3_Estad,
					npo.dsc_vc3_Estad,
					npo.vl_vc3_Estad
				from n_produtos_operadoras npo
				where npo.produtos_pk=".$produto_pk;				
		
		$result = mysql_query($sql);
		
		$row = mysql_fetch_array($result);
			echo "<tr >"	;		
			if(!empty($row['visualiza_vc1_local'])){
				echo "<td>";
				echo "<b><font size='-2'>".$row['dsc_vc1_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1ir' name='vc1ir' value=".number_format($row['vl_vc1_local'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vc1ir' name='vc1ir' value=''>";
			}			
			if(!empty($row['visualiza_vc2_local'])){
				echo "<td>";
				echo "&nbsp;<b><font size=-2>".$row['dsc_vc2_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1m' name='vc1m' value=".number_format($row['vl_vc2_local'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vc1m' name='vc1m' value=''>";
			}	
			if(!empty($row['visualiza_vc3_local'])){
				echo "<td>";
				echo "&nbsp;<b><font size=-2>".$row['dsc_vc3_local']."</font></b>&nbsp;<input type='text' size='3' id='vc1f' name='vc1f' value=".number_format($row['vl_vc3_local'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vc1f' name='vc1f' value=''>";
			}			
			echo "</tr>";
			echo "||";
			echo "<tr>";		
			if(!empty($row['visualiza_vc1_Estad'])){
				echo "<td>";
				echo "<b><font size=-2>".$row['dsc_vc1_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces' name='vces' value=".number_format($row['vl_vc1_Estad'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vces' name='vces' value=''>";
			}			
			if(!empty($row['visualiza_vc2_Estad'])){
				echo "<td>";
				echo "&nbsp;<b><font size=-2>".$row['dsc_vc2_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces2m' name='vces2m' value=".number_format($row['vl_vc2_Estad'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vces2m' name='vces2m' value=''>";
			}	
			if(!empty($row['visualiza_vc3_Estad'])){
				echo "<td>";
				echo "&nbsp;<b><font size=-2>".$row['dsc_vc3_Estad']."</font></b>&nbsp;<input type='text' size='3' id='vces2f' name='vces2f' value=".number_format($row['vl_vc3_Estad'],2,",",".").">";
				echo "</td>";
			}else{
				echo "<input type='hidden' size='3' id='vces2f' name='vces2f' value=''>";
			}		
			echo "</tr>";
	}
}
if($acao == "enviar_email"){
    $leads_pk = $_REQUEST['leads_pk'];
    $email_contato = $_REQUEST['email_contato'];
    $nomecontato = $_REQUEST['nomecontato'];
    $operador_pk = $_REQUEST['operador_pk'];
    $razaosocial = $_REQUEST['razaosocial'];
    $html = $_REQUEST['html'];


    
    if($operador_pk==3){
        $assunto = "PROPOSTA VIVO";
    }else if($operador_pk==2){
        $assunto = "PROPOSTA TIM";
    }else if ($operador_pk==1){
        $assunto= "PROPOSTA CLARO"; 
    }else if ($operador_pk==4){
        $assunto="PROPOSTA NEXTEL";
    }else if ($operador_pk==6){
        $assunto="PROPOSTA OI";
    }
                
                
                            $sql ="";
                            $sql.="SELECT ui.Nome
                                        ,ui.email email_consultor
                                        ,e.site
                                        ,e.ddd
                                        ,e.tel
                                        ,e.enviar_proposta_email_pk
                                        ,e.origem_email_proposta_pk
                                        ,e.proposta_email
                                        ,e.razao_social
                                    FROM usuariosinternos ui
                                    left join empresa e on ui.cod_empresa = e.cod_empresa
                                   WHERE ui.CodUsuarioInterno =".$_SESSION['codusuario'];

    $results = mysql_query($sql);
    $row1 = mysql_fetch_array($results);

    if($row1['enviar_proposta_email_pk']==1){

        ocorrencias::adicionar(array('codlead' => $leads_pk, 'descricao' => 'Envio da proposta', 'codtipoocorrencialead' => 7));
  
        if($row1['origem_email_proposta_pk']==1){
            
            email::envia_email_proposta($html,$row1['email_consultor'],$email_contato,$body,$msg_body,$assunto,$operador_pk,$nomecontato,$leads_pk);
        }elseif($row1['proposta_email']){
            
            $row1['email_consultor'] = $row1['proposta_email'] ;
            
            email::envia_email_proposta($html,$row1['email_consultor'],$email_contato,$body,$msg_body,$assunto,$operador_pk);
        }
    }
                              
      javascriptalert('Operação executada com sucesso!!!');
    
}
if($acao == "cancelar"){
	
	$propostas= new propostas($pk);	
	$propostas->setmotivo_cancelamento_pk ($motivo_cancelamento_pk );	
	$propostas->setdsc_cancelamento_proposta($dsc_cancelamento_prospota);
	$propostas->cancelar($pk);
    
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$propostas= new propostas($pk);
	$propostas->excluir();
    
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>
