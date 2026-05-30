<?
class afastamento_ferias_colaborador{
    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_apontamento;
    private $dt_inicio;
    private $dt_fim;
    private $ds_obs;
    private $colaborador_pk;
    private $leads_pk;    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_apontamento = null;
        $this->dt_inicio = null;
        $this->dt_fim = null;
        $this->ds_obs = null;
        $this->colaborador_pk = null;
        $this->leads_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_apontamento(){return $this->tipo_apontamento;}
    function getdt_inicio(){return $this->dt_inicio;}
    function getdt_fim(){return $this->dt_fim;}
    function getds_obs(){return $this->ds_obs;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getleads_pk(){return $this->leads_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_apontamento($tipo_apontamento){ $this->tipo_apontamento = $tipo_apontamento;}
    function setdt_inicio($dt_inicio){ $this->dt_inicio = $dt_inicio;}
    function setdt_fim($dt_fim){ $this->dt_fim = $dt_fim;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}

    
}

?>
