@extends('frontend.layouts.master')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            <!-- Sidebar -->
            @include('frontend.profile.sidebar')

            <!-- Content -->
            <div class="profile-content">
                <div class="content-header d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ trans_db('frontend.My Addresses') }}</h3>
                        <p>{{ trans_db('frontend.Manage your delivery addresses') }}</p>
                    </div>
                    <button class="add-address-btn" onclick="toggleAddressForm()">
                        <i class="fa-solid fa-plus"></i> {{ trans_db('frontend.Add New Address') }}
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Add/Edit Address Form (Hidden by default) -->
                <div id="addressFormSection" style="display: none; margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h4 id="formTitle">{{ trans_db('frontend.Add New Address') }}</h4>
                    <form id="addressForm" action="{{ route('frontend.user.addresses.store') }}" method="POST" class="profile-form">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ trans_db('frontend.Recipient Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ trans_db('frontend.Phone Number') }}</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="governorate_id">{{ trans_db('frontend.Governorate') }}</label>
                                    <select id="governorate_id" name="governorate_id" class="form-control" required onchange="loadCities(this.value)">
                                        <option value="">{{ trans_db('frontend.Select Governorate') }}</option>
                                        @foreach($governorates as $gov)
                                            <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id">{{ trans_db('frontend.City') }}</label>
                                    <select id="city_id" name="city_id" class="form-control" required>
                                        <option value="">{{ trans_db('frontend.Select City') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">{{ trans_db('frontend.Detailed Address') }}</label>
                                    <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <input type="checkbox" id="is_main" name="is_main" value="1" style="width: 20px; height: 20px;">
                                    <label for="is_main" style="margin-bottom: 0;">{{ trans_db('frontend.Set as Default Address') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions d-flex gap-2">
                            <button type="submit" class="save-btn">{{ trans_db('frontend.Save Address') }}</button>
                            <button type="button" class="cancel-btn" onclick="toggleAddressForm()">{{ trans_db('frontend.Cancel') }}</button>
                        </div>
                    </form>
                </div>

                <!-- Addresses List -->
                <div class="addresses-grid">
                    @forelse($addresses as $address)
                        <div class="address-card {{ $address->is_main ? 'is-main' : '' }}">
                            @if($address->is_main)
                                <span class="badge-main"><i class="fa-solid fa-check-circle"></i> {{ trans_db('frontend.Default') }}</span>
                            @endif
                            <div class="address-details">
                                <h5>{{ $address->name }}</h5>
                                <p><i class="fa-solid fa-phone"></i> {{ $address->phone }}</p>
                                <p><i class="fa-solid fa-location-dot"></i> {{ $address->governorate_rel->name ?? 'Governorate' }}, {{ $address->city_rel->name ?? 'City' }}</p>
                                <p class="detailed-address">{{ $address->address }}</p>
                            </div>
                            <div class="address-actions">
                                @if(!$address->is_main)
                                    <form action="{{ route('frontend.user.addresses.set_main', ['id' => $address->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action main-btn" title="{{ trans_db('frontend.Set as Default') }}">
                                            <i class="fa-solid fa-star"></i>
                                        </button>
                                    </form>
                                @endif
                                <button class="btn-action edit-btn" onclick="editAddress({{ $address }})" title="{{ trans_db('frontend.Edit') }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form action="{{ route('frontend.user.addresses.delete', ['id' => $address->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ trans_db('frontend.Are you sure?') }}')">
                                    @csrf
                                    <button type="submit" class="btn-action delete-btn" title="{{ trans_db('frontend.Delete') }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <p>{{ trans_db('frontend.No addresses found. Add your first address to start ordering.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.profile.partials.styles')
<style>
    /* Address Specific Styles */
    .add-address-btn { background: #1E5631; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
    .add-address-btn:hover { background: #4C825D; }

    .addresses-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
    .address-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; position: relative; transition: all 0.3s; background: white; }
    .address-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .address-card.is-main { border-color: #1E5631; background: rgba(30, 86, 49, 0.02); }
    
    .badge-main { position: absolute; top: 1rem; right: 1rem; background: #1E5631; color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    html[dir="rtl"] .badge-main { right: auto; left: 1rem; }

    .address-details h5 { margin: 0 0 1rem; color: #2d3748; font-weight: 700; }
    .address-details p { margin: 0 0 0.5rem; color: #718096; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
    .detailed-address { margin-top: 1rem !important; color: #4a5568 !important; line-height: 1.5; }

    .address-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; border-top: 1px solid #f1f5f9; padding-top: 1rem; }
    .btn-action { width: 32px; height: 32px; border-radius: 6px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .main-btn { background: #fef3c7; color: #d97706; }
    .main-btn:hover { background: #d97706; color: white; }
    .edit-btn { background: #e0f2fe; color: #0284c7; }
    .edit-btn:hover { background: #0284c7; color: white; }
    .delete-btn { background: #fee2e2; color: #dc2626; }
    .delete-btn:hover { background: #dc2626; color: white; }

    .empty-state { text-align: center; padding: 3rem; color: #a0aec0; grid-column: 1 / -1; }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }

    .form-control { border: 2px solid #e2e8f0; border-radius: 10px; padding: 0.75rem; }
    .form-control:focus { border-color: #1E5631; box-shadow: none; }
    .cancel-btn { background: #e2e8f0; color: #4a5568; border: none; padding: 0.8rem 1.5rem; border-radius: 10px; font-weight: 600; cursor: pointer; }
</style>

<script>
    function toggleAddressForm() {
        const section = document.getElementById('addressFormSection');
        const form = document.getElementById('addressForm');
        const method = document.getElementById('formMethod');
        const title = document.getElementById('formTitle');
        
        if (section.style.display === 'none') {
            section.style.display = 'block';
            form.reset();
            method.value = 'POST';
            form.action = "{{ route('frontend.user.addresses.store') }}";
            title.innerText = "{{ trans_db('frontend.Add New Address') }}";
            document.getElementById('city_id').innerHTML = '<option value="">{{ trans_db("frontend.Select City") }}</option>';
        } else {
            section.style.display = 'none';
        }
    }

    function editAddress(address) {
        const section = document.getElementById('addressFormSection');
        const form = document.getElementById('addressForm');
        const method = document.getElementById('formMethod');
        const title = document.getElementById('formTitle');
        
        section.style.display = 'block';
        title.innerText = "{{ trans_db('frontend.Edit Address') }}";
        method.value = 'PUT';
        form.action = "{{ route('frontend.user.addresses.update', ['id' => 0]) }}".replace('/0', '/' + address.id);
        
        document.getElementById('name').value = address.name;
        document.getElementById('phone').value = address.phone;
        document.getElementById('governorate_id').value = address.governorate_id;
        document.getElementById('address').value = address.address;
        document.getElementById('is_main').checked = address.is_main;
        
        loadCities(address.governorate_id, address.city_id);
        
        window.scrollTo({ top: section.offsetTop - 100, behavior: 'smooth' });
    }

    async function loadCities(govId, selectedCityId = null) {
        if (!govId) return;
        const citySelect = document.getElementById('city_id');
        citySelect.innerHTML = '<option value="">{{ trans_db("frontend.Loading...") }}</option>';
        
        try {
            const url = "{{ route('frontend.user.get_cities_by_gov', ['governorate_id' => 0]) }}".replace('/0', '/' + govId);
            const response = await fetch(url);
            const data = await response.json();
            
            citySelect.innerHTML = '<option value="">{{ trans_db("frontend.Select City") }}</option>';
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.text = city.name;
                if (selectedCityId && city.id == selectedCityId) {
                    option.selected = true;
                }
                citySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading cities:', error);
            citySelect.innerHTML = '<option value="">{{ trans_db("frontend.Error loading cities") }}</option>';
        }
    }
</script>
@endsection
