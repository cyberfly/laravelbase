<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\SpatiePermission\WebRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(User $user, WebRole $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest|Request $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = $this->user->create($data);

        // assign roles

        if ($request->filled('roles')) {

            foreach ($request->roles as $role_id) {

                $role = $this->role->find($role_id);

                if ($role) {
                    $user->assignRole($role);
                }
            }

        }

        return new UserResource($user->load('roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user
            ->with('roles')
            ->findOrFail($id);

        $roles = $this->role->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  int $id
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {

            $data = $data + [
                    'password' => Hash::make($request->password),
                ];
        }

        $user->update($data);

        // sync roles

        $user->syncRoles($request->roles);

        $user->refresh();

        return new UserResource($user->load('roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dataTables()
    {
        return Datatables::eloquent(User::query())->make(true);
    }
}
