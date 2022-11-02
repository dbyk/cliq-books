<?php

namespace App\Controllers\Api\Books;

use App\Controllers\Api\ApiActionInterface;
use Phalcon\Http\Response;
use App\Models\Book;

class Get implements ApiActionInterface
{
    public static function exec($app, ...$params): Response
    {
        list($id) = $params;
        $response = new Response();
        $book = Book::findFirst($id);

        if ($book === null) {
            $response = new Response();
            $response->setStatusCode(404, 'Not Found');
            return $response;
        }

        return $response->setJsonContent([
            'data' => $book,
        ]);
    }
}