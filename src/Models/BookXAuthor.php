<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class BookXAuthor extends Model
{
    public function initialize()
    {
        $this->setSource('books_authors');
    }
}