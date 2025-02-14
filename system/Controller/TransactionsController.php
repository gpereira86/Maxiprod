<?php

namespace System\Controller;

use System\Core\Controller;
use System\Core\Helpers;
use System\Model\PeopleModel;
use System\Model\TransactionModel;

class TransactionsController extends Controller
{
    protected $personInstance;
    protected $transactionInstance;

    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
        $this->transactionInstance = new TransactionModel();
    }

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

                        $this->mensagem->success("A transação '{$_POST['nomeDespesa']}' foi cadastrada com sucesso.")->flash();

                        Helpers::redirect();

                    } else {
                        echo $this->template->toRender('transaction-form.html', [
                            'transactions' => $this->transactionInstance->search()->limit(10)->order('id DESC')->result(true),
                            'persons' => $this->personInstance->search()->result(true),
                            'formData' => $_POST,
                        ]);
                    }

                } catch (\Exception $e) {
                    $this->mensagem->messageError("Algo deu errado! | Erro: ".$e->getMessage())->flash();
                    Helpers::redirect();
                }

        } else {
            $this->mensagem->messageError("Algo deu errado!")->flash();
            Helpers::redirect();
        }
    }


    public function deleteTransaction(int $id): void
    {
        try {
            $transaction = $this->transactionInstance->searchById($id);

            if($transaction) {
                $this->transactionInstance->delete("id = {$id}");
                $this->mensagem->success("A transação de '{$transaction->data()->cost_type}': '{$transaction->data()->expense_name}' foi excluída com sucesso.")->flash();
            }

        } catch (\Exception $e) {
            $this->mensagem->messageError("Algo deu errado! | Erro: ". $e->getMessage())->flash();
        } finally {
            Helpers::redirect("cadastrar-transacao");
        }
    }


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

                $this->mensagem->success("O cadastro da transação de '{$_POST['typeOption']}': '{$_POST['nomeDespesa']}' foi atualizada com sucesso.")->flash();

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


    public function validateRecordData(array $data):bool
    {
        $part2Mensagem = "precisa ser preenchido(a) de acordo com padrão solicitado no campo.";

        if (!isset($data) || empty($data)) {
            $this->mensagem->messageError("Todos os dados precisam ser preenchidos de acordo com padrão solicitado no campo.")->flash();
            return false;
        }

        if(!isset($data['nomeDespesa']) || empty($data['nomeDespesa'])) {
            $this->mensagem->messageError("O nome identificador da despesa ". $part2Mensagem)->flash();
            return false;
        }

        if(!isset($data['valor']) || empty($data['valor'])) {

            $this->mensagem->messageError("O valor ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['valor'] < 0) {
            $this->mensagem->messageError("O valor não pode ser nulo ou negativo.")->flash();
            return false;
        }

        if(!isset($data['typeOption']) || empty($data['typeOption'])) {
            $this->mensagem->messageError("O tipo de custo ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['typeOption'] != 'Entrada' && $data['typeOption'] != 'Saida') {
            $this->mensagem->messageError("O tipo de custo precisa ser preenchido apenas com 'Entrada' ou 'Saida.")->flash();
            return false;
        }



        if(!isset($data['usuario']) || empty($data['usuario'])) {
            $this->mensagem->messageError("O Usuário ". $part2Mensagem)->flash();
            return false;
        } elseif ($data['usuario'] < 0) {
            $this->mensagem->messageError("O Usuário ". $part2Mensagem)->flash();
            return false;
        } elseif (!is_numeric($data['usuario']) || !$this->personInstance->searchById($data['usuario'])) {
            $this->mensagem->messageError("O Usuário informado não está cadastrado em nossa base de dados, antes de mais nada, cadastre-o.")->flash();
            return false;
        }

        $user = $this->personInstance->searchById($data['usuario']);
        if ($user->data()->age < 18 && $data['typeOption'] == 'Entrada') {
            $this->mensagem->messageError("Usuários com menos de 18 anos não podem registrar transações de 'Entrada', apenas de 'Saída'.")->flash();
            return false;
        }


        return true;
    }

}