@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-container">
    
    @include('includes.breadcrumb', [
        'page_name' => 'Dashboard'
    ])

    <div class="row dashboard-row">
        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-bing dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_brands }}</p>
                        <p class="title">Total Brands</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-tags-fill dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_categories }}</p>
                        <p class="title">Total Categories</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-star-fill dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_products }}</p>
                        <p class="title">Total Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-row">
        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-arrow-bar-left dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_purchases_amount }}</p>
                        <p class="title">Total Purchases Amount</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-arrow-bar-right dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_sales_amount }}</p>
                        <p class="title">Total Sales Amount</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card dashboard-widget">
                <div class="card-body">
                    <div class="widget-icon">
                        <i class="bi bi-cash-coin dashboard-icon"></i>
                    </div>
                    
                    <div class="widget-info">
                        <p class="number">{{ $total_profit_amount }}</p>
                        <p class="title">Total Profit Amount</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection