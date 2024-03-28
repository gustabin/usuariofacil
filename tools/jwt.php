<?php
function jwt_encode($payload, $secret)
{
    $header = json_encode(array('typ' => 'JWT', 'alg' => 'HS256'));
    $header = base64_encode($header);
    $payload = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
    $signature = base64_encode($signature);
    return "$header.$payload.$signature";
}

// Función para validar el token JWT
function jwt_decode($token, $secret)
{
    list($header, $payload, $signature) = explode('.', $token);
    $data = "$header.$payload";
    $raw_signature = base64_decode($signature);
    $valid_signature = hash_hmac('sha256', $data, $secret, true);
    if ($raw_signature !== $valid_signature) {
        return false; // Firma no válida
    }
    $decoded = json_decode(base64_decode($payload), true);
    $current_time = time();
    if ($decoded['exp'] < $current_time) {
        return false; // Token expirado
    }
    return $decoded;
}
