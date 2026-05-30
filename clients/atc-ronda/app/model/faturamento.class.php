<?

class faturamento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $dt_faturamento_ini;
    private $dt_faturamento_fim;
    private $ic_contrato_fixo;
    private $ic_contrato_aditivo;
    private $ic_contrato_servico_extra;
    private $ic_gerar_boleto;
    private $ic_gerar_fatura;
    private $ic_gerar_nota_fiscal;
    private $ic_processar_faturamento;
    private $obs;
    private $ic_status;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->dt_faturamento_ini = null;
        $this->dt_faturamento_fim = null;
        $this->ic_contrato_fixo = null;
        $this->ic_contrato_aditivo = null;
        $this->ic_contrato_servico_extra = null;
        $this->ic_gerar_boleto = null;
        $this->ic_gerar_fatura = null;
        $this->ic_gerar_nota_fiscal = null;
        $this->ic_processar_faturamento = null;
        $this->obs = null;
        $this->ic_status = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getdt_faturamento_ini(){return $this->dt_faturamento_ini;}
    function getdt_faturamento_fim(){return $this->dt_faturamento_fim;}
    function getic_contrato_fixo(){return $this->ic_contrato_fixo;}
    function getic_contrato_aditivo(){return $this->ic_contrato_aditivo;}
    function getic_contrato_servico_extra(){return $this->ic_contrato_servico_extra;}
    function getic_gerar_boleto(){return $this->ic_gerar_boleto;}
    function getic_gerar_fatura(){return $this->ic_gerar_fatura;}
    function getic_gerar_nota_fiscal(){return $this->ic_gerar_nota_fiscal;}
    function getic_processar_faturamento(){return $this->ic_processar_faturamento;}
    function getobs(){return $this->obs;}
    function getic_status(){return $this->ic_status;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setdt_faturamento_ini($dt_faturamento_ini){ $this->dt_faturamento_ini = $dt_faturamento_ini;}
    function setdt_faturamento_fim($dt_faturamento_fim){ $this->dt_faturamento_fim = $dt_faturamento_fim;}
    function setic_contrato_fixo($ic_contrato_fixo){ $this->ic_contrato_fixo = $ic_contrato_fixo;}
    function setic_contrato_aditivo($ic_contrato_aditivo){ $this->ic_contrato_aditivo = $ic_contrato_aditivo;}
    function setic_contrato_servico_extra($ic_contrato_servico_extra){ $this->ic_contrato_servico_extra = $ic_contrato_servico_extra;}
    function setic_gerar_boleto($ic_gerar_boleto){ $this->ic_gerar_boleto = $ic_gerar_boleto;}
    function setic_gerar_fatura($ic_gerar_fatura){ $this->ic_gerar_fatura = $ic_gerar_fatura;}
    function setic_gerar_nota_fiscal($ic_gerar_nota_fiscal){ $this->ic_gerar_nota_fiscal = $ic_gerar_nota_fiscal;}
    function setic_processar_faturamento($ic_processar_faturamento){ $this->ic_processar_faturamento = $ic_processar_faturamento;}
    function setobs($obs){ $this->obs = $obs;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}

    
}

?>
