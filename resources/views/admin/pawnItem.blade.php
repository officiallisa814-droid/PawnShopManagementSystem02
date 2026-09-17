<!--Sidebar & Header -->
@extends('layouts.master')

@push('styles')
    <!-- Link to the clean external stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin_css/pawnItem.css') }}">
@endpush

@section('content')
    <div class="pawn-container">

        <!-- 1. ADD NEW PAWN ITEM FORM CARD -->
        <div class="pawn-card">
            <h2 class="pawn-card-title"><span class="khmer-os">បន្ថែមទំនិញបញ្ចាំថ្មី</span> / Add New Pawn Item</h2>

            <form action="{{ route('pawnItems.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="pawn-form-grid">
                    <!-- Customer Name / ID Search Field -->
                    <div class="form-group dropdown-anchor">
                        <label><span class="khmer-os">ឈ្មោះអតិថិជន ឬ លេខសម្គាល់</span> / Customer Name / User ID <span
                                class="required">*</span></label>

                        <!-- Input field for typing text query search parameters -->
                        <input type="text" id="customer_search" autocomplete="off"
                            placeholder="វាយឈ្មោះ ឬ ID អតិថិជន... / Type name or ID..." required>

                        <!-- Hidden input to hold the clean integer database primary key ID -->
                        <input type="hidden" name="customer_id" id="selected_customer_id">

                        <!-- Floating drop menu interface overlay container -->
                        <div id="search_results_dropdown" class="search-results-dropdown"></div>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="form-group">
                        <label><span class="khmer-os">ប្រភេទជម្រើស</span> / Category <span class="required">*</span></label>
                        <select name="category" required>
                            <option value="" disabled selected>Select item category</option>
                            <option value="electronics">Electronics / គ្រឿងអេឡិចត្រូនិច</option>
                            <option value="jewelry">Jewelry / គ្រឿងអលង្ការ</option>
                            <option value="vehicle">Vehicle / យានយន្ត</option>
                        </select>
                    </div>

                    <!-- Item Name -->
                    <div class="form-group">
                        <label><span class="khmer-os">ឈ្មោះទំនិញ</span> / Item Name <span class="required">*</span></label>
                        <input type="text" name="item_name" placeholder="Enter item name (e.g. iPhone 15 Pro Max)" required>
                    </div>

                    <!-- IMEI / Serial / Tag -->
                    <div class="form-group">
                        <label><span class="khmer-os">លេខសៀរៀល ឬ លេខកូដ</span> / IMEI / Serial / Tag <span
                                class="required">*</span></label>
                        <input type="text" name="serial_number" placeholder="Enter IMEI, Serial Number, or Asset Tag"
                            required>
                    </div>

                    <!-- Storage / Safe Location -->
                    <div class="form-group">
                        <label><span class="khmer-os">ទីតាំងរក្សាទុក</span> / Storage / Safe Location <span
                                class="required">*</span></label>
                        <input type="text" name="storage_location"
                            placeholder="Enter safe or shelf number (e.g. Safe A - Box 5)" required>
                    </div>

                    <!-- Included Accessories -->
                    <div class="form-group">
                        <label><span class="khmer-os">គ្រឿងបន្លាស់រួមបញ្ចូល</span> / Included Accessories</label>
                        <input type="text" name="accessories" placeholder="Enter accessories (e.g. Box, Charger, Receipt)">
                    </div>

                    <!-- Estimated Market Value -->
                    <div class="form-group">
                        <label><span class="khmer-os">តម្លៃទីផ្សារប៉ាន់ស្មាន ($)</span> / Estimated Market Value ($) <span
                                class="required">*</span></label>
                        <input type="number" step="0.01" name="market_value"
                            placeholder="Enter estimated market value in USD" required>
                    </div>

                    <!-- Approved Loan -->
                    <div class="form-group">
                        <label><span class="khmer-os">ប្រាក់កម្ចីដែលបានអនុម័ត ($)</span> / Approved Loan ($) <span
                                class="required">*</span></label>
                        <input type="number" step="0.01" name="approved_loan"
                            placeholder="Enter approved loan amount in USD" required>
                    </div>

                    <!-- Monthly Interest Rate -->
                    <div class="form-group">
                        <label><span class="khmer-os">អត្រាការប្រាក់ប្រចាំខែ (%)</span> / Monthly Interest Rate (%) <span
                                class="required">*</span></label>
                        <input type="number" step="0.01" name="interest_rate"
                            placeholder="Enter monthly interest rate percentage" required>
                    </div>

                    <!-- Pawn Date -->
                    <div class="form-group">
                        <label><span class="khmer-os">ថ្ងៃបញ្ចាំ</span> / Pawn Date <span class="required">*</span></label>
                        <input type="date" name="pawn_date" value="2026-09-06" required>
                    </div>

                    <!-- Maturity / Due Date -->
                    <div class="form-group">
                        <label><span class="khmer-os">ថ្ងៃផុតកំណត់</span> / Maturity / Due Date <span
                                class="required">*</span></label>
                        <input type="date" name="due_date" value="2026-11-07" required>
                    </div>

                    <!-- Item Photo Upload -->
                    <div class="form-group">
                        <label><span class="khmer-os">រូបថតទំនិញ</span> / Item Photo Upload</label>
                        <input type="file" name="item_photo" class="file-input">
                    </div>

                    <!-- Item Condition Notes (Spans full width) -->
                    <div class="form-group full-width">
                        <label><span class="khmer-os">ព័ត៌មានលម្អិតអំពីស្ថានភាពទំនិញ</span> / Item Condition & Wear
                            Details</label>
                        <textarea name="condition_details" rows="3"
                            placeholder="Enter detailed condition notes (e.g., 95% condition, slight scratches on screen, battery health 90%)"></textarea>
                    </div>
                </div>

                <!-- Form Submit Button Alignment Container -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn"><span class="khmer-os">បន្ថែមទំនិញបញ្ចាំ</span> / Add Pawn
                        Item</button>
                </div>
            </form>
        </div>




        <!-- 2. PAWNED ITEMS INVENTORY DATA TABLE -->
        <div class="pawn-card table-card">
            <div class="inventory-header">
                <h2 class="pawn-card-title">
                    <span class="khmer-os">បញ្ជីទំនិញបញ្ចាំ</span> / Pawned Items Inventory
                </h2>

                <!-- Search input container -->
                <div class="search-wrapper">
                    <input type="search" id="table_search_input" placeholder="Search Item..." class="cool-search-input">
                    <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                </div>
            </div>


            <div class="responsive-table-wrapper">
                <table class="inventory-table" id="inventory_data_table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Photo</th>
                            <th>Customer</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>IMEI / Serial</th>
                            <th>Storage</th>
                            <th>Loan ($)</th>
                            <th>Interest</th>
                            <th>Pawn Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pawnItems as $item)
                            <!-- Click row to open monthly payment schedule page -->
                            <tr onclick="window.location='{{ route('pawnItem.show', $item->id) }}'" style="cursor: pointer;"
                                onmouseover="this.style.backgroundColor='#f8fafc'"
                                onmouseout="this.style.backgroundColor='transparent'">
                                <td>#{{ $item->id }}</td>
                                <td>
                                    @if($item->item_photo)
                                        <img src="{{ asset('storage/' . $item->item_photo) }}"
                                            style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                    @else
                                        <span style="color: #94a3b8; font-size: 12px;">No Image</span>
                                    @endif
                                </td>

                                <!-- Prevents row link action when clicking customer name -->
                                <td onclick="event.stopPropagation();">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @if($item->customer && $item->customer->customer_avatar)
                                            <img src="{{ asset('storage/' . $item->customer->customer_avatar) }}"
                                                style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;">
                                        @else
                                            <div
                                                style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #64748b;">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        @endif
                                        <!-- Added a target class for the customer name column string -->
                                        <span class="khmer-os customer-name-td"
                                            style="font-weight: 600;">{{ $item->customer->customer_name ?? 'N/A' }}</span>
                                    </div>
                                </td>

                                <!-- Added a target class for the item name column string -->
                                <td class="item-name-td" style="color: #2563eb; font-weight: 600;">{{ $item->item_name }}</td>
                                <td>{{ ucfirst($item->category) }}</td>
                                <td>{{ $item->imei_serial_tag ?? $item->serial_number }}</td>
                                <td>{{ $item->storage_location }}</td>
                                <td style="font-weight: bold; color: #16a34a;">${{ number_format($item->approved_loan, 2) }}
                                </td>
                                <td>{{ $item->monthly_interest_rate ?? $item->interest_rate }}%</td>
                                <td>{{ $item->pawn_date }}</td>
                                <td style="color: #ef4444; font-weight: 600;">{{ $item->maturity_due_date ?? $item->due_date }}
                                </td>
                                <td>
                                    <span
                                        style="padding: 4px 8px; border-radius: 12px; font-size: 12px; background-color: #def7ec; color: #03543f; font-weight: bold;">
                                        {{ strtoupper($item->item_status ?? $item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="12" style="text-align: center; color: #94a3b8; padding: 40px 20px;">
                                    <span class="khmer-os">មិនទាន់មានទិន្នន័យនៅឡើយទេ។
                                        សូមបំពេញទម្រង់ខាងលើដើម្បីបន្ថែម។</span><br>
                                    No items added yet. Submit the form above to add an entry.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection



    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('customer_search');
            const resultsDropdown = document.getElementById('search_results_dropdown');
            const hiddenIdInput = document.getElementById('selected_customer_id');

            searchInput.addEventListener('input', function () {
                let query = this.value.trim();

                if (query.length < 1) {
                    resultsDropdown.style.display = 'none';
                    resultsDropdown.innerHTML = '';
                    hiddenIdInput.value = '';
                    return;
                }

                fetch(`/api/search-customers?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsDropdown.innerHTML = '';

                        if (data.length > 0) {
                            resultsDropdown.style.display = 'block';

                            data.forEach(customer => {
                                const item = document.createElement('div');
                                item.className = 'search-item';
                                item.innerHTML = `
                            <div>
                                <strong>ID: ${customer.id}</strong> - <span class="khmer-os">${customer.customer_name}</span>
                            </div>
                            <div class="phone-meta">${customer.phone_number}</div>
                        `;

                                item.addEventListener('click', function () {
                                    searchInput.value = `${customer.customer_name} (ID: ${customer.id})`;
                                    hiddenIdInput.value = customer.id;
                                    resultsDropdown.style.display = 'none';
                                });

                                resultsDropdown.appendChild(item);
                            });
                        } else {
                            resultsDropdown.style.display = 'block';
                            resultsDropdown.innerHTML = '<div style="padding: 10px; color: #94a3b8; font-size: 13px; text-align: center;">រកមិនឃើញអតិថិជនទេ / No customer found</div>';
                            hiddenIdInput.value = '';
                        }
                    })
                    .catch(error => console.error('Error fetching customers:', error));
            });

            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !resultsDropdown.contains(e.target)) {
                    resultsDropdown.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Search Item form the table -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Get elements from HTML page parameters
            const searchInput = document.getElementById('table_search_input');
            const dataTable = document.getElementById('inventory_data_table');
            const statusDisplay = document.getElementById('search_status_display');
            const infoText = document.getElementById('matched_info_text');

            // 2. Run function every time the user types a key inside the input box
            searchInput.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase().trim(); // Get user input phrase text
                const rows = dataTable.querySelectorAll('tbody tr'); // Target all table body rows

                let foundCustomer = "";
                let foundItem = "";
                let matchCount = 0;

                // 3. Loop through every single row inside the table body
                rows.forEach(function (row) {
                    if (row.classList.contains('empty-row')) return; // Skip empty message alert tag

                    const rowText = row.textContent.toLowerCase();

                    // 4. Show row if text matches. Hide it if it does not match.
                    if (rowText.includes(keyword)) {
                        row.style.display = ""; // Show matching entry
                        matchCount++;

                        // 5. Extract specific names values if keyword is present
                        if (keyword.length > 0 && matchCount === 1) {
                            const customerTd = row.querySelector('.customer-name-td');
                            const itemTd = row.querySelector('.item-name-td');

                            if (customerTd) foundCustomer = customerTd.textContent;
                            if (itemTd) foundItem = itemTd.textContent;
                        }
                    } else {
                        row.style.display = "none"; // Hide mismatching entry
                    }
                });

                // 6. Manage live header information text visibility parameters
                if (keyword.length > 0 && matchCount > 0) {
                    statusDisplay.style.display = "block"; // Show wrapper panel on screen

                    // If multiple items match, add text indicating total match volume layout counts
                    if (matchCount > 1) {
                        infoText.textContent = foundCustomer + " - " + foundItem + " (and " + (matchCount - 1) + " more)";
                    } else {
                        infoText.textContent = foundCustomer + " - " + foundItem;
                    }
                } else {
                    statusDisplay.style.display = "none"; // Hide container box when query input text is empty
                    infoText.textContent = "";
                }
            });
        });
    </script>