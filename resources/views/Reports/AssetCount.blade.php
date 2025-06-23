<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Count Report') }}
    </x-slot>

    <div class="card">
        <div class="card-header">
            
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-responsive-xl  text-center">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">Year</th>
                            <th class="staff_thead_name" colspan="2">Date range</th>
                            <th class="staff_thead_email">Count type </th>
                            <th class="staff_thead_edit">Quarter</th>
                            <th class="staff_thead_edit">Location</th>
                            <th class="staff_thead_edit">Lock Status</th>
                            <th class="staff_thead_edit">Print</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_asset_count as $assetcount)
                            <tr>
                                <td>{{ $assetcount->year }}</td>
                                <td>{{ \Carbon\Carbon::parse($assetcount->date_from)->format('F d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($assetcount->date_to)->format('F d, Y') }}</td>
                                <td>
                                    @if ($assetcount->type === 'quarter')
                                        Quarter
                                    @elseif ($assetcount->type === 'count')
                                        Count
                                    @else
                                        {{ $assetcount->type }}
                                    @endif
                                </td>
                                <td>
                                    @switch($assetcount->quarter)
                                        @case('Q1')
                                            1st Quarter
                                            @break
                                        @case('Q2')
                                            2nd Quarter
                                            @break
                                        @case('Q3')
                                            3rd Quarter
                                            @break
                                        @case('Q4')
                                            4th Quarter
                                            @break
                                        @default
                                            {{ $assetcount->quarter }}
                                    @endswitch
                                </td>
                                <td class="staff_tbody_edit">{{ $assetcount->location_show->location_data->name }}</td>
                                <td class="staff_tbody_edit">
                                    @if ($assetcount->is_finalized == 1)
                                        <span class="badge bg-success">Locked</span>
                                    @else
                                        <span class="badge bg-danger">Unlocked</span>
                                    @endif
                                </td>
                                <td class="staff_tbody_edit">
                                    <a href="/AssetReport/pdf/assetcount/{{ $assetcount->id }}" target="_blank" class="btn btn-primary">Print</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>