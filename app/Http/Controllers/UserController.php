<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\View;


class UserController extends Controller
{

    public function index(): View
    {
        return view('table', $this->getFormattedUsersData());
    }


    private function getFormattedUsersData(?int $id = null): array
    {
        if ($id) {
            $user = User::find($id);
            $rows_users = [[$user->id, $user->name, $user->email, $user->password]];
        } else {
            $users = User::all();
            $rows_users = $users->map(function ($user) {
                return [$user->id, $user->name, $user->email, $user->password];
            });
        }

        $headers_users = ['id', 'name', 'email', 'password'];
        $names = $this->removeSpacesFromWorld($headers_users);
        $table = 'users';

        return compact('rows_users', 'headers_users', 'table', 'names');
    }

    public function edit(int $id)
    {
        return view('edit-table', $this->getFormattedUsersData($id));
    }


    public function update(Request $request)
    {
        $user = User::find($request->input('id'));
        $this->fillUserData($user, $request, false);
        $user->save();

        return to_route('user-table');
    }

    public function add(Request $request)
    {
        $user = new User();
        $this->fillUserData($user, $request, true);
        $user->save();

        return to_route('user-table');
    }

    private function fillUserData(User $user, Request $request, bool $hashPassword = false)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($hashPassword) {
            $user->password = bcrypt($request->input('password'));
        } elseif ($request->has('password')) {
            $user->password = $request->input('password');
        }
    }

    public function delete(int $id)
    {
        User::destroy($id);

        return to_route('user-table');
    }


}
