<?
require_once "../inc/php/header.php";
?>
<script src="inc_lancamentos_mes_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
 
    
    <div class="row">
        <div class="col-md-12">            
             <!--<table class="table table-striped table-bordered nowrap" style="width:100%" id="tblReceita">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Empresa</th>
                        <th>Tipo Lançamento</th>
                        <th>Centro Custo</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Tipo Grupo</th>
                        <th>Tipo Operação</th>
                        <th>Pago </th>
                        <th>Ação</th>
                    </tr>
                </thead>              
            </table>-->
            <div class="row">
                <div class="col-md-12">
                    <div id="gridLancamentosMes"></div>
                </div>
            </div>
        </div>
    </div>
<?
require_once "../inc/php/footer.php";
?>
