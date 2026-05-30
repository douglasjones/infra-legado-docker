<?

class compra{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $fornecedor_pk;
    private $categoria_pk;
    private $conta_pk;
    private $dt_pagamento;
    private $vl_pagamento;
    private $metodos_pagamento_pk;
    private $qtde_parcelas;
    private $ds_numero_nota;
    private $ds_link_notafiscal;
    private $dt_notafiscal;
    private $vl_notafiscal;
    private $vl_frete;
    private $dt_entrega;
    private $ic_entregue;
    private $obs;
    private $grupo_lancamento_centro_custo_pk;
    private $centro_custo_pk;
    private $ic_status;
    private $compra_solicitacao_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->fornecedor_pk = null;
        $this->categoria_pk = null;
        $this->conta_pk = null;
        $this->dt_pagamento = null;
        $this->vl_pagamento = null;
        $this->metodos_pagamento_pk = null;
        $this->qtde_parcelas = null;
        $this->ds_numero_nota= null;
        $this->ds_link_notafiscal= null;
        $this->dt_notafiscal = null;
        $this->vl_notafiscal = null;
        $this->vl_frete = null;
        $this->dt_entrega = null;
        $this->ic_entregue = null;
        $this->obs = null;
        $this->grupo_lancamento_centro_custo_pk = null;
        $this->centro_custo_pk = null;
        $this->ic_status = null;
        $this->compra_solicitacao_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getfornecedor_pk(){return $this->fornecedor_pk;}
    function getcategoria_pk(){return $this->categoria_pk;}
    function getconta_pk(){return $this->conta_pk;}
    function getdt_pagamento(){return $this->dt_pagamento;}
    function getvl_pagamento(){return $this->vl_pagamento;}
    function getmetodos_pagamento_pk(){return $this->metodos_pagamento_pk;}
    function getqtde_parcelas(){return $this->qtde_parcelas;}
    function getds_numero_nota(){return $this->ds_numero_nota;}
    function getds_link_notafiscal(){return $this->ds_link_notafiscal;}
    function getdt_notafiscal(){return $this->dt_notafiscal;}
    function getvl_notafiscal(){return $this->vl_notafiscal;}
    function getvl_frete(){return $this->vl_frete;}
    function getdt_entrega(){return $this->dt_entrega;}
    function getic_entregue(){return $this->ic_entregue;}
    function getobs(){return $this->obs;}
    function getgrupo_lancamento_centro_custo_pk(){return $this->grupo_lancamento_centro_custo_pk;}
    function getcentro_custo_pk(){return $this->centro_custo_pk;}
    function getic_status(){return $this->ic_status;}
    function getcompra_solicitacao_pk(){return $this->compra_solicitacao_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setfornecedor_pk($fornecedor_pk){ $this->fornecedor_pk = $fornecedor_pk;}
    function setcategoria_pk($categoria_pk){ $this->categoria_pk = $categoria_pk;}
    function setconta_pk($conta_pk){ $this->conta_pk = $conta_pk;}
    function setdt_pagamento($dt_pagamento){ $this->dt_pagamento = $dt_pagamento;}
    function setvl_pagamento($vl_pagamento){ $this->vl_pagamento = $vl_pagamento;}
    function setmetodos_pagamento_pk($metodos_pagamento_pk){ $this->metodos_pagamento_pk = $metodos_pagamento_pk;}
    function setqtde_parcelas($qtde_parcelas){ $this->qtde_parcelas = $qtde_parcelas;}
    function setds_link_notafiscal($ds_link_notafiscal){ $this->ds_link_notafiscal = $ds_link_notafiscal;}
    function setds_numero_nota($ds_numero_nota){ $this->ds_numero_nota = $ds_numero_nota;}
    function setdt_notafiscal($dt_notafiscal){ $this->dt_notafiscal = $dt_notafiscal;}
    function setvl_notafiscal($vl_notafiscal){ $this->vl_notafiscal = $vl_notafiscal;}
    function setvl_frete($vl_frete){ $this->vl_frete = $vl_frete;}
    function setdt_entrega($dt_entrega){ $this->dt_entrega = $dt_entrega;}
    function setic_entregue($ic_entregue){ $this->ic_entregue = $ic_entregue;}
    function setobs($obs){ $this->obs = $obs;}
    function setgrupo_lancamento_centro_custo_pk($grupo_lancamento_centro_custo_pk){ $this->grupo_lancamento_centro_custo_pk = $grupo_lancamento_centro_custo_pk;}
    function setcentro_custo_pk($centro_custo_pk){ $this->centro_custo_pk = $centro_custo_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcompra_solicitacao_pk($compra_solicitacao_pk){ $this->compra_solicitacao_pk = $compra_solicitacao_pk;}

    
}

?>
