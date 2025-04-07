<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transmittal Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid black;
            /* page-break-before: always; */
        }
        .header {
            display: flex;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 2px solid black;
            position: relative;
            height: 120px;
        }
        .header .logo {
            width: 280px;
        }
        .title {
            flex-grow: 1;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            z-index: 1;
        }
        .info {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            font-size: 14px;
        }
        .note {
            font-weight: bold;
            margin-top: 10px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        th, td {
            border-bottom: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ddd;
            text-align: left;
        }
        .signatures {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 30px;
            padding-top: 15px;
        }
        .signature-block {
            text-align: left;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            white-space: nowrap;
        }
        .signature-block p {
            margin-right: 15px;
        }
        .signature-line {
            border-top: 1px solid black;
            width: 100%;
            margin-left: 15px;
        }
        @media print {
            body, html {
                height: auto;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            .container {
                page-break-after: always;
                page-break-before: always;
                width: 1000px;
                margin: 0 auto;
            }
            table {
                font-size: 12px;
            }
            .signatures {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                margin-top: 20px;
                margin-bottom: 0;
                padding-top: 10px;
            }
            .signature-block {
                text-align: center;
                font-size: 12px;
            }
            .info, .note {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ public_path('images/logos.png') }}"" alt="Company Logo" class="logo">
        <div class="title">
            Management Information Systems Department <br>
            TRANSMITTAL FORM - Defective IT Equipment for Disposal
        </div>
    </div>

    <div class="info">
        <p><strong>Transmitted To:</strong>  <u>{{ $data->transmitted_emp->first_name . " " . $data->transmitted_emp->last_name }}</u></p>
        <p><strong>Company/Dept.: </strong> <u>{{ $data->transmitted_emp->company->name . " / " . $data->transmitted_emp->department->name }}</u></p>
        <p><strong>Date:</strong><u>{{ \Carbon\Carbon::parse($data->date)->format('F j, Y') }}</u></p>
    </div>

    <p class="note">Note: Defective units for disposal</p>

    <table>
        <tr>
            <th>Asset Code</th>
            <th>Description</th>
            <th>Model No.</th>
            <th>Serial no.</th>
            <th>Remarks</th>
            <th>Qty</th>
            <th>Unit</th>
        </tr>
        @foreach ($data->details as $valData)
            <tr>
                <td>{{ $valData->asset_details->asset_id  }}</td>
                <td>{{ $valData->asset_details->asset_description }}</td>
                <td>{{ $valData->asset_details->model_no  }}</td>
                <td>{{ $valData->asset_details->serial_number }}</td>
                <td>{{ $valData->remarks }}</td>
                <td>{{ $valData->qty }}</td>
                <td>{{ $valData->unit }}</td>
            </tr>
        @endforeach
    </table>

    <div class="signatures">
        {{-- <div class="signature-block">
            <p><strong>Prepared By:</strong></p>
            <span class="signature-line"></span>
        </div>
        <div class="signature-block">
            <p><strong>Checked By:</strong></p>
            <span class="signature-line"></span>
        </div>
        <div class="signature-block">
            <p><strong>Recommended By:</strong></p>
            <span class="signature-line"></span>
        </div>

        <div class="signature-block">
            <p><strong>Approved By:</strong></p>
            <span class="signature-line"></span>
        </div> --}}

        @foreach ($disposal_status as $index => $status)
                    @switch($index)
                        @case(0)
                            <p><strong>CHECKED BY:</strong></p>
                            <p><u>{{ $status->user->name}}</u></p>
                            <p>{{ $status->uid }}</p>
                        @break

                        @case(1)
                            {{-- <td align="center"><strong>RECOMMENDED BY:</strong><br> <u>{{ $status->user->name }}</u><br>{{ $status->uid }}</td> --}}
                            <p><strong>RECOMMENDED BY:</strong></p>
                            <p><u>{{ $status->user->name}}</u></p>
                            <p>{{ $status->uid }}</p>
                        @break
                    
                        @default
                            {{-- <td align="center"><strong>APROVED BY:</strong><br> <u>{{ $status->user->name}}</u><br>{{ $status->uid }}</td> --}}
                            <p><strong>APROVED BY:</strong></p>
                            <p><u>{{ $status->user->name}}</u></p>
                            <p>{{ $status->uid }}</p>
                    @endswitch
                    @endforeach
    </div>

    <div class="signatures">
        <div class="signature-block">
            <p><strong>Received By:</strong> <b>{{ $data->recieved_by->first_name . " " . $data->recieved_by->last_name }}</b> at <b>{{ \Carbon\Carbon::parse($data->recieved_at)->format('F j, Y g:i A') }}</b></p>
            {{-- <span class="signature-line"></span> --}}
        </div>
    </div>

</div>

</body>
</html>
