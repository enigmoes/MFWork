<?php
declare(strict_types = 1);

class Tools
{
    // Funcion que limpia una cadena
    public static function clean($string, $html = false)
    {
        $string = addslashes($string);
        $string = trim($string);
        if ($html === true) {
            $string = htmlspecialchars($string);
        }
        return $string;
    }

    // Funcion que retorna la IP desde la que se accede
    public static function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    // Funcion que retorna la url desde la que se accede una la pagina
    public static function getUri()
    {
        $uri = "";
        if(isset($_SERVER['HTTPS'])) {
            $uri = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        } else {
            $uri = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
        }
        $uri = explode('?', $uri);
        return $uri[0];
    }

    // Funcion que genera una cadena segura aleatoria con la longitud indicada
    public static function getToken($length = 32)
    {
        $token = "";
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alphabet .= "abcdefghijklmnopqrstuvwxyz";
        $alphabet .= "0123456789";
        for ($i = 0; $i < $length; $i++) {
            $random = Tools::crypto_rand_secure(0, strlen($alphabet));
            if ($random > 0) {
                $token .= $alphabet[$random];
            }
        }
        return $token;
    }

    /**
     * Crypto Rand Secure
     * Función para generar cadena segura a nivel de bit
     * @param int $min longitud mínima
     * @param int $max longitud máxima
     */
    public static function crypto_rand_secure($min, $max)
    {
        $range = $max - $min; // generamos rango
        $random = $min; // asignamos valor minimo a random (no seguro)
        // si es mayor que 0
        if ($range > 0) {
            $log = log($range, 2);
            $bytes = (int) ($log / 8) + 1; // longitud en bytes
            $bits = (int) $log + 1; // longitud en bits
            $filter = (int) (1 << $bits) - 1; // desplaza cada bit tantos como logitud de $bits
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // descarta bits coincidentes en ambas variables
            } while ($rnd >= $range);
            // actualizamos random var
            $random = $min + $rnd;
        }
        return $random;
    }
}