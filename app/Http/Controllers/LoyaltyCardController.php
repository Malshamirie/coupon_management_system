<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LoyaltyCardController extends Controller
{
  public function index(Request $request)
  {
    $queryBuilder = LoyaltyCard::query();

    if ($request->filled('query')) {
      $search = $request->input('query');
      $queryBuilder->where('name', 'LIKE', "%{$search}%");
    }

    $loyaltyCards = $queryBuilder->orderBy('id', 'desc')->paginate(10);

    return view('backend.pages.loyalty_cards.index', compact('loyaltyCards'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=800,height=800',
      'description' => 'nullable|string',
      'is_active' => 'boolean'
    ]);

    $data = $request->all();
    $data['slug'] = Str::slug($request->name);
    $data['is_active'] = $request->has('is_active');

    if ($request->hasFile('image')) {
      $data['image'] = $request->file('image')->store('loyalty_cards', 'public');
    }

    LoyaltyCard::create($data);
    toast('تم الإضافة بنجاح', 'success');
    return redirect()->back();
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:width=800,height=800',
      'description' => 'nullable|string',
      'is_active' => 'boolean'
    ]);

    $loyaltyCard = LoyaltyCard::findOrFail($id);
    $data = $request->all();
    $data['slug'] = Str::slug($request->name);
    $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($loyaltyCard->image) {
                Storage::disk('public')->delete($loyaltyCard->image);
            }
            $data['image'] = $request->file('image')->store('loyalty_cards', 'public');
        }

    $loyaltyCard->update($data);
    toast('تم التعديل بنجاح', 'success');
    return redirect()->back();
  }

  public function destroy($id)
  {
    $loyaltyCard = LoyaltyCard::findOrFail($id);

            if ($loyaltyCard->image) {
            Storage::disk('public')->delete($loyaltyCard->image);
        }

    $loyaltyCard->delete();
    toast('تم الحذف بنجاح', 'success');
    return redirect()->back();
  }
}
