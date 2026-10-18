<?php
// Leector de varibables de entorno 
// para proteger datos sensibles y evitar 
// codigo quemado

class Env {//Clase Env
    public static function load($path) {//Funcion para descargar archivo .env
        $file = $path . '/.env';
        
        if (!file_exists($file)) {
            return;
        }

        // Leer el archivo línea por línea
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Dividir la línea en Nombre y Valor
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            // Establecer la variable de entorno en PHP
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
?>