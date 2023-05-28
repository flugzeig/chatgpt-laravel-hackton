<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
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
use App\Models\User;
class FavoriteRoleClass extends Controller{
    public function getFavoriteRoles($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $favoriteRoles = $user->favoriteRoles;

        return response()->json(['favorite_roles' => $favoriteRoles], 200);
    }
}

