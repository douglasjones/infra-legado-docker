<?

class ponto_folha_registro{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;    
    private $ponto_pk;
    private $tipo_ponto_pk;
    private $dt_hora_ponto;
    private $colaborador_pk;
    private $ic_status;
    private $ponto_folha_pk;
    
    private $hr_ini_expediente; 
    private $hr_ini_intervalo;
    private $hr_fim_intervalo;
    private $hr_fim_expediente;
    private $hr_trabalhadas;
    private $hr_excedente;
    private $hr_faltantes;                         
    private $hr_extra50;                                
    private $hr_extra100;
    private $hr_adicional_noturno;
    private $obs;
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ponto_pk = null;
        $this->tipo_ponto_pk = null;
        $this->dt_hora_ponto = null;
        $this->colaborador_pk = null;
        $this->ic_status = null;
        $this->ponto_folha_pk = null;
        
        $this->hr_ini_expediente = null;
        $this->hr_ini_intervalo = null;
        $this->hr_fim_intervalo = null;
        $this->hr_fim_expediente = null;
        $this->hr_trabalhadas = null;
        $this->hr_excedente = null;
        $this->hr_faltantes = null;                         
        $this->hr_extra50 = null;                                
        $this->hr_extra100 = null;
        $this->hr_adicional_noturno = null; 
        $this->obs = null; 
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getponto_pk(){return $this->ponto_pk;}
    function gettipo_ponto_pk(){return $this->tipo_ponto_pk;}
    function getdt_hora_ponto(){return $this->dt_hora_ponto;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getic_status(){return $this->ic_status;}
    function getponto_folha_pk(){return $this->ponto_folha_pk;}
    
    function gethr_ini_expediente(){return $this->hr_ini_expediente;}
    function gethr_ini_intervalo(){return $this->hr_ini_intervalo;}
    function gethr_fim_intervalo(){return $this->hr_fim_intervalo;}
    function gethr_fim_expediente(){return $this->hr_fim_expediente;}
    function gethr_trabalhadas(){return $this->hr_trabalhadas;}
    function gethr_excedente(){return $this->hr_excedente;}
    function gethr_faltantes(){return $this->hr_faltantes;}
    function gethr_extra50(){return $this->hr_extra50;}
    function gethr_extra100(){return $this->hr_extra100;}
    function gethr_adicional_noturno(){return $this->hr_adicional_noturno;}
    function getobs(){return $this->obs;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setponto_pk($ponto_pk){ $this->ponto_pk = $ponto_pk;}
    function settipo_ponto_pk($tipo_ponto_pk){ $this->tipo_ponto_pk = $tipo_ponto_pk;}
    function setdt_hora_ponto($dt_hora_ponto){ $this->dt_hora_ponto = $dt_hora_ponto;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setponto_folha_pk($ponto_folha_pk){ $this->ponto_folha_pk = $ponto_folha_pk;}
    
    function sethr_ini_expediente($hr_ini_expediente){ $this->hr_ini_expediente = $hr_ini_expediente;}
    function sethr_ini_intervalo($hr_ini_intervalo){ $this->hr_ini_intervalo = $hr_ini_intervalo;}    
    function sethr_fim_intervalo($hr_fim_intervalo){ $this->hr_fim_intervalo = $hr_fim_intervalo;}
    function sethr_fim_expediente($hr_fim_expediente){ $this->hr_fim_expediente = $hr_fim_expediente;}
    function sethr_trabalhadas($hr_trabalhadas){ $this->hr_trabalhadas = $hr_trabalhadas;}
    function sethr_excedente($hr_excedente){ $this->hr_excedente = $hr_excedente;}
    function sethr_faltantes($hr_faltantes){ $this->hr_faltantes = $hr_faltantes;}
    function sethr_extra50($hr_extra50){ $this->hr_extra50 = $hr_extra50;}
    function sethr_extra100($hr_extra100){ $this->hr_extra100 = $hr_extra100;}
    function sethr_adicional_noturno($hr_adicional_noturno){ $this->hr_adicional_noturno = $hr_adicional_noturno;}    
    function setobs($obs){ $this->obs = $obs;} 
}

?>
