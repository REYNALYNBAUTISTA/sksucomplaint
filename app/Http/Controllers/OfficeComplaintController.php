<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficeComplaintController extends Controller
{
    /**
     * Show the complaint details and the "Take Action" form.
     */
    public function show(Complaint $complaint)
    {
        // 1. Security Check: Ensure this complaint belongs to the user's office
        if (Auth::user()->office_id !== $complaint->assigned_office_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('office.complaints.show', compact('complaint'));
    }

    /**
     * Process the complaint (Resolve/Close).
     */
    public function process(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:resolved,rejected',
            'office_remarks' => 'required|string|min:5',
            'office_file' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:5120',
        ]);

        // ... (File upload logic remains the same) ...
        $officeFilePath = $complaint->office_file_path;
        if ($request->hasFile('office_file')) {
            $officeFilePath = $request->file('office_file')->store('office_responses', 'public');
        }

        // ✅ UPDATE: Set Status to 3 "Action Taken (Admin Review)"
        // The Admin will change it to 4 or 5 later.
        $STATUS_ACTION_TAKEN = 3;

        $complaint->update([
            'current_status_id' => $STATUS_ACTION_TAKEN,
            'final_decision' => $request->status, // "resolved" or "rejected"
            'office_remarks' => $request->office_remarks,
            'office_file_path' => $officeFilePath,
            'action_taken_at' => now(),
        ]);

        return redirect()->route('office.dashboard')
                         ->with('success', 'Action submitted! Pending final Admin approval.');
    }
}
