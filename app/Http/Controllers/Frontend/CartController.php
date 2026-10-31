<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = $this->cartItems($request);

        return view('frontend.shop.cart', [
            'items' => $items,
            'subtotal' => $items->sum(fn ($item) => $item['unit_price'] * $item['quantity']),
            'cartCount' => $items->sum('quantity'),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate(['product_id' => ['required','integer','exists:products,id'], 'variant_id' => ['nullable','integer'], 'quantity' => ['required','integer','min:1','max:20']]);
        $product = Product::with('variants')->findOrFail($data['product_id']);
        $key = $this->validateSelection($product, $data['variant_id'] ?? null, (int) $data['quantity']);
        $cart = $request->session()->get('hom_cart', []);
        $newQuantity = (int) ($cart[$key] ?? 0) + (int) $data['quantity'];
        if ($newQuantity > 20) throw ValidationException::withMessages(['quantity' => 'A maximum of 20 units can be added for one product option.']);
        $this->validateSelection($product, $data['variant_id'] ?? null, $newQuantity);
        $cart[$key] = $newQuantity;
        $request->session()->put('hom_cart', $cart);

        return redirect()->back()->with('cart_success', 'Added to your bag.');
    }

    public function buyNow(Request $request)
    {
        $data = $request->validate(['product_id' => ['required','integer','exists:products,id'], 'variant_id' => ['nullable','integer'], 'quantity' => ['required','integer','min:1','max:20']]);
        $product = Product::with('variants')->findOrFail($data['product_id']);
        $key = $this->validateSelection($product, $data['variant_id'] ?? null, (int) $data['quantity']);
        $request->session()->put('hom_cart', [$key => (int) $data['quantity']]);

        return redirect()->route('checkout.index')->with('cart_success', 'Your selection is ready for checkout.');
    }

    public function update(Request $request, string $key)
    {
        $data = $request->validate(['quantity' => ['required','integer','min:1','max:20']]);
        $cart = $request->session()->get('hom_cart', []);
        abort_unless(array_key_exists($key, $cart), 404);
        [$productId, $variantId] = $this->parseKey($key);
        $product = Product::with('variants')->findOrFail($productId);
        $this->validateSelection($product, $variantId, (int) $data['quantity']);
        $cart[$key] = (int) $data['quantity'];
        $request->session()->put('hom_cart', $cart);

        return redirect()->route('cart.index')->with('cart_success', 'Bag updated.');
    }

    public function remove(Request $request, string $key)
    {
        $cart = $request->session()->get('hom_cart', []);
        unset($cart[$key]);
        $request->session()->put('hom_cart', $cart);

        return redirect()->route('cart.index')->with('cart_success', 'Item removed from your bag.');
    }

    public function currentItems(Request $request): Collection
    {
        return $this->cartItems($request);
    }

    private function cartItems(Request $request): Collection
    {
        $cart = $request->session()->get('hom_cart', []);
        $items = collect();
        foreach ($cart as $key => $quantity) {
            try {
                [$productId, $variantId] = $this->parseKey((string) $key);
                $product = Product::with('variants')->where('status', 1)->find($productId);
                if (!$product) { unset($cart[$key]); continue; }
                $variant = $variantId ? $product->variants->first(fn ($item) => $item->id === $variantId && $item->is_active) : null;
                if ($variantId && !$variant) { unset($cart[$key]); continue; }
                if (!$variantId && $product->variants->isNotEmpty()) { unset($cart[$key]); continue; }
                $price = (float) (($variant?->sale_price ?: $variant?->price) ?: ($product->sale_price ?: $product->price));
                $items->push(['key' => $key, 'product' => $product, 'variant' => $variant, 'quantity' => (int) $quantity, 'unit_price' => $price]);
            } catch (\Throwable) {
                unset($cart[$key]);
            }
        }
        $request->session()->put('hom_cart', $cart);

        return $items;
    }

    private function validateSelection(Product $product, mixed $variantId, int $quantity): string
    {
        if (!$product->status) throw ValidationException::withMessages(['product_id' => 'This product is not currently available.']);
        $activeVariants = $product->variants->where('is_active', true);
        $variant = null;
        if ($product->variants->isNotEmpty()) {
            if ($activeVariants->isEmpty()) throw ValidationException::withMessages(['variant_id' => 'No options for this product are currently available.']);
            if (!$variantId) throw ValidationException::withMessages(['variant_id' => 'Please choose a size or colour first.']);
            $variant = $activeVariants->first(fn ($item) => $item->id === (int) $variantId);
            if (!$variant) throw ValidationException::withMessages(['variant_id' => 'That product option is no longer available. Please choose again.']);
        } elseif ($variantId) {
            throw ValidationException::withMessages(['variant_id' => 'That product option is no longer available.']);
        }
        $stock = $variant?->stock ?? $product->stock;
        if ($stock < $quantity && !$product->is_made_to_order) throw ValidationException::withMessages(['quantity' => 'The selected quantity is not available in ready stock.']);
        if ($stock < 1 && !$product->is_made_to_order) throw ValidationException::withMessages(['product_id' => 'This product is currently out of stock.']);

        return $product->id.':'.($variant?->id ?? 0);
    }

    private function parseKey(string $key): array
    {
        if (!preg_match('/^(\d+):(\d+)$/', $key, $matches)) abort(404);

        return [(int) $matches[1], (int) $matches[2] ?: null];
    }
}
