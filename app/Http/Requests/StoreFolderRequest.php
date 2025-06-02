<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ParentIdBaseRequest;
use App\Models\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class StoreFolderRequest extends ParentIdBaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('files')->where(function ($query) {
                    return $query->where('parent_id', $this->parent)
                        ->where('created_by', Auth::id());
                }),
            ],
            'parent' => [
                'nullable',
                'exists:files,id',
                'integer',
                Rule::exists('files', 'id')->where(function ($query) {
                    return $query->where('created_by', Auth::id());
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Folder with this name already exists in this location.'
        ];
    }
}
