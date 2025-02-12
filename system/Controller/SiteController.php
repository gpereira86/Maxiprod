<?php

namespace System\Controller;
use System\Core\Controller;
use System\Model\PeopleModel;

class SiteController extends Controller
{

    public function __construct()
    {
        parent::__construct('templates/View');
    }

    public function index(): void
    {
        $peoples = (new PeopleModel())->search();

        echo $this->template->toRender('index.html', [
            'peoples' => $peoples->result(true),
        ]);
    }

    public function personRecord():void
    {
        echo $this->template->toRender('people-form.html', [
            'teste' => 'teste'
        ]);
    }

}