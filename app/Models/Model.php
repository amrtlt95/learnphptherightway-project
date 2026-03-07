<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\DB;
use PDO;

abstract class Model
{
    
    /**
     * @var PDO $db
     */
    protected DB $db;
    public function __construct()
    {
        $this->db = App::db();
    }
}
