<?php

namespace AppsLab\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class RuhusaController extends Controller
{
    /**
     * Create role
     * @return mixed
     */
    public function createRole()
    {
//        dd('d');
        return view('ruhusa::acl.role-form-body')
            ->withPermissions(app(config('ruhusa.models.permission'))->all())
            ->withUsers(app(config('ruhusa.models.defaultUser'))->all());
    }

    /**
     * Create permission 
     * @return mixed
     */
    public function createPermission()
    {
        return view('acl.permission-form-body')
            ->withRoles(app(config('ruhusa.models.role'))->all())
            ->withPermissions(app(config('ruhusa.models.permission'))->all());
    }

    /**
     * Edit permission
     * @param $permission
     * @return mixed
     */
    public function editPermission($permission)
    {
        return view('acl.permission-form-body')
            ->withRoles(app(config('ruhusa.models.role'))->all())
            ->withPermissions(app(config('ruhusa.models.permission'))->all())
            ->withPermission(app(config('ruhusa.models.permission'))->find($permission));
    }

    /**
     * Store role
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRole(Request $request)
    {
        $request->request->add(['slug' => str_slug($request->name)]);
        $this->roleValidation($request);
        $role = app(config('ruhusa.models.role'));

        $role = $role->create($request->all());

        $role->permissions()->syncWithoutDetaching($request->permissions);

        if ($request->has('users')){
            $role->users()->syncWithoutDetaching($request->users);
        }

        return redirect()->route('roles.index');
    }

    /**
     * Store permission create
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePermission(Request $request)
    {
        $request->request->add(['slug' => str_slug($request->name)]);
        $this->permissionValidation($request);
        $permission = app(config('ruhusa.models.permission'));
        $permission = $permission->create($request->all());

        if ($request->has('roles')){
            $permission->roles()->syncWithoutDetaching($request->roles);
        }

        return redirect()->route('permissions.index');
    }

    /**
     * Update permission
     * @param Request $request
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermission(Request $request, $permission)
    {
        $request->request->add(['slug' => str_slug($request->name)]);
        $permission = app(config('ruhusa.models.permission'))->find($permission);

        if ($permission->slug != $request->slug){
            $this->permissionValidation($request);
        }

        $permission->update($request->all());

        $permission->roles()->detach();
        if ($request->has('roles')){
            $permission->roles()->sync($request->roles);
        }

        return redirect()->route('permissions.index');
    }

    /**
     * Return edit view
     * @param $role
     * @return mixed
     */
    public function editRole($role)
    {
        $roleModel = app(config('ruhusa.models.role'));
        $role =  $roleModel->findOrFail($role);

        return view('acl.role-form-body')
            ->withRole($role)
            ->withPermissions(app(config('ruhusa.models.permission'))->all())
            ->withUsers(app(config('ruhusa.models.defaultUser'))->all());
    }

    /**
     * Role validation
     * @param Request $request
     */
    public function roleValidation(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', new SlugRule(app(config('ruhusa.models.role')))],
            'permissions' => ['required']
        ]);
    }

    /**
     * List roles
     * @param Request $request
     * @return mixed
     */
    public function roles(Request $request)
    {
        $roles = app(config('ruhusa.models.role'));
        if ($request->has('permission')){
            $permission = app(config('ruhusa.models.permission'))->find($request->permission);
            if ($permission) {
                $roles = $permission->roles();
            }
        }

        return view('acl.role')
            ->withRoles($roles->paginate(config('ruhusa.perPage')));
    }

    /**
     * List permissions
     * @param Request $request
     * @return mixed
     */
    public function permissions(Request $request)
    {
        $permissions = app(config('ruhusa.models.permission'));
        if ($request->has('role')){
            $role = app(config('ruhusa.models.role'))->find($request->role);
            $permissions = [];
            if ($role) {
                $permissions = $role->permissions();
            }
        }

        return view('acl.permission')
            ->withPermissions($permissions->paginate(config('ruhusa.perPage')));
    }

    /**
     * Update role
     * @param Request $request
     * @param $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(Request $request, $role)
    {
        $request->request->add(['slug' => str_slug($request->name)]);
        $role = app(config('ruhusa.models.role'))->find($role);

        $request->validate([
            'permissions' => ['required']
        ]);

        if ($role->slug != $request->slug){
            $this->roleValidation($request);
        }

        $role->update($request->all());

        $role->permissions()->detach();
        $role->permissions()->sync($request->permissions);

        if ($request->has('users')){
            $role->users()->sync($request->users);
        }

        return redirect()->route('roles.index');
    }

    /**
     * Permission validation
     * @param Request $request
     */
    protected function permissionValidation(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', new SlugRule(app(config('ruhusa.models.permission')))],
        ]);
    }

    /**
     * Delete role
     * @param $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRole($role)
    {
        $role = app(config('ruhusa.models.role'))->find($role);
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();

        return back();
    }

    /**
     * Delete permissions
     * @param $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePermission($permission)
    {
        $permission = app(config('ruhusa.models.permission'))->find($permission);
        $permission->roles()->detach();
        $permission->users()->detach();
        $permission->delete();

        return back();
    }
}
