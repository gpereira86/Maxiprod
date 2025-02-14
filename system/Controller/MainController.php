<?php

namespace System\Controller;

use System\Core\Controller;
use System\Model\PeopleModel;
use System\Core\Helpers;
use System\Model\TransactionModel;

class MainController extends Controller
{
    protected $personInstance;
    protected $transactionInstance;

    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
        $this->transactionInstance = new TransactionModel();
    }

    public function index(): void
    {


        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            echo $this->template->toRender('index.html', [
                'persons' => $this->personInstance->search()->result(true),
                'transactions' => $this->transactionInstance->search()->result(true),
                'totalPersons' => $this->personInstance->search()->amount(),
                'totalTransactions' => $this->transactionInstance->search()->amount(),
            ]);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['filtro'];
            if($id == 'TODOS') {
                Helpers::redirect();
            }

            echo $this->template->toRender('index.html', [
                'persons' => $this->personInstance->search()->result(true),
                'personFilter' => $this->personInstance->searchById($id),
                'transactions' => $this->transactionInstance->searchById($id),
                'totalPersons' => $this->personInstance->search()->amount(),
                'totalTransactions' => $this->transactionInstance->search()->amount(),
                'totalUserTransactions' => $this->transactionInstance->search("people_id = {$id}")->amount(),
                'formData' => $_POST,
            ]);
        } else {
            $this->mensagem->messageError("Algo deu errado! Tente novamente.");
            Helpers::redirect();
        }

    }

    public function total(): void
    {
        echo $this->template->toRender('total.html', [
            'teste' => "Total!",
            'persons'=> $this->personInstance->search()->result(true),
        ]);
    }

    public function error404(): void
    {
        echo $this->template->toRender('404.html', [
            'teste' => "Testando!",

        ]);
    }

}