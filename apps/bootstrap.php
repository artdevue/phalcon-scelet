<?php
/**
 * Created by Artdevue.
 * User: artdevue - bootstrap.php
 * Date: 25.02.17
 * Time: 17:19
 * Project: phalcon-blank
 */

require_once PROJECT_PATH . 'vendor/autoload.php';

$config_local = include PROJECT_PATH. 'config/config_local.php';

require PROJECT_PATH . 'config/function.php';

$file_env_config = '.env';

if (array_key_exists(getHostByName(getHostName()), $config_local))
{
    $file_env_config = $config_local[getHostByName(getHostName())];
}

if (!file_exists(PROJECT_PATH . $file_env_config))
{
    if (!copy(PROJECT_PATH . '.env.example', PROJECT_PATH . $file_env_config)) {
        die ("failed to copy .env file");
    }
}

$dotenv = new \Dotenv\Dotenv(PROJECT_PATH, $file_env_config);
$dotenv->load();

/**
 * Read the configuration
 */
$config = include PROJECT_PATH. 'config/config.php';