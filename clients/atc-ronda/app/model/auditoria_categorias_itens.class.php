<?

class auditoria_categorias_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_categoria_item;
    private $tipo_item_pk;
    private $ic_status;
    private $auditorias_categorias_pk;
    private $auditorias_categorias_tipos_pk;
    private $ic_obrigatorio;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_categoria_item = null;
        $this->tipo_item_pk = null;
        $this->ic_status = null;
        $this->auditorias_categorias_pk = null;
        $this->auditorias_categorias_tipos_pk = null;
        $this->ic_obrigatorio = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_categoria_item(){return $this->ds_categoria_item;}
    function gettipo_item_pk(){return $this->tipo_item_pk;}
    function getic_status(){return $this->ic_status;}
    function getauditorias_categorias_pk(){return $this->auditorias_categorias_pk;}
    function getauditorias_categorias_tipos_pk(){return $this->auditorias_categorias_tipos_pk;}
    function getic_obrigatorio(){return $this->ic_obrigatorio;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_categoria_item($ds_categoria_item){ $this->ds_categoria_item = $ds_categoria_item;}
    function settipo_item_pk($tipo_item_pk){ $this->tipo_item_pk = $tipo_item_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setauditorias_categorias_pk($auditorias_categorias_pk){ $this->auditorias_categorias_pk = $auditorias_categorias_pk;}
    function setauditorias_categorias_tipos_pk($auditorias_categorias_tipos_pk){ $this->auditorias_categorias_tipos_pk = $auditorias_categorias_tipos_pk;}
    function setic_obrigatorio($ic_obrigatorio){ $this->ic_obrigatorio = $ic_obrigatorio;}

    
}

?>
