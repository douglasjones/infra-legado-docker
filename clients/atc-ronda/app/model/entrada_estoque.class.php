<?

class entrada_estoque{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_n_ordem;
    private $obs_entrada_estoque;
    private $fornecedor_pk;
    private $produtos_pk;
    private $qtde;
    private $vl_unitario;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_n_ordem = null;
        $this->obs_entrada_estoque = null;
        $this->fornecedor_pk = null;
        $this->produtos_pk = null;
        $this->qtde = null;
        $this->vl_unitario = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_n_ordem(){return $this->ds_n_ordem;}
    function getobs_entrada_estoque(){return $this->obs_entrada_estoque;}
    function getfornecedor_pk(){return $this->fornecedor_pk;}
    function getprodutos_pk(){return $this->produtos_pk;}
    function getqtde(){return $this->qtde;}
    function getvl_unitario(){return $this->vl_unitario;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_n_ordem($ds_n_ordem){ $this->ds_n_ordem = $ds_n_ordem;}
    function setobs_entrada_estoque($obs_entrada_estoque){ $this->obs_entrada_estoque = $obs_entrada_estoque;}
    function setfornecedor_pk($fornecedor_pk){ $this->fornecedor_pk = $fornecedor_pk;}
    function setprodutos_pk($produtos_pk){ $this->produtos_pk = $produtos_pk;}
    function setqtde($qtde){ $this->qtde = $qtde;}
    function setvl_unitario($vl_unitario){ $this->vl_unitario= $vl_unitario;}

    
}

?>
