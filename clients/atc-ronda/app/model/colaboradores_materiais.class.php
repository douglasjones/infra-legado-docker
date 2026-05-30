<?

class colaboradores_materiais{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $tipo_material_pk;
    private $material_pk;
    private $qtde_material;
    private $dt_entrega;
    private $dt_devolucao;
    private $obs;
    private $colaborador_pk;
    private $conjunto_material_pk;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->tipo_material_pk = null;
        $this->material_pk = null;
        $this->qtde_material = null;
        $this->dt_entrega = null;
        $this->dt_devolucao = null;
        $this->obs = null;
        $this->colaborador_pk = null;
        $this->conjunto_material_pk = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gettipo_material_pk(){return $this->tipo_material_pk;}
    function getmaterial_pk(){return $this->material_pk;}
    function getqtde_material(){return $this->qtde_material;}
    function getdt_entrega(){return $this->dt_entrega;}
    function getdt_devolucao(){return $this->dt_devolucao;}
    function getobs(){return $this->obs;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getconjunto_material_pk(){return $this->conjunto_material_pk;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function settipo_material_pk($tipo_material_pk){ $this->tipo_material_pk = $tipo_material_pk;}
    function setmaterial_pk($material_pk){ $this->material_pk = $material_pk;}
    function setqtde_material($qtde_material){ $this->qtde_material = $qtde_material;}
    function setdt_entrega($dt_entrega){ $this->dt_entrega = $dt_entrega;}
    function setdt_devolucao($dt_devolucao){ $this->dt_devolucao = $dt_devolucao;}
    function setobs($obs){ $this->obs = $obs;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setconjunto_material_pk($conjunto_material_pk){ $this->conjunto_material_pk = $conjunto_material_pk;}

    
}

?>
