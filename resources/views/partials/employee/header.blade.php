<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @if (isset($header))
                                {{ $header }}
                        @endif
                        </div>
                
                </div>

                <ul class="navbar-nav header-right">

                    <li class="nav-item notification_dropdown">
                        <a class="nav-link  ai-icon" href="#" role="button" data-bs-toggle="dropdown">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 5C3 4.44772 3.44772 4 4 4H20C20.5523 4 21 4.44772 21 5V19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19V5Z" 
                                stroke="black" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M3 6L12 13L21 6" stroke="black" stroke-width="2" stroke-linejoin="round"/>
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            5
                        </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                            <li><h6 class="dropdown-header">Notifications</h6></li>
                            <li><a class="dropdown-item" href="#">🔔 New message received</a></li>
                            <li><a class="dropdown-item" href="#">📢 System update available</a></li>
                            <li><a class="dropdown-item" href="#">⚠️ Security alert detected</a></li>
                            <li><a class="dropdown-item text-center text-primary" href="#" onclick="clearNotifications()">Clear All</a></li>
                        </ul>
                    </li>

                    <li class="nav-item notification_dropdown">
                        <a class="nav-link  ai-icon" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="mode animated backOutRight" data-id="dark">
                            <svg class="lighticon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g><g><path fill-rule="evenodd" clip-rule="evenodd" d="M18.1377 13.7902C19.2217 14.8742 16.3477 21.0542 10.6517 21.0542C6.39771 21.0542 2.94971 17.6062 2.94971 13.3532C2.94971 8.05317 8.17871 4.66317 9.67771 6.16217C10.5407 7.02517 9.56871 11.0862 11.1167 12.6352C12.6647 14.1842 17.0537 12.7062 18.1377 13.7902Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>
                        </div>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link  ai-icon" href="#" role="button" data-bs-toggle="dropdown">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g> 
                                    <g> 
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75 12C2.75 5.063 5.063 2.75 12 2.75C18.937 2.75 21.25 5.063 21.25 12C21.25 18.937 18.937 21.25 12 21.25C5.063 21.25 2.75 18.937 2.75 12Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.9935 12H16.0025" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.9945 12H12.0035" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.9955 12H8.0045" stroke="#130F26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3">
                                <ul class="timeline">
                                    <li data-val="ltr" class="layout_style">
                                        <div class="timeline-panel">
                                            <div class=" me-2">
                                                <img alt="image" width="120" src="/images/ltr.png">
                                            </div>
                                            
                                        </div>
                                    </li>
                                    <li data-val="rtl" class="layout_style">
                                        <div class="timeline-panel">
                                            <div class=" me-2 ">
                                                <img alt="image" width="120" src="/images/rtl.png">
                                            </div>
                                            
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="{{ session('image_path') }}" width="20" alt=""/>
                            <div class="header-info">
                                <span class="text-black text-capitalize">{{ session('user_name') }}</span>
                                <p class="fs-12 mb-0 text-capitalize">{{ session('user_role') }} </p>
                            </div>
                            
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="/employee/profile/view" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ms-2">profile </span>
                            </a>
                            <a href="/employee/logout" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ms-2">logout</span>
                            </a>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>