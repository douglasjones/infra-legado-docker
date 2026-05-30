<?

class teto_gastos_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $operacao_pk;
    private $categoria_operacao_pk;
    private $tipos_operacao_pk;
    private $dt_ini_teto;
    private $dt_fim_teto;
    private $vl_teto_anual;
    private $vl_teto_mensal;
    private $ic_teto_mensal;
    private $vl_teto_anual_atual;
    private $vl_teto_mensal_atual;
    private $ic_status;
    private $obs;
    private $teto_gastos_pk;
    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->operacao_pk = null;
        $this->categoria_operacao_pk = null;
        $this->tipos_operacao_pk = null;
        $this->dt_ini_teto = null;
        $this->dt_fim_teto = null;
        $this->vl_teto_anual = null;
        $this->vl_teto_mensal = null;
        $this->ic_teto_mensal = null;
        $this->vl_teto_anual_atual = null;
        $this->vl_teto_mensal_atual = null;
        $this->ic_status = null;
        $this->obs = null;
        $this->teto_gastos_pk = null;
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getoperacao_pk(){return $this->operacao_pk;}
    function getcategoria_operacao_pk(){return $this->categoria_operacao_pk;}
    function gettipos_operacao_pk(){return $this->tipos_operacao_pk;}
    function getdt_ini_teto(){return $this->dt_ini_teto;}
    function getdt_fim_teto(){return $this->dt_fim_teto;}
    function getvl_teto_anual(){return $this->vl_teto_anual;}
    function getvl_teto_mensal(){return $this->vl_teto_mensal;}
    function getic_teto_mensal(){return $this->ic_teto_mensal;}
    function getvl_teto_anual_atual(){return $this->vl_teto_anual_atual;}
    function getvl_teto_mensal_atual(){return $this->vl_teto_mensal_atual;}
    function getic_status(){return $this->ic_status;}
    function getobs(){return $this->obs;}
    function getteto_gastos_pk(){return $this->teto_gastos_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setoperacao_pk($operacao_pk){ $this->operacao_pk = $operacao_pk;}
    function setcategoria_operacao_pk($categoria_operacao_pk){ $this->categoria_operacao_pk = $categoria_operacao_pk;}
    function settipos_operacao_pk($tipos_operacao_pk){ $this->tipos_operacao_pk = $tipos_operacao_pk;}
    function setdt_ini_teto($dt_ini_teto){ $this->dt_ini_teto = $dt_ini_teto;}
    function setdt_fim_teto($dt_fim_teto){ $this->dt_fim_teto = $dt_fim_teto;}
    function setvl_teto_anual($vl_teto_anual){ $this->vl_teto_anual = $vl_teto_anual;}
    function setvl_teto_mensal($vl_teto_mensal){ $this->vl_teto_mensal = $vl_teto_mensal;}
    function setic_teto_mensal($ic_teto_mensal){ $this->ic_teto_mensal = $ic_teto_mensal;}
    function setvl_teto_anual_atual($vl_teto_anual_atual){ $this->vl_teto_anual_atual = $vl_teto_anual_atual;}
    function setvl_teto_mensal_atual($vl_teto_mensal_atual){ $this->vl_teto_mensal_atual = $vl_teto_mensal_atual;}
    function setic_status($ic_status){ $this->ic_status = $ic_status;}
    function setobs($obs){ $this->obs = $obs;}
    function setteto_gastos_pk($teto_gastos_pk){ $this->teto_gastos_pk = $teto_gastos_pk;}

    
}

?>
