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
                        <h4 class="card-title col-6">List of Asset Scanned</h4>
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
                                        <td>Year</td>
                                        <td>From</td>
                                        <td>To</td>
                                        <td>Type</td>
                                        <td>Location</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody_data">

                                    @foreach ($asset_scanned as $scanned)
                                        <tr>
                                            <td>{{ $scanned->year }}</td>
                                            <td>{{ \Carbon\Carbon::parse($scanned->date_from)->format('F j, Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($scanned->date_to)->format('F j, Y')}}</td>
                                            <td>{{ $scanned->type == 'surprise' ? 'Count' : 'Quarterly'   }}</td>
                                            <td>{{ $scanned->location_show->location_data->name }}</td>
                                            <td>
                                                <a href="/AssetScanning/scanned/{{ $scanned->id }}" class="btn btn-info">
                                                    Start Scan Asset
                                                </a>
                                            </td>
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
                    $.ajax({
                        type: "POST",
                        url: "./getScanned",
                        data:   {
                            "_token": "{{ csrf_token() }}",
                            asset_id: barcode
                        },
                        success: function (response) {
                            console.log(response.data)
                            Swal.fire({
                                title: "<h1>Details of Asset.</h1>",
                                // text: "You won't be able to revert this!",
                                html: `
                                    <table class="table-primary">
                                        <tr>
                                                <td>Asset Code: <b>`+ response.data.asset_id + `</b></td>
                                        </tr>
                                        <tr>
                                                <td>Asset Name: `+ response.data.name + `</td>
                                        </tr>
                                        <tr>
                                                <td>Asset Class: `+ response.data.category_data.name + `</td>
                                        </tr>
                                        <tr>
                                                <td>Asset Description: `+ response.data.asset_description + `</td>
                                        </tr>
                                        <tr>
                                                <td>Location: `+ response.data.location_data.location_data.name || "NO LOCATION" + `</td>
                                        </tr>
                                    </table>

                                    <div class="row">
                                    </div>
                                `,
                                // icon: "warning",
                                
                                showCancelButton: true,
                                // confirmButtonColor: "#3085d6",
                                // cancelButtonColor: "#d33",
                                confirmButtonText: "Finalize",
                                allowOutsideClick: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Swal.fire({
                                    // title: "Deleted!",
                                    // text: "Your file has been deleted.",
                                    // icon: "success"
                                    // });

                                    $.ajax({
                                        type: "POST",
                                        url: "./scanned_data",
                                        data:   {
                                            "_token": "{{ csrf_token() }}",
                                            asset_id: response.data.id
                                        },
                                        success: function (response1) {
                                            console.log(response1)

                                            if(response1.status == "success"){
                                                Swal.fire({
                                                    title: "Asset Scanned!",
                                                    html: `
                                                        Scanned Date : <b>${response1.message.scanned_date}</b><br>
                                                        Scanned Time : <b>${response1.message.scanned_time}</b><br>
                                                        Scanned By : <b>${response1.message.updatedby}</b>
                                                    `,
                                                    icon: "success"
                                                });

                                                let table = document.getElementById("example2").getElementsByTagName('tbody')[0];
                                                let newRow = table.insertRow(0);
                                                newRow.classList.add("new-row");
                                                

                                                let cell1 = newRow.insertCell(0);
                                                let cell2 = newRow.insertCell(1);
                                                let cell3 = newRow.insertCell(2);
                                                
                                                cell1.innerHTML= response1.message.asset_id
                                                cell2.innerHTML= response1.message.scanned_date
                                                cell3.innerHTML= response1.message.scanned_time
                                                newRow.style.backgroundColor = "red";
                                                setTimeout(() => {
                                                    newRow.style.transition = "background-color 2s ease";
                                                    newRow.style.backgroundColor = "transparent";
                                                }, 500);
                                            }
                                        },
                                        error: function name(error) {
                                            console.log(error.responseJSON)
                                            if(error.responseJSON.status == "info"){
                                                Swal.fire({
                                                    title: error.responseJSON.titled,
                                                    html : error.responseJSON.message,
                                                    icon: error.responseJSON.status 
                                                });
                                            }
                                        }
                                    });
                                }
                            });
                            
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
                    console.log("Scanned barcode:", barcode);
                    $(this).val(""); // Clear input for next scan
                }
            });

        </script>
        

</x-app-layout>