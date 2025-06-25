<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Disposal Request Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #d32f2f;">Asset Disposal Request</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $approver_data->name }},</p>
                            <p>An asset disposal request has been submitted and requires your review. Please find the details below and take appropriate action.</p>

                            <p><strong>Request Details:</strong></p>
                            <ul>
                                <li><strong>Disposal Reference Number:</strong> {{ $data_disposal->ref_num }}</li>
                                <li><strong>Date:</strong> {{ $data_disposal->date }}</li>
                                <li><strong>Transmitted To:</strong> {{ $data_disposal->transmitted_emp->first_name . " " . $data_disposal->transmitted_emp->last_name }}</li>
                            </ul>

                            <p><strong>Asset(s) Proposed for Disposal:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Type</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Model No.</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Remarks</th>
                                </tr>
                                @foreach ($data_disposal->details as $valData)
                                @if ($valData->asset_type == "csbles")
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">Consumables</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;" colspan="3">{{ $valData->consumable_item }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;" colspan="2">{{ $valData->qty }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">Asset</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->model_no }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->asset_details->serial_number }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $valData->remarks }}</td>
                                    </tr>
                                @endif
                                
                                @endforeach
                            </table>

                            <p style="text-align: center; margin-top: 20px;">
                                <a href="{{ url('/AssetDisposal/approve/'.$data_disposal->id.'/A/12/'.$approver_data->id) }}" target="_blank"
                                    style="display: inline-flex; align-items: center; background-color: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease-in-out;">
                                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Approve Request
                                </a>
                                <a href="{{ url('/AssetDisposal/approve/'.$data_disposal->id.'/R/12/'.$approver_data->id) }}" target="_blank"
                                    style="display: inline-flex; align-items: center; background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: bold; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease-in-out; margin-left: 10px;">
                                    <i class="fas fa-times-circle" style="margin-right: 8px;"></i> Reject Request
                                </a>
                            </p>

                            <p>If you need more details, please contact the requester or your IT asset management team.</p>

                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 Your Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
