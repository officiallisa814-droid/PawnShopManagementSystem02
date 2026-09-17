<?php

namespace App\Http\Controllers;

use App\Models\PawnItem;
use App\Models\Customer;
use App\Models\PaymentSchedule; 
use Illuminate\Http\Request;

class PawnItemController extends Controller
{
    /**
     * Show form page and pawned items inventory table.
     */
    public function index()
    {
        // 1. Get all customers for live searching dropdown list
        $customers = Customer::latest()->get();
        
        // 2. Get all pawn items with customer relationship data loaded
        $pawnItems = PawnItem::with('customer')->latest()->get();
        
        return view('admin.pawnItem', compact('customers', 'pawnItems'));
    }

    /**
     * Save form inputs data directly into database.
     */
    public function store(Request $request)
    {
        // 1. Check all form input values carefully
        $validatedData = $request->validate([
            'customer_id'       => 'required|exists:customers,id',
            'category'          => 'required|string',
            'item_name'         => 'required|string|max:255',
            'serial_number'     => 'required|string|max:255',
            'storage_location'  => 'required|string|max:255',
            'accessories'       => 'nullable|string|max:255',
            'market_value'      => 'required|numeric|min:0',
            'approved_loan'     => 'required|numeric|min:0',
            'interest_rate'     => 'required|numeric|min:0',
            'pawn_date'         => 'required|date',
            'due_date'          => 'required|date|after_or_equal:pawn_date',
            'item_photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'condition_details' => 'nullable|string',
        ]);

        // 2. Manage and upload item photo if it exists in request
        if ($request->hasFile('item_photo')) {
            $path = $request->file('item_photo')->store('pawn_items', 'public');
            $validatedData['item_photo'] = $path;
        }

        // 3. Create a new object record row inside pawn_items table
        $pawnItem = new PawnItem();
        $pawnItem->customer_id       = $validatedData['customer_id'];
        $pawnItem->category          = $validatedData['category'];
        $pawnItem->item_name         = $validatedData['item_name'];
        $pawnItem->imei_serial_tag   = $validatedData['serial_number']; 
        $pawnItem->storage_location  = $validatedData['storage_location'];
        $pawnItem->included_accessories = $validatedData['accessories'] ?? null;
        $pawnItem->estimated_market_value = $validatedData['market_value'];
        $pawnItem->approved_loan     = $validatedData['approved_loan'];
        $pawnItem->monthly_interest_rate = $validatedData['interest_rate'];
        $pawnItem->pawn_date         = $validatedData['pawn_date'];
        $pawnItem->maturity_due_date = $validatedData['due_date'];
        $pawnItem->item_photo        = $validatedData['item_photo'] ?? null;
        $pawnItem->item_condition_details = $validatedData['condition_details'] ?? null;
        $pawnItem->item_status       = 'active';
        $pawnItem->save(); 

        // 4. Start auto payment schedule generation loop engine
        $timeStart = strtotime($validatedData['pawn_date']);
        $timeEnd   = strtotime($validatedData['due_date']);
        
        // Calculate the total months of the pawn contract lifecycle
        $monthsStart = (int)date('Y', $timeStart) * 12 + (int)date('m', $timeStart);
        $monthsEnd   = (int)date('Y', $timeEnd) * 12 + (int)date('m', $timeEnd);
        $totalMonths = $monthsEnd - $monthsStart;
        
        if ($totalMonths < 1) {
            $totalMonths = 1;
        }

        // Formula: Approved Loan * (Monthly Interest Rate Percentage / 100)
        $monthlyInterestAmount = $pawnItem->approved_loan * ($pawnItem->monthly_interest_rate / 100);

        for ($i = 1; $i <= $totalMonths; $i++) {
            // Generate exact monthly rolling interest payment calendar due dates
            $scheduleDueDate = date('Y-m-d', strtotime("+" . $i . " month", $timeStart));

            // Write row records straight down inside payment_schedules table
            PaymentSchedule::create([
                'pawn_item_id'    => $pawnItem->id,
                'term_number'     => $i,
                'due_date'        => $scheduleDueDate,
                'interest_amount' => $monthlyInterestAmount,
                'status'          => 'unpaid',
            ]);
        }
        // End auto payment schedule generation loop engine

        // 5. Redirect back to view screen layout panel with success alert
        return redirect()->back()->with('success', 'Pawn item added and payment schedule created successfully!');
    }
}
