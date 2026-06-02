<?php

namespace App\Controller;

use App\Model\Documento;
use App\Utils\Json;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class DocumentoController extends BaseController {
    public function excluir(Request $request, Response $response, $args)
    {
        try{

            $data = $request->getQueryParams();
            $pk = isset($data['pk']) ? $data['pk'] : "";
            if($pk!=""){
                (new Documento($this->pdo))->excluir($pk);
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
    public function salvarDocumento(Request $request, Response $response, $args) {
        try{
            $data = $_POST;

            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";
            $ds_nome_documento = isset($data['ds_nome_documento'])? $data['ds_nome_documento'] : "";
            $diretorio = __DIR__ . '/../docs/';
            if (isset($_FILES) && isset($_FILES[0])){
                if (move_uploaded_file($_FILES[0]['tmp_name'], $diretorio. $_FILES[0]['name'])) {
                    $retorno = (new Documento($this->pdo))->salvarDocumento($_FILES,$diretorio,$leads_pk,$ds_nome_documento,$colaborador_pk);

                    Json::run(true, $retorno->data, "Inserido com sucesso!");
                } else {
                    Json::run(false, [], "Erro ao inserir!");
                }
              
                
            }
            else{
                Json::run(false, [], "Erro ao inserir!");
            }
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarDocumentosLead(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $leads_pk = isset($data['leads_pk'])? $data['leads_pk'] : "";

            (new Documento($this->pdo))->listarDocumentosLead($leads_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }
    public function listarDocumentosColaborador(Request $request, Response $response, $args) {

        try{
            $data = $request->getQueryParams();
            $colaborador_pk = isset($data['colaborador_pk'])? $data['colaborador_pk'] : "";

            (new Documento($this->pdo))->listarDocumentosColaborador($colaborador_pk);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function renomearArquivo(Request $request, Response $response, $args) {
        try{
            $entity = new Documento($this->pdo);
            $data = $request->getQueryParams();
            $ds_arquivo = isset($data['ds_arquivo']) ? $data['ds_arquivo'] : "";

            $diretorio = __DIR__ . '/../docs/';
            unlink($diretorio.$ds_arquivo);
            $dataResult = [
                "t_ds_nome_salvo" => $ds_arquivo,
            ];

            Json::run(true, $dataResult['t_ds_nome_salvo'], "Renomeado com sucesso!");
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }

    public function download(Request $request, Response $response, $args) {
        try{
            $data = $request->getQueryParams();

            
            $pk = $data['pk'];
            $ds_documento = $data['ds_documento'];

            if($pk>0){
                $retorno = (new Documento($this->pdo))->pegarDocumentoByPk($pk);
                
                header("Content-type: " . $retorno->data[0]["docsType"]);
                echo ($retorno->data[0]["docsData"]);
                exit;
            }
            else{
                set_time_limit(0);
                // Arqui você faz as validações e/ou pega os dados do banco de dados
                $aquivoNome = $ds_documento; // nome do arquivo que será enviado p/ download
                $ext = pathinfo($aquivoNome, PATHINFO_EXTENSION);

                $diretorio = __DIR__ . '/../docs/';
                $arquivoLocal = $diretorio.$aquivoNome; // caminho absoluto do arquivo
                // Verifica se o arquivo não existe
                if (!file_exists($arquivoLocal)) {
                    // Exiba uma mensagem de erro caso ele não exista
                    exit;
                }
                // Aqui você pode aumentar o contador de downloads
                // Definimos o novo nome do arquivo
                $novoNome = $aquivoNome;

                /********ABRIR DOCUMENTO**********/
                if($ext=="pdf"){
                    header('Content-Type: application/pdf');
                    header(sprintf("Content-disposition: inline;filename=%s", basename($arquivoLocal)));
                    echo file_get_contents($arquivoLocal);
                    exit;
                }
                else{
                    /************DOWNLOAD DOCUMENTO************/
                    // Configuramos os headers que serão enviados para o browser
                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename="'.$novoNome.'"');
                    header('Content-Type: application/octet-stream');
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: ' . filesize($aquivoNome));
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Expires: 0');
                    // Envia o arquivo para o cliente
                    readfile($aquivoNome);
                }
            }


            Json::run(true, [], "Download com sucesso!");
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Throwable $th) {
            return $response->withJson((object)[
                'error' => $th->getMessage()
            ], 500, []);
        }
    }


}