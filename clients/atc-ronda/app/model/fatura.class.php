<?

class fatura{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $leads_pk;
    private $dt_inicio_fatura;
    private $dt_fim_fatura;
    private $vl_bruto_total;
    private $vl_falta;
    private $qtde_falta;
    private $dt_cancelamento;
    private $ds_descricao_cancelamento;
    private $empresas_pk;
    private $tipo_contrato_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->leads_pk = null;
        $this->dt_inicio_fatura = null;
        $this->dt_fim_fatura = null;
        $this->vl_bruto_total = null;
        $this->vl_falta = null;
        $this->qtde_falta = null;
        $this->dt_cancelamento = null;
        $this->ds_descricao_cancelamento = null;
        $this->empresas_pk = null;
        $this->tipo_contrato_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getleads_pk(){return $this->leads_pk;}
    function getdt_inicio_fatura(){return $this->dt_inicio_fatura;}
    function getdt_fim_fatura(){return $this->dt_fim_fatura;}
    function getvl_bruto_total(){return $this->vl_bruto_total;}
    function getvl_falta(){return $this->vl_falta;}
    function getqtde_falta(){return $this->qtde_falta;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getds_descricao_cancelamento(){return $this->ds_descricao_cancelamento;}
    function getempresas_pk(){return $this->empresas_pk;}
    function gettipo_contrato_pk(){return $this->tipo_contrato_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setdt_inicio_fatura($dt_inicio_fatura){ $this->dt_inicio_fatura = $dt_inicio_fatura;}
    function setdt_fim_fatura($dt_fim_fatura){ $this->dt_fim_fatura = $dt_fim_fatura;}
    function setvl_bruto_total($vl_bruto_total){ $this->vl_bruto_total = $vl_bruto_total;}
    function setvl_falta($vl_falta){ $this->vl_falta = $vl_falta;}
    function setqtde_falta($qtde_falta){ $this->qtde_falta = $qtde_falta;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setds_descricao_cancelamento($ds_descricao_cancelamento){ $this->ds_descricao_cancelamento = $ds_descricao_cancelamento;}
    function setempresas_pk($empresas_pk){ $this->empresas_pk = $empresas_pk;}
    function settipo_contrato_pk($tipo_contrato_pk){ $this->tipo_contrato_pk = $tipo_contrato_pk;}

    
}

?>
