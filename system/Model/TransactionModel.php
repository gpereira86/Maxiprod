<?php

namespace System\Model;

use System\Core\Model;

class TransactionModel extends Model
{

    public function __construct()
    {
        parent::__construct('transactions');
    }
}