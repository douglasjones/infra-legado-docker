<?
    require_once "../inc/php/header.php";
    include "regerar_res_form.php";
?>
<script src="ponto_folha_registros_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<title>Gepros - CRM</title>
<style>
        @import "bourbon";
            .label-float{
            position: relative;
            padding-top: 13px;
        }

        .label-float input[type=text]{
            border: 0;
            border-bottom: 2px solid lightgrey;
            outline: none;
            min-width: 300px;
            font-size: 16px;
            transition: all .3s ease-out;
            -webkit-transition: all .3s ease-out;
            -moz-transition: all .3s ease-out;
            
            border-radius:0;
        }

        .label-float input[type=text]:focus{
            border-bottom: 2px solid #3951b2;
        }

        .label-float input[type=text]:placeholder{
            color:transparent;
        }

        .label-float label{
            pointer-events: none;
            position: absolute;
            top: 0;
            left: 0;
            margin-top: 13px;
            transition: all .3s ease-out;
            -webkit-transition: all .3s ease-out;
            -moz-transition: all .3s ease-out;
        }

        .label-float input[type=text]:required:invalid + label{
            color: red;
        }
        .label-float input[type=text]:focus:required:invalid{
            border-bottom: 2px solid red;
        }
        .label-float input:required:invalid + label:before{
            content: '*';
        }
        .label-float input[type=text]:focus + label,
        .label-float input[type=text]:not(:placeholder-shown) + label{
            font-size: 13px;
            margin-top: 0;
            color: #3951b2;
        }
        .oc_modal{
            cursor:pointer;
        }
        .doc_modal{
            cursor:pointer;
        }
        .processo_modal{
            cursor:pointer;
        }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            &nbsp;
            <h3>Folha de Ponto</h3>
            <hr>
        </div>
    </div>
    <form method="post">
        <input type="hidden" id="leads_pk" name="leads_pk" value="">
        <div class='row'>
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='tipos_operacao_pk'>Empresa:</label>
            </div>
            <div class='col-md-5'>
                <b><div id="ds_empresa"></div></b>
            </div>            
        </div> 
        <div class='row'>
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='agenda_contratos_pk'>Posto de Trabalho: </label>
            </div>
            <div class='col-md-4'>
                <b><div id="ds_lead"></div></b>
            </div>            
        </div>         
       
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for="dt_periodo_ini">Dt Periodo Folha Ini:&nbsp;</label>
            </div>
            <div class='col-md-4'>
                <b><div id="dt_periodo_ini"></div></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for="dt_periodo_ini">Dt Periodo Folha fim:&nbsp;</label>

            </div>
            <div class='col-md-4'>
                <b><div id="dt_periodo_fim"></div></b>
            </div>
        </div>       
        
         <div class='row'>
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='obs_faturamento'> Observação:&nbsp;</label>

            </div>
            <div class='col-md-4'>
                <textarea id="obs" name="obs" rows="3" cols="30" disabled=""><div id="obs"></div></textarea>
            </div> 
        </div>    
        <br>
        <div class='row'>
            <div class='col-md-1' align='Left'>
                &nbsp;
            </div>
            <div class='col-md-6' align='Right'>
                <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>
            </div>
        </div>    
        
    </form>
    <div class="row">
        <div class="col-md-12">
        
            <button type="button" class="btn btn-secondary" id="cmdRegerarFolha" data-dismiss="modal">Regerar Folha</a></button>
            <button type="button" class="btn btn-primary" id="cmdPrintAll" data-dismiss="modal">Imprimir Todas</button>
            <button type="button" class="btn btn-success" id="cmdGerarPlanilhaExcel" data-dismiss="modal">Gerar Planilha Excel</button>
            <hr>
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>#</th>    
                    <th>Cód.</th>    
                    <th>Ponto Folha</th>
                    <th>Dt. Cadastro</th>
                    <th>Dt. ult. Atualização</th>
                    <th>Status</th>
                    <th>Colaborador</th>  
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>
