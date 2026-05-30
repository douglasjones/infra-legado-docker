<?
require_once "../inc/php/header.php";
?>
<script src="processo_default_config_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
            <h4>Processo - Configuração Classificação</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post">
        <div id="x"></div>
        <div class='row'>
             <div class='col-md-4'>
                 &nbsp;
             </div>
            <div class='col-md-4'>
                 <label for='processo_pk'>Processo:</label>
                <select id="processo_pk" class='form-control form-control-sm ' name="processo_pk">
                    <option ></option>
                </select>
             </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_processo_default_configuracao'>Processo Etapas</label>
                <select class='form-control form-control-sm chzn-select'  id='ds_processo_default_configuracao' name='ds_processo_default_configuracao'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
             <div class='col-md-4'>
                 &nbsp;
             </div>
            <div class='col-md-4'>
                 <label for='ic_status'>Status:&nbsp;</label>
                 <select class='form-control form-control-sm'  id='ic_status' name='ic_status' requered/>
                     <option></option>
                    <option value="1">Ativo</option>
                    <option value="2">Desativado</option>
                 </select>
             </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                &nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Novo</button>
            </div>
        </div>
    </form>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <div class="row" >
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Cód.</th>
                    <th>Processo</th>
                    <th>Processo Etapa</th>
                    <th>Ordem</th>
                    <th>Status</th>
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
