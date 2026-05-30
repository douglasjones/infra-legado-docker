<?

class agendas_participantes{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ic_tipo_participante;
    private $participante_pk;
    private $ds_email;
    private $ds_cel;
    private $agendas_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ic_tipo_participante = null;
        $this->participante_pk = null;
        $this->ds_email = null;
        $this->ds_cel = null;
        $this->agendas_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getic_tipo_participante(){return $this->ic_tipo_participante;}
    function getparticipante_pk(){return $this->participante_pk;}
    function getds_email(){return $this->ds_email;}
    function getds_cel(){return $this->ds_cel;}
    function getagendas_pk(){return $this->agendas_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setic_tipo_participante($ic_tipo_participante){ $this->ic_tipo_participante = $ic_tipo_participante;}
    function setparticipante_pk($participante_pk){ $this->participante_pk = $participante_pk;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setds_cel($ds_cel){ $this->ds_cel = $ds_cel;}
    function setagendas_pk($agendas_pk){ $this->agendas_pk = $agendas_pk;}

    
}

?>
