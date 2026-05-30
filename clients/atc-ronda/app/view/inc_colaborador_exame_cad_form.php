<?
require_once "../inc/php/header.php";
?>
<script src="inc_colaborador_exame_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_exames" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_exames" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Novo Exame</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type='hidden' class='form-control form-control-sm'  id='colaborador_ezames_pk' name='colaborador_ezames_pk'>
                 <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Exame:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='exames_pk' name='exames_pk'/>
                            <option></option>
                            <option>Admicional</option>
                            <option>Periódico</option>
                            <option>Demissional</option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Prevista:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_prevista" name="dt_prevista"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Exame:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_exame" name="dt_exame"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Status:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_status_exames' name='ic_status_exames'/>
                            <option></option>
                            <option>Feito</option>
                            <option>Adiado</option>
                            <option>Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='processos_pk'>Observação:&nbsp;</label>
                        <textarea class=" form-control form-control-file" id="obs" name="obs"></textarea>
                    </div>
                </div>
            </div>  
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="cmdEnviarExames"  name="cmdEnviarExames">Salvar</button>
            </div>
            </div>
        </div>
    </div>  
</form>
