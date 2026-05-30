<?

class usuario_ponto{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $hr_entrada_dom;
    private $hr_saida_dom;
    private $hr_entrada_seg;
    private $hr_saida_seg;
    private $hr_entrada_ter;
    private $hr_saida_ter;
    private $hr_entrada_qua;
    private $hr_saida_qua;
    private $hr_entrada_qui;
    private $hr_saida_qui;
    private $hr_entrada_sex;
    private $hr_saida_sex;
    private $hr_entrada_sab;
    private $hr_saida_sab;
    private $ic_dom;
    private $ic_seg;
    private $ic_ter;
    private $ic_qua;
    private $ic_qui;
    private $ic_sex;
    private $ic_sab;
    private $turnos_pk_dom;
    private $turnos_pk_seg;
    private $turnos_pk_ter;
    private $turnos_pk_qua;
    private $turnos_pk_qui;
    private $turnos_pk_sex;
    private $turnos_pk_sab;
    private $usuarios_pk;
    private $colaborador_pk;
    private $ic_registrar_ponto;

    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->hr_entrada_dom = null;
        $this->hr_saida_dom = null;
        $this->hr_entrada_seg = null;
        $this->hr_saida_seg = null;
        $this->hr_entrada_ter = null;
        $this->hr_saida_ter = null;
        $this->hr_entrada_qua = null;
        $this->hr_saida_qua = null;
        $this->hr_entrada_qui = null;
        $this->hr_saida_qui = null;
        $this->hr_entrada_sex = null;
        $this->hr_saida_sex = null;
        $this->hr_entrada_sab = null;
        $this->hr_saida_sab = null;
        $this->ic_dom = null;
        $this->ic_seg = null;
        $this->ic_ter = null;
        $this->ic_qua = null;
        $this->ic_qui = null;
        $this->ic_sex = null;
        $this->ic_sab = null;
        $this->turnos_pk_dom = null;
        $this->turnos_pk_seg = null;
        $this->turnos_pk_ter = null;
        $this->turnos_pk_qua = null;
        $this->turnos_pk_qui = null;
        $this->turnos_pk_sex = null;
        $this->turnos_pk_sab = null;
        $this->usuarios_pk = null;
        $this->colaborador_pk = null;
        $this->ic_registrar_ponto = null;

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    
    function gethr_entrada_dom(){return $this->hr_entrada_dom;}
    function gethr_saida_dom(){return $this->hr_saida_dom;}
    function gethr_entrada_seg(){return $this->hr_entrada_seg;}
    function gethr_saida_seg(){return $this->hr_saida_seg;}
    function gethr_entrada_ter(){return $this->hr_entrada_ter;}
    function gethr_saida_ter(){return $this->hr_saida_ter;}
    function gethr_entrada_qua(){return $this->hr_entrada_qua;}
    function gethr_saida_qua(){return $this->hr_saida_qua;}
    function gethr_entrada_qui(){return $this->hr_entrada_qui;}
    function gethr_saida_qui(){return $this->hr_saida_qui;}
    function gethr_entrada_sex(){return $this->hr_entrada_sex;}
    function gethr_saida_sex(){return $this->hr_saida_sex;}
    function gethr_entrada_sab(){return $this->hr_entrada_sab;}
    function gethr_saida_sab(){return $this->hr_saida_sab;}
    function getic_dom(){return $this->ic_dom;}
    function getic_seg(){return $this->ic_seg;}
    function getic_ter(){return $this->ic_ter;}
    function getic_qua(){return $this->ic_qua;}
    function getic_qui(){return $this->ic_qui;}
    function getic_sex(){return $this->ic_sex;}
    function getic_sab(){return $this->ic_sab;}
    function getturnos_pk_dom(){return $this->turnos_pk_dom;}
    function getturnos_pk_seg(){return $this->turnos_pk_seg;}
    function getturnos_pk_ter(){return $this->turnos_pk_ter;}
    function getturnos_pk_qua(){return $this->turnos_pk_qua;}
    function getturnos_pk_qui(){return $this->turnos_pk_qui;}
    function getturnos_pk_sex(){return $this->turnos_pk_sex;}
    function getturnos_pk_sab(){return $this->turnos_pk_sab;}
    function getusuarios_pk(){return $this->usuarios_pk;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getic_registrar_ponto(){return $this->ic_registrar_ponto;}

    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function sethr_entrada_dom($hr_entrada_dom){ $this->hr_entrada_dom = $hr_entrada_dom;}
    function sethr_saida_dom($hr_saida_dom){ $this->hr_saida_dom = $hr_saida_dom;}
    function sethr_entrada_seg($hr_entrada_seg){ $this->hr_entrada_seg = $hr_entrada_seg;}
    function sethr_saida_seg($hr_saida_seg){ $this->hr_saida_seg = $hr_saida_seg;}
    function sethr_entrada_ter($hr_entrada_ter){ $this->hr_entrada_ter = $hr_entrada_ter;}
    function sethr_saida_ter($hr_saida_ter){ $this->hr_saida_ter = $hr_saida_ter;}
    function sethr_entrada_qua($hr_entrada_qua){ $this->hr_entrada_qua = $hr_entrada_qua;}
    function sethr_saida_qua($hr_saida_qua){ $this->hr_saida_qua = $hr_saida_qua;}
    function sethr_entrada_qui($hr_entrada_qui){ $this->hr_entrada_qui = $hr_entrada_qui;}
    function sethr_saida_qui($hr_saida_qui){ $this->hr_saida_qui = $hr_saida_qui;}
    function sethr_entrada_sex($hr_entrada_sex){ $this->hr_entrada_sex = $hr_entrada_sex;}
    function sethr_saida_sex($hr_saida_sex){ $this->hr_saida_sex = $hr_saida_sex;}
    function sethr_entrada_sab($hr_entrada_sab){ $this->hr_entrada_sab = $hr_entrada_sab;}
    function sethr_saida_sab($hr_saida_sab){ $this->hr_saida_sab = $hr_saida_sab;}
    function setic_dom($ic_dom){ $this->ic_dom = $ic_dom;}
    function setic_seg($ic_seg){ $this->ic_seg = $ic_seg;}
    function setic_ter($ic_ter){ $this->ic_ter = $ic_ter;}
    function setic_qua($ic_qua){ $this->ic_qua = $ic_qua;}
    function setic_qui($ic_qui){ $this->ic_qui = $ic_qui;}
    function setic_sex($ic_sex){ $this->ic_sex = $ic_sex;}
    function setic_sab($ic_sab){ $this->ic_sab = $ic_sab;}
    function setturnos_pk_dom($turnos_pk_dom){ $this->turnos_pk_dom = $turnos_pk_dom;}
    function setturnos_pk_seg($turnos_pk_seg){ $this->turnos_pk_seg = $turnos_pk_seg;}
    function setturnos_pk_ter($turnos_pk_ter){ $this->turnos_pk_ter = $turnos_pk_ter;}
    function setturnos_pk_qua($turnos_pk_qua){ $this->turnos_pk_qua = $turnos_pk_qua;}
    function setturnos_pk_qui($turnos_pk_qui){ $this->turnos_pk_qui = $turnos_pk_qui;}
    function setturnos_pk_sex($turnos_pk_sex){ $this->turnos_pk_sex = $turnos_pk_sex;}
    function setturnos_pk_sab($turnos_pk_sab){ $this->turnos_pk_sab = $turnos_pk_sab;}
    function setusuarios_pk($usuarios_pk){ $this->usuarios_pk = $usuarios_pk;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setic_registrar_ponto($ic_registrar_ponto){ $this->ic_registrar_ponto = $ic_registrar_ponto;}

    
}

?>
