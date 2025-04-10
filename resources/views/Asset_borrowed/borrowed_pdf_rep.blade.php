<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS-Asset Transmittal Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            /* margin: 20px 1in; */
            padding: 0;
        }

        .header {
            /* display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px; */
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 0 20px; /* Adds spacing */
        }

        .header-left img {
            max-width: 250px;
            height: auto;
        }

        .header-right {
            /* text-align: right;
            font-size: 14px;
            font-weight: bold; */
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .title-container {
            text-align: center;
            background: #d3d3d3;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .form-table,
        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 10px;
        }

        .form-table td {
            padding: 8px;
            border: 1px solid #000;
            width: 25%;
            font-size: 10px;
        }

        .equipment-table th,
        .equipment-table td {
            padding: 6px;
            border: 1px solid #000;
            text-align: left;
            font-size: 10px;
        }

        .equipment-table th {
            background-color: #d3d3d3;
            font-weight: bold;
            text-align: center;
        }

        .equipment-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 20px;
        }

        .signatures {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 48%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: auto;
            margin-top: 40px;
        }

        /* Print styles for A4 portrait */
        @media print {
            body {
                margin: 1in;
                font-size: 11px;
            }

            @page {
                size: A4 portrait;
                margin: 1in;
            }

            .header-left img {
                max-width: 200px;
            }

            .form-table,
            .equipment-table {
                page-break-inside: avoid;
            }

            .signatures {
                page-break-inside: avoid;
            }

            .signature-box,
            .signature-line {
                width: 100%;
                page-break-inside: avoid;
            }
        }

        .qr-img {
            width: 100px;
            height: auto;
            /* display: inline-block; */
        /* position: left; */
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('images/logos.png') }}" alt="Company Logo">
            
        </div>
        <div class="header-right">
                
            
            <p>{{ $data_show->ref_num }}</p>
        </div>
    </div>

    <!-- Form Title -->
    <div class="title-container">
        <p class="title">MIS-Asset Transmittal Form</p>
    </div>

    <!-- Updated 4-Column Form Table -->
    <table class="form-table">
        <tr>
            <td><strong>Name:</strong></td>
            <td>{{ $data_show->getEmployee->first_name . " " . $data_show->getEmployee->last_name }}</td>
            <td><strong>Requested Date:</strong></td>
            <td>{{ \Carbon\Carbon::parse($data_show->requested_at)->format('F j, Y') }}</td>
        </tr>
        <tr>
            <td><strong>Company/Dept.:</strong></td>
            <td>{{ $data_show->getEmployee->company->name . " / " . $data_show->getEmployee->department->name }}</td>
            <td><strong>Deployed Date:</strong></td>
            <td>{{ \Carbon\Carbon::parse($data_show->deployed_at)->format('F j, Y') }}</td>
        </tr>
        <tr>
            <td><strong>Employee #:</strong></td>
            <td>{{ $data_show->getEmployee->emp_no }}</td>
            <td><strong>From:</strong></td>
            <td>{{ $data_show->getLocation_from->location_data->name }}</td>
        </tr>
        <tr>
            <td><strong>Phone #:</strong></td>
            <td>{{ $data_show->getEmployee->phone_number }}</td>
            <td><strong>To:</strong></td>
            <td>{{ $data_show->getLocation_to->location_data->name }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td>{{ $data_show->getEmployee->email }}</td>
            <td><strong>Ticket #:</strong></td>
            <td>{{ $data_show->ref_rss }}</td>
        </tr>
    </table>

    <!-- Equipment List Section -->
    <p class="equipment-title">Equipment List</p>
    <table class="equipment-table">
        <tr>
            <th>Asset #</th>
            <th>Description</th>
            <th>S/N #</th>
            <th>QTY</th>
            <th>Comment</th>
            <th>Return Date</th>
        </tr>
        @foreach ($data_show->details as $datadetl)
            <tr>
                <td>{{ $datadetl->asset_details->asset_id }}</td>
                <td>{{ $datadetl->asset_details->asset_description }}</td>
                <td>{{ $datadetl->asset_details->serial_number }}</td>
                <td>1</td>
                <td>{{ $datadetl->comments }}</td>
                <td>{{ \Carbon\Carbon::parse($datadetl->date)->format('F j, Y') }}</td>
            </tr>
        @endforeach
        
    </table>

    <!-- Signature Section -->
    <div class="signatures">
        <table style="width: 100%; border-collapse: collapse; margin-top: 0px;">
            <tr>
                <!-- Left Column (Prepared, Recommended, Authorized) -->
                
                <td style="width: 50%; border: 1px solid #000; vertical-align: top; padding: 10px;">
                    <p><strong>Prepared By:</strong></p>
                    <p><u>{{ $requested->first_name . " " . $requested->last_name }}</u></p>
                    <p>Signature Over Printed Name</p>

                    @foreach ($gatepasss_status as $index => $status)
                    @switch($index)
                        @case(0)
                            <p><strong>Prepared By:</strong></p>
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
                    
                    {{-- <p><strong>Prepared By:</strong></p>
                    <p><u>asdasdasd</u></p>
                    <p>Signature Over Printed Name</p>

                    <p><strong>Recommended By:</strong></p>
                    <p>__________________________</p>
                    <p>Signature Over Printed Name</p>

                    <p><strong>Authorized By:</strong></p>
                    <p>__________________________</p>
                    <p>Signature Over Printed Name</p> --}}
                    @endforeach
                </td>

                <!-- Right Column (Received By with Agreement) -->
                <td style="width: 50%; border: 1px solid #000; vertical-align: top; padding: 10px;">
                    <p><strong>Received By:</strong></p>
                    <p style="font-size: 10px;">
                        By signing this form, I agree to the following: I am responsible for the equipment or property
                        issued to me; I will use it/them in the manner intended; I agree to keep the property in working
                        condition and notify management should the property malfunction, or should the property be lost
                        or stolen. Further, I agree to return this property at the end of my employment.
                    </p>
                    <table style="width: 100%; margin-top: 30px; text-align: center;">
                        <tr>
                            <td style="width: 50%; border-top: 1px solid #000; padding-top: 20px;">Signature Over
                                Printed Name</td>
                            <td style="width: 50%; border-top: 1px solid #000; padding-top: 20px;">Date</td>
                            <td style="width: 50%; border-top: 1px solid #000; padding-top: 20px;">UID</td>
                        </tr>
                        
                    </table>
                    <center><p><img src="{{ $qrCode }}" alt="QR Code" class="qr-img"></p></center>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
