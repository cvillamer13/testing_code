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
                    <input type="text" id="barcode_input" style="position: absolute; opacity: 0;" autocomplete="off">

                    <h1 id="test123"></h1>
                    {{-- <div class="card-header">
                        
                        <div class="card-title col-2">
                            <label>Company </label>
                            <select class="form-control" name="" id="">
                                <option value="all">ALL</option>
                            </select>
                        </div>

                        <div class="card-title col-2">
                            <label>Company </label>
                            <select class="form-control" name="" id="">
                                <option value="all">ALL</option>
                            </select>
                        </div>

                        <div class="card-title col-2">
                            <label>Department </label>
                            <select class="form-control" name="" id="">
                                <option value="all">ALL</option>
                            </select>
                        </div>

                        <div class="card-title col-2">
                            <label>From </label>
                            <input type="date" class="form-control" name="" id="">
                        </div>

                        <div class="card-title col-2">
                            <label>To </label>
                            <input type="date" class="form-control" name="" id="">
                        </div>

                        <div class="card-title col-2">
                            <label>Status </label>
                            <select class="form-control" name="" id="">
                                <option value="all">ALL</option>
                                <option value="all">Scanned</option>
                                <option value="all">Not Scanned</option>
                            </select>
                        </div>

                        
                    </div> --}}

                    {{-- <div class="card-title col-2">
                        <a class="btn btn-rounded btn-info" data-target="#exampleModal">
                            Filter
                            <span class="btn-icon-start text-info"><i
                                    class="fa fa-filter color-info"></i>
                            </span>
                        </a>
                    </div> --}}

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <h4>History</h4>
                            <table id="example2" class="table table-responsive-sm text-center">
                                <thead>
                                    {{-- <tr>
                                        <th class="staff_thead_email">Asset Id </th>
                                        <th class="staff_thead_no">Date</th>
                                        <th class="staff_thead_name">Time</th>
                                    </tr> --}}
                                </thead>
                                <tbody id="tbody_data">

                                    @foreach ($asset_scanned as $scanned)
                                        <tr>
                                            <td>{{ is_null($scanned->getAsset) == 1 ?  "No Asset: " . $scanned->asset_id : $scanned->getAsset->asset_id   }}</td>
                                            <td>{{ date("F j, Y", strtotime($scanned->scanned_date))  }}</td>
                                            <td>{{date("h:i A", strtotime($scanned->scanned_time)) }}</td>
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
            // $('#scanned_start').click(function (e) { 
            //     $(this).toggleClass("btn-info btn-danger");
            //     if ($(this).hasClass("btn-danger")) {
            //         $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-stop-circle color-danger"></i></span> Stop Scan Asset');

            //         console.log("start")
            //         let barcodestring = '';
            //         document.addEventListener('keypress', function(event) {
            //             console.log("Key pressed:", event.key);

            //             if(event.key = ""){
            //                 console.log("Scanned barcode:", barcodestring);
            //                 barcodestring = ""; 
            //             }else{
            //                 barcodestring += event.key
            //             }
            //         });
            //     } else {
            //         $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-barcode color-info"></i></span> Start Scan Asset');
            //         console.log("stop")
            //     }
            // });


            let isScanning = false;
            let barcodeInput = document.getElementById("barcode_input");

            $('#scanned_start').click(function (e) {
                e.preventDefault(); 
                $(this).toggleClass("btn-info btn-danger");

                if ($(this).hasClass("btn-danger")) { 
                    $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-stop-circle color-danger"></i></span> Stop Scan Asset');
                    console.log("Start scanning");

                    isScanning = true;
                    barcodeInput.value = ""; // Clear previous input
                    barcodeInput.focus(); // Focus input field (works for mobile scanners)
                } else { 
                    $(this).html('<span class="btn-icon-start text-info"><i class="fa fa-barcode color-info"></i></span> Start Scan Asset');
                    console.log("Stop scanning");

                    isScanning = false;
                    barcodeInput.blur(); // Remove focus
                }
            });

            // Capture barcode from input field
            barcodeInput.addEventListener("input", function () {
                console.log(isScanning)
                if (isScanning) {
                    console.log("Scanned barcode:", barcodeInput.value);
                    alert(barcodeInput.value)
                    barcodeInput.value = ""; // Reset after reading barcode
                }
            }
        );


        </script>
        

</x-app-layout>