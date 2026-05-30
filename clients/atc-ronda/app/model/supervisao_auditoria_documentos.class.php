<?

class supervisao_auditoria_documentos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_documento;
    private $ds_obs;
    private $ds_nome_original;
    private $supervisao_auditorias_pk;
       
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_documento = null;
        $this->ds_obs = null;
        $this->ds_nome_original = null;
        $this->supervisao_auditorias_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_documento(){return $this->ds_documento;}
    function getds_obs(){return $this->ds_obs;}
    function getds_nome_original(){return $this->ds_nome_original;}
    function getsupervisao_auditorias_pk(){return $this->supervisao_auditorias_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_documento($ds_documento){ $this->ds_documento = $ds_documento;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setds_nome_original($ds_nome_original){ $this->ds_nome_original = $ds_nome_original;}
    function setsupervisao_auditorias_pk($supervisao_auditorias_pk){ $this->supervisao_auditorias_pk = $supervisao_auditorias_pk;}

    
}

?>
