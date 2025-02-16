<?php

namespace System\Controller;

use System\Core\Controller;
use System\Model\PeopleModel;
use System\Core\Helpers;
use System\Model\TransactionModel;

/**
 * Classe responsável pelo gerenciamento da página principal, página de totais e página de erro, além de funcionalidades associadas.
 *
 * Esta classe lida com a exibição de informações sobre pessoas, transações e totais, além de fornecer funcionalidade de filtragem e cálculo de saldos.
 *
 * @package System\Controller
 */
class MainController extends Controller
{
    protected $personInstance;
    protected $transactionInstance;

    /**
     * Construtor da classe.
     *
     * Inicializa as instâncias dos modelos de pessoas e transações e chama o construtor da classe pai.
     */
    public function __construct()
    {
        parent::__construct('templates/view');
        $this->personInstance = new PeopleModel();
        $this->transactionInstance = new TransactionModel();
    }

    /**
     * Método principal de exibição da página inicial.
     *
     * Exibe informações gerais, incluindo uma lista de pessoas e transações, além de totais. Também lida com a filtragem de dados através de um formulário.
     *
     * @return void
     */
    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            echo $this->template->toRender('index.html', [
                'persons' => $this->personInstance->search()->result(true),
                'transactions' => $this->transactionInstance->search()->order('id DESC')->result(true),
                'totalPersons' => $this->personInstance->search()->amount(),
                'totalTransactions' => $this->transactionInstance->search()->amount(),
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['filtro'];

            if ($id == 'TODOS') {
                Helpers::redirect();
            }

            echo $this->template->toRender('index.html', [
                'persons' => $this->personInstance->search()->result(true),
                'personFilter' => $this->personInstance->searchById($id),
                'transactions' => $this->transactionInstance->search("people_id = {$id}")->order('id DESC')->result(true),
                'totalPersons' => $this->personInstance->search()->amount(),
                'totalTransactions' => $this->transactionInstance->search()->amount(),
                'totalUserTransactions' => $this->transactionInstance->search("people_id = {$id}")->amount(),
                'formData' => $_POST,
            ]);
        } else {
            $this->message->messageError("Algo deu errado! Tente novamente.");
            Helpers::redirect();
        }
    }

    /**
     * Exibe a página com o total de transações, distribuído por pessoa e por tipo de custo.
     *
     * @return void
     */
    public function total(): void
    {
        echo $this->template->toRender('total.html', [
            'persons'=> $this->personInstance->search()->order('name ASC')->result(true),
            'amountPerPerson' => $this->amountPerCostType()["perPerson"],
            'amountTotal' => $this->amountPerCostType()["total"],
        ]);
    }

    /**
     * Calcula os valores de entradas, saídas e saldo para cada pessoa e o total geral.
     *
     * Este método agrupa as transações por pessoa e calcula os totais de receitas, despesas e saldo para cada uma. Também calcula os totais gerais.
     *
     * @return array Retorna um array com o total por pessoa e o total geral de entradas, saídas e saldo.
     */
    public function amountPerCostType(): array
    {
        $amountPerPerson = [];
        $persons = $this->personInstance->search()->result(true);
        $counter = 0;

        foreach ($persons as $person) {
            $transactions = $this->transactionInstance->search("people_id = {$person->id}")->result(true);
            $income = 0;
            $expense = 0;

            foreach ($transactions as $transaction) {
                if ($transaction->cost_type == 'Receita') {
                    $income += $transaction->cost;
                } elseif ($transaction->cost_type == 'Despesa') {
                    $expense += $transaction->cost;
                }
            }

            $amountPerPerson[$counter] = [
                'name' => $person->name,
                'age' => $person->age,
                'incomes' => $income,
                'expenses' => $expense,
                'balance' => $income - $expense,
            ];
            $counter++;
        }

        $amount = [
            'incomes' => array_sum(array_column($amountPerPerson, 'incomes')),
            'expenses' => array_sum(array_column($amountPerPerson, 'expenses')),
            'balance' => array_sum(array_column($amountPerPerson, 'incomes')) - array_sum(array_column($amountPerPerson, 'expenses')),
        ];

        return [
            'perPerson' => $amountPerPerson,
            'total' => $amount,
        ];
    }

    /**
     * Exibe a página de erro 404.
     *
     * @return void
     */
    public function error404(): void
    {
        echo $this->template->toRender('404.html', []);
    }

}
