<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::query()
            ->when($request->filled('search'), fn ($query) => $query->where('code', 'like', '%'.strtoupper(trim($request->string('search')->toString())).'%'))
            ->latest()->paginate(15)->withQueryString();

        return view('backend.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.coupon.create');
    }

    public function store(Request $request)
    {
        $coupon = Coupon::create($this->validatedData($request));

        return redirect()->route('coupons.index')->with('success', "Coupon {$coupon->code} created.");
    }

    public function edit(Coupon $coupon)
    {
        return view('backend.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->validatedData($request, $coupon));

        return redirect()->route('coupons.index')->with('success', "Coupon {$coupon->code} updated.");
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted.');
    }

    private function validatedData(Request $request, ?Coupon $coupon = null): array
    {
        $request->merge(['code' => Str::upper(trim((string) $request->input('code')))]);
        $validated = $request->validate([
            'code' => ['required','string','max:40', Rule::unique('coupons', 'code')->ignore($coupon?->id)],
            'discount_type' => ['required', Rule::in(['fixed','percentage'])],
            'discount_value' => ['required','numeric','gt:0','max:10000000'],
            'minimum_subtotal' => ['nullable','numeric','min:0','max:99999999.99'],
            'maximum_discount' => ['nullable','numeric','gt:0','max:99999999.99'],
            'valid_from' => ['nullable','date'],
            'valid_until' => ['nullable','date','after_or_equal:valid_from'],
            'is_active' => ['nullable','boolean'],
        ]);

        if ($validated['discount_type'] === 'percentage' && (float) $validated['discount_value'] > 100) {
            throw ValidationException::withMessages(['discount_value' => 'Percentage discount cannot be greater than 100%.']);
        }

        $validated['code'] = Str::upper(trim($validated['code']));
        $validated['minimum_subtotal'] = $validated['minimum_subtotal'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
