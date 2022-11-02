<?php

namespace App\Controllers\Api\Books;

use App\Controllers\Api\ApiActionInterface;
use Phalcon\Http\Response;
use App\Models\Book;

class Patch implements ApiActionInterface
{

    public static function exec($app, ...$params): Response
    {

        list($id) = $params;
        $body = $app->request->getJsonRawBody(true);

        $response = new Response();
        $book = Book::findFirst($id);

        if ($book === null) {
            $response->setStatusCode(404, 'Not Found');
            return $response;
        }

        $book->assign($body);

        $result = $book->save();


        if ($result === true) {
            $response->setJsonContent([
                'status' => 'OK',
                'data' => $book,
            ]);
        } else {
            $response->setStatusCode(409, 'Conflict');

            $errors = [];
            foreach ($book->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status' => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
}