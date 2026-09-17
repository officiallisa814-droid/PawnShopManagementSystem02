<!-- Sidebar & Header -->


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin_css/customer.css')); ?>">
<?php $__env->stopPush(); ?>

<!-- put code  <?php echo $__env->yieldContent('content'); ?>  -->
<?php $__env->startSection('content'); ?>

    <div class="customer-container">

        <!-- 1. Top Section: Title & Main Action Buttons -->
        <div class="directory-header">
            <h2 class="directory-title">Customer Directory</h2>
            <div class="action-buttons">
                <button class="btn btn-add"><i class="fa-solid fa-plus"></i> Add New Customer</button>
                <button class="btn btn-view"><i class="fa-solid fa-user-slash"></i> View Blacklist</button>
                <button class="btn btn-export"><i class="fa-solid fa-download"></i> Export Report</button>
            </div>
        </div>

        <!-- 2. Main Content Card -->
        <div class="directory-card">

            <!-- Filter and Search Row -->
            <div class="filter-section">
                <span class="filter-title">Customer Directory</span>
                <p class="filter-subtitle">Search Affairs/Queries, contact numbers, extra, Pledges</p>

                <div class="filter-controls">
                    <div class="input-wrapper">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="search" id="customer_search_input" placeholder="Search...">
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-location-dot search-icon"></i>
                        <input type="text" placeholder="Phnom Penh">
                    </div>
                    <button class="layer-filter-btn">
                        <i class="fa-solid fa-sliders"></i> Layer Filters
                    </button>
                </div>
            </div>

            <!-- 3. Customer Data Table -->
            <div class="table-title">Customer List</div>
            <div class="table-responsive">
                <table class="customer-table">
                    <thead>
                        <tr style="background-color: #0b2240;">
                            <th style="width: 40px;"></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>ID/Passport</th>
                            <th>Phone</th>
                            <th style="text-align: center;">Active Pledges</th>
                            <th style="text-align: center;">Status</th>
                            <th style="width: 40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr onclick="window.location='<?php echo e(route('customer.show', $customer->id)); ?>'"
                                style="cursor: pointer;">
                                <td onclick="event.stopPropagation();"><input type="checkbox" value="<?php echo e($customer->id); ?>"></td>
                                <td class="id-col"><?php echo e($customer->id); ?></td>

                                <!-- Updated Name Column with Dynamic Profile Picture -->
                                <td class="name-col">
                                    <div style="display: inline-flex; align-items: center; gap: 10px;">
                                        <?php if($customer->customer_avatar): ?>
                                            <img src="<?php echo e(asset('storage/' . $customer->customer_avatar)); ?>"
                                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb;">
                                        <?php else: ?>
                                            <!-- Professional geometric fallback icon if no picture was uploaded -->
                                            <div
                                                style="width: 35px; height: 35px; border-radius: 50%; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #6b7280; font-weight: bold;">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span style="color: #2563eb; font-weight: 600;"><?php echo e($customer->customer_name); ?></span>
                                    </div>
                                </td>

                                <td><?php echo e($customer->passport_id ?? 'N/A'); ?></td>
                                <td><?php echo e($customer->phone_number); ?></td>
                                <td class="pledge-count" style="text-align: center;"><?php echo e($customer->pawnItems->count()); ?></td>
                                <td class="text-center">
                                    <?php if(strtolower($customer->customer_status) == 'active'): ?>
                                        <span class="badge active-badge">Active</span>
                                    <?php else: ?>
                                        <span class="badge inactive-badge"><?php echo e(ucfirst($customer->customer_status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-cell" onclick="event.stopPropagation();"><i class="fa-solid fa-ellipsis"></i>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px; color: #888;">
                                    មិនមានទិន្នន័យអតិថិជនទេ / No customers found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>








        <!-- =========================================== Pup up ================================================== -->
        <!-- Customer Form Popup Modal Overlay -->
        <div class="modal-overlay" id="customerModal">
            <div class="modal-card">

                <!-- Modal Head -->
                <div class="modal-header">
                    <h3><i class="fa-solid fa-user-plus"></i> <span class="khmer-os">បន្ថែមព័ត៌មានអតិថិជនថ្មី</span> / Add
                        New Customer</h3>
                    <button class="close-modal-btn" id="closeModalBtn">&times;</button>
                </div>

                <!-- Modal Form Body Inputs -->
                <!-- add enctype="multipart/form-data" for aprove Upload picture or file -->
                <form class="modal-form" action="<?php echo e(route('customers.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-scroll-container">

                        <!-- Section 1: Personal Information -->
                        <div class="form-section-title"><i class="fa-solid fa-address-card"></i><span
                                class="khmer-os">ព័ត៌មានផ្ទាល់ខ្លួន</span> /
                            Personal Information</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="customer_name"><span class="khmer-os">ឈ្មោះអតិថិជន</span> / Customer
                                    Name</label>
                                <input type="text" id="customer_name" name="customer_name" placeholder="Enter full name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="gender"><span class="khmer-os">ភេទ</span> / Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value=""><span class="khmer-os">ជ្រើសរើស</span> / Select</option>
                                    <option value="M"><span class="khmer-os">ប្រុស</span> / Male</option>
                                    <option value="F"><span class="khmer-os">ស្រី</span> / Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dob"><span class="khmer-os">ថ្ងៃខែឆ្នាំកំណើត</span> / Date of Birth</label>
                                <input type="date" id="dob" name="dob" required>
                            </div>

                            <div class="form-group">
                                <label for="passport_id"><span class="khmer-os">អត្តសញ្ញាណប័ណ្ណ ឬ លិខិតឆ្លងដែន</span> / ID
                                    or Passport</label>
                                <input type="text" id="passport_id" name="passport_id" placeholder="e.g. CUST004" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_number"><span class="khmer-os">លេខទូរស័ព្ទ</span> / Phone Number</label>
                                <input type="text" id="phone_number" name="phone_number" placeholder="e.g. (097) 1234567"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email"><span class="khmer-os">អ៊ីមែល</span> / Email Address</label>
                                <input type="email" id="email" name="email" placeholder="e.g. client@example.com">
                            </div>
                        </div>

                        <!-- Section 2: Current Address -->
                        <div class="form-section-title"><i class="fa-solid fa-map-location-dot"></i><span
                                class="khmer-os">អាសយដ្ឋានបច្ចុប្បន្ន</span> /
                            Current Address</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="address_house"><span class="khmer-os">ផ្ទះលេខ</span> / House No.</label>
                                <input type="text" id="address_house" name="address_house" placeholder="e.g. St 12A">
                            </div>

                            <div class="form-group">
                                <label for="address_street"><span class="khmer-os">ផ្លូវ</span> / Street No.</label>
                                <input type="text" id="address_street" name="address_street" placeholder="e.g. 271">
                            </div>

                            <div class="form-group">
                                <label for="address_village"><span class="khmer-os">ភូមិ-ឃុំ-សង្កាត់</span> /
                                    Village-Commune</label>
                                <input type="text" id="address_village" name="address_village"
                                    placeholder="e.g. Boeung Keng Kang" required>
                            </div>

                            <div class="form-group">
                                <label for="address_district"><span class="khmer-os">ក្រុង-ស្រុក-ខណ្ឌ</span> /
                                    District</label>
                                <input type="text" id="address_district" name="address_district"
                                    placeholder="e.g. Chamkar Mon" required>
                            </div>

                            <div class="form-group full-width">
                                <label for="address_province"><span class="khmer-os">ខេត្ត-រាជធានី</span> /
                                    Province-Capital</label>
                                <input type="text" id="address_province" name="address_province"
                                    placeholder="e.g. Phnom Penh" required>
                            </div>
                        </div>

                        <!-- Section 3: Guarantor or Emergency Contact -->
                        <div class="form-section-title"><i class="fa-solid fa-shield-halved"></i><span class="khmer-os">
                                អ្នកធានា ឬ
                                ទំនាក់ទំនងបន្ទាន់</span> / Emergency Contact</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="guarantor_name"><span class="khmer-os">ឈ្មោះអ្នកធានា</span> / Guarantor
                                    Name</label>
                                <input type="text" id="guarantor_name" name="guarantor_name"
                                    placeholder="Enter guarantor name">
                            </div>

                            <div class="form-group">
                                <label for="guarantor_phone"><span class="khmer-os">លេខទូរស័ព្ទអ្នកធានា</span> / Guarantor
                                    Phone</label>
                                <input type="text" id="guarantor_phone" name="guarantor_phone"
                                    placeholder="e.g. 012 345 678">
                            </div>
                        </div>

                        <!-- Selection 4: System Config & Documents -->
                        <div class="form-section-title"><i class="fa-solid fa-sliders"></i><span class="khmer-os">
                                ប្រព័ន្ធគ្រប់គ្រង និងឯកសារស្កែន</span>
                            / System & Documents</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="active_pledges"><span class="khmer-os">ចំនួនបញ្ចាំសកម្ម</span> / Active
                                    Pledges</label>
                                <input type="number" id="active_pledges" name="active_pledges" placeholder="0" min="0"
                                    value="0">
                            </div>

                            <div class="form-group">
                                <label for="customer_type"><span class="khmer-os">ចំណាត់ថ្នាក់អតិថិជន</span> / Customer
                                    Category</label>
                                <select id="customer_type" name="customer_type">
                                    <option value="regular"><span class="khmer-os">អតិថិជនទូទៅ</span> / Regular</option>
                                    <option value="vip"><span class="khmer-os">អតិថិជន</span> VIP</option>
                                    <option value="bad"><span class="khmer-os">ប្រវត្តិមិនល្អ</span> / Blacklisted</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="customer_status"><span class="khmer-os">ស្ថានភាពគណនី</span> / Initial
                                    Status</label>
                                <select id="customer_status" name="customer_status">
                                    <option value="active"><span class="khmer-os">សកម្ម</span> / Active</option>
                                    <option value="inactive"><span class="khmer-os">មិនសកម្ម</span> / Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_card_photo"><span class="khmer-os">រូបថតអត្តសញ្ញាណប័ណ្ណ</span> (KYC) / ID
                                    Card Image</label>
                                <input type="file" id="id_card_photo" name="id_card_photo" accept="image/*">
                            </div>

                            <div class="form-group full-width">
                                <label for="customer_avatar"><span class="khmer-os">រូបថតផ្ទាល់មុខអតិថិជន</span> / Customer
                                    Photo</label>
                                <input type="file" id="customer_avatar" name="customer_avatar" accept="image/*">
                            </div>

                            <div class="form-group full-width">
                                <label for="notes"><span class="khmer-os">កំណត់ចំណាំបន្ថែម</span> / Notes & Remarks</label>
                                <textarea id="notes" name="notes" rows="3"
                                    placeholder="Enter special remarks or history notes..."></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Action controls container row -->
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" id="cancelModalBtn"><span class="khmer-os">បោះបង់</span> /
                            Cancel</button>
                        <button type="submit" class="btn-submit"><span class="khmer-os">រក្សាទុក</span> / Save
                            Customer</button>
                    </div>
                </form>

                <!-- Display Success Message -->
                <?php if(session('success')): ?>
                    <div
                        style="background-color: #def7ec; color: #03543f; padding: 15px; margin-top: 20px; border-radius: 8px; border: 1px solid #31c48d;">
                        <strong>ជោគជ័យ!</strong> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <!-- Display Validation Error Messages -->
                <?php if($errors->any()): ?>
                    <div
                        style="background-color: #fde8e8; color: #9b1c1c; padding: 15px; margin-top: 20px; border-radius: 8px; border: 1px solid #f8b4b4;">
                        <strong>សូមពិនិត្យកំហុសខាងក្រោម / Please fix the following errors:</strong>
                        <ul style="margin-top: 5px; padding-left: 20px;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>


        <?php $__env->startPush('scripts'); ?>
            <script>
                // --- Step 1: Get HTML elements ---

                // Get "Add" button
                var btnAdd = document.querySelector('.btn-add');

                // Get pop-up background
                var popUpBox = document.getElementById('customerModal');

                // Get "Close (x)" and "Cancel" buttons
                var btnCloseX = document.getElementById('closeModalBtn');
                var btnCancel = document.getElementById('cancelModalBtn');


                // --- Step 2: Open and Close logic ---

                // 1. Open pop-up on click
                btnAdd.onclick = function (event) {
                    event.preventDefault(); // Stop page jump
                    popUpBox.classList.add('show-modal'); //Show box
                };

                // 2. Close pop-up on (x) click
                btnCloseX.onclick = function () {
                    popUpBox.classList.remove('show-modal'); // Hide box
                };

                // 3. Close pop-up on "Cancel" click
                btnCancel.onclick = function () {
                    popUpBox.classList.remove('show-modal'); // ដក Class ចេញដូចគ្នា
                };

                // 4. Close pop-up when clicking outside the box
                popUpBox.onclick = function (event) {
                    if (event.target === popUpBox) {
                        popUpBox.classList.remove('show-modal'); // Hide box
                    }
                };
            </script>

            <!-- REAL-TIME CUSTOMER SEARCH FILTER  -->
            <!-- 🌟 SINGLE-RESULT CUSTOMER SEARCH FILTER 🌟 -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // 1. Get the search input box and the table from the page
                    const searchInput = document.getElementById('customer_search_input');
                    const dataTable = document.getElementById('customer_data_table');

                    // 2. Listen to what the user types in the input box
                    searchInput.addEventListener('keyup', function () {
                        const keyword = this.value.toLowerCase().trim(); // Convert typed text to lowercase
                        const rows = dataTable.querySelectorAll('tbody tr'); // Find all rows inside the table body

                        // Track how many matching rows we have shown on screen
                        let matchCount = 0;

                        // 3. Loop through every row in the table
                        rows.forEach(function (row) {
                            // Skip the row if it is just the "No customers found" message
                            if (row.classList.contains('empty-row')) return;

                            // Get all combined text inside the current row
                            const rowText = row.textContent.toLowerCase();

                            // 4. Show the row ONLY if it matches the keyword AND it is the first match
                            if (keyword !== "" && rowText.includes(keyword)) {
                                matchCount++; // Found a match!

                                if (matchCount === 1) {
                                    row.style.display = "";     // Show only the first match
                                } else {
                                    row.style.display = "none";  // Hide any extra matching rows
                                }
                            } else if (keyword === "") {
                                row.style.display = "";         // Show all rows if search box is completely empty
                            } else {
                                row.style.display = "none";      // Hide rows that do not match at all
                            }
                        });
                    });
                });
            </script>


        <?php $__env->stopPush(); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>



    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\PawnShopManagementSystemV02\resources\views/admin/customer.blade.php ENDPATH**/ ?>