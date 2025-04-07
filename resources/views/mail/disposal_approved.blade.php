<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Asset Disposal Request Approved</title>
</head>
<body style="background-color: #f4f6f8; font-family: Arial, sans-serif; margin: 0; padding: 0;">
<table role="presentation" style="width: 100%; background-color: #f4f6f8; padding: 20px;">
<tr>
    <td align="center">
    <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);">
        <tr>
        <td align="center">
            <h2 style="color: #28a745;">Asset Disposal Request Approved</h2>
        </td>
        </tr>
        <tr>
        <td>
            <p>Dear {{ $employee_data->first_name . " " . $employee_data->last_name }},</p>
            <p>We are pleased to inform you that the following asset disposal request has been <strong>approved</strong>.</p>

            <p><strong>Request Summary:</strong></p>
            <ul>
            <li><strong>Disposal Reference Number:</strong> {{ $data_disposal->ref_num }}</li>
            <li><strong>Date:</strong> {{ $data_disposal->date }}</li>
            </ul>

            <p><strong>Asset(s) Approved for Disposal:</strong></p>
            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; background-color: #e9f7ef;">Asset Tag</th>
                <th style="border: 1px solid #ddd; padding: 8px; background-color: #e9f7ef;">Description</th>
                <th style="border: 1px solid #ddd; padding: 8px; background-color: #e9f7ef;">Model No.</th>
                <th style="border: 1px solid #ddd; padding: 8px; background-color: #e9f7ef;">Serial No.</th>
                <th style="border: 1px solid #ddd; padding: 8px; background-color: #e9f7ef;">Condition</th>
            </tr>
            @foreach ($data_disposal->details as $valData)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_description }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->model_no }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->serial_number }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->remarks }}</td>
            </tr>
            @endforeach
            </table>

            <p style="margin-top: 20px;">You may now proceed with the next steps for proper asset disposal.</p>

            <p style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/AssetDisposal/received/'.$data_disposal->id.'/R/12/'.$data_disposal->requested_by_id) }}" target="_blank"
                style="display: inline-block; background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); transition: background-color 0.3s ease-in-out;">
                ✅ Mark as Received
            </a>
            </p>

            <p>If you have any questions, please contact the approver or the asset management team.</p>

            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 Your Company. All rights reserved.</p>
        </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>
