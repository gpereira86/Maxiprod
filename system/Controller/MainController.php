<?php

namespace System\Controller;

use System\Core\Controller;
use System\Model\PeopleModel;
use System\Core\Helpers;

class MainController extends Controller
{
    protected $personInstance;

    public function __construct()
    {
        parent::__construct('templates/View');
        $this->personInstance = new PeopleModel();
    }

    public function index(): void
    {
        echo $this->template->toRender('index.html', [
            'teste' => "Testando!",
        ]);
    }

    public function error404(): void
    {
        echo $this->template->toRender('404.html', [
            'teste' => "Testando!",
        ]);
    }

}