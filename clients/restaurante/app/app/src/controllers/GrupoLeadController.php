<?php

namespace App\Controller;

use App\Model\GrupoLead;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class GrupoLeadController extends BaseController {
    public function listarTodos(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $entity = new GrupoLead($this->pdo);
            $retorno = $entity->listarTodos();
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }
}