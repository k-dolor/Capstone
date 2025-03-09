    {{-- ////////TOP LOGO//////// --}}
    {{-- <div class="iq-sidebar sidebar-default" style="background-color: #f8f9fa;"> <!-- Powder white background -->
        <div class="iq-sidebar-logo-card p-3 text-center" style="background-color: #ff7f00; border-radius: 0px; margin: 0px;"> <!-- Orange background -->
            <a href="{{ route('dashboard') }}" class="header-logo">
                <img src="{{ asset('assets/images/ln_logo.png') }}" class="img-fluid" alt="logo" style="width: 50px; height: auto;">
            </a>
            <h6 class="logo-title text-white mt-2">L&N Gas Management System Roxas</h6>
        </div> --}}


         {{-- ////////////SIDE LOGO/////////////////////// --}}

        <div class="iq-sidebar sidebar-default" style="background-color: #f8f9fa;"> <!-- Powder white background -->
            <div class="iq-sidebar-logo-card d-flex align-items-center justify-content-center p-3" style="background-color: #ff7f00; border-radius: 0px; margin: 0px;"> <!-- Orange background -->
                <a href="{{ route('dashboard') }}" class="header-logo d-flex align-items-center">
                    <img src="{{ asset('assets/images/ln_logo.png') }}" class="img-fluid" alt="logo" style="width: 55px; height: auto; margin-right: 10px;"> 
                    <div class="text-left p-0 m-0">
                        <h5 class="text-white mb-1" style="font-size: 16px; font-weight: bold; text-align: center; line-height: 1;">L&N GAS</h5>
                        <span class="text-white d-block" style="font-size: 11.5px; line-height: 1; text-align: center;">MANAGEMENT SYSTEM ROXAS</span>
                    </div>
                    
                </a>
            </div>


    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <svg  xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-kanban" viewBox="0 0 16 16">
                            <path d="M13.5 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-11a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm-11-1a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M6.5 3a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm-4 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1zm8 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1z"/>
                          </svg>
                        <span class="ml-4">Dashboards</span>
                    </a>
                </li>

                <hr>

                <li>
                    <a href="#orders" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 18h14M5 18v3h14v-3M5 18l1-9h12l1 9M16 6v3m-4-3v3m-2-6h8v3h-8V3Zm-1 9h.01v.01H9V12Zm3 0h.01v.01H12V12Zm3 0h.01v.01H15V12Zm-6 3h.01v.01H9V15Zm3 0h.01v.01H12V15Zm3 0h.01v.01H15V15Z"/>
                          </svg>
                        {{-- <i class="fa-solid fa-basket-shopping"></i> --}}
                        <span class="ml-3">POS</span>
                        
                        <!-- Replacing old arrow icon but keeping the same class for transition -->
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" stroke="currentColor">
                            <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                        </svg>
                    </a>
                    
                    
                    <ul id="orders" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">

                        <li class="{{ Request::is('pos*') ? 'active' : '' }}">
                            <a href="{{ route('pos.index') }}" class="svg-icon">
                                <i class="fa-solid fa-cart-shopping"></i>                                  
                                <span class="ml-3">POS</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('orders/complete*') ? 'active' : '' }}">
                            <a href="{{ route('order.completeOrders') }}"> 
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>Transaction Orders</span>
                            </a>
                        </li>

                    </ul>
                </li>

            


                <li class="nav-item">
                    <a href="#products" class="nav-link collapsed" data-toggle="collapse" aria-expanded="false">
                        {{-- <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z"/>
                        </svg> --}}
                
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span class="ml-3">Inventory</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" stroke="currentColor">
                            <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                        </svg>
                    </a>
                
                    <ul id="products" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="nav-sub-item {{ Request::is('inventory') ? 'active' : '' }}">
                            <a href="{{ route('inventory.index') }}" class="nav-sub-link">
                                <i class="fa-solid fa-arrow-right"></i><span>Inventory</span>
                            </a>
                        </li>
                        <li class="nav-sub-item {{ Request::is(['products']) ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}" class="nav-sub-link">
                                <i class="fa-solid fa-arrow-right"></i><span>Products</span>
                            </a>
                        </li>
                    </ul>
                </li>
yyy                


                {{-- ///////////////////////////////////////////////////////////////////////////////////// --}}
                {{-- <hr> --}}

                {{-- @if (auth()->user()->can('supplier.menu'))
                <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Suppliers</span>
                    </a>
                </li>
                @endif --}}

                {{-- @if (auth()->user()->can('transactions.menu'))
                <li class="{{ Request::is('transactions*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}" class="svg-icon">
                        <i class="fa-solid fa-exchange-alt"></i>
                        <span class="ml-3">Transactions</span>
                    </a>
                </li>
                @endif --}}


                <li class="{{ Request::is('reports') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}" class="svg-icon">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                          </svg>
                        <span class="ml-4">Reports</span>
                    </a>
                </li>
                
                {{-- ===========TO BE EDIT ============= --}}

                @if (auth()->user()->can('roles.menu'))
                <li>
                    <a href="#permission" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                          </svg>
                          
                        {{-- <i class="fa-solid fa-key"></i> --}}
                        <span class="ml-3">Users & Roles</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" stroke="currentColor">
                            <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
                        </svg>
                    </a>
                    <ul id="permission" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                        <li class="{{ Request::is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="svg-icon">
                                <i class="fa-solid fa-users"></i>
                                <span class="ml-0">Users List</span>
                            </a>
                        </li> 
                        <li class="{{ Request::is(['permission', 'permission/create', 'permission/edit/*']) ? 'active' : '' }}">
                            <a href="{{ route('permission.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Permissions</span>
                            </a>
                        </li>
                        <li class="{{ Request::is(['role', 'role/create', 'role/edit/*']) ? 'active' : '' }}">
                            <a href="{{ route('role.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Roles</span>
                            </a>
                        </li>
                        <li class="{{ Request::is(['role/permission*']) ? 'active' : '' }}">
                            <a href="{{ route('rolePermission.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Role in Permissions</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                {{-- @if (auth()->user()->can('user.menu'))
                <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Users</span>
                    </a>
                </li>
                @endif --}}

                @if (auth()->user()->can('database.menu'))
                <li class="{{ Request::is('database/backup*') ? 'active' : '' }}">
                    <a href="{{ route('backup.index') }}" class="svg-icon">
                      
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 6c0 1.657-3.134 3-7 3S5 7.657 5 6m14 0c0-1.657-3.134-3-7-3S5 4.343 5 6m14 0v6M5 6v6m0 0c0 1.657 3.134 3 7 3s7-1.343 7-3M5 12v6c0 1.657 3.134 3 7 3s7-1.343 7-3v-6"/>
                          </svg>
                          
                        <span class="ml-3">Backup Database</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
 
<style>




    /* Sidebar Container */
    .iq-sidebar {
        /* background-color: #fe6601; Orange background */
        /* background: linear-gradient(to top, #daa002, #ff7c17); */
        /* background: linear-gradient(to top, #b39e62, #e86507)!important; */
         background-color: #d4d2d0; /*WHITE / Orange background*/
        color: #FFFFFF !important; /* Ensure white text is enforced */
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif; /* Modern font */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Sidebar Logo */
    .iq-sidebar-logo {
        padding: 20px;
        text-align: center;
    }

    .iq-sidebar-logo .header-logo img {
        transition: transform 0.3s ease;
    }

    .iq-sidebar-logo .header-logo img:hover {
        transform: scale(1.1);
    }

    .logo-title {
        font-size: 14px;
        font-weight: 600;
        color: #FFFFFF !important; /* Bright white for logo text */
        letter-spacing: 1.2px;
        margin-top: 10px;
    }

    /* Sidebar Menu */
    .iq-sidebar-menu {
        padding: 20px 0;
    }

    .iq-sidebar-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .iq-sidebar-menu ul li a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-radius: 8px;
        color: #2e1919 !important; /* Ensure text is white */
        font-size: 16px !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .iq-sidebar-menu ul li a:hover,
    .iq-sidebar-menu ul li.active a {
        background-color: #FF8F00; /* Slightly darker orange for hover but active */
        color: #FFFFFF !important; /* Keep text white */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .iq-sidebar-menu ul li a svg {
        margin-right: 15px;
        transition: transform 0.3s ease;
    }

    .iq-sidebar-menu ul li a:hover svg {
        transform: scale(1.1);
    }

    /* Submenu */
    .iq-submenu {
        background-color: #ffffff; /* Slightly darker submenu background */
        margin-left: 20px;
        border-left: 3px solid #b36500;
        padding-left: 10px;
    }

    .iq-submenu li a {
        padding: 8px 20px;
        font-size: 14px;
        color: #ffffff !important; /* Ensure submenu text is white */
        border-radius: 6px;
    }

    .iq-submenu li a:hover {
        background-color: #715a5a; /* Lighter orange for submenu hover */
        color: #FFFFFF !important;
    }

    .iq-submenu li.active a {
        background-color: #ff6200 !important; /* Light cream for active submenu item */
        color: #212121 !important; /* Dark text for active submenu item */
    }
    
    .iq-sidebar-menu ul li a:hover {
        background-color: #494644 !important; /* Slightly darker orange for hovering the SIDEBAR */ 
        color: #ffffff !important; /* Keep text white */
    }

    .iq-sidebar-menu ul li.active a {
        background-color: #eecdbb !important; /* Light cream background for active item */
        color: #212121 !important; /* Dark text for active item */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar Divider */
    hr {
        border-color: rgba(255, 255, 255, 0.2);
        margin: 15px 0;
    }

    /* Smooth Transitions */
    .iq-sidebar .svg-icon {
        transition: fill 0.3s ease;
    }

    .iq-sidebar-menu ul li a .svg-icon {
        fill: currentColor;
    }

    .iq-sidebar-menu ul li.active a .svg-icon {
        fill: #ffffff !important;
    }

    .iq-sidebar-menu ul li a:hover .svg-icon {
        fill: #ffffff !important;
    }

    /* Scrollbar
    .data-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #FFA726 #FF6F00;
    }

    .data-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .data-scrollbar::-webkit-scrollbar-thumb {
        background-color: #FFA726;
        border-radius: 10px;
    } */

    /* Hover Effects for Modern Look */
    .iq-sidebar-menu ul li a {
        transition: transform 0.2s ease;
    }

    .iq-sidebar-menu ul li a:hover {
        transform: translateX(5px);
    }
</style>
