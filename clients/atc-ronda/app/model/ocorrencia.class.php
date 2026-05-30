<?php

class ocorrencia{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_ocorrencia;
    private $tipos_ocorrencias_pk;
    private $processos_etapas_pk;
    private $dt_fechamento;
    private $leads_pk;
    private $ic_recusa;
    private $dt_prazo_execucao;
    private $clientes_pk;
    private $obs_execucao;
    private $obs_recusa;
    private $dt_visualizacao;
    private $colaborador_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_ocorrencia = null;
        $this->tipos_ocorrencias_pk = null;
        $this->processos_etapas_pk = null;
        $this->dt_fechamento = null;
        $this->leads_pk = null;
        $this->ic_recusao = null;
        $this->dt_prazo_execucao = null;
        $this->clientes_pk = null;
        $this->obs_execucao = null;
        $this->obs_recusa = null;
        $this->dt_visualizacao = null;
        $this->colaborador_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_ocorrencia(){return $this->ds_ocorrencia;}
    function gettipos_ocorrencias_pk(){return $this->tipos_ocorrencias_pk;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getdt_fechamento(){return $this->dt_fechamento;}
    function getleads_pk(){return $this->leads_pk;}
    function getdt_prazo_execucao(){return $this->dt_prazo_execucao;}
    function getic_recusa(){return $this->ic_recusa;}
    function getclientes_pk(){return $this->clientes_pk;}
    function getobs_execucao(){return $this->obs_execucao;}
    function getobs_recusa(){return $this->obs_recusa;}
    function getdt_visualizacao(){return $this->dt_visualizacao;}
    function getcolaborador_pk(){return $this->colaborador_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_ocorrencia($ds_ocorrencia){ $this->ds_ocorrencia = $ds_ocorrencia;}
    function settipos_ocorrencias_pk($tipos_ocorrencias_pk){ $this->tipos_ocorrencias_pk = $tipos_ocorrencias_pk;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setdt_fechamento($dt_fechamento){ $this->dt_fechamento = $dt_fechamento;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_recusa($ic_recusa){ $this->ic_recusa = $ic_recusa;}
    function setdt_prazo_execucao($dt_prazo_execucao){ $this->dt_prazo_execucao = $dt_prazo_execucao;}
    function setclientes_pk($clientes_pk){ $this->clientes_pk = $clientes_pk;}
    function setobs_execucao($obs_execucao){ $this->obs_execucao = $obs_execucao;}
    function setobs_recusa($obs_recusa){ $this->obs_recusa = $obs_recusa;}
    function setdt_visualizacao($dt_visualizacao){ $this->dt_visualizacao = $dt_visualizacao;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}

    
}

?>
