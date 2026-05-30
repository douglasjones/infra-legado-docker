<?

class frota_checklist_itens{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $frota_checklist_pk;
    private $auditoria_categorias_itens_pk;
    private $ds_resultado_dados;
    private $ds_resultado_textarea;
    private $auditorias_categoria_itens_dados_pk;
    private $ic_checkbox;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->frota_checklist_pk = null;
        $this->auditoria_categorias_itens_pk = null;
        $this->ds_resultado_dados = null;
        $this->ds_resultado_textarea = null;
        $this->auditorias_categoria_itens_dados_pk = null;
        $this->ic_checkbox = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function getfrota_checklist_pk(){return $this->frota_checklist_pk;}
    function getauditoria_categorias_itens_pk(){return $this->auditoria_categorias_itens_pk;}
    function getds_resultado_dados(){return $this->ds_resultado_dados;}
    function getds_resultado_textarea(){return $this->ds_resultado_textarea;}
    function getauditorias_categoria_itens_dados_pk(){return $this->auditorias_categoria_itens_dados_pk;}
    function getic_checkbox(){return $this->ic_checkbox;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setfrota_checklist_pk($frota_checklist_pk){ $this->frota_checklist_pk = $frota_checklist_pk;}
    function setauditoria_categorias_itens_pk($auditoria_categorias_itens_pk){ $this->auditoria_categorias_itens_pk = $auditoria_categorias_itens_pk;}
    function setds_resultado_dados($ds_resultado_dados){ $this->ds_resultado_dados = $ds_resultado_dados;}
    function setds_resultado_textarea($ds_resultado_textarea){ $this->ds_resultado_textarea = $ds_resultado_textarea;}
    function setauditorias_categoria_itens_dados_pk($auditorias_categoria_itens_dados_pk){ $this->auditorias_categoria_itens_dados_pk = $auditorias_categoria_itens_dados_pk;}
    function setic_checkbox($ic_checkbox){ $this->ic_checkbox = $ic_checkbox;}

    
}

?>
