@extends('dashboard.admin.layouts.app')

@section('style1')
<link rel="stylesheet" href="{{ asset('admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-fluid p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0 text-primary">{{ trans_db('dashboard.Broadcasting') }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ trans_db('dashboard.Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.broadcasts.index') }}">{{ trans_db('dashboard.Broadcasting') }}</a></li>
                                <li class="breadcrumb-item active">{{ trans_db('dashboard.New Campaign') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.broadcasts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Message Content -->
                    <div class="col-lg-8 col-md-12">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-transparent border-bottom">
                                <h4 class="card-title d-flex align-items-center">
                                    <i data-feather="edit-3" class="me-50 text-primary"></i>
                                    {{ trans_db('dashboard.Message Content') }}
                                </h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bolder">{{ trans_db('dashboard.Notification Title') }}</label>
                                    <input type="text" name="title" class="form-control form-control-lg shadow-sm" placeholder="Flash Sale: 50% Off Everything!" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bolder">{{ trans_db('dashboard.Message Content') }}</label>
                                    <textarea name="content" class="form-control shadow-sm" rows="5" placeholder="Write your message here..." required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label fw-bolder">{{ trans_db('dashboard.Upload Image (Optional)') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i data-feather="image"></i></span>
                                                <input type="file" name="image" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label fw-bolder">{{ trans_db('dashboard.Insert Link (Optional)') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i data-feather="link"></i></span>
                                                <input type="url" name="link" class="form-control" placeholder="https://example.com/sale">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Audience Selection -->
                        <div class="card shadow-lg border-0 mt-2">
                            <div class="card-header bg-transparent border-bottom">
                                <h4 class="card-title d-flex align-items-center">
                                    <i data-feather="users" class="me-50 text-primary"></i>
                                    {{ trans_db('dashboard.Audience Selection') }}
                                </h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="row custom-options-checkable g-2">
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="audience" value="all" id="audience_all" checked />
                                        <label class="custom-option-item p-2" for="audience_all">
                                            <span class="d-flex align-items-center">
                                                <span class="avatar avatar-xl bg-light-primary me-2">
                                                    <span class="avatar-content"><i data-feather="users" class="font-medium-5"></i></span>
                                                </span>
                                                <span>
                                                    <span class="custom-option-item-title h5 d-block fw-bolder mb-0">{{ trans_db('dashboard.All Customers') }}</span>
                                                    <small class="text-muted">Target everyone in your database</small>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="audience" value="new" id="audience_new" />
                                        <label class="custom-option-item p-2" for="audience_new">
                                            <span class="d-flex align-items-center">
                                                <span class="avatar avatar-xl bg-light-success me-2">
                                                    <span class="avatar-content"><i data-feather="user-plus" class="font-medium-5"></i></span>
                                                </span>
                                                <span>
                                                    <span class="custom-option-item-title h5 d-block fw-bolder mb-0">{{ trans_db('dashboard.New Customers') }}</span>
                                                    <small class="text-muted">Registered in the last 30 days</small>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="audience" value="returning" id="audience_returning" />
                                        <label class="custom-option-item p-2" for="audience_returning">
                                            <span class="d-flex align-items-center">
                                                <span class="avatar avatar-xl bg-light-info me-2">
                                                    <span class="avatar-content"><i data-feather="repeat" class="font-medium-5"></i></span>
                                                </span>
                                                <span>
                                                    <span class="custom-option-item-title h5 d-block fw-bolder mb-0">{{ trans_db('dashboard.Returning Customers') }}</span>
                                                    <small class="text-muted">Completed 2+ orders</small>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="audience" value="top_spenders" id="audience_top" />
                                        <label class="custom-option-item p-2" for="audience_top">
                                            <span class="d-flex align-items-center">
                                                <span class="avatar avatar-xl bg-light-warning me-2">
                                                    <span class="avatar-content"><i data-feather="trending-up" class="font-medium-5"></i></span>
                                                </span>
                                                <span>
                                                    <span class="custom-option-item-title h5 d-block fw-bolder mb-0">{{ trans_db('dashboard.Top Spenders') }}</span>
                                                    <small class="text-muted">Highest lifetime value</small>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Settings -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-transparent border-bottom">
                                <h4 class="card-title d-flex align-items-center">
                                    <i data-feather="layers" class="me-50 text-primary"></i>
                                    {{ trans_db('dashboard.Channel Selection') }}
                                </h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="mb-1">
                                    <div class="form-check form-check-inline mb-2 w-100 p-1 border rounded shadow-sm hover-shadow transition">
                                        <input class="form-check-input ms-1" type="checkbox" name="channels[]" value="website" id="channel_web" checked />
                                        <label class="form-check-label d-flex align-items-center w-100 ms-1" for="channel_web">
                                            <i data-feather="monitor" class="me-1 text-primary"></i> 
                                            <span class="fw-bolder">Website Notification</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline mb-2 w-100 p-1 border rounded text-muted shadow-sm" style="opacity: 0.8">
                                        <input class="form-check-input ms-1" type="checkbox" name="channels[]" value="email" id="channel_email" />
                                        <label class="form-check-label d-flex align-items-center w-100 ms-1" for="channel_email">
                                            <i data-feather="mail" class="me-1 text-secondary"></i>
                                            <span class="fw-bolder">Email Marketing</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline mb-1 w-100 p-1 border rounded text-muted shadow-sm" style="opacity: 0.6">
                                        <input class="form-check-input ms-1" type="checkbox" name="channels[]" value="sms" id="channel_sms" disabled />
                                        <label class="form-check-label d-flex align-items-center w-100 ms-1" for="channel_sms">
                                            <i data-feather="message-square" class="me-1 text-secondary"></i>
                                            <span class="fw-bolder">SMS Broadcast (Soon)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-lg border-0 mt-2">
                            <div class="card-header bg-transparent border-bottom">
                                <h4 class="card-title d-flex align-items-center">
                                    <i data-feather="clock" class="me-50 text-primary"></i>
                                    {{ trans_db('dashboard.Scheduling & Sending') }}
                                </h4>
                            </div>
                            <div class="card-body pt-2">
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" name="send_option" id="send_now" value="now" checked />
                                        <label class="form-check-label fw-bolder ms-1" for="send_now">
                                            {{ trans_db('dashboard.Send Immediately') }}
                                            <small class="d-block text-muted">Campaign will launch within 5 minutes</small>
                                        </label>
                                    </div>
                                    <div class="form-check custom-radio">
                                        <input class="form-check-input" type="radio" name="send_option" id="send_later" value="later" />
                                        <label class="form-check-label fw-bolder ms-1" for="send_later">
                                            {{ trans_db('dashboard.Schedule Sending') }}
                                            <small class="d-block text-muted">Pick a specific date and time</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="schedule_input" class="mb-3 d-none animate__animated animate__fadeIn">
                                    <label class="form-label fw-bolder">{{ trans_db('dashboard.Schedule Date & Time') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="text" name="schedule_at" class="form-control flatpickr-date-time" placeholder="YYYY-MM-DD HH:MM">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 shadow-primary">
                                    <i data-feather="send" class="me-50"></i> {{ trans_db('dashboard.Send Campaign') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-option-item-check { display: none; }
    .custom-option-item {
        cursor: pointer;
        border: 2px solid #ebe9f1;
        border-radius: 12px;
        transition: all 0.3s ease;
        display: block;
        background: #fff;
    }
    .custom-option-item:hover { border-color: #7367f0; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(115, 103, 240, 0.1); }
    .custom-option-item-check:checked + .custom-option-item {
        border-color: #7367f0;
        background-color: rgba(115, 103, 240, 0.04);
        box-shadow: 0 4px 12px rgba(115, 103, 240, 0.15);
    }
    .hover-shadow:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important; }
    .transition { transition: all 0.3s ease; }
    .fw-bolder { font-weight: 800; }
    .shadow-primary { box-shadow: 0 4px 14px 0 rgba(115, 103, 240, 0.4) !important; }
</style>
@endsection
@section('script')
<script src="{{ asset('admin/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Flatpickr
        if ($('.flatpickr-date-time').length) {
            $('.flatpickr-date-time').flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today"
            });
        }

        $('input[name="send_option"]').change(function() {
            if ($(this).val() == 'later') {
                $('#schedule_input').removeClass('d-none').addClass('animate__fadeIn');
            } else {
                $('#schedule_input').addClass('d-none');
            }
        });

        // Initialize Feather icons
        if (feather) {
            feather.replace();
        }
    });
</script>
@endsection

