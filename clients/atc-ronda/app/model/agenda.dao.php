<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agenda.class.php';
require_once '../model/usuario.dao.php';
require_once "../model/documento.dao.php";
require_once "../model/agendas_participantes.dao.php";
require_once '../model/email_layout.dao.php';


class agendadao{

    private $db;
    private $arrToken;

    public function __construct(){

        $this->db = new DataBase();
        $this->db->conectar();

    }

    public function __destruct() {
        $this->db->desconectar();
    }


    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }

    public function salvar($agenda, $doc_agenda, $participantes_agenda, $token){
        $documentodao = new documentodao();
        $documentodao->setToken($token); 
        
        $agendas_participantesdao = new agendas_participantesdao();
        $agendas_participantesdao->setToken($token); 
                        
        $email_layoutdao = new email_layoutdao();
        $email_layoutdao->setToken($token); 

        if($agenda->getds_endereco() != 'undefined'){
            $ds_cep = $agenda->getds_cep() ;
            $ds_endereco = $agenda->getds_endereco();
            $ds_complemento = $agenda->getds_complemento();
            $ds_numero = $agenda->getds_numero();
            $ds_bairro = $agenda->getds_bairro();
            $ds_cidade = $agenda->getds_cidade();
            $ds_uf = $agenda->getds_uf();
        }else{
            if($agenda->getleads_pk() != '' && ($agenda->gettipo_agendas_pk() == 1 || $agenda->gettipo_agendas_pk() == 5)){
                $sql ="";
                $sql.="select pk";
                $sql.="       ,ds_cep ";
                $sql.="       ,ds_endereco ";
                $sql.="       ,ds_numero ";
                $sql.="       ,ds_complemento ";
                $sql.="       ,ds_bairro ";
                $sql.="       ,ds_cidade ";
                $sql.="       ,ds_uf ";
                $sql.="  from leads ";
                $sql.="  where pk =".$agenda->getleads_pk();
                $query = $this->db->execQuery($sql);

                $ds_cep = $query[0]['ds_cep'];
                $ds_endereco = $query[0]['ds_endereco'];
                $ds_complemento = $query[0]['ds_complemento'];
                $ds_numero = $query[0]['ds_numero'];
                $ds_bairro = $query[0]['ds_bairro'];
                $ds_cidade = $query[0]['ds_cidade'];
                $ds_uf = $query[0]['ds_uf'];
            }
        }

        $fields = array();
        $fields['tipo_agendas_pk'] = $agenda->gettipo_agendas_pk();
        $fields['dt_ini_agenda_ini'] = $agenda->getdt_ini_agenda_ini();
        $fields['dt_hr_agenda_fim'] = $agenda->getdt_hr_agenda_fim();
        $fields['ic_lembrete'] = $agenda->getic_lembrete();
        $fields['ic_repetir'] = $agenda->getic_repetir();
        $fields['ds_link_reuniao'] = $agenda->getds_link_reuniao();
        $fields['ds_cep'] = $ds_cep;
        $fields['ds_endereco'] = $ds_endereco;
        $fields['ds_complemento'] = $ds_complemento;
        $fields['ds_numero'] = $ds_numero;
        $fields['ds_bairro'] = $ds_bairro;
        $fields['ds_cidade'] = $ds_cidade;
        $fields['ds_uf'] = $ds_uf;
        $fields['leads_pk'] = $agenda->getleads_pk();
        $fields['ic_status'] = $agenda->getic_status();
        $fields['ds_obs'] = $agenda->getds_obs();
        $fields['agendas_reagendamento_pk'] = $agenda->getagendas_reagendamento_pk();
        $fields['ds_obs_reagendamento'] = $agenda->getds_obs_reagendamento();
        $fields['motivo_cancelameto_pk'] = $agenda->getmotivo_cancelameto_pk();
        $fields['classificacao_pk'] = $agenda->getclassificacao_pk();
        $fields['obs_classificacao'] = $agenda->getobs_classificacao();
        
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($agenda->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("agendas", $fields);
        }
        else{
            $this->db->execUpdate("agendas", $fields, " pk = ".$agenda->getpk());
            $pk = $agenda->getpk();
        }
        

        if($doc_agenda != ""){
            $doc_agenda = json_decode ($doc_agenda, true);
        }
        
        if(count($doc_agenda) > 0){
            for($i = 0; $i < count($doc_agenda); $i++){
                if($doc_agenda[$i]['doc_agenda_pk']!="Nenhum registro encontrado"){
                    if($doc_agenda[$i]['doc_agenda_pk']!="Carregando..."){
                        $documento = $documentodao->carregarPorPk($doc_agenda[$i]['doc_agenda_pk']);
                        $documento->setds_documento($doc_agenda[$i]['ds_documento']);

                        $documento->setds_nome_original($doc_agenda[$i]['ds_nome_original']);
                        $documento->setleads_pk($agenda->getleads_pk());
                        $documento->setagendas_pk($pk);

                        $documentodao->salvar($documento);
                    }
                }
            }
        }
        if($participantes_agenda != ""){
            $participantes_agenda = json_decode ($participantes_agenda, true);
        }
        if(count($participantes_agenda) > 0){
            for($i = 0; $i < count($participantes_agenda); $i++){
                if($participantes_agenda[$i]['participantes_agenda_pk']!="Nenhum registro encontrado"){
                    if($participantes_agenda[$i]['participantes_agenda_pk']!="Carregando..."){

                        $agendas_participantes = $agendas_participantesdao->carregarPorPk($participantes_agenda[$i]['participante_agenda_pk']);
                        $agendas_participantes->setds_email($participantes_agenda[$i]['ds_email']);
                        $agendas_participantes->setds_cel($participantes_agenda[$i]['ds_cel']);
                        $agendas_participantes->setagendas_pk($pk);
                        $agendas_participantes->setparticipante_pk($participantes_agenda[$i]['participante_pk']);
                        $agendas_participantes->setic_tipo_participante($participantes_agenda[$i]['ic_tipo_participante']);

                        $participantes_pk = $agendas_participantesdao->salvar($agendas_participantes);
                       /* if($participantes_pk > 0){
                            $email_layoutdao->agendaAvisoParticipantes($participantes_agenda[$i]['ds_email'], "Nova Agenda", $token);
                        }*/
                    }
                }
            }
        }
        return $pk;
    }

    public function excluir($agenda){
        $this->db->execDelete("agendas_participantes"," agendas_pk = ".$agenda->getpk());
        $this->db->execDelete("agendas"," pk = ".$agenda->getpk());
    }

    public function carregarPorPk($pk){

        $agenda = new agenda();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_agendas_pk ";
        $sql.="       ,dt_ini_agenda_ini ";
        $sql.="       ,dt_hr_agenda_fim ";
        $sql.="       ,ic_lembrete ";
        $sql.="       ,ic_repetir ";
        $sql.="       ,ds_link_reuniao ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_obs ";
        $sql.="       ,agendas_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,motivo_cancelameto_pk ";
        $sql.="       ,classificacao_pk ";
        $sql.="       ,obs_classificacao ";


        $sql.="  from agendas ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $agenda->setpk($query[$i]["pk"]);
                $agenda->setdt_cadastro($query[$i]["dt_cadastro"]);
                $agenda->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $agenda->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $agenda->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $agenda->settipo_agendas_pk($query[$i]['tipo_agendas_pk']);
                $agenda->setdt_ini_agenda_ini($query[$i]['dt_ini_agenda_ini']);
                $agenda->setdt_hr_agenda_fim($query[$i]['dt_hr_agenda_fim']);
                $agenda->setic_lembrete($query[$i]['ic_lembrete']);
                $agenda->setic_repetir($query[$i]['ic_repetir']);
                $agenda->setds_link_reuniao($query[$i]['ds_link_reuniao']);
                $agenda->setds_cep($query[$i]['ds_cep']);
                $agenda->setds_endereco($query[$i]['ds_endereco']);
                $agenda->setds_complemento($query[$i]['ds_complemento']);
                $agenda->setds_numero($query[$i]['ds_numero']);
                $agenda->setds_bairro($query[$i]['ds_bairro']);
                $agenda->setds_cidade($query[$i]['ds_cidade']);
                $agenda->setds_uf($query[$i]['ds_uf']);
                $agenda->setleads_pk($query[$i]['leads_pk']);
                $agenda->setic_status($query[$i]['ic_status']);
                $agenda->setds_obs($query[$i]['ds_obs']);
                $agenda->setagendas_reagendamento_pk($query[$i]['agendas_reagendamento_pk']);
                $agenda->setds_obs_reagendamento($query[$i]['ds_obs_reagendamento']);
                $agenda->setmotivo_cancelameto_pk($query[$i]['motivo_cancelameto_pk']);
                $agenda->setclassificacao_pk($query[$i]['classificacao_pk']);
                $agenda->setobs_classificacao($query[$i]['obs_classificacao']);

            }
        }
        return $agenda;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_agendas_pk ";
        $sql.="       ,date_format(dt_ini_agenda_ini, '%d/%m/%Y') dt_agenda_ini";
        $sql.="       ,date_format(dt_hr_agenda_fim, '%d/%m/%Y') dt_agenda_fim";
        $sql.="       ,date_format(dt_ini_agenda_ini, '%H:%i') hr_agenda_ini";
        $sql.="       ,date_format(dt_hr_agenda_fim, '%H:%i') hr_agenda_fim";
        $sql.="       ,ic_lembrete ";
        $sql.="       ,ic_repetir ";
        $sql.="       ,ds_link_reuniao ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_obs ";
        $sql.="       ,agendas_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";
        $sql.="       ,motivo_cancelameto_pk ";
        $sql.="       ,classificacao_pk ";
        $sql.="       ,obs_classificacao ";

        $sql.="  from agendas ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_agendas_pk($leads_pk){

        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,SUBSTRING_INDEX(SUBSTRING_INDEX(ds_usuario, ' ', 1), ' ', -1)  AS ds_usuario ";
        $sql.="       ,a.tipo_agendas_pk ";
        $sql.="       ,a.dt_ini_agenda_ini ";
        $sql.="       ,a.dt_hr_agenda_fim ";
        $sql.="       ,date_format(a.dt_ini_agenda_ini, '%d/%m/%Y') dt_agenda_ini";
        $sql.="       ,date_format(a.dt_hr_agenda_fim, '%d/%m/%Y') dt_agenda_fim";
        $sql.="       ,date_format(a.dt_ini_agenda_ini, '%H:%i') hr_agenda_fim";
        $sql.="       ,date_format(a.dt_hr_agenda_fim, '%H:%i') hr_agenda_ini";
        $sql.="       ,a.ic_lembrete ";
        $sql.="       ,a.ic_repetir ";
        $sql.="       ,a.ds_link_reuniao ";
        $sql.="       ,a.ds_cep ";
        $sql.="       ,a.ds_endereco ";
        $sql.="       ,a.ds_complemento ";
        $sql.="       ,a.ds_numero ";
        $sql.="       ,a.ds_bairro ";
        $sql.="       ,a.ds_cidade ";
        $sql.="       ,a.ds_uf ";
        $sql.="       ,a.leads_pk ";
        $sql.="       ,SUBSTRING_INDEX(SUBSTRING_INDEX(l.ds_lead, ' ', 1), ' ', -1)  AS ds_lead";
        $sql.="       ,a.ic_status ";
        $sql.="       ,a.ds_obs ";
        $sql.="       ,a.agendas_reagendamento_pk ";
        $sql.="       ,a.ds_obs_reagendamento ";
        $sql.="       ,a.motivo_cancelameto_pk ";
        $sql.="       ,a.classificacao_pk ";
        $sql.="       ,a.obs_classificacao ";
        $sql.="       ,case when a.tipo_agendas_pk = 1 then '#68C39F' ";
        $sql.="             when a.tipo_agendas_pk = 2 then '#6F42C1' ";
        $sql.="             when a.tipo_agendas_pk = 3 then '#ffff00' ";
        $sql.="             when a.tipo_agendas_pk = 4 then '#ff9933' ";
        $sql.="             when a.tipo_agendas_pk = 5 then '#ff5050' ";
        $sql.="             when a.tipo_agendas_pk = 6 then '#3399ff' ";
        $sql.="        end color ";
        $sql.="       ,case when a.tipo_agendas_pk = 1 then '#fff' ";
        $sql.="             when a.tipo_agendas_pk = 2 then '#fff' ";
        $sql.="             when a.tipo_agendas_pk = 3 then '#000' ";
        $sql.="             when a.tipo_agendas_pk = 4 then '#fff' ";
        $sql.="             when a.tipo_agendas_pk = 5 then '#fff' ";
        $sql.="             when a.tipo_agendas_pk = 6 then '#fff' ";
        $sql.="        end textColor ";
        $sql.="       ,case when a.classificacao_pk = 1 then 'bi bi-check-all' ";
        $sql.="             when a.ic_status = 2 then 'bi bi-check-lg' ";
        $sql.="             when a.ic_status = 3 then 'bi bi-x' ";
        $sql.="        else '' end icon ";

        $sql.="  from agendas a";
        $sql.="  left join usuarios u on u.pk = a.usuario_cadastro_pk";
        $sql.="  left JOIN leads l ON l.pk = a.leads_pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and a.leads_pk = ".$leads_pk." ";
        }
        $sql.=" order by a.tipo_agendas_pk asc ";
        $query = $this->db->execQuery($sql);

        if(count($query)>0){
            for($i = 0; $i < count($query); $i++){
                $sqlParticipantes ="";
                $sqlParticipantes .="SELECT participante_pk ";
                $sqlParticipantes .="  FROM agendas_participantes ap";
                $sqlParticipantes .="       LEFT JOIN usuarios u on u.pk = ap.participante_pk ";
                $sqlParticipantes .="       LEFT JOIN contatos c on c.pk = ap.participante_pk ";
                $sqlParticipantes .=" WHERE ap.agendas_pk = ".$query[$i]['pk'];
                $sqlParticipantes .="   AND (u.pk = ".$this->arrToken['usuarios_pk']." || c.pk = ".$this->arrToken['usuarios_pk'].")";
                $queryParticipantes = $this->db->execQuery($sqlParticipantes);
                if(count($queryParticipantes)>0 || $query[$i]["usuario_cadastro_pk"]==$this->arrToken['usuarios_pk']){
                    $result[] = array(
                        "icon" => $query[$i]["icon"],
                        "title" => $query[$i]["hr_agenda_ini"]."-".$query[$i]["ds_usuario"]." ".$query[$i]["ds_lead"],
                        "start" => $query[$i]['dt_ini_agenda_ini'],
                        "end"=> $query[$i]['dt_hr_agenda_fim'],
                        "color"=> $query[$i]['color'],
                        "textColor"=> $query[$i]['textColor'],
                        "id" => $query[$i]["pk"]
                    );
                }
            }
        }
        return $result;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_agendas_pk ";
        $sql.="       ,dt_ini_agenda_ini ";
        $sql.="       ,dt_hr_agenda_fim ";
        $sql.="       ,ic_lembrete ";
        $sql.="       ,ic_repetir ";
        $sql.="       ,ds_link_reuniao ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,ds_obs ";
        $sql.="       ,agendas_reagendamento_pk ";
        $sql.="       ,ds_obs_reagendamento ";

        $sql.="  from agendas ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_agendas_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodosPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select a.pk, a.dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,a.tipo_agendas_pk ";
        $sql.="       ,date_format(a.dt_ini_agenda_ini, '%d/%m/%Y %H:%i') dt_ini_agenda_ini";
        $sql.="       ,date_format(a.dt_cadastro, '%d/%m/%Y') dt_cadastro";
        $sql.="       ,a.dt_hr_agenda_fim ";
        $sql.="       ,a.ic_lembrete ";
        $sql.="       ,a.ic_repetir ";
        $sql.="       ,a.ds_link_reuniao ";
        $sql.="       ,a.ds_cep ";
        $sql.="       ,a.ds_endereco ";
        $sql.="       ,a.ds_complemento ";
        $sql.="       ,a.ds_numero ";
        $sql.="       ,a.ds_bairro ";
        $sql.="       ,a.ds_cidade ";
        $sql.="       ,a.ds_uf ";
        $sql.="       ,a.leads_pk ";
        $sql.="       ,a.ic_status ";
        $sql.="       ,a.ds_obs ";
        $sql.="       ,a.agendas_reagendamento_pk ";
        $sql.="       ,a.ds_obs_reagendamento ";
        $sql.="       ,case when a.tipo_agendas_pk = 1 then 'REUNIÃO PRESENCIAL' ";
        $sql.="             when a.tipo_agendas_pk = 2 then 'REUNIÃO POR VIDEO CHAMADA' ";
        $sql.="             when a.tipo_agendas_pk = 3 then 'LEMBRETE' ";
        $sql.="             when a.tipo_agendas_pk = 4 then 'RETORNO' ";
        $sql.="             when a.tipo_agendas_pk = 5 then 'TAREFA' ";
        $sql.="             when a.tipo_agendas_pk = 6 then 'PESSOAL' ";
        $sql.="        end ds_tipo_agendas ";
        $sql.="       ,case when a.ic_status = 1 then 'Agenda Pendente' ";
        $sql.="             when a.ic_status = 2 then 'Agenda Concluída' ";
        $sql.="             when a.ic_status = 3 then 'Agenda Cancelada' ";
        $sql.="        end ds_status ";

        $sql.="  from agendas a ";
        $sql.=" inner join usuarios u on a.usuario_cadastro_pk = u.pk ";
        $sql.=" where 1=1 ";
        $sql.="   and a.leads_pk =".$leads_pk;
        $sql.=" order by a.tipo_agendas_pk asc ";

        
        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>

