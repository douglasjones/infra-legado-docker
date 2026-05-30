<?

class compras_solicitacao_orcamento_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $categorias_produto_pk;
    private $produtos_pk;
    private $ds_produto;
    private $qtde_produto;
    private $vl_unitario;
    private $compras_solicitacao_orcamentos_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->categorias_produto_pk = null;
        $this->produtos_pk = null;
        $this->ds_produto = null;
        $this->qtde_produto = null;
        $this->vl_unitario = null;
        $this->compras_solicitacao_orcamentos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcategorias_produto_pk(){return $this->categorias_produto_pk;}
    function getprodutos_pk(){return $this->produtos_pk;}
    function getds_produto(){return $this->ds_produto;}
    function getqtde_produto(){return $this->qtde_produto;}
    function getvl_unitario(){return $this->vl_unitario;}
    function getcompras_solicitacao_orcamentos_pk(){return $this->compras_solicitacao_orcamentos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcategorias_produto_pk($categorias_produto_pk){ $this->categorias_produto_pk = $categorias_produto_pk;}
    function setprodutos_pk($produtos_pk){ $this->produtos_pk = $produtos_pk;}
    function setds_produto($ds_produto){ $this->ds_produto = $ds_produto;}
    function setqtde_produto($qtde_produto){ $this->qtde_produto = $qtde_produto;}
    function setvl_unitario($vl_unitario){ $this->vl_unitario = $vl_unitario;}
    function setcompras_solicitacao_orcamentos_pk($compras_solicitacao_orcamentos_pk){ $this->compras_solicitacao_orcamentos_pk = $compras_solicitacao_orcamentos_pk;}

    
}

?>
