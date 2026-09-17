@extends('layouts.master')

<!-- បាញ់ហ្វាយ CSS របស់ Dashboard ទៅកាន់ក្បាលរបស់ Master Layout -->
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin_css/dashboard.css') }}">
@endpush

@section('content')
    <!-- ជួរប្រអប់រាប់សរុប (Top Cards) -->
    <div class="top-cards">
        <!-- Card 1: Total Customers -->
        <div class="card" style="border: 1px solid #2563eb;">
            <div class="icon-circle blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="card-info">
                <span>Total Customers</span>
                <h3>{{ number_format($totalCustomers) }}</h3>
            </div>
        </div>

        <!-- Card 2: Active Pawn Items -->
        <div class="card" style="border: 1px solid #16a34a;">
            <div class="icon-circle green">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div class="card-info">
                <span>Active Pawn Items</span>
                <h3>{{ number_format($activePawnItems) }}</h3>
            </div>
        </div>

        <!-- Card 3: Total Loan Amount -->
        <div class="card" style="border: 1px solid #7c3aed;">
            <div class="icon-circle purple">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <span>Total Loan Amount</span>
                <h3>${{ number_format($totalLoanAmount, 2) }}</h3>
            </div>
        </div>

        <!-- Card 4: Total Interest Earned -->
        <div class="card" style="border: 1px solid #ea580c;">
            <div class="icon-circle orange">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div class="card-info">
                <span>Total Interest Earned</span>
                <h3>$12,580</h3>
            </div>
        </div>
    </div>


    <!-- ===================================================================================================================== -->


    <!-- Selection Data -->
    <div class="dashboard-grid">

        <!-- 1. Loan Overview Card -->
        <div class="grid-card">
            <div class="card-header">
                <h3>Loan Overview <span class="subtitle">(This Month)</span></h3>
            </div>
            <div class="chart-placeholder">
                <!-- Your line chart canvas goes here -->
                <p style="color: #94a3b8; font-size: 0.875rem;">[ Line Chart Container ]</p>
            </div>
        </div>

        <!-- 2. Pawn Items by Category Card -->
        <div class="grid-card">
            <div class="card-header">
                <h3>Pawn Items by Category</h3>
            </div>
            <div class="donut-container">
                <div class="chart-placeholder circle">
                    <!-- Your donut chart canvas goes here -->
                    <div class="donut-center">
                        <strong>2,843</strong>
                        <span>Items</span>
                    </div>
                </div>
                <div class="category-legend">
                    <div class="legend-item"><span class="dot blue"></span> Gold <span class="count">1,124 (39.5%)</span>
                    </div>
                    <div class="legend-item"><span class="dot dark-blue"></span> Phone <span class="count">856
                            (30.1%)</span></div>
                    <div class="legend-item"><span class="dot orange"></span> Jewelry <span class="count">542 (19.1%)</span>
                    </div>
                    <div class="legend-item"><span class="dot red"></span> Vehicle <span class="count">221 (7.8%)</span>
                    </div>
                    <div class="legend-item"><span class="dot purple"></span> Other <span class="count">100 (3.5%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Recent Activity Card -->
        <div class="grid-card">
            <div class="card-header">
                <h3>Recent Activity</h3>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon green"><i class="fa-solid fa-user-plus"></i></div>
                    <div class="activity-details">
                        <h4>New Customer Added</h4>
                        <span>Today, 10:30 AM</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon blue"><i class="fa-solid fa-briefcase"></i></div>
                    <div class="activity-details">
                        <h4>Pawn Item Added</h4>
                        <span>Today, 09:45 AM</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon orange"><i class="fa-solid fa-file-invoice"></i></div>
                    <div class="activity-details">
                        <h4>Loan Contract Created</h4>
                        <span>Today, 09:20 AM</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon emerald"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div class="activity-details">
                        <h4>Payment Received</h4>
                        <span>Today, 08:15 AM</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon purple"><i class="fa-solid fa-hand-holding-hand"></i></div>
                    <div class="activity-details">
                        <h4>Item Redeemed</h4>
                        <span>Yesterday, 04:40 PM</span>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <!-- =========================================================================================== -->





    <div class="dashboard-bottom-grid">

    
        <!-- Recent Pawn Items Table Card -->
        <div class="grid-card">
            <div class="card-header">
                <h3>Recent Pawn Items</h3>
                <!-- Link button directly to the main pawn item directory page -->
                <a href="{{ route('pawnItem') }}" class="view-all-btn" style="text-decoration: none;">View All</a>
            </div>

            <div class="table-container">
                <table class="pawn-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Customer</th>
                            <th>Loan Amount</th>
                            <th>Date</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 1. Start dynamic database collection loop -->
                        @forelse($recentPawnItems as $item)
                            <!-- Clickable row links to specific schedule details page -->
                            <tr onclick="window.location='{{ route('pawnItem.show', $item->id) }}'" style="cursor: pointer;">
                                <!-- Format primary key digits into consistent prefix formats -->
                                <td class="id-text">PWN{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>

                                <!-- Display category matching dynamic visual icons -->
                                <td class="item-name">
                                    <span class="item-icon">
                                        @if($item->category == 'electronics') 
                                        @elseif($item->category == 'jewelry') 
                                        @elseif($item->category == 'vehicle') 
                                        @else 
                                        @endif
                                    </span>
                                    {{ $item->item_name }}
                                </td>

                                <!-- Fetch active relationship owner names cleanly -->
                                <td>{{ $item->customer->customer_name ?? 'N/A' }}</td>

                                <!-- Print current primary active values with decimal filters -->
                                <td class="amount">$ {{ number_format($item->approved_loan, 0) }}</td>

                                <!-- Format timestamp logs into clean readability views -->
                                <td>{{ \Carbon\Carbon::parse($item->pawn_date)->format('d/m/Y') }}</td>

                                <!-- Display dynamic status class badge components based on data -->
                                <td class="status-cell">
                                    <span class="badge {{ strtolower($item->item_status ?? $item->status) }}">
                                        {{ ucfirst($item->item_status ?? $item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <!-- 2. Fallback row displays when no database history is discovered -->
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px 10px;">
                                    No recent pawn entries recorded in the system logs.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <!-- 2. Loan Status Summary Card -->
        <div class="grid-card">
            <div class="card-header">
                <h3>Loan Status Summary</h3>
            </div>

            <div class="summary-list">
                <!-- Active Progress Item -->
                <div class="summary-item">
                    <div class="summary-info">
                        <span class="status-label">Active</span>
                        <span class="status-count">1,826 <span class="pct">(70%)</span></span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill active-bar" style="width: 70%;"></div>
                    </div>
                </div>

                <!-- Redeemed Progress Item -->
                <div class="summary-item">
                    <div class="summary-info">
                        <span class="status-label">Redeemed</span>
                        <span class="status-count">642 <span class="pct">(24.6%)</span></span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill redeemed-bar" style="width: 24.6%;"></div>
                    </div>
                </div>

                <!-- Overdue Progress Item -->
                <div class="summary-item">
                    <div class="summary-info">
                        <span class="status-label">Overdue</span>
                        <span class="status-count">187 <span class="pct">(7.2%)</span></span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill overdue-bar" style="width: 7.2%;"></div>
                    </div>
                </div>

                <!-- Cancelled Progress Item -->
                <div class="summary-item">
                    <div class="summary-info">
                        <span class="status-label">Cancelled</span>
                        <span class="status-count">45 <span class="pct">(1.2%)</span></span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill cancelled-bar" style="width: 1.2%;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection