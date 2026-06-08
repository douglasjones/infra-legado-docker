<?php

namespace App\Model;

use App\Utils\Util;
use Throwable;

class Ronda {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function relRondas($leads_pk,$leads_clientes_pk,$dt_ini_ronda,$dt_fim_ronda, $requestData = []){
        $retorno = new \StdClass;
        $retorno->status = false;
        $retorno->message = 'Falha ao carregar dados';
        $retorno->data = [];
        $retorno->iTotalDisplayRecords = 0;
        $retorno->iTotalRecords = 0;
        $retorno->recordsFiltered = 0;
        $retorno->recordsTotal = 0;
        $retorno->draw = isset($requestData['draw']) ? (int) $requestData['draw'] : 0;

        try {
            $leads_clientes_pk = trim((string) $leads_clientes_pk);
            $leads_pk = trim((string) $leads_pk);
            $dt_ini_ronda = trim((string) $dt_ini_ronda);
            $dt_fim_ronda = trim((string) $dt_fim_ronda);

            $start = isset($requestData['start']) ? max(0, (int) $requestData['start']) : 0;
            $length = isset($requestData['length']) ? (int) $requestData['length'] : 10;

            if ($length <= 0 || $length > 500) {
                $length = 10;
            }

            $hasDateFilter = ($dt_ini_ronda !== "" && $dt_fim_ronda !== "");
            $hasClienteFilter = ctype_digit($leads_clientes_pk);
            $hasLeadFilter = ctype_digit($leads_pk);

            $paramsTotal = [];
            $whereTotal = " where 1=1";

            if ($hasDateFilter) {
                $whereTotal .= " and r.dt_cadastro between :dt_ini_total and :dt_fim_total";
                $paramsTotal[':dt_ini_total'] = Util::DataYMD($dt_ini_ronda) . " 00:00:00";
                $paramsTotal[':dt_fim_total'] = Util::DataYMD($dt_fim_ronda) . " 23:59:59";
            }

            $countTotalSql = "select count(*) from ronda r" . $whereTotal;
            $stmtTotal = $this->pdo->prepare($countTotalSql);
            $stmtTotal->execute($paramsTotal);
            $recordsTotal = (int) $stmtTotal->fetchColumn();

            $paramsFiltered = [];
            $whereFiltered = " where 1=1";

            if ($hasDateFilter) {
                $whereFiltered .= " and r.dt_cadastro between :dt_ini and :dt_fim";
                $paramsFiltered[':dt_ini'] = Util::DataYMD($dt_ini_ronda) . " 00:00:00";
                $paramsFiltered[':dt_fim'] = Util::DataYMD($dt_fim_ronda) . " 23:59:59";
            }

            if ($hasClienteFilter || $hasLeadFilter) {
                $filteredFromSql  = " from ronda r";
                $filteredFromSql .= " inner join leads l on r.leads_pk = l.ds_lead";
                $filteredFromSql .= " left join leads ll on l.leads_pai_pk = ll.pk";
                $filteredFromSql .= $whereFiltered;

                if ($hasClienteFilter) {
                    $filteredFromSql .= " and ll.pk = :cliente_pk";
                    $paramsFiltered[':cliente_pk'] = (int) $leads_clientes_pk;
                }

                if ($hasLeadFilter) {
                    $filteredFromSql .= " and l.pk = :lead_pk";
                    $paramsFiltered[':lead_pk'] = (int) $leads_pk;
                }

                $countFilteredSql = "select count(*)" . $filteredFromSql;
                $stmtFiltered = $this->pdo->prepare($countFilteredSql);
                $stmtFiltered->execute($paramsFiltered);
                $recordsFiltered = (int) $stmtFiltered->fetchColumn();

                $dataSql  = "select";
                $dataSql .= "    COALESCE(ll.ds_lead, l.ds_lead, '') ds_cliente,";
                $dataSql .= "    COALESCE(r.leads_pk, '') ds_lead,";
                $dataSql .= "    COALESCE(r.local_ronda_pk, '') ds_local_ronda,";
                $dataSql .= "    date_format(r.dt_cadastro, '%d/%m/%Y') dt_ronda,";
                $dataSql .= "    date_format(r.dt_cadastro, '%H:%i:%s') hr_ronda,";
                $dataSql .= "    COALESCE(r.ds_ronda, '') ds_obs";
                $dataSql .= $filteredFromSql;
                $dataSql .= " order by r.dt_cadastro desc";
                $dataSql .= " limit :limit offset :offset";

                $stmtData = $this->pdo->prepare($dataSql);
                foreach ($paramsFiltered as $key => $value) {
                    $stmtData->bindValue($key, $value);
                }
            } else {
                $recordsFiltered = $recordsTotal;

                $dataSql  = "select";
                $dataSql .= "    COALESCE(ll.ds_lead, l.ds_lead, '') ds_cliente,";
                $dataSql .= "    COALESCE(base.leads_pk, '') ds_lead,";
                $dataSql .= "    COALESCE(base.local_ronda_pk, '') ds_local_ronda,";
                $dataSql .= "    date_format(base.dt_cadastro, '%d/%m/%Y') dt_ronda,";
                $dataSql .= "    date_format(base.dt_cadastro, '%H:%i:%s') hr_ronda,";
                $dataSql .= "    COALESCE(base.ds_ronda, '') ds_obs";
                $dataSql .= " from (";
                $dataSql .= "    select r.leads_pk, r.local_ronda_pk, r.dt_cadastro, r.ds_ronda";
                $dataSql .= "    from ronda r";
                $dataSql .= $whereFiltered;
                $dataSql .= "    order by r.dt_cadastro desc";
                $dataSql .= "    limit :limit offset :offset";
                $dataSql .= " ) base";
                $dataSql .= " left join leads l on base.leads_pk = l.ds_lead";
                $dataSql .= " left join leads ll on l.leads_pai_pk = ll.pk";
                $dataSql .= " order by base.dt_cadastro desc";

                $stmtData = $this->pdo->prepare($dataSql);
                foreach ($paramsFiltered as $key => $value) {
                    $stmtData->bindValue($key, $value);
                }
            }

            $stmtData->bindValue(':limit', $length, \PDO::PARAM_INT);
            $stmtData->bindValue(':offset', $start, \PDO::PARAM_INT);
            $stmtData->execute();

            while ($row = $stmtData->fetch(\PDO::FETCH_ASSOC)) {
                $retorno->data[] = $row;
            }

            $retorno->status = true;
            $retorno->message = 'Dados carregados com sucesso !';
            $retorno->iTotalDisplayRecords = $recordsFiltered;
            $retorno->iTotalRecords = $recordsTotal;
            $retorno->recordsFiltered = $recordsFiltered;
            $retorno->recordsTotal = $recordsTotal;

            return $retorno;
        } catch (Throwable $th) {
            $retorno->message = $th->getMessage();
            return $retorno;
        }
    }

}
