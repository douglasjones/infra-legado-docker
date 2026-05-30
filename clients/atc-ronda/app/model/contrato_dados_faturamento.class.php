<?

class contrato_dados_faturamento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $metodos_pagamento_pk;
    private $num_parcela;
    private $dt_pagamento;
    private $vl_servico;
    private $contratos_pk;
    private $dt_faturamento;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->metodos_pagamento_pk = null;
        $this->num_parcela = null;
        $this->dt_pagamento = null;
        $this->vl_servico = null;
        $this->contratos_pk = null;
        $this->dt_faturamento = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getmetodos_pagamento_pk(){return $this->metodos_pagamento_pk;}
    function getnum_parcela(){return $this->num_parcela;}
    function getdt_pagamento(){return $this->dt_pagamento;}
    function getvl_servico(){return $this->vl_servico;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getdt_faturamento(){return $this->dt_faturamento;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setmetodos_pagamento_pk($metodos_pagamento_pk){ $this->metodos_pagamento_pk = $metodos_pagamento_pk;}
    function setnum_parcela($num_parcela){ $this->num_parcela = $num_parcela;}
    function setdt_pagamento($dt_pagamento){ $this->dt_pagamento = $dt_pagamento;}
    function setvl_servico($vl_servico){ $this->vl_servico = $vl_servico;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setdt_faturamento($dt_faturamento){ $this->dt_faturamento = $dt_faturamento;}

    
}

?>
