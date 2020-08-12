<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index');

Route::get('/export_report', 'ExcelController@exportReport');
Route::get('/test_view', 'ExcelController@testView');
Route::get('pdf_report/{type}/{date_report}', 'PdfController@report');
Route::get('pdf_accrued_report/{type}/{date_report}', 'PdfController@accrued_report');
Route::get('pdf_report_insurance/{type}', 'PdfController@report_insurance');
Route::get('pdf_plan/{id}', 'PdfController@plan');

Route::get('operation_index', 'Operation\OperationController@index');
Route::get('operation_create/{type}', 'Operation\OperationController@create')->where('type', '[PROPIO,FINANCIAL]+');
Route::get('operation_store', 'Operation\OperationController@store');
Route::get('operation_edit/{id}', 'Operation\OperationController@edit');
Route::get('operation_update/{id}', 'Operation\OperationController@update');
Route::get('operation_show/{id}', 'Operation\OperationController@show');
Route::get('operation_delete/{id}', 'Operation\OperationController@delete');
Route::get('operation_destroy/{id}', 'Operation\OperationController@destroy');

Route::get('operation_expired', 'Operation\OperationController@expired');
Route::get('operation_report/{type}', 'Operation\OperationController@report')->where('type', '[PROPIO,FINANCIAL]+');
Route::get('accrued_report/{type}', 'Operation\OperationController@accrued_report');

//Route::get('client_find', 'Operation\OperationController@find');
Route::get('product_find', 'Operation\OperationController@find_product');
//Route::get('operation_product_add/{id}', 'Operation\OperationController@product_add');
Route::get('operation_plan_generate/{id}', 'Operation\OperationController@generate_plan');
Route::get('operation_plan/{id}', 'Operation\OperationController@plan');
Route::get('operation_payment/{id}', 'Operation\OperationController@payment');
Route::get('operation_amort/{id}', 'Operation\OperationController@amort');
Route::post('operation_amort_prev/{id}', 'Operation\OperationController@prev_amort');
Route::get('operation_amort_mora/{id}', 'Operation\OperationController@mora_amort');
Route::post('operation_amort_mora_pay/{id}', 'Operation\OperationController@mora_pay_amort');

Route::get('client_index', 'Client\ClientController@index');
Route::get('client_create/{lp}', 'Client\ClientController@create')->where('lp', '[NATURAL,JURIDICA]+');
Route::get('client_store', 'Client\ClientController@store');
Route::get('client_edit/{id}', 'Client\ClientController@edit');
Route::get('client_update/{id}', 'Client\ClientController@update');
Route::get('client_show/{id}', 'Client\ClientController@show');
Route::get('client_delete/{id}', 'Client\ClientController@delete');
Route::get('client_destroy/{id}', 'Client\ClientController@destroy');

Route::get('product_index', 'Product\ProductController@index');
Route::get('product_create', 'Product\ProductController@create');
Route::get('product_store', 'Product\ProductController@store');
Route::get('product_edit/{id}', 'Product\ProductController@edit');
Route::get('product_update/{id}', 'Product\ProductController@update');
Route::get('product_show/{id}', 'Product\ProductController@show');
Route::get('product_delete/{id}', 'Product\ProductController@delete');
Route::get('product_destroy/{id}', 'Product\ProductController@destroy');

Route::get('dealer_index', 'Classif\DealerController@index');
Route::get('dealer_create', 'Classif\DealerController@create');
Route::get('dealer_store', 'Classif\DealerController@store');
Route::get('dealer_edit/{id}', 'Classif\DealerController@edit');
Route::get('dealer_update/{id}', 'Classif\DealerController@update');
Route::get('dealer_show/{id}', 'Classif\DealerController@show');
Route::get('dealer_delete/{id}', 'Classif\DealerController@delete');
Route::get('dealer_destroy/{id}', 'Classif\DealerController@destroy');

Route::get('insurance_register/{id}', 'Insurance\InsuranceController@register');
Route::get('insurance_update', 'Insurance\InsuranceController@update');
Route::get('insurance_expired', 'Insurance\InsuranceController@expired');
Route::get('insurance_report/{type}', 'Insurance\InsuranceController@report');

//Route::get('process_recovery_arrears', 'Process\ProcessController@recovery_arrears');
Route::get('process_rescission', 'Process\ProcessController@rescission');
Route::get('apply_rescission/{id}', 'Process\ProcessController@apply_rescission');
Route::post('apply_rescission_prev/{id}', 'Process\ProcessController@apply_rescission_prev');
Route::get('process_close_period', 'Process\ProcessController@close_period');
Route::get('period_close/{id}', 'Process\ProcessController@period_close');
Route::get('process_close_gestion', 'Process\ProcessController@close_gestion');
Route::get('gestion_close/{gestion}', 'Process\ProcessController@gestion_close');
