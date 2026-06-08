<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class Ronda {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function relRondas($leads_pk,$leads_clientes_pk,$dt_ini_ronda,$dt_fim_ronda, $requestData = []){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $leads_clientes_pk = trim($leads_clientes_pk);
        $leads_pk = trim($leads_pk);

        $draw = isset($requestData['draw']) ? (int) $requestData['draw'] : 0;
        $start = isset($requestData['start']) ? max(0, (int) $requestData['start']) : 0;
        $length = isset($requestData['length']) ? (int) $requestData['length'] : 100;

        if ($length <= 0 || $length > 500) {
            $length = 100;
        }

        $fromSql  = " from ronda r";
        $fromSql .= " LEFT JOIN leads l ON r.leads_pk = l.ds_lead";
        $fromSql .= " LEFT JOIN leads ll ON l.leads_pai_pk = ll.pk";
        $fromSql .= " where 1=1";

        $params = [];

        if ($leads_clientes_pk !== "") {
            $fromSql .= " and (l.ds_lead LIKE :cliente OR ll.ds_lead LIKE :cliente)";
            $params[':cliente'] = '%' . $leads_clientes_pk . '%';
        }

        if ($leads_pk !== "") {
            $fromSql .= " and (l.ds_lead LIKE :lead OR ll.ds_lead LIKE :lead)";
            $params[':lead'] = '%' . $leads_pk . '%';
        }

        if ($dt_ini_ronda !== "" && $dt_fim_ronda !== "") {
            $fromSql .= " and r.dt_cadastro between :dt_ini and :dt_fim";
            $params[':dt_ini'] = Util::DataYMD($dt_ini_ronda) . " 00:00:00";
            $params[':dt_fim'] = Util::DataYMD($dt_fim_ronda) . " 23:59:59";
        }

        $countSql = "select count(*) total" . $fromSql;
        $stmtCount = $this->pdo->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();

        $sql  = "select";
        $sql .= "    COALESCE(ll.ds_lead, l.ds_lead, '') ds_cliente,";
        $sql .= "    COALESCE(r.leads_pk, '') ds_lead,";
        $sql .= "    COALESCE(r.local_ronda_pk, '') ds_local_ronda,";
        $sql .= "    date_format(r.dt_cadastro, '%d/%m/%Y') dt_ronda,";
        $sql .= "    date_format(r.dt_cadastro, '%H:%i:%s') hr_ronda,";
        $sql .= "    COALESCE(r.ds_ronda, '') ds_obs";
        $sql .= $fromSql;
        $sql .= " order by r.dt_cadastro desc";
        $sql .= " limit :limit offset :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $length, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $start, \PDO::PARAM_INT);
        $stmt->execute();

        $retorno->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso !';
        $retorno->iTotalDisplayRecords = $total;
        $retorno->iTotalRecords = $total;
        $retorno->recordsFiltered = $total;
        $retorno->recordsTotal = $total;
        $retorno->draw = $draw;

        return $retorno;
    }

}
