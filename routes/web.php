<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('route:clear');
    return 'DONE'; //Return anything
});

Route::get('/vendor-publish', function() {
    $exitCode = Artisan::call('vendor:publish');
    return 'DONE'; //Return anything
});

Route::get('/datatables',[
	'uses'=>'DatatablesController@getIndex',
	'as'=>'get-datatables'
]);

Route::get('/datatables-data',[
	'uses'=>'DatatablesController@anyData',
	'as'=>'datatables.data'
]);

Route::get('/go-back', function() {
    return redirect()->back();   
})->name('go-back');

Route::get('/bagsak_now', function() {
    $exitCode = Artisan::call('down');
    return 'Website Down'; //Return anything
});

Route::get('/bangon_now', function() {
    $exitCode = Artisan::call('up');
    return 'Website UP'; //Return anything
});

Route::get('/maintenance', function () {
    return view('errors/maintenance');
})->name('maintenance-mode');




Route::get('/forgot-password',[
	'uses'=>'Auth\ForgotPasswordController@getForgotPassword',
	'as'=>'forgot-password'
]);

Route::post('/forgot-password',[
	'uses'=>'Auth\ForgotPasswordController@resetPassword',
	'as'=>'forgot-password-submit'
]);

Route::post('/password-update',[
	'uses'=>'Auth\ForgotPasswordController@resetPasswordUpdate',
	'as'=>'password-update-submit'
]);


//Route::get('/member-login', function () {
Route::get('/now', function () {
    return view('auth/member-login');
})->name('now');



Route::get('/member-login', function () {
    return view('auth/member-login');
    //return view('errors/maintenance');
})->name('member-login');

Route::get('/admin-login', function () {
    return view('auth/admin-login');
});

Route::get('/teller-login', function () {
    return view('auth/teller-login');
});

Route::get('login-check/{user}', 'LoginCheckController@check')->name('login-check');
Route::post('login-error', 'LoginCheckController@error')->name('login-error');


Route::get('/membership-registration-dev',[
	'uses'=>'DevJesserController@getRegister',
	'as'=>'membership-registration-dev'
]);

Route::get('/get-acc-ext-details/{username}',[
	'uses'=>'MemberRegistrationController@getExtensionAccount',
	'as'=>'get-acc-ext-details'
]);

Route::get('/membership-registration',[
	'uses'=>'MemberRegistrationController@getRegister',
	'as'=>'membership-registration'
]);

Route::get('/check-registered-email/{email}',[
	'uses'=>'MemberRegistrationController@checkRegisteredEmail',
	'as'=>'check-registered-email'
]);

Route::get('/check-registered-username/{username}',[
	'uses'=>'MemberRegistrationController@checkRegisteredUsername',
	'as'=>'check-registered-username'
]);

Route::get('/check-sponsor/{username}',[
	'uses'=>'MemberRegistrationController@checkSponsorUsername',
	'as'=>'check-sponsor'
]);

Route::get('/check-upline/{username}',[
	'uses'=>'MemberRegistrationController@checkUpline',
	'as'=>'check-upline'
]);

Route::get('/check-package-code/{code}',[
	'uses'=>'MemberRegistrationController@checkPackageCode',
	'as'=>'check-package-code'
]);

Route::get('/check-package-code-pin/{code}/{pin}',[
	'uses'=>'MemberRegistrationController@checkPackagePin',
	'as'=>'check-package-code-pin'
]);

Route::post('/save-member-register',[
	'uses'=>'MemberRegistrationController@saveMember',
	'as'=>'save-member-register'
]);

Route::get('/email-development',[
	'uses'=>'DevController@testEmail',
	'as'=>'email-development'
]);

/* -- START FREE registration routes-- */
Route::get('free-register',[
	'uses'=>'FreeRegisterController@getFreeRegister',
	'as'=>'free-register'
]);

Route::get('/purple-register/{code}',[
	'uses'=>'FreeRegisterController@getAffiliateFreeRegister',
	'as'=>'purple-register'
]);

Route::get('/product-retail/{code}',[
    'uses'=>'GuestController@productRetail',
    'as'=>'product-retail'
]);

Route::post('/insert-member-free-register',[
	'uses'=>'FreeRegisterController@insertFreeRegister',
	'as'=>'insert-member-free-register'
]);

Route::get('/test-free-register/{affiliate_link}',[
	'uses'=>'FreeRegisterController@testPosition',
	'as'=>'test-free-register'
]);

Route::get('/get-countries',[
	'uses'=>'CountryController@getCountries',
	'as'=>'get-countries'
]);

Route::get('/get-province',[
	'uses'=>'FreeRegisterController@getProvince',
	'as'=>'get-province'
]);

Route::get('/check-email/{email}',[
	'uses'=>'FreeRegisterController@checkRegisteredEmail',
	'as'=>'check-email'
]);

Route::get('/check-username/{username}',[
	'uses'=>'FreeRegisterController@checkUsername',
	'as'=>'check-username'
]);

Route::get('/get-banks',[
	'uses'=>'BankController@index',
	'as'=>'get-banks'
]);


/* -- END FREE registration routes-- */




/* member activate routes start */

Route::get('/check-placement/{username}',[
	'uses'=>'MemberActivateController@checkPlacement',
	'as'=>'check-placement'
]);

Route::post('/member-activate',[
	'uses'=>'MemberActivateController@userActivation',
	'as'=>'member-activate'
]);

Route::get('/fix-network',[
	'uses'=>'MemberRegistrationController@fix_network',
	'as'=>'fix-network'
]);



Route::get('/register-get-user-by-pcode/{code}/{pin}',[
	'uses'=>'MemberActivateController@userGetData',
	'as'=>'register-get-user-by-pcode'
]);

Route::get('/register-check-act-code/{code}',[
	'uses'=>'MemberActivateController@registerCheckCode',
	'as'=>'register-check-act-code'
]);

Route::get('/register-check-pin/{code}/{pin}',[
	'uses'=>'MemberActivateController@registerCheckPin',
	'as'=>'register-check-pin'
]);

/* member activate routes end */


Route::get('/test2',[
	'uses'=>'HomeController@test2',
	'as'=>'test2'
]);

Route::get('/test3',[
	'uses'=>'HomeController@test3',
	'as'=>'test3'
]);











Auth::routes();


//logout
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');



/* working */
/* ******************** Admin Route ******************** */
Route::group(['prefix' => 'staff',  'middleware' => 'adminMw'], function(){
    
    Route::post('edit-productData', 'ProductInventoryController@getProductData')->name('edit-productData');


	/************************************ Admin DashBoard ************************************/
	Route::get('/', 'AdminDashboardController@index')->name('admin-dashboard');

	Route::post('/currency-update', 'CurrencyController@update')->name('admin.currency-update');
	
    
	Route::post('/filter-count', 'AdminDashboardController@filterCount')->name('admin.filter-count');

	/************************************ Create User (Hidden) ************************************/
	Route::get('create-user', 'UserController@createUserForm')->name('admin.users.create');
	Route::post('create-user', 'UserController@createUser')->name('admin.users.store');
    
    /************************************ Branches ************************************/
	Route::get('add-branch', 'AdminBranchController@addBranch')->name('add-branch');
	Route::post('insert-branch', 'AdminBranchController@insertBranch')->name('insert-branch');
	Route::get('branch-list', 'AdminBranchController@viewAllBranch')->name('branch-list');
	Route::get('get-branch/{id}', 'AdminBranchController@getSpecificBranch')->name('get-branch');
	Route::post('update-branch', 'AdminBranchController@updateBranch')->name('update-branch');
	Route::post('delete-branch', 'AdminBranchController@deleteBranch')->name('delete-branch');

     /************************************ Suppliers ************************************/
	Route::get('add-supplier', 'AdminSupplierController@addSupplier')->name('add-supplier');
	Route::post('insert-supplier', 'AdminSupplierController@insertSupplier')->name('insert-supplier');
	Route::get('supplier-list', 'AdminSupplierController@viewAllSupplier')->name('supplier-list');
	Route::get('get-supplier/{id}', 'AdminSupplierController@editSupplier')->name('get-supplier');
	Route::post('update-supplier', 'AdminSupplierController@updateSupplier')->name('update-supplier');
    Route::post('delete-supplier', 'AdminSupplierController@deleteSupplier')->name('delete-supplier');

	/************************************ Announcement ************************************/
	Route::get('announcement', 'AnnouncementController@index')->name('announcement-list');
	Route::post('insert-announcement', 'AnnouncementController@insertAnnouncement')->name('insert-announcement');
	Route::get('edit-announcement/{id}', 'AnnouncementController@editAnnouncement')->name('edit-announcement');
	Route::post('update-announcement', 'AnnouncementController@updateAnnouncement')->name('update-announcement');
	Route::post('delete-announcement', 'AnnouncementController@deleteAnnouncement')->name('delete-announcement');

	/************************************ Messages/Conversations ************************************/
	Route::get('messages', 'StaffConversationController@index')->name('staff.messages.index');
	Route::get('messages/create', 'StaffConversationController@create')->name('staff.messages.create');
	Route::post('messages', 'StaffConversationController@store')->name('staff.messages.store');
	Route::get('messages/{conversation}', 'StaffConversationController@show')->name('staff.messages.show');
	Route::post('messages/{conversation}/reply', 'StaffConversationController@reply')->name('staff.messages.reply');
	Route::delete('messages/{conversation}', 'StaffConversationController@destroy')->name('staff.messages.destroy');
	Route::get('messages/{attachment}/download', 'StaffConversationController@downloadAttachment')->name('staff.messages.download');

	/************************************ Products ************************************/
    Route::get('ewallet-purchases', 'ProductController@ewallet_purchases')->name('ewallet-purchases');
    Route::get('approve-purchase/{sale}', 'ProductController@approve_purchase')->name('order.approve-purchase');
    Route::get('record-sales-admin/{sale}', 'ProductController@record_sale')->name('order.record-sale-admin');
	Route::get('products', 'ProductController@index')->name('product-list');
	Route::get('add-product', 'ProductController@create')->name('add-product');
	Route::get('view-product/{id}', 'ProductController@productView')->name('view-product');
	Route::get('view-product-movement/{id}/{type}', 'ProductController@product_movementView')->name('product-movement');
	Route::post('insert-product', 'ProductController@store')->name('insert-product');
	Route::get('edit-product/{id}', 'ProductController@productEdit')->name('staff.edit-product');
	Route::post('products/update', ['as' => 'product-update', 'uses' => 'ProductController@productUpdate']);
	//Route::post('products/delete', ['as' => 'product-delete', 'uses' => 'ProductController@deleteProduct']);
	Route::delete('products/{product}', 'ProductController@destroy')->name('product.destroy');

	/************************************ Admin New Products ************************************/
	Route::get('admin/products', 'AdminProductController@index')->name('admin.products');
	Route::get('admin/products/create', 'AdminProductController@create')->name('admin.products.create');
	Route::post('admin/products/store', 'AdminProductController@store')->name('admin.products.store');
	Route::get('admin/products/list', 'AdminProductController@getList')->name('admin.products.list');
	Route::get('admin/products/view/{id}', 'AdminProductController@view')->name('admin.products.view');
	Route::get('admin/products/edit/{id}', 'AdminProductController@edit')->name('admin.products.edit');
	Route::post('admin/products/update', 'AdminProductController@update')->name('admin.products.update');
	Route::post('admin/products/delete/{id}', 'AdminProductController@delete')->name('admin.products.delete');
	Route::get('admin/categories/list', 'AdminProductController@getCategoriesList')->name('admin.categories.list');

	// Product Submissions
	Route::get('admin/products/submissions/pending', 'AdminProductController@viewPendingSubmissions')->name('admin.products.pending-submissions');
	Route::get('admin/products/submissions/list', 'AdminProductController@getPendingSubmissions')->name('admin.products.submissions-list');
	Route::post('admin/products/submissions/approve', 'AdminProductController@approveSubmission')->name('admin.products.approve-submission');
	Route::post('admin/products/submissions/reject', 'AdminProductController@rejectSubmission')->name('admin.products.reject-submission');

	// Availed Products (Orders)
	Route::get('admin/availed-products/pending', 'AdminAvailedProductController@viewPendingOrders')->name('admin.availed-products.pending');
	Route::get('admin/availed-products/approved', 'AdminAvailedProductController@viewApprovedOrders')->name('admin.availed-products.approved');
	Route::get('admin/availed-products/list', 'AdminAvailedProductController@getPendingOrders')->name('admin.availed-products.list');
	Route::post('admin/availed-products/approve', 'AdminAvailedProductController@approveOrder')->name('admin.availed-products.approve');
	Route::post('admin/availed-products/reject', 'AdminAvailedProductController@rejectOrder')->name('admin.availed-products.reject');
	Route::post('admin/availed-products/attach', 'AdminAvailedProductController@attachDocument')->name('admin.availed-products.attach');

	// Payment Uploads
	Route::get('payments', 'admin\AdminPaymentUploadController@index')->name('admin.payments.index');
	Route::get('payments/{id}', 'admin\AdminPaymentUploadController@show')->name('admin.payments.show');
	Route::post('payments/{id}/approve', 'admin\AdminPaymentUploadController@approve')->name('admin.payments.approve');
	Route::post('payments/{id}/reject', 'admin\AdminPaymentUploadController@reject')->name('admin.payments.reject');
	Route::get('payments/{id}/download', 'admin\AdminPaymentUploadController@download')->name('admin.payments.download');


	/************************************ Inventories ************************************/
	Route::get('inventories', 'ProductInventoryController@index')->name('inventory-list');
	Route::get('all-inventories/{id}', 'ProductInventoryController@inventoriesBranch')->name('branch-inventories');
	 
	Route::get('beginning-inventories', 'ProductInventoryController@begininng_inventories')->name('beginning-inventories');
	Route::get('inventories/count', 'ProductInventoryController@count');
	Route::post('inventories/update', ['as' => 'inventories-update', 'uses' => 'ProductInventoryController@movements']);

	/************************************ Stocks ************************************/
	Route::get('add-stocks', 'ProductInventoryController@addStocks')->name('add-stocks');
	Route::post('add-stocks', 'ProductInventoryController@addStocksMovement')->name('add-stocks-insert');
	Route::get('transfer-stocks', 'ProductInventoryController@transferStocks')->name('transfer-stocks');
	Route::get('edit-stocks/{id}', 'ProductInventoryController@edit')->name('edit-stocks');
	Route::post('insert-stocks', 'ProductInventoryController@transferStocksMovement')->name('insert-stocks');
	
	
	/************************************ Packages ************************************/
	Route::get('packages', 'PackageController@index')->name('package-list');
	Route::post('insert-package', 'PackageController@store')->name('insert-package');
	Route::get('edit-package/{id}', 'PackageController@editPackage')->name('staff.edit-package');
	Route::post('update-package', 'PackageController@updatePackage')->name('update-package');
    Route::post('delete-package', 'PackageController@destroy')->name('delete-package');
    
    /************************************ Packages Dev ************************************/
	Route::get('packages-dev', 'PackageController@index_dev')->name('packages-dev');
	Route::get('edit-package-dev/{id}', 'PackageController@editPackage_dev')->name('edit-package-dev');
	Route::post('update-package-dev', 'PackageController@updatePackage')->name('update-package-dev');
	
	/************************************ Users ************************************/
	Route::get('users', 'UserController@users')->name('users');
	Route::post('allusers', ['as' => 'all-users', 'uses' => 'UserController@allUsers']);//Sever Side
	Route::post('insert-user', 'UserController@userAdd')->name('insert-user');
    Route::post('delete-user', 'UserController@deleteUser')->name('delete-user');
	Route::post('users/add', ['as' => 'user-add', 'uses' => 'UserController@userAdd']);
	
	//User Logs
	Route::get('user-logs', 'UserController@user_logs')->name('user-logs');
	Route::post('userlogs', ['as' => 'all-user-logs', 'uses' => 'UserController@userLogs']);//Sever Side
	/************************************ Encashment ************************************/
	//Route::get('encashment-view/{type}', 'AdminEncashmentController@adminViewEncashment')->name('encashment-view');
	//Route::post('encashment-view/{type}', 'AdminEncashmentController@adminViewEncashment')->name('encashment-view-search');
    //Paginated
    Route::get('encashment-view/{type}', 'AdminEncashmentController@adminViewEncashmentPaginate')->name('encashment-view');
	Route::post('encashment-view/{type}', 'AdminEncashmentController@adminViewEncashmentPaginate')->name('encashment-view-search');

	Route::post('process-encashment', 'AdminEncashmentController@processEncashment')->name('process-encashment');
	Route::get('get-encashment-data/{id}', 'AdminEncashmentController@getEncashmentData')->name('get-encashment-data');
	Route::post('all-encashment', 'AdminEncashmentController@allEncashments')->name('all-encashment');
	Route::get('encashment-voucher/{id}', 'AdminEncashmentController@adminViewVoucher')->name('encashment-voucher');
    Route::get('print-encashment/{id}', 'AdminEncashmentController@printEncashmentData')->name('print-encashment-data');
    
	//fith pair encashment
	Route::get('admin-fifth-pair-encashment/{type}', 'AdminFifthEncashmentController@adminViewEncashmentPaginate')->name('admin-fifth-pair-encashment');
	Route::post('admin-fifth-pair-encashment', 'AdminFifthEncashmentController@adminViewEncashmentPaginate')->name('admin-fifth-pair-encashment-search');
	Route::post('process-fifth-encashment', 'AdminFifthEncashmentController@processEncashment')->name('process-fifth-encashment');
    
	Route::get('get-fifth-encashment-data/{id}', 'AdminFifthEncashmentController@getEncashmentData')->name('get-fifth-encashment-data');
	Route::post('all-fifth-encashment', 'AdminFifthEncashmentController@allEncashments')->name('all-fifth-encashment');
	Route::get('fifth-encashment-voucher/{id}', 'AdminFifthEncashmentController@adminViewVoucher')->name('fifth-encashment-voucher');
    
	

	/************************************ Members ************************************/
	Route::get('members', 'UserController@today_members');
	
    
    Route::get('members/all', 'UserController@allMembersPaginate')->name('members-all');
    Route::post('members/all', 'UserController@allMembersPaginate')->name('members-all.post');
    Route::get('members/export', 'UserController@exportMembers')->name('members.export');
    
	Route::post('all-members', 'UserController@allMembers')->name('all-members'); //All Members Server Side
    
    Route::get('members/today', 'UserController@today_members')->name('members-today');
	Route::post('today-members', 'UserController@todayMembers')->name('today-members'); //Today Members Server Side
    
	Route::get('view-member-geneology/{user_id}', 'GeneologyController@viewMemberGeneology')->name('view-member-geneology');
	Route::get('get-member-geneo-data/{uid}', 'GeneologyController@getGeneoData')->name('get-member-geneo-data');

	//hidden routes
	Route::get('members/all-adminzero', 'UserController@allMembersHidden')->name('members-all-adminzero');
	Route::post('allmembers-hidden', 'UserController@allMembersHiddenSS')->name('all-members-hidden');
	
    Route::get('members/edit/', 'UserController@memberEdit');
	Route::post('members/update', ['as' => 'member-update', 'uses' => 'UserController@memberUpdate']);
    
    Route::get('members/delete-member', 'UserController@deleteMember')->name('delete-member');
    Route::get('members/select-members', 'UserController@selectMembers')->name('select-members');
    
    
    //Change Sponsor
	Route::get('members/change-sponsor', 'UserController@changeSponsorView')->name('get-change-sponsor');
	Route::post('members/change-sponsor', 'UserController@changeSponsor')->name('change-sponsor');
	Route::post('members/change-sponsor-id', 'UserController@changeSponsorById')->name('change-sponsor-id');

    
    
    
	Route::post('members/multi-delete', 'UserController@multiMemberDelete')->name('multi-member-delete');
	Route::get('member-forcedelete/{id}', 'UserController@memberDelete')->name('member-forcedelete');

	Route::post('members/password-update', ['as' => 'member-password-update', 'uses' => 'UserController@memberPasswordUpdate']);
	Route::post('members/modify', ['as' => 'member-modify', 'uses' => 'UserController@modifyMember']);
    
    /*Income Management*/
    Route::post('members/add-income', 'UserController@addIncome')->name('staff.add-income');
    Route::post('members/deduct-income', 'UserController@deductIncome')->name('staff.deduct-income');
    Route::get('members/added-incomes/{user_id}', 'UserController@getAddedIncomes')->name('staff.income-list');
    Route::post('members/income-update/{id}', 'UserController@updateIncome')->name('staff.income-update');
    Route::delete('members/income-delete/{id}', 'UserController@deleteIncome')->name('staff.income-delete');

    /*Application Management*/
    Route::get('applications/pending', 'ApplicationController@getPendingApplications')->name('applications.pending');
    Route::get('applications/approve-form/{user_id}', 'ApplicationController@showApproveForm')->name('applications.show-approve-form');
    Route::post('applications/approve/{user_id}', 'ApplicationController@approveApplication')->name('applications.approve');
    Route::post('applications/reject/{user_id}', 'ApplicationController@rejectApplication')->name('applications.reject');

    /* Application Product Codes */
    Route::get('applications/codes', 'ApplicationController@indexCodes')->name('applications.codes');
    Route::post('applications/generate-codes', 'ApplicationController@generateCodes')->name('applications.generate-codes');
    Route::get('applications/export-codes/{type}', 'ApplicationController@exportCodes')->name('applications.export-codes');

    /************************************ Reports ************************************/
    
    Route::get('sales-report', 'SaleController@salesReport')->name('sales-report');
    Route::post('sales-report', 'SaleController@salesReport')->name('search-sales-report');

	/* pv checker */
	Route::get('pv-points-checker', 'AdminDashboardController@pvchecker')->name('pv-points-checker');
	
	
	
    //Top Earners
	Route::get('top-earners', 'SaleController@topEarners')->name('top-earners');
	Route::post('top-earners', 'SaleController@topEarners')->name('search-top-earners');
    Route::post('view-top-earner', 'SaleController@viewTopEarner')->name('view-top-earner');
    
    //Top Recruiters
    Route::get('top-recruiters', 'SaleController@topRecruiters')->name('top-recuiters');
	Route::post('top-recruiters', 'SaleController@topRecruiters')->name('search-top-recuiters');
    Route::post('view-top-recruiter', 'SaleController@viewTopRecruiter')->name('view-top-recruiter');
    
    //Top Pairing & Referral
    Route::get('top-pairing-referral', 'SaleController@topPairingReferral')->name('top-pairing-referral');
    Route::post('top-pairing-referral', 'SaleController@topPairingReferral')->name('search-top-pairing-referral');
    Route::post('get-top-pairing-referral-data', 'SaleController@getTopPairingReferralData')->name('get-top-pairing-referral-data');
    
    //Product Codes
    //Route::get('product-codes', 'ProductCodeController@index')->name('product-codes');
    Route::get('product-codes/{type}', 'ProductCodeController@index')->name('product-codes');
    Route::post('memberscode', [
		'as' => 'members-code', 'uses' => 'ProductCodeController@membersCode'
	]);//Sever Side
    Route::post('nonmemberscode', [
		'as' => 'non-members-code', 'uses' => 'ProductCodeController@nonmembersCode'
	]);//Sever Side
    
    
    //PV Points Edit
    Route::get('members/pv-points', 'UserController@members_pv_points')->name('members-pv-points'); //pv points adjusment 28/10/2020
    Route::post('members/get-pv-points', 'UserController@get_members_pv_points')->name('get-pv-points'); //pv points adjusment 28/10/2020
	Route::post('members/update-pv-points', 'UserController@update_members_pv_points')->name('update-pv-points'); //pv points adjusment 28/10/2020
	
	Route::get('members/data-checker', 'UserController@members_data_checker')->name('data-checker'); //Data checker 14/12/2020
	Route::post('members/get-data-checker', 'UserController@get_data_checker')->name('get-data-checker'); //pv points adjusment 14/12/2020

	Route::get('members/unilevel-view', 'unilevelController@unilevel_view')->name('unilevel-view'); //unilevel 02/08/2021
	Route::post('members/unilevel-execute', 'unilevelController@unilevel_execute')->name('unilevel-execute'); //unilevel 02/08/2021
    
    //Product Codes
    //selects products on New Transaction
    Route::get('select-member', 'UserController@selectMembers')->name('admin-select-member');
    Route::post('new-transaction/products', 'ProductController@admin_product_transaction')->name('admin-product-transaction');
	Route::post('new-transaction/packages', 'ProductController@admin_package_transaction')->name('admin-package-transaction');
	
	Route::get('new-transaction', 'AdminTransactionController@index')->name('new.transaction');
	Route::post('new-transaction/insert', 'TransactionController@store')->name('admin.new-transaction');
	
	//Export Product Codes
	Route::get('new-transaction/export/{id}', 'TransactionController@Export')->name('admin.new-transaction.export');
    
    /************************************ Redeem Routes ************************************/
    Route::prefix('redeem')->name('redeem.')->group(function () {
        Route::get('/', 'admin\RedeemController@adminViewRedeem')->name('admin-list');
        Route::post('get-data', 'admin\RedeemController@redeemedProducts')->name('get-data');
        Route::post('process', 'admin\RedeemController@adminProcessRedeem')->name('process');
        Route::get('{id}', 'admin\RedeemController@viewRedeemRequest')->name('view');
    });

	//Donations
	Route::get('donations', 'admin\DonationController@index')->name('admin.donations');
	Route::post('donations/action', 'admin\DonationController@update')->name('admin.donations.action');

	/************************************ Advertisements Routes ************************************/
	Route::get('advertisements', 'admin\AdvertisementController@index')->name('admin.advertisements');
	Route::post('get-advertisements', 'admin\AdvertisementController@getAdvetisements')->name('admin.get-advertisements');
	Route::post('save-ads', 'admin\AdvertisementController@store')->name('admin.save-ads');
	Route::get('get-ads/{id}', 'admin\AdvertisementController@edit')->name('admin.get-ads');
	Route::post('update-ads', 'admin\AdvertisementController@update')->name('admin.update-ads');
	Route::post('advertisements/delete', 'admin\AdvertisementController@destroy')->name('admin.delete-ads');
	Route::post('advertisements/action', 'admin\AdvertisementController@action')->name('admin.ads.action');

	// Instructors Management
	Route::middleware(['can_manage_instructors'])->group(function () {
		Route::get('instructors', 'admin\InstructorController@index')->name('admin.instructors.index');
		Route::get('instructors/create', 'admin\InstructorController@create')->name('admin.instructors.create');
		Route::post('instructors/store', 'admin\InstructorController@store')->name('admin.instructors.store');
		Route::put('instructors/{id}', 'admin\InstructorController@update')->name('admin.instructors.update');
		Route::delete('instructors/{id}', 'admin\InstructorController@destroy')->name('admin.instructors.destroy');

		Route::get('courses', 'admin\CourseController@index')->name('admin.courses.index');
		Route::get('courses/{course}', 'admin\CourseController@show')->name('admin.courses.show');
		Route::post('courses/{course}/status', 'admin\CourseController@updateStatus')->name('admin.courses.update-status');
		Route::post('courses/{course}/price', 'admin\CourseController@updatePrice')->name('admin.courses.update-price');

		Route::get('enrollments', 'admin\CourseController@allEnrollments')->name('admin.courses.enrollments');
		Route::post('enrollments/{enrollment}/status', 'admin\CourseController@updateEnrollmentStatus')->name('admin.courses.enrollment-status');

		Route::get('materials', 'admin\CourseController@allMaterials')->name('admin.courses.materials');
		Route::post('materials/{material}/status', 'admin\CourseController@updateMaterialStatus')->name('admin.courses.material-status');
	});

	//profile
	Route::get('profile', 'AdminProfileController@viewProfile')->name('admin.profile');
	Route::post('update-profile', 'AdminProfileController@updateMemberProfile')->name('admin.update-profile');
	Route::post('update-password', 'AdminProfileController@updateMemberPassword')->name('admin.update-password');
	Route::post('update-picture', 'AdminProfileController@updateMemberPicture')->name('admin.update-picture');
	Route::post('update-account', 'AdminProfileController@updateAccountProfile')->name('admin.update-account');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'instructor', 'namespace' => 'Instructor'], function () {
	Route::get('dashboard', 'DashboardController@index')->name('instructor.dashboard');
	Route::resource('courses', 'CourseController', ['as' => 'instructor']);
	Route::get('enrollees', 'CourseController@enrollees')->name('instructor.courses.enrollees');
	
	Route::get('materials', 'CourseMaterialController@index')->name('instructor.materials.index');
	Route::get('materials/{course}', 'CourseMaterialController@show')->name('instructor.materials.show');
	Route::post('materials/store', 'CourseMaterialController@store')->name('instructor.materials.store');
	Route::delete('materials/{material}', 'CourseMaterialController@destroy')->name('instructor.materials.destroy');
});


/* ******************** Teller Route ******************** */
Route::group(['prefix' => 'tellers',  'middleware' => 'tellerMw'], function(){
	Route::get('/', 'TransactionController@getDashboard')->name('teller-dashboard');

	Route::get('edit-product/{id}', 'ProductController@productEdit')->name('edit-product');
	Route::get('edit-package/{id}', 'PackageController@edit')->name('edit-package');

	

	
	//Search Username in Generating Code
	Route::get('generate/users_search', 'ProductCodeController@search')
    ->name('api.users.search');
    
    Route::get('select-member', 'UserController@selectMembers')->name('select-member');
	
	
	// Member Registration
	Route::get('register', 'UserController@create');
	Route::post('register/insert','UserController@insert');
	Route::get('register/member-get-data','UserController@memberGetData');

/************************************ New Transaction ************************************/
    Route::prefix('new-transaction')->group(function () {
        Route::get('/', 'TransactionController@index');
        Route::get('/member', 'TransactionController@index');
        Route::get('/package/{id}', 'TransactionController@package');		
        Route::get('/non-member', 'TransactionController@index_non');
        Route::post('/products', 'ProductController@product_transaction')->name('product-transaction');
        Route::post('/packages', 'ProductController@package_transaction')->name('package-transaction');
        
        Route::get('/upgrade', 'TransactionController@upgrade_account')->name('newtransaction-upgrade');
        Route::post('/upgrade', 'TransactionController@upgrade_account')->name('newtransaction-upgrade-insert');
        Route::post('/insert', 'TransactionController@store')->name('new-transaction-insert');
		//Export Product Codes
		Route::get('/export/{id}', 'TransactionController@Export')->name('teller.code-export');
    });
	
	Route::get('transaction-receipt/{id}', 'TransactionController@transaction_receipt')->name('transaction-receipt');

/************************************ Members ************************************/
	Route::get('members/profile/{user_id}', 'UserController@members_profile');

/************************************ Order Management ************************************/
    
	Route::get('process-order', 'OrderManagementController@index')->name('order.process-order');
	
    Route::get('order-receipt/{sale}', 'OrderManagementController@order_receipt')->name('order.order-receipt');

    Route::get('view-receipt/{sale}', 'OrderManagementController@view_receipt')->name('order.view-receipt');

    Route::post('view-receipt/{sale}', 'OrderManagementController@email_receipt')->name('order.email-receipt');
	
	Route::get('record-sales', 'OrderManagementController@sales')->name('order.record-sales');

    Route::get('export-sales-data', 'OrderManagementController@export')->name('order.export-sales-data');

    Route::get('record-sales/{sale}', 'OrderManagementController@show')->name('order.show-sales');
	
	Route::get('override-sales', 'OrderManagementController@override');

    Route::post('override-sale/{sale}', 'OrderManagementController@override_sale')->name('order.override-sale');
	
	Route::get('void-transaction', 'OrderManagementController@void');

    Route::post('void-order/{sale}', 'OrderManagementController@void_order')->name('order.void-order');

	
	
	
	 //profile
	Route::get('profile', 'AdminProfileController@viewProfile')->name('profile');
	Route::post('update-profile', 'AdminProfileController@updateMemberProfile')->name('update-profile');
	Route::post('update-password', 'AdminProfileController@updateMemberPassword')->name('update-password');
	Route::post('update-picture', 'AdminProfileController@updateMemberPicture')->name('update-picture');
	Route::post('update-account', 'AdminProfileController@updateAccountProfile')->name('update-account');
});

Route::get('test-network-data', 'HomeController@getUserHomeData')->name('test-network-data');


Route::group(['prefix' => 'user',  'middleware' => 'userMw'], function(){
	//home routes
	Route::get('/', 'HomeController@index2')->name('home');
	Route::get('get-network-data', 'HomeController@getUserHomeData')->name('network-downlines');
	Route::get('get-my-network-count', 'HomeController@getMyNetworksCount')->name('get-my-network-count');
	Route::get('get-network-downlines/{position?}', 'HomeController@getUserDownlines');
	Route::get('get-adjustment-history', 'HomeController@getAdjustmentHistory')->name('get-adjustment-history');
	//geneology
	Route::get('get-geneo-data/{uid}', 'GeneologyController@getGeneoData')->name('get-geneo-data');
	Route::get('view-binary-list', 'GeneologyController@viewBinaryList')->name('view-binary-list');
	Route::get('view-binary-list-data/{offset}', 'GeneologyController@viewBinaryListDataUpdated')->name('view-binary-list-data');
	Route::get('view-binary-list-data-top/{offset}', 'GeneologyController@viewBinaryListTop')->name('view-binary-list-data-top');
	Route::get('binary-list/{offset}', 'GeneologyController@viewBinaryListData')->name('binary-list');
	Route::get('view-geneology/{user_id}', 'GeneologyController@viewGeneology')->name('view-geneology');
	Route::get('get-network-table', 'GeneologyController@getNetworkTableData')->name('get-network-table');
	//upgrade account
	Route::get('check-act-code/{code}', 'UpgradeAccountController@registerCheckCode')->name('check-act-code');
	Route::get('check-pin/{code}/{pin}', 'UpgradeAccountController@registerCheckPin')->name('check-pin');
	Route::post('member-upgrade', 'UpgradeAccountController@upgradeAccount')->name('member-upgrade');    
	Route::get('upgrade-account', 'UpgradeAccountController@viewUpgradeAccount')->name('upgrade-account');
	//announcement
	Route::get('announcement/{type}', 'MemberAnnouncementController@viewAnnouncement')->name('announcement');
	Route::get('load-more-announcement/{os}', 'MemberAnnouncementController@loadMoreAnnouncement')->name('load-more-announcement');
	Route::get('get-announcement-data/{id}', 'MemberAnnouncementController@getAnnouncementData')->name('get-announcement-data');
    
    
	//encashment
	Route::get('encashment', 'MemberEncashmentController@viewEncashment')->name('encashment');

	//Donations
	Route::get('donations', 'member\DonationController@index')->name('user.donations');
	Route::post('send-donation', 'member\DonationController@store')->name('user.donations.store');

	//Income
	Route::get('transfer-income', 'member\IncomeTransferController@index')->name('user.income-transfer');
	Route::get('transfer-income/select-members', 'UserController@selectMembers')->name('user.select-members');
	Route::get('get-total-income', 'member\IncomeTransferController@totalIncome')->name('user.get-total-income');
	Route::post('transfer-histories', 'member\IncomeTransferController@transferHistories')->name('user.get-transfer-histories');
	Route::post('send-income/{user}', 'member\IncomeTransferController@transferIncome')->name('user.income-transfer.store');

	//Social Funds Transfer
	Route::post('transfer-funds', 'TransferController@transferFunds')->name('transfer-funds');
	Route::get('validate-username/{username}', 'TransferController@validateUsername')->name('validate-username');
	Route::get('validate-user-id/{userId}', 'TransferController@validateUserId')->name('validate-user-id');
	Route::get('transfer-history', 'TransferController@getTransferHistory')->name('transfer-history');

	//Points
	Route::get('transfer-point', 'member\PointTransferController@index')->name('user.point-transfer');
	Route::get('get-total-points', 'member\PointTransferController@getTotalPoints')->name('user.get-total-points');
	Route::post('point-transfer-histories', 'member\PointTransferController@transferHistories')->name('user.get-point-transfer-histories');
	Route::post('send-point/{user}', 'member\PointTransferController@transferPoint')->name('user.point-transfer.store');

	//Advertisements
	Route::get('advertisements', 'member\AdvertisementController@index')->name('user.advertisements');
	Route::post('get-advertisements', 'member\AdvertisementController@getAdvetisements')->name('user.get-advertisements');
	Route::post('save-ads', 'member\AdvertisementController@store')->name('user.save-ads');
	Route::get('get-ads/{id}', 'member\AdvertisementController@edit')->name('user.get-ads');
	Route::post('update-ads', 'member\AdvertisementController@update')->name('user.update-ads');
	Route::post('advertisements/delete', 'member\AdvertisementController@destroy')->name('user.delete-ads');
    
    
	Route::get('weekly-income/{type}', 'IncomeController@getTotalWeeklyIncome')->name('weekly-encashment');
    
    //Encashment Maintenance
    /*Route::get('/encashment/view', function () {
        return view('errors/503');
    })->name('encashment');*/
    
    
	Route::get('e-wallet', 'MemberEncashmentController@viewEwallet')->name('e-wallet');
	Route::get('e-wallet-purchase/{id}', 'MemberEncashmentController@purchaseEwallet')->name('e-wallet-purchase');
	Route::post('request-encashment', 'MemberEncashmentController@requestEncashment')->name('request-encashment');
	//fifth encashment
	Route::get('fifth-pair-encashment', 'MemberFifthEncashmentController@viewEncashment')->name('fifth-pair-encashment');
	Route::post('fifth-pair-request-encashment', 'MemberFifthEncashmentController@requestEncashment')->name('fifth-pair-request-encashment');
    
	//profile
	Route::get('member-profile', 'MemberProfileController@viewProfile')->name('member-profile');
	Route::post('update-member-profile', 'MemberProfileController@updateMemberProfile')->name('update-member-profile');
	Route::post('update-member-password', 'MemberProfileController@updateMemberPassword')->name('update-member-password');
	Route::post('update-member-picture', 'MemberProfileController@updateMemberPicture')->name('update-member-picture');
	Route::post('update-member-account', 'MemberProfileController@updateAccountProfile')->name('update-member-account');
	
	//Payments
	Route::get('payments', 'PaymentUploadController@index')->name('user.payments');
	Route::post('payments/store', 'PaymentUploadController@store')->name('user.payments.store');
	Route::get('payments/download/{id}', 'PaymentUploadController@download')->name('user.payments.download');
	Route::delete('payments/{id}', 'PaymentUploadController@destroy')->name('user.payments.destroy');
	//
	Route::get('income-listing/{type}', 'IncomeController@viewIncome')->name('income-listing');
	Route::get('available-balance', 'IncomeController@getAvailBalance')->name('available-balance');
	Route::get('total-income', 'IncomeController@getTotalIncome')->name('total-income');
	Route::get('unilevel-sales', 'IncomeController@getUnilevelSales')->name('unilevel-sales');

	Route::get('affiliate-links/{type}', 'AffiliateController@viewAffiliate')->name('affiliate-links');
	Route::get('direct-referral/{type}', 'DirectReferralController@viewReferral')->name('direct-referral');

    //Messages/Inbox
    Route::get('messages', 'MemberConversationController@inbox')->name('user.messages.inbox');
    Route::get('messages/compose', 'MemberConversationController@compose')->name('user.messages.compose');
    Route::post('messages', 'MemberConversationController@store')->name('user.messages.store');
    Route::get('messages/{conversation}', 'MemberConversationController@show')->name('user.messages.show');
    Route::post('messages/{conversation}/reply', 'MemberConversationController@reply')->name('user.messages.reply');
    Route::get('messages/{attachment}/download', 'MemberConversationController@downloadAttachment')->name('user.messages.download');

    //Code Facility
	Route::get('codes-facility', 'CodesFacilityController@viewUserCodes')->name('codes-facility');
	Route::post('get-codes', 'CodesFacilityController@getCodes')->name('get-codes');
    Route::post('save-product-codes', 'CodesFacilityController@saveProductCodes')->name('save-product-codes'); //Add Product Codes

	 //Unilevel Code Facility
	 Route::get('unilevel-codes-facility', 'CodesFacilityController@unilevelUserCodes')->name('unilevel-codes-facility');
    
    //Redeem
    Route::prefix('redeem')->name('redeem.')->group(function () {
        Route::get('/', 'member\RedeemController@view')->name('list');
        Route::post('get-redeem-products', 'member\RedeemController@getProducts')->name('get-products');
        Route::post('get-redeemed-products', 'member\RedeemController@getRedeemedProducts')->name('get-redeemed');
		Route::post('get-redeemed-pv', 'member\RedeemController@getRedeemedPV')->name('get-redeemed-pv');
        Route::post('request', 'member\RedeemController@requestRedeem')->name('request');
        Route::get('/{id}', 'member\RedeemController@viewProductRedeem')->name('view-redeem');
    });
    
    Route::get('/change-user/{id}', 'AccountSwitcherController@changeUser')->name('change-user');
	Route::post('network-checker', 'HomeController@NetworkChecker')->name('network-checker');
	Route::get('network-checker-view', 'HomeController@NetworkCheckerView')->name('network-checker-view');

	//Products
	Route::prefix('products')->name('products.')->group(function () {
		Route::get('/', 'member\ProductController@index')->name('list');
    });
	
	Route::get('/cart', 'member\ProductController@cart')->name('cart');
	Route::get('/checkout','member\ProductController@checkout')->name('cart.checkout');
	
	Route::post('/cart/{product}', 'CartController@add')->name('cart.add');
	Route::post('/cart/{rowId}/update','CartController@update')->name('cart.cart.update');
	Route::get('/cart/{rowId}', 'CartController@remove')->name('cart.remove');
	Route::post('/payment', 'PaymentController@store')->name('cart.payment');

	// New Products Browse
	Route::get('browse-products', 'MemberProductController@browse')->name('member.products');
	Route::get('my-orders', 'MemberProductController@myOrders')->name('my-orders');
	Route::get('products-api/list', 'MemberProductController@getProducts')->name('api.products.list');
	Route::get('products-api/{id}', 'MemberProductController@getProduct')->name('api.products.detail');
	Route::get('api/my-orders', 'MemberProductController@getMyOrders')->name('api.my-orders');
	Route::post('submit-product', 'MemberProductController@submitProduct')->name('submit-product');
	Route::post('avail-product', 'MemberProductController@availProduct')->name('avail-product');
	
});

/* ******************** Instructor Route ******************** */
Route::group(['prefix' => 'instructor', 'middleware' => 'instructorMw'], function(){
    Route::get('/', 'Instructor\CourseController@index')->name('instructor.dashboard');
    Route::resource('courses', 'Instructor\CourseController', ['as' => 'instructor']);
});

Route::post('/e-walletProcess', 'PaymentController@ewalletProcess')->name('e-walletProcess');

//




//landing page
Route::name('landing.')->group(function () {
	Route::get('/','LandingPageController@home')->name('home');
	Route::get('/contact-us','LandingPageController@contact')->name('contact');

	Route::get('/legal-assistance','LandingPageController@legalAssistance')->name('legal-assistance');
	Route::get('/translation-service','LandingPageController@translationService')->name('translation-service');
	Route::get('/financial-assistance','LandingPageController@financialAssistance')->name('financial-assistance');
	
	Route::get('/benefit','LandingPageController@benefit')->name('benefit');
	
	Route::get('/recruitment','LandingPageController@recruitment')->name('recruitment');
	Route::get('/social-obligation','LandingPageController@socialObligation')->name('social-obligation');
	Route::get('/application','LandingPageController@application')->name('application');
	Route::get('/education','LandingPageController@education')->name('education');
	Route::get('/education/{course}','LandingPageController@courseDetails')->name('education.show');
	Route::post('/education/{course}/enroll','LandingPageController@enroll')->name('education.enroll');
	Route::post('/application/submit','ApplicationController@submitApplication')->name('application.submit');
	Route::get('/check-application-code/{code}','ApplicationController@checkApplicationCode')->name('application.check-code');
	
	// Route::get('/about','LandingPageController@about')->name('about');

	// Route::get('/announcements','LandingPageController@announcements')->name('announcements');
	// Route::get('/announcements/{slug}','LandingPageController@announcement')->name('announcements.page');

	// Route::get('/products','LandingPageController@products')->name('products');
	// Route::get('/advertisements','LandingPageController@advertisements')->name('advertisements');
	// Route::get('/advertisements/{slug}','LandingPageController@advertisement')->name('advertisement');
	
	// Route::post('contact-us-email','GuestController@emailContactUs')->name('contact-us-email');
	// Route::get('packages/{package}','LandingPageController@getPackage')->name('package');

	// Route::get('/get-currencies','LandingPageController@getCurrencies')->name('get-currencies');
	
});
