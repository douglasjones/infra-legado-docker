var tblResultado;
var click_id = 0;


function fcVerificarPontoColaborador(leads_pk,colaboradores_pk,dt_base){

    var objParametros = {
        "leads_pk": leads_pk,
        "colaborador_pk": colaboradores_pk,
        "dt_base": dt_base
    };  
    
    var intRegistroPonto = 0;
 
    var arrCarregar = carregarController("ponto", "relatorioFalta", objParametros); 
    
    if (arrCarregar.result == 'success'){
        intRegistroPonto = arrCarregar.data[0]['registros'];
    }
    else{
        alert('Falhar ao carregar o registro');
    }
    return intRegistroPonto;
}




function fcCarregarGrid(){  
    var ArrDataIni = dt_ini.split("/");
    var ArrDataFim = dt_fim.split("/");
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano

    var date1 = new Date(ArrDataIni[2], ArrDataIni[1] - 1, ArrDataIni[0]);
    var date2 = new Date(ArrDataFim[2], ArrDataFim[1] - 1, ArrDataFim[0]);

   
    var diffDays = (date2 - date1)/(1000*3600*24);
    
    
    
    
   var v_leads_pk = leads_pk;
   var v_colabboradores_pk = colaboradores_pk;
   var v_dt_ini = dt_ini;
   var v_dt_fim = dt_fim;
   var strRetorno = "";
 
    var objParametros = {
            "leads_pk": v_leads_pk,
            "colaborador_pk": v_colabboradores_pk,
            "dt_ini": v_dt_ini,
            "dt_fim": v_dt_fim
        };    
 
    var arrCarregar = carregarController("agenda_colaborador_padrao", "EscalaServicoDiaGridParaRelatorioFalta", objParametros); 
  
    if (arrCarregar.result == 'success'){
        
        strRetorno+="<table id='tabela' class='table table-striped table-bordered nowrap' style='width:100%' id='tblResultado'>";
        strRetorno+="    <thead>";
        strRetorno+="       <tr>";
        strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
        strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
        strRetorno+="            <th><input type='text' id='txthrEscala' /></th>";
        strRetorno+="            <th><input type='text' id='txtDataFalta' /></th>";
        strRetorno+="       </tr>";
        strRetorno+="       <tr>";
        strRetorno+="           <th>Posto Trabalho</th>";
        strRetorno+="           <th>Colaborador</th>";
        strRetorno+="           <th>HR.Escala</th>";
        strRetorno+="           <th>Data Falta</th>";
        strRetorno+="       </tr>";
        strRetorno+="    </thead>";
        strRetorno+="<tbody'>";
        
        
        
        for(j=0; j < arrCarregar.data.length ;j++){
                
                var intInverter = 1;
                var dt_agenda = v_dt_ini;
                
                
                for(i = 0 ;i< diffDays;i++){
                    var strBackGround = "";
                    var registroPonto = 0;
                    var strDataFalta = "";
                    var hrTurno = "";
                    var hrSaida = "";
                    
                    
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
                                intInverter = 0 + intInverter;
                                if (intInverter % 2 == 0) {
                                       if(strBackGround=="#aacaff"){
                                           
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                              
                                                strDataFalta = dt_agenda;
                                                hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                            }
                                            
                                        }
                                        else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                        }
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                        
                                    }
                                    else if(strBackGround==""){
                                        
                                        //TRAB
                                        registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                        if(registroPonto ==0){
                                            
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                               
                                        }
                                    }
                                    else if(strBackGround=="orange"){
                                        strDataFalta = dt_agenda;
                                       hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                   }
                                    else{
                                        
                                       //TRAB
                                        registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                        if(registroPonto ==0){
                                           
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                                
                                        }
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                   
                                }
                                else if(strBackGround=="#aacaff"){

                               }
                               else if(strBackGround=="orange"){
                                        strDataFalta = dt_agenda;
                                      hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                   }
                               else{
                                   
                                   //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                        
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                                
                                    }
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_dom_folga']==1){
                           
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){

                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                       //TRAB
                                        registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                        if(registroPonto ==0){
                                            
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                                
                                        }
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                                hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];  
                                        }
                                   else if(strBackGround==""){

                                   }
                                   else{

                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){

                                       }
                                       else if(strBackGround=="#aacaff"){

                                           
                                       }
                                       else if(strBackGround==""){
                                           
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                                
                                            }
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                                hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                        }
                                       else{
                                           
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{
                              
                                
                            }
                        }
                        else{
                             
                           //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto == 0){
                                strDataFalta = dt_agenda;

                                hrTurno = arrCarregar.data[j]['t_hr_turno_dom'];
                                hrSaida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                            }
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
                                           
                                       }
                                       else if(strBackGround=="#aacaff"){

                                        }
                                        else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                        }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else{

                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       

                                    }
                                    else if(strBackGround=="orange"){
                                        strDataFalta = dt_agenda;
                                       hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                   }
                                    else if(strBackGround==""){
                                        //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                                
                                            }
                                    }
                                    else{
                                        //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                   hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                   
                                }
                                else if(strBackGround=="#aacaff"){


                               }
                               else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                        }
                               else{

                                   //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                        
                                            strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                        
                                    }
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_seg_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                       
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                    }
                                   else if(strBackGround==""){
                                       
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hhrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                        }
                                   else{
                                        
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                        }
                                       else if(strBackGround==""){
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                                
                                            }
                                       }
                                       else{
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{
                                
                            }
                        }
                        else{
                           
                            //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto ==0){
                                
                                    strDataFalta = dt_agenda;
                                    hrTurno = arrCarregar.data[j]['t_hr_turno_seg'];
                                    hrSaida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                
                            }
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
                                           
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                        }
                                        else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                        }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else{
                                           
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                        }
                                    else if(strBackGround==""){
                                         //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                                
                                            }
                                    }
                                    else{
                                        //TRAB
                                        registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                        if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    
                                }
                                else if(strBackGround=="#aacaff"){

                                    
                               }
                               else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                        }
                               else{

                                  //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                                
                                            }
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_ter_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                       
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                        }
                                   else if(strBackGround==""){
                                       
                                   }
                                   else{
                                        
                                   }
                                }
                                else{

                                    //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                               
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                                
                                            }
                                       
                                }
                            }
                            else{
                                if(strBackGround=="#f2f2f2"){
                                        
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                        }
                                   else if(strBackGround==""){
                                       //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                               
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                                
                                            }
                                   }
                                   else{
                                        
                                   }
                                
                            }
                        }
                        else{
                            //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto ==0){
                                                
                                    strDataFalta = dt_agenda;
                                    hrTurno = arrCarregar.data[j]['t_hr_turno_ter'];
                                    hrSaida = arrCarregar.data[j]['t_hr_turno_ter_saida'];

                            }
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
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                         
                                        }
                                        else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else{
                                          
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                       
                                    }
                                    else if(strBackGround=="#aacaff"){
                                        
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        }
                                    else if(strBackGround==""){

                                         //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                                
                                            }
                                    }
                                    else{

                                        //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){

                                }
                                else if(strBackGround=="#aacaff"){

                                    
                               }
                               else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        }
                               else{
                                   //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                       
                                            strDataFalta = dt_agenda;
                                           hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        
                                    }
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qua_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        }
                                   else if(strBackGround==""){
                                      
                                   }
                                   else{
                                        
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                        }
                                       else if(strBackGround==""){
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                                
                                            }
                                       }
                                       else{
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{
                               
                            }
                        }
                        else{
                           
                            //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto ==0){
                               
                                    strDataFalta = dt_agenda;
                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qua'];
                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                
                            }
                         
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
                                           
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                       }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                        }
                                       else{
                                            
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                       
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                        }
                                    else if(strBackGround==""){
                                         //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                                
                                            }
                                    }
                                    else{
                                        //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    
                                }
                                else if(strBackGround=="#aacaff"){

                                    
                               }
                               else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                        }
                               else{

                                   //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                                
                                            }
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qui_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                   }
                                   else if(strBackGround==""){
                                       
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                        }
                                   else{
                                       
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                           hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                        }
                                       else if(strBackGround==""){
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                                
                                            }
                                       }
                                       else{
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                               
                                                    strDataFalta = dt_agenda;
                                                   hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{
                                
                            }
                        }
                        else{
                            //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto ==0){
                                                
                                    strDataFalta = dt_agenda;
                                    hrTurno = arrCarregar.data[j]['t_hr_turno_qui'];
                                    hrSaida = arrCarregar.data[j]['t_hr_turno_qui_saida'];

                            }
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
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                        }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else{
                                            
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                        }
                                    else if(strBackGround==""){
                                         //TRAB
                                         
                                        registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                        if(registroPonto ==0){
                                                
                                                strDataFalta = dt_agenda;
                                                hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];

                                        }
                                    }
                                    else{
                                        //TRAB
                                        
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{
                                   //TRAB
                                    registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                    if(registroPonto ==0){
                                                
                                            strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];

                                    }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sex_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                        }
                                   else if(strBackGround==""){
                                       
                                   }
                                   else{
                                        
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                             hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                        }
                                       else if(strBackGround==""){
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                                
                                            }
                                       }
                                       else{
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{
                                
                               
                            }
                        }
                        else{
                             //TRAB
                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                            if(registroPonto ==0){
                                                
                                    strDataFalta = dt_agenda;
                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sex'];
                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sex_saida'];

                            }
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
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                        }
                                       else if(strBackGround==""){
                                           
                                       }
                                       else{
                                            
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        
                                    }
                                    else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                        }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                               
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                                
                                            }
                                    }
                                    else{
                                        //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                                
                                            }
                                    }
                                }
                            }
                            else{

                                //TRAB
                                registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                if(registroPonto ==0){
                                                
                                        strDataFalta = dt_agenda;
                                        hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                        hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];

                                }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sab_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                       
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       
                                   }
                                   else if(strBackGround==""){
                                       
                                   }
                                   else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                        }
                                   else{
                                        
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           
                                           
                                       }
                                       else if(strBackGround=="orange"){
                                             strDataFalta = dt_agenda;
                                            hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                        }
                                       else if(strBackGround==""){
                                           //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                               
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                                
                                            }
                                       }
                                       else{
                                            //TRAB
                                            registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                                            if(registroPonto ==0){
                                                
                                                    strDataFalta = dt_agenda;
                                                    hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                                    hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                                
                                            }
                                       }
                                }
                            }
                            else{

                            }
                        }
                        else{
                            //TRAB
                             registroPonto = fcVerificarPontoColaborador(arrCarregar.data[j]['t_leads_pk'],arrCarregar.data[j]['t_colaboradores_pk'],dt_agenda);
                             if(registroPonto ==0){
                                
                                strDataFalta = dt_agenda;
                                hrTurno = arrCarregar.data[j]['t_hr_turno_sab'];
                                hrSaida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                                
                             }
                         }
                    }
                    if(registroPonto == 0 && strDataFalta !=""){
                        strRetorno+="<td width='10%'>"+arrCarregar.data[j]['t_ds_lead']+"</td>";
                        strRetorno+="<td width='10%'>"+arrCarregar.data[j]['t_ds_colaborador']+"</td>";
                        strRetorno+="<td width='10%'>"+hrTurno+ " / "+hrSaida+"</td>";
                        strRetorno+="<td width='10%'>"+strDataFalta+"</td>";


                        strRetorno+="</tr>";
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

    sendPost("rel_falta_colaborador_res_form.php", {token: token});
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
   $("#ds_lead").text(ds_lead);
    
    $("#dt_emissao").text(today);
    $("#dt_ini").text(dt_ini);
    $("#dt_fim").text(dt_fim);
   
    fcCarregarGrid();
    $("#loader").hide();
    $("#exibir").show();
        
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

});


