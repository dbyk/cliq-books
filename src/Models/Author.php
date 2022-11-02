<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Author extends Model
{
    public function initialize()
    {
        $this->setSource('authors');

    }
}