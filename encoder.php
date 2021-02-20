<?php

# Encoder PHP: transforma arquivos em base64 com URL [L]

# urlBaseEncoder($file, $mime) :: $mime = 'application, image, audio'
function urlBaseEncoder($file, $type){

    $data = file_get_contents($file);
    $basecoded = 'data:' . $type . ';base64,' . base64_encode($data);

    return $basecoded;
    
}





