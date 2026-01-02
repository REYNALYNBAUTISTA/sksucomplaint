<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Mail\ComplaintResolvedResult;
use App\Models\Complaint;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintRoutedToOffice;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminComplaintController extends Controller
{
   public function index()
    {
        // ✅ Added 'targetOffice' to the with() list
        $complaints = Complaint::with(['user', 'assignedOffice', 'targetOffice'])
                               ->latest()
                               ->paginate(10);

        return view('admin.complaint.index', compact('complaints'));
    }

    /**
     * Show the form to assign an office to a complaint.
     */
    public function showAssignmentForm(Complaint $complaint)
    {
        // Add a safety check/redirect for already assigned complaints
        if ($complaint->assigned_office_id) {
            return redirect()->route('admin.complaints.index')
                             ->with('error', 'Complaint is already assigned.');
        }

        $offices = Office::orderBy('name')->get();

        return view('admin.complaint.assign', compact('complaint', 'offices'));
    }

    /**
     * Route the complaint to the selected office.
     */
   public function assignOffice(Request $request, Complaint $complaint)
    {
        // 1. Validate Input
        $request->validate([
            'assigned_office_id' => ['required', 'exists:offices,id'],
            'admin_remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $STATUS_ASSIGNED = 2; // (Sent to Office)

        // 2. Update Complaint Database
        $complaint->update([
            'assigned_office_id' => $request->assigned_office_id,
            'current_status_id' => $STATUS_ASSIGNED,
            'admin_remarks' => $request->admin_remarks,
        ]);

        $complaint->load('assignedOffice');

        // =========================================================
        // ✅ 3. NOTIFY THE OFFICE PERSONNEL
        // =========================================================

        // We find the user assigned to this office.
        // We removed the role check, so it grabs whoever has this office_id.
        $officeStaff = User::where('office_id', $request->assigned_office_id)->first();

        if ($officeStaff && $officeStaff->email) {
            try {
                Mail::to($officeStaff->email)->send(new ComplaintRoutedToOffice($complaint));
            } catch (\Exception $e) {
                Log::error("Failed to email Office Staff (ID: {$officeStaff->id}): " . $e->getMessage());
            }
        }

        // =========================================================
        // ✅ 4. NOTIFY THE STUDENT
        // =========================================================
        if ($complaint->user && $complaint->user->email) {
            try {
                Mail::to($complaint->user->email)->send(new ComplaintRoutedToOffice($complaint));
            } catch (\Exception $e) {
                Log::error("Failed to email Student (ID: {$complaint->user->id}): " . $e->getMessage());
            }
        }

        return redirect()->route('admin.dashboard')
                         ->with('success', "Complaint #{$complaint->id} routed to {$complaint->assignedOffice->name}. Office staff and student have been notified.");
    }


    public function show(Complaint $complaint)
    {
        // Eager load relationships to prevent errors in the view
        $complaint->load(['user', 'assignedOffice']);

        return view('admin.complaint.show', compact('complaint'));
    }

    public function notifyStudent(Complaint $complaint)
    {

        if (!$complaint->user || !$complaint->user->email) {
            return back()->with('error', 'Student email not found.');
        }

        try {
            Mail::to($complaint->user->email)->send(new ComplaintResolvedResult($complaint));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }

        // ✅ UPDATE: Determine Final Status based on Office Decision
        // If Office said "resolved", we move to Status 4.
        // If Office said "rejected" or we are just closing it, we move to Status 5.

        if ($complaint->final_decision === 'resolved') {
            $NEW_STATUS = 4; // Resolved (Action Approved)
        } else {
            $NEW_STATUS = 5; // Invalid/Closed
        }

        $complaint->update([
            'current_status_id' => $NEW_STATUS
        ]);

        return back()->with('success', 'Notification sent and Complaint marked as Finalized.');
    }
}
