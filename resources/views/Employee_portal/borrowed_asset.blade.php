<x-employee-auth-layout>
    <x-slot name="header">
        {{ __('Asset Transmittal') }}
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Asset Transmittal Form') }}
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="scanned_start" href="/employee/trans_add">
                                Add Borrowed Asset
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('Document No') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($borrowed_asset as $borrowed)
                                        <tr>
                                            <td>{{ $borrowed->ref_num }}</td>
                                            <td>
                                                @if ($borrowed->status == 'P')
                                                    <span class="badge badge-danger">{{ __('Pending') }}</span>
                                                @elseif ($borrowed->status == 'A')
                                                    <span class="badge badge-success">{{ __('Approved') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/employee/borrowed_asset/{{ $borrowed->id }}" class="btn btn-primary btn-sm" target="_blank" style="text-decoration: none;" title="Hi">
                                                    {{ __('View') }}
                                                </a>
                                                <a href="/employee/borrowed_asset_pdf/{{ $borrowed->id }}" class="btn btn-warning btn-sm" target="_blank">
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