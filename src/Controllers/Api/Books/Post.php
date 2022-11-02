<?php

namespace App\Controllers\Api\Books;

use App\Controllers\Api\ApiActionInterface;
use Phalcon\Http\Response;
use App\Models\Book;

class Post implements ApiActionInterface
{

    public static function exec($app, ...$params): Response
    {

        $body = $app->request->getJsonRawBody(true);

        $book = new Book();
        $book->assign($body);

        $result = $book->create();

        $response = new Response();

        if ($result === true) {
            $response->setStatusCode(201, 'Created');

            $response->setJsonContent([
                    'status' => 'OK',
                    'data' => $book,
                ]
            );
        } else {
            $response->setStatusCode(409, 'Conflict');

            $errors = [];
            foreach ($book->getMessages() as $message) {
                $errors[] = $message->getMessage();
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent([
                    'status' => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }
        return $response;
    }
}