<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = ShippingCompany::query()
            ->where('is_accredited', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(
                    'company_name',
                    'like',
                    '%' . $request->search . '%'
                );
            })
            ->orderBy('company_name')
            ->paginate(12)
            ->withQueryString();

        return view('cadet.shipping-companies.index', compact('companies'));
    }
}
