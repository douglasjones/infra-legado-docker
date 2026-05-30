<?

class plano_contas{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_tipo_operacao;
    private $ic_status;
    private $categorias_financeiras_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_tipo_operacao = null;
        $this->ic_status = null;
        $this->categorias_financeiras_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_tipo_operacao(){return $this->ds_tipo_operacao;}
    function getic_status(){return $this->ic_status;}
    function getcategorias_financeiras_pk(){return $this->categorias_financeiras_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_tipo_operacao($ds_tipo_operacao){ $this->ds_tipo_operacao = $ds_tipo_operacao;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcategorias_financeiras_pk($categorias_financeiras_pk){ $this->categorias_financeiras_pk = $categorias_financeiras_pk;}

    
}

?>
