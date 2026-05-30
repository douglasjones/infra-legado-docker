<?

class ponto{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;    
    private $ds_pin;
    private $colaborador_pk;
    private $tipo_ponto_pk;
    private $dt_hora_ponto;
    private $ds_localizacao;
    private $ds_imagem;
    private $ponto_origem_pk;    
    private $ic_dispositivo;
    private $usuario_conferencia_pk;
    private $dt_conferencia;
    private $ic_status_conferencia;
    private $obs_conferencia;
    private $ds_total_horas_trabalhadas;
            
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_pin = null;
        $this->colaborador_pk = null;
        $this->tipo_ponto_pk = null;
        $this->dt_hora_ponto = null;
        $this->ds_localizacao = null;
        $this->ds_imagem = null;
        $this->ponto_origem_pk = null;
        $this->ic_dispositivo = null;
        $this->usuario_conferencia_pk = null;
        $this->dt_conferencia = null;
        $this->ic_status_conferencia = null;
        $this->obs_conferencia = null;  
        $this->ds_total_horas_trabalhadas = null;
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_pin(){return $this->ds_pin;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function gettipo_ponto_pk(){return $this->tipo_ponto_pk;}
    function getdt_hora_ponto(){return $this->dt_hora_ponto;}
    function getds_localizacao(){return $this->ds_localizacao;}
    function getds_imagem(){return $this->ds_imagem;}
    function getponto_origem_pk(){return $this->ponto_origem_pk;}
    function getic_dispositivo(){return $this->ic_dispositivo;}
    function getusuario_conferencia_pk(){return $this->usuario_conferencia_pk;}
    function getdt_conferencia(){return $this->dt_conferencia;}
    function getic_status_conferencia(){return $this->ic_status_conferencia;}
    function getobs_conferencia(){return $this->obs_conferencia;}
    function getds_total_horas_trabalhadas(){return $this->ds_total_horas_trabalhadas;}
   

    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_pin($ds_pin){ $this->ds_pin = $ds_pin;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function settipo_ponto_pk($tipo_ponto_pk){ $this->tipo_ponto_pk = $tipo_ponto_pk;}
    function setdt_hora_ponto($dt_hora_ponto){ $this->dt_hora_ponto = $dt_hora_ponto;}
    function setds_localizacao($ds_localizacao){ $this->ds_localizacao = $ds_localizacao;}
    function setds_imagem($ds_imagem){ $this->ds_imagem = $ds_imagem;}
    function setponto_origem_pk($ponto_origem_pk){ $this->ponto_origem_pk = $ponto_origem_pk;}
    function setic_dispositivo($ic_dispositivo){ $this->ic_dispositivo = $ic_dispositivo;}
    function setusuario_conferencia_pk($usuario_conferencia_pk){ $this->usuario_conferencia_pk = $usuario_conferencia_pk;}
    function setdt_conferencia($dt_conferencia){ $this->dt_conferencia = $dt_conferencia;}
    function setic_status_conferencia($ic_status_conferencia){ $this->ic_status_conferencia = $ic_status_conferencia;}
    function setobs_conferencia($obs_conferencia){ $this->obs_conferencia = $obs_conferencia;}
    function setds_total_horas_trabalhadas($ds_total_horas_trabalhadas){ $this->ds_total_horas_trabalhadas = $ds_total_horas_trabalhadas;}
        
}

?>
