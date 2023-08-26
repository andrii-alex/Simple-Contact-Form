<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientiModel extends Model
{
    protected $table      = 'clienti';
    protected $primaryKey = 'Id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['Nume', 'Prenume', 'Email', 'Telefon'];
}
