<?
require_once "../inc/php/header.php";
?>
<html>
    <script src="auditoria_supervisao_postos_trabalho_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <h2>Supervisão Auditorias Postos de Trabalho</h2>
                    <hr>
                </div>
            </div>
            <form method="post">
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='leads_pk'>Posto de trabalho:&nbsp;</label>
                        <select class="form-control form-control-sm" id="leads_pk" name="leads_pk">
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='auditoria_categorias_pk'>Categoria:&nbsp;</label>
                        <select class="form-control form-control-sm" id="auditoria_categorias_pk" name="auditoria_categorias_pk">
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='auditoria_categoria_tipos_pk'>Tipo categoria:&nbsp;</label>
                        <select class="form-control form-control-sm" id="auditoria_categoria_tipos_pk" name="auditoria_categoria_tipos_pk">
                            <option></option>
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
                        <button title="Incluir um novo registro" type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                    <thead>
                        <tr>
                            <th>Cód.</th>

                            <th>Posto De Trabalho</th>
                            <th>Categoria</th>
                            <th>Formulário</th>

                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>

<?
require_once "../inc/php/footer.php";
?>