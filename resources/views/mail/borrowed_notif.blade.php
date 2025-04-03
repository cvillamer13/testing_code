<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Borrowing Request Notification</title>
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
                            <p>Dear {{ $approver_data->name }},</p>
                            <p>A request has been made for borrowing an asset. Please review the details below and approve or reject the request.</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                <li><strong>RSS Number:</strong> {{ $data_ned->ref_rss }}</li>
                                <li><strong>Requested Date:</strong> {{ $data_ned->requested_at }}</li>
                                <li><strong>Deployed Date:</strong> {{ $data_ned->deployed_at }}</li>
                                <li><strong>Requested By:</strong> {{ $data_ned->requested_by }}</li>
                            </ul>
                            <p><strong>Asset Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                </tr>
                                @foreach ($data_ned->details as $valData)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->serial_number }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <p style="text-align: center; margin-top: 20px;">
                                <a href="{{ url('/BorrowedAsset/approve/'.$data_ned->id.'/A/11/'.$approver_data->id) }}" target="_blank"
                                    style="display: inline-flex; align-items: center; background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease-in-out;">
                                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Approve Request
                                </a>
                                <a href="{{ url('/BorrowedAsset/approve/'.$data_ned->id.'/R/11/'.$approver_data->id) }}" target="_blank"
                                    style="display: inline-flex; align-items: center; background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease-in-out; margin-left: 10px;">
                                    <i class="fas fa-times-circle" style="margin-right: 8px;"></i> Reject Request
                                </a>
                            </p>
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
