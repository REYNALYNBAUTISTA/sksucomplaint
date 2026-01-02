<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    // Define the columns that are safe for mass assignment
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'target_office_id',
        'current_status_id',
        'file_path',
        'assigned_office_id',
        'admin_remarks',
        'office_remarks',
        'office_file_path',
        'action_taken_at',
        'final_decision',



        // Note: The 'id' and timestamps ('created_at', 'updated_at') are automatically handled.
    ];

    /**
     * Define relationships
     */

    // Relationship to the Student who filed the complaint
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the office the complaint is directed to
    public function targetOffice()
    {
        return $this->belongsTo(Office::class, 'target_office_id');
    }

    // Relationship to the current status of the complaint
    public function currentStatus()
    {
        return $this->belongsTo(ComplaintStatus::class, 'current_status_id');
    }

    public function assignedOffice()
    {
        return $this->belongsTo(Office::class, 'assigned_office_id');
    }

}
