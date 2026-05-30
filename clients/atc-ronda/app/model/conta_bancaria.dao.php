<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/conta_bancaria.class.php';


class conta_bancariadao{

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
    
    public function salvar($conta_bancaria){

        $fields = array();
        $fields['ds_conta_bancaria'] = $conta_bancaria->getds_conta_bancaria();
        $fields['ds_agencia'] = $conta_bancaria->getds_agencia();
        $fields['ds_conta'] = $conta_bancaria->getds_conta();
        $fields['tipo_conta_pk'] = $conta_bancaria->gettipo_conta_pk();
        $fields['vl_saldo_inicial'] = $conta_bancaria->getvl_saldo_inicial();
        $fields['ic_status'] = $conta_bancaria->getic_status();
        $fields['bancos_pk'] = $conta_bancaria->getbancos_pk();
        $fields['empresas_pk'] = $conta_bancaria->getempresas_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($conta_bancaria->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contas_bancarias", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("contas_bancarias", $fields, " pk = ".$conta_bancaria->getpk());
        }

    }

    public function excluir($conta_bancaria){
        $this->db->execDelete("contas_bancarias"," pk = ".$conta_bancaria->getpk());
    }

    public function carregarPorPk($pk){

        $conta_bancaria = new conta_bancaria();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_conta_bancaria ";
        $sql.="       ,ds_agencia ";
        $sql.="       ,ds_conta ";
        $sql.="       ,tipo_conta_pk ";
        $sql.="       ,vl_saldo_inicial ";
        $sql.="       ,ic_status ";
        $sql.="       ,bancos_pk ";
        $sql.="       ,empresas_pk";


        $sql.="  from contas_bancarias ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $conta_bancaria->setpk($query[$i]["pk"]);
                $conta_bancaria->setdt_cadastro($query[$i]["dt_cadastro"]);
                $conta_bancaria->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $conta_bancaria->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $conta_bancaria->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $conta_bancaria->setds_conta_bancaria($query[$i]['ds_conta_bancaria']);
                $conta_bancaria->setds_agencia($query[$i]['ds_agencia']);
                $conta_bancaria->setds_conta($query[$i]['ds_conta']);
                $conta_bancaria->settipo_conta_pk($query[$i]['tipo_conta_pk']);
                $conta_bancaria->setvl_saldo_inicial($query[$i]['vl_saldo_inicial']);
                $conta_bancaria->setic_status($query[$i]['ic_status']);
                $conta_bancaria->setbancos_pk($query[$i]['bancos_pk']);
                $conta_bancaria->setempresas_pk($query[$i]['empresas_pk']);

            }
        }
        return $conta_bancaria;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_conta_bancaria ";
        $sql.="       ,ds_agencia ";
        $sql.="       ,ds_conta ";
        $sql.="       ,tipo_conta_pk ";
        $sql.="       ,vl_saldo_inicial ";
        $sql.="       ,ic_status ";
        $sql.="       ,bancos_pk ";
        $sql.="       ,empresas_pk";

        $sql.="  from contas_bancarias ";        
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listarContasLancamento($empresas_pk){

        $sql ="";
        $sql.="select cb.pk, cb.dt_cadastro, cb.usuario_cadastro_pk, cb.dt_ult_atualizacao, cb.usuario_ult_atualizacao_pk  ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,cb.ds_agencia ";
        $sql.="       ,cb.ds_conta ";
        $sql.="       ,cb.tipo_conta_pk ";
        $sql.="       ,cb.vl_saldo_inicial ";
        $sql.="       ,cb.ic_status ";
        $sql.="       ,cb.bancos_pk ";
        $sql.="       ,cb.empresas_pk";
        $sql.="       ,concat (b.ds_banco,' - AG:',cb.ds_agencia,' - Cont:',cb.ds_conta) ds_dados_conta ";
        $sql.="  from contas_bancarias cb ";
        $sql.="  left join bancos b on cb.bancos_pk = b.pk ";
        $sql.=" where 1=1";
        if($empresas_pk!=""){
            $sql.=" and cb.empresas_pk = ".$empresas_pk;
        }
        
        $sql.=" group by cb.pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    

    public function listar_por_ds_conta_bancaria($bancos_pk,$ds_conta,$ic_status){

        $sql ="";
        $sql.="select cb.pk, cb.dt_cadastro, cb.usuario_cadastro_pk, cb.dt_ult_atualizacao, cb.usuario_ult_atualizacao_pk ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,cb.ds_agencia ";
        $sql.="       ,cb.ds_conta ";
        $sql.="       ,cb.tipo_conta_pk ";
        $sql.="       ,cb.vl_saldo_inicial ";
        $sql.="       ,cb.ic_status ";
        $sql.="       ,cb.bancos_pk ";
        $sql.="       ,cb.empresas_pk";
        $sql.="       ,c.ds_banco ";
        $sql.="       ,Case";
        $sql.="         WHEN cb.ic_status = 1 THEN  'Ativa'";
        $sql.="         WHEN cb.ic_status = 2 THEN  'Desativada'";
        $sql.="         END ds_status";
        $sql.="       ,Case ";
        $sql.="         WHEN cb.tipo_conta_pk = 1 THEN  'Conta Corrente'";
        $sql.="         WHEN cb.tipo_conta_pk = 2 THEN  'Poupanbça'";
        $sql.="         WHEN cb.tipo_conta_pk = 3 THEN  'Investimento'";       
        $sql.="         WHEN cb.tipo_conta_pk = 4 THEN  'Caixinha'";       
        $sql.="         END ds_tipo_conta";
        $sql.="  from contas_bancarias cb ";
        $sql.="  left join bancos c on c.pk = cb.bancos_pk ";
        $sql.=" where 1=1 ";
        
        if($ds_conta_bancaria != ""){
             $sql.=" and cb.bancos_pk =".$bancos_pk;
        }
                
        if($ds_conta != ""){
            $sql.=" and cb.ds_conta like '%".$ds_conta."%' ";
        }
        
         if($ic_status != ""){
             $sql.=" and cb.ic_status =".$ic_status;
        }
        
        $sql.=" order by cb.ds_conta_bancaria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_conta_bancaria ";
        $sql.="       ,ds_agencia ";
        $sql.="       ,ds_conta ";
        $sql.="       ,tipo_conta_pk ";
        $sql.="       ,vl_saldo_inicial ";
        $sql.="       ,ic_status ";
        $sql.="       ,bancos_pk ";
        $sql.="       ,empresas_pk";

        $sql.="  from contas_bancarias ";
        $sql.=" where 1=1 ";
        $sql.=" ic_status = 1 ";
        $sql.=" order by ds_conta_bancaria asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarEmpresaContasAtivas(){

        $sql ="";
        $sql.="select c.pk,c.ds_conta";
        $sql.="  from contas_bancarias cb ";
        $sql.="  inner join contas c on c.pk = cb.empresas_pk ";   
        $sql.=" where 1=1 ";
        $sql.=" and cb.ic_status = 1 ";   
        $sql.=" group by c.pk ";
        $sql.=" order by c.ds_conta asc ";
  
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listaPorEmpresa($empresas_pk){

        $sql ="";
        $sql.="select cb.pk,cb.ds_conta_bancaria ";
        $sql.="       ,cb.ds_conta ";
        $sql.="       ,cb.ds_agencia ";
        $sql.="       ,b.ds_banco ";
        $sql.="  from contas_bancarias cb ";
        $sql.="  inner join contas c on c.pk = cb.empresas_pk ";   
        $sql.="  left join bancos b on b.pk = cb.bancos_pk ";
        $sql.=" where 1=1 ";
        $sql.=" and cb.ic_status = 1 "; 
        if(!empty($empresas_pk)){
            $sql .=" AND cb.empresas_pk=".$empresas_pk;
        }  
        $sql.=" group by cb.pk,c.pk ";
        //$sql.=" order by cb.ds_conta asc ";
        //echo $sql;
       //exit;
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            if($query[$i]['ds_banco'] != ""){
               $ds_conta = $query[$i]['ds_banco']." - AG:".$query[$i]['ds_agencia']." - CC:".$query[$i]['ds_conta'];
            }else{
                $ds_conta = "Caixinha";
            }
            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_conta"=>$ds_conta           
            );
        }
        return $result;

    }

    
    public function listarValorInicial($empresas_pk,$contas_bancarias_pk){

        $sql ="";
        $sql.="SELECT cb.vl_saldo_inicial";
        $sql.=" FROM contas_bancarias cb";
        $sql.=" WHERE cb.empresas_pk =".$empresas_pk;
        $sql.=" AND cb.pk = ".$contas_bancarias_pk;
      
        $query = $this->db->execQuery($sql);
        return $query;

    }
    

}

?>
