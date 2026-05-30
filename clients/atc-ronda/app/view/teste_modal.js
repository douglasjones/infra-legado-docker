function abreModal() {


    $('#abrir').modal({backdrop: 'static', keyboard: false});
}

$(document).ready(function(){

    $('#abrir').addClass('modal fade');
    $(document).on('click', '#cmd1', abreModal);


})
