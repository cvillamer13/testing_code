<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset</h4>
                        {{-- <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="filter_all">
                                Print All
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div> --}}
                    </div>


                    <div class="card-header">
                        {{-- <h4 class="card-title col-6">List of Asset</h4> --}}
                        <div class="card-title col-12">

                            <div class="row">
                                <div class="col-3">
                                    <select class="form-control" name="company_id" id="company_id" onchange="getDepartment()">
                                        <option value="all">All</option>
                                        @foreach ($company as $co)
                                            <option value="{{ $co->id }}">{{ $co->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-3">
                                    <select class="form-control" name="dep_id" id="dep_id" onchange="getLocation()">
                                        <option value="all">All</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <select class="form-control" name="loc_id" id="loc_id">
                                        <option value="all">All</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <a class="btn btn-rounded btn-info" id="filter_id">
                                                Filter
                                                <span class="btn-icon-start text-info"><i
                                                        class="fa fa-print"></i>
                                                </span>
                                            </a>
                                        </div>

                                        <div class="col-6">
                                            <a class="btn btn-rounded btn-info" id="print_id">
                                                Print
                                                <span class="btn-icon-start text-info"><i
                                                        class="fa fa-print"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_no">Asset Code</th>
                                        <th class="staff_thead_name">Asset Description</th>
                                        <th class="staff_thead_email">Company  </th>
                                        <th class="staff_thead_email">Department </th>
                                        <th class="staff_thead_status">Location</th>
                                        <th class="staff_thead_status">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="change_data">
                                    @foreach($asset as $ass)
                                        <tr>
                                            <td>{{ $ass->asset_id }}</td>
                                            <td>{{ $ass->asset_description }}</td>
                                            <td>{{ $ass->company_data->name }}</td>
                                            <td>{{ $ass->department_data->name ?? "No Department Assign" }}</td>
                                            <td>{{ $ass->location_data->location_data->name ?? "No Location Assign" }}</td>
                                            <td><a class="badge badge-lg badge-info" id="staff_id_new" onclick="printbarcode_data({{ $ass->id }})"><i class="fa fa-print"></i>print</a></td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="Logo" name="Logo" value="data:image/png;base64,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" />
        <div class="col-sm-12" id="divQRCode">
            <canvas width="180" height="180" style="display: none;"></canvas>
            <img src="" id="theqrval" style="display: none;">
        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
    <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
    <script src="{{ asset("/js/barcode.js") }}"></script>

    <script>
        function getLocation(){
            const company_id = $("#company_id").val();
            const department_id = $('#dep_id').val();
            $.ajax({
                url: "/Location/getLocation",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id,
                    department_id: department_id
                },
                success: function (response) {
                    let data_str = `<option value="all">All</option>`;
                    // console.log(response)
                    response.forEach(element => {
                        data_str += `<option value="${element.id}">${element.location_data.name}</option>`;
                    });
                    $('#loc_id').html(data_str);
                },
                error: function (error) {
                    toastr.error(data.responseJSON.message);
                }
            });
        }
        function getDepartment(){
            var company_id = $('#company_id').val();
            $.ajax({
                url: '/Location/getDepartment',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id
                },
                success: function(data) {
                    let data_str = `<option value="all">All</option>`;

                    data.forEach(element => {
                        data_str += `<option value="${element.id}">${element.name}</option>`;
                    });
                
                    $('#dep_id').html(data_str);
                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                }
            });
        }

        function textToBase64Barcode(text){
            var canvas = document.createElement("canvas");
            JsBarcode(canvas, text, {
                        width: 2,
                        height: 80,
                        displayValue: false,
                        fontOptions: "",
                        //font: "monospace",
                        text: undefined,
                        textAlign: "center",
                        textPosition: "bottom",
                        textMargin: 2,
                        fontSize: 15,
                        background: "#ffffff",
                        lineColor: "#000000",
                        margin: 10,
                        marginTop: undefined,
                        marginBottom: undefined,
                        marginLeft: undefined,
                        marginRight: undefined,
                        valid: function valid() { }
                    });
            return canvas.toDataURL("image/png");
        }


        function textToBase64QRcode(text) {
            var canvas = document.createElement("canvas"); // Corrected element type
            var qr = new QRCode(canvas, {
                text: text,
                width: 180,
                height: 180,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            setTimeout(() => {
                var dataURL = canvas.toDataURL("image/png");
                console.log(dataURL); // Test output
            }, 500); // Wait for QR code to render before converting to Base64

            return canvas;
        }
        




        $('#filter_id').on('click', function() {
            const company_id = $("#company_id").val();
            const department_id = $('#dep_id').val();
            const location_id = $('#loc_id').val();

            Swal.fire({
                title: "Loading...",
                html: "Please wait a moment",
                allowOutsideClick: false,

            });
            Swal.showLoading();

            $.ajax({
                type: "POST",
                url: "/PrintBarcode/getFilter",
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id,
                    department_id: department_id,
                    location_id: location_id
                },
                success: function (response) {
                    if(response.status == "success"){
                        
                        let data_str = '';
                        response.message.forEach( (data) => {
                            console.log(data)

                            data_str += '<tr>';
                                data_str += '<td>'+data.asset_id+'</td>';
                                data_str += '<td>'+data.asset_description+'</td>';
                                data_str += '<td>'+data.company_data.name+'</td>';
                                data_str += '<td>'+data.department_data.name+'</td>';
                                if(data.location_data == null){
                                    data_str += '<td><span class="badge badge-lg badge-warning">No Location</span></td>';
                                }else{
                                    data_str += '<td>'+ data.location_data.location_data.name +'</td>';
                                }
                                data_str += '<td><a class="badge badge-lg badge-info" id="staff_id_new" onclick="print_one('+data.id+')"><i class="fa fa-print"></i>print</a></td>';
                            data_str += '</tr>';
                        })

                        document.getElementById("change_data").innerHTML = data_str;
                        Swal.close();
                    }
                },
                error: function (error) {
                    
                    Swal.close();
                }
            });
        })


        $('#print_id').on('click', function() {
            const company_id = $("#company_id").val();
            const department_id = $('#dep_id').val();
            const location_id = $('#loc_id').val();

            Swal.fire({
                title: "Loading...",
                html: "Please wait a moment",
                allowOutsideClick: false,

            });
            Swal.showLoading();

            $.ajax({
                type: "POST",
                url: "/PrintBarcode/getFilter",
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id,
                    department_id: department_id,
                    location_id: location_id
                },
                success: function (response) {
                    if(response.status == "success"){

                        const { jsPDF } = window.jspdf;
                        var doc = new jsPDF({
                            orientation: 'portrait',
                            unit: 'mm',
                            format: [89, 100]
                        });
                        let data_str = '';
                        response.message.forEach( (data) => {
                            console.log(data)
                            doc.rect(1, 1.5, doc.internal.pageSize.width - 3, doc.internal.pageSize.height - 25);
                            let data_id = textToBase64Barcode(data.asset_id);
                            var dataLogo = document.getElementById("Logo").value;
                            doc.addImage(data_id, 'JPEG', 36, 3, 50, 10);
                            doc.addImage(dataLogo, 'JPEG', 2, 0.5, 25, 15);
                            doc.setFontSize(12)
                            doc.text('MIS IT ASSET ID TAG', 22, 20)

                            var fontSize = 8;
                            var x = 10;
                            var y = 25;
                            doc.setFontSize(fontSize)
                            doc.text('MIS ASSET CODE', x += 5, y += 5)
                            doc.text(' : ', x + 25, y)
                            doc.text(data.asset_id, x + 28, y)


                            var lineHeight = 5;
                            var descriptionLines = doc.splitTextToSize(data.asset_description, doc.internal.pageSize.width - x - 50)
                            doc.text('DESCRIPTION', x, y += lineHeight)
                            doc.text(' : ', x + 25, y)
                            doc.text(descriptionLines, x + 28, y)
                            var lineHeight2 = doc.getLineHeight();

                            doc.text('ACQ. DATE', x, y += lineHeight2)
                            doc.text(' : ', x + 25, y)
                            doc.text(data.date_of_purchase ?? "NA", x + 28, y)
                            var lineHeigh4 = doc.getLineHeight();

                            var CompanyLines = doc.splitTextToSize(data.company_data.name, doc.internal.pageSize.width - x - 28)
                            doc.text('COMPANY', x, y += lineHeigh4)
                            doc.text(' : ', x + 25, y)
                            doc.text(CompanyLines, x + 28, y)
                            var lineHeigh7 = doc.getLineHeight();

                            var DepartmenyLines = doc.splitTextToSize(data.department_data.name, doc.internal.pageSize.width - x - 28)
                            doc.text('DEPARTMENT', x, y += lineHeigh7)
                            doc.text(' : ', x + 25, y)
                            doc.text(DepartmenyLines, x + 28, y)

                            if(data.location_data == null){
                                var lineHeight3 = doc.getLineHeight();
                                doc.text('LOCATION', x, y += lineHeight3)
                                doc.text(' : ', x + 25, y)
                                doc.text("NA", x + 28, y)
                            }else{
                                var lineHeight3 = doc.getLineHeight();
                                doc.text('LOCATION', x, y += lineHeight3)
                                doc.text(' : ', x + 25, y)
                                doc.text(data.location_data.location_data.name, x + 28, y)
                            }

                            doc.addPage();
                        })

                        var blob = doc.output('bloburl');
                        window.open(blob);
                        Swal.close();
                    }
                },
                error: function (error) {
                    
                    Swal.close();
                }
            });
        })


        function printbarcode_data(id){
            Swal.fire({
                title: "Loading...",
                html: "Please wait a moment",
                allowOutsideClick: false,

            });
            Swal.showLoading();

            $.ajax({
                type: "POST",
                url: "/PrintBarcode/getFilterbyOne",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_data: id,
                },
                success: function (response) {
                    if(response.status == "success"){

                        const { jsPDF } = window.jspdf;
                        var doc = new jsPDF({
                            orientation: 'portrait',
                            unit: 'mm',
                            format: [89, 100]
                        });
                        console.log(response)
                        doc.rect(1, 1.5, doc.internal.pageSize.width - 3, doc.internal.pageSize.height - 25);
                        let data_id = textToBase64Barcode(response.message.asset_id);
                        var dataLogo = document.getElementById("Logo").value;
                        doc.addImage(data_id, 'JPEG', 36, 3, 50, 10);
                        doc.addImage(dataLogo, 'JPEG', 2, 0.5, 25, 15);
                        doc.setFontSize(12)
                        doc.text('MIS IT ASSET ID TAG', 22, 20)

                        var fontSize = 8;
                        var x = 10;
                        var y = 25;
                        doc.setFontSize(fontSize)
                        doc.text('MIS ASSET CODE', x += 5, y += 5)
                        doc.text(' : ', x + 25, y)
                        doc.text(response.message.asset_id, x + 28, y)


                        var lineHeight = 5;
                        var descriptionLines = doc.splitTextToSize(response.message.asset_description, doc.internal.pageSize.width - x - 50)
                        doc.text('DESCRIPTION', x, y += lineHeight)
                        doc.text(' : ', x + 25, y)
                        doc.text(descriptionLines, x + 28, y)
                        var lineHeight2 = doc.getLineHeight();

                        doc.text('ACQ. DATE', x, y += lineHeight2)
                        doc.text(' : ', x + 25, y)
                        doc.text(response.message.date_of_purchase ?? "NA", x + 28, y)
                        var lineHeigh4 = doc.getLineHeight();

                        var CompanyLines = doc.splitTextToSize(response.message.company_data.name, doc.internal.pageSize.width - x - 28)
                        doc.text('COMPANY', x, y += lineHeigh4)
                        doc.text(' : ', x + 25, y)
                        doc.text(CompanyLines, x + 28, y)
                        var lineHeigh7 = doc.getLineHeight();

                        var DepartmenyLines = doc.splitTextToSize(response.message.department_data.name, doc.internal.pageSize.width - x - 28)
                        doc.text('DEPARTMENT', x, y += lineHeigh7)
                        doc.text(' : ', x + 25, y)
                        doc.text(DepartmenyLines, x + 28, y)
                        var lineHeight3 = doc.getLineHeight();

                        if(response.message.location_data == null){
                            doc.text('LOCATION', x, y += lineHeight3)
                            doc.text(' : ', x + 25, y)
                            doc.text("NA", x + 28, y)
                        }else{

                            console.log(response.message.location_data.location_data.name)
                            doc.text('LOCATION', x, y += lineHeight3)
                            doc.text(' : ', x + 25, y)
                            doc.text(response.message.location_data.location_data.name, x + 28, y)
                        }

                        var blob = doc.output('bloburl');
                        window.open(blob);
                        Swal.close();
                    }
                },
                error: function (error) {
                    Swal.close();
                }
            });
        }

    </script>
</x-app-layout>