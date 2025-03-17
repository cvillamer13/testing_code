<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Issuance Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Approval Request Notification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $issueby }},</p>
                            <p>The request has been approved, and you are required to create a gate pass.</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                {{-- <li><strong>Rev No:</strong> <a href="{{ url('/AssetAssign/view_rev/'. $rev_num . '/'. $pages_id .'/'. $user_id ) }}" target="_blank">{{ $rev_num }}</a></li> --}}
                                <li><strong>Rev No:</strong> <a>{{ $rev_num }}</a></li>
                                <li><strong>Assignee:</strong> {{ $assignee }}</li>
                                {{-- <li><strong>Issued By:</strong> {{ $issueby }}</li> --}}
                                <li><strong>Date Requested:</strong> {{ \Carbon\Carbon::parse($date_req)->format('F j, Y') }}</li>
                                <li><strong>Date Needed:</strong> {{ \Carbon\Carbon::parse($date_need)->format('F j, Y') }}</li>
                            </ul>
                            <p>Please click the button below to create a gate pass:</p>
                            <p style="text-align: center;">
                                {{-- <a style="background-color: hsl(123, 100%, 50%); color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;" href="{{ url("/Gatepass/data/".$gatepass_id) }}" target="_blank">Create Gate Pass</a> --}}
                                <a href="{{ url('/Gatepass/data/'.$gatepass_id) }}" target="_blank"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        background-color: #28a745; /* Green color */
                                        color: white;
                                        padding: 12px 24px;
                                        text-decoration: none;
                                        border-radius: 8px;
                                        font-size: 16px;
                                        font-weight: bold;
                                        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
                                        transition: all 0.3s ease-in-out;
                                    "
                                    onmouseover="this.style.backgroundColor='#218838'"
                                    onmouseout="this.style.backgroundColor='#28a745'"
                                    >
                                    <i class="fas fa-door-open" style="margin-right: 8px;"></i> Create Gate Pass
                                    </a>

                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
