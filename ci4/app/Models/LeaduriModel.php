<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaduriModel extends Model
{
    protected $table      = 'leaduri';
    protected $primaryKey = 'Id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['IdClient', 'Mesaj'];
}
