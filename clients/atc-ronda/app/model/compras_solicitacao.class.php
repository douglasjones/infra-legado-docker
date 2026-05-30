<?php

class compras_solicitacao{
    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $solicitante_pk;
    private $ds_compra_solicitacao;
    private $dt_solicitacao;
    private $obs_solicitacao;
    private $usuario_aprovacao_pk;
    private $dt_aprovacao;
    private $obs_aprovacao;
    private $tipo_grupo_centro_custo_pk;
    private $grupo_lancamento_centrocusto_pk;
    private $empresas_pk;

    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->solicitante_pk = null;
        $this->ds_compra_solicitacao = null;
        $this->dt_solicitacao = null;
        $this->obs_solicitacao = null;
        $this->usuario_aprovacao_pk = null;
        $this->dt_aprovacao = null;
        $this->obs_aprovacao = null;
        $this->tipo_grupo_centro_custo_pk = null;
        $this->grupo_lancamento_centrocusto_pk = null;
        $this->empresas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getsolicitante_pk(){return $this->solicitante_pk;}
    function getds_compra_solicitacao(){return $this->ds_compra_solicitacao;}
    function getdt_solicitacao(){return $this->dt_solicitacao;}
    function getobs_solicitacao(){return $this->obs_solicitacao;}
    function getusuario_aprovacao_pk(){return $this->usuario_aprovacao_pk;}
    function getdt_aprovacao(){return $this->dt_aprovacao;}
    function getobs_aprovacao(){return $this->obs_aprovacao;}
    function gettipo_grupo_centro_custo_pk(){return $this->tipo_grupo_centro_custo_pk;}
    function getgrupo_lancamento_centrocusto_pk(){return $this->grupo_lancamento_centrocusto_pk;}
    function getempresas_pk(){return $this->empresas_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setsolicitante_pk($solicitante_pk){ $this->solicitante_pk = $solicitante_pk;}
    function setds_compra_solicitacao($ds_compra_solicitacao){ $this->ds_compra_solicitacao = $ds_compra_solicitacao;}
    function setdt_solicitacao($dt_solicitacao){ $this->dt_solicitacao = $dt_solicitacao;}
    function setobs_solicitacao($obs_solicitacao){ $this->obs_solicitacao = $obs_solicitacao;}
    function setusuario_aprovacao_pk($usuario_aprovacao_pk){ $this->usuario_aprovacao_pk = $usuario_aprovacao_pk;}
    function setdt_aprovacao($dt_aprovacao){ $this->dt_aprovacao = $dt_aprovacao;}
    function setobs_aprovacao($obs_aprovacao){ $this->obs_aprovacao = $obs_aprovacao;}
    function settipo_grupo_centro_custo_pk($tipo_grupo_centro_custo_pk){ $this->tipo_grupo_centro_custo_pk = $tipo_grupo_centro_custo_pk;}
    function setgrupo_lancamento_centrocusto_pk($grupo_lancamento_centrocusto_pk){ $this->grupo_lancamento_centrocusto_pk = $grupo_lancamento_centrocusto_pk;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}

    
}

?>
