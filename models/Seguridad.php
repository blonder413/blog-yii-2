<?php

/**
 * Esta clase implementa métodos de seguridad para encriptar información
 *
 * @author blonder413
 */

namespace app\models;

use yii\base\Model;

class Seguridad extends Model
{
    /**
     * desencripta una cadena de texto encriptada con la función encriptar
     * @param String $texto texto encriptado
     * @return String texto desencriptado
     */
    public static function desencriptar($texto)
    {
        return convert_uudecode(base64_decode($texto));
    }

    /**
     * Encripta de forma reversible una cadena de texto
     * @param String $texto cadena a encriptar
     * @return String texto encriptado
     */
    public static function encriptar($texto)
    {
        if (!$texto == null) {
            return base64_encode(convert_uuencode($texto));
        }
        return "";
    }
}
