<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Information Technology Asset Issuance Form</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fff;
    padding: 15px;
    font-size: 14px;
    color: #000;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 5px;
    vertical-align: top;
    color: #000;
}

.form-section {
    background-color: #444;
    color: #fff;
    padding: 6px;
    margin-top: 15px;
    font-weight: bold;
    font-size: 10px;
}

.form-group {
    display: grid;
    grid-template-columns: 140px 1fr;
    align-items: center;
    gap: 4px;
    margin-bottom: 5px;
}

.form-group label {
    font-weight: bold;
    white-space: nowrap;
    color: #000;
    padding-right: 8px;
    font-size: 10px;
}

.form-group span,
.form-group textarea {
    display: inline-block;
    min-height: 15px;
    padding: 6px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    width: 100%;
    box-sizing: border-box;
    color: #000;
    font-size: 10px;
}

.form-group textarea {
    height: 60px;
    resize: vertical;
}

.row-group {
    display: flex;
    justify-content: space-between;
    gap: 6px;
}

.half-input {
    flex: 1;
}

.radio-group {
    display: flex;
    gap: 8px;
    margin-left: 0px;
    margin-top: 2px;
    font-size: 8px;
    color: #000;
}

.software-grid table {
    width: 100%;
    border-spacing: 4px 2px;
}

.software-grid td {
    padding: 2px 8px;
    color: #000;
}

.software-grid label {
    font-weight: normal;
    font-size: 13px;
    color: #000;
}

h2 {
    color: #000;
}

@media print {
    body {
    background: #fff;
    color: #000;
    }
    .no-print {
    display: none;
    }
}
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<!-- Header Section -->
<table style="width: 100%; margin-bottom: 10px;">
  <tr>
    <td style="width: 20%; vertical-align: top;">
      <img src="logo (6).png" alt="Logo" style="max-width: 220px; height: auto;" />
    </td>
    <td style="text-align: center; width: 60%;">
      <h4 style="margin: 0; font-size: 15px;">Information Technology Asset Issuance Form</h4>
    </td>
    <td style="width: 20%; text-align: center; vertical-align: top;">
      <div style="font-size: 8px; font-weight: bold; margin-bottom: 6px;">IT Asset Form Rev 00-2025-0010</div>
      <img src="qr (1).png" alt="QR Code" style="max-width: 150px; height: auto;" />
      <div style="font-size: 8px; font-weight: bold; margin-top: 4px;">MIS Department</div>
    </td>
  </tr>
</table>

<!-- Assignee Info -->
<div class="form-section">Assignee Information</div>
<table>
  <tr>
    <td>
      <div class="form-group">
        <span>Name: Christian Villamer</span>
      </div>
    </td>
    <td>
      <div class="form-group">
        <span>Designation: Software Engineer II</span>
      </div>
    </td>
    <td>
      <div class="form-group">
        <span>Reports To: [Reports To Data]</span>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="form-group">
        <span>Employee ID: [Employee ID Data]</span>
      </div>
    </td>
    <td rowspan="2">
    <div class="row-group">
        <div class="form-group half-input">
            <span>Business Unit: [Business Unit Data]</span>
        </div>
    </div>
    
    <div class="form-group">
        <span>Duration: [Duration Data]</span>
    </div>
    </td>

    <td>
        <div class="form-group half-input">
            <span>Dept: [Dept Data]</span>
        </div>
    </td>
    <td>
        <div class="form-group">
            <span>Location: [Location Data]</span>
        </div>
    </td>
</tr>
<tr>
    <td>
      <div class="form-group">
        <label>Deployment Type:</label>
      </div>
      <div class="radio-group">
        <label>Deployment Type:</label>
        <label><input type="radio" name="deployment_type"> Permanent</label>
        <label><input type="radio" name="deployment_type"> Temporary</label>
      </div>
    </td>
    <td></td>
  </tr>
</table>

<!-- Hardware Info -->
<div class="form-section">Hardware Information</div>
<table class="table" border="1">
    <thead>
        <tr>
            <td >Asset No</td>
            <td>Model</td>
            <td>Serial No</td>
            <td>Peripherals</td>
        </tr>
    </thead>
</table>
{{-- <table>
  <tr>
    <td>
      <div class="form-group"><label>Desktop Model:</label><span>[Data]</span></div>
      <div class="form-group"><label>Asset Tag:</label><span>[Data]</span></div>
      <div class="form-group"><label>Serial No:</label><span>[Data]</span></div>
    </td>
    <td>
      <div class="form-group"><label>Display Monitor:</label><span>[Data]</span></div>
      <div class="form-group"><label>Asset Tag:</label><span>[Data]</span></div>
      <div class="form-group"><label>Serial No:</label><span>[Data]</span></div>
    </td>
    <td>
      <div class="form-group"><label>Peripherals 1:</label><textarea>[Data]</textarea></div>
    </td>
  </tr>
</table> --}}

<!-- Software Info -->
{{-- <div class="form-section">Software Information</div>
<table>
  <tr>
    <td style="width: 30%; vertical-align: top;">
      <div class="form-group"><label>OS:</label><span>[OS Data]</span></div>
      <div class="form-group"><label>OS Patch Version:</label><span>[Patch Data]</span></div>
    </td>
    <td colspan="2">
      <div class="software-grid">
        <table>
          <tr>
            <td><label><input type="checkbox"> MS Office</label></td>
            <td><label><input type="checkbox"> HCS</label></td>
            <td><label><input type="checkbox"> Acrobat Reader</label></td>
          </tr>
          <tr>
            <td><label><input type="checkbox"> Adobe Acrobat Standard</label></td>
            <td><label><input type="checkbox"> Netsuite Oracle</label></td>
            <td><label><input type="checkbox"> Spark</label></td>
          </tr>
          <tr>
            <td><label><input type="checkbox"> Utilities</label></td>
            <td><label><input type="checkbox"> Google Chrome</label></td>
            <td><label><input type="checkbox"> Endpoint Security</label></td>
          </tr>
          <tr>
            <td><label><input type="checkbox"> HRMS Access</label></td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="3">
      <div class="form-group" style="grid-template-columns: 180px 1fr; margin-top: 10px;">
        <label>Other Software (if any):</label><textarea style="width: 98%;">[Data]</textarea>
      </div>
    </td>
  </tr>
</table> --}}

<!-- Asset Approval Section -->
<div class="form-section">Asset Approval</div>
<table>
  <tr>
    <td style="width: 50%; vertical-align: top;">
      <div class="form-group"><label>Date Requested:</label><span>' . $date_requested . '</span></div>
      <div class="form-group"><label>Date Needed:</label><span>' . $date_needed . '</span></div>
      <div class="form-group"><label>Issued By:</label><span>' . $issued_by . '</span></div>
      <div class="form-group"><label>Ref. RSS Ticket No.:</label><span>' . $rss_ticket_no . '</span></div>
    </td>
    <td style="width: 50%; vertical-align: top;">
      <div style="font-size: 13px; line-height: 1.6; text-align: justify;">
        I hereby received the IT Asset Issuance Form and the details were explained to me by the MIS representative. This also serves as my affirmation that I am responsible for taking good care of the said IT asset and understand the boundaries of the said access privilege provided to me and limited to JAKA Group only.
      </div>
      <div style="margin-top: 40px; text-align: center;">
        <label>Received By:</label><br/>
        <span style="display: inline-block; border-top: 1px solid #000; padding-top: 5px; width: 80%;">(Signature over printed name)</span>
      </div>
    </td>
  </tr>
</table>
<!-- Signature Section -->
<table style="margin-top: 30px; text-align: center;">
  <tr>
    <td style="width: 33%;"><div style="border-top: 1px solid #000; padding-top: 5px; width: 80%; margin: 0 auto;">Approved By:</div></td>
    <td style="width: 33%;"><div style="border-top: 1px solid #000; padding-top: 5px; width: 80%; margin: 0 auto;">Approved By:</div></td>
    <td style="width: 33%;"><div style="border-top: 1px solid #000; padding-top: 5px; width: 80%; margin: 0 auto;">Approved By:</div></td>
  </tr>
</table>

</body>
</html>
