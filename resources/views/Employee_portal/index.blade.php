<x-employee-auth-layout>
    <x-slot name="header">
            {{ __('Dashboard') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Profile Overview') }}
                    </div>
                    <div class="card-body">
                        <p>{{ __('Welcome back, John Doe!') }}</p>
                        <p>{{ __('Your last login was on: ') }} {{ now()->toFormattedDateString() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Recent Activities') }}
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>{{ __('Completed task: Update employee records') }}</li>
                            <li>{{ __('Submitted report: Monthly sales data') }}</li>
                            <li>{{ __('Scheduled meeting: Team sync-up') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-employee-auth-layout>