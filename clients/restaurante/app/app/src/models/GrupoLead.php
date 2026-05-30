<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class GrupoLead {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function listarTodos(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.=" select g.pk,
                       g.ds_grupo_leads
                from grupos_leads g 
                inner join tipos_grupos_leads tgl on g.tipos_grupos_lead_pk = tgl.pk ";
        $sql.=" order by ds_grupo_leads asc ";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;

        return $retorno;
    }
}
