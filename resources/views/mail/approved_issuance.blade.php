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
                            <p>Dear TEST,</p>
                            <p>The request has been approved, and you are required to create a gate pass.</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                {{-- <li><strong>Rev No:</strong> <a href="{{ url('/AssetAssign/view_rev/'. $rev_num . '/'. $pages_id .'/'. $user_id ) }}" target="_blank">{{ $rev_num }}</a></li> --}}
                                <li><strong>Assignee:</strong> lasd,asssd</li>
                                <li><strong>Issued By:</strong> acasdxasd</li>
                                <li><strong>Date Requested:</strong> sadxasdasx</li>
                                <li><strong>Date Needed:</strong> asdasdasdasdas</li>
                            </ul>
                            <p>Please click the button below to create a gate pass:</p>
                            <p style="text-align: center;">
                                <a style="background-color: #1b4fd3; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Create Gate Pass</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
