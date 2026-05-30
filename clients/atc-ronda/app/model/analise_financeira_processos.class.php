<?

class analise_financeira_processos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_nivel_usuario;
    private $ic_recusa;
    private $obs_recusa;
    private $ic_correcao;
    private $obs_correcao;
    private $ic_aprovacao;
    private $obs_aprovacao;
    private $dt_cancelamento;
    private $obs_cancelamento;
    private $analise_financeira_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_nivel_usuario = null;
        $this->ic_recusa = null;
        $this->obs_recusa = null;
        $this->ic_correcao = null;
        $this->obs_correcao = null;
        $this->ic_aprovacao = null;
        $this->obs_aprovacao = null;
        $this->dt_cancelamento = null;
        $this->obs_cancelamento = null;
        $this->analise_financeira_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_nivel_usuario(){return $this->tipo_nivel_usuario;}
    function getic_recusa(){return $this->ic_recusa;}
    function getobs_recusa(){return $this->obs_recusa;}
    function getic_correcao(){return $this->ic_correcao;}
    function getobs_correcao(){return $this->obs_correcao;}
    function getic_aprovacao(){return $this->ic_aprovacao;}
    function getobs_aprovacao(){return $this->obs_aprovacao;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getobs_cancelamento(){return $this->obs_cancelamento;}
    function getanalise_financeira_pk(){return $this->analise_financeira_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_nivel_usuario($tipo_nivel_usuario){ $this->tipo_nivel_usuario = $tipo_nivel_usuario;}
    function setic_recusa($ic_recusa){ $this->ic_recusa = $ic_recusa;}
    function setobs_recusa($obs_recusa){ $this->obs_recusa = $obs_recusa;}
    function setic_correcao($ic_correcao){ $this->ic_correcao = $ic_correcao;}
    function setobs_correcao($obs_correcao){ $this->obs_correcao = $obs_correcao;}
    function setic_aprovacao($ic_aprovacao){ $this->ic_aprovacao = $ic_aprovacao;}
    function setobs_aprovacao($obs_aprovacao){ $this->obs_aprovacao = $obs_aprovacao;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setobs_cancelamento($obs_cancelamento){ $this->obs_cancelamento = $obs_cancelamento;}
    function setanalise_financeira_pk($analise_financeira_pk){ $this->analise_financeira_pk = $analise_financeira_pk;}

    
}

?>
