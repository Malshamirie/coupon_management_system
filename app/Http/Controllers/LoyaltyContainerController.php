<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyContainer;
use Illuminate\Http\Request;

class LoyaltyContainerController extends Controller
{
    public function index(Request $request)
    {

        // فلترة حسب النص في حقل الاسم إذا وُجد
        if ($request->filled('query')) {
            $search = $request->input('query');
            $queryBuilder = LoyaltyContainer::where('name', 'LIKE', "%{$search}%");
        } else {
            $queryBuilder = LoyaltyContainer::query();
        }

        $containers = $queryBuilder->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('backend.pages.loyalty_containers.index', compact('containers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        LoyaltyContainer::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => true,
        ]);

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $container = LoyaltyContainer::where('type', 'loyalty')->findOrFail($id);
        $container->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $container = LoyaltyContainer::findOrFail($id);
        
        // التحقق من عدم وجود حملات مرتبطة
        if ($container->loyaltyCampaigns()->count() > 0) {
            toast('لا يمكن حذف الحاوية لوجود حملات مرتبطة بها', 'error');
            return redirect()->back();
        }

        $container->delete();
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }

    public function toggleStatus($id)
    {
        $container = LoyaltyContainer::where('type', 'loyalty')->findOrFail($id);
        $container->update(['is_active' => !$container->is_active]);

        return response()->json([
            'message' => $container->is_active ? 'تم تفعيل الحاوية' : 'تم إلغاء تفعيل الحاوية',
            'status' => $container->is_active
        ]);
    }

    public function campaigns($id)
    {
        $container = LoyaltyContainer::where('type', 'loyalty')->findOrFail($id);
        $campaigns = $container->loyaltyCampaigns()->with('loyaltyCard')->paginate(10);
        
        return view('backend.pages.loyalty_containers.campaigns', compact('container', 'campaigns'));
    }
}
