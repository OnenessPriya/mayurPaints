<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// admin guard
Route::prefix('admin')->name('admin.')->group(function () {
    // auth
    Route::middleware(['guest:admin'])->group(function () {
        Route::view('/login', 'admin.auth.login')->name('login');
        Route::post('/check', 'Admin\AdminController@check')->name('login.check');
        Route::get('forget-password', 'Admin\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
        Route::post('forget-password', 'Admin\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
        Route::get('reset-password/{token}', 'Admin\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
        Route::post('reset-password', 'Admin\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');
    });

    Route::middleware(['auth:admin'])->group(function () {
        // dashboard
        Route::get('/home', 'Admin\AdminController@home')->name('home');
        Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
        Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');
        Route::post('/changepassword', 'Admin\ProfileController@changePassword')->name('admin.profile.changepassword');

        // category
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', 'Admin\CategoryController@index')->name('index');
			 Route::get('/create', 'Admin\CategoryController@create')->name('create');
            Route::post('/store', 'Admin\CategoryController@store')->name('store');
            Route::get('/{id}/view', 'Admin\CategoryController@show')->name('view');
			Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\CategoryController@update')->name('update');
            Route::get('/{id}/status', 'Admin\CategoryController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\CategoryController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\CategoryController@bulkDestroy')->name('bulkDestroy');
            Route::get('/export/csv', 'Admin\CategoryController@exportCSV')->name('export.csv');
        });
        // brochure
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/', 'Admin\BannerController@index')->name('index');
			Route::get('/create', 'Admin\BannerController@create')->name('create');
            Route::post('/offer', 'Admin\BannerController@store')->name('store');
            Route::get('/{id}/view', 'Admin\BannerController@show')->name('view');
			Route::get('/{id}/edit', 'Admin\BannerController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\BannerController@update')->name('update');
            Route::get('/{id}/status', 'Admin\BannerController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\BannerController@destroy')->name('delete');
        });
        // painter
        Route::prefix('user/painter')->name('user.painter.')->group(function () {
            Route::get('/', 'Admin\PainterController@index')->name('index');
            Route::get('/{id}/view', 'Admin\PainterController@show')->name('view');
            Route::get('/{id}/status', 'Admin\PainterController@status')->name('status');
            Route::get('/{id}/verification', 'Admin\PainterController@verification')->name('verification');
            Route::get('/{id}/delete', 'Admin\PainterController@destroy')->name('delete');
            Route::get('/export/csv', 'Admin\PainterController@exportCSV')->name('export.all');
        });
        // sales person
        Route::prefix('user/sales-person')->name('user.sales-person.')->group(function () {
            Route::get('/', 'Admin\UserController@index')->name('index');
            Route::get('/create', 'Admin\UserController@create')->name('create');
            Route::post('/store', 'Admin\UserController@store')->name('store');
            Route::get('/{id}/view', 'Admin\UserController@show')->name('view');
            Route::get('/{id}/edit', 'Admin\UserController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\UserController@update')->name('update');
            Route::get('/{id}/status', 'Admin\UserController@status')->name('status');
            Route::get('/{id}/verification', 'Admin\UserController@verification')->name('verification');
            Route::get('/{id}/delete', 'Admin\UserController@destroy')->name('delete');
            Route::get('/export/csv', 'Admin\UserController@exportCSV')->name('export.all');
			Route::post('/password/generate', 'Admin\UserController@passwordGenerate')->name('password.generate');
			Route::post('/password/reset', 'Admin\UserController@passwordReset')->name('password.reset');
        });
        // customer
        Route::prefix('user/customer')->name('user.customer.')->group(function () {
            Route::get('/', 'Admin\CustomerController@index')->name('index');
            Route::get('/create', 'Admin\CustomerController@create')->name('create');
            Route::post('/store', 'Admin\CustomerController@store')->name('store');
            Route::get('/{id}/view', 'Admin\CustomerController@show')->name('view');
            Route::get('/{id}/edit', 'Admin\CustomerController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\CustomerController@update')->name('update');
            Route::get('/{id}/status', 'Admin\CustomerController@status')->name('status');
            Route::get('/{id}/verification', 'Admin\CustomerController@verification')->name('verification');
            Route::get('/{id}/delete', 'Admin\CustomerController@destroy')->name('delete');
            Route::get('/export/csv', 'Admin\CustomerController@exportCSV')->name('export.all');
			Route::post('/password/generate', 'Admin\CustomerController@passwordGenerate')->name('password.generate');
			Route::post('/password/reset', 'Admin\CustomerController@passwordReset')->name('password.reset');
        });
      
            // notification
            Route::prefix('notification')->name('notification.')->group(function () {
                Route::get('/', 'Admin\NotificationController@index')->name('index');
				Route::get('/export/csv', 'Admin\NotificationController@exportCSV')->name('export.csv');
            });
        });
       // product
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/list', 'Admin\ProductController@index')->name('index');
            Route::get('/create', 'Admin\ProductController@create')->name('create');
            Route::post('/store', 'Admin\ProductController@store')->name('store');
            Route::get('/{id}/view', 'Admin\ProductController@show')->name('view');
            Route::post('/size', 'Admin\ProductController@size')->name('size');
            Route::get('/{id}/edit', 'Admin\ProductController@edit')->name('edit');
            Route::post('/update', 'Admin\ProductController@update')->name('update');
            Route::get('/{id}/status', 'Admin\ProductController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\ProductController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\ProductController@bulkDestroy')->name('bulkDestroy');
            Route::get('/export/csv', 'Admin\ProductController@exportCSV')->name('export.csv');
           
        });
        // qrcode
        Route::prefix('/qrcode')->name('qrcode.')->group(function () {
            Route::get('/', 'Admin\QRcodeController@index')->name('index');
            Route::get('/create', 'Admin\QRcodeController@create')->name('create');
            Route::get('/csv/export', 'Admin\QRcodeController@csvExport')->name('csv.export');
            Route::get('{slug}/csv/export', 'Admin\QRcodeController@csvExportSlug')->name('detail.csv.export');
            Route::post('/store', 'Admin\QRcodeController@store')->name('store');
            Route::get('/{id}/edit', 'Admin\QRcodeController@edit')->name('edit');
            Route::get('/{slug}/view', 'Admin\QRcodeController@show')->name('view');
            Route::get('/{id}/show', 'Admin\QRcodeController@view')->name('show');
            Route::post('/{id}/update', 'Admin\QRcodeController@update')->name('update');
            Route::get('/{id}/status', 'Admin\QRcodeController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\QRcodeController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\QRcodeController@bulkDestroy')->name('bulkDestroy');

        });
        // faq
        Route::prefix('about')->name('about.')->group(function () {
            Route::get('/', 'Admin\AboutManagementController@index')->name('index');
            Route::get('/{id}/view', 'Admin\AboutManagementController@show')->name('view');
            Route::post('/{id}/update', 'Admin\AboutManagementController@update')->name('update');
        });
         // enquiry
         Route::prefix('enquiry')->name('enquiry.')->group(function () {
            Route::get('/', 'Admin\EnquiryController@index')->name('index');
            Route::get('/{id}/view', 'Admin\EnquiryController@show')->name('view');
        });
        // complaint
        Route::prefix('complaint')->name('complaint.')->group(function () {
            Route::get('/', 'Admin\ComplaintController@index')->name('index');
            Route::get('/{id}/view', 'Admin\ComplaintController@show')->name('view');
        });
         // complaint
         Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', 'Admin\ChatController@index')->name('index');
            Route::post('/store', 'Admin\ChatController@store')->name('store');
            Route::post('/store/ajax', 'Admin\ChatController@storeAjax')->name('store.ajax');
            Route::post('/store/file/ajax/{channel_id}/{user_id}', 'Admin\ChatController@storeFileAjax')->name('store.file.ajax');
            Route::get('/view/{id}', 'Admin\ChatController@fetchMessages')->name('view');
        });
        // order
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', 'Admin\OrderController@index')->name('index');
            Route::get('/{id}/view', 'Admin\OrderController@show')->name('view');
            Route::get('/export/csv', 'Admin\OrderController@exportCSV')->name('export.csv');
            Route::get('/{id}/status/{status}', 'Admin\OrderController@status')->name('status');
        });

    Route::prefix('reward')->name('reward.')->group(function () {
        // product
        Route::prefix('/product')->name('product.')->group(function () {
            Route::get('/', 'Admin\RewardProductController@index')->name('index');
            Route::get('/create', 'Admin\RewardProductController@create')->name('create');
            Route::post('/store', 'Admin\RewardProductController@store')->name('store');
            Route::get('/{id}/view', 'Admin\RewardProductController@show')->name('view');
            Route::get('/{id}/edit', 'Admin\RewardProductController@edit')->name('edit');
            Route::post('/update', 'Admin\RewardProductController@update')->name('update');
            Route::get('/{id}/status', 'Admin\RewardProductController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\RewardProductController@destroy')->name('delete');
            Route::get('/export/csv', 'Admin\RewardProductController@exportCSV')->name('export.csv');
        });
    });
});

Route::post('/admin/logout', 'Admin\TestController@logout')->name('admin.logout');
