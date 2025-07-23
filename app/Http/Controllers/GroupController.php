<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
  public function index(Request $request)
  {
    $queryBuilder = Group::query();

    if ($request->filled('query')) {
      $search = $request->input('query');
      $queryBuilder->where('name', 'LIKE', "%{$search}%");
    }

    $groups = $queryBuilder->orderBy('id', 'desc')->paginate(10);

    return view('backend.pages.groups.index', compact('groups'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:groups,name'
    ]);

    Group::create([
      'name' => $request->name
    ]);

    toast('تم الإضافة بنجاح', 'success');
    return redirect()->back();
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:groups,name,' . $id
    ]);

    $group = Group::findOrFail($id);
    $group->update([
      'name' => $request->name
    ]);

    toast('تم التعديل بنجاح', 'success');
    return redirect()->back();
  }

  public function destroy($id)
  {
    $group = Group::findOrFail($id);
    $group->delete();
    toast('تم الحذف بنجاح', 'success');
    return redirect()->back();
  }
}