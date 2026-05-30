<?
require_once "../inc/php/header.php";
?>

<div class="container">
    <div class='row'>
        <div class="col-md-12" >
            <button type='button' class="btn btn-primary" id='cmdIncluirMaterial'>Incluir Material</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
             <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblMaterial">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Categoria</th>
                        <th>Categoria Pk</th>
                        <th>Produto</th>
                        <th>Produto Pk</th>
                        <th>Material</th>
                        <th>Material Pk</th>
                        <th>DT Entrega</th>
                        <th>DT Devolução</th>
                        <th>Obs</th>
                        <th>M.CargaPK</th>
                        <th>M.Carga</th>
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
