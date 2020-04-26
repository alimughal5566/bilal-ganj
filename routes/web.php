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

use App\Utills\consts\UserType;

Route::group(['BG'], function () {

    //*** Public routes start ***//
    Route::group(['public'], function () {

        //*** HomeController routes start ***//
        Route::group(['HomeController'], function () {

            Route::group(['middleware' => ['checkPublicRoutes']], function () {

                Route::get('/', 'HomeController@index')->name('index');
                Route::get('/shop', 'HomeController@shop')->name('shop');
                Route::get('/select-cat/{id}', 'HomeController@selectCat')->name('selectCat');
                Route::get('/about', 'HomeController@aboutUs')->name('aboutUs');
                Route::get('/contact', 'HomeController@contactUs')->name('contactUs');
                Route::post('/contactInfo', 'UserController@saveContactUsInfo')->name('saveContactUsInfo');

            });
            Route::get('/product-detail/{id?}', 'HomeController@productDetail')->name('productDetail');
        });
        //*** HomeController Routes end ***//
        //*** UserController Routes start ***//
        Route::group(['UserController'], function () {

            Route::group(['middleware' => ['checkPublicRoutes']], function () {
                Route::get('/redirect/{provider?}', 'Auth\LoginController@redirectToProvider')->name('redirect');
                Route::get('/callback/{provider?}', 'Auth\LoginController@handleProviderCallback')->name('callback');
                Route::get('/login', 'UserController@login')->name('login');
                Route::get('/sendEmailDone/{email}', 'UserController@sendEmailDone')->name('sendEmailDone');
                Route::get('/register-as-vendor', 'UserController@registerAsVendor')->name('registerAsVendor');
                Route::post('/auth-user', 'UserController@authUser')->name('authUser');
                Route::post('/saveVendor', 'UserController@saveVendor')->name('saveVendor');
                Route::post('/register-as-user', 'UserController@registerAsUser')->name('registerAsUser');
                Route::post('/resetPass', 'UserController@forgetPass')->name('resetPass');
                Route::get('/forget-password-view', 'UserController@forgetPasswordView')->name('forgetPasswordView');
                Route::post('/forget-password', 'UserController@forgetPassword')->name('forgetPassword');
                Route::get('/forget-password-done-view/{email}', 'UserController@forgetPasswordDoneView')->name('forgetPasswordDoneView');
                Route::post('/forget-password-done', 'UserController@forgetPasswordDone')->name('forgetPasswordDone');

            });

            Route::get('/logout', 'UserController@logout')->name('logout');
            Route::get('/category-select', 'ProductController@categorySelect')->name('categorySelect');
            Route::get('/sort-products','ProductController@sortProducts')->name('sortProducts');
            Route::post('/fetch-product-slider', 'ProductController@fetchProductSlider')->name('fetchProductSlider');
            Route::post('/fetch-product-checkbox', 'ProductController@fetchProductCheckbox')->name('fetchProductCheckbox');
            Route::post('/fetch-product-checkbox-vendor', 'ProductController@fetchProductCheckboxVendor')->name('fetchProductCheckboxVendor');
            Route::get('/mark-as-read', 'UserController@markAsRead')->name('markAsRead');
            Route::get('/search-products', 'UserController@searchProducts')->name('searchProducts');
            Route::get('/search-products-list', 'UserController@searchProductsList')->name('searchProductsList');
            Route::get('/get-user-chart-data','ChartDataController@getMonthlyUserData')->name('getUserChartData');

        });
        //*** UserController Routes end ***//
    });
    //*** Public routes end ***//

    //*** Private routes start ***//
    Route::group(['private'], function () {

        /* Tasks Those should be Done by Only Admin Start Here */
        Route::group(['middleware' => ['userType:' . UserType::ADMIN]], function () {

            Route::get('/admin-profile', function () {
                return view('admin.admin-profile');
            })->name('adminProfile');

            Route::get('/change-admin-passwordView', function () {
                return view('admin.change-password');
            })->name('changeAdminPassword');
            Route::post('/saveAgent', 'AgentController@save')->name('saveAgent');
            Route::post('/save-rider', 'RiderController@saveRider')->name('saveRider');
            Route::get('/editAgentForm/{id}', 'AgentController@editForm')->name('editAgentForm');
            Route::get('/edit-rider-form/{id}', 'RiderController@editRiderForm')->name('editRiderForm');
            Route::post('/editAgent/{id}', 'AgentController@edit')->name('editAgent');
            Route::post('/edit-rider/{id}', 'RiderController@editRider')->name('editRider');
            Route::post('/edit-admin-profile', 'AdminAccountController@editAdminProfile')->name('editAdminProfile');
            Route::post('/change-admin-password', 'AdminAccountController@adminChangePassword')->name('adminChangePassword');
            Route::get('/displayAdmin', 'AdminController@display')->name('displayAdmin');
            Route::get('/allAgents', 'AdminController@view')->name('agents');
            Route::get('/riders', 'AdminController@viewRiders')->name('viewRiders');
            Route::get('/deleteAgent/{id}', 'AdminController@deleteAgent')->name('deleteAgent');
            Route::get('/deleteRider/{id}', 'RiderController@deleteRider')->name('deleteRider');
            Route::get('/fetch-agent-vender', 'AdminController@fetchAgentVender')->name('fetchAgentVender');
            Route::post('/assign-agent-vender', 'AdminController@assignAgentVender')->name('assignAgentVender');
            Route::get('/unassign-agent-vender/{id}', 'AdminController@unassignAgentVender')->name('unassignAgentVender');
            Route::get('/showVendorView', 'AdminController@fetchVendor')->name('showVendorView');
            Route::get('/showUserView', 'AdminController@fetchUser')->name('showUserView');
            Route::get('/creatAgent', 'AdminController@creatFrom')->name('creatAgent');
            Route::get('/add-rider', 'AdminController@addRiderView')->name('addRiderView');
            Route::get('/response-to-notification/{notification?}', 'AdminController@responseToNotification')->name('responseToNotification');
            Route::get('/change-status/{id}', 'AdminController@changeStatus')->name('changeStatus');
            Route::get('/statusActive', 'AdminController@statusActive')->name('statusActive');
            Route::get('/delete-vendor', 'AdminController@deleteVendor')->name('deleteVendor');
            Route::get('/productList', 'AdminController@productList')->name('productList');
            Route::get('/comments-on-product', 'FeedbackController@commentOnProduct')->name('commentOnProduct');
            Route::get('/undo-product/{id}', 'ProductController@undoProduct')->name('undoProduct');
            Route::get('/delete-comment/{id}','FeedbackController@deleteComment')->name('deleteComment');
            Route::get('/comment-list','FeedbackController@commentList')->name('commentList');
            Route::get('/addsDetailView','AdvertisementController@adDetailView')->name('adDetailView');
            Route::post('/saveAdDetail','AdvertisementController@saveAdDetail')->name('saveAdDetail');
            Route::get('/order-list', 'OrderController@orderList')->name('orderList');
            Route::get('/view-order-details/{id?}', 'OrderController@adminOrderDetails')->name('adminOrderDetails');
            Route::get('/fetch-ad-detail','AdminController@fetchAdDetail')->name('fetchAdDetail');
            Route::get('approveAd/{id}','AdminController@approveAd')->name('approveAd');
            Route::get('rejectAd/{id}','AdminController@rejectAd')->name('rejectAd');
        });
        /* Tasks Those should be Done by Only Admin End Here */

        /* Tasks Those should be Done by Only User Start Here */
        Route::group(['middleware' => ['userType:' . UserType::USER]], function () {

//            Route::get('/my-account', function () {
//                return view('user-account.account');
//            })->name('userAccount');
            Route::get('/user-notification/{notification?}', 'UserController@userNotification')->name('userNotification');
            Route::get('/my-account','UserAccountController@userAccount')->name('userAccount');
            Route::get('/order-details/{id}','OrderController@orderDetails')->name('orderDetails');
            Route::post('/edit-profile', 'UserAccountController@editProfile')->name('editProfile');
            Route::post('/change-password-user', 'UserAccountController@changePassword')->name('changePassword');
            Route::get('/change-password-view', function () {
                return view('user-account.change-password');
            })->name('changePasswordView');
//            Route::post('/add-to-cart', 'CartController@addToCart')->name('addToCart');
            Route::get('/add-to-cart', 'CartController@addToCart')->name('addToCart');
            Route::get('/delete-cart', 'CartController@deleteCart')->name('deleteCart');
            Route::get('/delete-cart-item', 'CartController@deleteCartItem')->name('deleteCartItem');
            Route::get('/update-cart', 'CartController@updateCart')->name('updateCart');
            Route::get('/view-on-map/{order_id}', 'RiderController@viewOnMap')->name('viewOnMap');
            Route::get('/saveProduct-wishlist', 'WishListController@saveWish')->name('saveProduct-wishlist');
            Route::get('/delete-wish', 'WishListController@deleteWish')->name('delete-wish');
            Route::get('/do-order/{total?}/{orderAmount?}', 'OrderController@doOrder')->name('doOrder');
            Route::get('stripe/{total?}', 'StripePaymentController@stripe')->name('stripe');
            Route::post('stripe', 'StripePaymentController@stripePost')->name('stripePost');
            Route::get('/get-location', 'RiderController@getLocation')->name('getLocation');
            Route::post('/place-order', 'OrderController@placeOrder')->name('placeOrder');
        });
        /* Tasks Those should be Done by Only User End Here */

        /* Tasks Those should be Done by Only Auth user Start Here */
        Route::group(['middleware' => ['customAuth:' . UserType::USER]], function () {
            Route::get('/wishlistView/{id?}', 'WishListController@wishlistView')->name('wishlistView');
//            Route::get('/cart', 'HomeController@cart')->name('cart');
            Route::get('/cart', 'CartController@getCart')->name('cart');

        });
        /* Tasks Those should be Done by Only Auth user End Here */

        /* Tasks Those should be Done by Only Rider Start Here */
        Route::group(['middleware' => ['userType:' . UserType::RIDER]], function () {
            Route::get('/rider-panel', 'RiderController@riderPanel')->name('riderPanel');
            Route::get('/rider-notification/{notification?}', 'RiderController@riderNotification')->name('riderNotification');
            Route::get('/edit-profile/{user}', 'RiderController@riderEditProfile')->name('riderEditProfile');
            Route::post('/edited-profile', 'RiderController@riderEditedProfile')->name('riderEditedProfile');
            Route::get('/change-password', 'RiderController@riderChangePassword')->name('riderChangePassword');
            Route::post('/changed-password', 'RiderController@riderChangedPassword')->name('riderChangedPassword');
            Route::get('/schedule-rides', 'RiderController@scheduleRides')->name('scheduleRides');
            Route::get('/tracking-view/{ride_id}/{order_id}/{flag?}', 'RiderController@trackRiderView')->name('trackRiderView');
            Route::post('/tracking', 'RiderController@trackRider')->name('trackRider');
            Route::get('/update-rider-location', 'RiderController@updateRiderLocation')->name('updateRiderLocation');
            Route::get('/ride-completed/{id}', 'RiderController@rideCompleted')->name('rideCompleted');
            Route::get('/ride-history', 'RiderController@rideHistory')->name('rideHistory');
            Route::get('/save-start-time', 'RiderController@saveStartTime')->name('saveStartTime');
        });
        /* Tasks Those should be Done by Only Rider End Here */

        /* Tasks Those should be Done by Only Agent Start Here */
        Route::group(['middleware' => ['userType:' . UserType::AGENT]], function () {


            Route::get('/agent-panel', 'AgentController@agentPanel')->name('agentPanel');
            Route::get('/agent-account', function () {
                return view('agent.account');
            })->name('agentAccount');
            Route::get('/addCategoryView', 'AgentController@addCategoryView')->name('addCategoryView');
            Route::post('/addCategory', 'AgentController@addCategory')->name('addCategory');
            Route::get('/agent-notification/{notification?}', 'AgentController@agentNotification')->name('agentNotification');
            Route::get('/vendor-request', 'AgentController@vendorRequest')->name('vendorRequest');
            Route::get('/add-product-view/{id?}', 'ProductController@addProductView')->name('addProductView');
            Route::post('/add-product', 'ProductController@addProduct')->name('addProduct');
            Route::post('/fetch-dependent', 'ProductController@fetchDependent')->name('fetchDependent');
            Route::get('/edit-product/{id}/{user_id}', 'ProductController@editProduct')->name('editProduct');
            Route::post('/edit-product-save', 'ProductController@editProductSave')->name('editProductSave');
            Route::get('/post-ads/{id}/{type_id}', 'AdvertisementController@postAdsView')->name('postAds');
            Route::post('/save-ads', 'AdvertisementController@saveAds')->name('saveAds');
            Route::get('/agent-remarks/{id}', 'AgentController@agentRemarks')->name('agentRemarks');
            Route::get('/advertise-index/{id}','AdvertisementController@addsIndex')->name('addsIndex');
        });
        /* Tasks Those should be Done by Only Agent End Here */

        /* Tasks Those should be Done by Only Vendor Start Here */
        Route::group(['middleware' => ['userType:' . UserType::VENDOR]], function () {

            Route::get('/vendor-password', 'BgShopController@vendorPassword')->name('vendorPassword');
            Route::post('/edit-vendor-password', 'BgShopAccountController@editVendorPassword')->name('editVendorPassword');
            Route::get('/response-to-feedback/{notification?}', 'BgShopController@responseToFeedback')->name('responseToFeedback');
            Route::post('/edit-vendor-profile', 'BgShopAccountController@editVendorProfile')->name('editVendorProfile');
            Route::get('/buy-credits-view/{id}', 'CreditController@buyCreditsView')->name('buyCreditsView');
            Route::post('/get-Credit/{id}', 'CreditController@getCredit')->name('getCredit');

        });
        /* Tasks Those should be Done by Only Vendor End Here */

        /* Tasks Those should be Done by both, Vendor and Agent Start Here */
        Route::group(['middleware' => ['userType:' . UserType::VENDOR . ',' . UserType::AGENT]], function () {
            Route::get('/viewProducts/{id}', 'BgShopController@viewProducts')->name('viewProducts');
            Route::get('/vendor-panel/{id?}', 'BgShopController@vendorPanel')->name('vendorPanel');
            Route::get('/credits-History/{id}', 'CreditController@creditsView')->name('creditsView');
        });
        /* Tasks Those should be Done by both, Vendor and Agent End Here */

        /* Tasks Those should be Done by both, Admin and Agent Start Here */
        Route::group(['middleware' => ['userType:' . UserType::ADMIN . ',' . UserType::AGENT]], function () {
            Route::get('/delete-product/{id}', 'ProductController@deleteProduct')->name('deleteProduct');
            Route::post('/verify-location', 'AgentController@verifyLocation')->name('verifyLocation');
        });
        /* Tasks Those should be Done by both, Admin and Agent End Here */

        /* Tasks Those should be Done by both, User and Agent Start Here */
        Route::group(['middleware' => ['userType:' . UserType::USER . ',' . UserType::AGENT]], function () {



        });
        /* Tasks Those should be Done by both, User and Agent End Here */

        /* Tasks Those should be Done by both, User and Vendor Start Here */
        Route::group(['middleware' => ['userType:' . UserType::USER . ',' . UserType::VENDOR]], function () {

            Route::post('/add-feedback', 'FeedbackController@addFeedback')->name('addFeedback');
            Route::post('/update-feedback','FeedbackController@updateFeedback')->name('updateFeedback');
            Route::get('/remove-feedback/{id}','FeedbackController@removeFeedback')->name('removeFeedback');

        });
        /* Tasks Those should be Done by both, User and Vendor End Here */

    });
    //*** Private routes end ***//
    Route::get('ebaystore/{ebay}',['as'=>'product.details','uses'=>'EbayController@productDetail']);
    Route::post('ebaystoreadd','EbayController@addToStore')->name('ebaystoreadd');

    Route :: get('ebay', 'EbayController@view')->name('ebayview');

});



