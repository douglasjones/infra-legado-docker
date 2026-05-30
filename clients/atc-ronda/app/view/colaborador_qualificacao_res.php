<?
require_once "../inc/php/header.php";
?>

<script src="colaborador_qualificacao_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">


            <div class='row'>
                    <div class="col-md-12" >
                        <button type='button' class="btn btn-primary" id='cmdIncluirQualificacao'>Incluir Qualificação</button>
                    </div>
            </div>
                <br>
            <div class="row">
                <div class="col-md-12">
                         <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblQualificacao">
                            <thead>
                                <tr>
                                    <th>Qualificação</th>
                                    <th>Possui Treinamento</th>
                                    <th>Possui Certificado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
            </div>



<?
require_once "../inc/php/footer.php";
?>