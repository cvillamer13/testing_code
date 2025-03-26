<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Transfer Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Asset Transfer Notification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $name }},</p>
                            <p>An asset transfer requires your approval:</p>
                            <p><strong>Transfer Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: left;">From Employee</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2; text-align: right;">To Employee</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $transfer_data->getEmployee->first_name . " " . $transfer_data->getEmployee->last_name }}</td>
                                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ $transfer_data->getEmployee_to->first_name . " " . $transfer_data->getEmployee_to->last_name }}</td>
                                </tr>
                            </table>
                            <p><strong>Asset Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                </tr>
                                @foreach ($transfer_data->assetDetails as $valData)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->serial_number }}</td>
                                    </tr>
                                @endforeach
                            
                            </table>
                            <p>Please review and take action using the button below:</p>
                            <table role="presentation" width="100%" align="center">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/AssetTransfer/approver_data/'. $transfer_id . '/A' . '/'. $pages_id  .'/'. $user_id ) }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px; margin-right: 10px;">Approve Transfer</a>
                                        <a href="{{ url('/AssetTransfer/approver_data/'. $transfer_id . '/D' . '/'. $pages_id  .'/'. $user_id ) }}" style="display: inline-block; padding: 10px 20px; background-color: #dc3545; color: #ffffff; text-decoration: none; border-radius: 5px;">Reject Transfer</a>
                                    </td>
                                </tr>
                            </table>
                            <p>If you have any questions, please contact the requestor or support team.</p>
                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 Your Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
