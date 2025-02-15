<?php

namespace System\Support;

use Twig\Lexer;
use Twig\TwigFunction;
use System\Core\Helpers;

/**
 * Classe Template
 *
 * Fornece integração com o motor de templates Twig, permitindo a renderização de templates
 * e a adição de funções auxiliares personalizadas para uso dentro dos templates.
 *
 * @package system\Support
 */
class Template
{
    private \Twig\Environment $twig;

    /**
     * Construtor da classe Template.
     *
     * Configura o ambiente Twig, atribui o diretório dos templates e registra funções auxiliares personalizadas.
     *
     * @param string $diretorio Caminho para o diretório que contém os arquivos de templates Twig.
     */
    public function __construct(string $diretorio)
    {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

        $this->addHelpers();

        $lexer = new Lexer($this->twig);
        $this->twig->setLexer($lexer);
    }

    /**
     * Renderiza um template com os dados fornecidos.
     *
     * @param string $view O nome do arquivo do template a ser renderizado.
     * @param array  $dataSet Um array associativo com os dados que serão passados para o template.
     * @return string O conteúdo do template renderizado como uma string.
     *
     * @throws \Twig\Error\LoaderError Se o template não puder ser encontrado.
     * @throws \Twig\Error\RuntimeError Se ocorrer um erro durante a renderização do template.
     * @throws \Twig\Error\SyntaxError Se houver um erro de sintaxe no template.
     */
    public function toRender(string $view, array $dataSet): string
    {
        return $this->twig->render($view, $dataSet);
    }

    /**
     * Registra funções auxiliares personalizadas para uso dentro dos templates Twig.
     *
     * As seguintes funções auxiliares estão disponíveis:
     * - `url(string|null $url)`: Gera uma URL completa usando a função Helpers::url().
     * - `flash()`: Exibe mensagens de flash usando a função Helpers::flash().
     * - `timeLoading()`: Calcula o tempo de execução do script em segundos.
     * - `menu()`: Gera o menu de navegação com base na URL atual.
     *
     * @return void
     */
    private function addHelpers(): void
    {
        $functions = [
            new TwigFunction('url', fn(string $url = null) => Helpers::url($url)),
            new TwigFunction('flash', fn() => Helpers::flash()),
            new TwigFunction('timeLoading', function () {
                $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                return number_format($time, 4);
            }),
            new TwigFunction('menu', function () {
                $uri = $_SERVER['REQUEST_URI'];
                $menu =[
                    ['name' => 'Home', 'url' => '', 'active' => (!str_contains($uri, '404') && !str_contains($uri, 'pessoa') && !str_contains($uri, 'transacao') && !str_contains($uri, 'totais')) ? 'custom-active' : ''],
                    ['name' => 'Cadastro de Pessoa', 'url' => 'cadastrar-pessoa', 'active' => str_contains($uri, 'pessoa') ? 'custom-active': ''],
                    ['name' => 'Cadastro de Transação', 'url' => 'cadastrar-transacao', 'active' => str_contains($uri, 'transacao') ? 'custom-active': ''],
                    ['name' => 'Totais', 'url' => 'totais', 'active' => str_contains($uri, 'totais') ? 'custom-active': ''],
                ];
                return $menu;
            }),

        ];

        foreach ($functions as $function) {
            $this->twig->addFunction($function);
        }
    }
}
