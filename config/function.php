<?php
/**
 * Created by Artdevue.
 * User: artdevue - function.php
 * Date: 20.10.17
 * Time: 12:23
 * Project: onepoundlottery
 */

use Phalcon\Di;

function __(string $title, $data = null)
{
    $di = Di::getDefault();
    return $di->get('trans')->_($title, $data);
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && \Library\Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}