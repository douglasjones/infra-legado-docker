<?php

namespace App\Controller;

use App\Model\Log;
use App\Model\Empresa;
use App\Model\Lead;
use App\Model\PontoFolha;
use App\Utils\Json;
use App\Utils\Session;
use App\Utils\Util;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Utils\SlimImage;
use App\Utils\SlimStatus;
use Throwable;

final class PontoFolhaController extends BaseController {

    public function receptivoPontoFolha(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'ponto_folha/ponto_folha_res_form.twig');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function registrosCad(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $pk = isset($data['pk'])? $data['pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            $this->view->render($response, 'ponto_folha/ponto_folha_registros_cad_form.twig',array('pk'=>$pk, 'leads_pk'=>$leads_pk, 'colaborador_pk'=>$colaborador_pk));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function receptivoPrint(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $pk = isset($data['pk'])? $data['pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            $this->view->render($response, 'ponto_folha/ponto_folha_print_form.twig',array('pk'=>$pk, 'leads_pk'=>$leads_pk, 'colaborador_pk'=>$colaborador_pk));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }


    public function colaboradoresCad(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $pk = isset($data['pk'])? $data['pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            $this->view->render($response, 'ponto_folha/ponto_folha_registros_res_form.twig',array('pk'=>$pk, 'leads_pk'=>$leads_pk, 'colaborador_pk'=>$colaborador_pk));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function cadForm(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $pk = isset($data['pk'])? $data['pk'] : "";
            $this->view->render($response, 'ponto_folha/ponto_folha_cad_form.twig',array('pk'=>$pk));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function salvar(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $empresas_pk = isset($data['empresas_pk'])? $data['empresas_pk']: "";
            $dt_periodo_ini = isset($data['dt_periodo_ini'])? $data['dt_periodo_ini']: "";
            $dt_periodo_fim = isset($data['dt_periodo_fim'])? $data['dt_periodo_fim']: "";
            $obs = isset($data['obs'])? $data['obs']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $arrColaborador = isset($data['arrColaborador'])? $data['arrColaborador']: "";

            $pontoFolha = [
                "pk"=>"",
                "empresas_pk"=>$empresas_pk,
                "dt_periodo_ini"=>$dt_periodo_ini,
                "dt_periodo_fim"=>$dt_periodo_fim,
                "obs"=>$obs,
                "arrColaborador"=>$arrColaborador,
                "leads_pk"=>$leads_pk
            ];


            $retorno = (new PontoFolha($this->pdo))->salvar($pontoFolha);


            Json::run($retorno->status,$retorno->data,$retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function regerar(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $pk = isset($data['pk'])? $data['pk']: "";
            $dt_periodo_ini = isset($data['dt_periodo_ini'])? $data['dt_periodo_ini']: "";
            $dt_periodo_fim = isset($data['dt_periodo_fim'])? $data['dt_periodo_fim']: "";
            $arrColaborador = isset($data['arrColaborador'])? $data['arrColaborador']: "";

            $retorno = (new PontoFolha($this->pdo))->regerar($pk, $dt_periodo_ini, $dt_periodo_fim,$arrColaborador);

            Json::run($retorno->status,$retorno->data,$retorno->message);
        } catch (Throwable $th) {
            print_r($th->getMessage());
            die();
        }
    }
    public function salvarFolhaFinalizada(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();

            $ic_status = isset($data['ic_status'])? $data['ic_status']: "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk']: "";
            $pk = isset($data['pk'])? $data['pk']: "";

            $pontoFolhaFinalizada = [
                "ic_status"=>$ic_status,
                "colaborador_pk"=>$colaborador_pk,
                "pk"=>$pk
            ];

            $retorno = (new PontoFolha($this->pdo))->salvarFolhaFinalizada($pontoFolhaFinalizada);
            Json::run($retorno->status,$retorno->data,$retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function salvarRegistros(Request $request, Response $response, $args){
        try{
            $data = $request->getParsedBody();

            $arrDadosRegistros = isset($data['arrDadosRegistros'])? $data['arrDadosRegistros']: "";

            $retorno = (new PontoFolha($this->pdo))->salvarRegistros($arrDadosRegistros);

            Json::run($retorno->status,$retorno->data,$retorno->message);
        } catch (Throwable $th) {
           print_r($th->getMessage());
           die();
        }
    }

    public function listarGrid(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $empresas_pk = isset($data['empresas_pk'])? $data['empresas_pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $dt_periodo_ini = isset($data['dt_periodo_ini'])? $data['dt_periodo_ini'] : "";
            $dt_periodo_fim = isset($data['dt_periodo_fim'])? $data['dt_periodo_fim'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";

            $retorno = (new PontoFolha($this->pdo))->listarGrid($empresas_pk,$leads_pk,$colaborador_pk,$dt_periodo_ini, $dt_periodo_fim, $ic_status);
            
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarDadosImpressao(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $ponto_folha_pk = isset($data['ponto_folha_pk'])? $data['ponto_folha_pk'] : "";

            $retorno = (new PontoFolha($this->pdo))->listarDadosImpressao($leads_pk, $colaborador_pk, $ponto_folha_pk);
            
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarPontoFolhaPK(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $ponto_folha_pk = isset($data['ponto_folha_pk'])? $data['ponto_folha_pk'] : "";

            $retorno = (new PontoFolha($this->pdo))->listarPontoFolhaPK($ponto_folha_pk);
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarFolhasRegistros(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";

            $retorno = (new PontoFolha($this->pdo))->listarFolhasRegistros($pk);
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarRegistros(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            $retorno = (new PontoFolha($this->pdo))->listarRegistros($pk, $leads_pk, $colaborador_pk);
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }


    public function listarConsultaPontoColaborador(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $agenda_colaborador_padrao_pk = isset($data['agenda_colaborador_pk'])? $data['agenda_colaborador_pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $ic_mes = isset($data['ic_mes'])? $data['ic_mes'] : "";
            $ic_ano = isset($data['ic_ano'])? $data['ic_ano'] : "";
            $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $ic_mes, $ic_ano);

            $dt_periodo_ini = $ic_ano."-".$ic_mes."-01";
            $dt_periodo_fim = $ic_ano."-".$ic_mes."-".$ultimoDiaMes;

            $retorno = (new PontoFolha($this->pdo))->listarConsultaPontoColaborador($leads_pk, $colaborador_pk, $dt_periodo_ini,$dt_periodo_fim,$agenda_colaborador_padrao_pk);
            
            json::run(true,$retorno,"Carregado com sucesso!");
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }


    public function excluir(Request $request, Response $response, $args)
    {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";

            if($pk!=""){
                
                (new PontoFolha($this->pdo))->excluir($pk);
                Json::run(true, [], 'Registro excluído com sucesso!');
            }else{
                Json::run(false, [], 'Falha ao excluir registro!');
            }
        }catch(Throwable $th){
            print_r($th->getMessage());
            die();
            return $response->withJson((object)[
                'error'=>$th->getMessage()
            ],500,[]);
        }
    }

}
