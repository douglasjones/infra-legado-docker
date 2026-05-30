<?

class propostas_facilities{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_versao;
    private $ds_numero_proposta;
    private $leads_pk;
    private $ic_tipo_proposta;
    private $produtos_servicos_pk;
    private $ds_qtde_efetivo;
    private $ds_qtde_hr_semanais;
    private $ic_escala;
    private $convencao_coletiva_pk;
    private $dt_base_categoria;
    private $ds_num_registro_mte;
    private $vl_salario_piso_categoria;
    private $vl_total_proposta;
    private $vl_total_percentual_proposta;
    private $usuario_responsavel_comercial_pk;
    private $dt_envio_da_proposta;
    private $dt_previsao_fechamento;
    private $dt_fechamento;
    private $dt_cancelamento;
    private $obs_motivo_cancelamento;
    private $obs_proposta;
    private $ic_status;
    private $contratos_pk;
    private $proposta_facilities_pai_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_versao = null;
        $this->ds_numero_proposta = null;
        $this->leads_pk = null;
        $this->ic_tipo_proposta = null;
        $this->produtos_servicos_pk = null;
        $this->ds_qtde_efetivo = null;
        $this->ds_qtde_hr_semanais = null;
        $this->ic_escala = null;
        $this->convencao_coletiva_pk = null;
        $this->dt_base_categoria = null;
        $this->ds_num_registro_mte = null;
        $this->vl_salario_piso_categoria = null;
        $this->vl_total_proposta = null;
        $this->vl_total_percentual_proposta = null;
        $this->usuario_responsavel_comercial_pk = null;
        $this->dt_envio_da_proposta = null;
        $this->dt_previsao_fechamento = null;
        $this->dt_fechamento = null;
        $this->dt_cancelamento = null;
        $this->obs_motivo_cancelamento = null;
        $this->obs_proposta = null;
        $this->ic_status = null;
        $this->contratos_pk = null;
        $this->proposta_facilities_pai_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_versao(){return $this->ds_versao;}
    function getds_numero_proposta(){return $this->ds_numero_proposta;}
    function getleads_pk(){return $this->leads_pk;}
    function getic_tipo_proposta(){return $this->ic_tipo_proposta;}
    function getprodutos_servicos_pk(){return $this->produtos_servicos_pk;}
    function getds_qtde_efetivo(){return $this->ds_qtde_efetivo;}
    function getds_qtde_hr_semanais(){return $this->ds_qtde_hr_semanais;}
    function getic_escala(){return $this->ic_escala;}
    function getconvencao_coletiva_pk(){return $this->convencao_coletiva_pk;}
    function getdt_base_categoria(){return $this->dt_base_categoria;}
    function getds_num_registro_mte(){return $this->ds_num_registro_mte;}
    function getvl_salario_piso_categoria(){return $this->vl_salario_piso_categoria;}
    function getvl_total_proposta(){return $this->vl_total_proposta;}
    function getvl_total_percentual_proposta(){return $this->vl_total_percentual_proposta;}
    function getusuario_responsavel_comercial_pk(){return $this->usuario_responsavel_comercial_pk;}
    function getdt_envio_da_proposta(){return $this->dt_envio_da_proposta;}
    function getdt_previsao_fechamento(){return $this->dt_previsao_fechamento;}
    function getdt_fechamento(){return $this->dt_fechamento;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getobs_motivo_cancelamento(){return $this->obs_motivo_cancelamento;}
    function getobs_proposta(){return $this->obs_proposta;}
    function getic_status(){return $this->ic_status;}
    function getcontratos_pk(){return $this->contratos_pk;}
    function getproposta_facilities_pai_pk(){return $this->proposta_facilities_pai_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_versao($ds_versao){ $this->ds_versao = $ds_versao;}
    function setds_numero_proposta($ds_numero_proposta){ $this->ds_numero_proposta = $ds_numero_proposta;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setic_tipo_proposta($ic_tipo_proposta){ $this->ic_tipo_proposta = $ic_tipo_proposta;}
    function setprodutos_servicos_pk($produtos_servicos_pk){ $this->produtos_servicos_pk = $produtos_servicos_pk;}
    function setds_qtde_efetivo($ds_qtde_efetivo){ $this->ds_qtde_efetivo = $ds_qtde_efetivo;}
    function setds_qtde_hr_semanais($ds_qtde_hr_semanais){ $this->ds_qtde_hr_semanais = $ds_qtde_hr_semanais;}
    function setic_escala($ic_escala){ $this->ic_escala = $ic_escala;}
    function setconvencao_coletiva_pk($convencao_coletiva_pk){ $this->convencao_coletiva_pk = $convencao_coletiva_pk;}
    function setdt_base_categoria($dt_base_categoria){ $this->dt_base_categoria = $dt_base_categoria;}
    function setds_num_registro_mte($ds_num_registro_mte){ $this->ds_num_registro_mte = $ds_num_registro_mte;}
    function setvl_salario_piso_categoria($vl_salario_piso_categoria){ $this->vl_salario_piso_categoria = $vl_salario_piso_categoria;}
    function setvl_total_percentual_proposta($vl_total_percentual_proposta){ $this->vl_total_percentual_proposta = $vl_total_percentual_proposta;}
    function setvl_total_proposta($vl_total_proposta){ $this->vl_total_proposta = $vl_total_proposta;}
    function setusuario_responsavel_comercial_pk($usuario_responsavel_comercial_pk){ $this->usuario_responsavel_comercial_pk = $usuario_responsavel_comercial_pk;}
    function setdt_envio_da_proposta($dt_envio_da_proposta){ $this->dt_envio_da_proposta = $dt_envio_da_proposta;}
    function setdt_previsao_fechamento($dt_previsao_fechamento){ $this->dt_previsao_fechamento = $dt_previsao_fechamento;}
    function setdt_fechamento($dt_fechamento){ $this->dt_fechamento = $dt_fechamento;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setobs_motivo_cancelamento($obs_motivo_cancelamento){ $this->obs_motivo_cancelamento = $obs_motivo_cancelamento;}
    function setobs_proposta($obs_proposta){ $this->obs_proposta = $obs_proposta;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setproposta_facilities_pai_pk($proposta_facilities_pai_pk){ $this->proposta_facilities_pai_pk = $proposta_facilities_pai_pk;}

    
}

?>
