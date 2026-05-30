<?

class fornecedor{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $ds_fornecedor;
    private $ds_ddd;
    private $ds_tel;
    private $ds_email;
    private $categorias_produto_pk;
    private $ic_status;
    private $ds_cpf_cnpj;
    private $ds_razao_social;
    private $ds_endereco;
    private $ds_numero;
    private $ds_complemento;
    private $ds_bairro;
    private $ds_cidade;
    private $ds_uf;
    private $ds_cep;
    private $ds_contato;
    private $tipo_conta_bancaria;
    private $ds_agencia;
    private $ds_conta;
    private $bancos_pk;
    private $ds_digito;
    private $vl_salario;
    private $ds_pix;
    private $ds_favorecido_pix;
    


    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->ds_fornecedor = null;
        $this->ds_ddd = null;
        $this->ds_tel = null;
        $this->ds_email = null;
        $this->categorias_produto_pk = null;
        $this->ic_status = null;
        
        
        $this->ds_cpf_cnpj= null;
        $this->ds_razao_social= null;
        $this->ds_endereco= null;
        $this->ds_numero= null;
        $this->ds_complemento= null;
        $this->ds_bairro= null;
        $this->ds_cidade= null;
        $this->ds_uf= null;
        $this->ds_cep= null;
        $this->ds_contato= null;
        $this->tipo_conta_bancaria= null;
        $this->ds_agencia= null;
        $this->ds_conta= null;
        $this->bancos_pk= null;
        $this->ds_digito= null;
        $this->vl_salario= null;
        $this->ds_pix= null;
        $this->ds_favorecido_pix= null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getds_fornecedor(){return $this->ds_fornecedor;}
    function getds_ddd(){return $this->ds_ddd;}
    function getds_tel(){return $this->ds_tel;}
    function getds_email(){return $this->ds_email;}
    function getcategorias_produto_pk(){return $this->categorias_produto_pk;}
    function getic_status(){return $this->ic_status;}
    function getds_cpf_cnpj(){return $this->ds_cpf_cnpj;}
    function getds_razao_social(){return $this->ds_razao_social;}
    function getds_endereco(){return $this->ds_endereco;}
    function getds_numero(){return $this->ds_numero;}
    function getds_complemento(){return $this->ds_complemento;}
    function getds_bairro(){return $this->ds_bairro;}
    function getds_cidade(){return $this->ds_cidade;}
    function getds_uf(){return $this->ds_uf;}
    function getds_cep(){return $this->ds_cep;}
    function getds_contato(){return $this->ds_contato;}
    function gettipo_conta_bancaria(){return $this->tipo_conta_bancaria;}
    function getds_agencia(){return $this->ds_agencia;}
    function getds_conta(){return $this->ds_conta;}
    function getbancos_pk(){return $this->bancos_pk;}
    function getds_digito(){return $this->ds_digito;}
    function getvl_salario(){return $this->vl_salario;}
    function getds_pix(){return $this->ds_pix;}
    function getds_favorecido_pix(){return $this->ds_favorecido_pix;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_fornecedor($ds_fornecedor){ $this->ds_fornecedor = $ds_fornecedor;}
    function setds_ddd($ds_ddd){ $this->ds_ddd = $ds_ddd;}
    function setds_tel($ds_tel){ $this->ds_tel = $ds_tel;}
    function setds_email($ds_email){ $this->ds_email = $ds_email;}
    function setcategorias_produto_pk($categorias_produto_pk){ $this->categorias_produto_pk = $categorias_produto_pk;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setds_cpf_cnpj($ds_cpf_cnpj){ $this->ds_cpf_cnpj = $ds_cpf_cnpj;}
    function setds_razao_social($ds_razao_social){ $this->ds_razao_social = $ds_razao_social;}
    function setds_endereco($ds_endereco){ $this->ds_endereco = $ds_endereco;}
    function setds_numero($ds_numero){ $this->ds_numero = $ds_numero;}
    function setds_complemento($ds_complemento){ $this->ds_complemento = $ds_complemento;}
    function setds_bairro($ds_bairro){ $this->ds_bairro = $ds_bairro;}
    function setds_cidade($ds_cidade){ $this->ds_cidade = $ds_cidade;}
    function setds_uf($ds_uf){ $this->ds_uf = $ds_uf;}
    function setds_cep($ds_cep){ $this->ds_cep = $ds_cep;}
    function setds_contato($ds_contato){ $this->ds_contato = $ds_contato;}
    function settipo_conta_bancaria($tipo_conta_bancaria){ $this->tipo_conta_bancaria = $tipo_conta_bancaria;}
    function setds_agencia($ds_agencia){ $this->ds_agencia = $ds_agencia;}
    function setds_conta($ds_conta){ $this->ds_conta = $ds_conta;}
    function setbancos_pk($bancos_pk){ $this->bancos_pk = $bancos_pk;}
    function setds_digito($ds_digito){ $this->ds_digito = $ds_digito;}
    function setvl_salario($vl_salario){ $this->vl_salario = $vl_salario;}
    function setds_pix($ds_pix){ $this->ds_pix = $ds_pix;}
    function setds_favorecido_pix($ds_favorecido_pix){ $this->ds_favorecido_pix = $ds_favorecido_pix;}

    
}

?>
