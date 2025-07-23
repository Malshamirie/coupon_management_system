<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Coupon;
use Illuminate\Http\Request;


class ContainerController extends Controller
{

    public function index(Request $request)
{
    $queryBuilder = Container::query();

    // فلترة حسب النص في حقل الكود إذا وُجد
    if ($request->filled('query')) {
        $search = $request->input('query');
        $queryBuilder->where('name', 'LIKE', "%{$search}%");
    }

    $containers = $queryBuilder->orderBy('id', 'desc')->paginate(10);

    return view('backend.pages.containers.index', compact('containers'));
}






    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required',
        ]);

        $container=Container::create([
            'name'=>$request->name,
        ]);
        $container->save();
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request,$id){
        $request->validate([
            'name'       => 'required',
        ]);
        $container = Container::find($id);
        $container->name = $request->name;
        $container->save();
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }


    public function coupons(Request $request,$id)
    {
        $queryBuilder = Coupon::query();
        $container = Container::find($id);

        // فلترة حسب النص في حقل الكود إذا وُجد
        if ($request->filled('query')) {
            $search = $request->input('query');
            $queryBuilder->where('code', 'LIKE', "%{$search}%");
        }

        // فلترة حسب الحالة إذا تم اختيارها
        if ($request->has('status') && $request->input('status') != '') {
            $queryBuilder->where('status', $request->input('status'));
        }

        $coupons = $queryBuilder->where('container_id',$container->id)->orderBy('id', 'desc')->paginate(10);

        return view('backend.pages.containers.coupons', compact('coupons','container'));
    }

    public function destroy($id)
    {
        $container = Container::find($id);
        $container->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }

}
