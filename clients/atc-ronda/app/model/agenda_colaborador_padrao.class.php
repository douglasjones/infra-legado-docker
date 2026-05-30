<?
class agenda_colaborador_padrao{
    private $pk;
    private $dt_cadastro;
    private $usuario_cadastro_pk;
    private $dt_ult_atualizacao;
    private $usuario_ult_atualizacao_pk;    
    private $ds_agenda;
    private $dt_inicio_agenda;
    private $dt_fim_agenda;
    private $colaboradores_pk;
    private $processos_etapas_pk;
    private $ic_dom;
    private $ic_seg;
    private $ic_ter;
    private $ic_qua;
    private $ic_qui;
    private $ic_sex;
    private $ic_sab;    
    private $ic_dom_folga;
    private $ic_seg_folga;
    private $ic_ter_folga;
    private $ic_qua_folga;
    private $ic_qui_folga;
    private $ic_sex_folga;
    private $ic_sab_folga;
    private $ic_folga_inverter;  
    private $dom_turnos_pk;
    private $seg_turnos_pk;
    private $ter_turnos_pk;
    private $qua_turnos_pk;
    private $qui_turnos_pk;
    private $sex_turnos_pk;
    private $sab_turnos_pk;
    private $contratos_itens_pk;
    private $hr_turno_dom;
    private $hr_turno_seg;
    private $hr_turno_ter;
    private $hr_turno_qua;
    private $hr_turno_qui;
    private $hr_turno_sex;
    private $hr_turno_sab;
    private $hr_turno_dom_saida;
    private $hr_turno_seg_saida;
    private $hr_turno_ter_saida;
    private $hr_turno_qua_saida;
    private $hr_turno_qui_saida;
    private $hr_turno_sex_saida;
    private $hr_turno_sab_saida;
    private $nao_repetir_proxima_semana_pk;
    private $ic_nao_repetir;
    private $dt_cancelamento;
    private $ds_motivo_cancelamento;
    private $tipo_escala;
    private $hr_intervalo_dom;
    private $hr_intervalo_seg;
    private $hr_intervalo_ter;
    private $hr_intervalo_qua;
    private $hr_intervalo_qui;
    private $hr_intervalo_sex;
    private $hr_intervalo_sab;
    private $hr_intervalo_saida_dom;
    private $hr_intervalo_saida_seg;
    private $hr_intervalo_saida_ter;
    private $hr_intervalo_saida_qua;
    private $hr_intervalo_saida_qui;
    private $hr_intervalo_saida_sex;
    private $hr_intervalo_saida_sab;
    private $produtos_servicos_pk;
    private $n_qtde_dias_semana;
    private $turnos_pk;
    private $hr_inicio_expediente;
    private $hr_termino_expediente;
    private $hr_saida_intervalo;
    private $hr_retorno_intervalo;
    private $ic_preenchimento_automatico;
    private $leads_pk;
    private $processos_pk;
    private $contratos_pk;    
    private $ic_intrajornada;    
    
    function __construct(){
        $this->pk = null;
        $this->dt_cadastro = null;
        $this->usuario_cadastro_pk = null;
        $this->dt_ult_atualizacao = null;
        $this->usuario_ult_atualizacao_pk = null;        
        $this->ds_agenda = null;
        $this->dt_inicio_agenda = null;
        $this->dt_fim_agenda = null;
        $this->colaboradores_pk = null;
        $this->processos_etapas_pk = null;
        $this->ic_dom = null;
        $this->ic_seg = null;
        $this->ic_ter = null;
        $this->ic_qua = null;
        $this->ic_qui = null;
        $this->ic_sex = null;
        $this->ic_sab = null;
        $this->ic_dom_folga = null;
        $this->ic_seg_folga = null;
        $this->ic_ter_folga = null;
        $this->ic_qua_folga = null;
        $this->ic_qui_folga = null;
        $this->ic_sex_folga = null;
        $this->ic_sab_folga = null;  
        $this->ic_folga_inverter = null;  
        $this->dom_turnos_pk = null;
        $this->seg_turnos_pk = null;
        $this->ter_turnos_pk = null;
        $this->qua_turnos_pk = null;
        $this->qui_turnos_pk = null;
        $this->sex_turnos_pk = null;
        $this->sab_turnos_pk = null;
        $this->contratos_itens_pk = null;
        $this->hr_turno_dom = null;
        $this->hr_turno_seg = null;
        $this->hr_turno_ter = null;
        $this->hr_turno_qua = null;
        $this->hr_turno_qui = null;
        $this->hr_turno_sex = null;
        $this->hr_turno_sab = null;
        $this->hr_turno_dom_saida = null;
        $this->hr_turno_seg_saida = null;
        $this->hr_turno_ter_saida = null;
        $this->hr_turno_qua_saida = null;
        $this->hr_turno_qui_saida = null;
        $this->hr_turno_sex_saida = null;
        $this->hr_turno_sab_saida = null;
        $this->nao_repetir_proxima_semana_pk = null;
        $this->ic_nao_repetir = null;
        $this->dt_cancelamento = null;
        $this->ds_motivo_cancelamento = null;
        $this->tipo_escala = null;
        $this->hr_intervalo_dom = null;
        $this->hr_intervalo_seg = null;
        $this->hr_intervalo_ter = null;
        $this->hr_intervalo_qua = null;
        $this->hr_intervalo_qui = null;
        $this->hr_intervalo_sex = null;
        $this->hr_intervalo_sab = null;
        $this->hr_intervalo_saida_dom = null;
        $this->hr_intervalo_saida_seg = null;
        $this->hr_intervalo_saida_ter = null;
        $this->hr_intervalo_saida_qua = null;
        $this->hr_intervalo_saida_qui = null;
        $this->hr_intervalo_saida_sex = null;
        $this->hr_intervalo_saida_sab = null;        
        $this->produtos_servicos_pk= null;
        $this->n_qtde_dias_semana= null;
        $this->turnos_pk= null;
        $this->hr_inicio_expediente= null;
        $this->hr_termino_expediente= null;
        $this->hr_saida_intervalo= null;
        $this->hr_retorno_intervalo= null;
        $this->ic_preenchimento_automatico= null;
        $this->leads_pk= null;
        $this->processos_pk= null;
        $this->contratos_pk= null;        
        $this->ic_intrajornada= null;        
    }    
    
    public function getpk(){return $this->pk;}
    public function getdt_cadastro(){return $this->dt_cadastro;}
    public function getusuario_cadastro_pk(){return $this->usuario_cadastro_pk;}
    public function getdt_ult_atualizacao(){return $this->dt_ult_atualizacao;}    
    function getds_agenda(){return $this->ds_agenda;}
    function getdt_inicio_agenda(){return $this->dt_inicio_agenda;}
    function getdt_fim_agenda(){return $this->dt_fim_agenda;}
    function getcolaboradores_pk(){return $this->colaboradores_pk;}
    function getprocessos_etapas_pk(){return $this->processos_etapas_pk;}
    function getic_dom(){return $this->ic_dom;}
    function getic_seg(){return $this->ic_seg;}
    function getic_ter(){return $this->ic_ter;}
    function getic_qua(){return $this->ic_qua;}
    function getic_qui(){return $this->ic_qui;}
    function getic_sex(){return $this->ic_sex;}
    function getic_sab(){return $this->ic_sab;}    
    function getic_dom_folga(){return $this->ic_dom_folga;}
    function getic_seg_folga(){return $this->ic_seg_folga;}
    function getic_ter_folga(){return $this->ic_ter_folga;}
    function getic_qua_folga(){return $this->ic_qua_folga;}
    function getic_qui_folga(){return $this->ic_qui_folga;}
    function getic_sex_folga(){return $this->ic_sex_folga;}
    function getic_sab_folga(){return $this->ic_sab_folga;}
    function getic_folga_inverter(){return $this->ic_folga_inverter;}      
    function getdom_turnos_pk(){return $this->dom_turnos_pk;}
    function getseg_turnos_pk(){return $this->seg_turnos_pk;}
    function getter_turnos_pk(){return $this->ter_turnos_pk;}
    function getqua_turnos_pk(){return $this->qua_turnos_pk;}
    function getqui_turnos_pk(){return $this->qui_turnos_pk;}
    function getsex_turnos_pk(){return $this->sex_turnos_pk;}
    function getsab_turnos_pk(){return $this->sab_turnos_pk;}
    function getcontratos_itens_pk(){return $this->contratos_itens_pk;}
    function gethr_turno_dom(){return $this->hr_turno_dom;}
    function gethr_turno_seg(){return $this->hr_turno_seg;}
    function gethr_turno_ter(){return $this->hr_turno_ter;}
    function gethr_turno_qua(){return $this->hr_turno_qua;}
    function gethr_turno_qui(){return $this->hr_turno_qui;}
    function gethr_turno_sex(){return $this->hr_turno_sex;}
    function gethr_turno_sab(){return $this->hr_turno_sab;}
    function gethr_turno_dom_saida(){return $this->hr_turno_dom_saida;}
    function gethr_turno_seg_saida(){return $this->hr_turno_seg_saida;}
    function gethr_turno_ter_saida(){return $this->hr_turno_ter_saida;}
    function gethr_turno_qua_saida(){return $this->hr_turno_qua_saida;}
    function gethr_turno_qui_saida(){return $this->hr_turno_qui_saida;}
    function gethr_turno_sex_saida(){return $this->hr_turno_sex_saida;}
    function gethr_turno_sab_saida(){return $this->hr_turno_sab_saida;}
    function getnao_repetir_proxima_semana_pk(){return $this->nao_repetir_proxima_semana_pk;}
    function getic_nao_repetir(){return $this->ic_nao_repetir;}
    function getdt_cancelamento(){return $this->dt_cancelamento;}
    function getds_motivo_cancelamento(){return $this->ds_motivo_cancelamento;}
    function gettipo_escala(){return $this->tipo_escala;}
    function gethr_intervalo_dom(){return $this->hr_intervalo_dom;}
    function gethr_intervalo_seg(){return $this->hr_intervalo_seg;}
    function gethr_intervalo_ter(){return $this->hr_intervalo_ter;}
    function gethr_intervalo_qua(){return $this->hr_intervalo_qua;}
    function gethr_intervalo_qui(){return $this->hr_intervalo_qui;}
    function gethr_intervalo_sex(){return $this->hr_intervalo_sex;}
    function gethr_intervalo_sab(){return $this->hr_intervalo_sab;}
    function gethr_intervalo_saida_seg(){return $this->hr_intervalo_saida_seg;}
    function gethr_intervalo_saida_ter(){return $this->hr_intervalo_saida_ter;}
    function gethr_intervalo_saida_qua(){return $this->hr_intervalo_saida_qua;}
    function gethr_intervalo_saida_qui(){return $this->hr_intervalo_saida_qui;}
    function gethr_intervalo_saida_sex(){return $this->hr_intervalo_saida_sex;}
    function gethr_intervalo_saida_sab(){return $this->hr_intervalo_saida_sab;}
    function gethr_intervalo_saida_dom(){return $this->hr_intervalo_saida_dom;}
    function getprodutos_servicos_pk(){return $this->produtos_servicos_pk;}
    function getn_qtde_dias_semana(){return $this->n_qtde_dias_semana;}
    function getturnos_pk(){return $this->turnos_pk;}
    function gethr_inicio_expediente(){return $this->hr_inicio_expediente;}
    function gethr_termino_expediente(){return $this->hr_termino_expediente;}
    function gethr_saida_intervalo(){return $this->hr_saida_intervalo;}
    function gethr_retorno_intervalo(){return $this->hr_retorno_intervalo;}
    function getic_preenchimento_automatico(){return $this->ic_preenchimento_automatico;}
    function getleads_pk(){return $this->leads_pk;}
    function getprocessos_pk(){return $this->processos_pk;}
    function getcontratos_pk(){return $this->contratos_pk;}      
    function getic_intrajornada(){return $this->ic_intrajornada;}      
    
    public function setpk($v_pk){$this->pk = $v_pk;}
    public function setdt_cadastro($v_dt_cadastro){$this->dt_cadastro = $v_dt_cadastro;}
    public function setusuario_cadastro_pk($v_usuario_cadastro_pk){$this->usuario_cadastro_pk = $v_usuario_cadastro_pk;}
    public function setdt_ult_atualizacao($v_dt_ult_atualizacao){$this->dt_ult_atualizacao = $v_dt_ult_atualizacao;}
    public function setusuario_ult_atualizacao_pk($v_usuario_ult_atualizacao_pk){$this->usuario_ult_atualizacao_pk = $v_usuario_ult_atualizacao_pk;}
    
    function setds_agenda($ds_agenda){ $this->ds_agenda = $ds_agenda;}
    function setdt_inicio_agenda($dt_inicio_agenda){ $this->dt_inicio_agenda = $dt_inicio_agenda;}
    function setdt_fim_agenda($dt_fim_agenda){ $this->dt_fim_agenda = $dt_fim_agenda;}
    function setcolaboradores_pk($colaboradores_pk){ $this->colaboradores_pk = $colaboradores_pk;}
    function setprocessos_etapas_pk($processos_etapas_pk){ $this->processos_etapas_pk = $processos_etapas_pk;}
    function setic_dom($ic_dom){ $this->ic_dom = $ic_dom;}
    function setic_seg($ic_seg){ $this->ic_seg = $ic_seg;}
    function setic_ter($ic_ter){ $this->ic_ter = $ic_ter;}
    function setic_qua($ic_qua){ $this->ic_qua = $ic_qua;}
    function setic_qui($ic_qui){ $this->ic_qui = $ic_qui;}
    function setic_sex($ic_sex){ $this->ic_sex = $ic_sex;}
    function setic_sab($ic_sab){ $this->ic_sab = $ic_sab;}    
    function setic_dom_folga($ic_dom_folga){ $this->ic_dom_folga = $ic_dom_folga;}
    function setic_seg_folga($ic_seg_folga){ $this->ic_seg_folga = $ic_seg_folga;}
    function setic_ter_folga($ic_ter_folga){ $this->ic_ter_folga = $ic_ter_folga;}
    function setic_qua_folga($ic_qua_folga){ $this->ic_qua_folga = $ic_qua_folga;}
    function setic_qui_folga($ic_qui_folga){ $this->ic_qui_folga = $ic_qui_folga;}
    function setic_sex_folga($ic_sex_folga){ $this->ic_sex_folga = $ic_sex_folga;}
    function setic_sab_folga($ic_sab_folga){ $this->ic_sab_folga = $ic_sab_folga;}
    function setic_folga_inverter($ic_folga_inverter){ $this->ic_folga_inverter = $ic_folga_inverter;}       
    function setdom_turnos_pk($dom_turnos_pk){ $this->dom_turnos_pk = $dom_turnos_pk;}
    function setseg_turnos_pk($seg_turnos_pk){ $this->seg_turnos_pk = $seg_turnos_pk;}
    function setter_turnos_pk($ter_turnos_pk){ $this->ter_turnos_pk = $ter_turnos_pk;}
    function setqua_turnos_pk($qua_turnos_pk){ $this->qua_turnos_pk = $qua_turnos_pk;}
    function setqui_turnos_pk($qui_turnos_pk){ $this->qui_turnos_pk = $qui_turnos_pk;}
    function setsex_turnos_pk($sex_turnos_pk){ $this->sex_turnos_pk = $sex_turnos_pk;}
    function setsab_turnos_pk($sab_turnos_pk){ $this->sab_turnos_pk = $sab_turnos_pk;}
    function sethr_turno_dom($hr_turno_dom){ $this->hr_turno_dom = $hr_turno_dom;}
    function sethr_turno_seg($hr_turno_seg){ $this->hr_turno_seg = $hr_turno_seg;}
    function sethr_turno_ter($hr_turno_ter){ $this->hr_turno_ter = $hr_turno_ter;}
    function sethr_turno_qua($hr_turno_qua){ $this->hr_turno_qua = $hr_turno_qua;}
    function sethr_turno_qui($hr_turno_qui){ $this->hr_turno_qui = $hr_turno_qui;}
    function sethr_turno_sex($hr_turno_sex){ $this->hr_turno_sex = $hr_turno_sex;}
    function sethr_turno_sab($hr_turno_sab){ $this->hr_turno_sab = $hr_turno_sab;}
    function sethr_turno_dom_saida($hr_turno_dom_saida){ $this->hr_turno_dom_saida = $hr_turno_dom_saida;}
    function sethr_turno_seg_saida($hr_turno_seg_saida){ $this->hr_turno_seg_saida = $hr_turno_seg_saida;}
    function sethr_turno_ter_saida($hr_turno_ter_saida){ $this->hr_turno_ter_saida = $hr_turno_ter_saida;}
    function sethr_turno_qua_saida($hr_turno_qua_saida){ $this->hr_turno_qua_saida = $hr_turno_qua_saida;}
    function sethr_turno_qui_saida($hr_turno_qui_saida){ $this->hr_turno_qui_saida = $hr_turno_qui_saida;}
    function sethr_turno_sex_saida($hr_turno_sex_saida){ $this->hr_turno_sex_saida = $hr_turno_sex_saida;}
    function sethr_turno_sab_saida($hr_turno_sab_saida){ $this->hr_turno_sab_saida = $hr_turno_sab_saida;}
    function setcontratos_itens_pk($contratos_itens_pk){ $this->contratos_itens_pk = $contratos_itens_pk;}
    function setnao_repetir_proxima_semana_pk($nao_repetir_proxima_semana_pk){ $this->nao_repetir_proxima_semana_pk = $nao_repetir_proxima_semana_pk;}
    function setic_nao_repetir($ic_nao_repetir){ $this->ic_nao_repetir = $ic_nao_repetir;}
    function setdt_cancelamento($dt_cancelamento){ $this->dt_cancelamento = $dt_cancelamento;}
    function setds_motivo_cancelamento($ds_motivo_cancelamento){ $this->ds_motivo_cancelamento = $ds_motivo_cancelamento;}
    function settipo_escala($tipo_escala){ $this->tipo_escala = $tipo_escala;}
    function sethr_intervalo_dom($hr_intervalo_dom){ $this->hr_intervalo_dom = $hr_intervalo_dom;}
    function sethr_intervalo_seg($hr_intervalo_seg){ $this->hr_intervalo_seg = $hr_intervalo_seg;}
    function sethr_intervalo_ter($hr_intervalo_ter){ $this->hr_intervalo_ter = $hr_intervalo_ter;}
    function sethr_intervalo_qua($hr_intervalo_qua){ $this->hr_intervalo_qua = $hr_intervalo_qua;}
    function sethr_intervalo_qui($hr_intervalo_qui){ $this->hr_intervalo_qui = $hr_intervalo_qui;}
    function sethr_intervalo_sex($hr_intervalo_sex){ $this->hr_intervalo_sex = $hr_intervalo_sex;}
    function sethr_intervalo_sab($hr_intervalo_sab){ $this->hr_intervalo_sab = $hr_intervalo_sab;}
    function sethr_intervalo_saida_dom($hr_intervalo_saida_dom){ $this->hr_intervalo_saida_dom= $hr_intervalo_saida_dom;}
    function sethr_intervalo_saida_seg($hr_intervalo_saida_seg){ $this->hr_intervalo_saida_seg = $hr_intervalo_saida_seg;}
    function sethr_intervalo_saida_ter($hr_intervalo_saida_ter){ $this->hr_intervalo_saida_ter = $hr_intervalo_saida_ter;}
    function sethr_intervalo_saida_qua($hr_intervalo_saida_qua){ $this->hr_intervalo_saida_qua = $hr_intervalo_saida_qua;}
    function sethr_intervalo_saida_qui($hr_intervalo_saida_qui){ $this->hr_intervalo_saida_qui = $hr_intervalo_saida_qui;}
    function sethr_intervalo_saida_sex($hr_intervalo_saida_sex){ $this->hr_intervalo_saida_sex = $hr_intervalo_saida_sex;}
    function sethr_intervalo_saida_sab($hr_intervalo_saida_sab){ $this->hr_intervalo_saida_sab = $hr_intervalo_saida_sab;}
    function setprodutos_servicos_pk($produtos_servicos_pk){ $this->produtos_servicos_pk = $produtos_servicos_pk;}
    function setn_qtde_dias_semana($n_qtde_dias_semana){ $this->n_qtde_dias_semana = $n_qtde_dias_semana;}
    function setturnos_pk($turnos_pk){ $this->turnos_pk = $turnos_pk;}
    function sethr_inicio_expediente($hr_inicio_expediente){ $this->hr_inicio_expediente = $hr_inicio_expediente;}
    function sethr_termino_expediente($hr_termino_expediente){ $this->hr_termino_expediente = $hr_termino_expediente;}
    function sethr_saida_intervalo($hr_saida_intervalo){ $this->hr_saida_intervalo = $hr_saida_intervalo;}
    function sethr_retorno_intervalo($hr_retorno_intervalo){ $this->hr_retorno_intervalo = $hr_retorno_intervalo;}
    function setic_preenchimento_automatico($ic_preenchimento_automatico){ $this->ic_preenchimento_automatico = $ic_preenchimento_automatico;}
    function setleads_pk($leads_pk){ $this->leads_pk = $leads_pk;}
    function setprocessos_pk($processos_pk){ $this->processos_pk = $processos_pk;}
    function setcontratos_pk($contratos_pk){ $this->contratos_pk = $contratos_pk;}
    function setic_intrajornada($ic_intrajornada){ $this->ic_intrajornada = $ic_intrajornada;}
}
?>
