<?require_once "../inc/php/header.php";?>
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
</head>
<script src="mesa_operacional_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<p>  
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
                    <div class="card shadow mb-12">
                        <div class="card-header py-3">
                            <h6 class="font-weight-bold text-primary">Mesa Operacional</h6>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="col-md-12">
                                    <div class="col" align="center">
                                        <div class='col-md-4' align="left">
                                            <label for="leads_pk">Posto de trabalho:&nbsp;</label>
                                        </div>
                                        <div class='col-md-4'>
                                            <select id="leads_pk" class="form-control form-control-sm" name="leads_pk">
                                                <option value=""></option>
                                            </select>
                                            <div class='row' id="alert_leads_pk" style="display:none">
                                                <div class='col-md-12'>
                                                    <strong style="color: red">Por favor, informe o Posto de Trabalho!</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                    <div class="col" align="center">
                                        <div class="col-md-4" align="left">
                                            <label for="turnos_pk">Turno(s):&nbsp;</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select id="turnos_pk" class="form-control form-control-sm" name="turnos_pk">
                                                <option value=""></option>
                                            </select>
                                            <div class='row' id="alert_turnos_pk" style="display:none">
                                                <div class='col-md-12'>
                                                    <strong style="color: red">Por favor, informe o Turno!</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <button type="button" class="btn btn-primary" id="cmdAbrirAcompanhamento">Abrir Acompanhamento</button>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</body>


<?
    require_once "../inc/php/footer.php";
?>
