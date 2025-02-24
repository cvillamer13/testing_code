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

                    <div class="card-header">
                        
                        <div class="card-title col-2 text-end">
                            <select class="form-control" name="" id="">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="card-title col-2 text-end">
                            <select class="form-control" name="" id="">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="card-title col-2 text-end">
                            <select class="form-control" name="" id="">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="card-title col-2 text-end">
                            <input type="date" class="form-control" name="" id="">
                        </div>

                        <div class="card-title col-2 text-end">
                            <input type="date" class="form-control" name="" id="">
                        </div>

                        <div class="card-title col-2">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Filter
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-filter color-info"></i>
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

                                    @foreach ($asset_scanned as $scanned)
                                        <tr>
                                            <td>{{ $scanned->asset_id }}</td>
                                            <td>{{ $scanned->scanned_date }}</td>
                                            <td>{{ $scanned->scanned_time }}</td>
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
        

</x-app-layout>