<?php

namespace System\Core;

use System\Core\Session;

/**
 * Classe Helpers
 *
 * Uma classe utilitária que fornece diversos métodos auxiliares para operações comuns,
 * incluindo validação, manipulação de strings, gerenciamento de URLs e verificações de ambiente.
 *
 * @package system\Core
 */
class Helpers
{
    /**
     * Verifica se a aplicação está sendo executada em um servidor localhost.
     *
     * @return bool Retorna true se o servidor for localhost, false caso contrário.
     */
    public static function localhost(): bool
    {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');

        return $servidor === 'localhost';
    }

    /**
     * Recupera e exibe uma mensagem flash da sessão, se disponível.
     *
     * @return string|null O conteúdo da mensagem flash ou null se nenhuma mensagem for encontrada.
     */
    public static function flash(): ?string
    {
        $sessao = new Session();

        if ($flash = $sessao->flash()) {
            echo $flash;
        }

        return null;
    }

    /**
     * Redireciona o usuário para uma URL especificada ou para a URL padrão da aplicação.
     *
     * @param string|null $url A URL de destino. Por padrão, redireciona para a URL base da aplicação.
     * @return void
     */
    public static function redirect(string $url = null): void
    {
        header('HTTP/1.1 302 Found');

        $local = $url ? self::url($url) : self::url();

        header("Location: {$local}");
        exit();
    }

    /**
     * Gera uma URL completa com base no ambiente (desenvolvimento ou produção).
     *
     * @param string|null $url O caminho da URL relativa. Por padrão, utiliza a URL base.
     * @return string A URL completa.
     */
    public static function url(string $url = null): string
    {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = $servidor === 'localhost' ? URL_DEVELOPEMENT : URL_PRODUTION;

        if (str_starts_with($url, '/')) {
            return $ambiente . $url;
        }

        return $ambiente . '/' . $url;
    }
}
