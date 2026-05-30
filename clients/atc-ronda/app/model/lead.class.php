<?

class lead{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_lead;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_cep;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $n_qtde_torres;
    private $ds_obs;
    private $ic_cliente;
    
    private $ds_razao_social;
    private $ds_cpf_cnpj;
    private $ds_ie;
    private $ds_tel;
    private $ds_fax;
    private $ds_site;
    private $ds_email;
    private $supervisores_pk;
    private $supervisor1_pk;
    private $supervisor2_pk;
    private $responsavel_pk;
    private $segmentos_pk;    
    private $dt_vencimento;    
    private $ic_tipo_lead;    
    private $leads_pai_pk;   
    private $ds_tipo; 
    private $ds_porte; 
    private $dt_abertura; 
    private $ds_atividade_principal; 
    private $ds_atividade_secundaria; 
    private $ds_socio1; 
    private $ds_socio2; 
    private $ds_socio3; 
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_lead = null;
        $this->ds_endereco = null;
        $this->ds_numero = null;
        $this->ds_complemento = null;
        $this->ds_cep = null;
        $this->ds_bairro = null;
        $this->ds_cidade = null;
        $this->ds_uf = null;
        $this->ic_cliente = null;
        $this->n_qtde_torres = null;
        $this->ds_obs = null;
        
        $this->ds_razao_social = null;
        $this->ds_cpf_cnpj = null;
        $this->ds_ie = null;
        $this->ds_tel = null;
        $this->ds_fax = null;
        $this->ds_site = null;
        $this->ds_email = null;
        $this->supervisores_pk = null;
        $this->supervisor1_pk = null;
        $this->supervisor2_pk = null;
        $this->responsavel_pk = null;
        $this->segmentos_pk = null;
        $this->dt_vencimento = null;
        $this->ic_tipo_lead = null;
        $this->leads_pai_pk = null;
        $this->ds_tipo = null;
        $this->ds_porte = null;
        $this->dt_abertura = null;
        $this->ds_atividade_principal = null;
        $this->ds_atividade_secundaria = null;
        $this->ds_socio1 = null; 
        $this->ds_socio2 = null;
        $this->ds_socio3 = null; 

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_lead(){return $this->ds_lead;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_cep(){return $this->ds_cep;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getic_cliente(){return $this->ic_cliente;}
    function getn_qtde_torres(){return $this->n_qtde_torres;}
    function getds_obs(){return $this->ds_obs;}    
    function getds_razao_social(){return $this->ds_razao_social;}
    function getds_cpf_cnpj(){return $this->ds_cpf_cnpj;}
    function getds_ie(){return $this->ds_ie;}
    function getds_tel(){return $this->ds_tel;}
    function getds_fax(){return $this->ds_fax;}
    function getds_site(){return $this->ds_site;}
    function getds_email(){return $this->ds_email;}
    function getsupervisores_pk(){return $this->supervisores_pk;}
    function getsupervisor1_pk(){return $this->supervisor1_pk;}
    function getsupervisor2_pk(){return $this->supervisor2_pk;}
    function getresponsavel_pk(){return $this->responsavel_pk;}
    function getsegmentos_pk(){return $this->segmentos_pk;}
    function getdt_vencimento(){return $this->dt_vencimento;}
    function getic_tipo_lead(){return $this->ic_tipo_lead;}
    function getleads_pai_pk(){return $this->leads_pai_pk;}
    function getds_tipo(){return $this->ds_tipo;}
    function getds_porte(){return $this->ds_porte;}
    function getdt_abertura(){return $this->dt_abertura;}
    function getds_atividade_principal(){return $this->ds_atividade_principal;}
    function getds_atividade_secundaria(){return $this->ds_atividade_secundaria;}
    function getds_socio1(){return $this->ds_socio1;}
    function getds_socio2(){return $this->ds_socio2;}
    function getds_socio3(){return $this->ds_socio3;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_lead($ds_lead){ $this->ds_lead = $ds_lead;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setic_cliente($ic_cliente){ $this->ic_cliente = $ic_cliente;}
    function setn_qtde_torres($n_qtde_torres){ $this->n_qtde_torres = $n_qtde_torres;}
    function setds_obs($ds_obs){ $this->ds_obs = $ds_obs;}
    
    function setds_razao_social($ds_razao_social){ $this->ds_razao_social = $ds_razao_social;}
    function setds_cpf_cnpj($ds_cpf_cnpj){ $this->ds_cpf_cnpj = $ds_cpf_cnpj;}
    function setds_ie($ds_ie){ $this->ds_ie = $ds_ie;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_fax($ds_fax){ $this->ds_fax = $ds_fax;}
    function setds_site($ds_site){ $this->ds_site = $ds_site;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setsupervisores_pk($supervisores_pk){ $this->supervisores_pk = $supervisores_pk;}
    function setsupervisor1_pk($supervisor1_pk){ $this->supervisor1_pk = $supervisor1_pk;}    
    function setsupervisor2_pk($supervisor2_pk){ $this->supervisor2_pk = $supervisor2_pk;}    
    function setresponsavel_pk($responsavel_pk){ $this->responsavel_pk = $responsavel_pk;}
    function setsegmentos_pk($segmentos_pk){ $this->segmentos_pk = $segmentos_pk;}    
    function setdt_vencimento($dt_vencimento){ $this->dt_vencimento = $dt_vencimento;}    
    function setic_tipo_lead($ic_tipo_lead){ $this->ic_tipo_lead = $ic_tipo_lead;}    
    function setleads_pai_pk($leads_pai_pk){ $this->leads_pai_pk = $leads_pai_pk;} 
    function setds_tipo($ds_tipo){return $this->ds_tipo = $ds_tipo;}
    function setds_porte($ds_porte){return $this->ds_porte = $ds_porte;}
    function setdt_abertura($dt_abertura){return $this->dt_abertura = $dt_abertura;}
    function setds_atividade_principal($ds_atividade_principal){return $this->ds_atividade_principal = $ds_atividade_principal;}
    function setds_atividade_secundaria($ds_atividade_secundaria){return $this->ds_atividade_secundaria = $ds_atividade_secundaria;}
    function setds_socio1($ds_socio1){return $this->ds_socio1 = $ds_socio1;}
    function setds_socio2($ds_socio2){return $this->ds_socio2 = $ds_socio2;}
    function setds_socio3($ds_socio3){return $this->ds_socio3 = $ds_socio3;}   
}
?>
