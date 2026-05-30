<?php
    if (isset($_FILES) && isset($_FILES['FilesPic'])){
        move_uploaded_file($_FILES['FilesPic']['tmp_name'], '../docs/arquivosImportLancamento/'. $_FILES['FilesPic']['name']);
        echo '1';
    }
    echo '0';

?>
