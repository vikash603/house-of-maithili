<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
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







// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);

Route::prefix('admin')->group(function () {

  Route::resource('categories', CategoryController::class);
  Route::resource('subcategories', SubCategoryController::class);
  Route::resource('products', ProductController::class);

  // ✅ FIXED (no admin/admin)
  Route::delete('product-image/{id}', [ProductController::class, 'deleteImage'])
      ->name('product.image.delete');

  // SUBCATEGORY FETCH
  Route::get('get-subcategories/{id}', function ($id) {
      return \App\Models\SubCategory::where('category_id', $id)->get();
  });

});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', [AdminController::class, 'index']); // ✅ Changed


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
