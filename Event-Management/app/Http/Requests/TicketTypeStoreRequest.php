<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TicketTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'ticket_type_name' => 'required|string|max:255',
            'available_quantity' => 'required|integer|min:0',
            'sold_quantity' => 'required|integer',
            'value' => 'required|numeric',
            'description' => 'required|string|max:600',
            'sale_start_date' => 'required|date',
            'sale_end_date' => 'required|date|after:sale_start_date',
            'purchase_limit' => 'required|integer',

        ];
    }

    public function withValidator(Validator $validator)
    {

        $validator->after(function ($validator) {
            $availableQuantity = $this->input('available_quantity');
            $soldQuantity = $this->input('sold_quantity');

            if ($availableQuantity < $soldQuantity) {
                $validator->errors()->add('available_quantity', 'Available quantity cannot be less than sold quantity.');
            }
        });
    }
}
