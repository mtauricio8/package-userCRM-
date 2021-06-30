<?php

namespace Esatic\activateuser\Controllers;

use App\Http\Controllers\Controller;
use Esatic\activateuser\Models\User;
use Esatic\activateuser\Service\CreateUser;
use Esatic\activateuser\Service\UpdateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{

    private CreateUser $createUser;
    private UpdateUser $updateUser;

    /**
     * ContactController constructor.
     * @param CreateUser $createUser
     * @param UpdateUser $updateUser
     */
    public function __construct(CreateUser $createUser,UpdateUser $updateUser)
    {
        $this->createUser = $createUser;
        $this->updateUser = $updateUser;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        //var_dump($request->input('last_name'));
        //die;
        /** @var User $user */
        $user = User::query()->where('id_crm', '=', $request->input('id_crm'))->first();
        $result = array();
        if (is_null($user))
            $result = $this->createUser->execute();
        else
            $result = $this->updateUser->execute($user);
        return response()->json($result);
    }

    public function disable(Request $request)
    {
        /** @var User $user */
        $user = User::query()->where('id_crm', '=', $request->input('id_crm'))->first();
        if (is_null($user))
            return response()->json(['result' => false, 'message' => 'User not found']);
        $user->active = false;
        $user->save();
        return response()->json(['result' => false, 'message' => 'Uset updated', 'contact' => $user]);
    }
}
