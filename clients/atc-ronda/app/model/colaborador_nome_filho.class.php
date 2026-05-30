<?

class colaborador_nome_filho{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $colaborador_pk;
    private $ds_nome_filho;
    private $ds_cpf_filho;
    private $dt_nascimento_filho;

    private $ds_tipo_sanguineo_dependente;
    private $ds_num_cartao_sus_dependente;
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->colaborador_pk = null;
        $this->ds_nome_filho = null;
        $this->ds_cpf_filho = null;
        $this->dt_nascimento_filho = null;

        $this->ds_tipo_sanguineo_dependente = null;
        $this->ds_num_cartao_sus_dependente = null;
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getds_nome_filho(){return $this->ds_nome_filho;}
    function getds_cpf_filho(){return $this->ds_cpf_filho;}
    function getdt_nascimento_filho(){return $this->dt_nascimento_filho;}

    function getds_tipo_sanguineo_dependente(){return $this->ds_tipo_sanguineo_dependente;}
    function getds_num_cartao_sus_dependente(){return $this->ds_num_cartao_sus_dependente;}
    
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setds_nome_filho($ds_nome_filho){ $this->ds_nome_filho = $ds_nome_filho;}
    function setds_cpf_filho($ds_cpf_filho){ $this->ds_cpf_filho = $ds_cpf_filho;}
    function setdt_nascimento_filho($dt_nascimento_filho){ $this->dt_nascimento_filho = $dt_nascimento_filho;}

    function setds_tipo_sanguineo_dependente($ds_tipo_sanguineo_dependente){ $this->ds_tipo_sanguineo_dependente = $ds_tipo_sanguineo_dependente;}
    function setds_num_cartao_sus_dependente($ds_num_cartao_sus_dependente){ $this->ds_num_cartao_sus_dependente = $ds_num_cartao_sus_dependente;}

    
}

?>
