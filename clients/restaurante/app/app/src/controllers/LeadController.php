<?php

namespace App\Controller;

use App\Model\Lead;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class LeadController extends BaseController {
    public function receptivo(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $local = isset($data['local'])? $data['local']: "";
            $this->view->render($response, 'lead/lead_res_form.twig',array(
                "local"=>$local
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function excluirFuncao(Request $request, Response $response, $args)
    {
        try {
            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new Lead($this->pdo))->excluirFuncao($pk);
                Json::run(true, [], 'Registro excluido com sucesso!');
            }
            else{

                Json::run(false, [], 'Falha ao excluir registro!');
            }
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function excluir(Request $request, Response $response, $args)
    {
        try {
            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new Lead($this->pdo))->excluir($pk);
                Json::run(true, [], 'Registro excluido com sucesso!');
            }
            else{

                Json::run(false, [], 'Falha ao excluir registro!');
            }
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }


    public function salvar(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk']: "";
            $grupos_leads_pk = isset($data['grupos_leads_pk'])? $data['grupos_leads_pk']: "";
            $tipo_grupos_lead_pk = isset($data['tipo_grupos_lead_pk'])? $data['tipo_grupos_lead_pk']: "";
            $ds_lead = isset($data['ds_lead'])? $data['ds_lead']: "";
            $ds_razao_social = isset($data['ds_razao_social'])? $data['ds_razao_social']: "";
            $ds_cpf_cnpj = isset($data['ds_cpf_cnpj'])? $data['ds_cpf_cnpj']: "";
            $ds_cep = isset($data['ds_cep'])? $data['ds_cep']: "";
            $ds_endereco = isset($data['ds_endereco'])? $data['ds_endereco']: "";
            $ds_complemento = isset($data['ds_complemento'])? $data['ds_complemento']: "";
            $ds_numero = isset($data['ds_numero'])? $data['ds_numero']: "";
            $ds_bairro = isset($data['ds_bairro'])? $data['ds_bairro']: "";
            $ds_cidade = isset($data['ds_cidade'])? $data['ds_cidade']: "";
            $ds_uf = isset($data['ds_uf'])? $data['ds_uf']: "";
            $supervisor_pk = isset($data['supervisor_pk'])? $data['supervisor_pk']: "";
            $supervisor2_pk = isset($data['supervisor2_pk'])? $data['supervisor2_pk']: "";
            $ic_status = isset($data['ic_status'])? $data['ic_status']: "";
            $dt_ativacao = isset($data['dt_ativacao'])? $data['dt_ativacao']: "";
            $ds_tel = isset($data['ds_tel'])? $data['ds_tel']: "";
            $ds_cel = isset($data['ds_cel'])? $data['ds_cel']: "";
            $ds_lead_apelido = isset($data['ds_lead_apelido'])? $data['ds_lead_apelido']: "";

            $funcao_lead = isset($data['funcao_lead'])? $data['funcao_lead']: "";
            $arrFuncaoLead = [];
            $arrEscala = [];
            $arrDocs = [];
            if($funcao_lead != ""){
                $arrFuncaoLead = json_decode ($funcao_lead, true);
            }

            $escala_lead = isset($data['escala_lead'])? $data['escala_lead']: "";
            if($escala_lead != ""){
                $arrEscala = json_decode ($escala_lead, true);
            }

            $documento_lead = isset($data['documento_lead'])? $data['documento_lead']: "";
            if($documento_lead != ""){
                $arrDocs = json_decode ($documento_lead, true);
            }

            $lead = [
                "pk"=>$pk,
                "grupos_leads_pk"=>$grupos_leads_pk,
                "tipo_grupos_lead_pk"=>$tipo_grupos_lead_pk,
                "ds_lead"=>$ds_lead,
                "ds_razao_social"=>$ds_razao_social,
                "ds_cpf_cnpj"=>$ds_cpf_cnpj,
                "ds_cep"=>$ds_cep,
                "ds_endereco"=>$ds_endereco,
                "ds_complemento"=>$ds_complemento,
                "ds_numero"=>$ds_numero,
                "ds_bairro"=>$ds_bairro,
                "ds_cidade"=>$ds_cidade,
                "ds_uf"=>$ds_uf,
                "supervisor_pk"=>$supervisor_pk,
                "supervisor2_pk"=>$supervisor2_pk,
                "ic_status"=>$ic_status,
                "dt_ativacao"=>$dt_ativacao,
                "ds_tel"=>$ds_tel,
                "ds_lead_apelido"=>$ds_lead_apelido,
                "ds_cel"=>$ds_cel
            ];

            $retorno = (new Lead($this->pdo))->salvar($lead);
           
            if(count($arrFuncaoLead)>0){
                foreach($arrFuncaoLead as $v){
                    $funcao = [
                        "pk"=>$v['funcao_pk'],
                        "produtos_servicos_pk"=>$v['cargos_pk'],
                        "ic_status"=>$v['ic_status'],
                        "leads_pk"=>$retorno->data
                    ];
                    (new Lead($this->pdo))->salvarFuncaoLead($funcao);
                }
            }
            /*if(count($arrEscala)>0){
                foreach($arrEscala as $v){
                    $escala = [
                        "pk"=>$v['escala_pk'],
                        "leads_pk"=>$retorno->data
                    ];
                    (new Lead($this->pdo))->updateEscalaLead($escala);
                }
            }*/

            if(count($arrDocs)>0){
                if($arrDocs[0]['pk']!="Não existem Dados cadastrados"){
                  
                    foreach($arrDocs as $v){
                        $docs = [
                            "pk"=>$v['pk'],
                            "leads_pk"=>$retorno->data
                        ];
                        (new Lead($this->pdo))->updateDocsLead($docs);
                    }
                }
            }
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function salvarFuncao(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $funcao_pk = isset($data['funcao_pk'])? $data['funcao_pk']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk']: "";
            $ic_status = isset($data['ic_status'])? $data['ic_status']: "";
            $funcao = [
                "pk"=>$funcao_pk,
                "produtos_servicos_pk"=>$produtos_servicos_pk,
                "ic_status"=>$ic_status,
                "leads_pk"=>$leads_pk
            ];
            $retorno = (new Lead($this->pdo))->salvarFuncaoLead($funcao);


            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function cadForm(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $local = isset($data['local'])? $data['local']: "";
            $pk = isset($data['pk'])? $data['pk']: "";
            $this->view->render($response, 'lead/lead_cad_form.twig',array(
                "local"=>$local,
                "pk"=>$pk
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarTodos(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $entity = new Lead($this->pdo);
            $retorno = $entity->listarTodos();
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }
    public function listarPk(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $entity = new Lead($this->pdo);
            $retorno = $entity->listarPk($pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }
    public function listarLeadByGrupo(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $grupos_leads_pk = isset($data['grupos_leads_pk'])? $data['grupos_leads_pk'] : "";
            $entity = new Lead($this->pdo);
            $retorno = $entity->listarLeadByGrupo($grupos_leads_pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }

    public function listarDataTable(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $grupos_leads_pk = isset($data['grupos_leads_pk'])? $data['grupos_leads_pk'] : "";
            $supervisores_pk = isset($data['supervisores_pk'])? $data['supervisores_pk'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";

            (new Lead($this->pdo))->listarDataTable($leads_pk,$grupos_leads_pk,$supervisores_pk,$ic_status);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarGridFuncao(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";

            (new Lead($this->pdo))->listarGridFuncao($leads_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function verificarCNPJ(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $cpfcnpj = isset($data['ds_cpf_cnpj'])? $data['ds_cpf_cnpj'] : "";
            $retorno = (new Lead($this->pdo))->verificarCNPJ($cpfcnpj);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarLeadsPorEmpresa(Request $request, Response $response, $args) {
        
        try{
            $data = $request->getQueryParams();
            $empresas_pk = isset($data['empresas_pk'])? $data['empresas_pk'] : "";

            $retorno = (new Lead($this->pdo))->listarLeadsPorEmpresa($empresas_pk);
            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

}