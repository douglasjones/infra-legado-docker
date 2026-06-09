<?php

$posto = isset($_GET['posto']) ? $_GET['posto'] : '';
$local = isset($_GET['local']) ? $_GET['local'] : '';
$query = http_build_query([
    'posto' => $posto,
    'local' => $local,
]);

header('Location: /ronda/legado?' . $query, true, 302);
exit;
