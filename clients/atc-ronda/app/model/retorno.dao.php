<?php

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/retorno.class.php';


class retornodao{

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
    
    public function salvar($retorno){
        
        $fields = array();
        $fields['dt_retorno'] = $retorno->getdt_retorno();
        $fields['equipes_pk'] = $retorno->getequipes_pk();
        $fields['responsavel_pk'] = $retorno->getresponsavel_pk();
        //$fields['dt_termino_retorno'] =  $retorno->getdt_termino_retorno();
        $fields['ds_retorno'] = $retorno->getds_retorno();
        $fields['ocorrencias_pk'] = $retorno->getocorrencias_pk();
        $fields['tipo_lembrete_pk'] = $retorno->gettipo_lembrete_pk();
        
        if($retorno->getdt_termino_retorno()== 1){
            $fields['dt_termino_retorno'] = "sysdate()";
        }
        if($retorno->getdt_termino_retorno()== 2){
            $fields['dt_termino_retorno'] = " ";
        }

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($retorno->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            
			//$this->db->execInsert("retornos", $fields);
			
            $pk = $this->db->execInsert("retornos", $fields);
            return $pk;
        }else{
            
			//$this->db->execUpdate("retornos", $fields, " pk = ".$retorno->getpk());
			
            return $this->db->execUpdate("retornos", $fields, " pk = ".$retorno->getpk());   
        }
    }

    public function excluir($retorno){
        $this->db->execDelete("retornos"," pk = ".$retorno->getpk());
    }
    
    
    public function excluir_pk_oc($ocorrencias_pk){
        $this->db->execDelete("retornos"," ocorrencias_pk = ".$ocorrencias_pk);
    }

    public function carregarPorPk($pk){

        $retorno = new retorno();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,tipo_lembrete_pk";


        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
        
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $retorno->setpk($query[$i]["pk"]);
                $retorno->setdt_cadastro($query[$i]["dt_cadastro"]);
                $retorno->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $retorno->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $retorno->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $retorno->setdt_retorno($query[$i]['dt_retorno']);
                $retorno->setequipes_pk($query[$i]['equipes_pk']);
                $retorno->setresponsavel_pk($query[$i]['responsavel_pk']);
                $retorno->setdt_termino_retorno($query[$i]['dt_termino_retorno']);
                $retorno->setds_retorno($query[$i]['ds_retorno']);
                $retorno->setocorrencias_pk($query[$i]['ocorrencias_pk']);
                $retorno->settipo_lembrete_pk($query[$i]['tipo_lembrete_pk']);

            }
        }
        return $retorno;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,tipo_lembrete_pk";

        $sql.="  from retornos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarPorOcorrenciasPk($ocorrencias_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,date_format(dt_retorno, '%d/%m/%Y ') dt_retorno";
        $sql.="       ,date_format(dt_retorno, '%H:%i:%s') hr_retorno";
        $sql.="       ,date_format(dt_termino_retorno, '%d/%m/%Y ') dt_termino_retorno";
        $sql.="       ,date_format(dt_termino_retorno, '%H:%i:%s') hr_termino_retorno";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,tipo_lembrete_pk ";

        $sql.="  from retornos ";
        $sql.=" where ocorrencias_pk = $ocorrencias_pk ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_retorno($dt_retorno){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,tipo_lembrete_pk";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        if($dt_retorno != ""){
            $sql.=" and ds_retorno like '%".$dt_retorno."%' ";
        }
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_qtde_retorno_aberto(){

        date_default_timezone_set('America/Sao_Paulo');
        $data =  date('d/m/y');
        $hora = date('H:i:s');			

        $data =  date('y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
        $sql.="select COUNT(r.pk) qtde_retorno";
        $sql.="  from retornos r";
        $sql.="  INNER JOIN ocorrencias o on o.pk = r.ocorrencias_pk ";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.=" where r.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        $sql.=" and r.dt_retorno <= '".$horarioverao."'";
        //$sql.=" and r.tipo_lembrete_pk = 1";
        $sql.=" and r.dt_termino_retorno is null";
        
        $sql.=" order by r.dt_retorno asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_retorno_aberto_Popup(){

        date_default_timezone_set('America/Sao_Paulo');
        $data =  date('d/m/Y');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
        $sql.="select o.pk, o.dt_cadastro, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="  ,l.pk leads_pk";
        $sql.="  ,l.ds_lead ";
        $sql.="  ,date_format(r.dt_retorno,'%d/%m/%Y <br>%H:%i:%s')dt_retorno "; 
        $sql.="  ,tio.ds_tipo_ocorrencia";
        $sql.="  ,u1.ds_usuario ds_agendado_para ";  
        $sql.="  ,r.ds_retorno ";  
        $sql.="  ,r.tipo_lembrete_pk";  
        $sql.="  from retornos r";
        $sql.="  INNER JOIN ocorrencias o on o.pk = r.ocorrencias_pk ";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  INNER JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.=" where r.responsavel_pk =".$this->arrToken['usuarios_pk'];
        $sql.=" and r.dt_retorno <= '".$horarioverao."'";
        //$sql.=" and r.tipo_lembrete_pk = 1";
        
        $sql.=" order by r.dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_retorno_aberto_Whats(){

        date_default_timezone_set('America/Sao_Paulo');
        $data =  date('d/m/Y');
        $hora = date('H:i:s');			

        $data =  date('Y-m-d');
        $horarioverao = $data." ".$hora; 
        
        $sql ="";
        $sql.="select o.pk, o.dt_cadastro, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="  ,l.pk leads_pk";
        $sql.="  ,l.ds_lead ";
        $sql.="  ,date_format(r.dt_retorno,'%d/%m/%Y <br>%H:%i:%s')dt_retorno "; 
        $sql.="  ,tio.ds_tipo_ocorrencia";
        $sql.="  ,u1.ds_usuario ds_agendado_para ";  
        $sql.="  ,r.ds_retorno ";  
        $sql.="  ,r.tipo_lembrete_pk";  
        $sql.="  ,u1.ds_cel";  
        $sql.="  from retornos r";
        $sql.="  INNER JOIN ocorrencias o on o.pk = r.ocorrencias_pk ";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  INNER JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.=" where r.responsavel_pk=".$this->arrToken['usuarios_pk'];
        $sql.=" and r.dt_retorno <= '".$horarioverao."'";
        $sql.=" and r.tipo_lembrete_pk = 2";
        
        $sql.=" order by dt_retorno asc ";
       
        
       

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_retorno ";
        $sql.="       ,equipes_pk ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,dt_termino_retorno ";
        $sql.="       ,ds_retorno ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,tipo_lembrete_pk";

        $sql.="  from retornos ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_retorno asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
