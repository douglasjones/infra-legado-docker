<div style="display:none">
    <?  
        require_once "../inc/php/header.php";
        $ds_lead = $_REQUEST['ds_lead'];
        $leads_pk = $_REQUEST['leads_pk'];
        $ds_turno = $_REQUEST['ds_turno'];
        $turnos_pk = $_REQUEST['turnos_pk'];

    ?>
</div>
<script src="mesa_operacional_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container" id="exibir">
    <p>
    <div class="row">
        <input type='hidden' id='leads_pk' value="<?=$leads_pk;?>">
        <input type='hidden' id='turnos_pk' value="<?=$turnos_pk;?>">
        <input type='hidden' id='origem' value="mesa_operacional">
        <div class="col-md-12">
            <h2>Mesa Operacional</h2>
        </div>
    </div>
    <div class="col">
        <div class='col-md-4'>
            <label for="leads_pk">Posto de trabalho:&nbsp;</label> <?= $ds_lead;?>
        </div>
        <div class='col-md-4'>
            <label for="turnos_pk">Turno:&nbsp;</label> <?= $ds_turno;?>
        </div>
    </div>
    <div class="row col-md-12" align="center">
        <div class="col-md-5">
            &nbsp;
        </div> 
        <div class="col-md-2 ">
            <div class="text-center" >
                <b>Legenda</b>
            </div>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div> 
    </div>
    <br>
    <div class="row col-md-12" align="center">
        <div class="col-md-2">
            &nbsp;
        </div> 
        <div class="col-md-2 " style="background-color:e6df55">
            <div class="text-center" >
                <font> <b>Atraso de 10 Min até 14:59 Min</b></font> 
            </div>
        </div> 
        <div class="col-md-2 "  style="background-color:f99856;">
            <div class="text-center">
                    <font><b>Atraso de 15 Min até 24:59 Min</b></font> 
            </div>
        </div> 
        <div class="col-md-2 "  style="background-color:ec1c24;">
            <div class="text-center">
                <font color="white"><b>Atraso acima de 25 Min</b></font> 
            </div>
        </div>
        <div class="col-md-2 "  style="background-color:63ed83;">
            <div class="text-center">
                <font><b>Ponto registrado</b></font> 
            </div>
        </div>
        <div class="col-md-1">
            &nbsp;
        </div> 
    </div>
    <br>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <div id="tblMesaOperacional">

    </div>
</div>
<?
include "apontamento_colaborador_cad_form.php";
require_once "../inc/php/footer.php";
?>
