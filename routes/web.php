<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PawnItemController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Models\Customer;
use App\Models\PawnItem;
use App\Models\PaymentSchedule;

// ==========================================================
// 🔓 PUBLIC ROUTES: Anyone can open these pages without login
// ==========================================================

// Login page routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Signup page routes (Fixed: Kept completely outside middleware)
// Route::get('/signup', [SignupController::class, 'showSignupForm'])->name('signup');
// Route::post('/signup', [SignupController::class, 'register']);

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

// Logout action session
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Main welcome page
Route::get('/', function () {
    return view('welcome');
});


// ==========================================================
// 🔒 PROTECTED STAFF ROUTES: Must login first to access pages
// ==========================================================
Route::middleware(['auth'])->group(function () {

    // Main dashboard page counters logs
    Route::get('/dashboard', function () {
        $totalCustomers = Customer::count();
        $activePawnItems = PawnItem::where('item_status', 'active')->count();
        $totalLoanAmount = PawnItem::where('item_status', 'active')->sum('approved_loan');
        $recentPawnItems = PawnItem::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalCustomers', 'activePawnItems', 'totalLoanAmount', 'recentPawnItems'));
    })->name('dashboard');

    // Customer list directory view
    Route::get('/customer', function () {
        $customers = Customer::with('pawnItems')->latest()->get();
        return view('admin.customer', compact('customers'));
    })->name('customer');

    // Customer profile info detail cards
    Route::get('/customer/{id}', function ($id) {
        $customer = Customer::findOrFail($id);
        return view('admin.customer-show', compact('customer'));
    })->name('customer.show');

    // Save new customer data entries row
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

    // Pawn items database directory chart
    Route::get('/pawnItem', [PawnItemController::class, 'index'])->name('pawnItem');

    // Pawn ledger monthly details calendars
    Route::get('/pawnItem/{id}', function ($id) {
        $item = PawnItem::with('customer', 'paymentSchedules')->findOrFail($id);
        return view('admin.pawnItem-show', compact('item'));
    })->name('pawnItem.show');

    // Update payment schedule status row to paid
    Route::post('/payment-schedule/{id}/pay', function ($id) {
        $schedule = PaymentSchedule::findOrFail($id);
        $schedule->update([
            'status' => 'paid',
            'paid_date' => now()->format('Y-m-d')
        ]);
        return redirect()->back()->with('success', 'បានកត់ត្រាការបង់ប្រាក់រួចរាល់!');
    })->name('paymentSchedule.pay');

    // Save newly added pawn inventory items
    Route::post('/pawn-items', [PawnItemController::class, 'store'])->name('pawnItems.store');

    // Customer searching API JSON fields endpoints
    Route::get('/api/search-customers', [CustomerController::class, 'searchApi'])->name('customers.searchApi');

    // Future components menu tabs layouts
    Route::get('/loanContract', function () { return view('admin.loanContract'); })->name('loanContract');
    Route::get('/payments', function () { return view('admin.payments'); })->name('payments');

    // Sync calendars schedules logs for older database entries
    Route::get('/fix-old-schedules', function () {
        $pawnItems = PawnItem::all();
        $count = 0;
        foreach ($pawnItems as $item) {
            if ($item->paymentSchedules()->count() == 0) {
                $timeStart = strtotime($item->pawn_date);
                $timeEnd = strtotime($item->maturity_due_date);
                $monthsStart = (int) date('Y', $timeStart) * 12 + (int) date('m', $timeStart);
                $monthsEnd = (int) date('Y', $timeEnd) * 12 + (int) date('m', $timeEnd);
                $totalMonths = $monthsEnd - $monthsStart;
                if ($totalMonths < 1) $totalMonths = 1;

                $rate = $item->monthly_interest_rate ?? $item->interest_rate ?? 0;
                $monthlyInterestAmount = $item->approved_loan * ($rate / 100);

                for ($i = 1; $i <= $totalMonths; $i++) {
                    $scheduleDueDate = date('Y-m-d', strtotime("+" . $i . " month", $timeStart));
                    PaymentSchedule::create([
                        'pawn_item_id' => $item->id,
                        'term_number' => $i,
                        'due_date' => $scheduleDueDate,
                        'interest_amount' => $monthlyInterestAmount,
                        'status' => 'unpaid',
                    ]);
                }
                $count++;
            }
        }
        return "ជោគជ័យ! បានបំពេញកាលវិភាគបង់ប្រាក់ជូនរបស់ចាស់ៗចំនួន " . $count . " រួចរាល់។";
    });

});

// ==========================================================
// 🔒 CUSTOMER PORTAL ROUTES: Client account tracking layout page
// ==========================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/my-pledges', function () {
        return "Welcome to your personal client tracking portal layout view page!";
    })->name('customer.pledges');
});
