<?

class agenda{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_agendas_pk;
    private $dt_ini_agenda_ini;
    private $dt_hr_agenda_fim;
    private $ic_lembrete;
    private $ic_repetir;
    private $ds_link_reuniao;
    private $ds_cep;
    private $ds_endereco;
    private $ds_complemento;
    private $ds_numero;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $leads_pk;
    private $ic_status;
    private $ds_obs;
    private $agendas_reagendamento_pk;
    private $ds_obs_reagendamento;
    private $motivo_cancelameto_pk;
    private $classificacao_pk;
    private $obs_classificacao;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_agendas_pk = null;
        $this->dt_ini_agenda_ini = null;
        $this->dt_hr_agenda_fim = null;
        $this->ic_lembrete = null;
        $this->ic_repetir = null;
        $this->ds_link_reuniao = null;
        $this->ds_cep = null;
        $this->ds_endereco = null;
        $this->ds_complemento = null;
        $this->ds_numero = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->leads_pk = null;
        $this->ic_status = null;
        $this->ds_obs = null;
        $this->agendas_reagendamento_pk = null;
        $this->ds_obs_reagendamento = null;
        $this->motivo_cancelameto_pk = null;           
        $this->classificacao_pk = null;           
        $this->obs_classificacao = null;           

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_agendas_pk(){return $this->tipo_agendas_pk;}
    function getdt_ini_agenda_ini(){return $this->dt_ini_agenda_ini;}
    function getdt_hr_agenda_fim(){return $this->dt_hr_agenda_fim;}
    function getic_lembrete(){return $this->ic_lembrete;}
    function getic_repetir(){return $this->ic_repetir;}
    function getds_link_reuniao(){return $this->ds_link_reuniao;}
    function getds_cep(){return $this->ds_cep;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_numero(){return $this->ds_numero;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_status(){return $this->ic_status;}
    function getds_obs(){return $this->ds_obs;}
    function getagendas_reagendamento_pk(){return $this->agendas_reagendamento_pk;}
    function getds_obs_reagendamento(){return $this->ds_obs_reagendamento;}
    function getmotivo_cancelameto_pk(){return $this->motivo_cancelameto_pk;}
    function getclassificacao_pk(){return $this->classificacao_pk;}
    function getobs_classificacao(){return $this->obs_classificacao;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_agendas_pk($tipo_agendas_pk){ $this->tipo_agendas_pk = $tipo_agendas_pk;}
    function setdt_ini_agenda_ini($dt_ini_agenda_ini){ $this->dt_ini_agenda_ini = $dt_ini_agenda_ini;}
    function setdt_hr_agenda_fim($dt_hr_agenda_fim){ $this->dt_hr_agenda_fim = $dt_hr_agenda_fim;}
    function setic_lembrete($ic_lembrete){ $this->ic_lembrete = $ic_lembrete;}
    function setic_repetir($ic_repetir){ $this->ic_repetir = $ic_repetir;}
    function setds_link_reuniao($ds_link_reuniao){ $this->ds_link_reuniao = $ds_link_reuniao;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    function setagendas_reagendamento_pk($agendas_reagendamento_pk){ $this->agendas_reagendamento_pk = $agendas_reagendamento_pk;}
    function setds_obs_reagendamento($ds_obs_reagendamento){ $this->ds_obs_reagendamento = $ds_obs_reagendamento;}
    function setmotivo_cancelameto_pk($motivo_cancelameto_pk){ $this->motivo_cancelameto_pk = $motivo_cancelameto_pk;}
    function setclassificacao_pk($classificacao_pk){ $this->classificacao_pk = $classificacao_pk;}
    function setobs_classificacao($obs_classificacao){ $this->obs_classificacao = $obs_classificacao;}

    
}

?>
