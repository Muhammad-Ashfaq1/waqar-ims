<?php

namespace App\Http\Requests;

use App\Enums\LocationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('slug')) {
            $this->merge([
                'slug' => $this->readableSlug($this->input('slug')),
            ]);
        } elseif ($this->filled('name')) {
            $this->merge([
                'slug' => $this->readableSlug($this->input('name')),
            ]);
        }
    }

    private function readableSlug(string $value): string
    {
        return (string) str($value)
            ->trim()
            ->replaceMatches('/\s+/', '-')
            ->replaceMatches('/[^A-Za-z0-9\-]/', '')
            ->replaceMatches('/-+/', '-')
            ->trim('-');
    }

    public function rules(): array
    {
        $locationId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('locations', 'name')->ignore($locationId),
            ],
            'slug' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('locations', 'slug')->ignore($locationId),
            ],
            'location_type' => ['required', new Enum(LocationType::class)],
            'is_active' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Location name is required',
            'name.min' => 'Location name must be at least 2 characters',
            'name.max' => 'Location name must not exceed 255 characters',
            'name.unique' => 'This location name already exists',
            'slug.required' => 'Slug is required',
            'slug.min' => 'Slug must be at least 2 characters',
            'slug.max' => 'Slug must not exceed 255 characters',
            'slug.unique' => 'This slug already exists',
            'location_type.required' => 'Please select a location type',
            'location_type.enum' => 'Please select a valid location type',
            'is_active.required' => 'Please select a status',
            'is_active.in' => 'Please select a valid status',
        ];
    }
}
