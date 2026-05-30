<?
require_once "../inc/php/header.php";
?>

<script src="veiculo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <?require_once '../inc/php/scripts.php';?>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Novo Veiculo</h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarVeiculo">Salvar</button>                          
                        </div>
                    </div>   
				</div>
				<div class="card-body">
                <div class="row">
     
        </div> 
        <hr>
        <div class="tab-content">

            <form id="form_lead" class="form">
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='id_veiculo'>Id Veiculo:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='id_veiculo' name='id_veiculo' required >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_placa'>Placa:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_placa' name='ds_placa' required >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_km'>KM Inicial:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_km_inicial' name='ds_km_inicial'>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cor'>Cor:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cor' name='ds_cor' required >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='tipo_veiculo_pk'>Tipo Veiculo:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='tipo_veiculo_pk' name='tipo_veiculo_pk' />
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='marca_s_veiculos_pk'>Marca:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='marcas_veiculos_pk' name='marcas_veiculos_pk' />
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='modelos_veiculos_pk'>Modelo:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='modelos_veiculos_pk' name='modelos_veiculos_pk' />
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='leads_pk'>Posto de Trabalo:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk' />
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_status'>Status :&nbsp;</label>
                        <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                </div>
              
            </form>           
           
        </div>   
        <div class="row">
            <div class="col-md-12" align="Right">
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            <br>
                <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarVeiculo">Salvar</button>                
        </div>
                </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
require_once "../inc/php/footer.php";
?>
