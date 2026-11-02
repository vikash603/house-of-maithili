<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\PrivacyController;
use App\Http\Controllers\Backend\RefundController;
use App\Http\Controllers\Backend\TermsController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\StoryController;
use App\Http\Controllers\Backend\BulkProductImportController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\HomeHighlightController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AccountAccessController;
use App\Http\Controllers\Frontend\AccountOrderController;







// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/shop/suggestions', [ShopController::class, 'suggestions'])->name('shop.suggestions');
Route::get('/shop/makhana', [ShopController::class, 'makhana'])->name('shop.makhana');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/products/{product:slug}', [ShopController::class, 'show'])->name('shop.products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');
Route::patch('/cart/items/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/items/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
Route::delete('/checkout/coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->middleware('throttle:10,1')->name('checkout.place-order');
Route::post('/checkout/payment/verify', [CheckoutController::class, 'verifyPayment'])->middleware('throttle:10,1')->name('checkout.payment.verify');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->middleware('signed')->name('checkout.success');
Route::get('/checkout/invoice/{orderNumber}/pdf', [AccountAccessController::class, 'invoicePdf'])->middleware(['signed', 'throttle:10,1'])->name('checkout.invoice.pdf');
Route::get('/checkout/invoice/{orderNumber}', [AccountAccessController::class, 'invoice'])->middleware('signed')->name('checkout.invoice');
Route::post('/checkout/account/{orderNumber}/verify', [AccountAccessController::class, 'verifyOrderAccount'])->middleware(['signed', 'throttle:5,10'])->name('checkout.account.verify');
Route::post('/checkout/account/{orderNumber}/resend', [AccountAccessController::class, 'resendOrderCode'])->middleware(['signed', 'throttle:3,10'])->name('checkout.account.resend');
Route::post('/razorpay/webhook', [CheckoutController::class, 'webhook'])->name('razorpay.webhook');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
  Route::get('orders', [AccountOrderController::class, 'index'])->name('orders.index');
  Route::get('orders/{order}', [AccountOrderController::class, 'show'])->name('orders.show');
  Route::post('orders/{order}/cancel', [AccountOrderController::class, 'requestCancellation'])->middleware('throttle:5,10')->name('orders.cancel');
  Route::post('orders/{order}/return', [AccountOrderController::class, 'requestReturn'])->middleware('throttle:5,10')->name('orders.return');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->prefix('admin')->group(function () {

  Route::middleware('can:access-admin')->group(function () {

  Route::resource('categories', CategoryController::class);
  Route::resource('subcategories', SubCategoryController::class);
  Route::get('products/import/template', [BulkProductImportController::class, 'template'])->name('products.import.template');
  Route::get('products/import', [BulkProductImportController::class, 'index'])->name('products.import');
  Route::post('products/import/preview', [BulkProductImportController::class, 'preview'])->name('products.import.preview');
  Route::post('products/import/confirm', [BulkProductImportController::class, 'confirm'])->name('products.import.confirm');
  Route::post('products/import/cancel', [BulkProductImportController::class, 'cancel'])->name('products.import.cancel');
  Route::resource('products', ProductController::class);
  Route::resource('stories', StoryController::class)->except(['show']);
  Route::resource('home-highlights', HomeHighlightController::class)->except(['show']);
  Route::resource('testimonials', TestimonialController::class)->except(['show']);
  Route::resource('coupons', CouponController::class)->except(['show']);
  // ✅ FIXED (no admin/admin)
  Route::delete('product-image/{id}', [ProductController::class, 'deleteImage'])
      ->name('product.image.delete');

  // SUBCATEGORY FETCH
  Route::get('get-subcategories/{id}', function ($id) {
      return \App\Models\SubCategory::where('category_id', $id)->get();
  });

  });

  Route::middleware('can:manage-orders')->prefix('orders')->name('admin.orders.')->group(function () {
    Route::post('/notifications/read-all', [OrderController::class, 'markAllNotificationsRead'])->name('notifications.read-all');
    Route::post('/notifications/{notification}/read', [OrderController::class, 'markNotificationRead'])->name('notifications.read');
    Route::get('/', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/list', [OrderController::class, 'index'])->name('index');
    Route::get('/export', [OrderController::class, 'export'])->name('export');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('status');
    Route::patch('/{order}/shipping', [OrderController::class, 'updateShipping'])->name('shipping');
    Route::post('/{order}/notes', [OrderController::class, 'addNote'])->name('notes');
    Route::post('/{order}/refunds', [OrderController::class, 'recordRefund'])->name('refunds');
    Route::post('/{order}/cod-paid', [OrderController::class, 'markCodPaid'])->name('cod-paid');
  });

});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:access-admin'])
    ->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('banners', BannerController::class)->except(['show']);


     // privacy
     Route::get('/privacys', [PrivacyController::class, 'index'])->name('privacy.index');
     Route::get('/privacys/create', [PrivacyController::class, 'create'])->name('privacy.create');
     Route::post('/privacys/store', [PrivacyController::class, 'store'])->name('privacy.store');
     Route::get('/privacys/edit/{id}', [PrivacyController::class, 'edit'])->name('privacy.edit');
     Route::post('/privacys/update/{id}', [PrivacyController::class, 'update'])->name('privacy.update');
     Route::delete('/privacys/delete/{id}', [PrivacyController::class, 'destroy'])->name('privacy.delete');
 
 
      // refund
      Route::get('/refunds', [RefundController::class, 'index'])->name('refund.index');
      Route::get('/refunds/create', [RefundController::class, 'create'])->name('refund.create');
      Route::post('/refunds/store', [RefundController::class, 'store'])->name('refund.store');
      Route::get('/refunds/edit/{id}', [RefundController::class, 'edit'])->name('refund.edit');
      Route::post('/refunds/update/{id}', [RefundController::class, 'update'])->name('refund.update');
      Route::delete('/refunds/delete/{id}', [RefundController::class, 'destroy'])->name('refund.delete');
 
 
       // terms
     Route::get('/termss', [TermsController::class, 'index'])->name('terms.index');
     Route::get('/termss/create', [TermsController::class, 'create'])->name('terms.create');
     Route::post('/termss/store', [TermsController::class, 'store'])->name('terms.store');
     Route::get('/termss/edit/{id}', [TermsController::class, 'edit'])->name('terms.edit');
     Route::post('/termss/update/{id}', [TermsController::class, 'update'])->name('terms.update');
     Route::delete('/termss/delete/{id}', [TermsController::class, 'destroy'])->name('terms.delete');
 
 
      // news
      Route::get('/blog', [NewsController::class, 'index'])->name('news.index');
      Route::get('/blog/create', [NewsController::class, 'create'])->name('news.create');
      Route::post('/blog/store', [NewsController::class, 'store'])->name('news.store');
      Route::get('/blog/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
      Route::post('/blog/update/{id}', [NewsController::class, 'update'])->name('news.update');
      Route::delete('/blog/delete/{id}', [NewsController::class, 'destroy'])->name('news.delete');
 
       // about
     Route::get('/abouts', [AboutController::class, 'index'])->name('about.index');
     Route::get('/abouts/create', [AboutController::class, 'create'])->name('about.create');
     Route::post('/abouts/store', [AboutController::class, 'store'])->name('about.store');
     Route::get('/abouts/edit/{id}', [AboutController::class, 'edit'])->name('about.edit');
     Route::put('/abouts/update/{id}', [AboutController::class, 'update'])->name('about.update');
     Route::delete('/abouts/delete/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
 
    // contact
     Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
     Route::delete('/contacts/delete/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
});
