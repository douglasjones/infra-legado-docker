<?

class colaborador_hora_extra{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $colaborador_pk;
    private $leads_pk;
    private $dt_escala;
    private $hr_extra_ini;
    private $hr_extra_fim;
    private $obs;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->colaborador_pk = null;
        $this->leads_pk = null;
        $this->dt_escala = null;
        $this->hr_extra_ini = null;
        $this->hr_extra_fim = null;
        $this->obs = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getdt_escala(){return $this->dt_escala;}
    function gethr_extra_ini(){return $this->hr_extra_ini;}
    function gethr_extra_fim(){return $this->hr_extra_fim;}
    function getobs(){return $this->obs;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setdt_escala($dt_escala){ $this->dt_escala = $dt_escala;}
    function sethr_extra_ini($hr_extra_ini){ $this->hr_extra_ini = $hr_extra_ini;}
    function sethr_extra_fim($hr_extra_fim){ $this->hr_extra_fim = $hr_extra_fim;}
    function setobs($obs){ $this->obs = $obs;}

    
}

?>
