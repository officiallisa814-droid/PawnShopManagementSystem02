<!-- Sidebar & Header -->
@extends('layouts.master')

@push('styles')
    <!-- Call css style -->
    <link rel="stylesheet" href="{{ asset('css/admin_css/pawnItem-show.css') }}">
@endpush

<!-- start code @yield('content') -->
@section('content')
    <div class="pawn-container-wrapper">

        <!-- Button Back -->
        <a href="{{ route('pawnItem') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> <span class="khmer-os">ត្រឡប់ក្រោយ</span> / Back to Directory
        </a>

        <!-- Green success alert after payment -->
        @if(session('success'))
            <div
                style="background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 14px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="show-wrapper">

            <!-- Left Sticky Panel: Customer photo and name -->

            <div class="sticky-card">
                <div class="photo-preview-container">
                    @if($item->item_photo)
                        <img src="{{ asset('storage/' . $item->item_photo) }}" class="preview-photo" alt="Item Photo">
                    @else
                        <div class="no-photo-box">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="khmer-os">មិនមានរូបថតទំនិញទេ</span>
                        </div>
                    @endif
                </div>

                <h2 class="meta-title">{{ $item->item_name }}</h2>
                <p class="meta-subtitle">ID: #P-{{ $item->id }}</p>

                <div class="stats-summary">
                    <div class="stats-row">
                        <span class="khmer-os">ឈ្មោះអតិថិជន / Client</span>
                        <strong>{{ $item->customer->customer_name ?? 'N/A' }}</strong>
                    </div>
                    <div class="stats-row">
                        <span class="khmer-os">ប្រាក់កម្ចី / Loan</span>
                        <strong style="color: #16a34a;">${{ number_format($item->approved_loan, 2) }}</strong>
                    </div>
                    <div class="stats-row">
                        <span class="khmer-os">អត្រាការប្រាក់ / Rate</span>
                        <strong>{{ $item->monthly_interest_rate ?? $item->interest_rate }}% / <span
                                class="khmer-os">ខែ</span></strong>
                    </div>
                    <div class="stats-row">
                        <span class="khmer-os">ទីតាំងរក្សាទុក / Safe</span>
                        <strong>{{ $item->storage_location }}</strong>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Auto monthly interest table with dates -->

            <div class="content-card">
                <h3 class="section-heading-show">
                    <i class="fa-solid fa-calendar-days" style="color: #0b2240;"></i>
                    <span class="khmer-os">កាលវិភាគបង់ប្រាក់ការប្រាក់ប្រចាំខែ</span> / Payment Schedule
                </h3>

                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th><span class="khmer-os">វគ្គ/ខែទី</span> (Term)</th>
                            <th><span class="khmer-os">ថ្ងៃត្រូវបង់ជាក់លាក់</span> (Due Date)</th>
                            <th><span class="khmer-os">ប្រាក់ការត្រូវបង់</span> (Interest Amount)</th>
                            <th><span class="khmer-os">ស្ថានភាព</span> (Status)</th>
                            <th><span class="khmer-os">ថ្ងៃបានបង់ពិតប្រាកដ</span> (Paid Date)</th>
                            <th style="text-align: center;"><span class="khmer-os">សកម្មភាព</span> (Action)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($item->paymentSchedules as $schedule)
                            <tr>
                                <td><strong>Term {{ $schedule->term_number }}</strong></td>
                                <!-- បង្ហាញកាលបរិច្ឆេទច្បាស់លាស់កំណត់រៀងរាល់ខែ -->
                                <td style="font-weight: 600; color: #0f172a;">
                                    {{ \Carbon\Carbon::parse($schedule->due_date)->format('Y-M-d') }}
                                </td>

                               
                                <td style="font-weight: 600; color: #ea580c;">
                                    @php
                                        // រូបមន្ត៖ ប្រាក់ដើមដែលបានអនុម័ត (Approved Loan) × អត្រាការប្រាក់ (Interest Rate) ÷ 100
                                        $calculatedInterest = $item->approved_loan * (($item->monthly_interest_rate ?? $item->interest_rate) / 100);
                                    @endphp
                                    <!-- បង្ហាញទឹកប្រាក់ និងកាត់ក្បៀសកន្ទុយ .00 ស្អាតល្អ -->
                                    ${{ number_format($calculatedInterest, 2) }}
                                </td>
                                

                                <td>
                                    <span
                                        class="badge-status {{ $schedule->status == 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                                        {{ $schedule->status == 'paid' ? 'Paid / បានបង់រួច' : 'Unpaid / មិនទាន់បង់' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $schedule->paid_date ? \Carbon\Carbon::parse($schedule->paid_date)->format('Y-M-d') : '—' }}
                                </td>
                                <td style="text-align: center;">
                                    @if($schedule->status == 'unpaid')
                                        <!-- ហ្វមប៊ូតុងសម្រាប់ចុចបង់ប្រាក់ប្តូរស្ថានភាពទៅជា Paid -->
                                        <form action="{{ route('paymentSchedule.pay', $schedule->id) }}" method="POST"
                                            style="margin:0;">
                                            @csrf
                                            <button type="submit" class="pay-action-btn khmer-os">
                                                <i class="fa-solid fa-check"></i> ចុចបង់ប្រាក់
                                            </button>
                                        </form>
                                    @else
                                        <span class="success-msg-label">
                                            <i class="fa-solid fa-circle-check"></i> រួចរាល់ (Success)
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px 10px;">
                                    <span class="khmer-os">មិនទាន់មានកាលវិភាគបង់ប្រាក់នៅឡើយទេ / No schedules generated.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
@endsection