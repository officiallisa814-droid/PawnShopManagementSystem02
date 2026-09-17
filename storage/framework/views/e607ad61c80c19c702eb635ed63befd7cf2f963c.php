<!-- ហៅគ្រោងឆ្អឹងរួម (Sidebar & Header) ពីហ្វាយមេមកប្រើ -->


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin_css/customer-show.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="profile-page-wrapper">
    
    <div class="profile-layout-container">
        
        <!-- ផ្នែកខាងឆ្វេង (Sticky Column) -->
        <div class="left-sticky-column">
            
            <!-- លីងត្រឡប់ក្រោយ / Back Button -->
            <a href="<?php echo e(route('customer')); ?>" class="back-link-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Directory
            </a>
            
            <!-- box picture -->
            <div class="profile-sidebar-card">
                <div class="avatar-wrapper">
                    <?php if($customer->customer_avatar): ?>
                        <img src="<?php echo e(asset('storage/' . $customer->customer_avatar)); ?>" class="main-avatar-img" alt="Avatar">
                    <?php else: ?>
                        <div class="fallback-avatar-circle">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h2 class="customer-title-name"><?php echo e($customer->customer_name); ?></h2>
                <p class="customer-meta-id">ID: #<?php echo e($customer->id); ?></p>
                
                <div class="status-badge-wrapper">
                    <span class="badge-pill <?php echo e(strtolower($customer->customer_status) == 'active' ? 'badge-active' : 'badge-inactive'); ?>">
                        <i class="fa-solid <?php echo e(strtolower($customer->customer_status) == 'active' ? 'fa-circle-check' : 'fa-circle-xmark'); ?>"></i>
                        <?php echo e(strtoupper($customer->customer_status)); ?>

                    </span>
                </div>

                <div class="sidebar-stats-box">
                    <div class="stat-row">
                        <span class="khmer-os">ប្រភេទ</span>
                        <strong><?php echo e(ucfirst($customer->customer_type)); ?></strong>
                    </div>
                    <div class="stat-row">
                        <span class="khmer-os">ការបញ្ចាំសកម្ម</span>
                        <span class="pledge-count-tag"><?php echo e($customer->pawnItems->count()); ?> items</span>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- information right -->
        <div class="profile-details-content">
            
            <!-- block 1: Information customer -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-address-card"></i> 
                    <span class="khmer-os">ព័ត៌មានផ្ទាល់ខ្លួន</span> / Personal Information
                </h3>
                <div class="fields-data-grid">
                    <div class="data-field-box">
                        <label class="khmer-os">ភេទ / Gender</label>
                        <p class="khmer-os"><?php echo e($customer->gender == 'M' ? 'ប្រុស (Male)' : 'ស្រី (Female)'); ?></p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">ថ្ងៃខែឆ្នាំកំណើត / Date of Birth</label>
                        <p><?php echo e($customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('Y-M-d') : '—'); ?></p>
                    </div>
                    <div class="data-field-box full-width-field">
                        <label class="khmer-os">អត្តសញ្ញាណប័ណ្ណ ឬ លិខិតឆ្លងដែន / ID or Passport Number</label>
                        <p><?php echo e($customer->passport_id ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            <!-- block 2: communition and address -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-map-location-dot"></i> 
                    <span class="khmer-os">ទំនាក់ទំនង និង អាសយដ្ឋាន</span> / Contact & Location
                </h3>
                <div class="fields-data-grid">
                    <div class="data-field-box">
                        <label class="khmer-os">លេខទូរស័ព្ទ / Phone Number</label>
                        <p><?php echo e($customer->phone_number); ?></p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">អ៊ីមែល / Email Address</label>
                        <p><?php echo e($customer->email ?? '—'); ?></p>
                    </div>
                    <div class="data-field-box full-width-field">
                        <label class="khmer-os">អាសយដ្ឋានបច្ចុប្បន្ន / Registered Address</label>
                        <p class="address-paragraph khmer-os">
                            <span><strong class="khmer-os">ផ្ទះលេខ:</strong> <?php echo e($customer->address_house ?? '—'); ?></span>
                            <span><strong class="khmer-os">ផ្លូវ:</strong> <?php echo e($customer->address_street ?? '—'); ?></span><br>
                            <span><strong class="khmer-os">ភូមិ-ឃុំ-សង្កាត់:</strong> <?php echo e($customer->address_village ?? '—'); ?></span>
                            <span><strong class="khmer-os">ក្រុង-ស្រុក-ខណ្ឌ:</strong> <?php echo e($customer->address_district ?? '—'); ?></span><br>
                            <span><strong class="khmer-os">ខេត្ត-រាជធានី:</strong> <?php echo e($customer->address_province ?? '—'); ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- block 3: guarantor information -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-user-shield"></i> 
                    <span class="khmer-os">ព័ត៌មានអ្នកធានា</span> / Guarantor Information
                </h3>
                <div class="fields-data-grid">
                    <div class="data-field-box">
                        <label class="khmer-os">ឈ្មោះអ្នកធានា / Guarantor Name</label>
                        <p><?php echo e($customer->guarantor_name ?? '—'); ?></p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">លេខទូរស័ព្ទអ្នកធានា / Guarantor Phone</label>
                        <p><?php echo e($customer->guarantor_phone ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            <!-- block 4: Official Attachments -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-file-invoice"></i> 
                    <span class="khmer-os">ឯកសារភ្ជាប់ផ្លូវការ</span> / Official Attachments (KYC)
                </h3>
                <div class="kyc-container-box">
                    <?php if($customer->id_card_photo): ?>
                        <label class="doc-meta-label khmer-os">រូបថតអត្តសញ្ញាណប័ណ្ណ (National ID / Passport Scan)</label>
                        <img src="<?php echo e(asset('storage/' . $customer->id_card_photo)); ?>" class="kyc-preview-image" alt="KYC Document">
                    <?php else: ?>
                        <div class="kyc-empty-state">
                            <i class="fa-solid fa-folder-open"></i>
                            <p class="khmer-os">មិនមានឯកសារភ្ជាប់អត្តសញ្ញាណប័ណ្ណទេ / No official ID documents uploaded.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- block 5: Note -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-comment-medical"></i> 
                    <span class="khmer-os">កំណត់ចំណាំបន្ថែម</span> / Remarks & Notes
                </h3>
                <div class="notes-display-box">
                    <p><?php echo e($customer->notes ?? 'No internal audit notes recorded.'); ?></p>
                </div>
            </div>

            <!-- footer (Timestamps) -->
            <div class="system-logs-footer khmer-os">
                <span><i class="fa-solid fa-clock"></i> <strong>ចុះឈ្មោះដំបូង:</strong> <?php echo e($customer->created_at->format('Y-M-d h:i A')); ?></span>
                <span><i class="fa-solid fa-pen-to-square"></i> <strong>ធ្វើបច្ចុប្បន្នភាពចុងក្រោយ:</strong> <?php echo e($customer->updated_at->format('Y-M-d h:i A')); ?></span>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\PawnShopManagementSystemV02\resources\views/admin/customer-show.blade.php ENDPATH**/ ?>