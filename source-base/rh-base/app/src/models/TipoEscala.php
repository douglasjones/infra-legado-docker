<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class TipoEscala {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function listarTodos(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select t.pk, t.dt_cadastro,t.usuario_cadastro_pk, t.dt_ult_atualizacao, t.usuario_ult_atualizacao_pk ";
        $sql.="       ,t.ds_tipo_escala ";
        $sql.="  from tipos_escalas t ";
        $sql.=" where 1=1 ";
        $sql.=" and t.ic_status = 1 ";

        $sql.=" order by t.ds_tipo_escala asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

}
