<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Http\Requests\ApiV1\Address\AddressStoreRequest;
use App\Http\Requests\ApiV1\Address\AddressUpdateRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Resources\ApiV1\AddressResource;

/**
 * @group User Addresses
 * 
 * APIs for managing user addresses
 */
class UserAddressController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;
    /**
     * Get Addresses
     * 
     * Get all addresses for the authenticated user.
     * 
     * @authenticated
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $addresses = $request->user()->address()
            ->with(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])
            ->get();

        return $this->successResponse(AddressResource::collection($addresses));
    }

    /**
     * Add Address
     * 
     * Add a new address for the authenticated user.
     * 
     * @authenticated
     * @bodyParam name string required The name for the address (e.g., Home, Work). Example: Home
     * @bodyParam country_id int required The country ID. Example: 1
     * @bodyParam governorate_id int required The governorate ID. Example: 1
     * @bodyParam city_id int required The city ID. Example: 1
     * @bodyParam address string required The full address details. Example: 123 Street Name
     * @bodyParam phone string required Phone number for this address. Example: 01021456325
     * @bodyParam lat string Optional latitude. Example: 30.0444
     * @bodyParam lng string Optional longitude. Example: 31.2357
     * @bodyParam is_main boolean Set as main address. Example: 1
     */
    public function store(AddressStoreRequest $request)
    {

        // If this is set as main, unset others
        if ($request->is_main) {
            UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);
        }

        $address = $request->user()->address()->create($request->all());

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'Address added successfully');
    }

    /**
     * Update Address
     * 
     * Update an existing address.
     * 
     * @authenticated
     * @urlParam id int required The ID of the address. Example: 1
     */
    public function update(AddressUpdateRequest $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }

        if ($request->is_main) {
            UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);
        }

        $address->update($request->all());

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'Address updated successfully');
    }

    /**
     * Delete Address
     * 
     * Delete an address.
     * 
     * @authenticated
     * @urlParam id int required The ID of the address. Example: 1
     */
    public function destroy(\Illuminate\Http\Request $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }

        $address->delete();

        return $this->successResponse(null, 'Address deleted successfully');
    }

    /**
     * Set Main Address
     * 
     * Set a specific address as the main address for the user.
     * 
     * @authenticated
     * @urlParam id int required The ID of the address. Example: 1
     */
    public function setMain(\Illuminate\Http\Request $request, $id)
    {
        $address = $request->user()->address()->find($id);

        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }

        // Unset all other addresses as main
        UserAddress::where('user_id', $request->user()->id)->update(['is_main' => 0]);

        // Set this address as main
        $address->update(['is_main' => 1]);

        return $this->successResponse(new AddressResource($address->load(['country_rel.translation', 'governorate_rel.translation', 'city_rel.translation'])), 'Address set as main successfully');
    }
}
