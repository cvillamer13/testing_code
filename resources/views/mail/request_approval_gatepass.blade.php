<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Approval Notification</title>
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
                            <p>Dear {{ $name }},</p>
                            <p>A new request requires your approval:</p>
                            <p><strong>Request Details:</strong></p>
                            <ul>
                                <li><strong>Gatepass No:</strong> <a href="{{ url('/Gatepass/view_rev/'. $gatepass_id_dta . '/'. $pages_id .'/'. $user_id ) }}" target="_blank">{{ $gate_pass_no }}</a> </li>
                                {{-- <li><strong>Requested Date:</strong> {{ $created_date }}</li> --}}
                                <li><strong>Requested Date:</strong> {{ \Carbon\Carbon::parse($created_date)->format('F j, Y') }}</li>

                            </ul>
                            <table width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; text-align: center;" border="1">
                                <thead>
                                    <tr style="background-color: #343a40; color: white;">
                                        <td colspan="3">From</td>
                                        <td colspan="3">To</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Company</td>
                                        <td>Department</td>
                                        <td>Location</td>
                                        <td>Company</td>
                                        <td>Department</td>
                                        <td>Location</td>
                                    </tr>

                                    <tr>
                                        <td>{{ $from_location->company->name }}</td>
                                        <td>{{ $from_location->department->name }}</td>
                                        <td>{{ $from_location->name }}</td>
                                        <td>{{ $to_location->company->name }}</td>
                                        <td>{{ $to_location->department->name }}</td>
                                        <td>{{ $to_location->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <table role="presentation" width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; text-align: center;">
                                <thead>
                                    <tr style="background-color: #343a40; color: white;">
                                        <th style="padding: 10px; border: 1px solid #ddd;">Asset No</th>
                                        <th style="padding: 10px; border: 1px solid #ddd;">Description</th>
                                        <th style="padding: 10px; border: 1px solid #ddd;">Serial No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->assetDetails as $as)
                                    <tr style="background-color: #f9f9f9;">
                                        <td style="padding: 10px; border: 1px solid #ddd;">{{  $as->asset_id }}</td>
                                        <td style="padding: 10px; border: 1px solid #ddd;">{{  $as->asset_description }}</td>
                                        <td style="padding: 10px; border: 1px solid #ddd;">{{  $as->serial_number }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <p>Please review and take action using the button below:</p>
                            <table role="presentation" width="100%" align="center">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/Gatepass/view_rev_approvers/'. $gatepass_id_dta . '/A' . '/'. $pages_id  .'/'. $user_id ) }}" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px; margin-right: 10px;">Approve Request</a>
                                        <a href="{{ url('/Gatepass/view_rev_approvers/'. $gatepass_id_dta . '/D' . '/'. $pages_id  .'/'. $user_id ) }}" style="display: inline-block; padding: 10px 20px; background-color: #dc3545; color: #ffffff; text-decoration: none; border-radius: 5px;">Reject Request</a>
                                    </td>
                                </tr>
                            </table>
                            <p>If you have any questions, please contact the requestor or support team.</p>
                            <p style="text-align: center; font-size: 14px; color: #6c757d;">&copy; 2025 __Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
