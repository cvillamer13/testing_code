<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Return Confirmation</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Asset Return Confirmation</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $requestor->name }},</p>
                            <p>The asset return request has been successfully checked and sent back to the requestor.</p>

                            <p><strong>Confirmed By:</strong> {{ $confirmor->name }}</p>
                            <p><strong>Employee:</strong> {{ $employee->first_name . " " . $employee->last_name }}</p>

                            <p><strong>Asset Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                    {{-- <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Remarks.</th> --}}
                                </tr>
                                @foreach ($return_data->assetDetails as $index => $asset)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->serial_number }}</td>
                                        {{-- <td style="border: 1px solid #ddd; padding: 8px;">{{ $return_data[$index]->remarks }}</td> --}}
                                    </tr>
                                @endforeach
                            </table>

                            <p align="center">
                                <a href="{{ url('/AssetReturn/view_data_emp/'. $return_data->id ) }}" 
                                    style="display: inline-block; padding: 12px 25px; background-color: #1b4fd3; color: #ffffff; text-decoration: none; font-size: 16px; border-radius: 5px; font-weight: bold;">
                                    View Asset Return Details
                                </a>
                            </p>

                            <p>If you have any questions, please contact the support team.</p>
                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 Your Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
