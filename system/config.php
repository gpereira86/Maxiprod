<?php

use Dotenv\Dotenv;
use System\Core\Helpers;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Carrega as variáveis de ambiente e define constantes essenciais.
 *
 * Este script inicializa a configuração do sistema, carregando as variáveis de ambiente a partir do arquivo `.env`
 * e definindo constantes que são utilizadas em toda a aplicação, como informações sobre o site e configuração de banco de dados.
 */
date_default_timezone_set('America/Sao_Paulo');

define('COMPANY', 'Maxiprod');
define('MY_NAME', 'Glauco Pereira');
define('SITE_DESCRIPTION', 'Teste de Programação Maxiprod - Glauco Pereira');

define('URL_PRODUTION', 'https://maxiprodtest.glaucopereira.com');
define('URL_DEVELOPEMENT', 'http://localhost/maxiprod');

if (Helpers::localhost()) {

    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_NAME', 'maxiprod');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');

    define('SITE_URL', '/maxiprod/');
} else {

    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_PORT', $_ENV['DB_PORT']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

    define('SITE_URL', '/');
}
