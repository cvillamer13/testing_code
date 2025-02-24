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
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Scan Asset
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-barcode color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_email">Asset Id </th>
                                        <th class="staff_thead_no">Date</th>
                                        <th class="staff_thead_name">Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        

</x-app-layout>