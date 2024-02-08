<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    //index
    public function index()
    {
        $modules = Module::all()->sortBy('id');
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('modules', 'permissions'));
    }

    //store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:modules',
        ]);
        $module = Module::create(['name' => ucfirst($request->name)]);

        return redirect()->route('admin.permissions.index');
    }

    //assignPermission to roles
    public function assignPermission(Organisation $organisation, Role $role)
    {

        $permissions = Permission::all();
        $modules = Module::all();

        $permissions = Permission::all(); // Get all permissions
        // Retrieve all permissions associated with the role
        $rolePermissions = $role->permissions;

        return view('admin.permissions.assign', compact('organisation', 'role', 'permissions', 'modules', 'rolePermissions'));

    }

    public function assignPermissionToRole(Request $request, Organisation $organisation, Role $role)
    {

        // Retrieve selected permissions names from the request
        $permissions = $request->input('permissions', []);

        // Find or create permissions based on the provided names
        $permissionsToAssign = [];
        foreach ($permissions as $permissionName) {
            $permissionsToAssign[] = Permission::findOrCreate($permissionName);
        }

        // Sync permissions to the role (this will attach the new permissions and detach any that are not in the array)
        $role->syncPermissions($permissionsToAssign);

        return redirect()->route('admin.permissions.assign', [$organisation->slug, $role->id])->with('success', 'Permissions assigned to ' . $role->name . ' successfully');
    }

}
