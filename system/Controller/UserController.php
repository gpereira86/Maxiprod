<?php

namespace System\Controller;

use System\Core\Controller;
use System\Core\Helpers;
use System\Model\PeopleModel;
use System\Model\TransactionModel;

class UserController extends Controller
{
    protected $personInstance;

    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
    }

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

                        $this->mensagem->success("O usuário '{$_POST['nome']}' foi cadastrado com sucesso.")->flash();

                        Helpers::redirect("cadastrar-pessoa");

                    } else {
                        $this->mensagem->messageError("Erro ao salvar dados no Banco de Dados, verifique os dados.")->flash();
                        echo $this->template->toRender('people-form.html', [
                            'persons' => $this->personInstance->search()->result(true),
                            'formData' => $_POST,
                        ]);
                    }

                } catch (\Exception $e) {
                    $this->mensagem->messageError($e->getMessage())->flash();
                    Helpers::redirect("cadastrar-pessoa");
                }

        } else {
            $this->mensagem->messageError("Algo deu errado!")->flash();
            Helpers::redirect();
        }
    }


    public function deletePerson(int $id): void
    {
        try {
            $person = $this->personInstance->searchById($id);

            if($person) {
                $this->personInstance->delete("id = {$id}");
                $transactionInstance = new TransactionModel();
                $transactionInstance->delete("people_id = {$id}");
                $this->mensagem->success("O usuário '{$person->data()->name}' e todas suas transações foiram excluídas com sucesso!")->flash();
            } else {
                $this->mensagem->messageError("Algo deu errado! | O id de usuário: '{$id}' não foi encontrado.")->flash();
            }

        } catch (\Exception $e) {
            $this->mensagem->messageError("Algo deu errado! | Erro: ". $e->getMessage())->flash();
        } finally {
            Helpers::redirect("cadastrar-pessoa");
        }
    }

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

                $this->mensagem->success("O cadastro do usuário '{$_POST['nome']}' foi atualizado com sucesso.")->flash();

                Helpers::redirect("cadastrar-pessoa");

            } else {
                $this->mensagem->messageError("Erro ao tentar alterar dados do usuário '{$_POST['nome']}' no Banco de Dados, verifique os dados.")->flash();
                echo $this->template->toRender('people-form.html', [
                    'persons' => $this->personInstance->search()->result(true),
                    'formData' => $_POST,
                ]);
            }

        }
    }


    public function validateRecordData(array $data):bool
    {
        if (!isset($data['nome']) || empty($data['nome']) || !isset($data['idade']) || empty($data['idade'])) {
            return false;
        }

        return true;
    }

}