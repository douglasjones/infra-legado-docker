<?
class produto_iten{
    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;    
    private $ds_n_serie;
    private $qtde;
    private $vl_item;
    private $produtos_pk;   
    private $entrada_estoque_pk;   
    private $dt_baixa;   
    private $obs_baixa;   
    private $usuario_baixa_pk;   
    private $ds_identificacao;   
    private $polos_pk;   
    private $dt_cancelamento;   
    private $ds_motivo_cancelamento;   
    private $compras_pk;   
    private $ic_entrega;   
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_n_serie = null;
        $this->qtde = null;
        $this->vl_item = null;
        $this->produtos_pk = null;
        $this->entrada_estoque_pk = null;
        $this->dt_baixa = null;
        $this->obs_baixa = null;
        $this->usuario_baixa_pk = null;
        $this->ds_identificacao= null;
        $this->polos_pk= null;
        $this->dt_cancelamento= null;
        $this->ds_motivo_cancelamento= null;
        $this->compras_pk= null;
        $this->ic_entrega= null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_n_serie(){return $this->ds_n_serie;}
    function getqtde(){return $this->qtde;}
    function getvl_item(){return $this->vl_item;}
    function getprodutos_pk(){return $this->produtos_pk;}
    function getentrada_estoque_pk(){return $this->entrada_estoque_pk;}
    function getdt_baixa(){return $this->dt_baixa;}
    function getobs_baixa(){return $this->obs_baixa;}
    function getusuario_baixa_pk(){return $this->usuario_baixa_pk;}
    function getds_identificacao(){return $this->ds_identificacao;}
    function getpolos_pk(){return $this->polos_pk;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getds_motivo_cancelamento(){return $this->ds_motivo_cancelamento;}
    function getcompras_pk(){return $this->compras_pk;}
    function getic_entrega(){return $this->ic_entrega;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_n_serie($ds_n_serie){ $this->ds_n_serie = $ds_n_serie;}
    function setqtde($qtde){ $this->qtde = $qtde;}
    function setvl_item($vl_item){ $this->vl_item = $vl_item;}
    function setprodutos_pk($produtos_pk){ $this->produtos_pk = $produtos_pk;}
    function setentrada_estoque_pk($entrada_estoque_pk){ $this->entrada_estoque_pk = $entrada_estoque_pk;}
    function setdt_baixa($dt_baixa){ $this->dt_baixa = $dt_baixa;}
    function setobs_baixa($obs_baixa){ $this->obs_baixa = $obs_baixa;}
    function setusuario_baixa_pk($usuario_baixa_pk){ $this->usuario_baixa_pk = $usuario_baixa_pk;}
    function setds_identificacao($ds_identificacao){ $this->ds_identificacao = $ds_identificacao;}
    function setpolos_pk($polos_pk){ $this->polos_pk = $polos_pk;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setds_motivo_cancelamento($ds_motivo_cancelamento){ $this->ds_motivo_cancelamento = $ds_motivo_cancelamento;}
    function setcompras_pk($compras_pk){ $this->compras_pk = $compras_pk;}
    function setic_entrega($ic_entrega){ $this->ic_entrega = $ic_entrega;}

    
}

?>
