<?

class propostas_facilities_grupos_subgrupos{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ic_tipo_grupo;
    private $ds_nome_grupo;
    private $grupo_pai_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ic_tipo_grupo = null;
        $this->ds_nome_grupo = null;
        $this->grupo_pai_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getic_tipo_grupo(){return $this->ic_tipo_grupo;}
    function getds_nome_grupo(){return $this->ds_nome_grupo;}
    function getgrupo_pai_pk(){return $this->grupo_pai_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setic_tipo_grupo($ic_tipo_grupo){ $this->ic_tipo_grupo = $ic_tipo_grupo;}
    function setds_nome_grupo($ds_nome_grupo){ $this->ds_nome_grupo = $ds_nome_grupo;}
    function setgrupo_pai_pk($grupo_pai_pk){ $this->grupo_pai_pk = $grupo_pai_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
