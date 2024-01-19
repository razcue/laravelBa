<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

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
                    'image' =>
                        asset('images/' . ($user->image ?? env('NO_IMAGE_AVAILABLE_PATH', 'no_image.png'))),
                ]),
            'can' => [
                'create_user' => Auth::user()->can('user-create', User::class),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Form', [
            'action' => 'Create',
            'rolesDataSet' => Role::all(['id', 'name'])
                ->transform(fn ($role) => [
                    'id' => $role->id,
                    'label' => ucwords($role->name),
                ]),
        ]);
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
                'role_id' => Role::findByName($user->getRoleNames()[0], 'web')->id,
                'image' =>
                    asset('images/' . ($user->image ?? env('NO_IMAGE_AVAILABLE_PATH', 'no_image.png'))),
            ],
            'action' => 'Edit',
            'rolesDataSet' => Role::all(['id', 'name'])
                ->transform(fn ($role) => [
                    'id' => $role->id,
                    'label' => ucwords($role->name),
                ]),
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
