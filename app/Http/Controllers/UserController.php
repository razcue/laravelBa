<?php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::orderByName()
                ->get()
                ->transform(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'image' => asset('images/' . ($user->image ?? env('NO_IMAGE_AVAILABLE_PATH', 'no_image.png'))),
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Form', ['action' => 'Create']);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $role = Role::find($request->input('role_id'));
        $user->assignRole($role);

        return to_route('users.index', [], 303);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Form', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'image' => $user->image ? asset('images/' . $user->image) : null,
            ],
            'action' => 'Edit',
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user->update($request->all());
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $role = Role::find($request->input('role_id'));
        $user->assignRole($role);

        return to_route('users.index', [], 303);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index', [], 303);
    }
}
