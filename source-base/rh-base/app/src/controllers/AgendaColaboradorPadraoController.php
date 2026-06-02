<?php

namespace App\Controller;

use App\Model\AgendaColaboradorPadrao;
use App\Model\Log;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class AgendaColaboradorPadraoController extends BaseController {

    public function excluir(Request $request, Response $response, $args)
    {
        try {
            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new AgendaColaboradorPadrao($this->pdo))->excluir($pk);
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

    public function escalaDadosColaborador(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $entity = new AgendaColaboradorPadrao($this->pdo);
            $agenda_colaborador_padrao_pk = isset($data['agenda_colaborador_padrao_pk'])? $data['agenda_colaborador_padrao_pk'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaboradores_pk = isset($data['colaboradores_pk'])? $data['colaboradores_pk'] : "";
            $dt_periodo_ini = isset($data['dt_periodo_ini'])? $data['dt_periodo_ini'] : "";
            $dt_periodo_fim = isset($data['dt_periodo_fim'])? $data['dt_periodo_fim'] : "";
            $ds_escala = isset($data['ds_escala'])? $data['ds_escala'] : "";
            $tipo_escala_pk = isset($data['tipo_escala_pk'])? $data['tipo_escala_pk'] : "";

            $retorno = $entity->escalaDadosColaborador($colaboradores_pk, $dt_periodo_ini, $dt_periodo_fim, $leads_pk, $agenda_colaborador_padrao_pk, $ds_escala,$tipo_escala_pk);
            Json::run(true, [], "");
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function salvar(Request $request, Response $response, $args) {

        try{
            $data = $_POST;
            $pk = isset($data['pk'])? $data['pk'] : "";
            $colaboradores_pk = isset($data['colaboradores_pk'])? $data['colaboradores_pk'] : "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk'] : "";
            $dt_inicio_agenda = isset($data['dt_inicio_agenda'])? $data['dt_inicio_agenda'] : "";
            $dt_fim_agenda = isset($data['dt_fim_agenda'])? $data['dt_fim_agenda'] : "";
            $turnos_pk = isset($data['turnos_pk'])? $data['turnos_pk'] : "";
            $hr_inicio_expediente = isset($data['hr_inicio_expediente'])? $data['hr_inicio_expediente'] : "";
            $hr_termino_expediente = isset($data['hr_termino_expediente'])? $data['hr_termino_expediente'] : "";
            $hr_inicio_intervalo = isset($data['hr_inicio_intervalo'])? $data['hr_inicio_intervalo'] : "";
            $hr_termino_intervalo = isset($data['hr_termino_intervalo'])? $data['hr_termino_intervalo'] : "";
            $ic_intrajornada = isset($data['ic_intrajornada'])? $data['ic_intrajornada'] : "";
            $ic_variacao_dias_escala = isset($data['ic_variacao_dias_escala'])? $data['ic_variacao_dias_escala'] : "";
            $tipos_escalas_pk = isset($data['tipos_escalas_pk'])? $data['tipos_escalas_pk'] : "";
            $ic_folga_dom = isset($data['ic_folga_dom'])? $data['ic_folga_dom'] : "";
            $ic_folga_seg = isset($data['ic_folga_seg'])? $data['ic_folga_seg'] : "";
            $ic_folga_ter = isset($data['ic_folga_ter'])? $data['ic_folga_ter'] : "";
            $ic_folga_qua = isset($data['ic_folga_qua'])? $data['ic_folga_qua'] : "";
            $ic_folga_qui = isset($data['ic_folga_qui'])? $data['ic_folga_qui'] : "";
            $ic_folga_sex = isset($data['ic_folga_sex'])? $data['ic_folga_sex'] : "";
            $ic_folga_sab = isset($data['ic_folga_sab'])? $data['ic_folga_sab'] : "";
            $ic_escala_dom = isset($data['ic_escala_dom'])? $data['ic_escala_dom'] : "";
            $ic_escala_seg = isset($data['ic_escala_seg'])? $data['ic_escala_seg'] : "";
            $ic_escala_ter = isset($data['ic_escala_ter'])? $data['ic_escala_ter'] : "";
            $ic_escala_qua = isset($data['ic_escala_qua'])? $data['ic_escala_qua'] : "";
            $ic_escala_qui = isset($data['ic_escala_qui'])? $data['ic_escala_qui'] : "";
            $ic_escala_sex = isset($data['ic_escala_sex'])? $data['ic_escala_sex'] : "";
            $ic_escala_sab = isset($data['ic_escala_sab'])? $data['ic_escala_sab'] : "";
            $hr_inicio_exp_dom = isset($data['hr_inicio_exp_dom'])? $data['hr_inicio_exp_dom'] : "";
            $hr_inicio_exp_seg = isset($data['hr_inicio_exp_seg'])? $data['hr_inicio_exp_seg'] : "";
            $hr_inicio_exp_ter = isset($data['hr_inicio_exp_ter'])? $data['hr_inicio_exp_ter'] : "";
            $hr_inicio_exp_qua = isset($data['hr_inicio_exp_qua'])? $data['hr_inicio_exp_qua'] : "";
            $hr_inicio_exp_qui = isset($data['hr_inicio_exp_qui'])? $data['hr_inicio_exp_qui'] : "";
            $hr_inicio_exp_sex = isset($data['hr_inicio_exp_sex'])? $data['hr_inicio_exp_sex'] : "";
            $hr_inicio_exp_sab = isset($data['hr_inicio_exp_sab'])? $data['hr_inicio_exp_sab'] : "";
            $hr_inicio_intervalo_dom = isset($data['hr_inicio_intervalo_dom'])? $data['hr_inicio_intervalo_dom'] : "";
            $hr_inicio_intervalo_seg = isset($data['hr_inicio_intervalo_seg'])? $data['hr_inicio_intervalo_seg'] : "";
            $hr_inicio_intervalo_ter = isset($data['hr_inicio_intervalo_ter'])? $data['hr_inicio_intervalo_ter'] : "";
            $hr_inicio_intervalo_qua = isset($data['hr_inicio_intervalo_qua'])? $data['hr_inicio_intervalo_qua'] : "";
            $hr_inicio_intervalo_qui = isset($data['hr_inicio_intervalo_qui'])? $data['hr_inicio_intervalo_qui'] : "";
            $hr_inicio_intervalo_sex = isset($data['hr_inicio_intervalo_sex'])? $data['hr_inicio_intervalo_sex'] : "";
            $hr_inicio_intervalo_sab = isset($data['hr_inicio_intervalo_sab'])? $data['hr_inicio_intervalo_sab'] : "";
            $hr_termino_intervalo_dom = isset($data['hr_termino_intervalo_dom'])? $data['hr_termino_intervalo_dom'] : "";
            $hr_termino_intervalo_seg = isset($data['hr_termino_intervalo_seg'])? $data['hr_termino_intervalo_seg'] : "";
            $hr_termino_intervalo_ter = isset($data['hr_termino_intervalo_ter'])? $data['hr_termino_intervalo_ter'] : "";
            $hr_termino_intervalo_qua = isset($data['hr_termino_intervalo_qua'])? $data['hr_termino_intervalo_qua'] : "";
            $hr_termino_intervalo_qui = isset($data['hr_termino_intervalo_qui'])? $data['hr_termino_intervalo_qui'] : "";
            $hr_termino_intervalo_sex = isset($data['hr_termino_intervalo_sex'])? $data['hr_termino_intervalo_sex'] : "";
            $hr_termino_intervalo_sab = isset($data['hr_termino_intervalo_sab'])? $data['hr_termino_intervalo_sab'] : "";
            $hr_termino_expediente_dom = isset($data['hr_termino_expediente_dom'])? $data['hr_termino_expediente_dom'] : "";
            $hr_termino_expediente_seg = isset($data['hr_termino_expediente_seg'])? $data['hr_termino_expediente_seg'] : "";
            $hr_termino_expediente_ter = isset($data['hr_termino_expediente_ter'])? $data['hr_termino_expediente_ter'] : "";
            $hr_termino_expediente_qua = isset($data['hr_termino_expediente_qua'])? $data['hr_termino_expediente_qua'] : "";
            $hr_termino_expediente_qui = isset($data['hr_termino_expediente_qui'])? $data['hr_termino_expediente_qui'] : "";
            $hr_termino_expediente_sex = isset($data['hr_termino_expediente_sex'])? $data['hr_termino_expediente_sex'] : "";
            $hr_termino_expediente_sab = isset($data['hr_termino_expediente_sab'])? $data['hr_termino_expediente_sab'] : "";
            $dt_cancelamento = isset($data['dt_cancelamento'])? $data['dt_cancelamento'] : "";
            $ds_motivo_cancelamento = isset($data['ds_motivo_cancelamento'])? $data['ds_motivo_cancelamento'] : "";
            $obs = isset($data['obs'])? $data['obs'] : "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";

            $agenda_colaborador_padrao = [
                "pk"=>$pk,
                "colaboradores_pk"=>$colaboradores_pk,
                "produtos_servicos_pk"=>$produtos_servicos_pk,
                "dt_inicio_agenda"=>$dt_inicio_agenda,
                "dt_fim_agenda"=>$dt_fim_agenda,
                "turnos_pk"=>$turnos_pk,
                "hr_inicio_expediente"=>$hr_inicio_expediente,
                "hr_termino_expediente"=>$hr_termino_expediente,
                "hr_inicio_intervalo"=>$hr_inicio_intervalo,
                "hr_termino_intervalo"=>$hr_termino_intervalo,
                "ic_intrajornada"=>$ic_intrajornada,
                "ic_variacao_dias_escala"=>$ic_variacao_dias_escala,
                "tipos_escalas_pk"=>$tipos_escalas_pk,
                "ic_folga_dom"=>$ic_folga_dom,
                "ic_folga_seg"=>$ic_folga_seg,
                "ic_folga_ter"=>$ic_folga_ter,
                "ic_folga_qua"=>$ic_folga_qua,
                "ic_folga_qui"=>$ic_folga_qui,
                "ic_folga_sex"=>$ic_folga_sex,
                "ic_folga_sab"=>$ic_folga_sab,
                "ic_escala_dom"=>$ic_escala_dom,
                "ic_escala_seg"=>$ic_escala_seg,
                "ic_escala_ter"=>$ic_escala_ter,
                "ic_escala_qua"=>$ic_escala_qua,
                "ic_escala_qui"=>$ic_escala_qui,
                "ic_escala_sex"=>$ic_escala_sex,
                "ic_escala_sab"=>$ic_escala_sab,
                "hr_inicio_exp_dom"=>$hr_inicio_exp_dom,
                "hr_inicio_exp_seg"=>$hr_inicio_exp_seg,
                "hr_inicio_exp_ter"=>$hr_inicio_exp_ter,
                "hr_inicio_exp_qua"=>$hr_inicio_exp_qua,
                "hr_inicio_exp_qui"=>$hr_inicio_exp_qui,
                "hr_inicio_exp_sex"=>$hr_inicio_exp_sex,
                "hr_inicio_exp_sab"=>$hr_inicio_exp_sab,
                "hr_inicio_intervalo_dom"=>$hr_inicio_intervalo_dom,
                "hr_inicio_intervalo_seg"=>$hr_inicio_intervalo_seg,
                "hr_inicio_intervalo_ter"=>$hr_inicio_intervalo_ter,
                "hr_inicio_intervalo_qua"=>$hr_inicio_intervalo_qua,
                "hr_inicio_intervalo_qui"=>$hr_inicio_intervalo_qui,
                "hr_inicio_intervalo_sex"=>$hr_inicio_intervalo_sex,
                "hr_inicio_intervalo_sab"=>$hr_inicio_intervalo_sab,
                "hr_termino_intervalo_dom"=>$hr_termino_intervalo_dom,
                "hr_termino_intervalo_seg"=>$hr_termino_intervalo_seg,
                "hr_termino_intervalo_ter"=>$hr_termino_intervalo_ter,
                "hr_termino_intervalo_qua"=>$hr_termino_intervalo_qua,
                "hr_termino_intervalo_qui"=>$hr_termino_intervalo_qui,
                "hr_termino_intervalo_sex"=>$hr_termino_intervalo_sex,
                "hr_termino_intervalo_sab"=>$hr_termino_intervalo_sab,
                "hr_termino_expediente_dom"=>$hr_termino_expediente_dom,
                "hr_termino_expediente_seg"=>$hr_termino_expediente_seg,
                "hr_termino_expediente_ter"=>$hr_termino_expediente_ter,
                "hr_termino_expediente_qua"=>$hr_termino_expediente_qua,
                "hr_termino_expediente_qui"=>$hr_termino_expediente_qui,
                "hr_termino_expediente_sex"=>$hr_termino_expediente_sex,
                "hr_termino_expediente_sab"=>$hr_termino_expediente_sab,
                "dt_cancelamento"=>$dt_cancelamento,
                "ds_motivo_cancelamento"=>$ds_motivo_cancelamento,
                "obs"=>$obs,
                "leads_pk"=>$leads_pk,
            ];


            $retorno = (new AgendaColaboradorPadrao($this->pdo))->salvar($agenda_colaborador_padrao);


            json::run($retorno->status,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarEscalaLead(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";

            (new AgendaColaboradorPadrao($this->pdo))->listarEscalaLead($leads_pk);
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

            $retorno = (new AgendaColaboradorPadrao($this->pdo))->listarPk($pk);
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarEscala(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $tipo_escala_pk = isset($data['tipo_escala_pk'])? $data['tipo_escala_pk'] : "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk'] : "";

            (new AgendaColaboradorPadrao($this->pdo))->listarEscala($leads_pk,$colaborador_pk,$tipo_escala_pk,$produtos_servicos_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarEscalaColaborador(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            (new AgendaColaboradorPadrao($this->pdo))->listarEscalaColaborador($colaborador_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarEscalasPostosColaborador(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $entity = new AgendaColaboradorPadrao($this->pdo);

            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $dt_apontamento = isset($data['dt_apontamento'])? $data['dt_apontamento'] : "";
            $retorno = $entity->listarEscalasPostosColaborador($colaborador_pk, $dt_apontamento);

            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function receptivo(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();

            $local = isset($data['local'])? $data['local'] : "";
            $this->view->render($response, 'agenda_calendario/calendario_escala.twig',array('ic_abertura'=>1,'local'=>$local));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function calendarioDados(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();

            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk'] : "";
            $n_qtde_dias_semana = isset($data['n_qtde_dias_semana'])? $data['n_qtde_dias_semana'] : "";
            $tipo_escala_pk = isset($data['tipo_escala_pk'])? $data['tipo_escala_pk'] : "";
            $escala_pesq_agenda = isset($data['escala_pesq_agenda'])? $data['escala_pesq_agenda'] : "";
            $dt_ini = date('Y-m-d', strtotime($data['start']));
            $dt_fim = date('Y-m-d', strtotime($data['end']));

            $entity = new AgendaColaboradorPadrao($this->pdo);

            $entity->calendarioDados($dt_ini,$dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$tipo_escala_pk,$escala_pesq_agenda,$produtos_servicos_pk);

            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function calendarioDadosEscala(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $produtos_servicos_pk = isset($data['produtos_servicos_pk'])? $data['produtos_servicos_pk'] : "";
            $n_qtde_dias_semana = isset($data['n_qtde_dias_semana'])? $data['n_qtde_dias_semana'] : "";
            $dt_fim = date('Y-m-d', strtotime($data['end']));
            $entity = new AgendaColaboradorPadrao($this->pdo);

            $entity->calendarioDadosEscala($dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$produtos_servicos_pk,1);

            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function receptivoEscala(Request $request, Response $response, $args) {
        try{

            $data = $request->getQueryParams();
            $local = isset($data['local'])? $data['local']: "";
            $this->view->render($response, 'escala/agenda_escala_res_form.twig',array(
                "local"=>$local
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function cadFormEscala(Request $request, Response $response, $args){
        try{
            $data = $request->getQueryParams();
            $pk = isset($data['pk'])? $data['pk']: "";
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk']: "";
            $local = isset($data['local'])? $data['local']: "";
            $this->view->render($response, 'escala/agenda_escala_cad_form.twig',array(
                "pk"=>$pk,
                "leads_pk"=>$leads_pk,
                "local"=>$local
            ));
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function updateDataEscalaColaborador(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $colaborador_pk = isset($data['colaborador_pk']) ? $data['colaborador_pk'] : "";
            $dt_atual = isset($data['dt_atual']) ? $data['dt_atual'] : "";
            $nova_data = isset($data['nova_data']) ? $data['nova_data'] : "";
            $leads_pk = isset($data['leads_pk']) ? $data['leads_pk'] : "";

            $retorno = (new AgendaColaboradorPadrao($this->pdo))->updateDataEscalaColaborador($colaborador_pk,$dt_atual,$nova_data,$leads_pk);
            json::run(true,$retorno->data,$retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function listarTurno(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $entity = new AgendaColaboradorPadrao($this->pdo);

            $retorno = $entity->listarTurno();

            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function processa_escala(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();
            $entity = new AgendaColaboradorPadrao($this->pdo);
            $retorno = $entity->processa_escala();
            
            Json::run($retorno->status, $retorno->data, $retorno->message);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

}