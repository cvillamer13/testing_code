<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Edit Asset</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                <center><span class="text-red">*</span> - <b>Required</b></center>
                                <br>
                                <form class="needs-validation" action="/Asset/edit/{{ $asset_data->id }}" method="post" enctype="multipart/form-data" id="assetform">
                                    @csrf

                                    <div class="card card-primary card-outline card-tabs">
                                        <div class="card-header p-0 pt-1 border-bottom-0">
                                            <div class="d-flex overflow-auto">
                                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="BasicInfo" data-toggle="pill" href="#divBasicInfo" role="tab" aria-controls="BasicInfo" aria-selected="true">Basic Asset Info</a>
                                                    </li>
                                                    
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="OtherInfo" data-toggle="pill" href="#divOtherInfo" role="tab" aria-controls="OtherInfo" aria-selected="false">Other Info / Specification</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="UploadInfo" data-toggle="pill" href="#divUploadInfo" role="tab" aria-controls="UploadInfo" aria-selected="false">Upload File</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="AssetCompany" data-toggle="pill" href="#divAssetCompany" role="tab" aria-controls="AssetCompany" aria-selected="false">Company / Location</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="OtherTab" data-toggle="pill" href="#divOtherTab" role="tab" aria-controls="OtherTab" aria-selected="false">Asset Assign</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                    
                                        <div class="card-body">
                                            <div class="tab-content" id="tabContent">
                                                <div class="tab-pane fade" id="divUploadInfo" role="tabpanel" aria-labelledby="divUploadInfo">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="ImageURL">Image</label>
                                                                <div class="col-sm-9">
                                                                    <span class="control-fileupload">
                                                                    
                                                                        <input type="file" class="form-control" id="ImageURLDetails" name="ImageURLDetails">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="PurchaseReceipt">Purchase Receipt</label>
                                                                <div class="col-sm-9">
                                                                    <span class="control-fileupload">
                                                                        
                                                                        <input type="file" class="form-control" id="PurchaseReceiptDetails" name="PurchaseReceiptDetails">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="ImageURL">Image</label>
                                                                <div class="col-sm-9">
                                                                    <img class="rounded-circle" width="75" height="60" src="{{ asset('storage/'.$asset_data->image_path ) }}" alt="image">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="PurchaseReceipt">Purchase Receipt</label>
                                                                <div class="col-sm-9">
                                                                    <a href="{{ asset('storage/'.$asset_data->reciept_path ) }}" class="link-primary" target="_blank">{{ $asset_data->reciept_path }}</a>
                                                                </div>
                                                            </div>


                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="AssetId">SI No.</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="si_no" type="text" data-val="true" data-val-required="The Asset Id field is required." name="si_no" value="{{ $asset_data->si_no }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="AssetId">DR No.</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="dr_no" type="text" name="dr_no" value="{{ $asset_data->dr_no }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>


                                                <div class="tab-pane fade" id="divAssetCompany" role="tabpanel" aria-labelledby="divAssetCompany">
                                                    <div class="row">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" for="Company">Company <span class="text-red"> *</span></label>
                                                            <div class="col-sm-9">
                                                                <select id="Company" class="form-control" style="width:100%;" required="" data-val="true" data-val-required="The Company field is required." name="Company" onchange="getDepartment()">
                                                                    <option value selected disabled>Please Choose</option>
                                                                    @foreach ($company as $comp)
                                                                        @if ($comp->id == $asset_data->company_id)
                                                                            <option value="{{ $comp->id }}" selected>{{ $comp->name }}</option>
                                                                        @else
                                                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                                                        @endif
                                                                        
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger field-validation-valid" data-valmsg-for="Company" data-valmsg-replace="true"></span>
                                                            </div>
                                                        </div>
                
                
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" for="Department">Department<span class="text-red"> *</span></label>
                                                            <div class="col-sm-9">
                
                                                                <select id="Department" class="form-control" style="width:100%;" data-val="true" data-val-required="The Department field is required." name="Department">
                                                                    <option value selected disabled>Please Choose</option>
                                                                </select>
                                                                <span class="text-danger field-validation-valid" data-valmsg-for="Department" data-valmsg-replace="true"></span>
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" for="LocationArea">Location<span class="text-red"> *</span></label>
                                                            <div class="col-sm-9">
                                                                <select id="LocationArea" class="form-control" style="width:100%;" required="" data-val="true" data-val-required="The LocationArea field is required." name="LocationArea">
                                                                    <option value selected disabled>Please Choose</option>
                                                                </select>
                                                                <span class="text-danger field-validation-valid" data-valmsg-for="LocationArea" data-valmsg-replace="true"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade active show" id="divBasicInfo" role="tabpanel" aria-labelledby="divBasicInfo">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="AssetId">Asset Number: <span class="text-red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="AssetId" type="text" data-val="true" data-val-required="The Asset Id field is required." name="AssetId" onkeyup="getBarcode()" value="{{ $asset_data->asset_id }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="AssetId" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-5 col-form-label"> Accounting Asset Number: <span class="text-red"> *</span></label>
                                                                <div class="col-sm-7">
                                                                    <input class="form-control" id="MISAssetNo" type="text" name="MISAssetNo" value="{{ $asset_data->accounting_code }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="MISAssetNo" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="Name"> Name <span class="text-red"> *</span></label>
                    
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="Name" type="text" required="" data-val="true" data-val-required="The Name field is required." name="Name" value="{{ $asset_data->name }}">
                    
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="AssetModelNo">Asset Model No <span class="text-red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="AssetModelNo" type="text" name="AssetModelNo" value="{{ $asset_data->model_no }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="AssetModelNo" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="Description">Description <span class="text-red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    {{-- <input class="form-control" id="Description" type="text" required="" name="Description" value=""> --}}
                                                                    <textarea class="form-control" id="Description" name="Description">{{ $asset_data->asset_description }}</textarea>
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="Description" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="Unit">Unit<span class="text-red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select id="Unit" class="form-control" style="width:100%;" data-val="true" data-val-required="The Unit field is required." name="Unit" required>
                                                                        <option value selected disabled>Please Choose</option>
                                                                        @foreach ($unit as $un )
                                                                            @if ($un->id == $asset_data->unit_id)
                                                                                <option value="{{ $un->id }}" selected>{{ $un->name }}</option>
                                                                            @else
                                                                                <option value="{{ $un->id }}">{{ $un->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="Unit" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-sm-12">
                                                                    <img alt="" id="Barcode" src="">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="Barcode" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <div class="col-6 col-sm-6">
                                                                
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label" for="Category">Category <span class="text-red"> *</span></label>
                                                                    <div class="col-sm-9">
                                                                        <select id="Category" class="form-control" style="width:100%;" required="" data-val="true" data-val-required="The Category field is required." name="Category">
                                                                            <option value selected disabled>Please Choose</option>
                                                                            @foreach ($category as $cat)
                                                                                
                                                                                @if ($cat->id == $asset_data->category)
                                                                                    <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                                                                @else
                                                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger field-validation-valid" data-valmsg-for="Category" data-valmsg-replace="true"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label" for="Supplier">Supplier</label>
                                                                    <div class="col-sm-9">
                                                                        <select id="Supplier" class="form-control" style="width:100%;" data-val="true" data-val-required="The Supplier field is required." name="Supplier">
                                                                            <option value selected disabled>Please Choose</option>
                                                                            @foreach ($supplier as $supp)
                                                                                @if ($supp->id == $asset_data->supplier_id)
                                                                                    <option value="{{ $supp->id }}" selected>{{ $supp->name }}</option>
                                                                                @else
                                                                                    <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                                                                @endif
                                                                                
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger field-validation-valid" data-valmsg-for="Supplier" data-valmsg-replace="true"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label" for="AssetStatus"> Asset Status<span class="text-red"> *</span></label>
                                                                    <div class="col-sm-9">
                                                                        <select id="AssetStatus" class="form-control" style="width:100%;" required="" data-val="true" data-val-required="The Asset Status field is required." name="AssetStatus">
                                                                            <option value selected disabled>Please Choose</option>
                                                                            @foreach ($status_asset as $stars)
                                                                                
                                                                                @if ($stars->id == $asset_data->asset_status_id)
                                                                                    <option value="{{ $stars->id }}" selected>{{ $stars->status }}</option>
                                                                                @else
                                                                                    <option value="{{ $stars->id }}">{{ $stars->status }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                            
                                                                        </select>
                                                                        <span class="text-danger field-validation-valid" data-valmsg-for="AssetStatus" data-valmsg-replace="true"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-sm-12" id="divQRCode">
                                                                        <canvas width="180" height="180" style="display: none;"></canvas>
                                                                        <img src="" style="display: block;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                    {{-- <a class="nav-link" id="OtherInfo1" data-toggle="pill" href="#divOtherInfo" role="tab" aria-controls="OtherInfo" aria-selected="false">Other Info</a> --}}
                                                    {{-- <a class="btn btn-outline-primary" id="OtherInfo" data-toggle="pill" href="#divOtherInfo" role="tab" aria-controls="OtherInfo" aria-selected="false">Next</a> --}}
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="divOtherInfo" role="tabpanel" aria-labelledby="divOtherInfoTab">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="UnitPrice">Purchase Price</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="UnitPrice" type="number" data-val="true" data-val-number="The field Purchase Price must be a number." name="UnitPrice" value="{{ $asset_data->unit_price }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="UnitPrice" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label" for="DateOfPurchase">Date Of Purchase</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" type="date" data-val="true" data-val-required="The Date Of Purchase field is required." id="DateOfPurchase" name="DateOfPurchase" value="{{ $asset_data->date_of_purchase }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="DateOfPurchase" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label" for="DateOfManufacture">Date Of Manufacture</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" id="DateOfManufacture" type="date" data-val="true" data-val-required="The Date Of Manufacture field is required." name="DateOfManufacture" value="{{ $asset_data->date_manufacture }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="DateOfManufacture" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label" for="WarranetyInMonth">Warranty In Month</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" id="WarranetyInMonth" type="text" name="WarranetyInMonth" value="{{ $asset_data->warranty_month }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="WarranetyInMonth" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label" for="DepreciationInMonth">Depreciation In Month</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" id="DepreciationInMonth" type="text" name="DepreciationInMonth" value="{{ $asset_data->deprication_month }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="DepreciationInMonth" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                    
                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="serial_number">Serial Number</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="serial_number" type="text" name="serial_number" value="{{ $asset_data->serial_number }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="serial_number" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                    
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="OSDetails">OS Details</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="OSDetails" type="text" name="OSDetails" value="{{ $asset_data->os_details }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="OSDetails" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="processor_model">Processor Model</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="processor_model" type="text" name="processor_model" value="{{ $asset_data->processor_model }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="processor_model" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="desk_details">Disk Details</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="desk_details" type="text" name="desk_details" value="{{ $asset_data->desk_details }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="desk_details" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="ram_details">Ram Details</label>
                                                                <div class="col-sm-9">
                                                                    <input class="form-control" id="ram_details" type="text" name="ram_details" value="{{ $asset_data->ram_details }}">
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="ram_details" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" for="Note">Note</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" id="Note" type="text" rows="3" name="Note">{{ $asset_data->note }}</textarea>
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="Note" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="tab-pane fade" id="divOtherTab" role="tabpanel" aria-labelledby="divOtherTab">
                                                    <div class="row">
                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label" for="AssignEmployeeId">Assign Employee</label>
                                                                <div class="col-sm-12">
                                                                    <select id="AssignEmployeeId" class="form-control" style="width:100%;" data-val="true" data-val-required="The Assign Employee field is required." name="AssignEmployeeId">
                                                                        <option value selected disabled>Please Choose</option>
                                                                        @foreach ($employee as $emp)
                                                                            @if ($emp->id == $asset_data->assign_employee_id)
                                                                                <option value="{{ $emp->id }}" selected>{{ $emp->first_name ." ". $emp->last_name  }}</option>
                                                                            @else
                                                                                <option value="{{ $emp->id }}">{{ $emp->first_name ." ". $emp->last_name  }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger field-validation-valid" data-valmsg-for="AssignEmployeeId" data-valmsg-replace="true"></span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-6 col-sm-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-12 col-form-label" for="AssignEmployeeId">If Not Applicable Please check this to assign in department</label>
                                                                <div class="col-sm-12">
                                                                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                                                        <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                                                                        <label class="btn btn-outline-primary" for="btncheck1">Assign to Department</label>
                                                                        <input type="hidden" name="assntodep" id="assntodep" value="{{ $asset_data->isDepartmentAssign }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="button" id="btnSave" class="btn btn-outline-primary mt-4 w-100" value="Submit">
                                            {{-- <button type="button" class="btn btn-outline-primary mt-4 w-100">Submit</button> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/jsbarcode@latest/dist/JsBarcode.all.min.js"></script>
        <script src="{{ asset("/js/barcode.js") }}"></script>
        <script>
            
            
            var GenerateQRCode = function () {
                var _QRCode = $("#AssetId").val();
            
                $('#divQRCode').empty();
                var qrcode = new QRCode("divQRCode", {
                    text: _QRCode,
                    width: 180, //default 128
                    height: 180,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
            function getBarcode(){
                let getVal = document.getElementById("AssetId").value;
                console.log(getVal.length)
                if(getVal.length > 0){
                    JsBarcode("#Barcode", getVal,  {
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


                    GenerateQRCode();
                }else {
                    
                    document.getElementById("Barcode").src = "";
                    $('#divQRCode').empty();
                }
                
                
            }

            function getDepartment(){
                        var company_id = $('#Company').val();
                        $.ajax({
                            url: '/Location/getDepartment',
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                company_id: company_id
                            },
                            success: function(data) {
                                let data_str = `<option value="" disabled selected>Select Department</option>`;
                                data.forEach(element => {
                                    const dep_id = "{{ $asset_data->department_id }}";
                                    if (element.id == dep_id) {
                                        data_str += `<option value="${element.id}" selected>${element.name}</option>`;
                                        getLocation(company_id, dep_id)
                                    } else {
                                        data_str += `<option value="${element.id}">${element.name}</option>`;
                                    }
                                    
                                });
                            
                                $('#Department').html(data_str);
                            },
                            error: function(data) {
                                toastr.error(data.responseJSON.message);
                            }
                        });
            }

            function getSelected(){
                const NAdep = $("#assntodep").val();
                if(NAdep == "true"){
                    document.getElementById("AssignEmployeeId").disabled = true;
                    document.getElementById("btncheck1").checked = true;
                }else{;
                    document.getElementById("AssignEmployeeId").disabled = false;
                    document.getElementById("btncheck1").checked = false;
                }
            }
            function getLocation(com_id, dep_id){
                $.ajax({
                        url: "/Location/getLocation",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            company_id: com_id,
                            department_id: dep_id
                        },
                        success: function (response) {
                            let data_str = `<option value="" disabled selected>Select Location</option>`;
                            
                            response.forEach(element => {
                                const loc_id = "{{ $asset_data->location_id }}";
                                if (element.id == loc_id) {
                                    data_str += `<option value="${element.id}" selected>${element.name}</option>`;
                                    
                                } else {
                                    data_str += `<option value="${element.id}">${element.name}</option>`;
                                }
                                
                            });
                            $('#LocationArea').html(data_str);
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                        }
                    });
            }
            $(document).ready(function() {
                $('#Department').on('change', function() {
                    const company_id = $("#Company").val();
                    const department_id = $(this).val();
                    getLocation(company_id, department_id);
                })

                $('#btncheck1').on('click', function() {
                    const NAdep = $("#assntodep").val();
                    if(NAdep == "true"){
                        $("#assntodep").val("false");
                        document.getElementById("AssignEmployeeId").disabled = false;
                    }else{
                        $("#assntodep").val("true");
                        document.getElementById("AssignEmployeeId").disabled = true;
                    }
                })
                getSelected();
                getDepartment();
                getBarcode();
                GenerateQRCode();
                $('#btnSave').on('click', function() {
                    // alert("test");
                    let form = document.getElementById("assetform");
                    form.submit();
                })
            });
        </script>
    
</x-app-layout>