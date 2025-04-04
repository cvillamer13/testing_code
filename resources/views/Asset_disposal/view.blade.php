<x-app-layout>
    <x-slot name="header">
            {{ __('Disposal Asset') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Disposal Asset</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Disposal Asset
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
                                        <th class="staff_thead_no">No</th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                <tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</x-app-layout>