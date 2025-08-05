<?php

// Verifica se o nome do arquivo foi enviado como parâmetro na URL
if (isset($_GET['nome_arquivo'])) {
    // Recupera e decodifica o nome do arquivo
    $nome_arquivo = urldecode($_GET['nome_arquivo']);

    // Diretório onde estão os arquivos
    $diretorio = '/var/www/ravenor.online/public/vipLog';

    // Caminho completo do arquivo
    $filePath = $diretorio . '/' . $nome_arquivo;

    // Verifica se o arquivo existe
    if (file_exists($filePath)) {
        // Define o tipo de conteúdo como Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // Indica que é um arquivo para download
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        // Lê o arquivo e envia para saída
        readfile($filePath);
        exit; // Encerra o script após o download do arquivo
    } else {
        // Arquivo não encontrado
        echo "Arquivo não encontrado.";
    }
} else {
    // Se o nome do arquivo não foi fornecido na URL
    echo "Nome do arquivo não especificado.";
}
?>
