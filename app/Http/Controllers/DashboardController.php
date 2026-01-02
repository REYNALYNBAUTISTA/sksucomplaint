<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Complaint;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
    {
        $user = Auth::user();

        // 1. Check for Admin/Super Admin
        if ($user->hasRole(Roles::ADMIN->value) || $user->hasRole(Roles::SUPER_ADMIN->value)) {
            // Success: Redirects to /admin/dashboard
            return redirect()->route('admin.dashboard');
        }

        // 2. Check for Office Personnel
        if ($user->hasRole(Roles::OFFICE_PERSONNEL->value)) {
            return redirect()->route('office.dashboard');
        }

        // 3. Default to Student Dashboard (Only if all checks above fail)
        // If the admin user falls here, their role ID is incorrect in the database.
        return app(ComplaintController::class)->studentDashboard();
    }

    public function adminDashboard()
    {
        // Define Status IDs (Make sure these match your Database Seeder)
        $STATUS_PENDING_ADMIN_REVIEW = 1;      // New
        $STATUS_SENT_TO_OFFICE = 2;            // Routed / In Progress
        $STATUS_ACTION_TAKEN_ADMIN_REVIEW = 3; // Office Replied / Review Needed
        $STATUS_RESOLVED = 4;                  // Closed (Success)
        $STATUS_REJECTED = 5;                  // Invalid / Declined

        // 1. Fetch KPI Counts (Expanded for 6 Cards)
        $kpi = [
            'total_complaints' => \App\Models\Complaint::count(),

            'pending_routing'  => \App\Models\Complaint::where('current_status_id', $STATUS_PENDING_ADMIN_REVIEW)->count(),

            'action_taken'     => \App\Models\Complaint::where('current_status_id', $STATUS_SENT_TO_OFFICE)->count(),

            'pending_approval' => \App\Models\Complaint::where('current_status_id', $STATUS_ACTION_TAKEN_ADMIN_REVIEW)->count(),

            'resolved'         => \App\Models\Complaint::where('current_status_id', $STATUS_RESOLVED)->count(),

            'rejected'         => \App\Models\Complaint::where('current_status_id', $STATUS_REJECTED)->count(),
        ];

        // 2. Fetch Complaints for Routing Queue (Status ID 1)
        // This is the main table the admin needs to work on immediately
        $routingComplaints = \App\Models\Complaint::where('current_status_id', $STATUS_PENDING_ADMIN_REVIEW)
            ->with(['user', 'targetOffice', 'currentStatus'])
            ->latest()
            ->paginate(10, ['*'], 'routingPage');

        // 3. Fetch Complaint Counts by Office (for performance overview)
        // Helps admin see which office is busy or ignoring complaints
        $officePerformance = Office::select('id', 'name')
            ->withCount(['complaints as total_count'])
            ->withCount(['complaints as pending_routing_count' => function ($query) use ($STATUS_PENDING_ADMIN_REVIEW) {
                $query->where('current_status_id', $STATUS_PENDING_ADMIN_REVIEW);
            }])
            ->withCount(['complaints as awaiting_action_count' => function ($query) use ($STATUS_SENT_TO_OFFICE) {
                $query->where('current_status_id', $STATUS_SENT_TO_OFFICE);
            }])
            ->get();

        return view('admin.dashboard', [
            'kpi' => $kpi,
            'routingComplaints' => $routingComplaints,
            'officePerformance' => $officePerformance,
        ]);
    }

    public function officeDashboard()
{
    $user = Auth::user();

    if (!$user->office_id) {
        abort(403, 'Error: Your account is not assigned to any specific office.');
    }

    // 1. Base Query for this Office
    // We filter complaints assigned to this office, ignoring those still with Admin (Status 1)
    $baseQuery = Complaint::where('assigned_office_id', $user->office_id)
                          ->where('current_status_id', '!=', 1);

    // 2. Calculate Counts (KPIs)
    // Using clone ensures we don't mess up the query for the next count
    $totalComplaints = (clone $baseQuery)->count();
    $awaitingCount   = (clone $baseQuery)->where('current_status_id', 2)->count(); // New/Sent to Office
    $processedCount  = (clone $baseQuery)->where('current_status_id', 3)->count(); // Review Needed
    $resolvedCount   = (clone $baseQuery)->where('current_status_id', 4)->count(); // Resolved
    $rejectedCount   = (clone $baseQuery)->where('current_status_id', 5)->count(); // Rejected

    // 3. Fetch Data for Table
    $complaints = $baseQuery->orderBy('current_status_id', 'asc')
                            ->latest()
                            ->paginate(10);

    // 4. Get Office Name
    $officeName = Office::find($user->office_id)->name;

    return view('office.dashboard', compact(
        'complaints',
        'officeName',
        'totalComplaints',
        'awaitingCount',
        'processedCount',
        'resolvedCount',  // <--- Added
        'rejectedCount'   // <--- Added
    ));
}

    public function officeHistory()
    {
        $user = Auth::user();

        // Fetch complaints assigned to this office that HAVE been processed
        // We check if 'action_taken_at' is NOT NULL
        $history = Complaint::where('assigned_office_id', $user->office_id)
                                        ->whereNotNull('action_taken_at') // Only processed items
                                        ->with('user') // Eager load student data
                                        ->latest('action_taken_at') // Sort by most recently actioned
                                        ->paginate(15);

        return view('office.history', compact('history'));
    }
}
