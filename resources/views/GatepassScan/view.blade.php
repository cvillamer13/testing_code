<x-app-layout>
    <style>
        .form-table-property{
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            
        }

        .form-table-property th {
            background: #f0f0f0;
            text-align: center;
            border: 1px solid #000;
            font-size: 12px;
        }

        .form-table-property td{
            text-align: center;
            border: 1px solid #000;
            /* width: 100%; */
            font-size: 12px;
        }


    </style>
    <x-slot name="header">
            {{ __('Gatepass') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Gatepass</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="scanned_start">
                                Start Scan Gatepass
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-barcode color-info"></i>
                                </span>
                            </a>
                        </div>
                        {{-- <input type="hidden" name="date_fetch" id="date_fetch"> --}}
                        <input type="text" id="date_fetch" style="position: absolute; left: -9999px;" autocomplete="off">
                    </div>

                    <div class="card py-3 px-3">
                        <div class="settings-form">
                            <div class="table-responsive">
                                <table id="example7" class="table table-responsive-sm text-center">
                                    <thead>
                                        <tr>
                                            <th class="staff_thead_no">Gatepass No</th>
                                            <th class="staff_thead_name">Inspected By</th>
                                            <th class="staff_thead_name">Time</th>
                                            <th class="staff_thead_name">Recieved By</th>
                                            <th class="staff_thead_status">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $sec)
                                            <tr>
                                                <td>{{ $sec->gatepass_no }}</td>
                                                <td>{{ $sec->inspected_by }}</td>
                                                <td>{{ $sec->inspected_date }}</td>
                                                <td>{{ $sec->recieved }}</td>
                                                <td>{{ $sec->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>

    let isScanning = false;
        
    $("#scanned_start").click(function (e) {
        e.preventDefault(); // Prevent default action

        $(this).toggleClass("btn-info btn-danger");

        if ($(this).hasClass("btn-danger")) { // Start scanning
            $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-stop-circle color-danger"></i></span> Stop Scan Asset');
            console.log("Start scanning");

            isScanning = true;
            let inputField = document.getElementById("date_fetch");
            inputField.focus(); // Ensure input field is active to receive barcode scan
        } else { // Stop scanning
            $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-barcode color-info"></i></span> Start Scan Asset');
            console.log("Stop scanning");

            isScanning = false;
        }
    });


    $("#date_fetch").on("change", function () {
                let barcode = $(this).val();
                // console.log(barcode)
                if (isScanning && barcode.trim() !== "") {
                    Swal.showLoading();
                        $.ajax({
                            type: "POST",
                            url: "/GatepassScan/details",
                            data: {
                                "_token": '{{ csrf_token() }}',
                                "id_data": barcode,
                            },
                            success: function (response) {
                                console.log(response.data.asset_details[0])
                                let data_body = '';
                                for (let index = 0; index <= response.data.asset_details.length - 1; index++) { 
                                    const element = response.data.asset_details[index];

                                    data_body += `<tr>`;
                                    data_body += `<td>${element.asset_id}</td>`;
                                    data_body += `<td>${element.asset_description}</td>`;
                                    data_body += `<td>${element.serial_number}</td>`;
                                    data_body += `<td>1</td>`;
                                    data_body += `<td>Unit</td>`;
                                    data_body += `</tr>`;
                                                    
                                }


                                Swal.fire({
                                    title: "Gatepass info",
                                    html:  `
                                        
                                        <table width="100%">
                                            <tr>
                                                <td align="left"><strong>DATE: ${response.gatepass_info.date_issued} </strong></td>
                                                <td align="right"><strong>GATE PASS NO: ${response.gatepass_info.gatepass_no}</strong> </td>
                                            </tr>
                                        </table>
                                        <table class="form-table-property">
                                            <thead>
                                                <tr>
                                                    <th colspan="6">PROPERTY</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">FROM</th>
                                                    <th colspan="3">TO</th>
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
                                                    <td>${response.from_location.company.name}</td>
                                                    <td>${response.from_location.department.name}</td>
                                                    <td>${response.from_location.name}</td>

                                                    <td>${response.to_location.company.name}</td>
                                                    <td>${response.to_location.department.name}</td>
                                                    <td>${response.to_location.name}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <table width="100%">
                                            <tr>
                                                <td align="left"><strong>DETAILS</strong></td>
                                            </tr>
                                        </table>
                                        <hr>
                                        <table class="form-table-property">
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
                                                `+data_body+`
                                            </tbody>
                                        </table>
                                        <br>
                                        <table width="100%">
                                            <tr>
                                                <td align="left"><strong>RECIEVED BY</strong></td>
                                            </tr>
                                        </table>
                                        <hr>
                                        
                                        <input type="text" class="swal2-input" id="reciever_data" name="reciever_data">

                                    `,
                                    icon: "info",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showDenyButton: true,
                                    showCancelButton: false,
                                    confirmButtonText: "Confirm",
                                    denyButtonText: `Cancel`,
                                    width: "1000px",  // Set custom width

                                    preConfirm: () => {
                                        // Get the value inside the input field
                                        const receivedBy = document.getElementById("reciever_data").value;

                                        // Ensure it's not empty
                                        if (!receivedBy) {
                                            Swal.showValidationMessage("Receiver data is required");
                                        }

                                        return receivedBy;
                                }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const recived_by = result.value; 
                                        Swal.fire({
                                            title: "Processing...",
                                            text: "Please wait ....",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                                // const recived_by = result.value;  
                                                console.log(recived_by)
                                                var gatepass_id = response.gatepass_info.id;
                                                
                                                $.ajax({
                                                    type: "POST",
                                                    url: "/GatepassScan/confirmed_data",
                                                    data: {
                                                        "_token": '{{ csrf_token() }}',
                                                        'recived_by': recived_by,
                                                        'gatepass_id': gatepass_id
                                                    },
                                                    success: function (response) {
                                                        Swal.fire("confirmed!", response.message, response.status );
                                                    }
                                                });
                                            }
                                        })
                                    
                                    } else if (result.isDenied) {
                                        Swal.fire("Changes are not saved", "", "info");
                                    }
                                });
                            }
                        })
                    // Swal.fire({
                    //     title: "Gatepass info",
                    //     html:  ``,
                    //     icon: "info",
                    //     allowOutsideClick: false,
                    //     allowEscapeKey: false,
                    //     showDenyButton: true,
                    //     showCancelButton: false,
                    //     confirmButtonText: "Confirm",
                    //     denyButtonText: `Cancel`,
                    //     width: "1000px",  // Set custom width
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         Swal.fire({
                    //             title: "Processing...",
                    //             text: "Please wait while the gatepass is being reject.",
                    //             allowOutsideClick: false,
                    //             allowEscapeKey: false,
                    //             didOpen: () => {
                    //                 Swal.showLoading();
                    //                 // var gatepass_id = document.getElementById("gatepass_id_data").value
                    //                 // var user_id = "{{ Auth::user()->id }}";
                    //                 // var status = "R";
                    //                 // console.log("data",appr_id)
                    //                 // $.ajax({
                    //                 //     type: "POST",
                    //                 //     url: "/Gatepass/approvers",
                    //                 //     data: {
                    //                 //         "_token": '{{ csrf_token() }}',
                    //                 //         "appr_id": appr_id,
                    //                 //         "user_id": user_id,
                    //                 //         "status": status,
                    //                 //         "gatepass_id": gatepass_id
                    //                 //     },
                    //                 //     success: function (response) {
                    //                 //         // Swal.close();
                    //                 //         toastr.success(response.message);
                    //                 //         location.reload();
                    //                 //     },
                    //                 //     error: function (error) {
                    //                 //         console.log(error)
                    //                 //         toastr.error("Error: " + error.responseJSON.message);
                    //                 //     }
                    //                 // });
                    //             }
                    //         });
                    //     } else if (result.isDenied) {
                    //         Swal.fire("Changes are not saved", "", "info");
                    //     }
                    // });
                    console.log("Scanned barcode:", barcode);
                    $(this).val(""); // Clear input for next scan
                }
    });
</script>
</x-app-layout>