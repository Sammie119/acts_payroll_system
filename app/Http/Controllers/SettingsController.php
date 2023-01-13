<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\TaxSSNIT;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function indexDropdown()
    {
        $dropdowns = Dropdown::orderByDesc('dropdown_id')->get();
        return view('dropdowns', ['dropdowns' => $dropdowns]);
    }

    public function createDropdown()
    {
        return view('add_dropdown');
    }

    public function storeDropdown(Request $request)
    {
        request()->validate([
            'dropdown_name' => 'required',
            'category_id' => 'required|numeric',
        ]);
        // dd($request->all());
        Dropdown::updateOrCreate(
            [
                'dropdown_name' => $request['dropdown_name'],
            ],
            [
                'category_id' => $request['category_id'],
            ]
        );

        return redirect('dropdowns')->with('success', 'Dropdown Created Successfully!!');
    }

    public function editDropdown($id)
    {
        $dropdown = Dropdown::find($id);
        return view('add_dropdown', ['dropdown' => $dropdown]);
    }

    public function updateDropdown(Request $request)
    {
        request()->validate([
            'dropdown_name' => 'required',
            'category_id' => 'required|numeric',
        ]);
        // dd($request->all());
        Dropdown::find($request->id)->update([
                'dropdown_name' => $request['dropdown_name'],
                'category_id' => $request['category_id'],
            ]);

        return redirect('dropdowns')->with('success', 'Dropdown Updated Successfully!!');
    }

    public function deleteDropdown($id)
    {
        Dropdown::find($id)->delete();
        return back()->with('success', 'Dropdown Deleted Successfully!!');
    }

    public function indexTax()
    {
        $tax = TaxSSNIT::orderByDesc('id')->first();
        return view('tax_settings', ['tax' => $tax]);
    }

    public function storeTax(Request $request)
    {
        // dd($request->all());
        TaxSSNIT::create([
            'first_0' => $request->first_0,
            'next_5' => $request->next_5,
            'next_10' => $request->next_10,
            'next_17_5' => $request->next_17_5,
            'next_25' => $request->next_25,
            'exceeding' => $request->exceeding,
            'rate_0' => $request->rate_0,
            'rate_1' => $request->rate_1,
            'rate_2' => $request->rate_2,
            'rate_3' => $request->rate_3,
            'rate_4' => $request->rate_4,
            'rate_5' => $request->rate_5,
            'ssf_employer' => $request->ssf_employer,
            'ssf_employee' => $request->ssf_employee,
        ]);

        return back()->with('success', 'Tax Saved Successfully!!');
    }
}
