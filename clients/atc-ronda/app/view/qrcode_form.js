function fcCarregarQRCode(pk){
    try {
        var objParametros = {
            "leads_pk": pk
        };
        var arrCarregar = carregarController("agenda_colaborador_padrao", "listarQRCode", objParametros);
        
        var html = "";
        for(var i=0; i< arrCarregar.data.length; i++){

            $('#ds_lead_qr_code').html(arrCarregar.data[i]['ds_lead'])
            $('#ds_endereco_qr_code').html(arrCarregar.data[i]['ds_tel'])
            $('#ds_endereco_qr_code').html(arrCarregar.data[i]['ds_endereco'])

            html = "";
            html += '<br>';
            html += '<div class="row" style="margin:2em 2em 17em 2em;">'
            html += '   <div class="col-lg">';
            html += '       <div class="card shadow mb-4">';
            html += '           <div class="card-header py-3" style="text-align: center;">';
            html += '               <div class="col-md-12">';
            html += '                   <span>Colaborador: '+arrCarregar.data[i]['ds_colaborador']+'</span>';
            html += '               </div>';
            html += '               <div class="col-md-12">';
            html += '                   <span>Pin: '+arrCarregar.data[i]['ds_pin']+'</span>';
            html += '               </div>';
            html += '               <div class="col-md-12">';
            html += '                   <span>Status de Acesso ao APP: '+arrCarregar.data[i]['ds_status']+'</span>';
            html += '               </div>';
            html += '           </div>';
            html += '           <div class="card-body" >';
            if(i % 2 == 0){
                html += '               <br>';
                html += '               <br>';
                html += '               <div class="row">';
                html += '                   <div class="col-md-3">';
                html += '                       &nbsp;';
                html += '                   </div>';
                html += '                   <div class="col-md-4">';
                html += '                       <div id="qrCode'+arrCarregar.data[i]['ds_pin']+'"></div>';
                html += '                   </div>';
                html += '                   <div class="col-md-3">';
                html += '                       <div> <img src='+arrCarregar.data[i]['ds_imagem']+' width="200" height="250"></div>';
                html += '                   </div>';
                html += '               </div>';
                html += '               <br>';
                html += '               <br>';
            }else{
                html += '               <br>';
                html += '               <br>';
                html += '               <div class="row">';
                html += '                   <div class="col-md-3">';
                html += '                       &nbsp;';
                html += '                   </div>';
                html += '                   <div class="col-md-4">';
                html += '                       <div> <img src='+arrCarregar.data[i]['ds_imagem']+' width="200" height="250"></div>';
                html += '                   </div>';
                html += '                   <div class="col-md-3">';
                html += '                       <div id="qrCode'+arrCarregar.data[i]['ds_pin']+'"></div>';
                html += '                   </div>';
                html += '               </div>';
                html += '               <br>';
                html += '               </br>';
            }
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            html += '<br>';
            $('#qrcode-container').append(html);

            let website = arrCarregar.data[i]['ds_pin'];
            if (website) {
                let qrcodeContainer = document.getElementById("qrCode"+arrCarregar.data[i]['ds_pin']);
                qrcodeContainer.innerHTML = "";
                new QRCode(qrcodeContainer, website);
                document.getElementById("qrcode-container").style.display = "block";
            }
        }

        

    } catch (error) {
        alert(error)
    }
}

function fcImprimir(){
    window.print();
}

function fcVoltar(){
    sendPost('lead_res_form.php',{token: token, ic_abertura: 1});
}

$(document).ready(function(){
    fcCarregarQRCode(pk)

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
});