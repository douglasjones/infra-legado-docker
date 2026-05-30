<?
require_once "../inc/php/header.php";
?>
<script src="rel_agenda_condominio_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container col-md-10 ">
    <div class="row">
        <div class="col-md-12">
           <h2>Agenda Condomínio Período</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Colaborador</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Turno</th>
                    <!--th>Motivo Pausa</th-->
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
