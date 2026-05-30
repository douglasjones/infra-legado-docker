<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "../../libs/maininclude.php";
include_once "classifcacao_visita_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

$agenda_visita_pk = $_REQUEST['agenda_visita_pk'];
$leads_pk = $_REQUEST['leads_pk'];

$termino_visita = $_REQUEST['termino'];
$status_classificacao_pk = $_REQUEST['codstatus'];

if(!empty($_REQUEST['informacoes1'])){
    $descricao = $_REQUEST['informacoes1'];
}else{
    $descricao = $_REQUEST['informacoes2'];
}

$motivo_sem_interesse_pk = $_REQUEST['codmotivolead'];


$dt_prev_receb_conta = $_REQUEST['dt_prev_receb_conta'];


if ($acao == "gravar"){
   
    $classifcacao_visita = new classifcacao_visita(0);
    $classifcacao_visita->setpk($pk);
    $classifcacao_visita->setagenda_visita_pk($agenda_visita_pk);
    $classifcacao_visita->setleads_pk($leads_pk);
        $classifcacao_visita->setmotivo_sem_interesse_pk($motivo_sem_interesse_pk);
    $classifcacao_visita->settermino_visita($termino_visita);
    $classifcacao_visita->setstatus_classificacao_pk($status_classificacao_pk);
    $classifcacao_visita->setdescricao($descricao);


    $classifcacao_visita->salvar();
    
    //CAASTRA A OCORRENCIA DE CLASSIFICAÇÃO
    if(!empty($motivo_sem_interesse_pk)){
        $classifcacao_visita->add_seminteresse();
    }
	
	javascriptalert('Operação executada com sucesso!!!');
}

if($acao == "excluir"){
	$classifcacao_visita= new classifcacao_visita($pk);
	$classifcacao_visita->excluir();
	javascriptalert('Operação executada com sucesso!!!');
}

include_once "../../libs/desconectar.php";

?>

