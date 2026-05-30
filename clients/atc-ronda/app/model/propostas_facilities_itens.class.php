<?

class propostas_facilities_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_percentual;
    private $ds_valor;
    private $ic_status;
    private $propostas_facilities_label_pk;
    private $propostas_facilities_grupos_subgrupos_pk;
    private $propostas_facilities_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_percentual = null;
        $this->ds_valor = null;
        $this->ic_status = null;
        $this->propostas_facilities_label_pk = null;
        $this->propostas_facilities_grupos_subgrupos_pk = null;
        $this->propostas_facilities_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_percentual(){return $this->ds_percentual;}
    function getds_valor(){return $this->ds_valor;}
    function getic_status(){return $this->ic_status;}
    function getpropostas_facilities_label_pk(){return $this->propostas_facilities_label_pk;}
    function getpropostas_facilities_grupos_subgrupos_pk(){return $this->propostas_facilities_grupos_subgrupos_pk;}
    function getpropostas_facilities_pk(){return $this->propostas_facilities_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_percentual($ds_percentual){ $this->ds_percentual = $ds_percentual;}
    function setds_valor($ds_valor){ $this->ds_valor = $ds_valor;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setpropostas_facilities_label_pk($propostas_facilities_label_pk){ $this->propostas_facilities_label_pk = $propostas_facilities_label_pk;}
    function setpropostas_facilities_grupos_subgrupos_pk($propostas_facilities_grupos_subgrupos_pk){ $this->propostas_facilities_grupos_subgrupos_pk = $propostas_facilities_grupos_subgrupos_pk;}
    function setpropostas_facilities_pk($propostas_facilities_pk){ $this->propostas_facilities_pk = $propostas_facilities_pk;}

    
}

?>
