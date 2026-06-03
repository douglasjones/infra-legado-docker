<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class Documento {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function excluir($pk){
        Util::execDelete('documentos'," pk = ".$pk,$this->pdo);
    }
    public function pegarDocumentoByPk($pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $sql ="";
        $sql.="select pk,docsType,docsData from documentos where pk = ".$pk;
       
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function salvarDocumento($files,$diretorio,$leads_pk,$ds_nome_documento,$colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio


        $arquivo = $files[0]["name"];
        $tamanho = $files[0]["size"];
        $tipo    = $files[0]["type"];
        $diretorioArquivo = $diretorio.trim($arquivo);

        $fp = fopen($diretorioArquivo, "rb");
        $imgData = fread($fp, $tamanho);
        $imgData = addslashes($imgData);
        fclose($fp);


        $fields = array();
        $fields['docsType'] = $tipo;
        $fields['docsData'] = $imgData;
        $fields['ds_documento'] = $ds_nome_documento;


        if($leads_pk!=0){
            $fields['leads_pk'] = $leads_pk;
            $fields['colaborador_pk'] = "";
        }
        else if($leads_pk=="" && $colaborador_pk==0){
            $fields['leads_pk'] = 0;
            $fields['colaborador_pk'] = "";
        }
        else if($colaborador_pk!=0){
            $fields['colaborador_pk'] = $colaborador_pk;
            $fields['leads_pk'] = "";
        }
        else if($colaborador_pk=="" && $leads_pk==0){
            $fields['colaborador_pk'] = 0;
            $fields['leads_pk'] = "";
        }
        $fields['contas_pk'] = $_SESSION['session_user']['contas_pk'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"]   = $_SESSION['session_user']['par1'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];


        $pk = Util::execInsert("documentos", $fields,$this->pdo);

        $retorno->status = true;
        $retorno->message = 'Dados cadastrados com sucesso';
        $retorno->data = $pk;

        return $retorno;
    }

    public function listarDocumentosLead($leads_pk){
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

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.=" ,d.ds_documento";
        $sql.=" from documentos d";
        $sql.=" where 1=1";
        $sql.=" and d.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        if($leads_pk != ""){
            $sql.=" and d.leads_pk = ".$leads_pk;
        }
        else{
            $sql.=" and d.leads_pk = 0";
        }
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
    public function listarDocumentosColaborador($colaborador_pk){
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

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.=" ,d.ds_documento";
        $sql.=" from documentos d";
        $sql.=" where 1=1";
        $sql.=" and d.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        if($colaborador_pk != ""){
            $sql.=" and d.colaborador_pk = ".$colaborador_pk;
        }
        else{
            $sql.=" and d.colaborador_pk = 0";
        }
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

}
