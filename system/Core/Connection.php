<?php

namespace System\Core;

use PDO;
use PDOException;

/**
 * Classe Connection
 *
 * Fornece uma implementação singleton para criar e gerenciar uma conexão PDO com o banco de dados.
 * Garante que uma única instância da conexão com o banco de dados seja reutilizada em toda a aplicação.
 *
 * @package system\Core
 */
class Connection
{
    /**
     * @var PDO|null $instance
     * Contém a instância singleton da conexão PDO.
     */
    private static $instance;

    /**
     * Recupera a instância singleton da conexão PDO.
     *
     * Se a instância não existir, inicializa a conexão usando as constantes de configuração
     * do banco de dados: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, e `DB_PASSWORD`.
     *
     * @return PDO A instância PDO representando a conexão com o banco de dados.
     *
     * @throws PDOException Se houver um erro ao estabelecer a conexão.
     */
    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASSWORD,
                    [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "set NAMES utf8",
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_CASE => PDO::CASE_NATURAL
                    ]
                );
            } catch (PDOException $ex) {
                die("Erro de Conexão >>> " . $ex->getMessage());
            }
        }
        return self::$instance;
    }

    /**
     * Construtor protegido para evitar a instanciação direta.
     *
     * Isso garante que o padrão singleton seja respeitado e que a classe não possa
     * ser instanciada diretamente.
     */
    protected function __construct()
    {
    }

    /**
     * Método privado de clonagem para evitar a clonagem da instância.
     *
     * Isso garante que o padrão singleton seja respeitado e que a instância não possa
     * ser duplicada.
     */
    private function __clone(): void
    {
    }
}
