<?php

$diretorio = '/var/www/ravenor.online/public/vipLog';

if (is_dir($diretorio)) {

    $arquivos = scandir($diretorio);

    $arquivos = array_diff($arquivos, array('.', '..'));

    $arquivosXLSX = array_filter($arquivos, function ($arquivo) {
        return pathinfo($arquivo, PATHINFO_EXTENSION) === 'xlsx';
    });

    echo json_encode($arquivosXLSX);
} else {

    echo json_encode(['error' => 'O diretório não existe.']);
}
