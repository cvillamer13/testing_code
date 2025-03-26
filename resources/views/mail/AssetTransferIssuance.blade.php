<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Issuance Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Asset Issuance Required</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $issueby }},</p>
                            <p>The asset transfer has been approved. Please proceed with creating an issuance for the assigned asset.</p>
                            <p><strong>Issuance Details:</strong></p>
                            <ul>
                                <li><strong>Issuance Ref No:</strong> <a>{{ $issuance_ref }}</a></li>
                                <li><strong>Assignee:</strong> {{ $assignee }}</li>
                            </ul>
                            <p><strong>Asset Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                </tr>
                                @foreach ($asset_data->assetDetails as $valData)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->serial_number }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <p>Please click the button below to create an issuance:</p>
                            <p style="text-align: center;">
                                <a href="{{ url('/AssetAssign/detl/'.$issuance_id) }}" target="_blank"
                                    style="
                                        display: inline-flex;
                                        align-items: center;
                                        background-color: #007bff; /* Blue color */
                                        color: white;
                                        padding: 12px 24px;
                                        text-decoration: none;
                                        border-radius: 8px;
                                        font-size: 16px;
                                        font-weight: bold;
                                        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
                                        transition: all 0.3s ease-in-out;
                                    "
                                    onmouseover="this.style.backgroundColor='#0056b3'"
                                    onmouseout="this.style.backgroundColor='#007bff'">
                                    <i class="fas fa-file-signature" style="margin-right: 8px;"></i> Create Issuance
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
