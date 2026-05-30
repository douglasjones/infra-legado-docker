<?

class solicitacao_liberacao_app{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_pin;
    private $colaborador_pk;
    private $id_cliente;
    private $ds_imagem;
    private $dt_solit_liberacao;
    private $ds_aparelho;
    private $dt_liberacao;
    private $usuario_aprovacao_pk;
    private $obs;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_pin = null;
        $this-> colaborador_pk = null;
        $this->id_cliente = null;
        $this->ds_imagem = null;
        $this->dt_solit_liberacao = null;
        $this-> ds_aparelho = null;
        $this->dt_liberacao = null;
        $this->usuario_aprovacao_pk = null;
        $this->obs = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_pin(){return $this->ds_pin;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getid_cliente(){return $this->id_cliente;}
    function getds_imagem(){return $this->ds_imagem;}
    function getdt_solit_liberacao(){return $this->dt_solit_liberacao;}
    function getds_aparelho(){return $this->ds_aparelho;}
    function getdt_liberacao(){return $this->dt_liberacao;}
    function getusuario_aprovacao_pk(){return $this->usuario_aprovacao_pk;}
    function getobs(){return $this->obs;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_pin($ds_pin){ $this->ds_pin = $ds_pin;}
    function setcolaborador_pk($colaborador_pk){$this->colaborador_pk = $colaborador_pk;}
    function setid_cliente($id_cliente){ $this->id_cliente = $id_cliente;}
    function setds_imagem($ds_imagem){ $this->ds_imagem = $ds_imagem;}
    function setdt_solit_liberacao($dt_solit_liberacao){ $this->dt_solit_liberacao = $dt_solit_liberacao;}
    function setds_aparelho($ds_aparelho){ $this->ds_aparelho = $ds_aparelho;}
    function setdt_liberacao($dt_liberacao){ $this->dt_liberacao = $dt_liberacao;}
    function setusuario_aprovacao_pk($usuario_aprovacao_pk){ $this->usuario_aprovacao_pk = $usuario_aprovacao_pk;}
    function setobs($obs){ $this->obs = $obs;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
