<?php

# Archiver: recebe, carrega e guarda arquivos no banco de dados [L]

function archiver($archive){
    
    # Pasta onde o arquivo vai ser salvo
    $frame['folder'] = 'cads';

    # Tamanho máximo do arquivo (em Bytes)
    $frame['size'] = 1024 * 1024 * FILE_LIMIT;

    # Array com as extensões permitidas
    $frame['extensions'] = array('jpg', 'png', 'gif', 'jpeg', 'pdf', 'txt', 'ogg', 'mp3', 'txt', 'mp4', 'flv', 'mpeg', 'avi', 'wmv', 'doc', 'docx', 'xls', 'xlsx', 'ppt');

    # Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($archive['file']['error'] != 0) {
      die("Não foi possível fazer o upload, erro:" . $archive['file']['error']);
      exit;
    }

    # Faz a verificação da extensão do arquivo
    $filename = explode('.', $archive['file']['name']);
    $extension = end($filename);
    $extension = strtolower($extension);
    if (array_search($extension, $frame['extensions']) === false) {
      echo "Por favor, envie arquivos apenas os arquivos permitidos.";
      exit;
    }

    # Faz a verificação do size do arquivo
    if ($frame['size'] < $archive['file']['size']) {
      echo "O arquivo enviado é muito grande, envie arquivos de até $frame[size] Mb.";
      exit;
    }

    $filepath = $frame['folder'] . $archive['file']['name'];

    # Depois verifica se é possível mover o arquivo para a folder escolhida
    if (move_uploaded_file($archive['file']['tmp_name'], $filepath)) {
        # Upload efetuado com sucesso
        $type = $archive['file']['type'];
        $encoded = urlBaseEncoder($filepath,$type);
        # Exclui arquivo
        unlink($filepath);
        # Retorna o código
        return array($archive['file']['name'],$type,$encoded);
    } else {
        return false;
    }
}
