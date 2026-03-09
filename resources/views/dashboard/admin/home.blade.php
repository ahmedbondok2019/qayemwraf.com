@extends('dashboard.admin.layouts.app')

@section('style')
    @include('dashboard.admin.layouts.style')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('style1')
    <link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/charts/apexcharts.css') }}">
@endsection

@section('style2')
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css-rtl/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
@endsection

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Tabs Start -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">{{ trans_db('dashboard.Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" aria-controls="orders" role="tab" aria-selected="false">{{ trans_db('dashboard.Orders') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" aria-controls="products" role="tab" aria-selected="false">{{ trans_db('dashboard.Products') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="customers-tab" data-toggle="tab" href="#customers" aria-controls="customers" role="tab" aria-selected="false">{{ trans_db('dashboard.Customers') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Tab 1: Home (Analytics & Charts) -->
                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                         <!-- Dashboard Analytics Start -->
                        <section id="dashboard-analytics">
                            <div class="row match-height">
                                <!-- Today's Sales -->
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ format_price($todaySales) }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Today Sales') }}</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="shopping-cart" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- This Month Sales -->
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ format_price($thisMonthSales) }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.This Month Sales') }}</p>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="dollar-sign" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Growth -->
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">
                                                    @if($growthDirection == 'up')
                                                        <span class="text-success"><i data-feather="trending-up"></i> {{ number_format($growth, 1) }}%</span>
                                                    @elseif($growthDirection == 'down')
                                                        <span class="text-danger"><i data-feather="trending-down"></i> {{ number_format($growth, 1) }}%</span>
                                                    @else
                                                        <span class="text-secondary"><i data-feather="minus"></i> 0%</span>
                                                    @endif
                                                </h2>
                                                <p class="card-text">{{ trans_db('dashboard.Growth vs Last Month') }}</p>
                                            </div>
                                            <div class="avatar bg-light-info p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="activity" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Dashboard Analytics End -->

                        <!-- Charts Section Start -->
                        <section id="dashboard-charts">
                            <div class="row match-height">
                                <!-- Sales Chart -->
                                <div class="col-lg-8 col-12">
                                    <div class="card">
                                        <div class="card-header align-items-start">
                                            <div>
                                                <h4 class="card-title mb-25">{{ trans_db('dashboard.Sales Overview') }} (30 Days)</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="sales-line-chart"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Category Pie Chart -->
                                <div class="col-lg-4 col-12">
                                    <div class="card">
                                        <div class="card-header align-items-start">
                                            <div>
                                                <h4 class="card-title mb-25">{{ trans_db('dashboard.Sales by Category') }}</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                             <div id="category-pie-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                 <!-- Orders Chart -->
                                <div class="col-12">
                                    <div class="card">
                                         <div class="card-header align-items-start">
                                            <div>
                                                <h4 class="card-title mb-25">{{ trans_db('dashboard.Orders Overview') }} (30 Days)</h4>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="orders-bar-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Charts Section End -->
                    </div>

                    <!-- Tab 2: Orders -->
                    <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                        <!-- Order & Profit Statistics Start (Profit moved here or kept in Home? User said 'Orders' tab) -->
                        <!-- Actually Profit is financial. Let's keep Profit in Home or Orders? -->
                        <!-- Let's put Order Counts + Status + Recent here. Profit is tricky. Let's put Profit in Home/Analytics or create a Finance tab? -->
                        <!-- For now, I'll duplicate Profit or move it. Let's move Order Statistics here. -->
                        
                        <section id="order-statistics">
                            <div class="row match-height">
                                 <!-- Today's Orders Count -->
                                 <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $todayOrdersCount }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Today Orders') }}</p>
                                            </div>
                                            <div class="avatar bg-light-warning p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="package" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Orders Count -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $totalOrdersCount }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Total Orders') }}</p>
                                            </div>
                                            <div class="avatar bg-light-secondary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="shopping-bag" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Profit (Put here for now as part of Order Stats block row originally) -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ format_price($totalProfit) }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Total Profits') }}</p>
                                                <small class="text-muted">{{ trans_db('dashboard.After Discount') }}</small>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="credit-card" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Order Status Counts Start -->
                        <section id="order-status-counts">
                            <div class="row match-height">
                                <!-- Processing -->
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $ordersProcessing }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Processing') }}</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="settings" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipped -->
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $ordersShipped }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Shipped') }}</p>
                                            </div>
                                            <div class="avatar bg-light-info p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="truck" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $ordersDelivered }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Delivered') }}</p>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="check-square" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cancelled -->
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $ordersCancelled }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Cancelled') }}</p>
                                            </div>
                                            <div class="avatar bg-light-danger p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="x-circle" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                        <!-- Recent Orders Start -->
                         <section id="recent-orders">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Recent Orders') }} (Last 10)</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover-animation">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans_db('dashboard.Order Number') }}</th>
                                                        <th>{{ trans_db('dashboard.Customer') }}</th>
                                                        <th>{{ trans_db('dashboard.Total') }}</th>
                                                        <th>{{ trans_db('dashboard.Status') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($latestOrders as $order)
                                                        <tr>
                                                            <td>
                                                                <a href=""class="font-weight-bold">#{{ $order->id }}</a>
                                                            </td>
                                                            <td>
                                                                {{ $order->user->name ?? __('Guest') }}
                                                            </td>
                                                            <td>{{ format_price($order->total) }}</td>
                                                            <td>
                                                                @php
                                                                    $status = $order->getOrderStatusAttribute();
                                                                @endphp
                                                                <span class="{{ $status[1] }}">{{ $status[0] }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Tab 3: Products -->
                    <div class="tab-pane" id="products" aria-labelledby="products-tab" role="tabpanel">
                        <section id="product-statistics">
                            <div class="row match-height">
                                <!-- Total Products -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $totalProducts }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Total Books') }}</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="book" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Available Products -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $availableProducts }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Available Books') }}</p>
                                            </div>
                                            <div class="avatar bg-light-success p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="check-circle" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Out of Stock Products -->
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $outOfStockProducts }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Unavailable Books') }}</p>
                                                <small class="text-danger">{{ trans_db('dashboard.Out of Stock') }}</small>
                                            </div>
                                            <div class="avatar bg-light-danger p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="alert-circle" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Top & Least Selling Products Start -->
                        <section id="product-performance">
                            <div class="row match-height">
                                <!-- Top Selling Books -->
                                <div class="col-lg-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Top Selling Books') }} (Top 5)</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover-animation">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ trans_db('dashboard.Book Name') }}</th>
                                                        <th>{{ trans_db('dashboard.Sold Copies') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($topSellingProducts as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                @if($item->product)
                                                                    {{ $item->product->translation->name ?? __('Unknown') }}
                                                                @else
                                                                    <span class="text-danger">{{ __('Deleted Product') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-pill badge-light-primary mr-1">{{ $item->total_sold }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Least Selling Books -->
                                <div class="col-lg-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Least Selling Books') }} (Bottom 5)</h4>
                                            <small class="text-muted">{{ trans_db('dashboard.Consider for Offers') }}</small>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover-animation">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ trans_db('dashboard.Book Name') }}</th>
                                                        <th>{{ trans_db('dashboard.Sold Copies') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leastSellingProducts as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                @if($item->product)
                                                                    {{ $item->product->translation->name ?? __('Unknown') }}
                                                                @else
                                                                    <span class="text-danger">{{ __('Deleted Product') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-pill badge-light-warning mr-1">{{ $item->total_sold }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                         <!-- Top Selling Categories Start -->
                        <section id="category-performance">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ trans_db('dashboard.Top Selling Categories') }}</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover-animation">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ trans_db('dashboard.Category Name') }}</th>
                                                        <th>{{ trans_db('dashboard.Total Sales') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($topSellingCategories as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>
                                                                <span class="badge badge-pill badge-light-success mr-1">{{ $item->total_sold }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Tab 4: Customers -->
                    <div class="tab-pane" id="customers" aria-labelledby="customers-tab" role="tabpanel">
                        <section id="customer-statistics">
                            <div class="row match-height">
                                <!-- Total Customers -->
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $totalCustomers }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.Total Customers') }}</p>
                                            </div>
                                            <div class="avatar bg-light-primary p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="users" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- New Customers This Month -->
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">{{ $newCustomersThisMonth }}</h2>
                                                <p class="card-text">{{ trans_db('dashboard.New Customers (Month)') }}</p>
                                            </div>
                                            <div class="avatar bg-light-info p-50 m-0">
                                                <div class="avatar-content">
                                                    <i data-feather="user-plus" class="font-medium-5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- Dashboard Tabs End -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@section('script')
  <script>
      $(window).on('load', function () {
          var $primary = '#7367F0';
          var $success = '#28C76F';
          var $danger = '#EA5455';
          var $warning = '#FF9F43';
          var $info = '#00cfe8';
          var $primary_light = '#A9A2F6';
          var $danger_light = '#f29292';
          var $success_light = '#55DD92';
          var $warning_light = '#ffc085';
          var $info_light = '#1fecff';

          // Chart Options
          var chartDates = {!! json_encode($chartDates ?? []) !!};
          var chartSales = {!! json_encode($chartSales ?? []) !!};
          var chartOrders = {!! json_encode($chartOrders ?? []) !!};
          var pieLabels = {!! json_encode($pieLabels ?? []) !!};
          var pieSeries = {!! json_encode($pieSeries ?? []) !!};

          // 1. Sales Line Chart
          var salesChartOptions = {
              chart: {
                  height: 300,
                  type: 'area', // or 'line'
                  toolbar: { show: false },
                  zoom: { enabled: false }
              },
              colors: [$primary],
              dataLabels: { enabled: false },
              stroke: { curve: 'smooth', width: 2 },
              series: [{
                  name: 'Sales',
                  data: chartSales
              }],
              xaxis: {
                  categories: chartDates,
                  type: 'datetime',
                  labels: { format: 'dd/MM' } 
              },
              yaxis: {
                  labels: {
                      formatter: function(val) {
                          return val; 
                      }
                  }
              },
              tooltip: {
                  x: { format: 'dd/MM/yy' },
              },
              fill: {
                  type: 'gradient',
                  gradient: {
                      shadeIntensity: 1,
                      opacityFrom: 0.7,
                      opacityTo: 0.25,
                      stops: [0, 80, 100]
                  }
              }
          };
          var salesChart = new ApexCharts(document.querySelector("#sales-line-chart"), salesChartOptions);
          salesChart.render();

          // 2. Category Pie Chart
          var categoryChartOptions = {
              chart: {
                  type: 'pie',
                  height: 320,
              },
              labels: pieLabels,
              series: pieSeries.map(Number), // Ensure numbers
              colors: [$primary, $warning, $danger, $success, $info],
              legend: {
                  position: 'bottom'
              },
              responsive: [{
                  breakpoint: 480,
                  options: {
                      chart: {
                          width: 200
                      },
                      legend: {
                          position: 'bottom'
                      }
                  }
              }]
          };
          var categoryChart = new ApexCharts(document.querySelector("#category-pie-chart"), categoryChartOptions);
          categoryChart.render();

          // 3. Orders Bar Chart
          var ordersChartOptions = {
              chart: {
                  height: 300,
                  type: 'bar',
                  toolbar: { show: false }
              },
              colors: [$info],
              plotOptions: {
                  bar: {
                      columnWidth: '50%',
                      endingShape: 'rounded'
                  }
              },
              dataLabels: { enabled: false },
              series: [{
                  name: 'Orders',
                  data: chartOrders
              }],
              xaxis: {
                  categories: chartDates,
                  type: 'datetime',
                  labels: { format: 'dd/MM' }
              }
          };
          var ordersChart = new ApexCharts(document.querySelector("#orders-bar-chart"), ordersChartOptions);
          ordersChart.render();

      });
  </script>
@endsection
