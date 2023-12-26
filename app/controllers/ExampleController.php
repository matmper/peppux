<?php

namespace App\Controllers;

use App\Models\User;
use System\Libraries\Response;

class ExampleController extends Controller
{
    /**
     * Returns all users
     *
     * @return Response
     */
    public function index(): Response
    {
        $users = new User;

        // echo '<pre>'; print_r($users->get()); echo '</pre>';
        // echo '<pre>'; var_dump($users->where('id', '>=', 1)->get()); echo '</pre>';
        // echo '<pre>'; print_r($users->raw('select * from users where id > ?', [1])); echo '</pre>';
        // echo '<pre>'; print_r($users->where('id', '=', 44)->first()); echo '</pre>';
        // echo '<pre>'; print_r($users->find(2)); echo '</pre>';

        return response()->json($users->get());
    }

    /**
     * Returns a valid user
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $user = new User;

        if ($user) {
            return response()->json($user->find($id));
        }

        return response()->setCode(Response::HTTP_NOT_FOUND) ->json([
                'errors' => ['error.not_found'],
                'metadata' => [
                    'message' => Response::getMessage(Response::HTTP_NOT_FOUND),
                    'code' => Response::HTTP_NOT_FOUND,
                ]
            ]);
    }
}
