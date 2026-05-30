<?

require_once '../inc/php/public.php';

require_once '../inc/classes/bestflow/DataBase.php';

require_once '../model/usuario.class.php';



class usuariodao{

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
    
    public function salvar($usuario){

        $fields = array();
        $fields['ds_usuario'] = $usuario->getds_usuario();
        $fields['ds_login'] = $usuario->getds_login();
        $fields['ds_senha'] = $usuario->getds_senha();
        $fields['ds_email'] = $usuario->getds_email();
        $fields['ds_cel'] = $usuario->getds_cel();
        $fields['ic_status'] = $usuario->getic_status();
        $fields['grupos_pk'] = $usuario->getgrupos_pk();
        $fields['leads_pk'] = $usuario->getleads_pk();
        $fields['contas_pk'] = $usuario->getcontas_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($usuario->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("usuarios", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("usuarios", $fields, " pk = ".$usuario->getpk());
        }

    }

    public function excluir($usuario){
        $this->db->execDelete("usuarios"," pk = ".$usuario->getpk());
    }
    
    public function listarTodosSemAdm($ds_usuario){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        if($ds_usuario!=""){
            $sql.=" and ds_usuario like '%".$ds_usuario."%'";
        }
        $sql.=" and ic_status = 1";
        $sql.=" and pk not in (1)";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarAdmSistema(){    
            $sql ="";
            $sql.="select u.pk usuario_aprovacao_pk, ";
            $sql.=" u.ds_usuario ds_usuaario_aprovacao";
            $sql.="  from usuarios u ";
            $sql.=" inner join grupos g on u.grupos_pk = g.pk";
            $sql.=" where 1=1 ";
            $sql.=" and g.ds_grupo in ('Controller')";
            $sql.=" and u.ic_status = 1";
            $sql.=" and u.pk not in (1)";
            $sql.=" order by u.ds_usuario asc ";
     
            $query = $this->db->execQuery($sql);
            return $query;    
    }
    
    
    //antigo
    public function carregarPorPk($pk){

        $usuario = new usuario();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";
        $sql.="  from usuarios ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $usuario->setpk($query[$i]["pk"]);
                $usuario->setdt_cadastro($query[$i]["dt_cadastro"]);
                $usuario->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $usuario->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $usuario->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $usuario->setds_usuario($query[$i]['ds_usuario']);
                $usuario->setds_login($query[$i]['ds_login']);
                $usuario->setds_senha($query[$i]['ds_senha']);
                $usuario->setds_email($query[$i]['ds_email']);
                $usuario->setds_cel($query[$i]['ds_cel']);
                $usuario->setic_status($query[$i]['ic_status']);
                $usuario->setgrupos_pk($query[$i]['grupos_pk']);
            }
        }
        return $usuario;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk  ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.leads_pk";
        $sql.="       ,u.contas_pk";
        $sql.="       ,up.pk usuario_ponto_pk";
        $sql.="       ,up.hr_entrada_dom";
        $sql.="       ,up.hr_saida_dom";
        $sql.="       ,up.hr_entrada_seg";
        $sql.="       ,up.hr_saida_seg";
        $sql.="       ,up.hr_entrada_ter";
        $sql.="       ,up.hr_saida_ter";
        $sql.="       ,up.hr_entrada_qua";
        $sql.="       ,up.hr_saida_qua";
        $sql.="       ,up.hr_entrada_qui";
        $sql.="       ,up.hr_saida_qui";
        $sql.="       ,up.hr_entrada_sex";
        $sql.="       ,up.hr_saida_sex";
        $sql.="       ,up.hr_entrada_sab";
        $sql.="       ,up.hr_saida_sab";
        $sql.="       ,up.ic_dom";
        $sql.="       ,up.ic_seg";
        $sql.="       ,up.ic_ter";
        $sql.="       ,up.ic_qua";
        $sql.="       ,up.ic_qui";
        $sql.="       ,up.ic_sex";
        $sql.="       ,up.ic_sab";
        $sql.="       ,up.turnos_pk_dom";
        $sql.="       ,up.turnos_pk_seg";
        $sql.="       ,up.turnos_pk_ter";
        $sql.="       ,up.turnos_pk_qua";
        $sql.="       ,up.turnos_pk_qui";
        $sql.="       ,up.turnos_pk_sex";
        $sql.="       ,up.turnos_pk_sab";

        $sql.="  from usuarios u";
        $sql.="  left join usuario_ponto up on u.pk = up.usuarios_pk";
        $sql.=" where u.pk = $pk ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_usuario($ds_usuario){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.leads_pk";
        $sql.="       ,g.ds_grupo ";
        $sql.="       ,case u.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";

        $sql.="  from usuarios u ";
        $sql.="       inner join grupos g on u.grupos_pk = g.pk";
        $sql.=" where 1=1 ";
        if($ds_usuario!=""){
            $sql.=" and u.ds_usuario like '%".$ds_usuario."%'";
        }
        $sql.=" and ic_status = 1";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarGrid($ds_usuario,$ic_status,$contas_pk,$grupos_pk){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.leads_pk";
        $sql.="       ,g.ds_grupo ";
        $sql.="       ,c.ds_conta ";
        $sql.="       ,case u.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";

        $sql.="  from usuarios u ";
        $sql.="       inner join grupos g on u.grupos_pk = g.pk";
        $sql.="       left join contas c on u.contas_pk = c.pk";
        $sql.=" where 1=1 ";
        if($ds_usuario!=""){
            $sql.=" and u.ds_usuario like '%".$ds_usuario."%'";
        }
        if($ic_status!=""){
            $sql.=" and u.ic_status = ".$ic_status;
        }
        if($contas_pk!=""){
            $sql.=" and u.contas_pk = ".$contas_pk;
        }

        if($grupo_pk!=""){
            $sql.=" and u.grupos_pk = ".$grupos_pk;
        }

        if($this->arrToken['usuarios_pk']!=1){
            $sql.=" and u.pk not in (1)";
        }
        

        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_ds_usuario_ativo($ds_usuario){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        if($ds_usuario!=""){
            $sql.=" and ds_usuario like '%".$ds_usuario."%'";
        }
        $sql.=" and ic_status = 1";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_supervisor($ds_supervisor){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from usuarios ";
        //$sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        $sql.="     and grupos_pk = 3";
        //$sql.="     and eu.ic_supervisor = 1";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_equipes($equipes_pk){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.leads_pk";
        $sql.="       ,e.ds_equipe";

        $sql.="  from usuarios u";
        $sql.="       inner join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.="       inner join equipes e on eu.equipes_pk = e.pk";
        $sql.=" where 1=1 ";
        $sql.="     and eu.equipes_pk = ".$equipes_pk;
       
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarDadosCliente($leads_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and leads_pk = ".$leads_pk;
        }
        
        $sql.=" order by ds_usuario asc ";
     

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarLogin($strLogin, $strSenha){

        $sql ="";
        $sql.="select u.pk par1, u.ds_usuario par2, u.ds_login par3, date_format(date_add(sysdate(), interval 10 hour),'%Y%m%d%H%m%s') par4, u.colaboradores_pk par5,u.leads_pk par6, u.contas_pk par7 ";
        $sql.="  from usuarios u "; 
        $sql.=" where u.ds_login = ".$this->db->mysqlnull($strLogin)." ";
        $sql.="   and u.ds_senha = ".$this->db->mysqlnull($strSenha)." ";      
     
        $query = $this->db->execQuery($sql);
        
        return $query;
    }
    
    public function verificarTempoLogado($strDtValidadeLogin){
        
        $sql ="";
        $sql.="select '".$strDtValidadeLogin."' >= date_format(sysdate(),'%Y%m%d%H%m%s') expirado ";
        
        $query = $this->db->execQuery($sql);
        return $query[0]['expirado'];
    }    
    public function verificarPermissao($usuarios_pk,$ds_dominio_modulo,$ic_acao){
        
    $sql ="";
	$sql.="select count('0') total ";
	$sql.="  from usuarios u ";
	$sql.="	   inner join grupos g on u.grupos_pk = g.pk ";
	$sql.="	   inner join modulos_grupos mg on mg.grupos_pk = g.pk ";
	$sql.="       inner join modulos m on mg.modulos_pk = m.pk ";
	$sql.=" where u.pk = ".$usuarios_pk;
	$sql.="   and m.ds_dominio = '".$ds_dominio_modulo."' ";
	
	if($ic_acao == "ins"){
            $sql.=" and mg.ic_ins = 1 ";
	}
	else if($ic_acao == "cons"){
            $sql.=" and mg.ic_cons = 1 ";
	}
	else if($ic_acao == "upd"){
            $sql.=" and mg.ic_upd = 1 ";
	}
	else if($ic_acao == "del"){
            $sql.=" and mg.ic_del = 1 ";
	}

        $query = $this->db->execQuery($sql);
        return $query[0]['total'];
    }    
    
    public function pegarUltimoDiaMes($newData){
        
        $sql ="";
        $sql = "select date_format(last_day('".DataYMD($newData)."'),'%d/%m/%Y') ultimodia ";
        
        $query = $this->db->execQuery($sql);
        return $query[0]['ultimodia'];
    }

    public function listarUsuarioLogado(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,colaboradores_pk";
        $sql.="       ,leads_pk";
        $sql.="  from usuarios ";
        $sql.=" where pk =".$this->arrToken['usuarios_pk'];
        $query = $this->db->execQuery($sql);
        return $query;

    } 
    
    public function listar_por_grupos_pk($grupos_pk,$token){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_usuario ";
        $sql.="       ,ds_login ";
        $sql.="       ,ds_senha ";
        $sql.="       ,ds_email ";
        $sql.="       ,ds_cel ";
        $sql.="       ,ic_status ";
        $sql.="       ,grupos_pk ";
        $sql.="       ,leads_pk";
        $sql.="  from usuarios ";
        $sql.=" where 1=1 ";
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and grupos_pk not in (1)";
        }
        /*if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and grupos_pk =".$this->arrToken['grupos_pk'];
        }
        if($grupos_pk!=""){
            $sql.=" and grupos_pk=".$grupos_pk;
        }*/
                
        $sql.=" order by ds_usuario asc ";
        
        
       


        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_grupos_pk_equipes_pk($grupos_pk,$token){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="  from usuarios u";
        $sql.="       left join equipes_usuarios eu on u.pk = eu.usuarios_pk";
        $sql.=" where 1=1 ";
        if(!permissao("grupo_admin_listar", "cons", $token)){
            $sql.=" and u.grupos_pk not in (1)";
        }
        /*if(!permissao("grupo_listar_todos", "cons", $token)){
            $sql.=" and u.grupos_pk =".$this->arrToken['grupos_pk'];
        }*/
        if(!permissao("usuario_listar_todos", "cons", $token)){
            $sql.=" and u.pk =".$this->arrToken['usuarios_pk'];
        }                
        /*if($grupos_pk!=""){
          $sql.=" and u.grupos_pk=".$grupos_pk;
        }*/
        if(!permissao("supervisor_listar_equipes", "cons", $token)){
            if($this->arrToken['equipes_pk']!=""){
                $sql.=" and eu.equipes_pk = ".$this->arrToken['equipes_pk'];
            }
        }
       
        
        
        $sql.=" order by ds_usuario asc ";
    }
    public function listar_nome_login($ds_login){

        $sql ="";
        $sql.="select pk ";
        $sql.="  from usuarios ";
        $sql.=" where ds_login ='".$ds_login."'";
        $query = $this->db->execQuery($sql);
        return $query[0]['pk'];

    }
    public function trocarSenha($usuario_pk,$ds_senha){
        $fields = array();
    
        $fields['ds_senha'] = $ds_senha;
        $this->db->execUpdate("usuarios", $fields, " pk = ".$usuario_pk);
        
        

    }

    public function listarGrupoComPermissaoConstEmAnaliseFinanceira(){
        $sql ="";
        $sql.="select pk ";
        $sql.="  from usuarios ";
        $query = $this->db->execQuery($sql);
        return $query[0]['pk'];

    }

    public function listarTodosGestores(){
        $sql ="";
        $sql.="select u.pk,  u.ds_usuario ";
        $sql.="  from usuarios u ";
        $sql.=" LEFT join grupos g on g.pk = u.grupos_pk ";
        $sql.=" where  g.ds_grupo like 'Controller' ";
        $sql.=" ORDER BY u.ds_usuario ASC ";
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodosAnalistas(){
        $sql ="";
        $sql.="select u.pk,  u.ds_usuario ";
        $sql.="  from usuarios u ";
        $sql.=" inner join grupos g on g.pk = u.grupos_pk ";
        $sql.=" where  g.ds_grupo like '%Analista Financeiro' ";
        $sql.=" ORDER BY u.ds_usuario ASC ";
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarGruposUsuario($usuarios_pk){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,g.ds_grupo ";

        $sql.="  from usuarios u ";
        $sql.="       inner join grupos g on u.grupos_pk = g.pk";
        $sql.=" where 1=1 ";
        if($usuarios_pk == ""){
            $sql.=" and u.pk = ".$this->arrToken['usuarios_pk'];
        }else{
            $sql.=" and u.pk = ".$usuarios_pk;
        }

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDadosUsuario($usuarios_pk){

        $sql ="";
        $sql.="select u.pk, u.dt_cadastro, u.usuario_cadastro_pk, u.dt_ult_atualizacao, u.usuario_ult_atualizacao_pk  ";
        $sql.="       ,u.ds_usuario ";
        $sql.="       ,u.ds_login ";
        $sql.="       ,u.ds_senha ";
        $sql.="       ,u.ds_email ";
        $sql.="       ,u.ds_cel ";
        $sql.="       ,u.ic_status ";
        $sql.="       ,u.grupos_pk ";
        $sql.="       ,u.colaboradores_pk";
        $sql.="       ,u.leads_pk";
        $sql.="       ,g.ds_grupo ";
        $sql.="  from usuarios u";
        $sql.="       inner join grupos g on u.grupos_pk = g.pk";
        $sql.=" where u.pk =".$usuarios_pk;
        $query = $this->db->execQuery($sql);
        return $query;

    } 
    
    
}

?>
