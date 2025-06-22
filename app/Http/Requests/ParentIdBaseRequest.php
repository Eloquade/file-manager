<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use App\Models\File;

class ParentIdBaseRequest extends FormRequest
{
    /**
     * The parent folder instance (if applicable).
     */
    public ?File $parent = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->parent = File::query()
            ->where('id', $this->input('parent_id'))
            ->first();

        // If parent exists, ensure the user owns it
        if ($this->parent && !$this->parent->isOwnedBy(Auth::id())) {
            return false;
        }

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
            'parent_id' => [
                Rule::exists('files', 'id')->where(function (Builder $query) {
                    $query->where('is_folder', 1)
                          ->where('created_by', Auth::id());
                }),
            ],
        ];
    }
}
