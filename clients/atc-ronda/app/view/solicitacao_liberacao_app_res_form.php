<?
require_once "../inc/php/header.php";
?>
<script src="solicitacao_liberacao_app_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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


.text-center {
    display: flex;
    justify-content: center;
    align-items: center;
}
.expanded-image {
    transform: scale(5.2); /* Aumenta a escala da imagem */
    transition: transform 0.3s ease-in-out; /* Adiciona uma transição suave */
}
.img-colaborador img {
  width: 10em;
  height: 10em;
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
                                    <h6 class="m-0 font-weight-bold text-primary">Solicitação de Acesso ponto App</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltarLead">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                        
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for='clientes_pk'>Colaboradores</label>
                            <select class='form-control form-control-sm chzn-select'  id='colaboradores_pk' name=colaboradores_pk'>
                                <option></option>
                            </select>
                        </div>
        
                        </div>
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_pin">PIN:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="ds_pin" required="true">
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_pin">R.E:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="ds_re" required="true">
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1">Aprovado</option>
                                    <option value="2">Pendente</option>
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
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>                    
                                            <th>Colaborador</th>
                                            <th>Pin</th>
                                            <th>R.E</th>                    
                                            <th>Img Colaborador</th>
                                            <th>Imagem Colaborador</th>
                                            <th>Dt Solicitação</th>
                                            <th>Status</th>
                                            <th>Dt Liberação</th>
                                            <th>User Liberação</th>                    
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
	</div>
    
    <form id="form_liberacao" class="form">
        <!-- Inicio janeja modal para edicao do registro -->
        <div class="modal fade bd-example-modal-lg" id="janela_liberacao" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="container">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-0 font-weight-bold text-primary" id="janela_contatosLabel">Liberar colaborador acesso App</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type='hidden' class='form-control form-control-sm'  id='ponto_solicitacao_liberacao_app_pk' name='ponto_solicitacao_liberacao_app_pk'>
                        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                        <div class="row">
                            <div class='col-md-4'>
                                
                                <div id="ds_imagem_modal" class='img-colaborador'></div>
                            </div>
                        </div>   
                        <p>
                        <div class="row">
                            <div class='col-md-4'>
                                <label for='ds_contato'>Colaborador: </label>
                                <div id="ds_colaborador_modal" class='form-control form-control-sm'></div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class='col-md-3'>
                                <label for='ds_contato'>Data da solicitação: </label>
                                <div id="dt_solit_liberacao_modal" class='form-control form-control-sm'></div>
                            </div>  
                        </div> 
                        <p>
                         <div class="row">
                            <div class='col-md-4'>
                                <label for='ds_cel'>Liberar Acesso ao App: </label>
                                <input type="checkbox" id="ic_status_modal" name="ic_status_modal" >
                            </div>
                        </div>
                        <div class="row" id="alert_liberacao" style="display:none" >                              
                            <br>
                            <div class='col-md-5' >
                                <strong style="color: red">Por favor, marque para liberar o acesso!</strong>
                            </div>
                        </div>
                        <p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" id="cmdEnviarAprovacaoSolicitacao"  name="cmdEnviarAprovacaoSolicitacao">Salvar</button>
                        </div>
                    </div>                        
                </div>
                </div>
            </div>
        </div>            
    </form>
</div>










<?
require_once "../inc/php/footer.php";
?>
