<?

class ponto_folha{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    private $colaborador_pk;
    private $dt_periodo_ini;
    private $dt_periodo_fim;
    private $ic_status;
    private $dt_validacao;
    private $obs;
    private $leads_pk;
    private $empresas_pk;   
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;        
        $this->colaborador_pk = null;
        $this->dt_periodo_ini = null;
        $this->dt_periodo_fim = null;
        $this->ic_status = null;
        $this->dt_validacao = null;
        $this->obs = null;
        $this->leads_pk = null;
        $this->empresas_pk = null;
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getdt_periodo_ini(){return $this->dt_periodo_ini;}
    function getdt_periodo_fim(){return $this->dt_periodo_fim;}
    function getic_status(){return $this->ic_status;}
    function getdt_validacao(){return $this->dt_validacao;}
    function getobs(){return $this->obs;}
    function getleads_pk(){return $this->leads_pk;}
    function getempresas_pk(){return $this->empresas_pk;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setdt_periodo_ini($dt_periodo_ini){ $this->dt_periodo_ini = $dt_periodo_ini;}
    function setdt_periodo_fim($dt_periodo_fim){ $this->dt_periodo_fim = $dt_periodo_fim;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setdt_validacao($dt_validacao){ $this->dt_validacao = $dt_validacao;}
    function setobs($obs){ $this->obs = $obs;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}

    
}

?>
