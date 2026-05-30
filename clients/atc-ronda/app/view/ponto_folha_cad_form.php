<?
require_once "../inc/php/header.php";
?>

<script src="ponto_folha_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<title>Gepros - CRM</title>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Gerar - Folha Ponto</h3>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
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
        <p>
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
        <p>      
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for="dt_periodo_ini">Dt Periodo Ponto Ini:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="dt_periodo_ini" required="true">
                
            </div>
            <div class='col-md-2'>
                <label for="dt_periodo_ini">Dt Periodo Ponto Fim:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="dt_periodo_fim" required="true">
            </div>
        </div>
        <p>      
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ic_escala">Escalas:&nbsp;</label>
                <select class="form-control form-control-sm" id="ic_escala" >
                    <option></option>
                    <option value="1">Ativa</option>
                    <option value="2">Cancelada</option>
                </select>
            </div>
        </div>
        <p>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='obs_faturamento'> Observação:&nbsp;</label>
                <textarea id="obs" name="obs" rows="3" cols="41"></textarea>
            </div>
        </div>
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-primary" id="cmdPesquisarDadosFolha"  name="cmdPesquisarDadosFolha">Pesquisar</button>
            </div>
        </div>
        <p>
        <div class="row">
            <div class="col-md-12">
                <h5>Colaboradores do Posto de Trabalho</h5>
                <hr>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                 <button type="button" class="btn btn-primary" id="cmdMarcarTodos"  name="cmdMarcarTodos">Marcar Todos</button>
            </div>
        </div>  
        <p>
        <div class="row">
                <div class="col-md-12">

                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                    <thead>
                        <tr>
                            <th>#</th>                    
                            <th>Colaborador</th>  
                            <th>Status</th>     
                            <th>Qualificação</th>    
                            <th>DT Escala</th>                
                            <th>Escala</th>
                            <th>HR Escala</th>
                            <th>Status Escala</th>
                            <th>Dt Cancelamento</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cmdCancelar">Voltar</button>
            <button type="submit" class="btn btn-primary" id="cmdEnviarContato"  name="cmdEnviarContato">Gerar Folha</button>
       </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>
