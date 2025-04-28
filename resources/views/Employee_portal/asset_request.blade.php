<x-employee-auth-layout>
    <x-slot name="header">
        {{ __('Asset Request') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Asset Request Form') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('Document No') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Request Date') }}</th>
                                        <th>{{ __('Status') }}</th>
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
</x-employee-auth-layout>