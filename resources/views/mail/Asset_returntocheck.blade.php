<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Return Notification</title>
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" style="width: 100%; background-color: #f8f9fa; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #1b4fd3;">Asset Return Notification</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Dear {{ $name }},</p>
                            <p>The following asset return request requires your checking:</p>

                            <p><strong>Requested By:</strong> {{ $requestor->name }}</p>
                            <p><strong>Employee:</strong> {{ $employee->first_name . " " . $employee->last_name }}</p>

                            <p><strong>Asset Details:</strong></p>
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <tr>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Tag</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Asset Description</th>
                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Serial No.</th>
                                </tr>
                                @foreach ($return_data->assetDetails as $asset)
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->asset_id }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->asset_description }}</td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $asset->serial_number }}</td>
                                    </tr>
                                @endforeach
                            </table>

                            <p>Please review and proceed to the asset return page:</p>
                            <table role="presentation" width="100%" align="center">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/AssetReturn/check/'. $return_data->id .'/'. '10'.'/'. $user_id ) }}" 
                                        style="display: inline-block; padding: 10px 20px; background-color: #1b4fd3; color: #ffffff; text-decoration: none; border-radius: 5px;">
                                            Go to Asset Return
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p>If you have any questions, please contact HR or the support team.</p>
                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 Your Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
