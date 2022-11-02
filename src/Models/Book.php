<?php

namespace App\Models;

use Phalcon\Messages\Message;
use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;

class Book extends Model
{

    public function initialize()
    {
        $this->setSource('books');

        $this->hasManyToMany(
            'id',
            BookXAuthor::class,
            'book_id',
            'author_id',
            Author::class,
            'id',
            [
                'reusable' => true,
                'alias' => 'authors',
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();

        if (mb_strlen($this->title) === 0) {
            $this->appendMessage(new Message("Title can't be empty"));
        }

        // Validate the validator
        return $this->validate($validator);
    }
}