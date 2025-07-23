<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Container;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $queryBuilder = Customer::with('container');

        if ($request->filled('query')) {
            $search = $request->input('query');
            $queryBuilder->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $customers = $queryBuilder->orderBy('id', 'desc')->paginate(10);
        $containers = Container::all();

        return view('backend.pages.customers.index', compact('customers', 'containers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers,phone',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'address' => 'nullable|string',
            'container_id' => 'required|exists:containers,id'
        ]);

        Customer::create($request->all());

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers,phone,' . $id,
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'address' => 'nullable|string',
            'container_id' => 'required|exists:containers,id'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
            'container_id' => 'required|exists:containers,id'
        ]);

        try {
            Excel::import(new CustomersImport($request->container_id), $request->file('file'));
            toast('تم استيراد العملاء بنجاح', 'success');
        } catch (\Exception $e) {
            toast('حدث خطأ أثناء الاستيراد: ' . $e->getMessage(), 'error');
        }

        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new \App\Exports\CustomersExport, 'customers.xlsx');
    }
} 