<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Base Resets */
        body { margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }

        /* Container */
        .wrapper { width: 100%; table-layout: fixed; background-color: #f3f4f6; padding-bottom: 40px; }
        .main-content { background-color: #ffffff; margin: 0 auto; max-width: 600px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }

        /* Header */
        .header { background-color: #374151; padding: 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        /* Body */
        .body-section { padding: 30px; color: #374151; line-height: 1.6; }
        .greeting { font-size: 16px; font-weight: bold; margin-bottom: 15px; }

        /* Status Box Logic */
        .status-box { padding: 20px; border-radius: 6px; margin: 25px 0; border-left: 5px solid; }

        /* Labels */
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: bold; display: block; margin-bottom: 5px; }
        .value { font-size: 15px; font-weight: 500; color: #111827; margin-bottom: 15px; display: block; }
        .remarks-text { font-style: italic; color: #4b5563; background: rgba(255,255,255,0.6); padding: 10px; border-radius: 4px; border: 1px solid rgba(0,0,0,0.05); }

        /* Button */
        .btn-container { text-align: center; margin-top: 30px; margin-bottom: 20px; }
        .btn { background-color: #4f46e5; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; display: inline-block; }
        .btn:hover { background-color: #4338ca; }

        /* Footer */
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #9ca3af; background-color: #f9fafb; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>

    {{-- LOGIC FOR COLORS --}}
    @php
        $isResolved = $complaint->final_decision === 'resolved';
        // Green for Resolved, Red for Rejected
        $bgColor = $isResolved ? '#ecfdf5' : '#fef2f2';
        $borderColor = $isResolved ? '#10b981' : '#ef4444';
        $textColor = $isResolved ? '#065f46' : '#991b1b';
        $statusText = $isResolved ? 'APPROVED / RESOLVED' : 'REJECTED';
        $icon = $isResolved ? '✅' : '❌';
    @endphp

    <div class="wrapper">
        <br>
        <div class="main-content">

            {{-- Header --}}
            <div class="header">
                <h1>Update on Complaint #{{ $complaint->id }}</h1>
            </div>

            <div class="body-section">
                <p class="greeting">Dear {{ $complaint->user->name }},</p>

                <p>This is an automated notification regarding the complaint you filed regarding: <br>
                <strong>"{{ $complaint->subject }}"</strong>.</p>

                <p>The assigned office has processed your request. Please review the result below:</p>

                {{-- Dynamic Status Box --}}
                <div class="status-box" style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">

                    {{-- 1. Final Decision --}}
                    <span class="label">Final Office Decision</span>
                    <span class="value" style="color: {{ $textColor }}; font-size: 18px; font-weight: 800;">
                        {{ $icon }} {{ $statusText }}
                    </span>

                    {{-- 2. Remarks --}}
                    <span class="label">Office Remarks / Details</span>
                    <div class="value remarks-text">
                        "{{ $complaint->office_remarks }}"
                    </div>

                    {{-- 3. Date --}}
                    <span class="label">Date Actioned</span>
                    <span class="value" style="margin-bottom: 0;">
                        {{ \Carbon\Carbon::parse($complaint->action_taken_at)->format('F j, Y, h:i A') }}
                    </span>
                </div>

                <p>For more details, or to view any attached official documents from the office, please log in to your student portal.</p>

                {{-- Action Button --}}
                <div class="btn-container">
                    {{-- Replace 'dashboard' with your actual student route --}}
                    <a href="{{ route('dashboard') }}" class="btn">Login to Student Portal</a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>This is a system-generated email. Please do not reply.</p>
            </div>
        </div>
    </div>

</body>
</html>
