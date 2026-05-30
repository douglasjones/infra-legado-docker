<?
require_once "../inc/php/header.php";
?>
<script src="http://leandrolisura.com.br/wp-content/uploads/2017/07/printThis.js"></script>
<script src="apontamento_folha_ponto_posto_trabalho_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style type="text/css">
    .starter-template {
        padding: 40px 15px;
        text-align: center;
    }
    .printable {
        display: none;
    }
    /* print styles*/
    @media print {
        .printable {
            display: block;
        }
        .screen {
            display: none;
        }
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Folha Ponto Gerar / Apontamento </h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="produtos_servicos_pk">Posto de Trabalho:&nbsp;</label>
                <select id="leads_pk" class="form-control form-control-sm chzn-select" name="leads_pk">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="produtos_servicos_pk">Colaborador :&nbsp;</label>
                <select id="colaborador_pk_pesq" class="form-control form-control-sm chzn-select" name="colaborador_pk_pesq">
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>DT. Peíodo Geração Início:&nbsp;</label>
                <input type='text' class=" form-control form-control-file" id="dt_periodo_ini_pesq" name="dt_periodo_ini_pesq"/>
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>DT. Peíodo Geração Fim:&nbsp;</label>
                <input type='text' class=" form-control form-control-file" id="dt_periodo_fim_pesq" name="dt_periodo_fim_pesq"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Gerar </button>&nbsp;&nbsp;&nbsp;<br>
                <!--button type="button" class="btn btn-primary" id="cmdMigrar">Migrar </button-->
            </div>
        </div>
    </form>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Cód</th>
                    <th>Posto de Trabalho</th>
                    <th>DT Geração da Folha</th>
                    <th>DT Período Folha Ini</th>
                    <th>DT Período Folha Fim</th>
                    <th>Ação</th>
                    
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
<form id="form" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_folha" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Folha Ponto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-sm">
                        <b>Folha Ponto</b>  - Gerar
                    </div>
                </div> 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <p>
                <div class="row">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class="col-md-4">
                        <label for="produtos_servicos_pk">Posto de Trabalho:&nbsp;</label>
                        <select id="leads_pk_cad" class="form-control form-control-sm chzn-select" name="leads_pk_cad">
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>DT. Peíodo Geração Início:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_periodo_ini" name="dt_periodo_ini"/>
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>DT. Peíodo Geração Fim:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_periodo_fim" name="dt_periodo_fim"/>
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
                <br>
                <div class="row">
                    <div class="col-sm">
                        <b>Colaboradores</b>  - Selecione para Gerar Folha
                    </div>
                </div> 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <p>
                <div class="row">
                    <div class="col-md-12">
                        <div id="grid_colaboradores"></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class="col-md-4" align="center">
                       <button type="submit" class="btn btn-primary" id="cmdGerarFolhaPonto"  name="cmdGerarFolhaPonto">Gerar Folha Ponto</button>
                    </div>
                </div>
                
            </div>  
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                
            </div>
            </div>
        </div>
    </div>  
</form>
<div class="container">    
    <div class="modal fade bd-example-modal-lg" id="janela" data-backdrop='static'>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Informativo </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>                
                <div class="modal-content bd-example-modal-lg-12">
                    <div class="modal-body" >    
                        <div class='container' id='exibir_informativo_agenda'>  
                            <div class='row'> 
                                <div class='container'> 
                                    <div class='modal-content'> 
                                        <div class='modal-content'>
                                            <div class='modal-body' style='box-shadow: 2px 2px 5px grey;'> 
                                               <div class='row ' >
                                                    <div class='col-sm-12 '>
                                                       <div class='col-md-8'>
                                                         <label >Posto de Trabalho</label> 
                                                        <b><div id="ds_lead"></div></b>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class='row ' >
                                                    <div class='col-sm-12 '>                                                
                                                      <div class='col-md-8' >
                                                          <label >Período</label>
                                                            <b><div id="periodo"></div></b>
                                                     </div>
                                                   </div>
                                                </div>
                                                <br>
                                                <br>
                                                <div class='row ' >
                                                    <div class='col-md-1' >
                                                        &nbsp;
                                                    </div>
                                                    <div class='col-md-10' >
                                                        <div id="grid_informativo_colaboradores"></div>
                                                    </div>
                                                    
                                                </div>

                                                <hr> 
                                                <br>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
        </div> 
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>
