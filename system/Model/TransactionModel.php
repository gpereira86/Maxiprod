<?php

namespace System\Model;

use System\Core\Model;

/**
 * Classe TransactionModel
 *
 * Representa o modelo para a entidade "Transaction" (Transação).
 * Esta classe estende o modelo base e é responsável pela interação com a tabela de transações no banco de dados.
 *
 * @package System\Model
 */
class TransactionModel extends Model
{

    /**
     * Construtor da classe TransactionModel.
     *
     * Inicializa o modelo de transações e define a tabela associada a ele.
     * Chama o construtor da classe pai (Model) e passa o nome da tabela "transactions".
     */
    public function __construct()
    {
        parent::__construct('transactions');
    }
}