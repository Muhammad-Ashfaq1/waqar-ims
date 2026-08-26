<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationDepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $locations = Location::active()->with('departments')->orderBy('name')->get();
        $selectedLocationId = $request->integer('location_id');

        return view('locationDepartment', [
            'locations' => $locations,
            'selectedLocationId' => $selectedLocationId,
        ]);
    }

    public function create(Request $request): View
    {
        $locations = Location::active()->with('departments')->orderBy('name')->get();
        $departments = Department::orderBy('dep_name')->get();
        $selectedLocationId = $request->integer('location_id') ?: old('location_id');

        $locationDepartmentMap = $locations->mapWithKeys(function (Location $loc) {
            return [$loc->id => $loc->departments->pluck('id')->all()];
        })->all();

        return view('addLocationDepartment', [
            'locations' => $locations,
            'departments' => $departments,
            'locationDepartmentMap' => $locationDepartmentMap,
            'selectedLocationId' => $selectedLocationId,
        ]);
    }

    public function edit($id): View
    {
        $location = Location::findOrFail($id);
        $locations = Location::active()->with('departments')->orderBy('name')->get();
        $departments = Department::orderBy('dep_name')->get();

        $locationDepartmentMap = $locations->mapWithKeys(function (Location $loc) {
            return [$loc->id => $loc->departments->pluck('id')->all()];
        })->all();

        return view('addLocationDepartment', [
            'locations' => $locations,
            'departments' => $departments,
            'locationDepartmentMap' => $locationDepartmentMap,
            'selectedLocationId' => $location->id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
            'department_ids' => ['nullable', 'array'],
            'department_ids.*' => ['exists:departments,id'],
        ]);

        $location = Location::findOrFail($data['location_id']);
        $departmentIds = $data['department_ids'] ?? [];

        $location->departments()->sync($departmentIds);

        $count = count($departmentIds);
        toastr()->closeButton(true)->addSuccess("Successfully updated departments for '{$location->name}' ({$count} assigned).");

        return redirect('location-departments');
    }
}
