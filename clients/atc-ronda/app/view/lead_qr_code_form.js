function fcAbrirModalFolha(pk,ds_lead){

    $("#grid").empty();
    var str = "";
    var objParametros = {
        "leads_pk": pk
    };
    var arrCarregar = carregarController("agenda_colaborador_padrao", "listarQRCode", objParametros);
    
    if (arrCarregar.result == 'success'){
        var i = 0
        for(t=0;t<arrCarregar.data.length;t++){
            
            $(".ds_lead_qr_code").text(arrCarregar.data[t]['ds_lead']);
            $(".ds_tel_qr_code").text(arrCarregar.data[t]['ds_tel']);
            $(".ds_endereco_qr_code").text(arrCarregar.data[t]['ds_endereco']);
            var ds_imagem = "";
            
            if(arrCarregar.data[t]['ds_imagem']==null){
                ds_imagem="../img/usuario_sem_imagem.png";
            }else{
                ds_imagem=arrCarregar.data[t]['ds_imagem'];
            }
            var dt_liberacao = "";
            
            if(arrCarregar.data[t]['dt_liberacao']==null){
                dt_liberacao="";
            }else{
                dt_liberacao=arrCarregar.data[t]['dt_liberacao'];
            }
            var ds_pin = "";
            
            if(arrCarregar.data[t]['ds_pin']==null){
                ds_pin="";
            }else{
                ds_pin=arrCarregar.data[t]['ds_pin'];
            }
            var ds_status = "";
            
            if(arrCarregar.data[t]['ds_status']==null){
                ds_status="";
            }else{
                ds_status=arrCarregar.data[t]['ds_status'];
            }
            var ds_colaborador = "";
            
            if(arrCarregar.data[t]['ds_colaborador']==null){
                ds_colaborador="";
            }else{
                ds_colaborador =arrCarregar.data[t]['ds_colaborador'];
            }
            
            //str +="<page size='A4'>";
            str +="<div class='row ' >";
            str +="<div class='col-md-2'>&nbsp;</div>";
            str +="<div class='col-md-8'>";
            str +="<table style='width=100%' >";
            str +="<thead style='border-style: solid;'>";
            str +="<tr width=100%' align=center>";
            str +="<th colspan='7' nowrap style='border-style: solid;background-color:cdcdcd'align=center>";
            str +="<b>Posto de Trabalho: "+ds_lead;
            str +="</b>";
            str +="</th>";
            str +="</thead>";
            str +="<tbody >";
            
            if (t % 2 == 0) {
                

                str +="</tr>";
                str +="<tr align=center>";
                str+="<th style='border-style: solid;width=100%'><br>Colaborador:"+ds_colaborador+"<br>Pin : "+ds_pin+" <br> Status Liberação acesso ponto APP : "+ds_status+" <br> Data Liberação acesso APP Ponto "+dt_liberacao+"<br><br><br><div align=center ><img src="+ds_imagem+" width='200' height='250'></div><br>";
                str+="<th  style='border-style: solid;width=100%;'><div align=center class='qr_code"+ds_pin+"'></div></th>";
                str +="</tr>";
            }
            else{
                str +="<tr align=center>";
                str+="<th style='border-style: solid;width=100%' class='galeria'><div align=center id='qr_code"+ds_pin+"' class='qr_code"+ds_pin+"'></th>";
                str+="<th style='border-style: solid;width=100%'><br>Colaborador:"+ds_colaborador+"<br>Pin : "+ds_pin+" <br> Status Liberação acesso ponto APP : "+ds_status+" <br> Data Liberação acesso APP Ponto "+dt_liberacao+"<br><br><br><div align=center ><img src="+ds_imagem+" width='200' height='250'></div><br>";
                str+="</th>";
                str +="</tr>";
            }
            
            
            
            //ESPAÇO
            str +="<tr >";
            str +="<th  rowspan=3 colspan=2 style='width=100%' class='galeria'><br><br><br><br><br></th>";
            str +="</tr>";
            str +="<tr '>";
            str +="</tr>";
            str +="<tr '>";
            
            str +="</tr>";
            
            
            
            

            
            str +="</tbody>";
            str +="</table>";
            str +="</div>";
            str +="</div>";  
            str +="<br>"; 
            //str +="</page>"; 
            i++;
            if(i==3){
                var i =0;
                str +="<div style='page-break-after:always'></div>";  
            }
           //str +="</page>";  
           
        }
       
    }
    $("#grid").append(str);
 
    //$("#janela_impressao").modal();
    
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

function fcVoltar(){
    sendPost('lead_res_form.php',{token: token});
}
function fcImprimir(){
    window.print();
    
}

function gerarQrCode(pk){
    try {
        
    var objParametros = {
        "leads_pk": pk
    };
    var arrCarregar = carregarController("agenda_colaborador_padrao", "listarQRCode", objParametros);
  
    
    if (arrCarregar.result == 'success'){
        for(t=0;t<arrCarregar.data.length;t++){

            let website = "PR01-1";

            if (website) {
                let qrcodeContainer = $("qr_codePR01-1")
                    qrcodeContainer.innerHTML = "";
                    new QRCode(qrcodeContainer, website);
            } else {
                alert("Colaborador Invalido");
            }
        }
    }
    } catch (error) {
        alert(error)
    }
}


$(document).ready(function(){
    fcAbrirModalFolha(pk,ds_lead);
    
    $("#loader").hide();
    $("#exibir").show();
    

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);
    /*setTimeout(function(){
        gerarQrCode(pk);
    }, 200);*/
    
    
});