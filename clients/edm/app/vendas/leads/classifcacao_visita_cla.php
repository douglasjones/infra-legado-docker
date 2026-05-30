<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once "../../libs/datas.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "../../libs/cla.leads.php";

class classifcacao_visita{

	private $pk;
	private $dt_cadastro;
	private $usuario_cadastro_pk;
	private $dt_ult_atualizacao;
	private $usuario_ult_atualizacao_pk;	
	private $agenda_visita_pk;
        private $leads_pk;
        private $termino_visita;
        private $status_classificacao_pk;
        private $descricao;
        private $motivo_sem_interesse_pk;
        private $qtde_linhas;
        private $vencimento_contrato;
        private $operadoras_pk;
        private $dt_prev_receb_conta;
        
	function getagenda_visita_pk(){return $this->agenda_visita_pk;}
        function getleads_pk(){return $this->leads_pk;}
        function gettermino_visita(){return $this->termino_visita;}
        function getstatus_classificacao_pk(){return $this->status_classificacao_pk;}
        function getdescricao(){return $this->descricao;}
        function getmotivo_sem_interesse_pk(){return $this->motivo_sem_interesse_pk;}
        function getqtde_linhas(){return $this->qtde_linhas;}
        function getvencimento_contrato(){return $this->vencimento_contrato;}
        function getoperadoras_pk(){return $this->operadoras_pk;}
        function getdt_prev_receb_conta(){return $this->dt_prev_receb_conta;}

	function getpk() {return $this->pk;}
	function getdt_cadastro(){return $this->dt_cadastro;}
	function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
	function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
	
	function getusuario_cadastro_nome_pk(){
		$strRetorno = "";
		$sql = "select nome from usuariosinternos where codusuariointerno = ".$this->usuario_cadastro_pk;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno = $row["nome"];
		}
		mysql_free_result($result);
		return $strRetorno;
	}

	function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	function getusuario_ult_atualizacao_nome_pk(){
		$strRetorno = "";
		$sql = "select nome from usuariosinternos where codusuariointerno = ".$this->usuario_ult_atualizacao_pk;
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$strRetorno = $row["nome"];
		}
		mysql_free_result($result);
		return $strRetorno;
	}
	
	function setpk($pk){$this->pk = $pk;}
	function setagenda_visita_pk($agenda_visita_pk){ $this->agenda_visita_pk = $agenda_visita_pk;}
        function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
        function settermino_visita($termino_visita){ $this->termino_visita = $termino_visita;}
        function setstatus_classificacao_pk($status_classificacao_pk){ $this->status_classificacao_pk = $status_classificacao_pk;}
        function setdescricao($descricao){ $this->descricao = $descricao;}
        function setmotivo_sem_interesse_pk($motivo_sem_interesse_pk){ $this->motivo_sem_interesse_pk = $motivo_sem_interesse_pk;}
        function setqtde_linhas($qtde_linhas){ $this->qtde_linhas = $qtde_linhas;}
        function setvencimento_contrato($vencimento_contrato){ $this->vencimento_contrato = $vencimento_contrato;}
        function setoperadoras_pk($operadoras_pk){ $this->operadoras_pk = $operadoras_pk;}
        function setdt_prev_receb_conta($dt_prev_receb_conta){ $this->dt_prev_receb_conta = $dt_prev_receb_conta;}

	function __construct($pk){
		
		$this->pk = null;
		$this->dt_cadastro = null;
		$this->usuario_cadastro_pk = null;
		$this->dt_ult_atualizacao = null;
		$this->usuario_ult_atualizacao = null;
		$this->agenda_visita_pk = null;
        $this->leads_pk = null;
        $this->termino_visita = null;
        $this->status_classificacao_pk = null;
        $this->descricao = null;
        $this->motivo_sem_interesse_pk = null;
        $this->qtde_linhas = null;
        $this->vencimento_contrato = null;
        $this->operadoras_pk = null;
        $this->dt_prev_receb_conta = null;

		
		if ($pk != 0){
			$sql ="select pk,";
			$sql.="       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, ";
			$sql.="       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, ";
            $sql.="       date_format(dt_prev_receb_conta, '%d/%m/%Y %H:%i:%s') dt_prev_receb_conta, ";
			$sql.="       usuario_cadastro_pk, ";
			$sql.="       usuario_ult_atualizacao_pk, ";
			$sql.="agenda_visita_pk, ";
            $sql.="leads_pk, ";
            $sql.="termino_visita, ";
            $sql.="status_classificacao_pk, ";
            $sql.="descricao, ";
            $sql.="motivo_sem_interesse_pk, ";
            $sql.="qtde_linhas, ";
            $sql.="vencimento_contrato, ";
            $sql.="operadoras_pk, ";

			$sql.="  from agendaslead ";
			$sql.=" where pk = ".$pk;
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				$this->pk = $row['pk'];
				$this->dt_cadastro = $row['dt_cadastro'];
				$this->dt_ult_atualizacao = $row['dt_ult_atualizacao'];
				$this->usuario_cadastro_pk = $row['usuario_cadastro_pk'];
				$this->usuario_ult_atualizacao_pk = $row['usuario_ult_atualizacao_pk'];
				$this->agenda_visita_pk = $row['agenda_visita_pk'];
                $this->leads_pk = $row['leads_pk'];
                $this->termino_visita = $row['termino_visita'];
                $this->status_classificacao_pk = $row['status_classificacao_pk'];
                $this->descricao = $row['descricao'];
                $this->motivo_sem_interesse_pk = $row['motivo_sem_interesse_pk'];
                $this->qtde_linhas = $row['qtde_linhas'];
                $this->vencimento_contrato = $row['vencimento_contrato'];
                $this->operadoras_pk = $row['operadoras_pk'];
                $this->dt_prev_receb_conta = $row['dt_prev_receb_conta'];

			
			}
			mysql_free_result($result);
		}
	}
	
	function salvar(){

        $fields['Termino'] = $this->termino_visita;
        $fields['CodStatus'] = $this->status_classificacao_pk;
        $fields['Informacoes'] = $this->descricao;
        if(!empty($this->dt_prev_receb_conta)){
            $fields['dt_prev_receb_conta'] = dataYMD($this->dt_prev_receb_conta);
        }

        $sql = sqlupdate('agendaslead', $fields, ' codagendalead = ' . mysqlnull($this->agenda_visita_pk));
        mysql_query($sql);  
      
        
	}
    function add_seminteresse(){

        //ALTERA O STATUS DO LEAD
        $fields['codstatusclassificacaolead'] = 1;
        $fields['CodMotivo'] = $this->motivo_sem_interesse_pk;


        $sql ="";
        $sql.= sqlupdate('leads', $fields, ' codlead = ' . mysqlnull($this->leads_pk));

        mysql_query($sql);  

        //GERA OCORRENCIA DE SEM INTERESSE
        $sql ="";
        $sql.="SELECT ml.Descricao
                FROM motivoslead ml
               WHERE ml.CodMotivoLead=".$this->motivo_sem_interesse_pk;

        $result = sql_query($sql);
        $row = mysql_fetch_array($result);        
        $motivo_seminteresse = $row['Descricao'];
        mysql_free_result($result);
      
        $descricao_oc = "MOTIVO DO SEM INTERESSE  ".$motivo_seminteresse."<p> DESCRIÇÃO ".$this->descricao;
        $codtipoororrencia = 5;

        ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $descricao_oc, 'codtipoocorrencialead' => 5));
    
        $sql = "Select
        o.cod_operador operador_pk
        ,o.dsc_operador
        ,op.cod_operadora
        from operador o";
        $sql .="	inner join empresa_operador eo on o.cod_operador = eo.cod_operador 
                left join operadoras op on op.dsc_operadora = o.dsc_operador";
        if(!empty($_SESSION['cod_empresa'])){
                $sql .=" where eo.cod_empresa=".$_SESSION['cod_empresa'];
        }
        $sql .=" group by o.dsc_operador";
        $result = sql_query($sql);
        $dt_vencimento = "";
        
        while($row = mysql_fetch_array($result)){
            $sql ="";
            $sql.="SELECT DATE_FORMAT(nldc.dt_vencimento, '%d/%m/%Y') dt_vencimento
                    FROM n_leads_dados_vencimento nldc
                   WHERE nldc.leads_pk =".$this->leads_pk;
            $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

            $results = sql_query($sql);    
            $rows = mysql_fetch_array($results);
            $dt_vencimento = $rows['dt_vencimento']; 
            
            if(!empty($dt_vencimento)){
                //GERA OCORRENCIA DE OPORTUNIDADE
                $descricao_oc = "OPORTUNIDADE IDENTIFICADA DATA DE VENCIMENTO DE CONTRATO OPERADORA ".$row['dsc_operador']." Data vencimento do contrato ".$dt_vencimento;        
                ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $descricao_oc, 'codtipoocorrencialead' => 5000));
                
                
                //GERA OCORRENCIA DE RETORNO
                $sql ="";
                $sql.="select date_add('".dataYMD($dt_vencimento)."', interval -1 month) dt_retorno ";

                $result = sql_query($sql);
                $row = mysql_fetch_array($result);        
                $dt_retorno = $row['dt_retorno'];
                mysql_free_result($result);            

                $descricao_oc = "VENDIMENTO DO CONTRATO EM ".$dt_vencimento."<br><br> DATA DE RETORNO PARA ".$dt_retorno;

                ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $descricao_oc,'dt_retorno'=>$dt_retorno, 'codtipoocorrencialead' => 6001));           
                
            }
            
            mysql_free_result($results);           
            
        }   
        
        //FECHAR OC ACOMPANHAMENTO DE AGENDAMENTO.
        $this->fecha_oc();

        
    }  
    function add_oc_vencimento(){
        $sql ="";
        $sql.="select date_add('".dataYMD($this->vencimento_contrato)."', interval -1 month) dt_retorno ";

        $result = sql_query($sql);
        $row = mysql_fetch_array($result);        
        $dt_retorno = $row['dt_retorno'];
        mysql_free_result($result);            

        $descricao_oc = "VENDIMENTO DO CONTRATO EM ".$this->vencimento_contrato."<br><br> DATA DE RETORNO PARA".$dt_retorno;

        ocorrencias::adicionar(array('codlead' => $this->leads_pk, 'descricao' => $descricao_oc,'dt_retorno'=>$dt_retorno, 'codtipoocorrencialead' => 6001));
    }
    function fecha_oc(){
        $sql ="";
        $sql.="SELECT a.CodOcorrenciaLead
                FROM agendaslead a
               WHERE a.CodAgendaLead =".$this->agenda_visita_pk;
        
        $result = sql_query($sql);
        $row = mysql_fetch_array($result);        
        $codocorrencialead = $row['CodOcorrenciaLead'];
        mysql_free_result($result);  
        
        $codocorrencialead = $codocorrencialead + 2;
        $fields['DataFechamento'] = "sysdate()";
        $fields['dt_retorno_fechamento']  = "sysdate()";
        $fields['dsc_retorno'] = "Visita improdutiva Sem interesse";
        
        $sql = sqlupdate('ocorrenciaslead', $fields, ' codocorrencialead = ' . mysqlnull($codocorrencialead));
        mysql_query($sql);   
        
    }
	function excluir(){
		
		$sql = "delete from agendaslead where pk = ".mysqlnull($this->pk);
		mysql_query($sql);
		return true;
		
	}	
	
}
?>


