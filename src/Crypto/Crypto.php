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
    public static function getRandomBytes($length = 32)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $strong);

            if ($strong === true) {
                return base64_encode($bytes);
            }
        }

        $sha = '';
        $bytes = '';

        if (file_exists('/dev/urandom')) {
            $fp = fopen('/dev/urandom', 'rb');

            if ($fp) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($fp, 0);
                }

                $sha = fread($fp, $length);
                fclose($fp);
            }
        }

        for ($i = 0; $i < $length; $i += 1) {
            $sha = hash('sha256', $sha.mt_rand());
            $char = mt_rand(0, 62);
            $bytes .= chr(hexdec($sha[$char] . $sha[$char + 1]));
        }

        return base64_encode($bytes);
    }

    public static function encrypt($data, $key)
    {
        $key = base64_decode($key);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $mac = hash_hmac('sha256', $data, substr(bin2hex($key), -32));
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($encrypted). '|' . base64_encode($iv);

        return $encoded;
    }

    public static function decrypt($data, $key)
    {
        $data = explode('|', $data);
        $key = base64_decode($key);
        $decoded = base64_decode($data[0]);
        $iv = base64_decode($data[1]);

        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }

        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $hash = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));

        if ($hash !== $mac) {
            return false;
        }

        return $decrypted;
    }

    public static function encryptUri($data, $key)
    {
        $encoded = self::encrypt($data, $key);
        $rewritten = strtr($encoded, '+/', '-_');

        return chunk_split($rewritten, 10, '/');
    }

    public static function decryptUri($data, $key)
    {
        $rewritten = implode('', explode('/', $data));
        $encoded = (str_pad(strtr($rewritten, '-_', '+/'), strlen($rewritten) % 4, '=', STR_PAD_RIGHT));

        return self::decrypt($encoded, $key);
    }
}