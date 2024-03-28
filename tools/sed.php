<?php
function encriptarUsuarioID($usuarioID, $clave)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $usuarioID_encriptado = openssl_encrypt($usuarioID, 'aes-256-cbc', $clave, 0, $iv);
    return base64_encode($iv . $usuarioID_encriptado);
}

function desencriptarUsuarioID($usuarioID_encriptado, $clave)
{
    $usuarioID_encriptado = base64_decode($usuarioID_encriptado);
    $iv_size = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($usuarioID_encriptado, 0, $iv_size);
    $usuarioID_cifrado = substr($usuarioID_encriptado, $iv_size);
    return openssl_decrypt($usuarioID_cifrado, 'aes-256-cbc', $clave, 0, $iv);
}
