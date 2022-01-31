<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::group(['middleware' => ['auth','check_branch']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/retentions', 'Retention\RetentionController@index');

    Route::post('/user/to/branch', 'Branch\UserToBranchController@store');
    Route::post('/user/to/branch/update/{branch}', 'Branch\UserToBranchController@update');
    Route::post('/user/to/branch/register', 'Branch\UserToBranchController@register_user');
    Route::post('/user/to/branch/merge/{branch}', 'Branch\UserToBranchController@merge_user');
    Route::post('user/to/branch/manage/usertobranch/{usertobranch}', 'Branch\UserToBranchController@manage');
    
    Route::get('/sc/search_report', 'PurchaseOrder\PurchaseOrderController@search_report_sc');
    Route::get('/project/address/{project}', 'PurchaseOrder\PurchaseOrderController@sertAdd');
    
    Route::get('/sale/quotations', 'Sale\QuotationController@index');
    Route::get('/sale/quotation/create', 'Sale\QuotationController@create');
    Route::post('/sale/quotation', 'Sale\QuotationController@store');
    Route::get('/sale/quotation/{quotation}/show', 'Sale\QuotationController@show');
    Route::get('/sale/quotation/{quotation}/print', 'Sale\QuotationController@print');
    Route::get('/sale/quotation/{quotation}/edit', 'Sale\QuotationController@edit');
    Route::post('/sale/quotation/{quotation}', 'Sale\QuotationController@update');
    Route::post('/sale/quotation/{quotation}/cancel', 'Sale\QuotationController@cancel');
    Route::post('/sale/quotation/{quotation}/project', 'Sale\QuotationController@project');

    Route::get('/ask-price', 'AskPrice\AskPriceController@index');
    Route::get('/ask-price/expired', 'AskPrice\AskPriceController@expired');
    Route::get('/ap/print/{ap}/{supplier}', 'AskPrice\AskPriceController@print');
    Route::get('/ap/show/{ap}', 'AskPrice\AskPriceController@show');
    Route::get('/ask-price/create', 'AskPrice\AskPriceController@create');
    Route::post('/ask-price/create', 'AskPrice\AskPriceController@store');
    
    Route::get('/invoice/cancel/{invoice}', 'Project\InvoiceController@cancel');

    Route::post('/invoice-ap/create', 'Invoice\InvoiceApController@store');
    Route::post('/invoice-approve', 'Invoice\InvoiceApController@approve');
    Route::post('/invoice-reject', 'Invoice\InvoiceApController@reject_store');
    Route::get('/invoice-ap/create', 'Invoice\InvoiceApController@create');
    Route::get('/invoice-ap', 'Invoice\InvoiceApController@index');
    Route::get('/invoice-ap/approve', 'Invoice\InvoiceApController@all_approve');
    Route::get('/invoice-ap/reject', 'Invoice\InvoiceApController@all_reject');
    Route::get('/invoice-ap/finish', 'Invoice\InvoiceApController@finish');
    Route::get('/getReceive', 'Invoice\InvoiceApController@getReceive');
    Route::get('/invoice-ap/show/{invoice}', 'Invoice\InvoiceApController@show');
    Route::get('/invoice-ap/report', 'Invoice\InvoiceApController@report');
    Route::get('/invoice-ap/show/{invoice}/print', 'Invoice\InvoiceApController@print');
    
    Route::post('/receive/delete', 'Receive\ReceiveController@receive_delet');
    Route::post('/receive', 'Receive\ReceiveController@store');
    Route::post('/receive/close', 'Receive\ReceiveController@close');
    Route::get('/receive', 'Receive\ReceiveController@index');
    Route::get('/receive/finish', 'Receive\ReceiveController@finish');
    Route::get('/receive/close', 'Receive\ReceiveController@all_close');
    Route::get('/receive/selelct-type', 'Receive\ReceiveController@select_type');
    Route::get('/receive/select/{receive}', 'Receive\ReceiveController@selected');
    Route::get('/receive/po/show/{po}', 'Receive\ReceiveController@po_show');
    Route::get('/receive/po/{po}/{type}', 'Receive\ReceiveController@receive');
    Route::get('/receive/po/close/{po}/{type}', 'Receive\ReceiveController@receive_close');
    Route::get('/revice/show/{receive}', 'Receive\ReceiveController@receive_show');
    Route::get('/receive-waiting-approve/show/{receive}', 'Receive\ReceiveController@receive_waiting_approve');
    Route::get('/receive/waiting/PAD', 'Receive\ReceiveController@waiting_approvePAD');
    Route::get('/receive/waiting/RR', 'Receive\ReceiveController@waiting_approveRR');
    Route::get('/receive/waiting/RS', 'Receive\ReceiveController@waiting_approveRS');
    Route::post('/receive-approve', 'Receive\ReceiveController@waiting_approve_store');
    Route::post('/receive-reject', 'Receive\ReceiveController@receive_reject');
    Route::get('/receive/approve', 'Receive\ReceiveController@all_approve');
    Route::get('/receive/reject', 'Receive\ReceiveController@all_reject');
    Route::get('/receive/update/{receive}', 'Receive\ReceiveController@edit');
    Route::get('/receive/approve/update/{receive}', 'Receive\ReceiveController@approve_edit');
    Route::post('/receive/update', 'Receive\ReceiveController@update');
    Route::post('/receive/approve/update', 'Receive\ReceiveController@approve_update');
    Route::get('/receive/delete/file/{receive_file}', 'Receive\ReceiveController@receive_delete_file');

    Route::get('/get/receive/PAD/count', 'Receive\ReceiveController@receive_countPAD');
    Route::get('/get/receive/RR/count', 'Receive\ReceiveController@receive_countRR');
    Route::get('/get/receive/RS/count', 'Receive\ReceiveController@receive_countRS');

    Route::get('/receive/report/{type}', 'Receive\ReceiveController@report');
    Route::get('/receive-waiting-approve/show/{receive}/print', 'Receive\ReceiveController@print');

    Route::get('/wht/edit/{wht}', 'Wht\WhtController@edit');
    Route::get('/wht/print/{wht}', 'Wht\WhtController@print');
    Route::get('/wht/finish', 'Wht\WhtController@finish');
    Route::get('/wht/payment/finish', 'Wht\WhtController@payment_finish');
    Route::get('/wht/reject', 'Wht\WhtController@reject');
    Route::get('/wht/group', 'Wht\WhtController@wht_group');
    Route::post('/wht/group', 'Wht\WhtController@wht_group_store');
    Route::post('/wht/group/update', 'Wht\WhtController@update');
    Route::get('/wht', 'Wht\WhtController@index');
    Route::get('/wht/create', 'Wht\WhtController@create');
    Route::get('/wht/show/{wht}', 'Wht\WhtController@show');
    Route::post('/wht/create', 'Wht\WhtController@store');
    Route::get('/wht/report', 'Wht\WhtController@report');
    Route::get('/wht/report/print', 'Wht\WhtController@print_report');
    Route::post('/wht/update/{wht}', 'Wht\WhtController@edit_store');
    Route::post('/delete/wht/{wht}', 'Wht\WhtController@delete');

    Route::post('/get/group-cost', 'PurchaseOrder\PurchaseOrderController@group_cost');
    Route::post('/get/group-cost/search', 'PurchaseOrder\PurchaseOrderController@allocate_search');
    Route::get('/po/allocate/edit/{polist}', 'PurchaseOrder\PurchaseOrderController@allocate_edit');
    Route::post('/allocate/update', 'Allocate\AllocateController@update');
    
    Route::post('/allocate', 'Allocate\AllocateController@store');
    Route::get('/new-allocate', 'Allocate\AllocateController@new_allocate_index');
    Route::post('/new-allocate', 'Allocate\AllocateController@new_store');
    Route::post('/cut_project_cost', 'Allocate\AllocateController@cut_project_cost');
    Route::post('/nr-allocate', 'Allocate\AllocateController@nr_store');
    Route::post('/allocate/update', 'Allocate\AllocateController@update');
    Route::post('/nr-allocate/update', 'Allocate\AllocateController@nr_update');

    Route::get('/sc', 'PurchaseOrder\PurchaseOrderController@index_sc');
    Route::get('/sc/approves', 'PurchaseOrder\PurchaseOrderController@approves_sc');
    Route::get('/sc/cancels', 'PurchaseOrder\PurchaseOrderController@cancels_sc');

    Route::get('/po/approves', 'PurchaseOrder\PurchaseOrderController@approves');
    Route::post('/po/create', 'PurchaseOrder\PurchaseOrderController@store');
    Route::get('/po/create/{type}', 'PurchaseOrder\PurchaseOrderController@create');
    Route::get('/po', 'PurchaseOrder\PurchaseOrderController@index');
    Route::get('/po/show/{po}', 'PurchaseOrder\PurchaseOrderController@show');
    Route::get('/po/print/{po}', 'PurchaseOrder\PurchaseOrderController@print');
    Route::post('/po/approve/{po}', 'PurchaseOrder\PurchaseOrderController@approve');
    Route::post('/po/cancel/{po}', 'PurchaseOrder\PurchaseOrderController@cancel');
    Route::get('/po/cancels', 'PurchaseOrder\PurchaseOrderController@cancels');
    Route::get('/po/search_report', 'PurchaseOrder\PurchaseOrderController@search_report');

    Route::get('/po/copy/{po}', 'PurchaseOrder\PurchaseOrderController@copy');
    Route::get('/po/edit/{po}', 'PurchaseOrder\PurchaseOrderController@edit');
    Route::get('/po/cancle/{po}', 'PurchaseOrder\PurchaseOrderController@cancle');
    Route::post('/po/update', 'PurchaseOrder\PurchaseOrderController@update');

    Route::get('/getContract', 'Customer\SupplierContractController@getContract');
    Route::get('/getSupplier', 'Customer\SupplierContractController@getSupplier');
    Route::get('/add-contract/{supplier}', 'Customer\SupplierContractController@index');
    Route::post('/add/contract/{supplier}', 'Customer\SupplierContractController@store');
    Route::post('/edit/contract/{contract}', 'Customer\SupplierContractController@edit');

    Route::get('/project/detail/budget/{project}/create', 'Project\BudgetController@addcost');
    Route::get('/project/detail/budget/{project}', 'Project\BudgetController@index');
    Route::post('/project/detail/budget/{project}', 'Project\BudgetController@addcost_store');
    Route::get('/project/detail/budget/{project}/edit', 'Project\BudgetController@edit');
    Route::post('/project/detail/budget/{project}/update', 'Project\BudgetController@update');

    Route::get('/receipt-ar/finish', 'Project\InvoiceReceiptController@finish');
    Route::get('/receipt-ar/show/{receipt_ar}', 'Project\InvoiceReceiptController@show');
    Route::get('/receipt-ar/show/{receipt}/print', 'Project\InvoiceReceiptController@print');
    Route::get('/receipt-ars', 'Project\InvoiceReceiptController@index');
    Route::get('/tax-invoices', 'Project\InvoiceReceiptController@tax');
    Route::post('/receipt-ar/create', 'Project\InvoiceReceiptController@create');
    Route::post('/receipt-ar/store', 'Project\InvoiceReceiptController@store');
    Route::post('/receipt-ar/cancel/{receipt}', 'Project\InvoiceReceiptController@cancel');

    Route::get('/project/invoices', 'Project\InvoiceController@index');
    Route::get('/project/invoice/show/{invoice}', 'Project\InvoiceController@show');
    Route::get('/project/invoice/print/{invoice}', 'Project\InvoiceController@print');
    Route::post('/project/invoice/create/{project}', 'Project\InvoiceController@create');
    Route::post('/project/invoice/store/{project}', 'Project\InvoiceController@store');
    
    Route::get('/project/add-income/new/{project}', 'Project\IncomeController@index');
    Route::get('/project/add-income/create/{project}', 'Project\IncomeController@create');
    Route::get('/project/add-income/edit/{project}', 'Project\IncomeController@edit');
    Route::post('/project/create-income/{project}', 'Project\IncomeController@store');
    Route::get('/project/add-income/delete/{income}', 'Project\IncomeController@delete');
    Route::post('/project/update-income/{project}', 'Project\IncomeController@update');

    Route::get('/project-type', 'Project\ProjectTypeController@index');
    Route::post('/project-type', 'Project\ProjectTypeController@store');
    Route::post('/project-type/update/{project_type}', 'Project\ProjectTypeController@update');

    Route::get('/project', 'Project\ProjectController@index');
    Route::get('/project/create', 'Project\ProjectController@create');
    Route::post('/project', 'Project\ProjectController@store');
    Route::post('/project/update/{project}', 'Project\ProjectController@update');
    Route::get('/project/show/{project}', 'Project\ProjectController@show');

    Route::get('/cost-plan', 'CostPlans\ConstPlanController@index');
    Route::post('/cost-plan', 'CostPlans\ConstPlanController@store');
    Route::post('/cost-plan/update/{costplan}', 'CostPlans\ConstPlanController@update');
    Route::post('/cost-plan-list-auto', 'CostPlans\ConstPlanController@create_auto');
    
    Route::post('/cost-plan-list', 'CostPlans\ConstPlanListController@create');
    Route::post('cost-plan-list/update/{costplan_list}', 'CostPlans\ConstPlanListController@update');
    
    Route::get('/customers', 'Customer\CustomerController@index');
    Route::get('/customer/create', 'Customer\CustomerController@create');
    Route::get('/customer/create/project/{project}', 'Customer\CustomerController@create_project');
    Route::get('/customer/{customer}/show', 'Customer\CustomerController@show');
    Route::post('/customer', 'Customer\CustomerController@store');
    Route::post('/customer/update/{customer}', 'Customer\CustomerController@update');

    Route::get('/branch', 'Branch\BranchController@index');
    Route::post('/branch/update/{branch}', 'Branch\BranchController@update');
    Route::post('/branch', 'Branch\BranchController@store');

    Route::get('/jb/admin/users', 'UserController@lists');
    Route::post('/jb/admin/user/{user}', 'UserController@update');
    Route::post('/user/register', 'UserController@store');

    Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/home', 'DashboardController@index')->name('home');

    Route::get('/jb/admin/roles', 'RoleController@index');
    Route::get('/jb/admin/role/create', 'RoleController@create');
    Route::post('/jb/admin/role', 'RoleController@store');
    Route::get('/jb/admin/role/{role}/edit', 'RoleController@edit');
    Route::patch('/jb/admin/role/{role}', 'RoleController@update');

    Route::get('/jb/admin/permissions', 'PermissionController@index');
    Route::get('/jb/admin/permission/create', 'PermissionController@create');
    Route::post('/jb/admin/permission', 'PermissionController@store');
    Route::get('/jb/admin/permission/{permission}/edit', 'PermissionController@edit');
    Route::patch('/jb/admin/permission/{permission}', 'PermissionController@update');
});
Route::post('/login', 'Auth\LoginController@login');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/user/to/branch', 'Branch\UserToBranchController@index')->name('user_to_branch');
Route::get('/auth/user/checkout/tobranch/{to_branch}', 'Branch\UserToBranchController@checkout');