<?

class itens_fatura{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_item_fatura;
    private $vl_total;
    private $fatura_pk;
    private $ds_descricao;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_item_fatura = null;
        $this->vl_total = null;
        $this->fatura_pk = null;
        $this->ds_descricao = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_item_fatura(){return $this->tipo_item_fatura;}
    function getvl_total(){return $this->vl_total;}
    function getfatura_pk(){return $this->fatura_pk;}
    function getds_descricao(){return $this->ds_descricao;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_item_fatura($tipo_item_fatura){ $this->tipo_item_fatura = $tipo_item_fatura;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function setfatura_pk($fatura_pk){ $this->fatura_pk = $fatura_pk;}
    function setds_descricao($ds_descricao){ $this->ds_descricao = $ds_descricao;}

    
}

?>
