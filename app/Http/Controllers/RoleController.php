<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->input('query');
        $roles = Role::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }



    public function create()
    {
        $permission = Permission::get();
        return view('backend.pages.roles.create',compact('permission'));
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        // $role = Role::create(['name' => $request->input('name')]);
        // $role->syncPermissions($request->input('permission'));


        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permission)->pluck('name');
        $role->syncPermissions($permissions);

        // return  $request->permission;

        alert()->success('تم الإضافة بنجاح')->toToast();
        return redirect()->route('roles.index');    }




    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('backend.pages.roles.show',compact('role','rolePermissions', ));
    }



    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('backend.pages.roles.edit',compact('role','permission','rolePermissions', ));
    }



    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        // $role->name = $request->input('name');
        // $role->save();

        // $role->syncPermissions($request->input('permission'));
        $permissions = Permission::whereIn('id', $request->permission)->pluck('name');
        $role->syncPermissions($permissions);

        alert()->success('تم التعديل بنجاح')->toToast();
        return redirect()->route('roles.index');
    }



    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        alert()->success('تم الحذف بنجاح')->toToast();
        return redirect()->route('roles.index');
    }


}
