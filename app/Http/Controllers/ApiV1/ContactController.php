<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\ApiV1\Contact\ContactStoreRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group General
 * 
 * APIs for contact us and general support.
 */
class ContactController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Contact Us
     * 
     * Store a new contact message.
     * 
     * @bodyParam name string required The name of the person. Example: John Doe
     * @bodyParam email string required The email address. Example: john@example.com
     * @bodyParam phone string ID of the person. Example: 01021456325
     * @bodyParam subject string The subject of the message. Example: Inquiry about products
     * @bodyParam message string required The message content. Example: I would like to know more about your services.
     */
    public function store(ContactStoreRequest $request)
    {

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return $this->successResponse($contact, 'تم استلام رسالتك بنجاح، سنقوم بالرد عليك في أقرب وقت');
    }
}
