<?

class produto{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_produto;
    private $obs;
    private $ic_status;
    private $categorias_produto_pk;
    private $tipo_unidade_pk;
    private $vl_unitario;
    private $ic_tempo_troca;
    private $qtde_minima;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_produto = null;
        $this->obs = null;
        $this->ic_status = null;
        $this->categorias_produto_pk = null;
        $this->tipo_unidade_pk = null;
        $this->vl_unitario = null;
        $this->ic_tempo_troca = null;
        $this->qtde_minima = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_produto(){return $this->ds_produto;}
    function getobs(){return $this->obs;}
    function getic_status(){return $this->ic_status;}
    function getcategorias_produto_pk(){return $this->categorias_produto_pk;}
    function gettipo_unidade_pk(){return $this->tipo_unidade_pk;}
    function getvl_unitario(){return $this->vl_unitario;}
    function getic_tempo_troca(){return $this->ic_tempo_troca;}
    function getqtde_minima(){return $this->qtde_minima;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_produto($ds_produto){ $this->ds_produto = $ds_produto;}
    function setobs($obs){ $this->obs = $obs;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcategorias_produto_pk($categorias_produto_pk){ $this->categorias_produto_pk = $categorias_produto_pk;}
    function settipo_unidade_pk($tipo_unidade_pk){ $this->tipo_unidade_pk = $tipo_unidade_pk;}
    function setvl_unitario($vl_unitario){ $this->vl_unitario = $vl_unitario;}
    function setic_tempo_troca($ic_tempo_troca){ $this->ic_tempo_troca = $ic_tempo_troca;}
    function setqtde_minima($qtde_minima){ $this->qtde_minima = $qtde_minima;}

    
}

?>
