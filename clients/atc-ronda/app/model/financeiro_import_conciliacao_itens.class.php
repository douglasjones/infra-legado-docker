<?

class financeiro_import_conciliacao_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ic_tipo_transacao;
    private $dt_transacao;
    private $vl_transacao;
    private $cod_verificacao_transacao;
    private $ds_estabelecimento;
    private $financeiro_conciliacao_banco_pk;
    

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ic_tipo_transacao = null;
        $this->dt_transacao = null;
        $this->vl_transacao = null;
        $this->cod_verificacao_transacao = null;
        $this->ds_estabelecimento = null;
        $this->financeiro_conciliacao_banco_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getic_tipo_transacao(){return $this->ic_tipo_transacao;}
    function getdt_transacao(){return $this->dt_transacao;}
    function getvl_transacao(){return $this->vl_transacao;}
    function getcod_verificacao_transacao(){return $this->cod_verificacao_transacao;}
    function getds_estabelecimento(){return $this->ds_estabelecimento;}
    function getfinanceiro_conciliacao_banco_pk(){return $this->financeiro_conciliacao_banco_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setic_tipo_transacao($ic_tipo_transacao){ $this->ic_tipo_transacao = $ic_tipo_transacao;}
    function setdt_transacao($dt_transacao){ $this->dt_transacao = $dt_transacao;}
    function setvl_transacao($vl_transacao){ $this->vl_transacao = $vl_transacao;}
    function setcod_verificacao_transacao($cod_verificacao_transacao){ $this->cod_verificacao_transacao = $cod_verificacao_transacao;}
    function setds_estabelecimento($ds_estabelecimento){ $this->ds_estabelecimento = $ds_estabelecimento;}
    function setfinanceiro_conciliacao_banco_pk($financeiro_conciliacao_banco_pk){ $this->financeiro_conciliacao_banco_pk = $financeiro_conciliacao_banco_pk;}
    
}

?>
