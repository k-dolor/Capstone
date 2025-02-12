<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex flex-column align-items-center">
        <a href="{{ route('dashboard') }}" class="header-logo text-center">
            <img src="{{ asset('assets/images/ln_logo.png') }}" class="img-fluid normal light-logo" alt="logo" style="width: 100px; height: auto;">

        </a>
        <div class="text-center mt-2" style="color: #00111d">
            <h5 class="logo-title light-logo">Management System Roxas</h5>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="svg-icon">
                        <svg  class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Dashboards</span>
                    </a>
                </li>

                <hr>

                <li>
                    <a href="#orders" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-basket-shopping"></i>
                        <span class="ml-3">POS</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
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
                                <i class="fa-solid fa-arrow-right"></i><span>Complete Orders</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="#products" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span class="ml-3">Inventory</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>

                    <ul id="products" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">

                        <li class="{{ Request::is('inventory') ? 'active' : '' }}">
                            <a href="{{ route('inventory.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Inventory</span>
                            </a>
                        </li>
                        <li class="{{ Request::is(['products']) ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Products</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <hr>

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
                        <svg  class="svg-icon" id="p-dash1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Reports</span>
                    </a>
                </li>
                
                {{-- ===========TO BE EDIT ============= --}}

                @if (auth()->user()->can('roles.menu'))
                <li>
                    <a href="#permission" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-key"></i>
                        <span class="ml-3">Role & Permission</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="permission" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                        <li class="{{ Request::is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="svg-icon">
                                <i class="fa-solid fa-users"></i>
                                <span class="ml-3">Users</span>
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
                        <i class="fa-solid fa-database"></i>
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
        background-color: #fe6601; /* Orange background */
        color: #FFFFFF !important; /* Ensure white text is enforced */
        transition: all 0.3s ease;
        font-family: 'Calisto MT', sans-serif; /* Modern font */
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
        font-size: 18px;
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
        color: #FFFFFF !important; /* Ensure text is white */
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .iq-sidebar-menu ul li a:hover,
    .iq-sidebar-menu ul li.active a {
        background-color: #FF8F00; /* Slightly darker orange for hover */
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
        background-color: #FFF8E1; /* Light cream for active submenu item */
        color: #212121 !important; /* Dark text for active submenu item */
    }
    
    .iq-sidebar-menu ul li a:hover {
        background-color: #fed7a6 !important; /* Slightly darker orange for hovering the SIDEBAR */ 
        color: #000000 !important; /* Keep text white */
    }

    .iq-sidebar-menu ul li.active a {
        background-color: #FFF8E1; /* Light cream background for active item */
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
