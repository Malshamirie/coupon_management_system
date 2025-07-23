<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
  public function index(Request $request)
  {
    $queryBuilder = City::query();

    if ($request->filled('query')) {
      $search = $request->input('query');
      $queryBuilder->where('name', 'LIKE', "%{$search}%");
    }

    $cities = $queryBuilder->orderBy('id', 'desc')->paginate(10);

    return view('backend.pages.cities.index', compact('cities'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:cities,name'
    ]);

    City::create([
      'name' => $request->name
    ]);

    toast('تم الإضافة بنجاح', 'success');
    return redirect()->back();
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255|unique:cities,name,' . $id
    ]);

    $city = City::findOrFail($id);
    $city->update([
      'name' => $request->name
    ]);

    toast('تم التعديل بنجاح', 'success');
    return redirect()->back();
  }

  public function destroy($id)
  {
    $city = City::findOrFail($id);
    $city->delete();
    toast('تم الحذف بنجاح', 'success');
    return redirect()->back();
  }
}