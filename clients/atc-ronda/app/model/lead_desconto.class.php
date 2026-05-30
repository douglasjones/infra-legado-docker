<?

class lead_desconto{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_desconto;
    private $dt_base;
    private $vl_desconto;
    private $leads_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_desconto = null;
        $this->dt_base = null;
        $this->vl_desconto = null;
        $this->leads_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_desconto(){return $this->ds_desconto;}
    function getdt_base(){return $this->dt_base;}
    function getvl_desconto(){return $this->vl_desconto;}
    function getleads_pk(){return $this->leads_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_desconto($ds_desconto){ $this->ds_desconto = $ds_desconto;}
    function setdt_base($dt_base){ $this->dt_base = $dt_base;}
    function setvl_desconto($vl_desconto){ $this->vl_desconto = $vl_desconto;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}

    
}

?>
