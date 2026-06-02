<?php

namespace App\Controller;

use App\Model\Log;
use App\Model\RelatorioComercial;
use App\Utils\Json;
use App\Utils\Session;
use App\Utils\Util;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Utils\SlimImage;
use App\Utils\SlimStatus;
use Throwable;

final class RelatorioController extends BaseController {

    //OPERACIONAL
    public function operacional(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'relatorio/operacional/menu_relatorio_operacional.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function pesqAcompanhamentoPontoSintetico(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'relatorio/operacional/rel_acompanhamento_ponto_sintetico_pesq.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function resAcompanhamentoPontoSintetico(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $ic_cliente = isset($data['ic_cliente'])? $data['ic_cliente'] : "";
            $ds_cliente = isset($data['ds_cliente'])? $data['ds_cliente'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $ds_lead = isset($data['ds_lead'])? $data['ds_lead'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $ds_colaborador = isset($data['ds_colaborador'])? $data['ds_colaborador'] : "";
            $ds_periodo = isset($data['ds_periodo'])? $data['ds_periodo'] : "";

            $aux = explode('-', $ds_periodo);
            $dt_periodo_ini = trim($aux[0]);
            $dt_periodo_fim = trim($aux[1])  ;
            $this->view->render($response, 'relatorio/operacional/rel_acompanhamento_ponto_sintetico_res.twig',
                array(
                    "ic_cliente"=>$ic_cliente,
                    "ds_cliente"=>$ds_cliente,
                    "leads_pk"=>$leads_pk,
                    "ds_lead"=>$ds_lead,
                    "colaborador_pk"=>$colaborador_pk,
                    "ds_colaborador"=>$ds_colaborador,
                    "ds_periodo"=>$ds_periodo,
                    "dt_periodo_ini"=>$dt_periodo_ini,
                    "dt_periodo_fim"=>$dt_periodo_fim
                ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function pesqAcompanhamentoPontoAnalitico(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'relatorio/operacional/rel_acompanhamento_ponto_analitico_pesq.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function resAcompanhamentoPontoAnalitico(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $ic_cliente = isset($data['ic_cliente'])? $data['ic_cliente'] : "";
            $ds_cliente = isset($data['ds_cliente'])? $data['ds_cliente'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $ds_lead = isset($data['ds_lead'])? $data['ds_lead'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $ds_colaborador = isset($data['ds_colaborador'])? $data['ds_colaborador'] : "";
            $ds_periodo = isset($data['ds_periodo'])? $data['ds_periodo'] : "";

            $aux = explode('-', $ds_periodo);
            $dt_periodo_ini = trim($aux[0]);
            $dt_periodo_fim = trim($aux[1])  ;
            $this->view->render($response, 'relatorio/operacional/rel_acompanhamento_ponto_analitico_res.twig',
                array(
                    "ic_cliente"=>$ic_cliente,
                    "ds_cliente"=>$ds_cliente,
                    "leads_pk"=>$leads_pk,
                    "ds_lead"=>$ds_lead,
                    "colaborador_pk"=>$colaborador_pk,
                    "ds_colaborador"=>$ds_colaborador,
                    "ds_periodo"=>$ds_periodo,
                    "dt_periodo_ini"=>$dt_periodo_ini,
                    "dt_periodo_fim"=>$dt_periodo_fim
                ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function pesqColaboradorApontamento(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'relatorio/rel_colaborador_apontamento_pesq.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function resColaboradorApontamento(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk']: "";
            $ds_colaborador = isset($data['ds_colaborador'])? $data['ds_colaborador']: "";
            $ds_tipo_apontamento = isset($data['ds_tipo_apontamento'])? $data['ds_tipo_apontamento']: "";
            $tipo_apontamento_pk = isset($data['tipo_apontamento_pk'])? $data['tipo_apontamento_pk']: "";
            $dt_apontamento_ini = isset($data['dt_apontamento_ini'])? $data['dt_apontamento_ini']: "";
            $dt_apontamento_fim = isset($data['dt_apontamento_fim'])? $data['dt_apontamento_fim']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $ds_lead = isset($data['ds_lead'])? $data['ds_lead']: "";

            $this->view->render($response, 'relatorio/rel_colaborador_apontamento_res.twig',array(
                "colaborador_pk"=>$colaborador_pk,
                "ds_colaborador" =>$ds_colaborador,
                "ds_tipo_apontamento" =>$ds_tipo_apontamento,
                "tipo_apontamento_pk" =>$tipo_apontamento_pk,
                "dt_apontamento_ini" =>$dt_apontamento_ini,
                "dt_apontamento_fim" =>$dt_apontamento_fim,
                "leads_pk" =>$leads_pk,
                "ds_lead" =>$ds_lead
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function pesqRondas(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'relatorio/operacional/rel_rondas_pesq.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function receptivoRondas(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $leads_clientes_pk = isset($data['leads_clientes_pk'])? $data['leads_clientes_pk']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $dt_ini_ronda = isset($data['dt_ini_ronda'])? $data['dt_ini_ronda']: "";
            $dt_fim_ronda = isset($data['dt_fim_ronda'])? $data['dt_fim_ronda']: "";
            $ds_lead = isset($data['ds_lead'])? $data['ds_lead']: "";
            $ds_lead_clientes = isset($data['ds_lead_clientes'])? $data['ds_lead_clientes']: "";
            
            $this->view->render($response, 'relatorio/operacional/rel_rondas_res.twig',array(
                "leads_clientes_pk" =>$leads_clientes_pk,
                "leads_pk" =>$leads_pk,
                "dt_ini_ronda" =>$dt_ini_ronda,
                "dt_fim_ronda" =>$dt_fim_ronda,
                "ds_lead" =>$ds_lead,
                "ds_lead_clientes" =>$ds_lead_clientes
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
}
