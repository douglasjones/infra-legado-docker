<?

class apontamento_servico_extra{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $colaborador_pk;
    private $dt_escala;
    private $leads_pk;
    private $contratos_pk;
    private $contratos_itens_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->colaborador_pk = null;
        $this->dt_escala = null;
        $this->leads_pk = null;
        $this->contratos_pk = null;
        $this->contratos_itens_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getdt_escala(){return $this->dt_escala;}
    function getleads_pk(){return $this->leads_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getcontratos_itens_pk(){return $this->contratos_itens_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setdt_escala($dt_escala){ $this->dt_escala = $dt_escala;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setcontratos_itens_pk($contratos_itens_pk){ $this->contratos_itens_pk = $contratos_itens_pk;}

    
}

?>
