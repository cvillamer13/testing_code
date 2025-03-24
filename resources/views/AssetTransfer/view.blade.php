<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Transfer') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset Transfer</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="scanned_start" href="./add">
                                Add Asset Transfer
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
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
                                            <th class="staff_thead_no">Gatepass No</th>
                                            <th class="staff_thead_name">Inspected By</th>
                                            <th class="staff_thead_name">Time</th>
                                            <th class="staff_thead_name">Recieved By</th>
                                            <th class="staff_thead_status">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>


</script>
</x-app-layout>