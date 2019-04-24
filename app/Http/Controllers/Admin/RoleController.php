<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Common\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Models\SpatiePermission\WebPermission;
use App\Models\SpatiePermission\WebRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role;
    protected $permission;

    public function __construct(WebRole $role, WebPermission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permission->all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return RoleResource
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->role->create($request->all());

        // sync permissions

        $role->syncPermissions($request->permissions);

        $role->refresh();

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->role
            ->with('permissions')
            ->findOrFail($id);

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->role
            ->with('permissions')
            ->findOrFail($id);

        $permissions = $this->permission->all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param  int $id
     * @return RoleResource
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->role->findOrFail($id);

        $role->update($request->all());

        // sync permissions

        $role->syncPermissions($request->permissions);

        $role->refresh();

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->role->findOrFail($id);

        $role->delete();

        return response('', 204);
    }

    /**
     * Data for index ajax request
     * @param RoleFilter $filter
     * @return RoleResource
     * @internal param Request $request
     */
    public function getRoles(RoleFilter $filter)
    {
        $roles = $this->role
            ->with('permissions')
            ->filter($filter)
            ->result();

        return new RoleResource($roles);
    }
}
