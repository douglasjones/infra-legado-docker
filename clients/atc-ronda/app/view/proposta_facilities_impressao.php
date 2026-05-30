<?
require_once "../inc/php/header.php";
?>
<script src="proposta_facilities_impressao.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
</head>
<style>
    @media print{
        #noprint{
            display:none;
        }
    }
</style>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
            <div class="row"> 
                <div class='col-sm-12' align="center" id='noprint'>
                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>                     
                    <button type="button" class="btn btn-primary btn-sm" id="cmdImprimir">Imprimir</button>                     
                </div>
            </div>
            <div class='col-sm-12'>
                <br>
                <div class="row"> 
                    <div class='col-sm-11' align='right'>
                        <img id='logo' width='60%' height='60%' alt='logo'>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-sm-6' align='left'>
                        <b>Para:</b><br>
                        <span id='ds_lead'></span>
                    </div>
                    <div class='col-sm-6' align='right'>
                        <b>Data:</b><br>
                        <span id='dt_base_categoria'></span>
                    </div>
                </div>

                <br>
                <div class='row'>
                    <div class='col-sm-6' align='left'>
                        <b>A/C:</b><br>
                        <span id='ds_aos_cuidados'></span>
                    </div>
                    <div class='col-sm-6' align='right'>
                        <b>ORÇAMENTO Nº:</b><br>
                        <span id='n_orcamento'></span>
                    </div>
                </div>
                <br>

                <div class='row'>
                    <div class='col-sm-1'>
                            &nbsp;
                    </div>
                    <div class='col-sm-10' align='left'>
                        <b>Tipo:</b>
                        <span id='ds_tipo'></span>
                    </div>
                </div>
                <br>
                <div class='col-sm-12' id='ds_proposta' style='border:1px solid black'>
                    <br>

                </div>
                <br>

                <div class='row'>
                    <div class='col-sm-1'>
                            &nbsp;
                    </div>
                    <div class='col-sm-10' align='right'>
                        <b>Valor Total R$:</b>
                        <span id='ds_total'></span>
                    </div>
                </div>
                <br>

                Orçamento válido por 30 (Trinta) dias conforme Código de Defesa do Consumidor - Art. 40. § 1º.
            </div>
		</div>
	</div>
</div>