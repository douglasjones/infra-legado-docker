<?

class colaborador_curso{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $colaboradores_pk;
    private $cursos_pk;
    private $dt_execucao;
    private $dt_validacao;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->colaboradores_pk = null;
        $this->cursos_pk = null;
        $this->dt_execucao = null;
        $this->dt_validacao = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaboradores_pk(){return $this->colaboradores_pk;}
    function getcursos_pk(){return $this->cursos_pk;}
    function getdt_execucao(){return $this->dt_execucao;}
    function getdt_validacao(){return $this->dt_validacao;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaboradores_pk($colaboradores_pk){ $this->colaboradores_pk = $colaboradores_pk;}
    function setcursos_pk($cursos_pk){ $this->cursos_pk = $cursos_pk;}
    function setdt_execucao($dt_execucao){ $this->dt_execucao = $dt_execucao;}
    function setdt_validacao($dt_validacao){ $this->dt_validacao = $dt_validacao;}

    
}

?>
