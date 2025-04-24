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
            
                
                
        </ul>
    </div>
</div>