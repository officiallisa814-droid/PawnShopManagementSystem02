<!-- ហៅគ្រោងឆ្អឹងរួម (Sidebar & Header) ពីហ្វាយមេមកប្រើ -->
@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin_css/customer-show.css') }}">
@endpush

@section('content')
<div class="profile-page-wrapper">
    
    <div class="profile-layout-container">
        
        <!-- ផ្នែកខាងឆ្វេង (Sticky Column) -->
        <div class="left-sticky-column">
            
            <!-- លីងត្រឡប់ក្រោយ / Back Button -->
            <a href="{{ route('customer') }}" class="back-link-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Directory
            </a>
            
            <!-- box picture -->
            <div class="profile-sidebar-card">
                <div class="avatar-wrapper">
                    @if($customer->customer_avatar)
                        <img src="{{ asset('storage/' . $customer->customer_avatar) }}" class="main-avatar-img" alt="Avatar">
                    @else
                        <div class="fallback-avatar-circle">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                    @endif
                </div>
                
                <h2 class="customer-title-name">{{ $customer->customer_name }}</h2>
                <p class="customer-meta-id">ID: #{{ $customer->id }}</p>
                
                <div class="status-badge-wrapper">
                    <span class="badge-pill {{ strtolower($customer->customer_status) == 'active' ? 'badge-active' : 'badge-inactive' }}">
                        <i class="fa-solid {{ strtolower($customer->customer_status) == 'active' ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                        {{ strtoupper($customer->customer_status) }}
                    </span>
                </div>

                <div class="sidebar-stats-box">
                    <div class="stat-row">
                        <span class="khmer-os">ប្រភេទ</span>
                        <strong>{{ ucfirst($customer->customer_type) }}</strong>
                    </div>
                    <div class="stat-row">
                        <span class="khmer-os">ការបញ្ចាំសកម្ម</span>
                        <span class="pledge-count-tag">{{ $customer->pawnItems->count() }} items</span>
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
                        <p class="khmer-os">{{ $customer->gender == 'M' ? 'ប្រុស (Male)' : 'ស្រី (Female)' }}</p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">ថ្ងៃខែឆ្នាំកំណើត / Date of Birth</label>
                        <p>{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('Y-M-d') : '—' }}</p>
                    </div>
                    <div class="data-field-box full-width-field">
                        <label class="khmer-os">អត្តសញ្ញាណប័ណ្ណ ឬ លិខិតឆ្លងដែន / ID or Passport Number</label>
                        <p>{{ $customer->passport_id ?? '—' }}</p>
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
                        <p>{{ $customer->phone_number }}</p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">អ៊ីមែល / Email Address</label>
                        <p>{{ $customer->email ?? '—' }}</p>
                    </div>
                    <div class="data-field-box full-width-field">
                        <label class="khmer-os">អាសយដ្ឋានបច្ចុប្បន្ន / Registered Address</label>
                        <p class="address-paragraph khmer-os">
                            <span><strong class="khmer-os">ផ្ទះលេខ:</strong> {{ $customer->address_house ?? '—' }}</span>
                            <span><strong class="khmer-os">ផ្លូវ:</strong> {{ $customer->address_street ?? '—' }}</span><br>
                            <span><strong class="khmer-os">ភូមិ-ឃុំ-សង្កាត់:</strong> {{ $customer->address_village ?? '—' }}</span>
                            <span><strong class="khmer-os">ក្រុង-ស្រុក-ខណ្ឌ:</strong> {{ $customer->address_district ?? '—' }}</span><br>
                            <span><strong class="khmer-os">ខេត្ត-រាជធានី:</strong> {{ $customer->address_province ?? '—' }}</span>
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
                        <p>{{ $customer->guarantor_name ?? '—' }}</p>
                    </div>
                    <div class="data-field-box">
                        <label class="khmer-os">លេខទូរស័ព្ទអ្នកធានា / Guarantor Phone</label>
                        <p>{{ $customer->guarantor_phone ?? '—' }}</p>
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
                    @if($customer->id_card_photo)
                        <label class="doc-meta-label khmer-os">រូបថតអត្តសញ្ញាណប័ណ្ណ (National ID / Passport Scan)</label>
                        <img src="{{ asset('storage/' . $customer->id_card_photo) }}" class="kyc-preview-image" alt="KYC Document">
                    @else
                        <div class="kyc-empty-state">
                            <i class="fa-solid fa-folder-open"></i>
                            <p class="khmer-os">មិនមានឯកសារភ្ជាប់អត្តសញ្ញាណប័ណ្ណទេ / No official ID documents uploaded.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- block 5: Note -->
            <div class="details-section-block">
                <h3 class="section-heading">
                    <i class="fa-solid fa-comment-medical"></i> 
                    <span class="khmer-os">កំណត់ចំណាំបន្ថែម</span> / Remarks & Notes
                </h3>
                <div class="notes-display-box">
                    <p>{{ $customer->notes ?? 'No internal audit notes recorded.' }}</p>
                </div>
            </div>

            <!-- footer (Timestamps) -->
            <div class="system-logs-footer khmer-os">
                <span><i class="fa-solid fa-clock"></i> <strong>ចុះឈ្មោះដំបូង:</strong> {{ $customer->created_at->format('Y-M-d h:i A') }}</span>
                <span><i class="fa-solid fa-pen-to-square"></i> <strong>ធ្វើបច្ចុប្បន្នភាពចុងក្រោយ:</strong> {{ $customer->updated_at->format('Y-M-d h:i A') }}</span>
            </div>

        </div>
    </div>
</div>
@endsection
