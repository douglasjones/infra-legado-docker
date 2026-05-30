<?
require_once "../inc/php/header.php";
?>
<script src="inc_colaboradores_materiais_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_materiais" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_materiais" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Novo Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type='hidden' class='form-control form-control-sm'  id='colaborador_material_pk' name='colaborador_material_pk'>
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Tipo:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='tipo_material_pk' name='tipo_material_pk'/>
                            <option></option>
                            <option>Vestuário</option>
                        </select>
                    </div>
                </div> 
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Materiais:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='material_pk' name='material_pk'/>
                            <option></option>
                            <option>Uniforme</option>
                            <option>Botas</option>
                            <option>Camiseta</option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Qtde Itens:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="qtde_material" name="qtde_material"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Entrega:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_entrega" name="dt_entrega"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Devolução:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_devolucao" name="dt_devolucao"/>
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
                <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-secondary" id="cmdEnviarMateriais"  name="cmdEnviarMateriais">Salvar</button>
            </div>
            </div>
        </div>
    </div>  
</form>
