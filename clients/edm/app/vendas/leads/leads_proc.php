<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.email.php";
include_once "../../libs/cla.layout_email.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "adm_propostas_cla.php";


if($_REQUEST['acao'] == "cliente"){   
    $sql = "delete from n_leads_dados_cliente where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['lead_cliente']= $_REQUEST['lead_cliente'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_dados_cliente', $fields);
    
     
    mysql_query($sql);   
}else if($_REQUEST['acao'] == "custo_atual_lead"){ 
    $sql = "delete from n_leads_custo_atual where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['vl_custo_atual']= moeda2float($_REQUEST['vl_custo_atual']);
    
    $sql = "";
    $sql.= sqlinsert('n_leads_custo_atual', $fields); 

    
    mysql_query($sql); 
    
}else if($_REQUEST['acao'] == "score_leade"){ 
    $sql = "delete from n_leads_score where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['n_score']= $_REQUEST['n_score'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_score', $fields); 

    mysql_query($sql);     
    
    
}else if($_REQUEST['acao'] == "cliente_base"){ 
    $sql = "delete from n_leads_dados_base where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['lead_cliente_base']= $_REQUEST['lead_cliente_base'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_dados_base', $fields); 
    mysql_query($sql);
    
    
    
}else if($_REQUEST['acao'] == "dt_vencimento_contrato"){   
    $sql = "DELETE FROM n_leads_dados_vencimento WHERE leads_pk=".$_REQUEST['leads_pk']." AND operadora_pk=".$_REQUEST['operadora_pk'];

        mysql_query($sql);
        
        
        
        
        
        $fields['dt_cadastro'] = "sysdate()";
        $fields['dt_ult_atualizacao'] = "sysdate()";
        $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
        $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
        $fields['leads_pk']= $_REQUEST['leads_pk'];
        $fields['operadora_pk']= $_REQUEST['operadora_pk'];
        $fields['dt_vencimento']= dataYMD($_REQUEST['dt_vencimento']);
        
        
        
        if($_REQUEST['operadora_pk']==1){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Tim';
        }
        if($_REQUEST['operadora_pk']==2){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora OI';
        }
        if($_REQUEST['operadora_pk']==3){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Nextel';
        }
        if($_REQUEST['operadora_pk']==4){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Outros';
        }
        if($_REQUEST['operadora_pk']==5){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Claro';
        }
        if($_REQUEST['operadora_pk']==6){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Vivo';
        }
        if($_REQUEST['operadora_pk']==8){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Base ';
        }
        if($_REQUEST['operadora_pk']==9){
        $descricao = 'VENCIMENTO DO CONTRATO EM '.dataDMY($fields['dt_vencimento']).' Operadora Porto Conecta ';
        }
        $dt_retorno = SubtrairData($_REQUEST['dt_vencimento'],0,4, 0);
        
            ocorrencias::adicionar(array('codlead' => $_REQUEST['leads_pk'], 'descricao' => $descricao.' - Data: ' .$dt_retorno.'','codtipoocorrencialead' => 6001, 'dt_retorno' => dataYMD($dt_retorno) ));  
            
        $sql = "";
        $sql.= sqlinsert('n_leads_dados_vencimento', $fields);
        mysql_query($sql);
        
        echo $sql;
        exit;
        
}else if($_REQUEST['acao'] == "classificacao_operadora_lead"){   
    
    $sql = "delete from n_leads_dados_classificacao where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['classificacao_operadora_pk']= $_REQUEST['classificacao_operadora_pk'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_dados_classificacao', $fields);

    mysql_query($sql);    
}else if($_REQUEST['acao'] == "qtde_voz_leade"){   
    
    $sql = "delete from n_leads_qtde_voz where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['qtde_voz']= $_REQUEST['qtde_voz'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_qtde_voz', $fields);

    mysql_query($sql);    
}else if($_REQUEST['acao'] == "qtde_dados_leade"){   
    
    $sql = "delete from n_leads_qtde_dados where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['qtde_dados']= $_REQUEST['qtde_dados'];
    
    $sql = "";
    $sql.= sqlinsert('n_leads_qtde_dados', $fields);

    mysql_query($sql);    
}else if($_REQUEST['acao'] == "dt_ativacao_contrato"){   
    
    $sql = "delete from n_leads_dados_ativacao where leads_pk=".$_REQUEST['leads_pk']." and operadora_pk=".$_REQUEST['operadora_pk'];   

    mysql_query($sql);
    
    $fields['dt_cadastro'] = "sysdate()";
    $fields['dt_ult_atualizacao'] = "sysdate()";
    $fields['usuario_cadastro_pk'] = $_SESSION['codusuario'];
    $fields['usuario_ult_atualizacao_pk'] = $_SESSION['codusuario'];
    $fields['leads_pk']= $_REQUEST['leads_pk'];
    $fields['operadora_pk']= $_REQUEST['operadora_pk'];
    $fields['dt_ativacao']= dataYMD($_REQUEST['dt_ativacao']);
    
    $sql = "";
    $sql.= sqlinsert('n_leads_dados_ativacao', $fields);
        
    mysql_query($sql);    
    
}else if($_REQUEST['acao']=="enviar_email"){
    
     $codlead = $_REQUEST['codlead'];
     $razaosocial = $_REQUEST['razaosocial'];
     $ddd = $_REQUEST['ddd'];
     $tel = $_REQUEST['tel'];
     $CodGerenteConta = $_REQUEST['CodGerenteConta'];
     $NomeContato = $_REQUEST['NomeContato'];
     $DDD_fone = $_REQUEST['DDD_fone'];
     $fone = $_REQUEST['fone'];
     $email_contato = $_REQUEST['email_contato'];
     $emailpara = $_REQUEST['email'];
     $nome = $_REQUEST['nome'];
     $fields['operador_pk']= $_REQUEST['operador_pk'];
     
     if($fields['operador_pk']){
         
        $assunto = " SOLICITAÇÃO DE PROPOSTA";
}
     
     
    $sql ="";
    $sql.="SELECT ui.Nome
                ,ui.email email_usuario
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

    $emailde = $row1['email_usuario'];


    $sql="";
    $sql.="SELECT 
                email email_contato 
           FROM contatoslead 
           WHERE CodLead=".$codlead;
    $results = mysql_query($sql);
    $row2 = mysql_fetch_array($results);

    $email_contato = $row2['email_contato'];


    $sql="";
    $sql.="SELECT dsc_operadora FROM operadoras
           WHERE cod_operadora=".$fields['operador_pk'];
    $results = mysql_query($sql);
    $row3 = mysql_fetch_array($results);

            
    $html = layout_email::layout_solicitacao($nome,$row3['dsc_operadora'],$codlead,$razaosocial,$ddd,$tel,$NomeContato,$email_contato,$DDD_fone,$fone);
    
    email::envia_solicitacao($html,$emailde,$emailpara,$assunto,$fields['operador_pk']);
        
    ocorrencias::adicionar(array('codlead' => $codlead, 'descricao' => 'Solicitação de proposta '.$nome, 'codtipoocorrencialead' => 6043));
}



?>
