<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Models\Issuance;
use App\Models\Location;
use App\Models\Stock;
use Throwable;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderByDesc('id')->get();

        return view('locationInfo', ['locations' => $locations]);
    }

    public function create()
    {
        return view('addLocation');
    }

    public function store(StoreLocationRequest $request)
    {
        try {
            Location::create([
                'name' => trim($request->input('name')),
                'slug' => $request->input('slug'),
                'location_type' => $request->input('location_type'),
                'is_active' => $request->boolean('is_active'),
            ]);

            toastr()->closeButton(true)->addSuccess('Location has been added successfully');

            return redirect('locationinfo');
        } catch (Throwable $e) {
            toastr()->error('Failed to add location. Please try again.');

            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $location = Location::find($id);

        if (! $location) {
            toastr()->error('Location not found');

            return redirect('locationinfo');
        }

        return view('updateLocation', ['location' => $location]);
    }

    public function update(StoreLocationRequest $request, $id)
    {
        $location = Location::find($id);

        if (! $location) {
            toastr()->error('Location not found');

            return redirect('locationinfo');
        }

        try {
            $location->update([
                'name' => trim($request->input('name')),
                'slug' => $request->input('slug'),
                'location_type' => $request->input('location_type'),
                'is_active' => $request->boolean('is_active'),
            ]);

            toastr()->closeButton(true)->addSuccess('Location has been updated successfully');

            return redirect('locationinfo');
        } catch (Throwable $e) {
            toastr()->error('Failed to update location. Please try again.');

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        $location = Location::find($id);

        if (! $location) {
            toastr()->error('Location not found');

            return redirect('locationinfo');
        }

        $usedInStock = Stock::where('location_id', $location->id)->exists();
        $usedInIssuance = Issuance::where('location_id', $location->id)->exists();

        if ($usedInStock || $usedInIssuance) {
            toastr()->error('This location is assigned to stock/issuance and cannot be deleted.');

            return redirect('locationinfo');
        }

        try {
            $location->forceDelete();
            toastr()->closeButton(true)->addSuccess('Location has been deleted successfully');
        } catch (Throwable $e) {
            toastr()->error('Failed to delete location. Please try again.');
        }

        return redirect('locationinfo');
    }
}
