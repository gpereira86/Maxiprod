<?php

namespace System\Core;

use System\Support\Template;

/**
 * Classe Controller
 *
 * Representa um controlador base na aplicação, fornecendo acesso a recursos comuns,
 * como o motor de renderização de templates e o gerenciamento de mensagens.
 *
 * @package system\Core
 */
class Controller
{
    protected Template $template;
    protected Message $message;

    /**
     * Construtor do Controller.
     *
     * Inicializa o controlador base com um diretório de templates especificado
     * e prepara o sistema de gerenciamento de mensagens.
     *
     * @param string $diretorio O diretório onde os arquivos de template estão localizados.
     */
    public function __construct(string $diretorio)
    {
        $this->template = new Template($diretorio);
        $this->message = new Message();
    }
}
