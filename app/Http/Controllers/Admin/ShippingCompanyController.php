<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ShippingCompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = ShippingCompany::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('company_name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'accredited') {
                    $query->where('is_accredited', true);
                } elseif ($request->status === 'not_accredited') {
                    $query->where('is_accredited', false);
                }
            })
            ->orderBy('company_name')
            ->paginate(10)
            ->withQueryString();

        $totalCompanies = ShippingCompany::count();
        $accreditedCompanies = ShippingCompany::where('is_accredited', true)->count();
        $notAccreditedCompanies = ShippingCompany::where('is_accredited', false)->count();

        return view('admin.shipping-companies.index', compact(
            'companies',
            'totalCompanies',
            'accreditedCompanies',
            'notAccreditedCompanies'
        ));
    }

    public function create()
    {
        return view('admin.shipping-companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => [
                'required',
                'string',
                'max:255',
                'unique:shipping_companies,company_name',
            ],
            'company_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'company_address' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_accredited' => [
                'required',
                'boolean',
            ],
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')
                ->store('shipping-company-logos', 'public');
        }

        ShippingCompany::create([
            'company_name' => $validated['company_name'],
            'company_information' => $validated['company_information'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'logo_path' => $logoPath,
            'is_accredited' => $validated['is_accredited'],
        ]);

        return redirect()
            ->route('admin.shipping-companies.index')
            ->with('success', 'Shipping company added successfully.');
    }

    public function show(ShippingCompany $shippingCompany)
    {
        return redirect()->route(
            'admin.shipping-companies.edit',
            $shippingCompany->id
        );
    }

    public function edit(ShippingCompany $shippingCompany)
    {
        return view('admin.shipping-companies.edit', compact('shippingCompany'));
    }

    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        $validated = $request->validate([
            'company_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipping_companies', 'company_name')
                    ->ignore($shippingCompany->id),
            ],
            'company_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'company_address' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_accredited' => [
                'required',
                'boolean',
            ],
        ]);

        $logoPath = $shippingCompany->logo_path;

        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }

            $logoPath = $request->file('logo')
                ->store('shipping-company-logos', 'public');
        }

        $shippingCompany->update([
            'company_name' => $validated['company_name'],
            'company_information' => $validated['company_information'] ?? null,
            'company_address' => $validated['company_address'] ?? null,
            'logo_path' => $logoPath,
            'is_accredited' => $validated['is_accredited'],
        ]);

        return redirect()
            ->route('admin.shipping-companies.index')
            ->with('success', 'Shipping company updated successfully.');
    }

    public function destroy(ShippingCompany $shippingCompany)
    {
        if ($shippingCompany->logo_path) {
            Storage::disk('public')->delete($shippingCompany->logo_path);
        }

        $shippingCompany->delete();

        return redirect()
            ->route('admin.shipping-companies.index')
            ->with('success', 'Shipping company deleted successfully.');
    }
}
