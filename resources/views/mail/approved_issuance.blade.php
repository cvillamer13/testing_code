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
                            <p>Dear {{ $name }},</p>
                            <p>A your request is Approved:</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                <li><strong>Rev No:</strong> <a href="{{ url('/AssetAssign/view_rev/'. $rev_num . '/'. $pages_id .'/'. $user_id ) }}" target="_blank">{{ $rev_num }}</a> </li>
                                <li><strong>Assignee:</strong> {{ $assignee }}</li>
                                <li><strong>Issued By:</strong> {{ $issueby }}</li>
                                <li><strong>Date Requested:</strong> {{ \Carbon\Carbon::parse($date_req)->format('F j, Y') }}</li>
                                <li><strong>Date Needed:</strong> {{ \Carbon\Carbon::parse($date_need)->format('F j, Y') }}</li>
                            </ul>
                            <p>Please review and take action using the button below:</p>
                            <p>If you have any questions, please contact the requestor or support team.</p>
                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 __COMPANY. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
