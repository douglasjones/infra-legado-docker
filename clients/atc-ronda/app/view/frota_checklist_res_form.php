<?
require_once "../inc/php/header.php";
?>

<script src="frota_checklist_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<title>Gepros CRM</title>
<!-- Custom fonts for this template-->
<link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-6">
                <div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Frota</h6>     
                        </div>       
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp; &nbsp; &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='leads_pk'>Posto de Trabalho:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk'>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp; &nbsp; &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='condutores_pk'>Condutores:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='condutores_pk' name='condutores_pk'>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='condutores_pk'>ID Veiculo:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='id_veiculo' name='id_veiculo'>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp; &nbsp; &nbsp;
                                    </div>
                                    <div class='col-md-2'>
                                        <label for='condutores_pk'>Dt. Ini. Checklist:&nbsp;</label>
                                        <input class='form-control form-control-sm' id='dt_ini_checklist' name='dt_ini_checklist'>
                                    </div>
                                    <div class='col-md-2'>
                                        <label for='condutores_pk'>Dt. Fim. Checklist:&nbsp;</label>
                                        <input class='form-control form-control-sm' id='dt_fim_checklist' name='dt_fim_checklist'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp; &nbsp; &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='usuario_cadastro_pk'>Usuário Cadastro:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='usuario_cadastro_pk' name='usuario_cadastro_pk'>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Novo</button>
                                    &nbsp;
                                </div>
                            </div>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="row" id="ic_grid">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblResultado">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>
                                                <th>Posto De Trabalho</th>
                                                <th>Condutor</th>
                                                <th>Veiculo</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
        
<?require_once "../inc/php/footer.php";?>
