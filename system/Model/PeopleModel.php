<?php

namespace System\Model;

use System\Core\Model;

/**
 * Classe PeopleModel
 *
 * Representa o modelo para a entidade "People" (Pessoa).
 * Esta classe estende o modelo base e é responsável pela interação com a tabela de pessoas no banco de dados.
 *
 * @package System\Model
 */
class PeopleModel extends Model
{
    /**
     * Construtor da classe PeopleModel.
     *
     * Inicializa o modelo de pessoas e define a tabela associada a ele.
     * Chama o construtor da classe pai (Model) e passa o nome da tabela "people".
     */
    public function __construct()
    {
        parent::__construct('people');
    }
}