<?php

require_once 'UsersApi.php';

try {
    $api = new usersApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

?>