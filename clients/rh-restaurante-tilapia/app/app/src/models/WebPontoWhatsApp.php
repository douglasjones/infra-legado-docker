<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;
use Throwable;

class WebPontoWhatsApp {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUrlContents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function tratarMensagem(
        $mensagem_from,
        $mensagemRecebida,
        $telRecebido,
        $tipoMensagem,
        $ds_link,
        $latitude,
        $longitude,
        $phone_number_id
        ){

            try{
                $retorno = new \StdClass; //Estrutura de retorno para controller
                $retorno->status = false; //Retorno setado status como false
                $retorno->data = []; //Retorno data setado como vazio

                // Define o locale para português do Brasil
                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

                // Obtém o dia da semana em português
                $diaSemana = strftime('%A');

                // Pega as 3 primeiras letras e coloca em minúsculas
                $diaAbreviado = mb_strtolower(substr($diaSemana, 0, 3));
                //verificar qual o dia da semana para fazer a consulta na query
                $ic_consulta = "ic_escala_".$diaAbreviado;

                $hora_atual = date("H:i:s");

                if ($hora_atual >= "04:00:00" && $hora_atual <= "12:29:29") {
                    $turnos_pk = 1;
                } elseif ($hora_atual > "11:59:59" && $hora_atual <= "17:59:59") {
                    $turnos_pk = 2;
                } elseif ($hora_atual >= "18:00:00") {
                    $turnos_pk = 3;
                }


                $texto1 ="";
                $texto2 = "";
                $texto3 = "";
                $texto4 = "";
                $texto5 = "";
                $texto6 = "";
                $texto7 = "";

                

                 //PEGAR O PONTO 
                 $dataAtual = date('Y-m-d');


                $sql ="";
                $sql.="SELECT c.pk,c.ds_colaborador,c.ds_pin,ct.pk id_cliente";
                $sql.=" FROM colaboradores c";
                $sql.=" INNER JOIN contas ct on c.contas_pk = ct.pk";
                $sql.=" WHERE REPLACE(SUBSTRING(c.ds_cel, 5), '-', '') = '".$telRecebido."'";
                $sql.=" and c.ic_status=1";
                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
                if(count($query)>0){
                    $colaborador_pk = $query[0]['pk'];
                    $ds_colaborador = $query[0]['ds_colaborador'];
                    $ds_pin_tabela_colaborador = $query[0]['ds_pin'];
                    $id_cliente = $query[0]['id_cliente'];

                    //VAMOS VERIFICAR SE EXISTE UM CADASTRO DELE NA SOLICITAÇÃO DE PONTO.
                    $sql ="";
                    $sql.="SELECT p.ds_pin,p.ic_status";
                    $sql.=" FROM ponto_solicitacao_liberacao_app p";
                    $sql.=" WHERE p.colaborador_pk = ".$colaborador_pk;
                    $stmt = $this->pdo->prepare( $sql );
                    $stmt->execute();
                    $query1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    
                    if(count($query1)>0){
                        if($query1[0]['ic_status']!=1){
                            $texto1 ="Olá *".$ds_colaborador."*, seja bem vindo ao batimento de ponto !!!\u2705 ";
                            $texto2 = " Seu acesso ainda não foi liberador, entre em contato com o RH.";
                
                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                        }
                        else{
                            $ds_pin = $query1[0]['ds_pin'];

                            //CASO TENHA O REGISTRO
                            //CONSULTAR O POSTO DE TRABALHO DO COLABORADOR
                            $sql="";
                            $sql.="SELECT a.pk,";
                            $sql.=" l.pk leads_pk,";
                            $sql.=" l.ds_lead,";
                            $sql.=" concat(l.ds_endereco,', ',l.ds_numero,',',l.ds_cidade,',Brasil')ds_local_trabalho,";
                            $sql.=" c.ds_colaborador,";
                            $sql.=" a.hr_inicio_expediente,";
                            $sql.=" a.hr_termino_expediente,";
                            $sql.=" TIMESTAMPDIFF(MINUTE, a.hr_inicio_expediente, CURRENT_TIME) AS diferenca_minutos,";
                            $sql.=" a.turnos_pk,";
                            $sql.=" date_format(a.dt_inicio_agenda, '%d/%m/%Y') dt_inicio_agenda,";
                            $sql.=" date_format(a.dt_fim_agenda, '%d/%m/%Y') dt_fim_agenda,";
                            $sql.=" date_format(a.dt_cancelamento, '%d/%m/%Y') dt_cancelamento";
                            $sql.=" FROM agenda_colaborador_padrao a";
                            $sql.="     INNER JOIN leads l ON a.leads_pk = l.pk";
                            $sql.="     INNER JOIN colaboradores c ON a.colaboradores_pk = c.pk";
                            $sql.=" WHERE a.colaboradores_pk =".$colaborador_pk;
                            $sql.="       AND a.dt_cancelamento IS NULL";
                            $sql.="       AND a.dt_fim_agenda > sysdate()";
                            //$sql.="       AND a.turnos_pk = ".$turnos_pk;
                            //$sql.="       AND a.".$ic_consulta." = 1";
                            $sql .= " ORDER BY ABS(TIMESTAMPDIFF(MINUTE, a.hr_inicio_expediente, CURRENT_TIME)) ASC";
                            $sql .= " LIMIT 1";

                            $stmt = $this->pdo->prepare( $sql );
                            $stmt->execute();
                            $queryLead = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                            if(count($queryLead)>0){
                                //CASO TENHA O POSTO DE TRABALHO
                                $agenda_colaborador_pk = $queryLead[0]['pk'];
                                $leads_pk = $queryLead[0]['leads_pk'];
                                $ds_lead = $queryLead[0]['ds_lead'];
                                $turnos_pk = $queryLead[0]['turnos_pk'];
                                $diferenca_minutos = $queryLead[0]['diferenca_minutos'];
                                $hr_inicio_expediente = $queryLead[0]['hr_inicio_expediente'];
                                $ds_local_trabalho = $queryLead[0]['ds_local_trabalho'];
                                if($tipoMensagem == 'text'){
                                    if($mensagemRecebida=="oi" || $mensagemRecebida =="Oi" || $mensagemRecebida =="Olá" || $mensagemRecebida =="Começar"){
                        
                                        
                                        $sql ="";
                                        $sql.=" SELECT ";
                                        $sql.="    p.ds_pin,";
                                        $sql.="    p.colaborador_pk,";
                                        $sql.="    p.tipos_ponto_pk tipo_ponto_pk";
                                        $sql.=" FROM";
                                        $sql.="    ponto p";

                                        $sql.=" WHERE 1 = 1 ";
                                        $sql.=" and p.dt_hora_ponto between '".$dataAtual." 00:00:00' and '".$dataAtual." 23:59:59'";
                                        if($colaborador_pk != ""){
                                            $sql.=" and p.colaborador_pk  =".$colaborador_pk;
                                        }
                                        
                                        $stmt = $this->pdo->prepare( $sql );
                                        $stmt->execute();
                                        $queryp = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                                        $ini_exp = 0;
                                        $ini_int = 0;
                                        $term_int = 0;
                                        $term_exp = 0;
                                        $allPontos = 0;
                                        if(count($queryp)>0){
                                            for($p=0;$p<count($queryp);$p++){
                                                if($queryp[$p]['tipo_ponto_pk']==1){
                                                    $ini_exp = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==2){
                                                    $term_exp = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==3){
                                                    $ini_int = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==4){
                                                    $term_int = 1;
                                                    $allPontos++;
                                                }
                                                
                                            }
                                        }
                                        $isFuturo = false;
                                        $HorarioPermitido = false;
                                        $comparacao = "-5";
                                        //CALCULAR HORA DO EXPEDIENTE.
                                        if($turnos_pk!=3){
                                            if(($diferenca_minutos) >= 0){
                                                $isFuturo = true;
                                            }
                                            if($isFuturo){
                                                $HorarioPermitido = true;
                                            }
                                            else{
                                                if(($diferenca_minutos) >= ($comparacao)){
                                                    $HorarioPermitido = true;
                                                }
                                            }
                                        }

                                        

                                        //if($HorarioPermitido){
                                            
                                            if($allPontos>3){
                                                $texto1 ="Olá *".$ds_colaborador."* ";
                                                $texto2 = " \u203c\ufe0f *Informamos que você já bateu todos os seus pontos diários.* \u203c\ufe0f";
                                    
                                                $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                                $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                
                                            }
                                            else{
                                                $texto1 ="Olá *".$ds_colaborador."*, seja bem vindo ao batimento de ponto !!!\u2705 ";
                                                $texto2 = " Informe com o número qual o ponto.";
                                                $texto3 = "*1 - Inicio de expediente.*";
                                                $texto4 = "*2 - Final de expediente*";
                                                $texto5 = "*3 - Inicio Intervalo*";
                                                $texto6 = "*4 - Volta do Intervalo.*";
                                    
                                                $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                                $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                                if($ini_exp==0){
                                                    $this->enviarMensagem($texto3,$mensagem_from,$phone_number_id);
                                                }
                                                if($term_exp==0){
                                                    $this->enviarMensagem($texto4,$mensagem_from,$phone_number_id);
                                                }
                                                if($ini_int==0){
                                                    $this->enviarMensagem($texto5,$mensagem_from,$phone_number_id);
                                                }
                                                if($term_int==0){
                                                    $this->enviarMensagem($texto6,$mensagem_from,$phone_number_id);
                                                }
                                            }
                                        /*}
                                        else{
                                            $texto1 ="Olá *".$ds_colaborador."* ";
                                            $texto2 = " *Você ainda não está liberado para bater seus pontos.* ";
                                            $texto3 = " *Seu expediente começa às ".$hr_inicio_expediente.".* ";
                                
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto3,$mensagem_from,$phone_number_id);
                                        }*/
                                    }
                                    else if($mensagemRecebida==1 || $mensagemRecebida == 2|| $mensagemRecebida == 3|| $mensagemRecebida == 4){
                                        
                                        $sql ="";
                                        $sql.=" SELECT ";
                                        $sql.="    p.ds_pin,";
                                        $sql.="    p.colaborador_pk,";
                                        $sql.="    p.tipos_ponto_pk tipo_ponto_pk";
                                        $sql.=" FROM";
                                        $sql.="    ponto p";

                                        $sql.=" WHERE 1 = 1 ";
                                        $sql.=" and p.dt_hora_ponto between '".$dataAtual." 00:00:00' and '".$dataAtual." 23:59:59'";
                                        if($colaborador_pk != ""){
                                            $sql.=" and p.colaborador_pk  =".$colaborador_pk;
                                        }
                                        
                                        $stmt = $this->pdo->prepare( $sql );
                                        $stmt->execute();
                                        $queryp = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                                        $ini_exp = 0;
                                        $ini_int = 0;
                                        $term_int = 0;
                                        $term_exp = 0;
                                        $allPontos = 0;
                                        if(count($queryp)>0){
                                            for($p=0;$p<count($queryp);$p++){
                                                if($queryp[$p]['tipo_ponto_pk']==1){
                                                    $ini_exp = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==2){
                                                    $term_exp = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==3){
                                                    $ini_int = 1;
                                                    $allPontos++;
                                                }
                                                if($queryp[$p]['tipo_ponto_pk']==4){
                                                    $term_int = 1;
                                                    $allPontos++;
                                                }
                                                
                                            }
                                        }

                                        if($mensagemRecebida==1 && $ini_exp==1){
                                            $texto1 ="Você já bateu seu ponto de entrada hoje ! .";
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        }
                                        else if($mensagemRecebida==2 && $term_exp==1){
                                            $texto1 ="Você já bateu seu ponto de Saida hoje ! .";
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        }
                                        else if($mensagemRecebida==3 && $ini_int==1){
                                            $texto1 ="Você já bateu seu ponto de saida para intervalo hoje ! .";
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        }
                                        else if($mensagemRecebida==4 && $term_int==1){
                                            $texto1 ="Você já bateu seu ponto de retorno do intervalo hoje ! .";
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        }
                                        else{
                                            $texto1 ="Ótimo \ud83d\ude04 .";
                                            $texto2 = "Preciso que tire uma foto agora \ud83d\udcf8";
                                            $texto3 = "\u203c\ufe0f *Como deve ser feito* \u203c\ufe0f";
                                            $texto4 = "*Apenas do rosto, sem mascara, oculos ou boné.*";
                                            $texto5 = "*De frente sem inclinação e local iluminado.*";
                                            $texto6 = "*Uma foto nitida.*";
                            
                                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto3,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto4,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto5,$mensagem_from,$phone_number_id);
                                            $this->enviarMensagem($texto6,$mensagem_from,$phone_number_id);


                                            try{
                                                //SALVAR O TIPO PONTO 
                                                $fields = array();
                                                $fields['ds_pin'] = $ds_pin;
                                                
                                                $fields['ic_tipo_dispositivo'] = 1;
                                                $fields['ds_identificacao_dispositivo'] = "WhatsApp";
                                                $fields['colaborador_pk'] = $colaborador_pk;
                                                $fields['tipos_ponto_pk'] = $mensagemRecebida;
                                                $fields['dt_hora_ponto'] = 'sysdate()';
                                                $fields['agenda_colaborador_padrao_pk'] = $agenda_colaborador_pk;
                                                $fields['leads_pk'] = $leads_pk;
                                                $fields['ic_tipo_sincronizacao'] = 1;
                                                $fields['contas_pk'] = 1;
                                                $fields["dt_ult_atualizacao"] = "sysdate()";
                                                $fields["usuario_ult_atualizacao_pk"] = 1;
                                                $fields["dt_cadastro"] = "sysdate()";
                                                $fields["usuario_cadastro_pk"]   = 1;
    
    
    
    
                                                Util::execInsert("ponto", $fields,$this->pdo);
                                            }
                                            catch(Throwable $th){
                                                $this->enviarMensagem($th->getMessage(),$mensagem_from,$phone_number_id);
                                            }
                                        }
                                        

                                        
                                        
                                    
                                    }
                                    else{
                                        $texto1 ="Não entendi sua solicitação, poderia informar novamente";
                                        $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                    }
                                }
                                else if($tipoMensagem == 'image'){
                                    //CONVERTER IMG PARA BLOB 
                                    $urlAtual = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST']."/";
                                    
                                    $conteudo_imagem = $this->getUrlContents("https://www.gpros.com.br/wb/".$ds_link);
                                    
                                    
                                    //CONSULTAR O PONTO PARA ARMAZENAR A FOTO 

                                    $sql="";
                                    $sql.="SELECT pk FROM ponto ";
                                    $sql.=" where ds_pin = '".$ds_pin."'";
                                    $sql.=" and ds_identificacao_dispositivo = 'WhatsApp'";
                                    $sql.=" and img_ponto is null";
                                    $sql.=" order by pk desc";
                                    $stmt = $this->pdo->prepare( $sql );
                                    $stmt->execute();
                                    $queryPonto = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                                    if(count($queryPonto)>0){
                                        $ponto_pk = $queryPonto[0]['pk'];

                                        //SALVAR O IMG PONTO
                                        $fields = array();
                                        $fields['img_ponto'] = base64_encode($conteudo_imagem);
                                        $fields['ds_imagem'] = "https://www.gpros.com.br/wb/".$ds_link;
                                        $fields['dt_hora_ponto'] = 'sysdate()';

                                        Util::execUpdate("ponto", $fields, " pk = ".$ponto_pk,$this->pdo);

                                        // Definir o local para o Brasil
                                        date_default_timezone_set('America/Sao_Paulo');
                                        // Obter a data e hora atual no formato brasileiro
                                        $dataHoraAtual = date('d/m/Y H:i:s');
                                        $texto1 = "Perfeito \u263a\ufe0f .";
                                        $texto2 = " *Precisamos que envie agora a sua localização atual* \ud83d\udccd ";
                                        $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                    }
                                    else{
                                        //CASO O ARQUIVO NÃO SEJA UM IMAGEM
                                        $texto1 ="Tivemos um problema para bater o ponto, entre em contato com o suporte.";
                                        $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                    }
                                }
                                else if($tipoMensagem == 'location'){
                                    

                                    $endereco = $this->transformarCoordenadasEmEndereco($latitude,$longitude);
                                    
                                    $endereco = $this->transformarCoordenadasEmEndereco($latitude,$longitude);
                            

                                    $location2 = Util::getCoordinates($ds_local_trabalho);
                                    
                                    $distancia_ponto= "km.";
                                    // Verifica se as coordenadas foram obtidas com sucesso
                                    if ($location2) {
                                        // Calcula a distância entre os dois pontos
                                        $distancia = Util::calcularDistancia($latitude,$longitude, $location2['lat'], $location2['lon']);
                                        $distancia_ponto = round($distancia, 2) . " km.";
                                    }
                                    //CONSULTAR O PONTO PARA ARMAZENAR A LOCALIZAÇÃO 

                                    $sql="";
                                    $sql.="SELECT pk FROM ponto ";
                                    $sql.=" where ds_pin = '".$ds_pin."'";
                                    $sql.=" and ds_identificacao_dispositivo = 'WhatsApp'";
                                    $sql.=" and ds_localizacao is null";
                                    $sql.=" order by pk desc";
                                    $stmt = $this->pdo->prepare( $sql );
                                    $stmt->execute();
                                    $queryPonto = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                                    if(count($queryPonto)>0){
                                        $ponto_pk = $queryPonto[0]['pk'];

                                        //SALVAR O IMG PONTO
                                        $fields = array();
                                        $fields['ds_localizacao'] = $endereco;
                                        $fields['ds_distancia_ponto'] = $distancia_ponto;
                                        $fields['dt_hora_ponto'] = 'sysdate()';
                                        Util::execUpdate("ponto", $fields, " pk = ".$ponto_pk,$this->pdo);


                                        // Definir o local para o Brasil
                                        date_default_timezone_set('America/Sao_Paulo');
                                        // Obter a data e hora atual no formato brasileiro
                                        $dataHoraAtual = date('d/m/Y H:i:s');
                                        $texto1 = "Finalizamos \u263a\ufe0f .";
                                        $texto2 = "Seu ponto foi batido com sucesso !!! \ud83c\udf89";
                                        $texto3 = "Data do Ponto:*".$dataHoraAtual."*";
                                        $texto4 = "Posto de trabalho:*".$ds_lead."*";
                                        $texto5 = "\u2139\ufe0f *Sua foto e sua localização será comparada com a do nosso banco de dados.* ";
                                        
                                        $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                        $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                        $this->enviarMensagem($texto3,$mensagem_from,$phone_number_id);
                                        $this->enviarMensagem($texto4,$mensagem_from,$phone_number_id);
                                        $this->enviarMensagem($texto5,$mensagem_from,$phone_number_id);
                                    }
                                }
                                else {

                                    //CASO O ARQUIVO NÃO SEJA UM IMAGEM
                                    $texto1 ="Tipo de dado enviado não é compativel, refaça o processo";
                                    $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                                }
                            }
                            else{
                                //CASO NÃO LOCALIZE NENHUM POSTO DE TRABALHO DO COLABORADOR
                                $texto1 = $ds_colaborador." Não localizamos nenhum posto de trabalho, entre em contato com o RH da sua empresa";
                                $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                            }
                        }
                    }
                    else{
                        //CASO NÃO TENHA O REGISTRO !!!
                        if($tipoMensagem == 'text'){
                            $texto1 ="Olá *".$ds_colaborador."*, bem vindo ao WhatsApp Ponto Gepros !!!\u2705 ";
                            $texto2 = "Vimos que você não tem um cadastro conosco !";
                            $texto3 = "Mas podemos fazer agora !";
                            $texto4 = "Só precisa tirar uma foto \ud83d\udcf8";
                            $texto5 = "*Apenas do rosto, sem mascara, oculos ou boné.*";
                            $texto6 = "*De frente sem inclinação e local iluminado.*";
                            $texto7 = "*Uma foto nitida.*";
                
                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto3,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto4,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto5,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto6,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto7,$mensagem_from,$phone_number_id);
                        }
                        else if($tipoMensagem == 'image'){
                            
                        
                            $urlAtual = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST']."/";
                            $conteudo_imagem = file_get_contents("https://www.gpros.com.br/wb/".$ds_link);
                            
                            $fields = array();
                            $fields['ds_pin'] = $ds_pin_tabela_colaborador;
                            $fields['colaborador_pk'] = $colaborador_pk;
                            $fields['id_cliente'] = $id_cliente;
                            $fields['img_colaborador_cadastro'] = base64_encode($conteudo_imagem);
                            $fields['ds_link_imagem_cadastro'] =  "https://www.gpros.com.br/wb/".$ds_link;
                            $fields['IdTermoAceite'] = 1;
                            $fields['ic_tipo_app'] = 1;


                            $fields["dt_ult_atualizacao"] = "sysdate()";
                            $fields["usuario_ult_atualizacao_pk"] = 1;
                            

                            $fields['dt_solit_liberacao'] = "sysdate()";

                            $fields["dt_cadastro"] = "sysdate()";
                        
                            $fields["usuario_cadastro_pk"]   = 1;
                            
                            Util::execInsert("ponto_solicitacao_liberacao_app", $fields,$this->pdo);


                            $texto1 = "Perfeito \u263a\ufe0f .";
                            $texto2 = " *Entre em contato com o RH da sua empresa para solicitar a liberação do seu acesso!* \ud83d\udccd ";
                                
                            $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                            $this->enviarMensagem($texto2,$mensagem_from,$phone_number_id);
                                
                        }
                    }
                
                
                }
                else{
                  
                    //SE NÃO EXISTIR, PEDIMOS PARA QUE ENTRE EM CONTATO COM O RH DA EMPRESA
                    $texto1 ="Não localizamos seu registro, entre em contato com o RH da sua empresa";
                    $this->enviarMensagem($texto1,$mensagem_from,$phone_number_id);
                }

                echo json_encode($retorno);
                exit(0);

            }
            catch(Throwable $e){
                $this->enviarTeste(
                    $e->getMessage(),
                    "5511978344771"
                 );
                
            }
        

        
    }


    public function transformarCoordenadasEmEndereco($latitude,$longitude){
    
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1";
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
        
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_status == 200) {
            $data = json_decode($response, true);
            if (isset($data['display_name'])) {
                $address = $data['display_name'];
    
                $endereco = explode(",", $address);
                return $endereco[0].",".$endereco[1]."-".$endereco[3];
                
            } else {
                return "Endereço não encontrado.";
                //return null;
            }
        } else {
            return "Erro ao processar a solicitação. Código de status HTTP: " . $http_status;
            //return null;
        }
    }

   public  function enviarMensagem($mensagemParaEnviar,$telefone,$phone_number_id){
    try{
        $token = 'EAAM4IEWO1gsBOz6kF00qzSjjjQf4joZCqCsLTDRUEsmvss7oqji5zRshF7AnuceFTmO3asQA2HvU9K21ZBi6sDW9m8ufnQsPAifZChjQdWZAfg7jOxl1UnuuFDDTbMkqTPJkgu1c5ZA7GNv9Do56HuVWVjonejLpFHZAikQkZBnqxg9EMiCqW7jfpKcYcjfM9TTcwZDZD';


        $url = "https://graph.facebook.com/v16.0/".$phone_number_id."/messages";
        $header = [    
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        ];

        $mensagem = "{ \"messaging_product\": \"whatsapp\", \"to\": \"".$telefone."\", \"type\": \"text\", \"text\": { \"preview_url\": false, \"body\": \"".$mensagemParaEnviar."\"} }";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$mensagem);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        
        echo json_encode(["success" => $response]) ;
    }
    catch(Throwable $e){

        
        print_r($e->getMessage());
        die();
    }
}


    public function enviarTeste($mensagemParaEnviar,$telefone){

        try{
         $phone_number_id ='372810795920515';
         $token = 'EAAM4IEWO1gsBO2FnTr54mIv76z5NBq4ZCkjoiutlRkrABqrZBWiZBl3LFmRWIZA0pgaW6QjfKMrnpIXZAuzOl4fJDtcKZAcW2wmOPIRGFNzXZAd90hmuV0vZAQH33f1BFQWVKGQGZAjG2ip490Drm2rBHhkqBIKGbZCEbG9RglXAOdDHbDVhgn1B2dvSd5JMo0jt7N1rFBuap6ZAfpL5H1LYEdZAozGNHT9GZAkZCPI7EJ';
     
     
         $url = "https://graph.facebook.com/v16.0/".$phone_number_id."/messages";
         $header = [    
             'Authorization: Bearer '.$token,
             'Content-Type: application/json'
         ];
     
         $mensagem = "{ \"messaging_product\": \"whatsapp\", \"to\": \"".$telefone."\", \"type\": \"text\", \"text\": { \"preview_url\": false, \"body\": \"".$mensagemParaEnviar."\"} }";
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
     
         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
     
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$mensagem);  //Post Fields
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
         $response = curl_exec($ch);
         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
     
         curl_close($ch);
         
         echo json_encode(["success" => $response]) ;
         
        }
        catch(Throwable $th){
         echo json_encode(["success" => $th->getMessage()]) ;
        }
         
     }
}
