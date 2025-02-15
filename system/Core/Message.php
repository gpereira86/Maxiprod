<?php

namespace System\Core;

/**
 * Classe Message
 *
 * Esta classe é responsável por criar e renderizar mensagens estilizadas, como sucesso, erro, aviso e notificações,
 * utilizando classes do Bootstrap. Ela fornece métodos para filtrar e higienizar o conteúdo das mensagens
 * e inclui suporte para mensagens temporárias através do armazenamento na sessão.
 */
class Message
{
    private $text;
    private $css;

    /**
     * Converte o objeto Message para uma representação de string.
     *
     * @return string O HTML renderizado da mensagem.
     */
    public function __toString(): string
    {
        return $this->messageRender();
    }

    /**
     * Define a mensagem como uma mensagem de sucesso.
     *
     * @param string $message O texto da mensagem de sucesso.
     * @return $this A instância atual da classe Message para encadeamento de métodos.
     */
    public function success(string $message): Message
    {
        $this->css = 'alert alert-success';
        $this->text = $this->messageFilter($message);
        return $this;
    }

    /**
     * Define a mensagem como uma mensagem de erro.
     *
     * @param string $message O texto da mensagem de erro.
     * @return $this A instância atual da classe Message para encadeamento de métodos.
     */
    public function messageError(string $message): Message
    {
        $this->css = 'alert alert-danger';
        $this->text = $this->messageFilter($message);
        return $this;
    }

    /**
     * Define a mensagem como uma mensagem de aviso.
     *
     * @param string $message O texto da mensagem de aviso.
     * @return $this A instância atual da classe Message para encadeamento de métodos.
     */
    public function messageAlert(string $message): Message
    {
        $this->css = 'alert alert-warning';
        $this->text = $this->messageFilter($message);
        return $this;
    }

    /**
     * Define a mensagem como uma mensagem de notificação.
     *
     * @param string $message O texto da mensagem de notificação.
     * @return $this A instância atual da classe Message para encadeamento de métodos.
     */
    public function messageNotify(string $message): Message
    {
        $this->css = 'container alert alert-primary';
        $this->text = $this->messageFilter($message);
        return $this;
    }

    /**
     * Renderiza a mensagem como uma string HTML.
     *
     * Inclui um botão de descarte para mensagens estilizadas com Bootstrap.
     *
     * @return string O HTML renderizado para a mensagem.
     */
    public function messageRender(): string
    {
        $button = '<div class="col-auto"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button></div>';

        return "<div class='{$this->css}'><div class='row d-flex justify-content-between align-items-center'><div class='col'>{$this->text}</div> $button</div></div>";
    }

    /**
     * Filtra e higieniza o texto da mensagem para prevenir ataques XSS.
     *
     * @param string $message O texto bruto da mensagem.
     * @return string O texto da mensagem higienizado.
     */
    private function messageFilter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Armazena a mensagem atual na sessão como uma mensagem flash.
     *
     * Mensagens flash são temporárias e devem ser exibidas apenas uma vez.
     *
     * @return void
     */
    public function flash(): void
    {
        (new Session())->create('flash', $this);
    }
}
