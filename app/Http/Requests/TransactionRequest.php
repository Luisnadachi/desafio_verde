<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['integer', 'required', 'min:1'],
            'payer_id' => ['required', 'string', 'exists:wallets,id'],
            'payee_id' => ['required', 'string', 'exists:wallets,id'],
        ];
    }
}
