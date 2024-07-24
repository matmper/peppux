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
        $users = $users->get();

        return response()->json($users);
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
        $user = $user->find($id);

        if ($user) {
            return response()->json($user);
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
