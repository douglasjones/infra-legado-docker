<?require_once "../inc/php/header.php";?>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script src="qrcode_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    @media print{
        #noprint{
            display:none;
        }
    }
</style>
<div id="container-fluid">
    <div id="container col-sm-12">
        <div id="noprint">
            <br>
            <div class="row">
                <div class="col-md-12" align="center" >
                    <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" id="cmdImprimir" data-dismiss="modal">Imprimir</button>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-md-12' align='center'>
                    <h4>QR Code Colaboradores</h4>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-3">
                    &nbsp;
                </div>
                <div class='col-md-9'>
                    <label><b> Posto de Trabalho:</b> </label>
                    <span id='ds_lead_qr_code'></span>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-3">
                    &nbsp;
                </div>
                <div class='col-md-9'>
                    <label><b>Endereço:</b> </label>
                    <span id='ds_endereco_qr_code'></span>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-3">
                    &nbsp;
                </div>
                <div class='col-md-9'>
                    <label><b>Telefone:</b> </label>
                    <span id="ds_tel_qr_code"></span>
                </div>
            </div>
        </div>
        <br>
        <div id="qrcode-container">
            
        </div>
    </div>
</div>