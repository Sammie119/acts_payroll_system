<?php

use App\Http\Controllers\DownloadPayslipController;
use App\Http\Controllers\ExportToExcelController;
use App\Http\Controllers\SalaryGradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SalaryNotchController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SetupSalaryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

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

Route::get('/', function () {
//    return view('lock_screen');
    return view('auth.login');
})->middleware('guest');

Auth::routes();

//Route::get('login', function () {
//    return view('lock_screen');
////    return view('auth.login');
//})->middleware('guest');
Route::middleware('auth')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('users', 'users')->name('users');
        Route::get('destroy_user/{id}', 'destroy');
        Route::post('reset_user', 'resetPassword')->name('reset_user');
    });

    Route::controller(StaffController::class)->group(function () {
        Route::get('staff', 'index')->name('staff');
        Route::get('staff/create_staff', 'create')->name('staff/create_staff');
        Route::post('staff/store_staff', 'store');
        Route::get('staff/edit_staff/{id}', 'edit');
        Route::post('staff/edit_staff/update_staff', 'update');
        Route::get('staff/delete_staff/{id}', 'destroy');
    });

    Route::controller(SetupSalaryController::class)->group(function () {
        Route::get('salary', 'index')->name('salary');
        Route::get('salary/create_salary', 'create')->name('salary/create_salary');
        Route::post('salary/store_salary', 'store');
        Route::get('salary/edit_salary/{id}', 'edit');
        Route::post('salary/edit_salary/update_salary', 'update');
    });

    Route::controller(LoanController::class)->group(function () {
        Route::get('loans', 'index')->name('loans');
        Route::get('loans/create_loan', 'create')->name('loans/create_loan');
        Route::post('loans/store_loan', 'store');
        Route::get('loans/edit_loan/{id}', 'edit')->name('loan.edit');
        Route::post('loans/edit_loan/update_loan', 'update');
        Route::get('loans/delete_loan/{id}', 'destroy');
        Route::get('loans/view_loan/{id}', 'viewLoanPayment')->name('loan.payment');
    });

    Route::controller(PayrollController::class)->group(function () {
        Route::get('payroll', 'index')->name('payroll');
        Route::get('payroll/salary_inputs/{id}', 'salaryInputs')->name('salary_inputs');
        Route::post('payroll/salary_inputs/store_payroll', 'store');
        Route::get('payroll/view_paid_salaries/{id}', 'viewSalariesPaid')->name('view_paid_salaries');
        // Route::get('payroll/delete_all_paymemt/{id}', 'destroy');
        Route::post('generate_payroll', 'generatePayroll');
        Route::get('payroll/view_payslip/{pay_id}', 'viewPayslip')->name('view_payslip');
        Route::get('payroll/get_payslip/{pay_id}', 'getPaySlip')->name('get_payslip');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('reports', 'index')->name('reports');
        Route::post('generate_report', 'GenerateReport');
    });

    Route::controller(DownloadPayslipController::class)->group(function () {
        Route::get('payslips', 'index')->name('payslips');
        Route::get('download_pdf/{month}/{year}', 'downloadPayslips')->name('download_pdf');
        Route::get('delete_payslips/{month}/{year}/{filename}', 'deletePayslip')->name('delete_payslips');
        Route::get('send_emal/{month}/{year}/{start?}', 'sendEmails')->name('send_emal');
    });

    Route::controller(SettingsController::class)->group(function () {
        Route::get('dropdowns', 'indexDropdown')->name('dropdowns');
        Route::get('dropdowns/create_dropdown', 'createDropdown')->name('create_dropdown');
        Route::post('store_dropdown', 'storeDropdown')->name('store_dropdown');
        Route::get('dropdowns/edit_dropdown/{id}', 'editDropdown')->name('edit_dropdown');
        Route::post('update_dropdown', 'updateDropdown')->name('update_dropdown');
        Route::get('delete_dropdown/{id}', 'deleteDropdown')->name('delete_dropdown');

        Route::get('taxs', 'indexTax')->name('taxs');
        // Route::get('taxs/create_taxs', 'createTax')->name('create_taxs');
        Route::post('store_taxs', 'storeTax')->name('store_taxs');
        // Route::get('edit_taxs/{id}', 'editTax')->name('edit_taxs');
        // Route::post('update_taxs', 'updateTax')->name('update_taxs');
        // Route::get('delete_taxs/{id}', 'deleteTax')->name('delete_taxs');
    });

    Route::controller(SalaryGradeController::class)->group(function () {
        Route::prefix('grades')->group(function () {
            Route::get('/', 'index')->name('grades');
            Route::get('create', 'create')->name('grade.create');
            Route::post('store', 'store');
            Route::get('edit/{id}', 'edit');
            Route::post('edit/grade', 'update');
            Route::get('delete/{id}', 'destroy');
        });
    });

    Route::controller(SalaryNotchController::class)->group(function () {
        Route::prefix('notches')->group(function () {
            Route::get('/{grade_id}', 'index');
            Route::get('edit/{id}', 'edit');
            Route::post('edit/update', 'update');
            Route::get('delete/{id}', 'destroy');
        });
    });

    // Export Routes
    Route::controller(ExportToExcelController::class)->group(function () {
        Route::get('exprt_to_bank/{report_month}/{report_year}', 'exportToBank')->name('exprt_to_bank');
        Route::get('exprt_to_tier_1/{report_month}/{report_year}', 'exportToTeirOne')->name('exprt_to_tier_1');
        Route::get('exprt_to_tier_2/{report_month}/{report_year}', 'exportToTeirTwo')->name('exprt_to_tier_2');
        Route::get('exprt_to_welfare/{report_month}/{report_year}', 'exportToWelfareDues')->name('exprt_to_welfare');
        Route::get('exprt_to_loans/{report_month}/{report_year}', 'exportToLoans')->name('exprt_to_loans');
        Route::get('exprt_to_rent/{report_month}/{report_year}', 'exportToRentAdvance')->name('exprt_to_rent');
        Route::get('exprt_to_credit_union/{report_month}/{report_year}', 'exportToCreditUnionSaving')->name('exprt_to_credit_union');
        Route::get('exprt_to_paye_tax/{report_month}/{report_year}', 'exportToGRA')->name('exprt_to_paye_tax');

        Route::get('exprt_to_act_welfare/{report_month}/{report_year}', 'exportToActsWelfare')->name('exprt_to_act_welfare');
        Route::get('exprt_to_nehemiah/{report_month}/{report_year}', 'exportToNehemiah')->name('exprt_to_nehemiah');
        Route::get('exprt_to_p_fund/{report_month}/{report_year}', 'exportToPFund')->name('exprt_to_p_fund');
    });

});

Route::get('email/verify/{token}', [StaffController::class, 'verifyAccount'])->name('email.verify');

