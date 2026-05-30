<?

class colaborador_recibo{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $colaborador_pk;
    private $vl_total;
    private $tipos_recibos_pk;
    private $mes_ini_pk;
    private $ano_ini_pk;
    private $mes_fim_pk;
    private $ano_fim_pk;
       
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->colaborador_pk = null;
        $this->vl_total = null;
        $this->tipos_recibos_pk = null;
        
        $this->mes_ini_pk = null;
        $this->ano_ini_pk = null;
        $this->mes_fim_pk = null;
        $this->ano_fim_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getvl_total(){return $this->vl_total;}
    function gettipos_recibos_pk(){return $this->tipos_recibos_pk;}
    function getmes_ini_pk(){return $this->mes_ini_pk;}
    function getano_ini_pk(){return $this->ano_ini_pk;}
    function getmes_fim_pk(){return $this->mes_fim_pk;}
    function getano_fim_pk(){return $this->ano_fim_pk;}
      
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setvl_total($vl_total){ $this->vl_total = $vl_total;}
    function settipos_recibos_pk($tipos_recibos_pk){ $this->tipos_recibos_pk = $tipos_recibos_pk;}
    
    function setmes_ini_pk($mes_ini_pk){ $this->mes_ini_pk = $mes_ini_pk;}
    function setano_ini_pk($ano_ini_pk){ $this->ano_ini_pk = $ano_ini_pk;}
    function setmes_fim_pk($mes_fim_pk){ $this->mes_fim_pk = $mes_fim_pk;}
    function setano_fim_pk($ano_fim_pk){ $this->ano_fim_pk = $ano_fim_pk;}
    
}

?>
