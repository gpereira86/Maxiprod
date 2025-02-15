<?php

namespace System\Controller;

use System\Core\Controller;
use System\Core\Helpers;
use System\Model\PeopleModel;
use System\Model\TransactionModel;

/**
 * Controlador responsável por gerenciar transações financeiras.
 *
 * Este controlador permite o registro, edição e exclusão de transações financeiras.
 * Também realiza validações para garantir que os dados inseridos sejam consistentes e válidos.
 */
class TransactionsController extends Controller
{
    protected $personInstance;
    protected $transactionInstance;

    /**
     * Construtor da classe, inicializa as instâncias dos modelos.
     */
    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
        $this->transactionInstance = new TransactionModel();
    }

    /**
     * Registra uma nova transação ou exibe o formulário de registro.
     *
     * Este método verifica o tipo de requisição (GET ou POST). No caso de uma requisição GET,
     * exibe o formulário de transação com os dados necessários. Para uma requisição POST,
     * valida os dados e, se válidos, realiza o cadastro da transação.
     *
     * @return void
     */
    public function transactionRecord(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            echo $this->template->toRender('transaction-form.html', [
                'persons' => $this->personInstance->search()->result(true),
                'transactions' => $this->transactionInstance->search()->limit(10)->order('id DESC')->result(true),
            ]);

        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dataSet = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            try {
                if ($this->validateRecordData($dataSet)) {

                    $this->transactionInstance->expense_name = $dataSet['nomeDespesa'];
                    $this->transactionInstance->cost = $dataSet['valor'];
                    $this->transactionInstance->cost_type = $dataSet['typeOption'];
                    $this->transactionInstance->notes = $dataSet['observacao'];
                    $this->transactionInstance->people_id = $dataSet['usuario'];

                    $this->transactionInstance->save();

                    $this->message->success("A transação '{$_POST['nomeDespesa']}' foi cadastrada com sucesso.")->flash();

                    Helpers::redirect();

                } else {
                    echo $this->template->toRender('transaction-form.html', [
                        'transactions' => $this->transactionInstance->search()->limit(10)->order('id DESC')->result(true),
                        'persons' => $this->personInstance->search()->result(true),
                        'formData' => $_POST,
                    ]);
                }

            } catch (\Exception $e) {
                $this->message->messageError("Algo deu errado! | Erro: ".$e->getMessage())->flash();
                Helpers::redirect();
            }

        } else {
            $this->message->messageError("Algo deu errado!")->flash();
            Helpers::redirect();
        }
    }

    /**
     * Exclui uma transação específica.
     *
     * Este método busca a transação pelo ID, e caso a transação exista, realiza sua exclusão.
     * Em caso de erro, uma mensagem de erro é exibida.
     *
     * @param int $id ID da transação a ser excluída
     *
     * @return void
     */
    public function deleteTransaction(int $id): void
    {
        try {
            $transaction = $this->transactionInstance->searchById($id);

            if ($transaction) {
                $this->transactionInstance->delete("id = {$id}");
                $this->message->success("A transação de '{$transaction->data()->cost_type}': '{$transaction->data()->expense_name}' foi excluída com sucesso.")->flash();
            }

        } catch (\Exception $e) {
            $this->message->messageError("Algo deu errado! | Erro: ". $e->getMessage())->flash();
        } finally {
            Helpers::redirect("cadastrar-transacao");
        }
    }

    /**
     * Edita os dados de uma transação existente.
     *
     * Este método exibe o formulário com os dados da transação a ser editada em uma requisição GET.
     * Em uma requisição POST, ele valida e atualiza os dados da transação no banco de dados.
     *
     * @param int $id ID da transação a ser editada
     *
     * @return void
     */
    public function editTransaction(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $transaction = $this->transactionInstance->searchById($id);
            $formDataSet = [
                'id' => $transaction->data()->id,
                'nomeDespesa' => $transaction->data()->expense_name,
                'valor' => $transaction->data()->cost,
                'typeOption' => $transaction->data()->cost_type,
                'observacao' => $transaction->data()->notes,
                'usuario' => $transaction->data()->people_id,
            ];

            echo $this->template->toRender('transaction-form.html', [
                'transactions' => $this->transactionInstance->search()->limit(10)->order('id DESC')->result(true),
                'persons' => $this->personInstance->search()->result(true),
                'formData' => $formDataSet,
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dataSet = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($this->validateRecordData($dataSet)) {

                $this->transactionInstance->id = $dataSet['id'];
                $this->transactionInstance->expense_name = $dataSet['nomeDespesa'];
                $this->transactionInstance->cost = $dataSet['valor'];
                $this->transactionInstance->cost_type = $dataSet['typeOption'];
                $this->transactionInstance->notes = $dataSet['observacao'];
                $this->transactionInstance->people_id = $dataSet['usuario'];

                $this->transactionInstance->save();

                $this->message->success("O cadastro da transação de '{$_POST['typeOption']}': '{$_POST['nomeDespesa']}' foi atualizada com sucesso.")->flash();

                Helpers::redirect();

            } else {
                echo $this->template->toRender('transaction-form.html', [
                    'transactions' => $this->transactionInstance->search()->limit(10)->order('id DESC')->result(true),
                    'persons' => $this->personInstance->search()->result(true),
                    'formData' => $_POST,
                ]);
            }

        }
    }

    /**
     * Valida os dados da transação.
     *
     * Este método valida os campos da transação, garantindo que todos os campos obrigatórios
     * sejam preenchidos corretamente e que os valores estejam dentro das restrições estabelecidas.
     *
     * @param array $data Dados da transação a ser validada
     *
     * @return bool Retorna true se os dados forem válidos, caso contrário, retorna false
     */
    public function validateRecordData(array $data): bool
    {
        $part2Mensagem = "precisa ser preenchido(a) de acordo com padrão solicitado no campo.";

        if (!isset($data) || empty($data)) {
            $this->message->messageError("Todos os dados precisam ser preenchidos de acordo com padrão solicitado no campo.")->flash();
            return false;
        }

        if (!isset($data['nomeDespesa']) || empty($data['nomeDespesa'])) {
            $this->message->messageError("O nome identificador da despesa ". $part2Mensagem)->flash();
            return false;
        }

        if (!isset($data['valor']) || empty($data['valor'])) {
            $this->message->messageError("O valor ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['valor'] < 0) {
            $this->message->messageError("O valor não pode ser nulo ou negativo.")->flash();
            return false;
        }

        if (!isset($data['typeOption']) || empty($data['typeOption'])) {
            $this->message->messageError("O tipo de custo ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['typeOption'] != 'Entrada' && $data['typeOption'] != 'Saida') {
            $this->message->messageError("O tipo de custo precisa ser preenchido apenas com 'Entrada' ou 'Saida.")->flash();
            return false;
        }

        if (!isset($data['usuario']) || empty($data['usuario'])) {
            $this->message->messageError("O Usuário ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['usuario'] < 0) {
            $this->message->messageError("O Usuário ". $part2Mensagem)->flash();
            return false;
        } elseif (!is_numeric($data['usuario']) || !$this->personInstance->searchById($data['usuario'])) {
            $this->message->messageError("O Usuário informado não está cadastrado em nossa base de dados, antes de mais nada, cadastre-o.")->flash();
            return false;
        }

        $user = $this->personInstance->searchById($data['usuario']);
        if ($user->data()->age < 18 && $data['typeOption'] == 'Entrada') {
            $this->message->messageError("Usuários com menos de 18 anos não podem registrar transações de 'Entrada', apenas de 'Saída'.")->flash();
            return false;
        }

        return true;
    }

}
