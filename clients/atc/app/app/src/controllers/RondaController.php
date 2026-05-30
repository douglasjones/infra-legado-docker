<?php

namespace App\Controller;

use App\Utils\Json;
use App\Model\Ronda;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class RondaController extends BaseController {

    public function registrarForm(Request $request, Response $response, $args) {
        try {
            $data = $request->getQueryParams();
            $qrCodePk = isset($data['qr']) ? (int)$data['qr'] : 0;
            $ponto = null;
            $erro = '';

            if ($qrCodePk > 0) {
                $ponto = (new Ronda($this->pdo))->buscarPontoQrCode($qrCodePk);
            }

            if (!$ponto) {
                $erro = 'Ponto de ronda não encontrado.';
            }

            $this->view->render($response, 'ronda/registrar.twig', [
                'qr_code_pk' => $qrCodePk,
                'ponto' => $ponto,
                'erro' => $erro
            ]);

            return $response;
        } catch (Throwable $th) {
            return $response->withStatus(500)->write($th->getMessage());
        }
    }

    public function registrarLegado(Request $request, Response $response, $args) {
        try {
            $data = $request->getQueryParams();
            $posto = isset($data['posto']) ? trim($data['posto']) : '';
            $local = isset($data['local']) ? trim($data['local']) : '';
            $ponto = null;

            if ($posto !== '' && $local !== '') {
                $ponto = (new Ronda($this->pdo))->buscarPontoLegado($posto, $local);
            }

            if ($ponto) {
                return $response
                    ->withStatus(302)
                    ->withHeader('Location', '/ronda/registrar?qr=' . (int)$ponto['qr_code_pk']);
            }

            $this->view->render($response, 'ronda/registrar.twig', [
                'qr_code_pk' => 0,
                'ponto' => null,
                'erro' => 'Ponto de ronda não encontrado.'
            ]);

            return $response;
        } catch (Throwable $th) {
            return $response->withStatus(500)->write($th->getMessage());
        }
    }

    public function registrar(Request $request, Response $response, $args) {
        try {
            $data = $request->getParsedBody();
            $qrCodePk = isset($data['qr_code_pk']) ? (int)$data['qr_code_pk'] : 0;
            $dsRonda = isset($data['ds_ronda']) ? trim($data['ds_ronda']) : '';

            $retorno = (new Ronda($this->pdo))->registrar($qrCodePk, $dsRonda);
            json::run($retorno->status, $retorno->data, $retorno->message);

            return $response->withStatus($retorno->status ? 200 : 404)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            json::run(false, [], $th->getMessage());
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }


    public function relRondas(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_clientes_pk = isset($data['leads_clientes_pk'])? $data['leads_clientes_pk']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $dt_ini_ronda = isset($data['dt_ini_ronda'])? $data['dt_ini_ronda']: "";
            $dt_fim_ronda = isset($data['dt_fim_ronda'])? $data['dt_fim_ronda']: "";

            $retorno = (new Ronda($this->pdo))->relRondas($leads_pk,$leads_clientes_pk,$dt_ini_ronda,$dt_fim_ronda);
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

}
