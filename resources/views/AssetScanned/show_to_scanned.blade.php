<style>
@keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .new-row {
        animation: fadeIn 0.5s ease-out;
        background-color: lightgreen;
    }


</style>

<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Scanned') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List to Asset Scanned</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="scanned_start">
                                Start Scan Asset
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-barcode color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <input type="text" id="barcodeInput" style="position: absolute; left: -9999px;" autocomplete="off">
                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <h4>History</h4>
                            <table id="example" class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <td>Company</td>
                                        <td>Department</td>
                                        <td>Asset Code</td>
                                        <td>Asset Description</td>
                                        <td>is Scanned</td>
                                        <td>Scanned By</td>
                                        <td>Scanned Date</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody_data">
                                    @foreach ($asset_scanned as $asset)
                                        <tr>
                                            <td>{{ $asset->company->name }}</td>
                                            <td>{{ $asset->department->name }}</td>
                                            <td>{{ $asset->asset->asset_id }}</td>
                                            <td>{{ $asset->asset->asset_description }}</td>
                                            <td>
                                                @if ($asset->isScanned == 1)
                                                    <span class="badge badge-success">Scanned</span>
                                                @else
                                                    <span class="badge badge-danger">Not Scanned</span>
                                                @endif
                                            </td>
                                            <td>{{ $asset->scannedby }}</td>
                                            <td>{{ $asset->scanned_at }}</td>
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
             $("#scanned_start").click(function (e) {
                e.preventDefault(); // Prevent default action

                $(this).toggleClass("btn-info btn-danger");

                if ($(this).hasClass("btn-danger")) { // Start scanning
                    $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-stop-circle color-danger"></i></span> Stop Scan Asset');
                    console.log("Start scanning");

                    isScanning = true;
                    let inputField = document.getElementById("barcodeInput");
                    inputField.focus(); // Ensure input field is active to receive barcode scan
                } else { // Stop scanning
                    $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-barcode color-info"></i></span> Start Scan Asset');
                    console.log("Stop scanning");

                    isScanning = false;
                }
            });


            $("#barcodeInput").on("change", function () {
                let barcode = $(this).val();
                if (isScanning && barcode.trim() !== "") {
                    console.log(barcode)
                    Swal.showLoading()
                    $.ajax({
                        type: "POST",
                        url: "/AssetScanning/getScanned",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            asset_id: barcode
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    title: "Asset Found",
                                    html: `
                                        <div>
                                            <p><strong>Company:</strong> ${response.data.company_data.name}</p>
                                            <p><strong>Department:</strong> ${response.data.department_data.name}</p>
                                            <p><strong>Asset Code:</strong> ${response.data.asset_id}</p>
                                            <p><strong>Asset Description:</strong> ${response.data.asset_description}</p>
                                        </div>
                                    `,
                                    icon: "info",
                                    showCancelButton: true,
                                    confirmButtonText: "Confirm",
                                    cancelButtonText: "Cancel"
                                }).then((result) => {
                                    Swal.showLoading()
                                    if (result.isConfirmed) {
                                        let assetId = response.data.id; // Pre-process data to extract asset ID
                                        Swal.fire({
                                            title: "Processing...",
                                            text: "Please wait while the asset is being processed.",
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                                // var id = document.getElementById("issuance_id").value;
                                                $.ajax({
                                                    type: "POST",
                                                    url: "/AssetScanning/getScanned_new",
                                                    data:   {
                                                        "_token": "{{ csrf_token() }}",
                                                        asset_id: assetId // Use the pre-processed asset ID
                                                    },
                                                    success: function (response) {
                                                        Swal.close();
                                                        toastr.success(response.message);
                                                        console.log(response.data);
                                                        $('#example').DataTable().destroy();
                                                        $('#example').DataTable(); // reinitialize

                                                    },
                                                    error: function(error) {
                                                        if(error.responseJSON.status == "error"){
                                                            Swal.fire({
                                                                title: error.responseJSON.message,
                                                                icon: "error"
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                        
                                    }
                                });
                            }
                            else {
                                Swal.fire({
                                    title: response.message,
                                    icon: "error"
                                });
                            }
                           
                            console.log(response)
                        }
                    });
                    // Swal.fire({
                    //     title: "Do you want to finalized the issuance?",
                    //     text: "Once finalized, you will not be able to make changes and send the issuance will send for approval",
                    //     icon: "warning",
                    //     showDenyButton: true,
                    //     showCancelButton: false,
                    //     confirmButtonText: "Finalize",
                    //     denyButtonText: `Cancel`
                    // }).then((result) => {

                    // });


                    // $.ajax({
                    //     type: "POST",
                    //     url: "/AssetScanning/getScanned_new",
                    //     data:   {
                    //         "_token": "{{ csrf_token() }}",
                    //         asset_id: barcode
                    //     },
                    //     success: function (response) {
                    //         console.log(response.data)
                            
                            
                    //     },
                    //     error: function(error) {
                    //         if(error.responseJSON.status == "error"){
                    //             Swal.fire({
                    //                 title: error.responseJSON.message,
                    //                 icon: "error"
                    //             });
                    //         }
                    //     }
                    // });
                    console.log("Scanned barcode:", barcode);
                    $(this).val(""); // Clear input for next scan
                }
            });
        </script>
        

</x-app-layout>