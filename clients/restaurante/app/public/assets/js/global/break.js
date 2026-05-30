// noinspection JSUnresolvedFunction,JSStringConcatenationToES6Template

let breakJS = {
    initBinds: function () {
        $('.btn-logout').on('click', $.debounce(1000, true, function (e) {
            utilsJS.jqueryConfirm('Sair?', 'Deseja sair do sistema?', function () {
                $.ajax({
                    type: 'POST',
                    url: '/api/auth/logout',
                    data: {},
                    complete: function (response) {
                        try {
                            let log = JSON.parse(response.responseText);
                            if(log.status == true){
                                location.reload();
                            }
                        } catch (e) {
                            utilsJS.sweetMensagem(false, 'Ocorreu um erro na requisição<br /> Contate o suporte');
                        }
                    }
                });
            }, function () {
            }, 'Tenho certeza', 'Cancelar');
            return false;
        }));

        $('#transferir').on('click', $.debounce(1000, true, function (e) {
            utilsJS.jqueryConfirm('Transferir?', 'Deseja transferir a ligação?', function () {
                $.ajax({
                    type: 'POST',
                    url: '/api/avaya/transfer-blind',
                    data: {},
                    complete: function (response) {
                        try {
                            let log = JSON.parse(response.responseText);
                            if(log.status == true){
                                location.reload();
                            }
                        } catch (e) {
                            utilsJS.sweetMensagem(false, 'Ocorreu um erro na requisição<br /> Contate o suporte');
                        }
                    }
                });
            }, function () {
            }, 'Tenho certeza', 'Cancelar');
            return false;
        }));



        $('div.status-dropdown ul li.option').on('click', function (e) {
            e.preventDefault();
            let id = parseInt($(this).attr('data-id'));
            let label = $(this).attr('data-label');
            let fl_available = parseInt($(this).attr('data-id-available'));

            utilsJS.jqueryConfirm('Alterar status?', 'Deseja alterar seu status para "' + label + '"?', function () {
                utilsJS.loadingDiv($('div.status-dropdown'));
                breakJS.persist(id, function (response) {
                    utilsJS.loadedDiv($('div.status-dropdown'));
                    utilsJS.toastNotify(response.status, response.message);

                    if (response.status) {
                        utilsJS.nativeNotification('Controle de pausa', response.message);

                        if (!response.scheduled) {
                            utilsJS.applyAnimate($('div.status-dropdown'), 'pulse', false);
                            $('div.status-dropdown #dropdownStatusButton a').attr('data-id', id).html(label);
                            $('div.status-dropdown #dropdownStatusButton span.status').removeClass('success danger').addClass((label == 'Disponível') ? 'success' : 'danger');
                            $('.status-dropdown .dropdown-menu li').removeAttr('disabled');
                            $('.status-dropdown .dropdown-menu li[data-id="' + id + '"]').attr('disabled', 'disabled');

                            if (response.data.fl_accept_new_interaction && response.data.fl_accept_new_interaction == 1) {
                                $('.box-queue #tabQueued .tab-pane-info').removeClass('d-none d-block').addClass('d-none');
                                $('.box-queue #tabQueued .tab-queue-capsuled').removeClass('d-none d-block').addClass('d-block');
                            } else {
                                $('.box-queue #tabQueued .tab-pane-info').removeClass('d-none d-block').addClass('d-block');
                                $('.box-queue #tabQueued .tab-queue-capsuled').removeClass('d-none d-block').addClass('d-none');
                            }
                        }
                    }
                });
            }, function () {
            }, 'Tenho certeza', 'Cancelar');
            return false;
        });
    },

    persist: function (id_break, callback) {
        $.ajax({
            type: 'POST',
            url: '/api/avaya/set-reason',
            data: {reason: id_break},
            complete: function (response) {
                try {
                    let log = JSON.parse(response.responseText);
                    if (typeof callback == 'function') {
                        callback(log);
                    }
                } catch (e) {
                    utilsJS.sweetMensagem(false, 'Ocorreu um erro na requisição<br /> Contate o suporte');
                }
            }
        });
    },
}

$(document).ready(function () {
    $("#telefone_chamando").mask("(99)9999-9999");
    breakJS.initBinds();
    //setInterval(verficaLigacao,2000);
});

function verficaLigacao() {
    $.ajax({
        type: 'GET',
        url: '/api/avaya/check-session',
        datatype: 'json',
        data: {},
        timeout: 35000,
        complete: function (response) {
            var log = JSON.parse(response.responseText);
            if(log.data != false){
                if (log.data[0].callID != "undefined"){
                    $('#telefone_chamando').val(log.data[0].phoneNumber);
                    $('#telefone_chamando').css('display', 'block');
                    $('#transferir').css('display', 'block');

                    utilsJS.applyAnimate( $('#transferir'), 'pulse', false);
                    utilsJS.applyAnimate( $('#telefone_chamando'), 'pulse', false);
                }else{
                    $('#telefone_chamando').val('');
                    $('#telefone_chamando').css('display', 'none');
                    $('#transferir').css('display', 'none');

                }
            }else{
                $('#telefone_chamando').val('');
                $('#telefone_chamando').css('display', 'none');
                $('#transferir').css('display', 'none');

            }
        }
    });
}
