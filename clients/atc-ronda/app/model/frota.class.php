<?

class frota{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $id_veiculo;
    private $ds_placa;
    private $ds_km_inicial;
    private $ds_cor;
    private $tipo_veiculo_pk;
    private $marcas_veiculos_pk;
    private $modelos_veiculos_pk;
    private $leads_pk;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->id_veiculo = null;
        $this->ds_placa = null;
        $this->ds_km_inicial = null;
        $this->ds_cor = null;
        $this->tipo_veiculo_pk = null;
        $this->marcas_veiculos_pk = null;
        $this->modelos_veiculos_pk = null;
        $this->leads_pk = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getid_veiculo(){return $this->id_veiculo;}
    function getds_placa(){return $this->ds_placa;}
    function getds_km_inicial(){return $this->ds_km_inicial;}
    function getds_cor(){return $this->ds_cor;}
    function gettipo_veiculo_pk(){return $this->tipo_veiculo_pk;}
    function getmarcas_veiculos_pk(){return $this->marcas_veiculos_pk;}
    function getmodelos_veiculos_pk(){return $this->modelos_veiculos_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setid_veiculo($id_veiculo){ $this->id_veiculo = $id_veiculo;}
    function setds_placa($ds_placa){ $this->ds_placa = $ds_placa;}
    function setds_km_inicial($ds_km_inicial){ $this->ds_km_inicial = $ds_km_inicial;}
    function setds_cor($ds_cor){ $this->ds_cor = $ds_cor;}
    function settipo_veiculo_pk($tipo_veiculo_pk){ $this->tipo_veiculo_pk = $tipo_veiculo_pk;}
    function setmarcas_veiculos_pk($marcas_veiculos_pk){ $this->marcas_veiculos_pk = $marcas_veiculos_pk;}
    function setmodelos_veiculos_pk($modelos_veiculos_pk){ $this->modelos_veiculos_pk = $modelos_veiculos_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
