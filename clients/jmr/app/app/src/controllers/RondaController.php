<?php

namespace App\Controller;

use App\Model\Ronda;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class RondaController extends BaseController {


    public function relRondas(Request $request, Response $response, $args) {
        $data = [];
        try{
            $data = $request->getQueryParams();
            $leads_clientes_pk = isset($data['leads_clientes_pk']) ? trim((string) $data['leads_clientes_pk']) : "";
            $leads_pk = isset($data['leads_pk']) ? trim((string) $data['leads_pk']) : "";
            $dt_ini_ronda = isset($data['dt_ini_ronda']) ? trim((string) $data['dt_ini_ronda']) : "";
            $dt_fim_ronda = isset($data['dt_fim_ronda']) ? trim((string) $data['dt_fim_ronda']) : "";

            $retorno = (new Ronda($this->pdo))->relRondas($leads_pk, $leads_clientes_pk, $dt_ini_ronda, $dt_fim_ronda, $data);
            return $response->withJson($retorno, 200, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
        } catch (Throwable $th) {
            $draw = isset($data['draw']) ? (int) $data['draw'] : 0;
            return $response->withJson((object)[
                'status' => false,
                'message' => $th->getMessage(),
                'data' => [],
                'iTotalDisplayRecords' => 0,
                'iTotalRecords' => 0,
                'recordsFiltered' => 0,
                'recordsTotal' => 0,
                'draw' => $draw,
                'error' => $th->getMessage()
            ], 500, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
        }
    }

}
