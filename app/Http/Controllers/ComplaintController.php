<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteComplaintRequest;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use App\Models\Office; // Import the Request class
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ComplaintController extends Controller
{
    // Renders the Student Submission Form
    public function create()
    {
        // Fetch all offices for the dropdown menu
        $offices = Office::all(['id', 'name']);

        return view('complaint.create', [
            'offices' => $offices,
        ]);
    }

    // Handles the Form Submission
    public function store(StoreComplaintRequest $request)
{
    // 1. Handle File Upload
    $filePath = null;
    if ($request->hasFile('file_upload')) {
        $filePath = $request->file('file_upload')->store('complaints', 'public');
    }

    // 2. Create Complaint Record
    Complaint::create([
        'user_id' => Auth::id(),
        'subject' => $request->subject,
        'description' => $request->description,
        'file_path' => $filePath,

        // We store the student's suggestion, but we DO NOT assign it yet.
        'target_office_id' => $request->target_office_id,

        // This remains NULL so the Admin knows it needs routing
        'assigned_office_id' => null,

        // Status 1: Pending Admin Review
        'current_status_id' => 1,
    ]);

    // 3. Redirect
    return redirect()->route('dashboard')
                     ->with('status', 'Complaint filed! It is now pending review by the Administrator.');
}

    // Implement the index method (used by the student dashboard route)
    public function index()
    {
        // Students only see their own complaints
        $complaints = Complaint::where('user_id', Auth::id())
            ->with('currentStatus', 'targetOffice') // Eager load relationships
            ->latest()
            ->paginate(10);

        return view('dashboard', [
            'complaints' => $complaints,
        ]);
    }

    private function authorizePending(Complaint $complaint)
    {
        // 1. Check Ownership and Status
        if ($complaint->user_id !== Auth::id() || $complaint->current_status_id !== 1) {
            // Throw a 403 Forbidden error if conditions are not met
            abort(403, 'Unauthorized action. The complaint has already been processed or is not yours.');
        }
    }

    // Displays the Edit Form
    public function edit(Complaint $complaint)
    {
        $this->authorizePending($complaint); // Authorization check

        $offices = Office::all(['id', 'name']);

        return view('complaint.edit', [
            'complaint' => $complaint,
            'offices' => $offices,
        ]);
    }

    // Handles the Update Request
    public function update(StoreComplaintRequest $request, Complaint $complaint)
    {
        $this->authorizePending($complaint); // Authorization check

        // 1. Handle File Upload (Optional: If a new file is uploaded)
        $filePath = $complaint->file_path;
        if ($request->hasFile('file_upload')) {
            // Optional: Delete old file if one exists
            if ($filePath) {
                \Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file_upload')->store('complaints', 'public');
        }

        // 2. Update Complaint Record
        $complaint->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'target_office_id' => $request->target_office_id,
            'file_path' => $filePath,
            // current_status_id remains 1 (Pending)
        ]);

        return redirect()->route('dashboard')->with('status', 'Complaint C-'.$complaint->id.' has been successfully updated.');
    }

    // Handles the Deletion Request
    public function destroy(Complaint $complaint)
    {
        $this->authorizePending($complaint); // Authorization check

        // Optional: Delete associated file
        if ($complaint->file_path) {
            Storage::disk('public')->delete($complaint->file_path);
        }

        $complaintId = $complaint->id;
        $complaint->delete();

        return redirect()->route('dashboard')->with('status', 'Complaint C-'.$complaintId.' has been successfully deleted.');
    }

    public function showRoutingForm(Complaint $complaint)
    {
        // 1. Authorization Check: Ensure only Admin can see this
        if (Auth::user()->role_id != \App\Enums\Roles::ADMIN->value && Auth::user()->role_id != \App\Enums\Roles::SUPER_ADMIN->value) {
            abort(403);
        }

        // 2. Status Check: Only route complaints that are 'Pending (Admin Review)' (Status ID 1)
        if ($complaint->current_status_id != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Complaint C-'.$complaint->id.' has already been routed.');
        }

        // Fetch all offices for the dropdown
        $offices = Office::all(['id', 'name']);

        return view('admin.complaint.route', [
            'complaint' => $complaint->load(['user', 'targetOffice']), // Eager load student and student's chosen office
            'offices' => $offices,
        ]);
    }

    // Handles the submission of the routing form
    public function processRouting(RouteComplaintRequest $request, Complaint $complaint)
    {
        // Status Check: Only process complaints that are 'Pending (Admin Review)' (Status ID 1)
        if ($complaint->current_status_id != 1) {
            return redirect()->route('admin.dashboard')->with('error', 'Complaint C-'.$complaint->id.' has already been processed.');
        }

        // Update the complaint record
        // Status ID 2 is assumed to be 'Addressed (Sent to Office)'
        $complaint->update([
            'assigned_office_id' => $request->assigned_office_id,
            'current_status_id' => 2,
            'admin_remarks' => $request->admin_remarks,
        ]);

        // Redirect back to the dashboard queue
        return redirect()->route('admin.dashboard')->with('status', 'Complaint C-'.$complaint->id.' has been successfully routed to '.$complaint->assignedOffice->name.'.');
    }

    public function studentDashboard() // <--- RENAME THIS METHOD
    {
        $complaints = Complaint::where('user_id', Auth::id())
            ->with(['targetOffice', 'currentStatus'])
            ->latest()
            ->paginate(10);

        // This view is resources/views/dashboard.blade.php
        return view('dashboard', [
            'complaints' => $complaints,
        ]);
    }

    public function show(Complaint $complaint)
    {
        // Security: Ensure the student can only view their OWN complaints
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('complaint.show', compact('complaint'));
    }
}
