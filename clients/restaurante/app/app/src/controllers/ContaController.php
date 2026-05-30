<?php

namespace App\Controller;

use App\Model\Conta;
use App\Utils\Util;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class ContaController extends BaseController {

    public function receptivo(Request $request, Response $response, $args){
        try{
            $this->view->render($response, 'conta/conta_res.twig');
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
                (new Conta($this->pdo))->excluir($pk);
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
    public function salvar(Request $request, Response $response, $args) {
        try{
            
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $ds_tipo_pessoa = isset($data['ds_tipo_pessoa'])? $data['ds_tipo_pessoa'] : "";
            $ds_conta = isset($data['ds_conta'])? $data['ds_conta'] : "";
            $ds_razao_social = isset($data['ds_razao_social'])? $data['ds_razao_social'] : "";
            $ds_cpf_cnpj = isset($data['ds_cpf_cnpj'])? $data['ds_cpf_cnpj'] : "";
            $ds_tel = isset($data['ds_tel'])? $data['ds_tel'] : "";
            $ds_cel = isset($data['ds_cel'])? $data['ds_cel'] : "";
            $ds_cep = isset($data['ds_cep'])? $data['ds_cep'] : "";
            $ds_endereco = isset($data['ds_endereco'])? $data['ds_endereco'] : "";
            $ds_numero = isset($data['ds_numero'])? $data['ds_numero'] : "";
            $ds_complemento = isset($data['ds_complemento'])? $data['ds_complemento'] : "";
            $ds_bairro = isset($data['ds_bairro'])? $data['ds_bairro'] : "";
            $ds_cidade = isset($data['ds_cidade'])? $data['ds_cidade'] : "";
            $ds_uf = isset($data['ds_uf'])? $data['ds_uf'] : "";
            $dt_ativacao = isset($data['dt_ativacao'])? $data['dt_ativacao'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";
            $ic_tipo_faturamento = isset($data['ic_tipo_faturamento'])? $data['ic_tipo_faturamento'] : "";
            $ic_dia_faturamento = isset($data['ic_dia_faturamento'])? $data['ic_dia_faturamento'] : "";
            $ic_tipo_conta = isset($data['ic_tipo_conta'])? $data['ic_tipo_conta'] : "";
            $ic_tipo_segmento = isset($data['ic_tipo_segmento'])? $data['ic_tipo_segmento'] : "";


            $conta =[
                "pk"=>$pk,
                "ds_tipo_pessoa"=>$ds_tipo_pessoa,
                "ds_conta"=>$ds_conta,
                "ds_razao_social"=>$ds_razao_social,
                "ds_cpf_cnpj"=>$ds_cpf_cnpj,
                "ds_tel"=>$ds_tel,
                "ds_cel"=>$ds_cel,
                "ds_cep"=>$ds_cep,
                "ds_endereco"=>$ds_endereco,
                "ds_numero"=>$ds_numero,
                "ds_complemento"=>$ds_complemento,
                "ds_bairro"=>$ds_bairro,
                "ds_cidade"=>$ds_cidade,
                "ds_uf"=>$ds_uf,
                "dt_ativacao"=>$dt_ativacao,
                "ic_status"=>$ic_status,
                "ic_tipo_faturamento"=>$ic_tipo_faturamento,
                "ic_dia_faturamento"=>$ic_dia_faturamento,
                "ic_tipo_conta"=>$ic_tipo_conta,
                "ic_tipo_segmento"=>$ic_tipo_segmento,
            ];

            $retorno = (new Conta($this->pdo))->salvar($conta);

            Json::run($retorno->status, $retorno->data, $retorno->message);
        
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }
    public function listarDataTable(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();

            $ic_tipo_lead = isset($data['ic_tipo_lead'])? $data['ic_tipo_lead'] : "";
            $ds_conta = isset($data['ds_conta'])? $data['ds_conta'] : "";
            $ds_razao_social = isset($data['ds_razao_social'])? $data['ds_razao_social'] : "";
            $ds_cpf_cnpj = isset($data['ds_cpf_cnpj'])? $data['ds_cpf_cnpj'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";

            (new Conta($this->pdo))->listar_por_ds_conta($ic_tipo_lead, $ds_conta, $ds_razao_social, $ds_cpf_cnpj, $ic_status);

            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarPk(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $entity = new Conta($this->pdo);
            $retorno = $entity->listarPorPk($pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }
    public function editarConta(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";

            $this->view->render($response, 'conta/conta_cad.twig',array(
                    'pk'=>$pk
                )
            );
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarTodos(Request $request, Response $response, $args) {
        try{
            $entity = new Conta($this->pdo);
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