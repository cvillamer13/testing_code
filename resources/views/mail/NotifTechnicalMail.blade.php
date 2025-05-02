<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Borrowing Request</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Asset Borrowing Request</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Reference No:</strong> {{ $data->ref_num }}</p>
                            <p><strong>Requested by:</strong> {{ $data->getEmployee->first_name . " " . $data->getEmployee->last_name }}</p>
                            <p>Hello Technical Team,</p>
                            <p>{{ $data->getEmployee->first_name . " " . $data->getEmployee->last_name }} has submitted a request to borrow an asset. Please find the details below:</p>
                            
                            <a href="{{ url('/BorrowedAsset/for_finalize/' . $data->id) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; margin-top: 10px;">View Request</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px; font-size: 12px; color: #6c757d;">
                            <p>This is an automated message. Please do not reply to this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
