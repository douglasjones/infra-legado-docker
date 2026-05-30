<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "libs/maininclude.php";
    // Abre ou cria o arquivo bloco1.txt
    // "a" representa que o arquivo � aberto para ser escrito
    $fp = fopen("fast.txt", "a");
    $sql ="";
    $sql.=" SELECT lf.LOJA,
                lf.CNPJ,
                lf.IE,
                lf.EMAIL,
                lf.ENDERECO,
                lf.NUMERO,
                lf.COMPLEMENTO,
                lf.CEP,
                lf.BAIRRO,
                lf.CODMUNICIPIO,
                lf.CIDADE,
                lf.UF
            FROM lojas_fast lf"; 
 
    $result = sql_query($sql);
    fwrite($fp,"CLIENTE|85\r\n");
    while($row = mysql_fetch_array($result)){  
        fwrite($fp,"A|1.02\r\n");
        
        $LOJA = trim($row['LOJA']);
        $CNPJ = trim($row['CNPJ']);
        $IE = trim($row['IE']);
        $EMAIL = trim($row['EMAIL']);
        $ENDERECO = trim($row['ENDERECO']);
        $NUMERO = trim($row['NUMERO']);
        $COMPLEMENTO = trim($row['COMPLEMENTO']);
        $CEP = trim(str_replace("-","",$row['CEP']));
        $BAIRRO = trim($row['BAIRRO']);
        $CODMUNICIPIO = trim($row['CODMUNICIPIO']);
        $CIDADE = trim($row['CIDADE']);
        $UF = trim($row['UF']);
        
        //emisor
        $linha = "E|CNPJ|".$CNPJ."|".$LOJA."|".$IE."||".$ENDERECO."|".$NUMERO."|".$COMPLEMENTO."|".$BAIRRO."|".$CODMUNICIPIO."|".$CIDADE."|".$UF."|".$CEP."|1058|BRASIL||".$EMAIL."\r\n";
        //NOTA FISCAL
        //$linha = "A|3.10|NFe||\r\n";
        //$linha = "B|35|\r\n";
        fwrite($fp,$linha);       
    }
    mysql_free_result($result);
    // Fecha o arquivo
    fclose($fp);

 

?>


