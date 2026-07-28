<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\ApiV1\Contact\ContactStoreRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group 22. تواصل معنا (Contact Us)
 * 
 * يتولى استقبال وتخزين رسائل واستفسارات المستخدمين والزوار من نموذج اتصل بنا.
 */
class ContactController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * إرسال رسالة تواصل معنا
     * 
     * ينشئ ويحفظ رسالة جديدة من المستخدم المشتملة على الاسم، البريد، رقم التواصل، والموضوع.
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
