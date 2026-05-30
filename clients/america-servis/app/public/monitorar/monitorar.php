<?php
try {
    // Defina a URL manualmente
    $url = 'https://appfacilitiesteste.gpros.com.br/'; 

    $timeout = 5; // segundos

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_message = curl_error($ch);
        $http_code = 0;
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);

    // Espera receber JSON correto
    $expected = '"status":"ok"';

    if ($http_code !== 200 || strpos($response, $expected) === false) {

        try {
            $mensagemParaEnviar = "O Servidor : ".$url.". Está fora, alterar o arquivo public/.htaccess";
            $telefone = "5511978344771";
            $phone_number_id ='314329865089134';
            $token = 'EAAM4IEWO1gsBOz6kF00qzSjjjQf4joZCqCsLTDRUEsmvss7oqji5zRshF7AnuceFTmO3asQA2HvU9K21ZBi6sDW9m8ufnQsPAifZChjQdWZAfg7jOxl1UnuuFDDTbMkqTPJkgu1c5ZA7GNv9Do56HuVWVjonejLpFHZAikQkZBnqxg9EMiCqW7jfpKcYcjfM9TTcwZDZD';
        
        
            $url = "https://graph.facebook.com/v16.0/".$phone_number_id."/messages";
            $header = [    
                'Authorization: Bearer '.$token,
                'Content-Type: application/json'
            ];
        
            $mensagem = "{ \"messaging_product\": \"whatsapp\", \"to\": \"".$telefone."\", \"type\": \"text\", \"text\": { \"preview_url\": false, \"body\": \"".$mensagemParaEnviar."\"} }";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$mensagem);  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            curl_close($ch);
            
            echo json_encode(["success" => $response]) ;
            
        } catch (Throwable $th) {
            echo json_encode(["erro" => $th->getMessage()]);
        }
    } else {
        print_r("funcionou");
        die();
    }
} catch (Throwable $e) {
    print_r($e->getMessage());
    die();
}
?>
