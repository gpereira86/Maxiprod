<?php

namespace System\Model;

use System\Core\Model;

class PeopleModel extends Model
{

    /**
     * @var mixed|null
     */
    public function __construct()
    {
        parent::__construct('people');
    }
}