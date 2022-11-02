<?php

namespace App\Controllers\Api\Books;

use App\Controllers\Api\ApiActionInterface;
use Phalcon\Http\Response;
use App\Models\Book;

class GetList implements ApiActionInterface
{
    public static function exec($app, ...$params): Response
    {
        $response = new Response();
        $books = Book::find([
            'limit' => $app->request->get('limit') ?? 10,
            'offset' => $app->request->get('offset') ?? 0,
        ]);

        return $response->setJsonContent([
            'data' => $books,
        ]);
    }
}