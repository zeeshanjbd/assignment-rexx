<?php

namespace App\Models;

use App\Services\Database;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}

