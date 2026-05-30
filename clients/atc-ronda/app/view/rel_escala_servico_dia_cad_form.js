var tblResultado;
var click_id = 0;

function fcCarregarGrid(){  
     var ArrData = dt_ini.split("/");
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano

    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    var dia_semana = data.getDay(); // 0-6 (zero=domingo)
    
    var v_leads_pk = leads_pk;
    var v_colabboradores_pk = colaboradores_pk;
    var dt_agenda_ini = "01/"+(ArrData[1])+"/"+ArrData[2];
    var v_dt_ini = dt_ini;
    var v_turnos_pk = turnos_pk;
    var strRetorno = "";

    var strNenhumRegisto = "";
        var objParametros = {
            "leads_pk": v_leads_pk,
            "colaborador_pk": v_colabboradores_pk,
            "dt_ini": v_dt_ini,
            "turnos_pk":v_turnos_pk,
            "dia_semana":dia_semana
        };    
 
    var arrCarregar = carregarController("agenda_colaborador_padrao", "relatorioEscalaServicoDiaGrid", objParametros); 
 
    if (arrCarregar.result == 'success'){

        if(arrCarregar.data.length > 0){                
                strRetorno+="<table id='tabela' class='table table-striped table-bordered nowrap' style='width:100%' id='tblResultado'>";
                strRetorno+="    <thead>";
                strRetorno+="       <tr>";
                strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
                strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
                strRetorno+="            <th><input type='text' id='txtRE' /></th>";
                strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
                strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
                strRetorno+="            <th><input type='text' id='txtFerias' /></th>";
                strRetorno+="            <th><input type='text' id='txtEscala' /></th>";
                strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                strRetorno+="            <th><input type='text' id='txtDtSaidaPonto' /></th>";
                strRetorno+="       </tr>";
                strRetorno+="       <tr>";
                strRetorno+="           <th>Posto Trabalho</th>";
                strRetorno+="           <th>Função</th>";
                strRetorno+="           <th>R.E</th>";
                strRetorno+="           <th>Colaborador</th>";
                strRetorno+="           <th>Turno</th>";
                strRetorno+="           <th>Férias</th>";
                strRetorno+="           <th>Escala</th>";
                strRetorno+="           <th>Dt/HR Entrada</th>";
                strRetorno+="           <th>Dt/HR Saída</th>";
                strRetorno+="       </tr>";
                strRetorno+="    </thead>";
                strRetorno+="<tbody'>";
            
            for(j=0; j < arrCarregar.data.length ;j++){
                
                var objParametrosFerias = {
                    "colaborador_pk": arrCarregar.data[j]['t_colaboradores_pk'],
                    "dt_agenda": v_dt_ini,
                    "dt_agenda_fim": v_dt_ini,
                    "leads_pk": arrCarregar.data[j]['t_leads_pk']
                        //"dia_semana": i
                };         

                var arrCarregarFerias = carregarController("agenda_colaborador_pausa", "listarFerias", objParametrosFerias);
               
                if(arrCarregarFerias.data.length > 0){ 
                    var ds_ferias = "Sim";
                }
                else{
                    var ds_ferias = " ";
                }
                
                
                var strBackGround = "";
                var strDiaFolga = "";
                var strFontColor = "";
                strDiaFolga = "Folga";
                strFontColor = "red";
                
                
                
                var objParametrosCores = {
                    "colaborador_pk": arrCarregar.data[j]['t_colaboradores_pk'],
                    "dt_agenda": dt_agenda_ini,
                    "dt_agenda_fim": v_dt_ini,
                    "leads_pk": arrCarregar.data[j]['t_leads_pk']
                        //"dia_semana": i
                };         

                var arrCarregarCores = carregarController("agenda_colaborador_pausa", "listarCores", objParametrosCores);
            
                var dt_agenda = "01/"+(ArrData[1])+"/"+ArrData[2];
                if(arrCarregar.data[j]['t_ds_lead']!= null){
                    var ds_lead = arrCarregar.data[j]['t_ds_lead'];
                }else{
                    var ds_lead = "";
                }          
                
                if(arrCarregar.data[j]['t_ds_re']!= null){
                    var ds_re = arrCarregar.data[j]['t_ds_re'];
                }else{
                    var ds_re = "";
                }
                
                
                if(arrCarregar.data[j]['t_ds_colaborador']!= null){
                    var ds_colaborador = arrCarregar.data[j]['t_ds_colaborador'];
                }else{
                    var ds_colaborador = "";
                }
                
                if(arrCarregar.data[j]['t_ds_produto_servico']!= null){
                    var ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico'];
                }else{
                    var ds_produto_servico = "";
                }
                if(arrCarregar.data[j]['t_ds_turnos']!= null){
                    var ds_turno = arrCarregar.data[j]['t_ds_turnos'];
                }else{
                    var ds_turno = "";
                }
                
                
                var hr_turno = "";
                var hr_turno_saida = "";
                
                var dt_ini_agenda = arrCarregar.data[j]['t_dt_inicio_agenda'];

                // Precisamos quebrar a string para retornar cada parte
                var dataSplit = dt_ini_agenda.split('/');

                var day = dataSplit[0]; // 15
                var month = dataSplit[1]; // 04
                var year = dataSplit[2]; // 2019

                // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
                var data_inicio_da_agenda = new Date(year, month - 1, day);


               // Precisamos quebrar a string para retornar cada parte
               var d = dt_agenda_ini.split('/');

               var dayd = d[0]; // 15
               var monthd = d[1]; // 04
               var yeard = d[2]; // 2019

               // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
               var data_d = new Date(yeard, monthd - 1, dayd);
               if(data_inicio_da_agenda <= data_d){
                               
                   if(arrCarregar.data[j]['t_ic_dom']==1){      
                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_seg']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_ter']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_qua']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_qui']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_sex']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_sab']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                }
                else{

                    if(arrCarregar.data[j]['t_ic_dom']==1){      
                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_seg']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_ter']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_qua']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_qui']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_sex']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                           if (day % 2 == 1) {
                               var intInverter = 0;
                           }
                           else{
                               var intInverter = 1;
                           }
                        }
                    }
                    if(arrCarregar.data[j]['t_ic_sab']==1){

                        if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                            if (day % 2 == 1) {
                               var intInverter = 1;
                           }
                           else{
                               var intInverter = 0;
                           }
                        }
                    }

                }
                if(intInverter % 2 == 0){
                   var intInverter = 0;
                }
                else{
                    var intInverter = 1;
                }
                strRetorno+="<tr>";
                
                for(i = 0 ;i< ArrData[0];i++){
                    if (arrCarregarCores.result == 'success'){
                        if(arrCarregarCores.data.length > 0){
                            for(c=0; c < arrCarregarCores.data.length ;c++){
                                //PONTO
                                
                                if(arrCarregarCores.data[c]['dt_hr_ponto']==dt_agenda){
                                     strBackGround = "green";

                                }
                                //FALTA
                                if(arrCarregarCores.data[c]['dt_escala']==dt_agenda){
                                    strBackGround = "orange";

                                }
                                //TROCA COLABORADOR
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivos_pausas_pk']!=null){
                                    strBackGround = "yellow";

                                }
                                //EXCLUSAO
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_exclusao_pk']!=null){
                                    strBackGround = "salmon";

                                }
                                //REMOVER FOLGA
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_exclusao_pk']==null && arrCarregarCores.data[c]['motivos_pausas_pk']==null && arrCarregarCores.data[c]['ds_agenda_colaborador_pausa']!="Férias"){

                                   strDiaFolga = arrCarregarCores.data[c]['ds_agenda_colaborador_pausa'];
                                   strBackGround = "#f2f2f2";

                                }

                                 //ATRIBUIR FOLGA
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_folga_pk']!=null){

                                    strDiaFolga = "Folga";
                                    strBackGround = "#aacaff";
                                }


                            }
                        }
                    }
                    var ArrDatas = dt_agenda.split("/");
                    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
                    //0 dia; 1 mes; 2 ano

                    var dt_semana = new Date(ArrDatas[2], ArrDatas[1] - 1, ArrDatas[0]);
                    //DOMINGO
                    if(dt_semana.getDay()==0){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_dom']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                //intInverter = 0 + intInverter;
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_dom_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                     }
                     //SEGUNDA
                    if(dt_semana.getDay()==1){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_seg']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                        //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_seg_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                     //TERÇA
                    if(dt_semana.getDay()==2){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_ter']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_ter_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{

                                    //TRAB
                                     hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                     hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                       
                                }
                            }
                            else{
                                if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                   }
                                   else{
                                        //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                   }
                                
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    //QUARTA
                    if(dt_semana.getDay()==3){
                                       
                         //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_qua']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qua_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                       }
                                }
                            }
                            else{
                               //FOLGA
                                hr_turno = strDiaFolga;
                                hr_turno_saida = strDiaFolga;
                            }
                        }
                        else{
                           
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                         
                        }
                    }
                    //QUINTA
                    if(dt_semana.getDay()==4){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_qui']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qui_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    //SEXTA
                    if(dt_semana.getDay()==5){
                                       
                       //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_sex']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                    }
                                }
                            }
                            else{
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sex_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                   
                    //SABADO
                    if(dt_semana.getDay()==6){
                         //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_sab']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                    }
                                }
                            }
                            else{

                                //TRAB
                                 hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                 hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sab_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    
                     var p_nova_dt_agenda = dt_agenda.split("/");


                    //pega a data que ja passou pelo for 
                    var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                    var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                    //a cada looping acrescenta mais um dia 
                    nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

                    var dt_agenda = 0;
                    var dia = 0;
                    var mes = 0;
                    var ano = 0;
                    if(nova_dt_agenda_dia_proximo.getDate()<10){
                        dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();
                    }
                    else{
                        dia = nova_dt_agenda_dia_proximo.getDate();
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();
                    }

                    if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                        mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();

                    }
                    else{
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();

                    }                
                    dt_agenda = dia+"/"+mes+"/"+ano;
            
                    
                     
                    
                    intInverter ++ ;
                }
                
                
                
                       
                       
                if(hr_turno!="Folga"){
                    strRetorno+="<td width='10%'>"+ds_lead+"</td>";
                    strRetorno+="<td width='10%'>"+ds_produto_servico+"</td>";
                    strRetorno+="<td width='10%'>"+ds_re+"</td>";
                    strRetorno+="<td width='10%'>"+ds_colaborador+"</td>";

                    strRetorno+="<td width='10%'>"+ds_turno+"</td>";
                    strRetorno+="<td width='10%'>"+ds_ferias+"</td>";
                    strRetorno+="<td width='10%'>Trabalho</td>";
                    strRetorno+="<td width='10%'>"+hr_turno+"</td>";
                    strRetorno+="<td width='10%'>"+hr_turno_saida+"</td>";
                }
                
                strRetorno+="</tr>";
            }

            strRetorno+="</tbody>";
            strRetorno+="</table>";

        }

    }
    else{
        alert('Falhar ao carregar o registro');
    }
    
    if(strRetorno!=""){        
        $("#grid").html(strRetorno);
    }else{ 
        $("#grid").append(strNenhumRegisto);
    }
    
}

pegarUltimoDiaMes = function(year, month){
    var ultimoDia = (new Date(year, month, 0)).getDate();
    return ultimoDia;
};

function pegarPosicaoDiaSemana(data){
    
    var splitData = data.split("/");
    var semana = [0, 1, 2, 3, 4, 5,6];
    var d = new Date(splitData[2], splitData[1] - 1, splitData[0]);
    return semana[d.getDay()];
}

function fcCarregarColaborador(){

    var objParametros = {
        "pk": ds_colaboradores
    };      
    
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 
    if (arrCarregar.result == 'success'){
        $("#ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
    }
        
}

function fcCancelar(){

    sendPost("rel_escala_servico_dia_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

$(document).ready(function(){    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
     
    //fcCarregarColaborador();
 
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    //hora 
    if(hh<10) {
        hh = '0'+hh
    } 

    if(min<10) {
        min = '0'+min
    } 
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;
    
   $("#ds_colaborador").text(ds_colaboradores);
   $("#ds_turnos").text(ds_turnos);
   $("#ds_lead").text(ds_lead);
    
    $("#dt_emissao").text(today);
    $("#dt_ini").text(dt_ini);
 
    fcCarregarGrid();
    
        
    $("#tabela input").keyup(function(){
            var index = $(this).parent().index();
            var nth = "#tabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#tabela tbody tr").show();
            $(nth).each(function(){
                    if($(this).text().toUpperCase().indexOf(valor) < 0){
                            $(this).parent().hide();
                    }
            });
    });
    $("#tabela input").blur(function(){
            $(this).val("");
    });	
    $("#loader").hide();
    $("#exibir").show();

});


