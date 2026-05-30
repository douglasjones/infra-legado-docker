<?
require_once "../inc/php/header.php";
?>

<div class="container">
    <div class='row'>
        <div class="col-md-12" >
            <button type='button' class="btn btn-secondary" id='cmdIncluirMaterial'>Incluir Material</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
             <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblMaterial">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Material</th>
                        <th>Qtde</th>
                        <th>DT Entrega</th>
                        <th>DT Devolução</th>
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
