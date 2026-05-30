<?
require_once "../inc/php/header.php";
?>
<script src="tarefa_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
 #loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
.label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 350px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -webkit-appearance:none;
  border-radius:0;
}

.label-float input:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input::placeholder{
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

.label-float input:required:invalid + label{
  color: red;
}
.label-float input:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input:focus + label,
.label-float input:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
    .titulo_calendario_anterior{
        background-color: #DFF0D8;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_grid_produto_servico{
        background-color: #c3c3c3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_atual{
        background-color: #9fd3f6;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #FCF8E3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .subtitulo_calendario{
        text-align: center;
    }
    .corpo{
        border-right-style: dashed;
        border-right-width: thin;        
    }
    .modal-content1{
        width: 1200px;
    }

</style>
<div id="loader"></div>
<div class="container-fluid" id="exibir" style="display:none">   
    <p>
    <div class="row">
        <div class="col-md-12">
            <h5><div class="ds_usuario" ></div></h5>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>   
    <form method="post">
        <div >
            <div >
                <div class="row" align="center">
                    <div class="col-md" >
                        <button type="button" class="btn" id="cmdPreviDia"  name="cmdPreviDia"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                        &nbsp;<label id="ds_dia"></label>&nbsp;
                        <button type="button" class="btn" id="cmdNextDia"  name="cmdNextDia"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                    
                        <input type="hidden" id="ic_dia" value="ic_dia" >&nbsp;&nbsp; - &nbsp;&nbsp;
                        
                        <button type="button" class="btn" id="cmdPreviMes"  name="cmdPreviMes"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                        &nbsp;<label id="ds_mes"></label>&nbsp;
                        <button type="button" class="btn" id="cmdNextMes"  name="cmdNextMes"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                    
                        <input type="hidden" id="ic_mes" value="ic_mes" >&nbsp;&nbsp; - &nbsp;&nbsp;
                        
                        
                        <button type="button" class="btn" id="cmdPreviAno"  name="cmdPreviAno"><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                        &nbsp;<label id="ano_pk"></label>&nbsp;
                        <input type="hidden" id="ds_ano" value="ds_ano" >
                        <button type="button" class="btn" id="cmdNextAno"  name="cmdNextAno"><i class="fa fa-chevron-right" aria-hidden="true"></i><i class="fa fa-chevron-right" aria-hidden="true"></i></button>                       
                    </div> 
                </div>
                <br>
                <div class="row" align="center">
                    <div class="col-md" >
                        <h4>Tarefas do Dia</h4>
                    </div> 
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="form_grid">
                        <div id="grid"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>
<!--DOCUMENTOS-->
<div class="container">    
    <div class="modal fade bd-example-modal-lg" id="janela_docs" >
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                                    
                    <div>  
                        <p>   
                        <div class="row">
                            <div class="col-md-12" >
                                <button type="button" class="btn btn-primary" id="cmdIncluirDocumento">Incluir Documento</button>
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Documento</th>
                                            <th>Observação</th>
                                            <th>Nome Original</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>  
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="janela_documentos" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Novo Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Escolha o Arquivo</span>
                            <input id="fileuploadDoc"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

                        </span>
                        <br>
                        <div id="alert_documento" style="display:none" >
                            <strong style="color: red">Selecione um arquivo</strong>
                        </div>
                        <br>
                        <div id="progressDoc" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <div id="files" class="files"></div>
                        <!---->
                        <div class="row" id="rowFotos"></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblArquivos">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Nome Original</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>

                    <div class='col-md-6'>
                        <div class="label-float">
                            <!--<input type="text" id="ds_obs_doc" name="ds_obs_doc" placeholder=" "/>-->
                            <!--<label for="agenda_ds_retorno">Observação:</label>-->
                            <textarea  class=" form-control form-control-file" id="ds_obs_doc" name="ds_obs_doc"></textarea>
                        </div>

                        <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                        <input type="hidden" name="ds_documento" id="ds_documento"/>
                        <input type="hidden" name="tarefas_pk" id="tarefas_pk"/>

                    </div>
                </div>
                <br>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
        
       
<?
require_once "../inc/php/footer.php";
?>
