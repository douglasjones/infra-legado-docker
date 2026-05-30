<?

class colaborador_beneficio{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $vl_beneficio;
    private $obs;
    private $ic_status;
    private $beneficios_pk;
    private $colaborador_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->vl_beneficio = null;
        $this->obs = null;
        $this->ic_status = null;
        $this->beneficios_pk = null;
        $this->colaborador_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getvl_beneficio(){return $this->vl_beneficio;}
    function getobs(){return $this->obs;}
    function getic_status(){return $this->ic_status;}
    function getbeneficios_pk(){return $this->beneficios_pk;}
    function getcolaborador_pk(){return $this->colaborador_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setvl_beneficio($vl_beneficio){ $this->vl_beneficio = $vl_beneficio;}
    function setobs($obs){ $this->obs = $obs;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setbeneficios_pk($beneficios_pk){ $this->beneficios_pk = $beneficios_pk;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}

    
}

?>
