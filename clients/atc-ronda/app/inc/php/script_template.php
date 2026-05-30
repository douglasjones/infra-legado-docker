<META HTTP-EQUIV="Cache-Control" content="max-age=0">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" crossorigin="anonymous">

<link rel = "stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<link rel="stylesheet" href="<?php echo PATH;?>inc/js/bootstrap/css/bootstrap.min.css">



<link href="<?php echo PATH;?>inc/js/bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo PATH;?>inc/js/bootstrap/css/bootstrap-datepicker3.css" rel="stylesheet">
<link href="<?php echo PATH;?>inc/js/bootstrap/css/bootstrap-datepicker3.standalone.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?php echo PATH;?>inc/js/datatables/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo PATH;?>inc/js/datatables/responsive.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo PATH;?>inc/js/datatables/jquery.dataTables.css"/>

<!--links externos-->
<link rel="stylesheet" href="<?php echo PATH;?>inc/css/bestflow.css?<?php echo time(); ?>">

<script src='../inc/fullcalendar/lib/moment.min.js'></script>
<script src='../inc/fullcalendar/lib/jquery.min.js'></script>
<script src='../inc/fullcalendar/fullcalendar.js'></script>
<link rel='stylesheet' href='../inc/fullcalendar/fullcalendar.css' />

<script src="<?= PATH;?>inc/js/highcharts/highcharts.js"></script>
<script src="<?= PATH;?>inc/js/highcharts/highcharts-3d.js"></script>
<script src="<?= PATH;?>inc/js/highcharts/highcharts-3d.src.js"></script>
<!--<script src="<?= PATH;?>js/highcharts/modules/series-label.js"></script>-->
<script src="<?= PATH;?>inc/js/highcharts/modules/exporting.js"></script>
<script src="<?= PATH;?>inc/js/highcharts/modules/export-data.js"></script>



<link href="<?php echo PATH;?>inc/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PATH;?>inc/js/jquery/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo PATH;?>inc/js/jquery/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="<?php echo PATH;?>inc/js/jquery/jquery.fileupload.js" type="text/javascript"></script>


<script src="<?php echo PATH;?>inc/js/jquery.validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo PATH;?>inc/js/jquery.validate/additional-methods.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo PATH;?>inc/js/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo PATH;?>inc/js/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo PATH;?>inc/js/datatables/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?php echo PATH;?>inc/js/datatables/dataTables.responsive.min.js"></script>

<script src="<?php echo PATH;?>inc/js/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo PATH;?>inc/js/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo PATH;?>inc/js/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo PATH;?>inc/js/bootstrap/locales/bootstrap-datepicker.pt-BR.min.js"></script>

<script type="text/javascript" src="<?php echo PATH;?>inc/js/outros/jsapi"></script>
<script type="text/javascript" src="<?php echo PATH;?>inc/js/bestflow/bestflow.js?<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo PATH;?>inc/js/bestflow/apireceitaws.js?<?php echo time(); ?>"></script>


<!--Template-->



<style>
@import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}
</style>