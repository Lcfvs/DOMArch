<?php
/*
Copyright 2015 Lcf.vs
 -
Released under the MIT license
 -
https://github.com/Lcfvs/DOMArch
*/
namespace DOMArch;

class Crypto
{
    const
        AES_256_CBC = 'aes-256-cbc';

    public static function getRandomBytes($encoded = true)
    {
        $length = openssl_cipher_iv_length(self::AES_256_CBC);
        $bytes = openssl_random_pseudo_bytes($length, $strong);

        if (!$encoded) {
            return $bytes;
        }

        return base64_encode($bytes);
    }

    public static function encrypt($data, $key)
    {
        $key = base64_decode($key);
        $iv = self::getRandomBytes(false);
        $encrypted = openssl_encrypt($data, self::AES_256_CBC, $key, 0, $iv);
        $encoded = base64_encode($encrypted). ':' . base64_encode($iv);

        return $encoded;
    }

    public static function decrypt($data, $key)
    {
        $data = explode(':', $data);
        $key = base64_decode($key);
        $decoded = base64_decode($data[0]);
        $iv = base64_decode($data[1]);
        $decrypted = openssl_decrypt($decoded, self::AES_256_CBC, $key, 0, $iv);

        return $decrypted;
    }

    public static function encryptUri($data, $key)
    {
        $encoded = self::encrypt($data, $key);
        $rewritten = strtr($encoded, '+/', '-_');

        return '/' . chunk_split($rewritten, 10, '/');
    }

    public static function decryptUri($data, $key)
    {
        $rewritten = implode('', explode('/', $data));
        $encoded = (str_pad(strtr($rewritten, '-_', '+/'), strlen($rewritten) % 4, '=', STR_PAD_RIGHT));

        return self::decrypt($encoded, $key);
    }
}