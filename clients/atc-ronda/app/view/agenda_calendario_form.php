
<?
require_once "../inc/php/header.php";
require_once "../inc/php/script_template.php";
?>

<!DOCTYPE html>
<html>
    <head>
		<script src='agenda_calendario_form.js? <?php echo time(); ?>' type="text/javascript" charset="utf-8"></script>
        <script src='../inc/fullcalendar/lang-all.js'></script>
    </head>
    <body class="fixed-left">
        <div class="card-header">
            <h6 class="font-weight-bold text-primary">Agenda</h6>
        </div>
        <br>
        <div class="content-page">
            <div class="content">
                <div class="row">
                <!--div class="col-md-12 portlets"-->
                    <div class="widget">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="widget bg-gray-light">
                                    <div class="widget-body">
                                        <div style="margin:5px" class="row">
                                            <div class="col-md-11 col-sm-11 col-xs-11">
                                                <br>
                                                <div id='usuario' style='font-size: 20px'></div>
                                                <br>
                                                <div id='draggable-events'>
                                                    <div class="draggable-event btn btn-block" style="background-color:#68C39F; color:#ffff">
                                                        <i class="fa fa-move"></i>Reunião
                                                    </div>
                                                    <div class="draggable-event btn btn-block" style="background-color:#6F42C1; color:#ffff">
                                                        <i class="fa fa-move"></i>Reunião Por Vídeo Chamada
                                                    </div>
                                                    <div class="draggable-event btn btn-block" style="background-color:#ff9933; color:#ffff">
                                                        <i class="fa fa-move"></i>Retorno
                                                    </div>
                                                    <div class="draggable-event btn btn-block" style="background-color:#ffff00; color:#000">
                                                        <i class="fa fa-move"></i>Lembrete
                                                    </div>
                                                    <div class="draggable-event btn btn-block" style="background-color:#ff5050; color:#ffff">
                                                        <i class="fa fa-move"></i>Tarefa
                                                    </div>
                                                    <div class="draggable-event btn btn-block" style="background-color:#3399ff; color:#ffff">
                                                        <i class="fa fa-move"></i>Pessoal
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-11 col-sm-11 col-xs-11">
                                                <div class="col-md-12">
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Tipo agenda</label>
                                                    <select class=" form-control form-control-sm" id="tipo_agenda_pesquisa_pk" name="tipo_agenda_pesquisa_pk">
                                                        <option value=''></option>
                                                        <option value='1'>REUNIÃO PRESENCIAL</option>
                                                        <option value='2'>REUNIÃO POR VIDEO CHAMADA</option>
                                                        <option value='3'>LEMBRETE</option>
                                                        <option value='4'>RETORNO</option>
                                                        <option value='5'>TAREFA</option>
                                                        <option value='6'>PESSOAL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Status</label>
                                                    <select class="form-control form-control-sm">
                                                        <option></option>
                                                        <option value='1'>Agenda Pendente</option>
                                                        <option value='2'>Agenda Concluída</option>
                                                        <option value='3'>Agenda Cancelada</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Lead's</label>
                                                    <select id='leads_pk_pesquisa' class="form-control form-control-sm">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Equipe</label>
                                                    <select id='equipes_pk_pesquisa' class="form-control form-control-sm">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="col-md-1">
                                                    &nbsp;
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-sm" id="cmdPesquisarAgenda">Pesquisar</button>                        
                                                </div>      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="widget bg-white">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="calendario"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--/div-->
                </div>
            </div>	
        </div>
    </div>
	<!-- End of page -->
		<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

	</body>
</html>
<?
include_once "agenda_cad_form.php";
echo "<script>var ic_abertura = 1;</script>";
?>