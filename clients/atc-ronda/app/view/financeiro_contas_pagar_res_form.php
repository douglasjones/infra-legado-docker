<?
require_once "../inc/php/header.php";
?>
<script src="financeiro_contas_pagar_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="financeiro_documento_form.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
    .loader{
        width:100%;
        height:100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    svg{
        width:10%;

    }
    .exibir{
        display: none;
    }
</style>

<div id="loader" class="loader">
    <svg id="animated" viewbox="0 0 100 100">
        <circle cx="50" cy="50" r="45" fill="#FDB900"/>
        <path id="progress" stroke-linecap="round" stroke-width="5" stroke="#fff" fill="none"
                d="M50 10
                a 40 40 0 0 1 0 80
                a 40 40 0 0 1 0 -80">
        </path>
        <text id="count" x="50" y="50" text-anchor="middle" dy="7" font-size="20">100%</text>
    </svg>
</div>
<div id="exibir" style="display: none;">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <h4>Contas a Pagar e Receber</h4>
                <hr>
            </div>
        </div>
        <div class="row" > 
            <div class="col-md-12" >
                <div class='row'>
                    <div class='col-sm-2'>
                        <button type='button' class="btn btn-primary" id='cmdNovoLencamento'>Novo Lançamento</button>    
                    </div>
                </div> 
            </div>         
        </div> 
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>       
        </div> 
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>       
        </div>
    </div>
    <div class="col-md-12">
        &nbsp;
    </div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="menu_extrato-tab" data-toggle="tab" href="#menu_extrato" role="tab" aria-controls="menu_extrato" aria-selected="true">Extrato Mês</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="manu_receita-tab" data-toggle="tab" href="#manu_receita" role="tab" aria-controls="menu_receita" aria-selected="false">Receita(s)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="manu_despesa-tab" data-toggle="tab" href="#menu_despesa" role="tab" aria-controls="menu_despesa" aria-selected="false">Despesa(s)</a>
                </li>      
                <li class="nav-item">
                    <a class="nav-link" id="menu_lancamento-tab" data-toggle="tab" href="#menu_lancamento" role="tab" aria-controls="menu_lancamento" aria-selected="false">Lançamento(s)</a>
                </li>    
            </ul>
        </div>       
    </div> 
    <br>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="menu_extrato" role="tabpanel" aria-labelledby="menu_extrato-tab">
            <?
                include("financeiro_extrato_res_form.php");               
            ?>  
        </div>
        <div class="tab-pane fade" id="manu_receita" role="tabpanel" aria-labelledby="menu_receita-tab">      
            <?
                include("financeiro_receita_grid_res_form.php");
            ?>
        </div>  
        <div class="tab-pane fade" id="menu_despesa" role="tabpanel" aria-labelledby="menu_despesa-tab">      
            <?
                include("financeiro_despesa_grid_res_form.php");
            ?>
        </div>
        <div class="tab-pane fade" id="menu_lancamento" role="tabpanel" aria-labelledby="menu_lancamento-tab">      
            <?
                include("financeiro_lancamento_grid_res_form.php");
            ?>
        </div>
    </div>    
</div>  

<?
require_once "financeiro_contas_pagar_cad_form.php";
require_once "financeiro_documentos_cad_form.php";
require_once "financeiro_documento_historico_res_form.php";
require_once "../inc/php/footer.php";
?>
