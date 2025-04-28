<x-employee-auth-layout>
    <x-slot name="header">
        {{ __('Asset Recieved') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Asset Recieved Form') }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('Rev No.') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Recieved Date') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset_issuance as $recieved)
                                        <tr>
                                            <td>
                                                <a href="/employee/asset_recieved/issuance/{{ $recieved->id }}" class="btn btn-primary btn-sm" target="_blank" style="text-decoration: none;" title="Hi">
                                                    {{ $recieved->rev_num }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($recieved->is_recieved)
                                                    <span class="badge badge-success">{{ __('Recieved') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $recieved->recieved_at ? \Carbon\Carbon::parse($recieved->recieved_at)->format('F j, Y g:i A') : '' }}</td>
                                            <td>
                                                <a href="/employee/asset_recieved/issuance_pdf/{{ $recieved->id }}" class="btn btn-primary btn-sm" target="_blank">
                                                    {{ __('Print') }}
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

</x-employee-auth-layout>