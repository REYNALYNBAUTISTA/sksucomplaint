<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #f8f9fa; padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
        .details { margin: 20px 0; }
        .label { font-weight: bold; color: #555; }
        .button { display: inline-block; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Complaint Assignment</h2>
        </div>

        <p>Hello,</p>
        <p>A new complaint has been routed to your office for action.</p>

        <div class="details">
            <p><span class="label">Complaint ID:</span> #{{ $complaint->id }}</p>
            <p><span class="label">Subject:</span> {{ $complaint->subject }}</p>
            <p><span class="label">Filed By:</span> {{ $complaint->user->name }} ({{ $complaint->user->id_number }})</p>

            @if($complaint->admin_remarks)
                <p><span class="label">Admin Remarks:</span><br>
                <em style="color: #d97706;">"{{ $complaint->admin_remarks }}"</em></p>
            @endif
        </div>

        <p>Please log in to the system to review the full details and take necessary action.</p>

        <center>
            {{-- Link to your Office Dashboard --}}
            <a href="{{ route('office.dashboard') }}" class="button">Go to Office Dashboard</a>
        </center>
    </div>
</body>
</html>
