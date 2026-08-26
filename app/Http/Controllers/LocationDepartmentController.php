<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationDepartmentController extends Controller
{
    public function create(): View
    {
        return view('locationDepartment', [
            'locations' => Location::active()->orderBy('name')->get(),
            'departments' => Department::orderBy('dep_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'location_id' => ['required', 'exists:locations,id'],
            'department_id' => ['required', 'exists:departments,id'],
        ]);

        $location = Location::findOrFail($data['location_id']);
        $attached = $location->departments()->syncWithoutDetaching([$data['department_id']]);

        if ($attached) {
            toastr()->closeButton(true)->addSuccess('Department has been linked to the location.');
        } else {
            toastr()->info('This department is already linked to the location.');
        }

        return redirect('location-departments');
    }
}
