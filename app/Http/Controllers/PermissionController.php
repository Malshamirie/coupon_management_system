<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('query');
        $permissions = Permission::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.Permissions.index', compact('permissions'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Permission::create([
            'name' => $request->name,
        ]);
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->update([
            'name' => $request->name,
        ]);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }


    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();


    }


}
