<?php

namespace App\Controllers\Api\Books;

use App\Controllers\Api\ApiActionInterface;
use Phalcon\Http\Response;
use App\Models\Book;

class Delete implements ApiActionInterface
{

    public static function exec($app, ...$params): Response
    {

        list($id) = $params;
        $book = Book::findFirst($id);

        $response = new Response();
        if ($book === null) {
            $response->setStatusCode(404, 'Not Found');
            return $response;
        }


        $result = $book->delete();


        if ($result === true) {
            $response->setJsonContent([
                'status' => 'OK'
            ]);
        } else {
            $response->setStatusCode(409, 'Conflict');

            $errors = [];
            foreach ($book->getMessages() as $message) {
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