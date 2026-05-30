<?
require_once "../inc/php/header.php";
?>

<style>
    
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
        -webkit-user-select: none;
        -moz-user-select: none; 
        -ms-user-select: none; 
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        -ms-transform: rotate(90deg); 
        -webkit-transform: rotate(90deg); 
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
    <div class="container_tipos_categoria">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h2>Auditoria Tipos Categorias</h2>
                <hr>
            </div>
        </div>
        <form id="form" class="form">
            <div class='row'>
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class='row'>
                <div class='col-md-4'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='auditoria_categorias_pk'>Categoria:&nbsp;</label>
                    <select class="form-control form-control-sm" id="auditoria_categorias_pk" name="auditoria_categorias_pk">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-4'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='ds_auditoria_categoria_tipo'>Tipo Categoria:&nbsp;</label>
                    <input type="text" class="form-control form-control-sm" id="ds_auditoria_categoria_tipo" name="ds_auditoria_categoria_tipo">
                </div>
            </div>

            <div class='row'>
                <div class='col-md-4'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='ic_status'>Status:&nbsp;</label>
                    <select class="form-control form-control-sm" id="ic_status" name="ic_status">
                        <option></option>
                        <option value="1">Ativo</option>
                        <option value="2">Inativo</option>
                    </select>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                <br>
                <button type="submit" class="btn btn-primary" id="cmdEnviarTiposCategoria">Adicionar Campos Formulário</button>
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelarTiposCategoria">Cancelar</button>
            </div>
        </div>
    </div>
    <div class="container" name="container_campos_formulario" id="container_campos_formulario">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h3>Campos Formulário</h3>
            </div>
        </div>
        <hr>

        <form id="formCampos" class="formCampos">
            <div class='row'>
                <input type="hidden" name="auditorias_categorias_tipos_pk" id="auditorias_categorias_tipos_pk" value="">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class='col-md-3'>
                    <label for='tipo_item_pk'>Tipo Campo:&nbsp;</label>
                    <select class="form-control form-control-sm" id="tipo_item_pk" name="tipo_item_pk">
                        <option></option>
                        <option value="1">Lista Suspensa</option>
                        <option value="2">Texto</option>
                        <option value="3">Checkbox</option>
                        <option value="4">Textarea</option>
                    </select>
                </div>
                
                <div class='col-md-3'>
                    <label for='ds_categoria_item'>Identificação do Campo:&nbsp;</label>
                    <input type="text" class="form-control form-control-sm" id="ds_categoria_item" name="ds_categoria_item">
                </div>

                <div align="center" class='col-md-1'>
                    <label for='ic_obrigatorio'>Obrigatório:</label>&nbsp;
                    <input type="checkbox" class="form-check-input" id="ic_obrigatorio" name="ic_obrigatorio">
                </div>
                    
            </div>
        </form>

        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button title="Incluir um novo campo" type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
            </div>
        </div>

        <div class='row'>
            <div style="width:50%" id="campos_treeView">
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                <hr>
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Enviar</button>
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script src="auditoria_categoria_tipos_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<?
require_once "../inc/php/footer.php";
?>
