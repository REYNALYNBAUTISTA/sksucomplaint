<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OfficeAccountController extends Controller
{
    /**
     * Show the form for creating a new Office and its primary Personnel account.
     * (This was missing in your code!)
     */
    public function create()
    {
        return view('admin.office_accounts.create');
    }

   public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'office_name' => ['required', 'string', 'max:255', 'unique:offices,name'],
            'name'      => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Database Transaction
        DB::transaction(function () use ($request) {

            // A. Create the Office Record
            $office = Office::create([
                'name' => $request->office_name,
            ]);

            // B. Create the Personnel Account
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'id_number' => $request->id_number,

                // ✅ CHANGED: Hardcoded to 2
                'role_id'      => 2,

                'office_id' => $office->id,
            ]);
        });

        // 3. Redirect
        return redirect()->route('admin.offices.index')
                         ->with('success', 'Office and Personnel account created successfully.');
    }

    /**
     * Display a listing of the offices.
     */
    public function index()
    {
        // Get offices and their associated personnel (users with office_id)
        $offices = Office::with('personnel')->orderBy('name')->paginate(10);
        return view('admin.offices.index', compact('offices'));
    }

    /**
     * Show the form for editing the specified office.
     */
public function edit(Office $office)
{
    // 1. Fetch all users who could potentially be office personnel
    $personnelOptions = User::where('role_id', Roles::OFFICE_PERSONNEL->value)
                     ->orderBy('name')
                     ->get();

    // 2. Fetch the currently assigned personnel for this office
    // We assume the primary personnel is the first one linked to this office.
    $currentPersonnel = $office->personnel()->first();

    return view('admin.offices.edit', compact('office', 'personnelOptions', 'currentPersonnel'));
}

    /**
     * Update the specified office in the database.
     */
    public function update(Request $request, Office $office)
{
    $currentPersonnel = $office->personnel()->first();

    // Base Validation Rules
    $rules = [
        // Office Validation
        'office_name' => ['required', 'string', 'max:255', 'unique:offices,name,' . $office->id],
        'description' => ['nullable', 'string', 'max:500'],

        // Personnel Validation (Only required if personnel exists)
        'personnel_name' => ['nullable', 'string', 'max:255'],
        'id_number' => ['nullable', 'string', 'max:20', 'unique:users,id_number,' . optional($currentPersonnel)->id],
        'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . optional($currentPersonnel)->id],
        'personnel_id_new' => ['nullable', 'exists:users,id'], // For reassigning
    ];

    // If we have current personnel AND fields were filled, make them required for update
    if ($currentPersonnel) {
        $rules['personnel_name'][] = 'required';
        $rules['id_number'][] = 'required';
        $rules['email'][] = 'required';
    }

    // Only validate password if the field is present
    if ($request->filled('password')) {
        $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
    }

    $request->validate($rules);

    // Use a transaction to ensure both records are updated or neither is.
    DB::transaction(function () use ($request, $office, $currentPersonnel) {

        // 1. Update the Office Record
        $office->update([
            'name' => $request->office_name,
            'description' => $request->description,
        ]);

        // 2. Handle Personnel Update/Reassignment
        $newPersonnelId = $request->personnel_id_new;

        if ($newPersonnelId && $newPersonnelId != optional($currentPersonnel)->id) {

            // --- Reassignment Logic ---

            // A. If the old personnel exists and is different, unassign them
            if ($currentPersonnel) {
                $currentPersonnel->update(['office_id' => null]);
            }

            // B. Assign the NEW selected Personnel to this Office
            $newPersonnel = User::find($newPersonnelId);
            if ($newPersonnel) {
                // Ensure the new personnel is linked to this office
                $newPersonnel->update([
                    'office_id' => $office->id,
                ]);
            }

        } elseif ($currentPersonnel) {

            // --- Existing Personnel Detail Update ---

            $userData = [
                'name' => $request->personnel_name,
                'email' => $request->email,
                'id_number' => $request->id_number,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $currentPersonnel->update($userData);
        }
    });

    return redirect()->route('admin.offices.index')
                     ->with('success', 'Office and Personnel details updated successfully.');
}

    /**
     * Remove the specified office from the database.
     */
    public function destroy(Office $office)
    {
        // Optional: Check if the office has assigned complaints or personnel before deleting
        $office->delete();

        return redirect()->route('admin.offices.index')
                         ->with('success', 'Office deleted successfully.');
    }
}
