<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use App\Models\Group;
use Illuminate\Http\Request;

class BranchController extends Controller
{
  public function index(Request $request)
  {
    $queryBuilder = Branch::with(['city', 'group']);

    if ($request->filled('query')) {
      $search = $request->input('query');
      $queryBuilder->where(function ($q) use ($search) {
        $q->where('branch_number', 'LIKE', "%{$search}%")
          ->orWhere('branch_name', 'LIKE', "%{$search}%")
          ->orWhere('contact_number', 'LIKE', "%{$search}%");
      });
    }

    $branches = $queryBuilder->orderBy('id', 'desc')->paginate(10);
    $cities = City::all();
    $groups = Group::all();

    return view('backend.pages.branches.index', compact('branches', 'cities', 'groups'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'branch_number' => 'required|string|max:255|unique:branches,branch_number',
      'branch_name' => 'required|string|max:255',
      'contact_number' => 'required|string|max:255',
      'city_id' => 'required|exists:cities,id',
      'area' => 'required|string|max:255',
      'google_map_link' => 'nullable|url',
      'group_id' => 'required|exists:groups,id'
    ]);

    Branch::create($request->all());

    toast('تم الإضافة بنجاح', 'success');
    return redirect()->back();
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'branch_number' => 'required|string|max:255|unique:branches,branch_number,' . $id,
      'branch_name' => 'required|string|max:255',
      'contact_number' => 'required|string|max:255',
      'city_id' => 'required|exists:cities,id',
      'area' => 'required|string|max:255',
      'google_map_link' => 'nullable|url',
      'group_id' => 'required|exists:groups,id'
    ]);

    $branch = Branch::findOrFail($id);
    $branch->update($request->all());

    toast('تم التعديل بنجاح', 'success');
    return redirect()->back();
  }

  public function destroy($id)
  {
    $branch = Branch::findOrFail($id);
    $branch->delete();
    toast('تم الحذف بنجاح', 'success');
    return redirect()->back();
  }
}
