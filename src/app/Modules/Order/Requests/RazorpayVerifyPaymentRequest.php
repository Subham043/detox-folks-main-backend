<?php

namespace App\Modules\Order\Requests;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Http\Services\RazorpayService;
use App\Modules\Order\Models\Order;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;


class RazorpayVerifyPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Order::with([
            'products',
            'charges',
            'statuses',
            'payment',
        ])->whereHas('payment', function($qry){
            $qry->where('mode', PaymentMode::RAZORPAY)->where('status', PaymentStatus::PENDING)->where('razorpay_order_id', $this->razorpay_order_id);
        })->findOrFail($this->route('order_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    $verify_signature = (new RazorpayService)->payment_verify($this->safe()->only(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature']));
                    if (!$verify_signature) {
                        $fail("Payment verification failed.");
                    }
                },
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = Purify::clean(
            $this->validated()
        );
        $this->replace(
            [...$request]
        );
    }
}
