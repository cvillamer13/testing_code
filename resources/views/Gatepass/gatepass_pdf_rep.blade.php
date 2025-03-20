<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GATE PASS</title>
  <style>

    /* body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 30px;
      background-color: #f4f4f4;
    } */

    .form-container {
      background: #fff;
      padding: 30px;
      border: 1px solid #999;
      border-radius: 6px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 10px;
      border-bottom: 2px solid #000;
    }

    .header-left {
      width: 65%;
    }

    .logo {
      width: 130px;
      margin-bottom: 10px;
    }

    .company-details {
      font-size: 13px;
      line-height: 1.4;
    }

    .header-right {
        width: 35%;
        text-align: right;
        position: absolute;
        top: 5;
        right: 2;
    }

    .qr-img {
      width: 130px;
      height: auto;
      display: inline-block;
      /* position: left; */
    }

    .centered-title {
      text-align: center;
      font-size: 14px;
      margin-top: 20px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .main-title {
      font-size: 18px;
      margin-top: 5px;
      text-align: center;
      font-weight: bold;
    }

    .section-row {
      display: flex;
      justify-content: space-between;
      margin: 20px 0 10px 0;
      font-size: 13px;
      padding: 0 10px;
    }

    .form-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }

    .form-table th,
    .form-table td {
      border: 1px solid #000;
      padding: 10px;
      font-size: 13px;
      vertical-align: top;
    }

    .form-table th {
      background: #f0f0f0;
      text-align: center;
    }

    /* .wide-row {
      margin-top: 20px;
      padding-left: 10px;
      font-size: 13px;
    } */
    .form-table-property{
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        
    }

    .form-table-property th {
      background: #f0f0f0;
      text-align: center;
      border: 1px solid #000;
    }

    .form-table-property td{
        text-align: center;
        border: 1px solid #000;
        width: 100%;
        font-size: 12px;
    }


    .signature-row {
      /* display: flex;
      justify-content: space-between;
      margin-top: 30px;
      font-size: 13px;
      text-align: center; */
      display: flex;
    justify-content: space-between; /* Pushes items to opposite ends */
    width: 100%; /* Ensures it spans the full width */
    }

    .signature-row div {
      flex: 1;
      padding: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    
  </style>
</head>
<body>

<div class="form-container">

  <div class="header">
    <div class="header-left">
      {{-- <img src="{{ url('images/logos.png') }}" alt="Company Logo" class="logo"> --}}
      <img src="{{ public_path('images/logos.png') }}" alt="laravel daily" class="logo" />

      <div class="company-details">
        <strong>Management Information System</strong><br>
        2111 Chino Roces Avenue, Makati City<br>
        Tel. No. 893-5531
      </div>
    </div>
    <div class="header-right">
      <img src="{{ $qrCode }}" alt="QR Code" class="qr-img"><br>
    </div>
  </div>

  {{-- <div class="centered-title">PROPERTY FROM <u>__________</u> TO <u>__________</u></div> --}}
  <div class="main-title">MIS IT ASSET GATE PASS</div>
  
  {{-- <div class="section-row">
    <div><strong>DATE:</strong> ___________________________</div>
    <div><strong>GATE PASS NO:</strong> ___________________________</div>
  </div> --}}

  <table width="100%">
    <tr>
        <td align="left"><strong>DATE: {{ $data->date_issued}} </strong></td>
        <td align="right"><strong>GATE PASS NO: {{ $data->gatepass_no}}</strong> </td>
    </tr>
</table>


  <table class="form-table-property">
    <thead >
        <tr>
            <th colspan="6">PROPERTY</th>
        </tr>
        <tr>
            <th colspan="3">From</th>
            <th colspan="3">To</th>
        </tr>
        <tr>
            <th>COMPANY</th>
            <th>DEPARTMENT</th>
            <th>LOCATION</th>

            <th>COMPANY</th>
            <th>DEPARTMENT</th>
            <th>LOCATION</th>
        </tr>
    </thead>
    <tbody>
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
  <br>
 



<table class="form-table">
<thead>
    <tr>
        <th>ASSET NO</th>
        <th>DESCRIPTION</th>
        <th>SERIAL NO</th>
        <th>QTY</th>
        <th>UNIT</th>
    </tr>
</thead>
<tbody>
    {{-- <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr> --}}

    @foreach ($data_show->assetDetails as $index => $asset)
        <tr>
            <td>{{ $asset->asset_id }}</td>
            <td>{{ $asset->asset_description }}</td>
            <td>{{ $asset->serial_number }}</td>
            <td>1 </td>
            <td>{{ $asset->unit_data ? $asset->unit_data->name : 'N/A' }}</td>
            
        </tr>
    @endforeach
</tbody>
</table>

  <div class="wide-row">
    <strong>PURPOSE:</strong> <u>{{ $data->purpose }}</u>
  </div>

  <table width="100%" style="margin-top: 20px;">
    <tr>
        <td align="center"><strong>REQ. BY:</strong><br> <u>{{ $data->finalizedby }}</u></td>
        @foreach ($gatepasss_status as $status)
        <td align="center"><strong>NOTED BY:</strong><br> {{ $status->user->name }}</td>
        @endforeach
        {{-- <td align="center"><strong>NOTED BY:</strong><br> ___________________________</td>
        <td align="center"><strong>RECOMMENDED BY:</strong><br> ___________________________</td>
        <td align="center"><strong>APPROVED BY:</strong><br> ___________________________</td> --}}
    </tr>
</table>

<table width="100%" style="margin-top: 20px;">
    <tr>
        <td align="center"><strong>INSPECTED BY:</strong><br> ___________________________</td>
        <td align="center"><strong>TIME:</strong><br> ___________________________</td>
        <td align="center"><strong>RECEIVED BY:</strong><br> ___________________________</td>
    </tr>
</table>

</div>

</body>
</html>
