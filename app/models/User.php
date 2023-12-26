<?php

namespace App\Models;

use Peppux\Model;

class User extends Model
{
    /**
     * @var string
     */
    public string $table = 'users';

    /**
     * @var string
     */
    public string $primary = 'id';
}
