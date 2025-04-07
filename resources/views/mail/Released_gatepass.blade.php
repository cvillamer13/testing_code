<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gatepass Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Gatepass Notification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Hello {{ $issueby }},</p>
                            <p>Your gate pass request has been approved and is now ready for release.</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                <li><strong>Gate Pass No:</strong> <a>{{ $gatepass_no }}</a></li>
                            </ul>
                            <a href="{{ url('/Gatepass/gatepass_report/'. $gatepass_id ) }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px; margin-right: 10px;">View Gatepass document</a>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
