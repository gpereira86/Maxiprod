<?php

namespace System\Controller;

use System\Core\Controller;
use System\Core\Helpers;
use System\Model\PeopleModel;
use System\Model\TransactionModel;

/**
 * Classe UserController
 *
 * Controlador responsável por gerenciar as operações relacionadas a usuários, como cadastro, edição e exclusão de registros.
 *
 * @package system\Controller
 */
class UserController extends Controller
{
    protected $personInstance;

    /**
     * Construtor do controlador.
     *
     * Inicializa a instância do controlador base e cria uma instância do modelo de pessoas.
     */
    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
    }

    /**
     * Método para registrar ou exibir o formulário de cadastro de pessoa.
     *
     * Exibe o formulário de cadastro no método GET e processa o envio dos dados no método POST.
     *
     * @return void
     */
    public function personRecord(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $persons = $this->personInstance->search();

            echo $this->template->toRender('people-form.html', [
                'persons' => $persons->result(true),
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $dataSet = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            try {
                if ($this->validateRecordData($dataSet)) {

                    $this->personInstance->name = $dataSet['nome'];
                    $this->personInstance->age = $dataSet['idade'];

                    $this->personInstance->save();

                    $this->message->success("O usuário '{$_POST['nome']}' foi cadastrado com sucesso.")->flash();

                    Helpers::redirect("cadastrar-pessoa");

                } else {
                    $this->message->messageError("Erro ao salvar dados no Banco de Dados, verifique os dados.")->flash();
                    echo $this->template->toRender('people-form.html', [
                        'persons' => $this->personInstance->search()->result(true),
                        'formData' => $_POST,
                    ]);
                }

            } catch (\Exception $e) {
                $this->message->messageError($e->getMessage())->flash();
                Helpers::redirect("cadastrar-pessoa");
            }

        } else {
            $this->message->messageError("Algo deu errado!")->flash();
            Helpers::redirect();
        }
    }

    /**
     * Método para excluir um usuário e suas transações associadas.
     *
     * Exclui o registro de pessoa e todas as transações associadas a ela.
     *
     * @param int $id O ID do usuário a ser excluído.
     * @return void
     */
    public function deletePerson(int $id): void
    {
        try {
            $person = $this->personInstance->searchById($id);

            if ($person) {
                $this->personInstance->delete("id = {$id}");
                $transactionInstance = new TransactionModel();
                $transactionInstance->delete("people_id = {$id}");
                $this->message->success("O usuário '{$person->data()->name}' e todas suas transações foram excluídas com sucesso!")->flash();
            } else {
                $this->message->messageError("Algo deu errado! | O id de usuário: '{$id}' não foi encontrado.")->flash();
            }

        } catch (\Exception $e) {
            $this->message->messageError("Algo deu errado! | Erro: ". $e->getMessage())->flash();
        } finally {
            Helpers::redirect("cadastrar-pessoa");
        }
    }

    /**
     * Método para editar um usuário existente.
     *
     * Exibe o formulário de edição no método GET e processa as alterações no método POST.
     *
     * @param int $id O ID do usuário a ser editado.
     * @return void
     */
    public function editPerson(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $person = $this->personInstance->searchById($id);
            $formDataSet = [
                'id' => $person->data()->id,
                'nome' => $person->data()->name,
                'idade' => $person->data()->age,
            ];

            echo $this->template->toRender('people-form.html', [
                'persons' => $person->search()->result(true),
                'formData' => $formDataSet,
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataSet = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($this->validateRecordData($dataSet)) {

                $this->personInstance->id = $dataSet['id'];
                $this->personInstance->name = $dataSet['nome'];
                $this->personInstance->age = $dataSet['idade'];

                $this->personInstance->save();

                $this->message->success("O cadastro do usuário '{$_POST['nome']}' foi atualizado com sucesso.")->flash();

                Helpers::redirect("cadastrar-pessoa");

            } else {
                $this->message->messageError("Erro ao tentar alterar dados do usuário '{$_POST['nome']}' no Banco de Dados, verifique os dados.")->flash();
                echo $this->template->toRender('people-form.html', [
                    'persons' => $this->personInstance->search()->result(true),
                    'formData' => $_POST,
                ]);
            }

        }
    }

    /**
     * Método para validar os dados do formulário de registro.
     *
     * Verifica se os campos obrigatórios (nome e idade) estão preenchidos corretamente.
     *
     * @param array $data Os dados do formulário a serem validados.
     * @return bool Retorna true se os dados forem válidos, caso contrário, false.
     */
    public function validateRecordData(array $data): bool
    {
        if (!isset($data['nome']) || empty($data['nome']) || !isset($data['idade']) || empty($data['idade'])) {
            return false;
        }

        return true;
    }

}
