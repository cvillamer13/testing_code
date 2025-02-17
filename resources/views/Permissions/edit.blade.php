<x-app-layout>
    <x-slot name="header">
            {{ __('Permissions') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">Roles Permissions for {{ $roles->name }}</h4>
        </div>
        <form method="POST" action="{{ route('permissions.update', $roles->id) }}">
            @csrf
            @method('POST') <!-- Use POST to update -->
        
            <div class="card-body">
                @foreach ($pages as $category => $categoryPages)
                {{-- <pre> --}}
                {{-- {{ print_r($categoryPages->first()->page_category_data->name) }} --}}
                <p>
                    <button class="btn btn-outline-info" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($category) }}" aria-expanded="false">
                        {{ $categoryPages->first()->page_category_data->name }}
                    </button>
                </p>
                <div class="collapse" id="collapse-{{ Str::slug($category) }}">
                    <div class="card card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>View</th>
                                        <th>Create</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                        <th>Process</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryPages as $page)
                                    @php
                                        $permission = $permissions->where('pages_id', $page->id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $page->name }}</td>
                                        <td><input type="checkbox" name="permissions[{{ $page->id }}][view]" {{ $permission && $permission->isView ? 'checked' : '' }}></td>
                                        <td><input type="checkbox" name="permissions[{{ $page->id }}][create]" {{ $permission && $permission->isCreate ? 'checked' : '' }}></td>
                                        <td><input type="checkbox" name="permissions[{{ $page->id }}][update]" {{ $permission && $permission->isUpdate ? 'checked' : '' }}></td>
                                        <td><input type="checkbox" name="permissions[{{ $page->id }}][delete]" {{ $permission && $permission->isDelete ? 'checked' : '' }}></td>
                                        <td><input type="checkbox" name="permissions[{{ $page->id }}][process]" {{ $permission && $permission->isProcess ? 'checked' : '' }}></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div> 
            {{-- <button type="submit" class="btn btn-primary">Save Permissions</button> --}}
        </form>
        
        
        
    </div>

        @csrf
</div>
</x-app-layout>