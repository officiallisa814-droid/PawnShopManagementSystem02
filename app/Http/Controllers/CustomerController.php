<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the form inputs
        $validatedData = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'gender'           => 'required|in:M,F',
            'dob'              => 'nullable|date',
            'passport_id'      => 'nullable|string|max:100',
            'phone_number'     => 'required|string|max:50',
            'email'            => 'nullable|email|max:255',
            'address_house'    => 'nullable|string|max:100',
            'address_street'   => 'nullable|string|max:100',
            'address_village'  => 'nullable|string|max:150',
            'address_district' => 'nullable|string|max:150',
            'address_province' => 'nullable|string|max:150',
            'guarantor_name'   => 'nullable|string|max:255',
            'guarantor_phone'  => 'nullable|string|max:50',
            'active_pledges'   => 'nullable|integer|min:0',
            'customer_type'    => 'nullable|string|max:50',
            'customer_status'  => 'nullable|string|max:50',
            'id_card_photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'customer_avatar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'notes'            => 'nullable|string',
        ]);

        // 2. Handle 'id_card_photo' upload if a file exists
        if ($request->hasFile('id_card_photo')) {
            $path = $request->file('id_card_photo')->store('customers/id_cards', 'public');
            $validatedData['id_card_photo'] = $path;
        }

        // 3. Handle 'customer_avatar' upload if a file exists
        if ($request->hasFile('customer_avatar')) {
            $path = $request->file('customer_avatar')->store('customers/avatars', 'public');
            $validatedData['customer_avatar'] = $path;
        }

        // 4. Insert data directly into the database using Eloquent
        Customer::create($validatedData);

        // 5. Redirect back with a success message
        return redirect()->back()->with('success', 'Customer registered successfully!');
    }

    /**
     * 🌟 បន្ថែមមុខងារនេះសម្រាប់ឱ្យ JavaScript (AJAX) វាយស្វែងរកទិន្នន័យអតិថិជនលឿនរហ័ស
     */
    public function searchApi(Request $request)
    {
        $search = $request->query('query');
        
        // ស្វែងរកអតិថិជនតាមរយៈ ID ចំៗ ឬ ឈ្មោះ ឬ លេខទូរស័ព្ទ
        $customers = Customer::where('id', $search)
            ->orWhere('customer_name', 'LIKE', "%{$search}%")
            ->orWhere('phone_number', 'LIKE', "%{$search}%")
            ->select('id', 'customer_name', 'phone_number')
            ->take(5) // យកតែ ៥ លទ្ធផលដំបូងដើម្បីកុំឱ្យកម្មវិធីដើរយឺត
            ->get();
            
        return response()->json($customers);
    }
}
