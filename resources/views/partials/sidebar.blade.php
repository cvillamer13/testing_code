<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">

                <li>
                    <a class="has-arrow ai-icon" href="/dashboard" href="javascript:void()" aria-expanded="false">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g> 
                                    <path d="M9.07861 16.1355H14.8936" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.3999 13.713C2.3999 8.082 3.0139 8.475 6.3189 5.41C7.7649 4.246 10.0149 2 11.9579 2C13.8999 2 16.1949 4.235 17.6539 5.41C20.9589 8.475 21.5719 8.082 21.5719 13.713C21.5719 22 19.6129 22 11.9859 22C4.3589 22 2.3999 22 2.3999 13.713Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        <span class="nav-text ">Dashboard</span>
                    </a>
                </li>
                <!-- Loop through the user permissions stored in session -->
                @if(Session::has('user_permissions'))
                    @php
                        $grouped = collect(Session::get('user_permissions'))->groupBy('pages_category');
                    @endphp
                    @foreach($grouped as $category => $permissions)
                        <li class="has-menu">
                            <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                                <i class="far fa-folder"></i>
                                <span class="nav-text">{{ ucwords(str_replace('_', ' ', $category)) }}</span>
                            </a>
                            <ul aria-expanded="false">
                                @foreach($permissions as $permission)
                                    @if($permission['isView'])
                                        <li>
                                            <a onclick="pages_checker({{ $permission['page_id'] }})" class="ai-icon" aria-expanded="false">
                                                <i class="{{ $permission['icon_data'] ?? 'far fa-circle' }}"></i>
                                                <span class="nav-text">{{ ucwords(str_replace('-', ' ', basename($permission['page_name']))) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                @endif
                
                
                {{-- <li class="has-menu">
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <!-- <i class="menu-icon la la-money-check-alt"></i> -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                              <g>
                                <path d="M6.91699 14.854L9.90999 10.965L13.324 13.645L16.253 9.86499" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.6671 2.3501C20.7291 2.3501 21.5891 3.2101 21.5891 4.2721C21.5891 5.3331 20.7291 6.1941 19.6671 6.1941C18.6051 6.1941 17.7451 5.3331 17.7451 4.2721C17.7451 3.2101 18.6051 2.3501 19.6671 2.3501Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M20.7555 9.26898C20.8885 10.164 20.9495 11.172 20.9495 12.303C20.9495 19.241 18.6375 21.553 11.6995 21.553C4.76246 21.553 2.44946 19.241 2.44946 12.303C2.44946 5.36598 4.76246 3.05298 11.6995 3.05298C12.8095 3.05298 13.8005 3.11198 14.6825 3.23998" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </g>
                            </g>
                        </svg>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li class="text-nowrap">
                            <a href="/User/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>User
                            </a>
                        </li>
                        <li class="text-nowrap">
                            <a href="/Roles/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Roles
                            </a>
                        </li>
                        <li class="text-nowrap">
                            <a href="/Permissions/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Roles Permissions
                            </a>
                        </li>

                        <li class="text-nowrap">
                            <a href="/Company/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Company
                            </a>
                        </li>

                        <li class="text-nowrap">
                            <a href="/Department/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Department
                            </a>
                        </li>
                        <li class="text-nowrap">
                            <a href="/Location/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Location
                            </a>
                        </li>

                        <li class="text-nowrap">
                            <a href="/Approvers/view" class="ai-icon" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>Approval Matrix
                            </a>
                        </li>
                    </ul>
                </li> --}}
                
                
        </ul>
    </div>
</div>