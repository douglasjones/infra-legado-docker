<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;
use Throwable;

class Colaborador {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function excluir($pk){
        Util::execDelete('documentos',' colaborador_pk = '.$pk,$this->pdo);

        $sql="";
        $sql.=" delete from escala_dados_colaborador where agenda_colaborador_padrao_pk in(select pk
          from (select a.pk from agenda_colaborador_padrao a
         where a.colaboradores_pk =".$pk.")x)";

        $stmt = $this->pdo->prepare( $sql);
        $stmt->execute();


        Util::execDelete('agenda_colaborador_padrao',' colaboradores_pk = '.$pk,$this->pdo);
        Util::execDelete('colaboradores_produtos_servicos',' colaboradores_pk = '.$pk,$this->pdo);
        Util::execDelete('colaboradores',' pk = '.$pk,$this->pdo);
    }
    public function excluirFuncao($pk){
        Util::execDelete('colaboradores_produtos_servicos',' pk = '.$pk,$this->pdo);
    }

    public function updateEscala($escala){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['colaboradores_pk'] = $escala['colaboradores_pk'];

        Util::execUpdate("agenda_colaborador_padrao", $fields, " pk = ".$escala['pk'],$this->pdo);
        $pk = $escala['pk'];
        $retorno->status = true;
        $retorno->message = 'Dados atualizado com sucesso';
        $retorno->data = $pk;

        return $retorno;

    }

    public function updateDocs($docs){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['colaborador_pk'] = $docs['colaborador_pk'];
        Util::execUpdate("documentos", $fields, " pk = ".$docs['pk'],$this->pdo);
        $pk = $docs['pk'];
        $retorno->status = true;
        $retorno->message = 'Dados atualizado com sucesso';
        $retorno->data = $pk;

        return $retorno;

    }

    public function salvarDSPin($colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        try{
            $fields = array();
            $fields['ds_pin'] = $_SESSION['session_user']['ds_uf']."0".$_SESSION['session_user']['contas_pk']." - ".$colaborador_pk;


            Util::execUpdate("colaboradores", $fields, " pk = ".$colaborador_pk,$this->pdo);


            $retorno->status = true;
            $retorno->message = 'Dados atualizado com sucesso';
            $retorno->data = $_SESSION['session_user']['contas_pk']." - ".$colaborador_pk;

            return $retorno;
        }
        catch(Throwable $e){
            print_r($e->getMessage());
            die();
        }
        

    }
    public function salvar($colaborador){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        try{
            $fields = array();
            $fields['grupos_pk'] = $colaborador['grupos_pk'];
            $fields['ds_colaborador'] = $colaborador['ds_colaborador'];
            $fields['ds_nacionalidade'] = $colaborador['ds_nacionalidade'];
            $fields['ic_genero'] = $colaborador['ic_genero'];
            $fields['ds_nome_pai'] = $colaborador['ds_nome_pai'];
            $fields['ds_nome_mae'] = $colaborador['ds_nome_mae'];
            $fields['ic_regime_contratacao'] = $colaborador['ic_regime_contratacao'];
            $fields['ds_carga_horaria_mensal'] = $colaborador['ds_carga_horaria_mensal'];
            $fields['vl_salario'] = $colaborador['vl_salario'];
            $fields['ds_matricula'] = $colaborador['ds_matricula'];
            $fields['ds_e_social'] = $colaborador['ds_e_social'];
            $fields['ic_funcionario'] = $colaborador['ic_funcionario'];
            $fields['ic_status'] = $colaborador['ic_status'];
            $fields['ds_cpf'] = $colaborador['ds_cpf'];
            $fields['ds_rg'] = $colaborador['ds_rg'];
            $fields['ds_cel'] = $colaborador['ds_cel'];
            $fields['ds_orgao_expedicao_rg'] = $colaborador['ds_orgao_expedicao_rg'];
            $fields['uf_expedicao_rg'] = $colaborador['uf_expedicao_rg'];
            $fields['ds_titulo_eleitor'] = $colaborador['ds_titulo_eleitor'];
            $fields['ds_zona_eleitorial'] = $colaborador['ds_zona_eleitorial'];
            $fields['ds_secao'] = $colaborador['ds_secao'];
            $fields['ds_ctps'] = $colaborador['ds_ctps'];
            $fields['ds_serie_ctps'] = $colaborador['ds_serie_ctps'];
            $fields['ds_num_reservista'] = $colaborador['ds_num_reservista'];
            $fields['ds_num_cartao_sus'] = $colaborador['ds_num_cartao_sus'];
            $fields['ic_tipo_conta_bancaria'] = $colaborador['ic_tipo_conta_bancaria'];
            $fields['banco_pk'] = $colaborador['banco_pk'];
            $fields['ds_agencia'] = $colaborador['ds_agencia'];
            $fields['ds_conta'] = $colaborador['ds_conta'];
            $fields['ds_digito'] = $colaborador['ds_digito'];
            $fields['ds_pix'] = $colaborador['ds_pix'];
            $fields['ds_favorecido'] = $colaborador['ds_favorecido'];
            $fields['ds_cep'] = $colaborador['ds_cep'];
            $fields['ds_endereco'] = $colaborador['ds_endereco'];
            $fields['ds_numero'] = $colaborador['ds_numero'];
            $fields['ds_complemento'] = $colaborador['ds_complemento'];
            $fields['ds_bairro'] = $colaborador['ds_bairro'];
            $fields['ds_cidade'] = $colaborador['ds_cidade'];
            $fields['ds_uf'] = $colaborador['ds_uf'];
            $fields['ds_num_sapato'] = $colaborador['ds_num_sapato'];
            $fields['ds_num_camisa'] = $colaborador['ds_num_camisa'];
            $fields['ds_num_calca'] = $colaborador['ds_num_calca'];


            if($colaborador['dt_nascimento']!=""){
                $fields['dt_nascimento'] = Util::DataYMD($colaborador['dt_nascimento']);
            }
            if($colaborador['dt_expedicao_rg']!=""){
                $fields['dt_expedicao_rg'] = Util::DataYMD($colaborador['dt_expedicao_rg']);
            }

            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
            $fields["contas_pk"] = $_SESSION['session_user']['contas_pk'];

            if($colaborador['pk']  == ""){

                $fields["dt_cadastro"] = "sysdate()";
                $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];

                $pk = Util::execInsert("colaboradores", $fields,$this->pdo);
                $retorno->status = true;
                $retorno->message = 'Dados cadastrados com sucesso';
                $retorno->data = $pk;
            }
            else{
                Util::execUpdate("colaboradores", $fields, " pk = ".$colaborador['pk'],$this->pdo);
                $pk = $colaborador['pk'];
                $retorno->status = true;
                $retorno->message = 'Dados atualizado com sucesso';
                $retorno->data = $pk;
            }
            return $retorno;
        }
        catch(Throwable $e){
            print_r($e->getMessage());
            die();
        }
        
    }

    public function salvarFuncao($funcao){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['produtos_servicos_pk'] = $funcao['produtos_servicos_pk'];
        $fields['colaboradores_pk'] = $funcao['colaboradores_pk'];
        if($funcao['pk']==""){
            $pk = Util::execInsert("colaboradores_produtos_servicos", $fields,$this->pdo);
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("colaboradores_produtos_servicos", $fields,' pk = '.$funcao['pk'],$this->pdo);
            $retorno->data = $funcao['pk'];
        }

        $retorno->status = true;
        $retorno->message = 'Dados cadastrados com sucesso';



        return $retorno;
    }
    public function listarTodosByFuncaoPk($produtos_servicos){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.grupos_pk ";
        $sql.="  from colaboradores c ";
        $sql.="  inner join colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk";
        $sql.=" where 1=1 ";
        $sql.=" and c.ic_status = 1 ";
        if($produtos_servicos!=""){
            $sql.=" and cps.produtos_servicos_pk =".$produtos_servicos;
        }
        $sql.="   and c.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by c.ds_colaborador asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }
    public function listarTodos(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.grupos_pk ";
        $sql.="  from colaboradores c ";
        $sql.=" where 1=1 ";
        $sql.=" and c.ic_status = 1 ";
        $sql.="   and c.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by c.ds_colaborador asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }
    public function listarPk($pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select c.pk,";
        $sql.="     c.dt_cadastro,";
        $sql.="     c.usuario_cadastro_pk,";
        $sql.="     c.dt_ult_atualizacao,";
        $sql.="     c.usuario_ult_atualizacao_pk,";
        $sql.="     c.ds_colaborador,";
        $sql.="     date_format(c.dt_nascimento,'%d/%m/%Y')dt_nascimento,";
        $sql.="     c.ic_genero,";
        $sql.="     c.ds_nacionalidade,";
        $sql.="     c.ds_nome_pai,";
        $sql.="     c.ds_nome_mae,";
        $sql.="     c.contas_pk,";
        $sql.="     c.ic_regime_contratacao,";
        $sql.="     c.ds_carga_horaria_mensal,";
        $sql.="     c.vl_salario,";
        $sql.="     c.ds_matricula,";
        $sql.="     c.ds_e_social,";
        $sql.="     c.ic_funcionario,";
        $sql.="     c.ic_status,";
        $sql.="     c.ds_cpf,";
        $sql.="     c.ds_cel,";
        $sql.="     c.ds_rg,";
        $sql.="     c.ds_orgao_expedicao_rg,";
        $sql.="     date_format(c.dt_expedicao_rg,'%d/%m/%Y')dt_expedicao_rg,";
        $sql.="     c.uf_expedicao_rg,";
        $sql.="     c.ds_titulo_eleitor,";
        $sql.="     c.ds_zona_eleitorial,";
        $sql.="     c.ds_secao,";
        $sql.="     c.ds_ctps,";
        $sql.="     c.ds_serie_ctps,";
        $sql.="     c.ds_num_reservista,";
        $sql.="     c.ds_num_cartao_sus,";
        $sql.="     c.ic_tipo_conta_bancaria,";
        $sql.="     c.ds_agencia,";
        $sql.="     c.ds_conta,";
        $sql.="     c.ds_digito,";
        $sql.="     c.banco_pk,";
        $sql.="     c.ds_pix,";
        $sql.="     c.ds_favorecido,";
        $sql.="     c.ds_cep,";
        $sql.="     c.ds_endereco,";
        $sql.="     c.ds_numero,";
        $sql.="     c.ds_cel,";
        $sql.="     c.ds_complemento,";
        $sql.="     c.ds_bairro,";
        $sql.="     c.ds_cidade,";
        $sql.="     c.ds_uf,";
        $sql.="     c.ds_num_sapato,";
        $sql.="     c.ds_num_camisa,";
        $sql.="     c.ds_num_calca,";
        $sql.="     c.grupos_pk,";
        $sql.="     c.ds_pin,";
        $sql.="     psl.img_colaborador_cadastro ds_imagem";
        $sql.="  from colaboradores c ";
        $sql.="     left join ponto_solicitacao_liberacao_app psl on c.pk = psl.colaborador_pk";
        $sql.=" where 1=1 ";
        $sql.=" and c.pk =  ".$pk;
        $sql.="   and c.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by c.ds_colaborador asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                if(!empty($query[$i]['ds_imagem'])){
                    $img = '<img width=100 height=100 src="data:image/png;base64,'. ($query[$i]['ds_imagem']).'">';;
                }
                else{
                    $img ='<img src="/assets/img/profile/avatar.jpg" width="100" height="100">';
                }

                $return[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "usuario_cadastro_pk" => $query[$i]["usuario_cadastro_pk"],
                    "dt_ult_atualizacao" => $query[$i]["dt_ult_atualizacao"],
                    "usuario_ult_atualizacao_pk" => $query[$i]["usuario_ult_atualizacao_pk"],
                    "ds_colaborador" => $query[$i]["ds_colaborador"],
                    "dt_nascimento" => $query[$i]["dt_nascimento"],
                    "ic_genero" => $query[$i]["ic_genero"],
                    "ds_nacionalidade" => $query[$i]["ds_nacionalidade"],
                    "ds_nome_pai" => $query[$i]["ds_nome_pai"],
                    "ds_nome_mae" => $query[$i]["ds_nome_mae"],
                    "ds_cel" => $query[$i]["ds_cel"],
                    "contas_pk" => $query[$i]["contas_pk"],
                    "ic_regime_contratacao" => $query[$i]["ic_regime_contratacao"],
                    "ds_carga_horaria_mensal" => $query[$i]["ds_carga_horaria_mensal"],
                    "vl_salario" => $query[$i]["vl_salario"],
                    "ds_matricula" => $query[$i]["ds_matricula"],
                    "ds_e_social" => $query[$i]["ds_e_social"],
                    "ic_funcionario" => $query[$i]["ic_funcionario"],
                    "ic_status" => $query[$i]["ic_status"],
                    "ds_cpf" => $query[$i]["ds_cpf"],
                    "ds_rg" => $query[$i]["ds_rg"],
                    "ds_orgao_expedicao_rg" => $query[$i]["ds_orgao_expedicao_rg"],
                    "dt_expedicao_rg" => $query[$i]["dt_expedicao_rg"],
                    "uf_expedicao_rg" => $query[$i]["uf_expedicao_rg"],
                    "ds_titulo_eleitor" => $query[$i]["ds_titulo_eleitor"],
                    "ds_zona_eleitorial" => $query[$i]["ds_zona_eleitorial"],
                    "ds_secao" => $query[$i]["ds_secao"],
                    "ds_ctps" => $query[$i]["ds_ctps"],
                    "ds_serie_ctps" => $query[$i]["ds_serie_ctps"],
                    "ds_num_reservista" => $query[$i]["ds_num_reservista"],
                    "ds_num_cartao_sus" => $query[$i]["ds_num_cartao_sus"],
                    "ic_tipo_conta_bancaria" => $query[$i]["ic_tipo_conta_bancaria"],
                    "ds_agencia" => $query[$i]["ds_agencia"],
                    "ds_conta" => $query[$i]["ds_conta"],
                    "ds_digito" => $query[$i]["ds_digito"],
                    "banco_pk" => $query[$i]["banco_pk"],
                    "ds_pix" => $query[$i]["ds_pix"],
                    "ds_favorecido" => $query[$i]["ds_favorecido"],
                    "ds_cep" => $query[$i]["ds_cep"],
                    "ds_endereco" => $query[$i]["ds_endereco"],
                    "ds_numero" => $query[$i]["ds_numero"],
                    "ds_complemento" => $query[$i]["ds_complemento"],
                    "ds_bairro" => $query[$i]["ds_bairro"],
                    "ds_cidade" => $query[$i]["ds_cidade"],
                    "ds_uf" => $query[$i]["ds_uf"],
                    "ds_num_sapato" => $query[$i]["ds_num_sapato"],
                    "ds_num_camisa" => $query[$i]["ds_num_camisa"],
                    "ds_num_calca" => $query[$i]["ds_num_calca"],
                    "ds_pin" => $query[$i]["ds_pin"],
                    "grupos_pk" => $query[$i]["grupos_pk"],
                    "ds_imagem" => $img,

                    "t_functions" => ""
                );
            }
        }


        $retorno->data = $return;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarDataTable($pk,$grupos_leads_pk,$leads_pk,$ds_cpf,$cargo_pk,$ds_pin,$ic_status){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";
        if (isset($_GET['search']['value']) and $_GET['search']['value'] != '') {
            $pesq = $_GET['search']['value'];
            $search .= " AND (
                            c.ds_colaborador LIKE '%".$pesq."%' 
                        )";
        }

        $sql ="";
        $sql.="SELECT ";
        $sql.="                DISTINCT(c.pk),";
        $sql.="                c.ds_colaborador,";
        $sql.="                a.pk agenda_colaborador_pk,";
        $sql.="                l.pk leads_pk,";
        $sql.="                l.ds_lead,";
        $sql.="                ps.ds_produto_servico ds_funcao,";
        $sql.="                c.ds_pin,";
        $sql.="                CASE c.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.="        from colaboradores c";
        $sql.="        LEFT JOIN agenda_colaborador_padrao a on c.pk = a.colaboradores_pk";
        $sql.="        LEFT JOIN leads l on a.leads_pk = l.pk";
        $sql.="        LEFT JOIN colaboradores_produtos_servicos cps on c.pk = cps.colaboradores_pk";
        $sql.="        LEFT JOIN produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
        $sql.="        WHERE c.contas_pk =  ".$_SESSION['session_user']['contas_pk'];
        $sql.= $search;
        if($pk != ""){
            $sql.=" and c.pk = ".$pk;
        }
        if($grupos_leads_pk != ""){
            $sql.=" and c.grupos_pk = ".$grupos_leads_pk;
        }

        if($leads_pk != ""){
            $sql.=" and l.pk =".$leads_pk;
        }
        if($ic_status != ""){
            $sql.=" and c.ic_status =".$ic_status;
        }
        if($cargo_pk != ""){
            $sql.=" and ps.pk =".$cargo_pk;
        }
        if($ds_cpf != ""){
            $sql.=" and c.ds_cpf LIKE '%".$ds_cpf."%'" ;
        }
        if($ds_pin != ""){
            $sql.=" and c.ds_pin LIKE '%".$ds_pin."%'" ;
        }
        $sql.=" group by c.pk ";
        $sql.=" order by c.ds_colaborador asc ";




        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }

    public function listarGridFuncao($colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }

        if($colaborador_pk != ""){

            $sql ="";
            $sql.=" select cps.pk, ";
            $sql.=" ps.pk produtos_servicos_pk,";
            $sql.=" ps.ds_produto_servico";
            $sql.=" from colaboradores_produtos_servicos cps";
            $sql.=" inner join produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
            $sql.=" where 1=1 ";

            $sql.=" and cps.colaboradores_pk = ".$colaborador_pk;

            $stmt = $this->pdo->prepare( $sql.$lengthSql );
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmtCount = $this->pdo->prepare( $sql );
            $stmtCount->execute();
            $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

            $retorno->status = true;
            $retorno->message = 'Dados carregados com sucesso';
            $retorno->data = $rows;
            $retorno->iTotalDisplayRecords = count($rowsCount);
            $retorno->iTotalRecords = count($rowsCount);

        }
        else{
            $retorno->status = true;
            $retorno->message = 'Dados carregados com sucesso';
            $retorno->data = [];
            $retorno->iTotalDisplayRecords = 0;
            $retorno->iTotalRecords = 0;
        }




        echo json_encode($retorno);
        exit(0);
    }

    public function RelatorioDadosColaborador($pk,$ic_status){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select ";
        $sql.="        c.pk";
        $sql.="        ,c.ds_colaborador ";
        $sql.="        ,date_format(c.dt_nascimento,'%d/%m/%Y')dt_nascimento";
        $sql.="        ,c.ds_rg";
        $sql.="        ,c.ds_cpf";
        $sql.="        ,ct.ds_razao_social";
        $sql.="        ,c.contas_pk";
        $sql.="        ,case c.ic_regime_contratacao when 1 then 'Mensalista' when 2 then 'Horista' end ds_regime_contratacao";
        $sql.="        ,c.vl_salario";
        $sql.="        ,c.ds_endereco";
        $sql.="        ,c.ds_numero";
        $sql.="        ,c.ds_complemento";
        $sql.="        ,c.ds_bairro";
        $sql.="        ,c.ds_cep";
        $sql.="        ,c.ds_cidade";
        $sql.="        ,c.ds_uf";
        $sql.="        ,c.ds_pin";
        $sql.="  from colaboradores c ";
        $sql.="  inner join contas ct on ct.pk = c.contas_pk ";
        $sql.=" where 1=1 ";
        if($pk!=""){
            $sql.=" and c.pk =".$pk;
        }
        if(empty($ic_status)){
            $sql." and c.ic_statis =".$ic_status;

        }

        $sql.=" group by c.pk";
        $sql.=" order by c.ds_colaborador";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        for($i=0;$i<count($query);$i++){

            if($query[$i]['ds_endereco']==""){
                $ds_endereco = "";
            }
            else{
                $ds_endereco = $query[$i]['ds_endereco']." - ".$query[$i]['ds_numero'].", ".$query[$i]['ds_complemento']." / ".$query[$i]['ds_bairro']." / ".$query[$i]['ds_cidade']." - ".$query[$i]['ds_uf'];
            }

            $sqlItensGrupos ="";
            $sqlItensGrupos = "";
            $sqlItensGrupos.="select ";
            $sqlItensGrupos.="   ps.ds_produto_servico ";


            $sqlItensGrupos.="  from colaboradores_produtos_servicos c ";
            $sqlItensGrupos.="  inner join produtos_servicos ps on ps.pk = c.produtos_servicos_pk";
            $sqlItensGrupos.=" where 1=1 ";
            if($pk!=""){
                $sqlItensGrupos.=" and c.colaboradores_pk = ".$pk;
            }
            $sqlItensGrupos.=" group by c.colaboradores_pk";
            $stmt = $this->pdo->prepare( $sqlItensGrupos );
            $stmt->execute();
            $queryItens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if(count($queryItens) > 0){
                $ds_qualificacao = "";
                for($j = 0; $j < count($queryItens); $j++){
                    $ds_qualificacao = $queryItens[$j]['ds_produto_servico'].",";
                }
            }
            $result[] = array(
                "ds_colaborador" => $query[$i]["ds_colaborador"],
                "dt_nascimento"=>$query[$i]['dt_nascimento'],
                "ds_qualificacao"=>$ds_qualificacao,
                "ds_rg"=>$query[$i]['ds_rg'],
                "ds_cpf"=>$query[$i]['ds_cpf'],
                "ds_razao_social"=>$query[$i]['ds_razao_social'],
                "ds_regime_contratacao"=>$query[$i]['ds_regime_contratacao'],
                "vl_salario"=>$query[$i]['vl_salario'],
                "ds_pin"=>$query[$i]['ds_pin'],
                "ds_endereco"=>$ds_endereco
            );
        }

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $result;

        return $retorno;
    }

    public function listarDsPin($colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select c.pk";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_pin ";
        $sql.="  from colaboradores c";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and c.pk = ".$colaborador_pk;
        }
        $sql.=" order by c.ds_colaborador asc ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarColaboradoresQualificacao($ds_produtos_servicos, $colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql="";
        $sql.="SELECT c.pk, c.ds_colaborador";
        $sql.=" FROM colaboradores c";
        $sql.="     INNER JOIN colaboradores_produtos_servicos cps  ON c.pk = cps.colaboradores_pk";
        $sql.="     INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.=" WHERE ps.ds_produto_servico = '".$ds_produtos_servicos."'";
        $sql.="   AND c.pk NOT IN (".$colaborador_pk.")";
        $sql.="   AND c.ic_status = 1";
        $sql.=" GROUP BY c.pk";
        $sql.=" ORDER BY c.ds_colaborador ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarColaboradorLeadCalendario($leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $sql="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="  from colaboradores c";
        $sql.="     left join agenda_colaborador_padrao a on a.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and a.leads_pk = ".$leads_pk;
        }
        $sql.=" and a.dt_cancelamento is null";
        $sql.=" group by c.pk,a.colaboradores_pk";
        $sql.=" order by TRIM(c.ds_colaborador) asc";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarColaboradorFolha($empresas_pk, $leads_pk, $ic_escala){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql = "";
        $sql.=" SELECT c.pk colaborador_pk,";
        $sql.="        c.ds_colaborador,";
        $sql.="        prs.ds_produto_servico,";
        $sql.="         a.tipos_escalas_pk n_qtde_dias_semana,";
        $sql.="        a.hr_inicio_expediente,";
        $sql.="        a.hr_termino_expediente,";
        $sql.="        CASE WHEN c.ic_funcionario = 1 THEN 'Ativo' ELSE 'Desligado' END  ds_status_colaborador,";
        $sql.="        CASE WHEN a.dt_cancelamento IS NULL THEN 'Ativa' ELSE 'Cancelada' END  ds_status_escala,";
        $sql.="        date_format(a.dt_cancelamento,'%d/%m/%Y')dt_cancelamento,";
        $sql.="        date_format(a.dt_inicio_agenda,'%d/%m/%Y')dt_ini_escala,";
        $sql.="        date_format(a.dt_fim_agenda,'%d/%m/%Y')dt_fim_escala,";
        $sql.="        a.pk agenda_colaborador_padrao_pk";
        $sql.=" FROM colaboradores c";
        $sql.="      INNER JOIN agenda_colaborador_padrao a ON c.pk = a.colaboradores_pk";
        $sql.="      LEFT JOIN colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="      LEFT JOIN produtos_servicos prs ON cps.produtos_servicos_pk = prs.pk";
        $sql.=" WHERE 1 = 1";
        if($ic_escala == 1){
            $sql.=" and a.dt_cancelamento IS NULL";
        }else if($ic_escala == 2){
            $sql.=" and a.dt_cancelamento IS NOT NULL";
        }
        if(!empty($empresas_pk)){
            //$sql.=" AND ct.empresas_pk=".$empresas_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" AND a.leads_pk=".$leads_pk;
        }

        $sql.=" GROUP BY a.pk";
        $sql.=" ORDER BY c.ds_colaborador";
       
        

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarColaboradorLead($leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="  from colaboradores c";
        $sql.="     left join agenda_colaborador_padrao a on a.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and a.leads_pk = ".$leads_pk;
        }
        //$sql.=" and a.dt_cancelamento is null";
        $sql.=" group by c.pk,a.colaboradores_pk";
        $sql.=" order by TRIM(c.ds_colaborador) asc";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

}
