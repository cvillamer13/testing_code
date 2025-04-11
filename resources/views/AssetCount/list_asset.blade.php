<x-app-layout>
    <x-slot name="header">
        {{ __('Asset Count Schedule') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card-header">
                    <h4 class="card-title col-6">Asset Count Schedule</h4>
                </div>
                <div class="card py-3 px-3">
                    <div class="card-body">
                        <div class="form-validation">
                            {{-- <form class="needs-validation" action="{{ Route('AssetCount.add') }}" method="post" enctype="multipart/form-data"> --}}
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Year<span class="text-red">*</span></label>
                                        <input type="text" id="year_edit" class="form-control" name="year_edit" value="{{ $asset_count->year }}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">From Date<span class="text-red">*</span></label>
                                        <input type="date" class="form-control" id="from_date_edit" name="from_date_edit" value="{{ $asset_count->date_from }}" readonly>
                                        <input type="hidden" class="form-control" id="from_date" name="from_date" value="{{ $asset_count->date_from }}">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">To Date<span class="text-red">*</span></label>
                                        <input type="date" class="form-control" id="to_date_edit" name="to_date_edit" value="{{ $asset_count->date_to }}" readonly>
                                        <input type="hidden" class="form-control" id="to_date" name="to_date" value="{{ $asset_count->date_to }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Location<span class="text-red">*</span></label>
                                        <input type="hidden" id="location_id" name="location_id" value="{{ $asset_count->location }}">
                                        <input type="text" class="form-control" id="location" name="location" value="{{ $asset_count->location_show->location_data->name }}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Count Type<span class="text-red">*</span></label>
                                        <input type="text" class="form-control" id="count_type" name="count_type" value="{{ $asset_count->type == 'surprise' ? 'Count' : 'Quarterly' }}" readonly>
                                        <input type="hidden" class="form-control" id="count_type" name="count_type" value="{{ $asset_count->type }}">
                                        {{-- <select class="form-control" id="count_type" name="count_type" onchange="toggleQuarterDropdown()" required>
                                            <option disabled selected>Please select</option>
                                            <option value="quarter">Quarter</option>
                                            <option value="surprise">Count</option>
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="row" id="quarter-row" style="display: none;">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Quarter<span class="text-red">*</span></label>
                                        <select class="form-control" id="quarter" name="quarter">
                                            <option disabled selected>Please select</option>
                                            <option value="Q1">Q1</option>
                                            <option value="Q2">Q2</option>
                                            <option value="Q3">Q3</option>
                                            <option value="Q4">Q4</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Filter by Company:</label>
                                        <select id="filter-company" class="form-control">
                                            <option value="">All Companies</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Filter by Department:</label>
                                        <select id="filter-department" class="form-control">
                                            <option value="">All Departments</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Filter by Status:</label>
                                        <select id="filter-status" class="form-control">
                                            <option value="">All Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Filter by Scanned:</label>
                                        <select id="filter-scanned" class="form-control">
                                            <option value="">All</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                
                                

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Location Scope</label>
                                        <table class="table table-striped table-secondary" border="1">
                                            <thead class="thead-light text-center">
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Departments</th>
                                                    <th>Asset Code</th>
                                                    <th>Asset Description</th>
                                                    <th>Status</th>
                                                    <th>is Scanned</th>
                                                    {{-- <th>Scanning</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="company-department-table">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-4 w-100" type="submit">Lock Schedule</button>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleQuarterDropdown() {
            const countType = document.getElementById('count_type').value;
            const quarterRow = document.getElementById('quarter-row');
            if (countType === 'quarter') {
                quarterRow.style.display = 'flex';
            } else {
                quarterRow.style.display = 'none';
            }
        }
        $(document).ready(function () {
            // Fetch the company and department data when the page loads
            fetchCompanyAndDepartment();
            toggleQuarterDropdown();
        });

        function fetchCompanyAndDepartment() {
            const location = document.getElementById('location_id').value;


            // Clear the table before fetching new data
            const tableBody = document.getElementById('company-department-table');
            tableBody.innerHTML = '';

            // Perform an AJAX request to fetch company and department data
            fetch(`/AssetCount/getLocationScope`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ location_id: location })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('company-department-table');
                
                // Object.entries(data.data).forEach(([companyName, departments]) => {
                //     const row = document.createElement('tr');
                //     console.log(companyName);
                    
                //     const companyCell = document.createElement('td');
                //     companyCell.textContent = companyName;
                //     row.appendChild(companyCell);
                    
                //     const departmentCell = document.createElement('td');
                //     const departmentList = document.createElement('ul');
                    
                //     departments.forEach(department => {
                //         const listItem = document.createElement('li');
                //         listItem.textContent = department;
                //         departmentList.appendChild(listItem);
                //     });
                    
                //     departmentCell.appendChild(departmentList);
                //     row.appendChild(departmentCell);
                    
                //     tableBody.appendChild(row);
                // });

                // Object.entries(data.data).forEach(([companyName, departments]) => {
                //     departments.forEach((department, index) => {
                //         const row = document.createElement('tr');

                //         // Add company name cell only in the first row of this group
                //         if (index === 0) {
                //             const companyCell = document.createElement('td');
                //             companyCell.textContent = companyName;
                //             companyCell.rowSpan = departments.length;
                //             row.appendChild(companyCell);
                //         }

                //         // Add department cell
                //         const departmentCell = document.createElement('td');
                //         departmentCell.textContent = department;
                //         row.appendChild(departmentCell);

                //         tableBody.appendChild(row);
                //     });
                // });


                // Object.entries(data.data).forEach(([companyName, departments]) => {
                //     const departmentEntries = Object.entries(departments);

                //     departmentEntries.forEach(([departmentName, assets], index) => {
                //         const row = document.createElement('tr');

                //         // Company cell with rowspan
                //         if (index === 0) {
                //             const companyCell = document.createElement('td');
                //             companyCell.textContent = companyName;
                //             companyCell.rowSpan = departmentEntries.length;
                //             row.appendChild(companyCell);
                //         }

                //         // Department cell
                //         const departmentCell = document.createElement('td')
                //         departmentCell.textContent = departmentName;
                //         row.appendChild(departmentCell);


                //         console.log(assets.length);



                //         tableBody.appendChild(row);
                //     });
                // });


                Object.entries(data.data).forEach(([companyName, departments]) => {
                        const departmentEntries = Object.entries(departments); // [ [deptName, [assets]], ... ]

                        let totalRows = 0;
                        departmentEntries.forEach(([_, assets]) => {
                            totalRows += assets.length;
                        });

                        let companyRowPrinted = false;

                        departmentEntries.forEach(([departmentName, assets], deptIndex) => {
                            assets.forEach((asset, assetIndex) => {
                                const row = document.createElement('tr');

                                // Print company cell once
                                if (!companyRowPrinted) {
                                    const companyCell = document.createElement('td');
                                    companyCell.textContent = companyName;
                                    companyCell.rowSpan = totalRows;
                                    row.appendChild(companyCell);
                                    companyRowPrinted = true;
                                }

                                // Print department cell once per department group
                                if (assetIndex === 0) {
                                    const departmentCell = document.createElement('td');
                                    departmentCell.textContent = departmentName;
                                    departmentCell.rowSpan = assets.length;
                                    row.appendChild(departmentCell);
                                }

                                // Asset Code
                                const codeCell = document.createElement('td');
                                codeCell.textContent = asset.asset_id;
                                row.appendChild(codeCell);

                                // Description
                                const descCell = document.createElement('td');
                                descCell.textContent = asset.asset_description;
                                row.appendChild(descCell);

                                // Status
                                const statusCell = document.createElement('td');
                                statusCell.textContent = asset.status;
                                row.appendChild(statusCell);

                                // Is Scanned
                                const scanCell = document.createElement('td');
                                scanCell.textContent = asset.is_scanned ? 'Yes' : 'No';
                                row.appendChild(scanCell);

                                tableBody.appendChild(row);
                            });
                        });
                    });




            })
            .catch(error => {
                console.error('Error fetching company and department data:', error);
            });
        }
    </script>
</x-app-layout>
