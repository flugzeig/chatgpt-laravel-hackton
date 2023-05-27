<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = new User();
        $user->login = $request->login;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->remember_token = bin2hex(random_bytes(40)); // Генерация API-ключа
        $user->save();

        return response()->json(['remember_token' => $user->remember_token], 201);
    }

    // ...
}

use App\Models\Role;
use Illuminate\Http\Request;
class AddRoleController extends Controller{
    public function addRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'query' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $role = new Role();
        $role->name = $request->input('name');
        $role->query = $request->input('query');
        // Добавьте другие поля, если они также вводятся пользователем

        $role->save();

        return response()->json(['message' => 'Role added successfully'], 201);
    }
}

