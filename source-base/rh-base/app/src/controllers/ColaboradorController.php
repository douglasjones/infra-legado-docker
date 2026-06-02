<?php

namespace App\Controller;

use App\Model\Colaborador;
use App\Model\Conta;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class ColaboradorController extends BaseController {
    public function listarTodosByFuncaoPk(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $produtos_servicos = isset($data['produtos_servicos'])? $data['produtos_servicos'] : "";
            $entity = new Colaborador($this->pdo);
            $retorno = $entity->listarTodosByFuncaoPk($produtos_servicos);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }

    public function cadForm(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $local = isset($data['local'])? $data['local']: "";
            $pk = isset($data['pk'])? $data['pk']: "";
            $this->view->render($response, 'colaborador/colaborador_cad_form.twig',array(
                "local"=>$local,
                "pk"=>$pk
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarGridFuncao(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            (new Colaborador($this->pdo))->listarGridFuncao($colaborador_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function excluirFuncao(Request $request, Response $response, $args) {

        try{

            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new Colaborador($this->pdo))->excluirFuncao($pk);
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
    public function excluir(Request $request, Response $response, $args) {

        try{

            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new Colaborador($this->pdo))->excluir($pk);
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

            $arrFuncao = [];
            $arrEscala = [];
            $arrDocs = [];

            $pk = isset($data['pk'])? $data['pk'] : "";
            $ds_colaborador = isset($data['ds_colaborador'])? $data['ds_colaborador'] : "";
            $ds_nacionalidade = isset($data['ds_nacionalidade'])? $data['ds_nacionalidade'] : "";
            $ic_genero = isset($data['ic_genero'])? $data['ic_genero'] : "";
            $dt_nascimento = isset($data['dt_nascimento'])? $data['dt_nascimento'] : "";
            $ds_nome_pai = isset($data['ds_nome_pai'])? $data['ds_nome_pai'] : "";
            $ds_nome_mae = isset($data['ds_nome_mae'])? $data['ds_nome_mae'] : "";
            $ic_regime_contratacao = isset($data['ic_regime_contratacao'])? $data['ic_regime_contratacao'] : "";
            $ds_carga_horaria_mensal = isset($data['ds_carga_horaria_mensal'])? $data['ds_carga_horaria_mensal'] : "";
            $vl_salario = isset($data['vl_salario'])? $data['vl_salario'] : "";
            $ds_matricula = isset($data['ds_matricula'])? $data['ds_matricula'] : "";
            $ds_e_social = isset($data['ds_e_social'])? $data['ds_e_social'] : "";
            $ic_funcionario = isset($data['ic_funcionario'])? $data['ic_funcionario'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";
            $ds_cpf = isset($data['ds_cpf'])? $data['ds_cpf'] : "";
            $ds_rg = isset($data['ds_rg'])? $data['ds_rg'] : "";
            $ds_orgao_expedicao_rg = isset($data['ds_orgao_expedicao_rg'])? $data['ds_orgao_expedicao_rg'] : "";
            $dt_expedicao_rg = isset($data['dt_expedicao_rg'])? $data['dt_expedicao_rg'] : "";
            $uf_expedicao_rg = isset($data['uf_expedicao_rg'])? $data['uf_expedicao_rg'] : "";
            $ds_titulo_eleitor = isset($data['ds_titulo_eleitor'])? $data['ds_titulo_eleitor'] : "";
            $ds_zona_eleitorial = isset($data['ds_zona_eleitorial'])? $data['ds_zona_eleitorial'] : "";
            $ds_secao = isset($data['ds_secao'])? $data['ds_secao'] : "";
            $ds_ctps = isset($data['ds_ctps'])? $data['ds_ctps'] : "";
            $ds_serie_ctps = isset($data['ds_serie_ctps'])? $data['ds_serie_ctps'] : "";
            $ds_num_reservista = isset($data['ds_num_reservista'])? $data['ds_num_reservista'] : "";
            $ds_num_cartao_sus = isset($data['ds_num_cartao_sus'])? $data['ds_num_cartao_sus'] : "";
            $ic_tipo_conta_bancaria = isset($data['ic_tipo_conta_bancaria'])? $data['ic_tipo_conta_bancaria'] : "";
            $banco_pk = isset($data['banco_pk'])? $data['banco_pk'] : "";
            $ds_agencia = isset($data['ds_agencia'])? $data['ds_agencia'] : "";
            $ds_conta = isset($data['ds_conta'])? $data['ds_conta'] : "";
            $ds_digito = isset($data['ds_digito'])? $data['ds_digito'] : "";
            $ds_pix = isset($data['ds_pix'])? $data['ds_pix'] : "";
            $ds_favorecido = isset($data['ds_favorecido'])? $data['ds_favorecido'] : "";
            $ds_cep = isset($data['ds_cep'])? $data['ds_cep'] : "";
            $ds_endereco = isset($data['ds_endereco'])? $data['ds_endereco'] : "";
            $ds_numero = isset($data['ds_numero'])? $data['ds_numero'] : "";
            $ds_complemento = isset($data['ds_complemento'])? $data['ds_complemento'] : "";
            $ds_bairro = isset($data['ds_bairro'])? $data['ds_bairro'] : "";
            $ds_cidade = isset($data['ds_cidade'])? $data['ds_cidade'] : "";
            $ds_uf = isset($data['ds_uf'])? $data['ds_uf'] : "";
            $ds_num_sapato = isset($data['ds_num_sapato'])? $data['ds_num_sapato'] : "";
            $ds_num_camisa = isset($data['ds_num_camisa'])? $data['ds_num_camisa'] : "";
            $ds_num_calca = isset($data['ds_num_calca'])? $data['ds_num_calca'] : "";
            $grupos_pk = isset($data['grupos_pk'])? $data['grupos_pk'] : "";
            $ds_cel = isset($data['ds_cel']) ? $data['ds_cel'] : "";
            
            $funcao_colaborador = isset($data['funcao_colaborador'])? $data['funcao_colaborador'] : "";
            if($funcao_colaborador != ""){
                $arrFuncao = json_decode ($funcao_colaborador, true);
            }
            $escala_colaborador = isset($data['escala_colaborador'])? $data['escala_colaborador'] : "";
            if($escala_colaborador != ""){
                $arrEscala = json_decode ($escala_colaborador, true);
            }
            $documento_colaborador = isset($data['documento_colaborador'])? $data['documento_colaborador'] : "";
            if($documento_colaborador != ""){
                $arrDocs = json_decode ($documento_colaborador, true);
            }


            $colaborador=[
              "pk"=>$pk,
              "ds_colaborador"=>$ds_colaborador,
              "ds_nacionalidade"=>$ds_nacionalidade,
              "ic_genero"=>$ic_genero,
              "dt_nascimento"=>$dt_nascimento,
              "ds_nome_pai"=>$ds_nome_pai,
              "ds_nome_mae"=>$ds_nome_mae,
              "ic_regime_contratacao"=>$ic_regime_contratacao,
              "ds_carga_horaria_mensal"=>$ds_carga_horaria_mensal,
              "vl_salario"=>$vl_salario,
              "ds_matricula"=>$ds_matricula,
              "ds_e_social"=>$ds_e_social,
              "ic_funcionario"=>$ic_funcionario,
              "ic_status"=>$ic_status,
              "ds_cpf"=>$ds_cpf,
              "ds_rg"=>$ds_rg,
              "ds_orgao_expedicao_rg"=>$ds_orgao_expedicao_rg,
              "dt_expedicao_rg"=>$dt_expedicao_rg,
              "uf_expedicao_rg"=>$uf_expedicao_rg,
              "ds_titulo_eleitor"=>$ds_titulo_eleitor,
              "ds_zona_eleitorial"=>$ds_zona_eleitorial,
              "ds_secao"=>$ds_secao,
              "ds_ctps"=>$ds_ctps,
              "ds_serie_ctps"=>$ds_serie_ctps,
              "ds_num_reservista"=>$ds_num_reservista,
              "ds_num_cartao_sus"=>$ds_num_cartao_sus,
              "ic_tipo_conta_bancaria"=>$ic_tipo_conta_bancaria,
              "banco_pk"=>$banco_pk,
              "ds_agencia"=>$ds_agencia,
              "ds_conta"=>$ds_conta,
              "ds_digito"=>$ds_digito,
              "ds_pix"=>$ds_pix,
              "ds_favorecido"=>$ds_favorecido,
              "ds_cep"=>$ds_cep,
              "ds_endereco"=>$ds_endereco,
              "ds_numero"=>$ds_numero,
              "ds_complemento"=>$ds_complemento,
              "ds_bairro"=>$ds_bairro,
              "ds_cidade"=>$ds_cidade,
              "ds_uf"=>$ds_uf,
              "ds_num_sapato"=>$ds_num_sapato,
              "ds_num_camisa"=>$ds_num_camisa,
              "grupos_pk"=>$grupos_pk,
              "ds_cel"=>$ds_cel,
              "ds_num_calca"=>$ds_num_calca
            ];
            $retorno = (new Colaborador($this->pdo))->salvar($colaborador);
            //(new Colaborador($this->pdo))->verificarColaboradorAtivoParaBaseWebPonto($retorno->data);
            (new Colaborador($this->pdo))->salvarDSPin($retorno->data);

            if(count($arrFuncao)>0){
                foreach($arrFuncao as $v){
                    if($v['cargos_pk']!="undefined"){
                        $funcao = [
                            "pk"=>"",
                            "produtos_servicos_pk"=>$v['cargos_pk'],
                            "colaboradores_pk"=>$retorno->data
                        ];
                        (new Colaborador($this->pdo))->salvarFuncao($funcao);
                    }
                   
                }
            }
          
            if(count($arrEscala)>0){
                foreach($arrEscala as $v){
                    $escala = [
                        "pk"=>$v['escala_pk'],
                        "colaboradores_pk"=>$retorno->data
                    ];
                    (new Colaborador($this->pdo))->updateEscala($escala);
                }
            }
            if(count($arrDocs)>0){
                if($arrDocs[0]['pk']!="Não existem Dados cadastrados" ){
                    if($arrDocs[0]['pk']!="NÃ£o existem Dados cadastrados"){
                        foreach($arrDocs as $v){
                            $docs = [
                                "pk"=>$v['pk'],
                                "colaborador_pk"=>$retorno->data
                            ];
                            (new Colaborador($this->pdo))->updateDocs($docs);
                        }
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
            $pk = isset($data['pk'])? $data['pk']: "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk']: "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk']: "";
            $funcao = [
                "pk"=>$pk,
                "produtos_servicos_pk"=>$produtos_servicos_pk,
                "colaboradores_pk"=>$colaborador_pk
            ];
            $retorno = (new Colaborador($this->pdo))->salvarFuncao($funcao);


            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function receptivo(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $local = isset($data['local'])? $data['local']: "";
            $this->view->render($response, 'colaborador/colaborador_res_form.twig',array(
                "local"=>$local
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarDataTable(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $grupos_leads_pk = isset($data['grupos_leads_pk'])? $data['grupos_leads_pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $ds_cpf = isset($data['ds_cpf'])? $data['ds_cpf'] : "";
            $cargo_pk = isset($data['cargo_pk'])? $data['cargo_pk'] : "";
            $ds_pin = isset($data['ds_pin'])? $data['ds_pin'] : "";
            $ic_status = isset($data['ic_status'])? $data['ic_status'] : "";
            $supervisor_pk = isset($data['supervisor_pk'])? $data['supervisor_pk'] : "";

            (new Colaborador($this->pdo))->listarDataTable($pk,$grupos_leads_pk,$leads_pk,$ds_cpf,$cargo_pk,$ds_pin,$ic_status,$supervisor_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
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
            $entity = new Colaborador($this->pdo);
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
            $entity = new Colaborador($this->pdo);
            $retorno = $entity->listarPk($pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500,[]);
        }
    }

    public function RelatorioDadosColaborador(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])?$data['pk'] : "";
            $ic_status = isset($data['ic_status'])?$data['ic_status'] : "";
            $retorno = (new Colaborador($this->pdo))->RelatorioDadosColaborador($pk,$ic_status);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarDsPin(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk'] : "";
            $retorno = (new Colaborador($this->pdo))->listarDsPin($pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarColaboradoresQualificacao(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $ds_produtos_servicos = isset($data['ds_produtos_servicos'])?$data['ds_produtos_servicos'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])?$data['colaborador_pk'] : "";
            $retorno = (new Colaborador($this->pdo))->listarColaboradoresQualificacao($ds_produtos_servicos, $colaborador_pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarColaboradorLeadCalendario(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])?$data['leads_pk'] : "";
            $retorno = (new Colaborador($this->pdo))->listarColaboradorLeadCalendario($leads_pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarColaboradorFolha(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();

            $empresas_pk = isset($data['empresas_pk'])?$data['empresas_pk'] : "";
            $leads_pk = isset($data['leads_pk'])?$data['leads_pk'] : "";
            $ic_escala = isset($data['ic_escala'])?$data['ic_escala'] : "";

            $retorno = (new Colaborador($this->pdo))->listarColaboradorFolha($empresas_pk, $leads_pk, $ic_escala);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarColaboradorLead(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])?$data['leads_pk'] : "";
            $retorno = (new Colaborador($this->pdo))->listarColaboradorLead($leads_pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

}