<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSendRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
            '_hp' => ['nullable', 'max:0'], // Honeypot field (must be empty)
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Please enter your name.'),
            'name.max' => __('Name must not exceed 100 characters.'),
            'email.required' => __('Please enter your email address.'),
            'email.email' => __('Please enter a valid email address.'),
            'message.required' => __('Please enter a message.'),
            'message.max' => __('Message must not exceed 2000 characters.'),
            '_hp.max' => __('Spam detected.'),
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // If honeypot field is filled, silently redirect back
        if ($this->filled('_hp')) {
            \Log::warning('Honeypot triggered', [
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                '_hp' => $this->input('_hp'),
            ]);
            
            // Pretend success to confuse spam bots
            session()->flash('success', __('Thank you! We have received your message and will get back to you shortly.'));
            
            throw new \Illuminate\Validation\ValidationException(
                $validator,
                redirect()->back()->with('success', __('Thank you! We have received your message and will get back to you shortly.'))
            );
        }

        parent::failedValidation($validator);
    }

    /**
     * Get validated data with cleaned values.
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        
        // Remove honeypot from validated data
        unset($data['_hp']);
        
        return $data;
    }
}

