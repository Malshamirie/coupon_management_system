<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:users', ['only' => ['index','show']]);
//    }


    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(50);
        return view('backend.pages.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }



    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('backend.pages.users.create',compact('roles'));
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        alert()->success('تم الإضافة بنجاح')->toToast();
        return redirect()->route('users.index');
    }



    public function show($id)
    {
        $user = User::find($id);
        return view('backend.pages.users.show',compact('user'));
    }



    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('backend.pages.users.edit',compact('user','roles','userRole'));
    }



    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        alert()->success('تم التعديل بنجاح')->toToast();
        return redirect()->route('users.index');
    }



    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->CarsContracts->count() > 0){
            $user->delete();
            alert()->success('تم الحذف بنجاح')->toToast();
            return redirect()->route('users.index');
        }else{
            alert()->error('لا يمكن الحذف يوجد تحته عقود')->toToast();
            return redirect()->route('users.index');
        }
    }


}
