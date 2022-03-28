<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TicketStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ticket_type' => ['required', Rule::in(array_keys(Ticket::$deviceTypes))],
            'other_ticket_type' => [Rule::requiredIf($this->get('ticket_type') == 4)],
            'employee_name' => 'required|string|max:255',
            'department_id' => 'required',
            'priority' => ['required', Rule::in(array_keys(Ticket::$ticketPriority))],
            'details' => 'required|string',
            'technician' => ['required', Rule::exists('users', 'id')],
        ];
    }

    public function attributes(): array
    {
        return [
            'ticket_type' => 'نوع البلاغ',
            'other_ticket_type' => 'النوع مطلوب',
            'employee_name' => 'إسم الموظف',
            'department_id' => 'الإدارة',
            'priority' => 'الأولوية',
            'details' => 'تفاصيل البلاغ',
            'technician' => 'الفني',
        ];
    }
}
