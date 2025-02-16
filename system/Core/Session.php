<?php

namespace System\Core;

/**
 * Classe Session
 *
 * Fornece funcionalidades de gerenciamento de sessão, incluindo criação,
 * recuperação, verificação, limpeza e manipulação de IP do usuário e mensagens flash.
 *
 * @package system\Core
 */
class Session
{
    /**
     * Construtor da sessão.
     *
     * Inicializa a sessão e garante que o endereço IP do usuário seja armazenado
     * caso ainda não esteja presente na sessão.
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Cria ou atualiza uma variável de sessão.
     *
     * @param string $chave O nome da variável de sessão.
     * @param mixed  $valor O valor a ser armazenado na variável de sessão.
     * @return Session Retorna a instância atual da sessão para encadeamento de métodos.
     */
    public function create(string $chave, mixed $valor): Session
    {
        $_SESSION[$chave] = $valor;
        return $this;
    }

    /**
     * Verifica se uma variável de sessão existe.
     *
     * @param string $chave O nome da variável de sessão a verificar.
     * @return bool Retorna true se a variável de sessão existir, false caso contrário.
     */
    public function check(string $chave): bool
    {
        return isset($_SESSION[$chave]);
    }

    /**
     * Limpa uma variável específica da sessão.
     *
     * @param string $chave O nome da variável de sessão a ser limpa.
     * @return Session Retorna a instância atual da sessão para encadeamento de métodos.
     */
    public function clear(string $chave): Session
    {
        unset($_SESSION[$chave]);
        return $this;
    }

    /**
     * Destrói a sessão atual, limpando todos os dados de sessão.
     *
     * @return Session Retorna a instância atual da sessão para encadeamento de métodos.
     */
    public function delete(): Session
    {
        session_destroy();
        return $this;
    }

    /**
     * Método mágico para recuperar o valor de uma variável de sessão.
     *
     * @param string $atributo O nome da variável de sessão.
     * @return mixed|null Retorna o valor da variável de sessão ou null se não estiver definida.
     */
    public function __get($atributo)
    {
        return $this->check($atributo) ? $_SESSION[$atributo] : null;
    }

    /**
     * Recupera e limpa a mensagem flash armazenada na sessão.
     *
     * @return Message|null Retorna a mensagem flash se existir, ou null caso contrário.
     */
    public function flash(): ?Message
    {
        if ($this->check('flash')) {
            $flash = $this->flash;
            $this->clear('flash');
            return $flash;
        }
        return null;
    }


}
