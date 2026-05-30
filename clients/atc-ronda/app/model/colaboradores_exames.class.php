<?

class colaboradores_exames{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $exames_pk;
    private $dt_prevista;
    private $dt_exame;
    private $ic_status;
    private $obs;
    private $colaborador_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->exames_pk = null;
        $this->dt_prevista = null;
        $this->dt_exame = null;
        $this->ic_status = null;
        $this->obs = null;
        $this->colaborador_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getexames_pk(){return $this->exames_pk;}
    function getdt_prevista(){return $this->dt_prevista;}
    function getdt_exame(){return $this->dt_exame;}
    function getic_status(){return $this->ic_status;}
    function getobs(){return $this->obs;}
    function getcolaborador_pk(){return $this->colaborador_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setexames_pk($exames_pk){ $this->exames_pk = $exames_pk;}
    function setdt_prevista($dt_prevista){ $this->dt_prevista = $dt_prevista;}
    function setdt_exame($dt_exame){ $this->dt_exame = $dt_exame;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setobs($obs){ $this->obs = $obs;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}

    
}

?>
