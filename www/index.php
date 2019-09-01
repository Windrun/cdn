<?php

define('URL_SEP', '/');

$file_system_token = 'asdgbgdaj_ASFASgVFcaxfbh12EQWqeWwd';

$token = $_POST['token'] ?? '';

$response = [
    'code'   => 1, // Error
    'result' => 'ACCESS_DENIED', // Error
];

if ($token === $file_system_token) {
    $root     = __DIR__;
    $action   = $_POST['action'];
    $filename = $root . $_POST['filename'];
    if (DIRECTORY_SEPARATOR !== URL_SEP) {
        $filename = str_replace(URL_SEP, DIRECTORY_SEPARATOR, $filename);
    }

    $result = null;

    switch ($action) {
        case 'is_exist':
            {
                $result = file_exists($filename);
                break;
            }
        case 'add':
            {
                $res = move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                if ($res === true) {
                    $result = $filename;
                } else {
                    $result = 'ADD_FILE_ERROR';
                }
                break;
            }
        case 'delete':
            {
                $result = unlink($filename);
                break;
            }
    }

    if ($result !== null) {
        $response['code']   = 0;
        $response['result'] = $result;
    } else {
        $response['result'] = 'UNDEFINED_ACTION';
    }
}

echo json_encode($response);
