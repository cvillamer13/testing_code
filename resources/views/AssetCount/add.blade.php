<x-app-layout>
    <x-slot name="header">
        {{ __('Asset Count Schedule Setup') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card-header">
                    <h4 class="card-title col-6">Asset Count Setup Schedule</h4>
                </div>
                <div class="card py-3 px-3">
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="needs-validation" action="{{ Route('AssetCount.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Year<span class="text-red">*</span></label>
                                        <select class="form-control" id="year" name="year" required>
                                            <option disabled selected>Please select</option>
                                            @for ($year = now()->year; $year <= 2030; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">From Date<span class="text-red">*</span></label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">To Date<span class="text-red">*</span></label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Location<span class="text-red">*</span></label>
                                        <select class="form-control" id="location" name="location" onchange="fetchCompanyAndDepartment()" required>
                                            <option disabled selected>Please select</option>
                                            @foreach ($locations as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Count Type<span class="text-red">*</span></label>
                                        <select class="form-control" id="count_type" name="count_type" onchange="toggleQuarterDropdown()" required>
                                            <option disabled selected>Please select</option>
                                            <option value="quarter">Quarter</option>
                                            <option value="surprise">Count</option>
                                        </select>
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

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Location Scope</label>
                                        <table class="table table-bordered table-secondary" border="1">
                                            <thead class="thead-light text-center">
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Departments</th>
                                                </tr>
                                            </thead>
                                            <tbody id="company-department-table">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button class="btn btn-primary mt-4 w-100" type="submit">Submit</button>
                            </form>
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
        function fetchCompanyAndDepartment() {
            const location = document.getElementById('location').value;


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
                //     const departmentEntries = Object.entries(departments);
                //     const row = document.createElement('tr');
                    
                //     const companyCell = document.createElement('td');
                //     companyCell.textContent = companyName;
                //     companyCell.rowSpan = departments.length;
                //     row.appendChild(companyCell);

                //     console.log(departments)
                //     departmentEntries.forEach(([departmentName, assets], deptIndex)=> {
                //         const departmentCell = document.createElement('td');
                //         departmentCell.textContent = departmentName;
                //         row.appendChild(departmentCell);
                //     });

                    
                //     // const departmentCell = document.createElement('td');
                //     // const departmentList = document.createElement('ul');
                    
                //     // departments.forEach(department => {
                //     //     const listItem = document.createElement('li');
                //     //     listItem.textContent = department;
                //     //     departmentList.appendChild(listItem);
                //     // });
                    
                //     // departmentCell.appendChild(departmentList);
                //     // row.appendChild(departmentCell);
                    
                //     tableBody.appendChild(row);
                // });



                Object.entries(data.data).forEach(([companyName, departments]) => {
                    const departmentEntries = Object.entries(departments); // [ [deptName, [assets]], ... ]

                    let companyRowPrinted = false;

                    departmentEntries.forEach(([departmentName, assets], deptIndex) => {
                        const row = document.createElement('tr');

                        // Print company cell only once
                        if (!companyRowPrinted) {
                            const companyCell = document.createElement('td');
                            companyCell.textContent = companyName;
                            companyCell.rowSpan = departmentEntries.length;
                            row.appendChild(companyCell);
                            companyRowPrinted = true;
                        }

                        // Print department cell
                        const departmentCell = document.createElement('td');
                        departmentCell.textContent = departmentName;
                        row.appendChild(departmentCell);

                        tableBody.appendChild(row);
                    });
                });


            })
            .catch(error => {
                console.error('Error fetching company and department data:', error);
            });
        }
    </script>
</x-app-layout>
