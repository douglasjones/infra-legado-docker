<?

class agenda_colaborador_apontamento{

    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
    
    private $agenda_colaborador_apontamento_pk;
    private $leads_pk;
    private $tipo_apontamento_pk;
    private $colaborador_pk;
    private $agenda_colaborador_padrao_pk;
    private $dt_apontamento;
   
   
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
        
        $this->agenda_colaborador_apontamento_pk = null;
        $this->leads_pk = null;
        $this->tipo_apontamento_pk = null;
        $this->colaborador_pk = null;
        $this->agenda_colaborador_padrao_pk = null;
        $this->dt_apontamento = null; 

    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
    
    function getagenda_colaborador_apontamento_pk(){return $this->agenda_colaborador_apontamento_pk;}
    function getleads_pk(){return $this->leads_pk;}
    function gettipo_apontamento_pk(){return $this->tipo_apontamento_pk;}
    function getcolaborador_pk(){return $this->colaborador_pk;}
    function getagenda_colaborador_padrao_pk(){return $this->agenda_colaborador_padrao_pk;}
    function getdt_apontamento(){return $this->dt_apontamento;}
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setagenda_colaborador_apontamento_pk($agenda_colaborador_apontamento_pk){ $this->agenda_colaborador_apontamento_pk = $agenda_colaborador_apontamento_pk;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function settipo_apontamento_pk($tipo_apontamento_pk){ $this->tipo_apontamento_pk = $tipo_apontamento_pk;}
    function setcolaborador_pk($colaborador_pk){ $this->colaborador_pk = $colaborador_pk;}
    function setagenda_colaborador_padrao_pk($agenda_colaborador_padrao_pk){ $this->agenda_colaborador_padrao_pk = $agenda_colaborador_padrao_pk;}
    function setdt_apontamento($dt_apontamento){ $this->dt_apontamento = $dt_apontamento;}
    
}

class apontamento_ponto extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $tipo_ponto_pk;
    private $hr_ponto;
    private $ds_obs_ponto;
    private $dt_ponto;
    private $ds_pin;
	
	function __construct(){
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->tipo_ponto_pk = null;
		$this->hr_ponto = null;
		$this->ds_obs_ponto = null;
		$this->dt_ponto = null;
		$this->ds_pin = null;

	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function gettipo_ponto_pk(){return $this->tipo_ponto_pk;}
    function gethr_ponto(){return $this->hr_ponto;}
    function getds_obs_ponto(){return $this->ds_obs_ponto;}
    function getdt_ponto(){return $this->dt_ponto;}
    function getds_pin(){return $this->ds_pin;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
	
	function settipo_ponto_pk($tipo_ponto_pk){ $this->tipo_ponto_pk = $tipo_ponto_pk;}
    function sethr_ponto($hr_ponto){ $this->hr_ponto = $hr_ponto;}
    function setds_obs_ponto($ds_obs_ponto){ $this->ds_obs_ponto = $ds_obs_ponto;}
    function setdt_ponto($dt_ponto){ $this->dt_ponto = $dt_ponto;}
    function setds_pin($ds_pin){ $this->ds_pin = $ds_pin;}
}

class apontamento_afastamento extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $motivo_afastamento_pk;
    private $dt_ini_afastamento;
    private $dt_fim_afastamento;
    private $colaborador_cobertura_afastamento_pk;
    private $ds_obs_afastamento;
	
	function __construct(){
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->motivo_afastamento_pk = null;
		$this->dt_ini_afastamento = null;
		$this->dt_fim_afastamento = null;
		$this->colaborador_cobertura_afastamento_pk = null;
		$this->ds_obs_afastamento = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function getmotivo_afastamento_pk(){return $this->motivo_afastamento_pk;}
    function getdt_ini_afastamento(){return $this->dt_ini_afastamento;}
    function getdt_fim_afastamento(){return $this->dt_fim_afastamento;}
    function getcolaborador_cobertura_afastamento_pk(){return $this->colaborador_cobertura_afastamento_pk;}
    function getds_obs_afastamento(){return $this->ds_obs_afastamento;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
	function setmotivo_afastamento_pk($motivo_afastamento_pk){ $this->motivo_afastamento_pk = $motivo_afastamento_pk;}
    function setdt_ini_afastamento($dt_ini_afastamento){ $this->dt_ini_afastamento = $dt_ini_afastamento;}
    function setdt_fim_afastamento($dt_fim_afastamento){ $this->dt_fim_afastamento = $dt_fim_afastamento;}
    function setcolaborador_cobertura_afastamento_pk($colaborador_cobertura_afastamento_pk){ $this->colaborador_cobertura_afastamento_pk = $colaborador_cobertura_afastamento_pk;}
    function setds_obs_afastamento($ds_obs_afastamento){ $this->ds_obs_afastamento = $ds_obs_afastamento;}
	
	
}

class apontamento_ferias extends agenda_colaborador_apontamento{
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $dt_ini_ferias;
    private $dt_fim_ferias;
    private $colaborador_cobertura_ferias_pk;
    private $ds_obs_ferias;
	
	function __construct(){
		
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->dt_ini_ferias = null;
		$this->dt_fim_ferias = null;
		$this->colaborador_cobertura_ferias_pk = null;
		$this->ds_obs_ferias = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function getdt_ini_ferias(){return $this->dt_ini_ferias;}
    function getdt_fim_ferias(){return $this->dt_fim_ferias;}
    function getcolaborador_cobertura_ferias_pk(){return $this->colaborador_cobertura_ferias_pk;}
    function getds_obs_ferias(){return $this->ds_obs_ferias;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
	function setdt_ini_ferias($dt_ini_ferias){ $this->dt_ini_ferias = $dt_ini_ferias;}
    function setdt_fim_ferias($dt_fim_ferias){ $this->dt_fim_ferias = $dt_fim_ferias;}
    function setcolaborador_cobertura_ferias_pk($colaborador_cobertura_ferias_pk){ $this->colaborador_cobertura_ferias_pk = $colaborador_cobertura_ferias_pk;}
    function setds_obs_ferias($ds_obs_ferias){ $this->ds_obs_ferias = $ds_obs_ferias;}
}

class apontamento_folga extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $motivo_folga_pk;
    private $motivo_ft_pk;
    private $ds_obs_folga;
    private $dt_folga;
    private $apontamento_falta_pk;
    private $lead_cobertura_pk;
    private $vl_ft;
	private $ds_obs_falta; 
    private $colaborador_cobertura_falta_pk;
    private $motivo_falta_pk;
    private $dt_falta;
	
	function __construct(){
		
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->motivo_folga_pk = null;
		$this->motivo_ft_pk = null;
		$this->ds_obs_folga = null;
		$this->dt_folga = null;
		$this->apontamento_falta_pk = null;
		$this->lead_cobertura_pk = null;
        $this->vl_ft = null; 
		$this->ds_obs_falta = null;
		$this->colaborador_cobertura_falta_pk = null;
		$this->motivo_falta_pk = null;
		$this->dt_falta = null;
		$this->lead_pk = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function getmotivo_folga_pk(){return $this->motivo_folga_pk;}
    function getmotivo_ft_pk(){return $this->motivo_ft_pk;}
    function getds_obs_folga(){return $this->ds_obs_folga;}
    function getdt_folga(){return $this->dt_folga;}
    function getapontamento_falta_pk(){return $this->apontamento_falta_pk;} 
    function getlead_cobertura_pk(){return $this->lead_cobertura_pk;} 
    function getvl_ft(){return $this->vl_ft;}
    function getds_obs_falta(){return $this->ds_obs_falta;}
    function getcolaborador_cobertura_falta_pk(){ return $this->colaborador_cobertura_falta_pk;}
    function getmotivo_falta_pk(){return $this->motivo_falta_pk; }
    function getdt_falta(){ return $this->dt_falta; }
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
	

	function setmotivo_folga_pk($motivo_folga_pk){ $this->motivo_folga_pk = $motivo_folga_pk;}
    function setmotivo_ft_pk($motivo_ft_pk){ $this->motivo_ft_pk = $motivo_ft_pk;}
    function setds_obs_folga($ds_obs_folga){ $this->ds_obs_folga = $ds_obs_folga;}
    function setdt_folga($dt_folga){ $this->dt_folga = $dt_folga;}
    function setapontamento_falta_pk($apontamento_falta_pk){ $this->apontamento_falta_pk = $apontamento_falta_pk;}
    function setlead_cobertura_pk($lead_cobertura_pk){ $this->lead_cobertura_pk = $lead_cobertura_pk;}
    function setvl_ft($vl_ft){ $this->vl_ft = $vl_ft;}

	function setds_obs_falta($ds_obs_falta){ $this->ds_obs_falta = $ds_obs_falta;}
    function setcolaborador_cobertura_falta_pk($colaborador_cobertura_falta_pk){ $this->colaborador_cobertura_falta_pk = $colaborador_cobertura_falta_pk;}
    function setmotivo_falta_pk($motivo_falta_pk){ $this->motivo_falta_pk = $motivo_falta_pk;}
    function setdt_falta($dt_falta){ $this->dt_falta = $dt_falta;}
	
}

class apontamento_troca_escala extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $ds_obs_troca_escala;
    private $dt_troca_escala;
    private $motivos_troca_escala_pk;
    private $colaborador_cobertura_troca_escala_pk;
	
	function __construct(){
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->ds_obs_troca_escala = null;
		$this->dt_troca_escala = null;
		$this->motivos_troca_escala_pk = null;
		$this->colaborador_cobertura_troca_escala_pk = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function getds_obs_troca_escala(){return $this->ds_obs_troca_escala;}
    function getdt_troca_escala(){return $this->dt_troca_escala;}
    function getmotivos_troca_escala_pk(){return $this->motivos_troca_escala_pk;}
    function getcolaborador_cobertura_troca_escala_pk(){return $this->colaborador_cobertura_troca_escala_pk;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
	
	function setds_obs_troca_escala($ds_obs_troca_escala){ $this->ds_obs_troca_escala = $ds_obs_troca_escala;}
    function setdt_troca_escala($dt_troca_escala){ $this->dt_troca_escala = $dt_troca_escala;}
    function setmotivos_troca_escala_pk($motivos_troca_escala_pk){ $this->motivos_troca_escala_pk = $motivos_troca_escala_pk;}
    function setcolaborador_cobertura_troca_escala_pk($colaborador_cobertura_troca_escala_pk){ $this->colaborador_cobertura_troca_escala_pk = $colaborador_cobertura_troca_escala_pk;}

	
}

class apontamento_falta extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $ds_obs_falta;
    private $colaborador_cobertura_falta_pk;
    private $motivo_falta_pk;
    private $dt_falta;
    private $lead_pk;
    private $motivo_cobertura_pk;
    private $lead_cobertura_pk;
    private $vl_ft_falta;
	
	function __construct(){
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->ds_obs_falta = null;
		$this->colaborador_cobertura_falta_pk = null;
		$this->motivo_falta_pk = null;
		$this->dt_falta = null;
		$this->lead_pk = null;
		$this->motivo_cobertura_pk = null;
		$this->lead_cobertura_pk = null;
		$this->vl_ft_falta = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
	function getds_obs_falta(){return $this->ds_obs_falta;}
    function getcolaborador_cobertura_falta_pk(){return $this->colaborador_cobertura_falta_pk;}
    function getmotivo_falta_pk(){return $this->motivo_falta_pk;}
    function getdt_falta(){return $this->dt_falta;}
    function getlead_pk(){return $this->lead_pk;}
    function getmotivo_cobertura_pk(){return $this->motivo_cobertura_pk;}
    function getlead_cobertura_pk(){return $this->lead_cobertura_pk;}
    function getvl_ft_falta(){return $this->vl_ft_falta;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
	function setds_obs_falta($ds_obs_falta){ $this->ds_obs_falta = $ds_obs_falta;}
    function setcolaborador_cobertura_falta_pk($colaborador_cobertura_falta_pk){ $this->colaborador_cobertura_falta_pk = $colaborador_cobertura_falta_pk;}
    function setmotivo_falta_pk($motivo_falta_pk){ $this->motivo_falta_pk = $motivo_falta_pk;}
    function setdt_falta($dt_falta){ $this->dt_falta = $dt_falta;}
    function setlead_pk($lead_pk){ $this->lead_pk = $lead_pk;}
    function setmotivo_cobertura_pk($motivo_cobertura_pk){ $this->motivo_cobertura_pk = $motivo_cobertura_pk;}
    function setlead_cobertura_pk($lead_cobertura_pk){ $this->lead_cobertura_pk = $lead_cobertura_pk;}
    function setvl_ft_falta($vl_ft_falta){ $this->vl_ft_falta = $vl_ft_falta;}
	
}

class apontamento_servico_extra extends agenda_colaborador_apontamento{
	
	private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;
	
	private $dt_ini_exec_servico;
    private $dt_fim_exec_servico;
    private $contrato_pk;
    private $vl_servico;
    private $ds_obs_servico_extra;
	
	function __construct(){
		$this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;
		
		$this->dt_ini_exec_servico = null;
		$this->dt_fim_exec_servico = null;
		$this->contrato_pk = null;
		$this->vl_servico = null;
		$this->ds_obs_servico_extra = null;
	}
	
	public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}
    public function getusuario_ult_atualizacao_pk(){return $this->usuario_ult_atualizacao_pk;}
	
    function getdt_ini_exec_servico(){return $this->dt_ini_exec_servico;}
    function getdt_fim_exec_servico(){return $this->dt_fim_exec_servico;}
    function getcontrato_pk(){return $this->contrato_pk;}
    function getvl_servico(){return $this->vl_servico;}
    function getds_obs_servico_extra(){return $this->ds_obs_servico_extra;}
	
	public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
	
	function setdt_ini_exec_servico($dt_ini_exec_servico){ $this->dt_ini_exec_servico = $dt_ini_exec_servico;}
    function setdt_fim_exec_servico($dt_fim_exec_servico){ $this->dt_fim_exec_servico = $dt_fim_exec_servico;}
    function setcontrato_pk($contrato_pk){ $this->contrato_pk = $contrato_pk;}
    function setvl_servico($vl_servico){ $this->vl_servico = $vl_servico;}
    function setds_obs_servico_extra($ds_obs_servico_extra){ $this->ds_obs_servico_extra = $ds_obs_servico_extra;}


}
?>
