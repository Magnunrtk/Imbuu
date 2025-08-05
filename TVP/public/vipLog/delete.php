<?php

if (isset($_POST['nome_arquivo'])) {

    $nomeArquivo = filter_var($_POST['nome_arquivo'], FILTER_SANITIZE_STRING);

    $diretorio = '/var/www/ravenor.online/public/vipLog';

    $caminhoArquivo = $diretorio . '/' . $nomeArquivo;

    if (file_exists($caminhoArquivo) && is_file($caminhoArquivo)) {

        if (unlink($caminhoArquivo)) {

            echo json_encode(['success' => true, 'message' => 'Arquivo deletado com sucesso.']);
        } else {

            echo json_encode(['success' => false, 'message' => 'Erro ao deletar o arquivo.']);
        }
    } else {

        echo json_encode(['success' => false, 'message' => 'O arquivo não existe ou não é um arquivo regular.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nome do arquivo não especificado.']);
}
