<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {

    /* For unauthorized users */
    Route::post('login', 'UserController@authenticate')->name('users.authenticate');
    Route::post('register', 'UserController@register')->name('users.register');
    Route::get('forgot-password/{email}', 'UserController@forgotPassword')->name('forgotPassword');
    Route::post('reset/process', 'UserController@setNewPassword')->name('setNewPassword');
    Route::get('users/current-user', 'UserController@currentUser')->name('users.currentUser');
    Route::get('users/formated-current-user', 'UserController@formatedCurrentUser')->name('users.formatedCurrentUser');


    /* For authorized users */
    Route::post('users/email/verify', 'UserController@verifyEmail')->name('users.verifyEmail');
    Route::get('users/email/resend', 'UserController@resendCode')->name('users.resendCode');
    Route::post('users/edit-profile', 'UserController@editProfile')->name('users.editProfile');

    /* For authorized users and verify */
    Route::group(['middleware' => ['auth:api', 'verified', 'hasUserInfo']], function () {

        /* Settings */
        Route::apiResource('settings', 'SettingController')->except('update', 'destroy');

        /* Users */
        Route::get('users/certified-users', 'UserController@getCertifiedUsers')->name('users.getCertifiedUsers');
        Route::post('users/change-avatar', 'UserController@changeAvatar')->name('users.changeAvatar');
        Route::post('users/change-password', 'UserController@changePassword')->name('users.changePassword');
        Route::apiResource('users', 'UserController')->except('store', 'destroy');

        /* Roles */
        Route::apiResource('roles', 'RoleController')->except('show', 'store', 'update', 'destroy');

        /* Nfts */
        Route::get('nfts/nfts-not-for-sale', 'NftController@getNftsNotForSale')->name('nfts.getNftsNotForSale');
        Route::get('nfts/nfts-for-sale', 'NftController@getNftsForSale')->name('nfts.getNftsForSale');
        Route::get('nfts/nfts-in-drop', 'NftController@getNftsInDrop')->name('nfts.getNftsInDrop');
        Route::get('nfts/all-nfts-of-all-users', 'NftController@allNftsOfAllUsers')->name('nfts.allNftsOfAllUsers');
        Route::get('nfts/by-user-id/{user_id}', 'NftController@allNftsByUserId')->name('nfts.allNftsByUserId');
        Route::get('nfts/send-as-gift/{nft}/{address}', 'NftController@sendNftAsGift')->name('nfts.sendNftAsGift');
        Route::post('nfts/put-for-sale', 'NftController@putForSale')->name('nfts.putForSale');
        Route::get('nfts/remove-from-sale/{nft}', 'NftController@removeFromSale')->name('nfts.removeFromSale');
        Route::post('nfts/buy/{nft}', 'NftController@buy')->name('nfts.buy');
        Route::apiResource('nfts', 'NftController')->except('update', 'destroy');

        /* Drops */
        Route::get('drops/by-user-id', 'DropController@allDropsByUser')->name('drops.allDropsByUser');
        Route::get('drops/get-highlited-drops', 'DropController@getHighlitedDrops')->name('drops.getHighlitedDrops');
        Route::post('drops/buy/{drop}', 'DropController@buy')->name('drops.buy');
        Route::apiResource('drops', 'DropController');

        /* Drop lines */
        Route::get('drop-lines/store-by-drop/{drop_id}', 'DropLineController@storeByDrop')->name('drop-line.storeByDrop');
        Route::get('drop-lines/my-time-to-start-buy-drop/{drop_id}', 'DropLineController@myTimeToStartBuyDrop')->name('drop-line.myTimeToStartBuyDrop');
        Route::get('drop-lines/my-time-to-buy-drop/{drop_id}', 'DropLineController@myTimeToBuyDrop')->name('drop-line.myTimeToBuyDrop');
        Route::get('drop-lines/destroy-by-drop/{drop_id}', 'DropLineController@destroyByDrop')->name('drop-line.destroyByDrop');

        /* Collections */
        Route::get('collections/collections-not-for-sale', 'CollectionController@getCollectionsNotForSale')->name('collections.getCollectionsNotForSale');
        Route::get('collections/collections-for-sale', 'CollectionController@getCollectionsForSale')->name('collections.getCollectionsForSale');
        Route::get('collections/collections-in-drop', 'CollectionController@getCollectionsInDrop')->name('collections.getCollectionsInDrop');
        Route::post('collections/show-by-tab/{collection_id}', 'CollectionController@showByTab')->name('collections.showByTab');
        Route::apiResource('collections', 'CollectionController')->except('update', 'destroy');

        /* Transactions history */
        Route::get('transactions-history/by-user-id/{user_id}', 'TransactionHistoryController@getByUserId')->name('transactions-history.getByUserId');
        Route::apiResource('transactions-history', 'TransactionHistoryController')->except('index', 'store', 'update');
    });
});
