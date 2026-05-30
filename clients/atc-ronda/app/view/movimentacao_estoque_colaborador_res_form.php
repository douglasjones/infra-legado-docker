<?
require_once "../inc/php/header.php";
?>

<script src="movimentacao_estoque_colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">


<div class="row">
    <div class="col-md-2" align="center">
        <button type="button" class="btn btn-primary" id="cmdIncluirConjuntoMaterial">Incluir Material</button>
    </div>
</div>
<br>
<div class="col-md-12" >
    <table class="table table-striped table-bordered nowrap" id="tblResultadoEstoque" >
        <thead>
            <tr>
                <th>Código</th>
                <th>Grupo Movimentação</th>
                <th>Colaborador/Posto</th>
                <th>Categoria</th>
                <!--th>Produto</th-->
                <th>Qtde</th>
                <th>DT Movimentação</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>



<?
include_once "inc_movimentar_material_prod_cad_form.php";
require_once "../inc/php/footer.php";
?>