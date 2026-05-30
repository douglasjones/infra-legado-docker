<?

class lancamento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_vencimento;
    private $ds_lancamento;
    private $vl_lancamento;
    private $operacao_pk;
    private $tipo_grupo_pk;
    private $grupo_leancamento_pk;
    private $ic_status_pagamento;
    private $obs_lancamento;
    private $dt_competencia;
    private $n_documento;
    private $contas_bancarias_pk;
    private $tipos_operacao_pk;
    private $metodos_pagamento_pk;
    private $empresas_pk;
    private $tipo_grupo_centro_custo_pk;
    private $grupo_lancamento_centro_custo_pk;
    private $ds_ocorrencia;
    private $dt_pagamento;
    private $contratos_pk;
    private $compras_pk;
    private $dt_faturamento;

    private $categoria_operacao_pk;
    private $leads_clientes_pk;
    private $leads_posto_trabalho_pk;
    private $colaborador_posto_trabalho_pk;
    private $fornecedor_posto_trabalho_pk;
    private $colaborador_contratos_pk; 
    private $fornecedor_contratos_pk; 
    private $colaborador_pk;
    private $fornecedor_pk;
    private $parcela_pk;
    private $ds_num_documento;
    private $ic_tipo_num_documento;
   
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_vencimento = null;
        $this->ds_lancamento = null;
        $this->vl_lancamento = null;
        $this->operacao_pk = null;
        $this->tipo_grupo_pk = null;       
        $this->grupo_leancamento_pk = null;
        $this->ic_status_pagamento = null;
        $this->obs_lancamento = null;
        $this->dt_competencia = null;
        $this->n_documento = null;
        $this->contas_bancarias_pk = null;
        $this->tipos_operacao_pk = null;
        $this->metodos_pagamento_pk = null;
        $this->empresas_pk = null;
        $this->tipo_grupo_centro_custo_pk = null;
        $this->grupo_lancamento_centro_custo_pk = null;
        $this->ds_ocorrencia = null;
        $this->dt_pagamento = null;
        $this->contratos_pk = null;
        $this->compras_pk = null;
        $this->dt_faturamento = null;

        $this->categoria_operacao_pk  = null;
        $this->leads_clientes_pk  = null;
        $this->leads_posto_trabalho_pk  = null;
        $this->colaborador_posto_trabalho_pk  = null;
        $this->colaborador_contratos_pk = null;
        $this->fornecedor_posto_trabalho_pk  = null;
        $this->fornecedor_contratos_pk  = null;       
        $this->colaborador_pk = null;
        $this->fornecedor_pk = null; 
        $this->parcela_pk = null; 
        $this->ds_num_documento = null; 
        $this->ic_tipo_num_documento = null; 
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_vencimento(){return $this->dt_vencimento;}
    function getds_lancamento(){return $this->ds_lancamento;}
    function getvl_lancamento(){return $this->vl_lancamento;}
    function getoperacao_pk(){return $this->operacao_pk;}
    function gettipo_grupo_pk(){return $this->tipo_grupo_pk;}   
    function getgrupo_leancamento_pk(){return $this->grupo_leancamento_pk;}
    function getic_status_pagamento(){return $this->ic_status_pagamento;}
    function getobs_lancamento(){return $this->obs_lancamento;}
    function getdt_competencia(){return $this->dt_competencia;}
    function getn_documento(){return $this->n_documento;}
    function getcontas_bancarias_pk(){return $this->contas_bancarias_pk;}
    function gettipos_operacao_pk(){return $this->tipos_operacao_pk;}
    function getmetodos_pagamento_pk(){return $this->metodos_pagamento_pk;}
    function getempresas_pk(){return $this->empresas_pk;}
    function gettipo_grupo_centro_custo_pk(){return $this->tipo_grupo_centro_custo_pk;}
    function getgrupo_lancamento_centro_custo_pk(){return $this->grupo_lancamento_centro_custo_pk;}
    function getds_ocorrencia(){return $this->ds_ocorrencia;}
    function getdt_pagamento(){return $this->dt_pagamento;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getcompras_pk(){return $this->compras_pk;}
    function getdt_faturamento(){return $this->dt_faturamento;}

    function getcategoria_operacao_pk(){return $this->categoria_operacao_pk;}
    function getleads_clientes_pk(){return $this->leads_clientes_pk;}
    function getleads_posto_trabalho_pk(){return $this->leads_posto_trabalho_pk;}
    function getcolaborador_posto_trabalho_pk(){return $this->colaborador_posto_trabalho_pk;}
    function getcolaborador_contratos_pk(){return $this->colaborador_contratos_pk;}    
    function getfornecedor_posto_trabalho_pk(){return $this->fornecedor_posto_trabalho_pk;}
    function getfornecedor_contratos_pk(){return $this->fornecedor_contratos_pk;}   
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getfornecedor_pk(){return $this->fornecedor_pk;}
    function getparcela_pk(){return $this->parcela_pk;}
    function getds_num_documento(){return $this->ds_num_documento;}
    function getic_tipo_num_documento(){return $this->ic_tipo_num_documento;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_vencimento($dt_vencimento){ $this->dt_vencimento = $dt_vencimento;}
    function setds_lancamento($ds_lancamento){ $this->ds_lancamento = $ds_lancamento;}
    function setvl_lancamento($vl_lancamento){ $this->vl_lancamento = $vl_lancamento;}
    function setoperacao_pk($operacao_pk){ $this->operacao_pk = $operacao_pk;}
    function settipo_grupo_pk($tipo_grupo_pk){ $this->tipo_grupo_pk = $tipo_grupo_pk;}   
    function setgrupo_leancamento_pk($grupo_leancamento_pk){ $this->grupo_leancamento_pk = $grupo_leancamento_pk;}
    function setic_status_pagamento($ic_status_pagamento){ $this->ic_status_pagamento = $ic_status_pagamento;}
    function setobs_lancamento($obs_lancamento){ $this->obs_lancamento = $obs_lancamento;}
    function setdt_competencia($dt_competencia){ $this->dt_competencia = $dt_competencia;}
    function setn_documento($n_documento){ $this->n_documento = $n_documento;}
    function setcontas_bancarias_pk($contas_bancarias_pk){ $this->contas_bancarias_pk = $contas_bancarias_pk;}
    function settipos_operacao_pk($tipos_operacao_pk){ $this->tipos_operacao_pk = $tipos_operacao_pk;}
    function setmetodos_pagamento_pk($metodos_pagamento_pk){ $this->metodos_pagamento_pk = $metodos_pagamento_pk;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}
    function settipo_grupo_centro_custo_pk($tipo_grupo_centro_custo_pk){ $this->tipo_grupo_centro_custo_pk = $tipo_grupo_centro_custo_pk;}
    function setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk){ $this->grupo_lancamento_centro_custo_pk = $grupo_lancamento_centro_custo_pk;}
    function setds_ocorrencia($ds_ocorrencia){ $this->ds_ocorrencia = $ds_ocorrencia;}
    function setdt_pagamento($dt_pagamento){ $this->dt_pagamento = $dt_pagamento;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setcompras_pk($compras_pk){ $this->compras_pk= $compras_pk;}
    function setdt_faturamento($dt_faturamento){ $this->dt_faturamento= $dt_faturamento;}

    function setcategoria_operacao_pk($categoria_operacao_pk){ $this->categoria_operacao_pk= $categoria_operacao_pk;}
    function setleads_clientes_pk($leads_clientes_pk){ $this->leads_clientes_pk= $leads_clientes_pk;}
    function setleads_posto_trabalho_pk($leads_posto_trabalho_pk){ $this->leads_posto_trabalho_pk= $leads_posto_trabalho_pk;}
    function setcolaborador_posto_trabalho_pk($colaborador_posto_trabalho_pk){ $this->colaborador_posto_trabalho_pk= $colaborador_posto_trabalho_pk;}
    function setcolaborador_contratos_pk($colaborador_contratos_pk){ $this->colaborador_contratos_pk= $colaborador_contratos_pk;}    
    function setfornecedor_posto_trabalho_pk($fornecedor_posto_trabalho_pk){ $this->fornecedor_posto_trabalho_pk= $fornecedor_posto_trabalho_pk;}
    function setfornecedor_contratos_pk($fornecedor_contratos_pk){ $this->fornecedor_contratos_pk= $fornecedor_contratos_pk;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk= $colaborador_pk;}
    function setfornecedor_pk($fornecedor_pk){ $this->fornecedor_pk= $fornecedor_pk;}
    function setparcela_pk($parcela_pk){ $this->parcela_pk= $parcela_pk;}
    function setds_num_documento($ds_num_documento){ $this->ds_num_documento= $ds_num_documento;}
    function setic_tipo_num_documento($ic_tipo_num_documento){ $this->ic_tipo_num_documento= $ic_tipo_num_documento;}


    
}

?>
