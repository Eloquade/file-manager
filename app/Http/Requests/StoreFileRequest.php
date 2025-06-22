<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Http\Requests\ParentIdBaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File as FileRule;


class StoreFileRequest extends ParentIdBaseRequest
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

    protected function prepareForValidation()
    {
        $paths = array_filter($this->relative_path ?? [], fn($f) => $f !== null);

        $this->merge([
            'file_path' => $paths,
            'folder_name' => $this->detectFolderName($paths),
        ]);
    }

    protected function passedValidation()
    {

        $data = $this->validated();
        $this->replace([
            'file_tree' => $this->buildFileTree($this->file_path, $data['files'])

        ]);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'files' => ['required', 'array'],
            'files.*' => [
                'file',
                function ($attribute, $value, $fail) {

                    if (!$this->folder_name) {
                        $originalName = $value->getClientOriginalName();

                        $fileExists = File::query()
                            ->where('name', $originalName)
                            ->where('created_by', Auth::id())
                            ->where('parent_id', $this->input('parent_id'))
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($fileExists) {
                            $fail("File '$originalName' already exists in this folder.");
                        }
                    }

                }
            ],
            'folder_name' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $file = File::query()
                            ->where('name', $value)
                            ->where('created_by', Auth::id())
                            ->where('parent_id', $this->input('parent_id'))
                            ->whereNull('deleted_at')
                            ->first();
                        if ($file) {
                            $fail("Folder '$value' already exists in this folder.");
                        }
                    }
                }
            ]
        ]);
    }

    public function detectFolderName($paths)
    {
        if (!$paths) {
            return null;
        }
        $parts = explode('/', $paths[0]);

        return $parts[0];

    }

    private function buildFileTree($filePaths, $files)
    {
        $filePaths = array_slice($filePaths, 0, count($files));
        $filePaths = array_filter($filePaths, fn($f) => $f !== null);

        $tree = [];
        foreach ($filePaths as $index => $path) {
            explode('/', $filePaths);
            $currentNode = &$tree;

            foreach ($path as $i => $part) {
                if (!isset($currentNode[$part])) {
                    $currentNode[$part] = [];
                }


                if ($i == count($part) - 1) {
                    $currentNode[$part] = $files[$index];
                } else {
                    $currentNode = &$currentNode[$part];
                }
            }
        }

        return $tree;
    }
}
