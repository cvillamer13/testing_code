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
                    @foreach(Session::get('user_permissions') as $permission)
                        @if($permission['isView']) 
                            <li>
                                {{-- pages_checker --}}
                            {{-- <a href="{{ $permission['page'] }}" class="has-arrow ai-icon" aria-expanded="false"> --}}
                            <a onclick="pages_checker({{ $permission['page_id'] }})" class="has-arrow ai-icon" aria-expanded="false">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g> 
                                    <g> 
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.92234 21.8083C6.10834 21.8083 2.85034 21.2313 2.85034 18.9213C2.85034 16.6113 6.08734 14.5103 9.92234 14.5103C13.7363 14.5103 16.9943 16.5913 16.9943 18.9003C16.9943 21.2093 13.7573 21.8083 9.92234 21.8083Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.92231 11.2159C12.4253 11.2159 14.4553 9.1859 14.4553 6.6829C14.4553 4.1789 12.4253 2.1499 9.92231 2.1499C7.41931 2.1499 5.38931 4.1789 5.38931 6.6829C5.38031 9.1769 7.39631 11.2069 9.89031 11.2159H9.92231Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                    </g>
                                </svg>
                                <span class="nav-text ">{{ ucwords(str_replace('-', ' ', basename($permission['page_name']))) }}</span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                @endif
                
                {{-- <!-- PRODUCTS -->
                <li class="has-menu">
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g> 
                            <g> 
                                <path d="M12.0002 2.75C5.06324 2.75 2.75024 5.063 2.75024 12C2.75024 18.937 5.06324 21.25 12.0002 21.25C18.9372 21.25 21.2502 18.937 21.2502 12" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5285 4.30364V4.30364C18.5355 3.42464 17.0185 3.51664 16.1395 4.50964C16.1395 4.50964 11.7705 9.44464 10.2555 11.1576C8.73853 12.8696 9.85053 15.2346 9.85053 15.2346C9.85053 15.2346 12.3545 16.0276 13.8485 14.3396C15.3435 12.6516 19.7345 7.69264 19.7345 7.69264C20.6135 6.69964 20.5205 5.18264 19.5285 4.30364Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.009 5.80078L18.604 8.98378" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            </g>
                        </svg>
                        <span class="nav-text ">Test Dropdown menu</span>
                    </a>
                    <ul aria-expanded="false" class="mm-collapse">
                        <li>
                            <a href="/products/categories" href="javascript:void()" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>menu 1
                            </a>
                        </li>
                        <li>
                            <a href="/products/brands" href="javascript:void()" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>menu 2
                            </a>
                        </li>
                        <li>
                            <a href="/products/units" href="javascript:void()" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>menu 3
                            </a>
                        </li>
                        <li>
                            <a href="/products/view" href="javascript:void()" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>menu 4
                            </a>
                        </li>

                        <li>
                            <a href="/products/print_barcode" href="javascript:void()" aria-expanded="false">
                                <i class="far fa-arrow-alt-circle-right"></i>menu 5
                            </a>
                        </li>
                    </ul>
                </li> --}}
                
                <li class="has-menu">
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
                </li>
                
                
        </ul>
    </div>
</div>