<?php

namespace App\Controller;

use App\Model\WebPontoWhatsApp;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class WebPontoWhatsAppController extends BaseController {


    public function webPontoWhatsApp(Request $request, Response $response, $args){
        try{

            $data = (object)$request->getParsedBody();

            
          
            $webPontoWhatsApp = new WebPontoWhatsApp($this->pdo);

            $from = $data->from;
            $textoRecebido = $data->texto_recebido;
            $telRecebido = $data->telRecebido;
            $tipoMensagem = $data->tipoMensagem;
            $ds_link = $data->ds_link;
            $latitude = $data->latitude;
            $longitude = $data->longitude;
            $phone_number_id = $data->phone_number_id;

            
            $query = $webPontoWhatsApp->tratarMensagem($from,$textoRecebido,$telRecebido,$tipoMensagem,$ds_link,$latitude,$longitude,$phone_number_id);
            

            $json_data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
            echo $json_data;
            die();

        } catch (Throwable $th) {
            print_r($th->getMessage());
            die();
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

}
