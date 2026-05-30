<?

class movimentacao_estoque{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;    
    private $leads_pk;
    private $colaborador_pk;
    private $produtos_itens_pk;
    private $qtde;
    private $dt_entrega;
    private $dt_devolucao;
    private $obs_movimentacao;
    private $conjunto_material_pk;
    private $ic_mateiral_carga;
    private $polos_origem_pk;
    private $polos_destino_pk;
    private $grupo_para_movimentacao_pk;
    private $contratos_pk;

    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->leads_pk = null;
        $this->colaborador_pk = null;
        $this->produtos_itens_pk = null;
        $this->qtde = null;
        $this->obs_movimentacao = null;
        $this->conjunto_material_pk = null;
        $this->ic_mateiral_carga = null;
        $this->polos_origem_pk = null;
        $this->polos_destino_pk = null;
        $this->grupo_para_movimentacao_pk = null;
        $this->contratos_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}    
    function getleads_pk(){return $this->leads_pk;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getprodutos_itens_pk(){return $this->produtos_itens_pk;}
    function getqtde(){return $this->qtde;}
    function getdt_entrega(){return $this->dt_entrega;}
    function getdt_devolucao(){return $this->dt_devolucao;}
    function getobs_movimentacao(){return $this->obs_movimentacao;}
    function getconjunto_material_pk(){return $this->conjunto_material_pk;}
    function getic_mateiral_carga(){return $this->ic_mateiral_carga;}
    function getpolos_origem_pk(){return $this->polos_origem_pk;}
    function getpolos_destino_pk(){return $this->polos_destino_pk;}
    function getgrupo_para_movimentacao_pk(){return $this->grupo_para_movimentacao_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}    
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setprodutos_itens_pk($produtos_itens_pk){ $this->produtos_itens_pk = $produtos_itens_pk;}
    function setqtde($qtde){ $this->qtde = $qtde;}
    function setdt_entrega($dt_entrega){ $this->dt_entrega = $dt_entrega;}
    function setdt_devolucao($dt_devolucao){ $this->dt_devolucao = $dt_devolucao;}
    function setobs_movimentacao($obs_movimentacao){ $this->obs_movimentacao = $obs_movimentacao;}
    function setconjunto_material_pk($conjunto_material_pk){ $this->conjunto_material_pk = $conjunto_material_pk;}
    function setic_mateiral_carga($ic_mateiral_carga){ $this->ic_mateiral_carga = $ic_mateiral_carga;}
    function setpolos_origem_pk($polos_origem_pk){ $this->polos_origem_pk = $polos_origem_pk;}
    function setpolos_destino_pk($polos_destino_pk){ $this->polos_destino_pk = $polos_destino_pk;}
    function setgrupo_para_movimentacao_pk($grupo_para_movimentacao_pk){ $this->grupo_para_movimentacao_pk = $grupo_para_movimentacao_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
}

?>
