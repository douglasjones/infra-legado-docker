<?

class log_exclusao{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    
    private $ds_modulo;
    private $pk_modulo;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        
        $this->ds_modulo = null;
        $this->pk_modulo = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    
    function getds_modulo(){return $this->ds_modulo;}
    function getpk_modulo(){return $this->pk_modulo;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    
    function setds_modulo($ds_modulo){ $this->ds_modulo = $ds_modulo;}
    function setpk_modulo($pk_modulo){ $this->pk_modulo = $pk_modulo;}

    
}

?>
