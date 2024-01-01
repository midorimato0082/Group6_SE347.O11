<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class HasRightCreateSuperAdmin implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Auth::user()->role->name !== 'Super Admin' && $value === 'Super Admin') {
            $fail('Bạn không có quyền tạo Super Admin.');
        }
    }
}
