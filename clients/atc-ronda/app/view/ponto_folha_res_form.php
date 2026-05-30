<?
require_once "../inc/php/header.php";
?>
<link href="https://cdn.jsdelivr.net/npm/jquery-treegrid@0.3.0/css/jquery.treegrid.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/jquery-treegrid@0.3.0/js/jquery.treegrid.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/treegrid/bootstrap-table-treegrid.min.js"></script>

<script src="ponto_folha_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
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

    .caret {
    cursor: pointer;
    -webkit-user-select: none; /* Safari 3.1+ */
    -moz-user-select: none; /* Firefox 2+ */
    -ms-user-select: none; /* IE 10+ */
    user-select: none;
    }

    .listaFolha{
        cursor: pointer;
    }

    .caret::before {
    content: "\25B6";
    color: black;
    display: inline-block;
    margin-right: 6px;
    }

    .caret-down::before {
    -ms-transform: rotate(90deg); /* IE 9 */
    -webkit-transform: rotate(90deg); /* Safari */
    transform: rotate(90deg);  
    }

   .nested {
    display: none;
    }

    .active {
    display: block;
    }
</style>

<div class="container">
	<br>
    <div class="row">            
        <div class="col-md-12">
            <div  id="abrir" tabindex="-1" role="dialog" aria-labelledby="modal-set-ramalLabel" >       
                <div class="col-lg"  style="max-width:1000px;margin-left: auto;margin-right: auto;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">	
                            <div class="row">
                                <div class='col-sm-6' align="left">
                                    <h6 class="m-0 font-weight-bold text-primary">Pesquisar - Folha de Ponto</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao' >
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select' id='empresas_pk' name='empresas_pk' />
                                    <option value=""></option>
                                </select> 
                            </div>
                        </div> 
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='agenda_contratos_pk'>Posto de Trabalho: </label>
                                <select class="form-control form-control-sm chzn-select" id="leads_pk" >
                                    <option></option>
                                </select>
                            </div>
                        </div>         
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-2'>
                                <label for="dt_periodo_ini">Dt Periodo Folha Ini:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_periodo_ini" required="true">
                            </div>
                            <div class='col-md-2'>
                                <label for="dt_periodo_ini">Dt Periodo Folha fim:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_periodo_fim" required="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1">Validas</option>
                                    <option value="2">Canceladas</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                                </div>
                            </div>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                    <h4>   
                                        <br>              
                                        &nbsp; Posto Trabalho
                                        <hr>
                                    </h4>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
	</div>
</div>


<?
require_once "../inc/php/footer.php";
?>
