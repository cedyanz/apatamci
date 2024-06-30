<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\LocationController;

Route::get('/getAllProducts', [ProductController::class, 'index']); 
Route::post('/createProduct', [ProductController::class, 'store']); 
Route::get('/searchProduct/{name}', [ProductController::class, 'search']); 
Route::get('editProduct/{id}/edit',[ProductController::class, 'edit']); 
Route::put('updateProduct/{id}',[ProductController::class, 'update']); 
Route::delete('deleteProduct/{id}/delete',[ProductController::class, 'destroy']); 



Route::get('/getAllUsers', [UserController::class, 'index']);
Route::post('/createUser', [UserController::class, 'store']);
Route::get('/getUser/{id}', [UserController::class, 'show']);
Route::put('/updateUser/{id}', [UserController::class, 'update']);
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);



Route::get('/getAllProperties', [PropertyController::class, 'index']);
Route::post('/createProperty', [PropertyController::class, 'store']);
Route::get('/getProperty/{id}', [PropertyController::class, 'show']);
Route::put('/updateProperty/{id}', [PropertyController::class, 'update']);
Route::delete('/deleteProperty/{id}', [PropertyController::class, 'destroy']);


Route::get('/getAllBookings', [BookingController::class, 'index']);
Route::post('/createBooking', [BookingController::class, 'store']);
Route::get('/getBooking/{id}', [BookingController::class, 'show']);
Route::put('/updateBooking/{id}', [BookingController::class, 'update']);
Route::delete('/deleteBooking/{id}', [BookingController::class, 'destroy']);



Route::get('/getAllReviews', [ReviewController::class, 'index']);
Route::post('/createReview', [ReviewController::class, 'store']);
Route::get('/getReview/{id}', [ReviewController::class, 'show']);
Route::put('/updateReview/{id}', [ReviewController::class, 'update']);
Route::delete('/deleteReview/{id}', [ReviewController::class, 'destroy']);


Route::get('/getAllImages', [ImageController::class, 'index']);
Route::post('/uploadImage', [ImageController::class, 'store']);
Route::get('/getImage/{id}', [ImageController::class, 'show']);
Route::put('/updateImage/{id}', [ImageController::class, 'update']);
Route::delete('/deleteImage/{id}', [ImageController::class, 'destroy']);


Route::get('/getAllPayments', [PaymentController::class, 'index']);
Route::post('/createPayment', [PaymentController::class, 'store']);
Route::get('/getPayment/{id}', [PaymentController::class, 'show']);
Route::put('/updatePayment/{id}', [PaymentController::class, 'update']);
Route::delete('/deletePayment/{id}', [PaymentController::class, 'destroy']);


Route::get('/getAllMessages', [MessageController::class, 'index']);
Route::post('/sendMessage', [MessageController::class, 'store']);
Route::get('/getMessage/{id}', [MessageController::class, 'show']);
Route::delete('/deleteMessage/{id}', [MessageController::class, 'destroy']);


Route::get('/getAllWishlists', [WishlistController::class, 'index']);
Route::post('/createWishlist', [WishlistController::class, 'store']);
Route::get('/getWishlist/{id}', [WishlistController::class, 'show']);
Route::delete('/deleteWishlist/{id}', [WishlistController::class, 'destroy']);


Route::get('/getAllLocations', [LocationController::class, 'index']);
Route::post('/createLocation', [LocationController::class, 'store']);
Route::get('/getLocation/{id}', [LocationController::class, 'show']);
Route::put('/updateLocation/{id}', [LocationController::class, 'update']);
Route::delete('/deleteLocation/{id}', [LocationController::class, 'destroy']);


