        <div class="iq-sidebar sidebar-default" > <!-- Powder white background -->
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
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="ml-4">Dashboards</span>
                    </a>
                </li>

                <hr>

                <li>
                    <a href="#orders" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-cash-register"></i>
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


                <li class="{{ Request::is('reports') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}" class="svg-icon">
                        <i class="fa-solid fa-chart-bar"></i>
                        <span class="ml-4">Reports</span>
                    </a>
                </li>


                {{-- NEW SETTINGS FEATURE --}}
                @if (auth()->user()->can('roles.menu'))
                <li class="nav-item {{ Request::is('settings') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="ml-3">Admin Panel</span>
                    </a>
                </li>
                
                @endif    
                             
                
                {{-- ===========TO BE EDIT ============= --}}

                {{-- @if (auth()->user()->can('roles.menu'))
                @endif --}}


                {{-- @if (auth()->user()->can('database.menu'))

                @endif --}}
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>


<style>


/* Ensure the content doesn't overflow */
body {
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Flex and Layout Management */
.d-flex {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 0px;
}

        /* Sidebar Container */
        .iq-sidebar {
            background-color: #FDF6F0; /* Soft white/orange-tinted */
            color: #2E2E2E;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Logo Area */
        .iq-sidebar-logo-card {
            background-color: #FF6F00;
            border-radius: 0;
            padding: 1rem;
            margin: 0;
        }

        .iq-sidebar-logo-card h5,
        .iq-sidebar-logo-card span {
            color: #fff;
            text-align: center;
        }

        /* Sidebar Menu Items */
    .iq-sidebar-menu ul li {
        /* margin-bottom: 18px; Add spacing between each item */
    }

        /* Menu Items */
        .iq-sidebar-menu ul li a {
            display: flex;
            align-items: center;
            /* padding: 12px 18px; */
            padding: 25px 15px !important; /* More padding for space */
            margin: 5px 10px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            color: #2E2E2E;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .iq-sidebar-menu ul li a svg {
            margin-right: 12px;
            transition: transform 0.3s ease;
        }
        
        /* Active Main Menu Item */
        .iq-sidebar-menu ul li.active > a {
            background-color: #e65100 !important; /* Darker orange for active */
            color: #ffffff !important;
            box-shadow: inset 4px 0 0 #ffb74d; /* Left accent stripe */
        }

        /* Hover Effect */
        .iq-sidebar-menu ul li a:hover {
            background-color: #f57c00 !important; /* Slightly lighter orange */
            color: #ffffff !important;
        }

        /* Submenu Items */
        .iq-submenu {
            background-color: #f5f5f5 !important;
            margin-left: 20px;
            border-left: 3px solid #e65100;
            padding-left: 10px;
        }

        /* Submenu Links */
        .iq-submenu li a {
            padding: 8px 16px;
            font-size: 14px;
            color: #212121 !important; /* Dark text for readability */
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        /* Submenu Hover */
        .iq-submenu li a:hover {
            background-color: #ffe0b2 !important;
            color: #e65100 !important;
        }

        /* Submenu Active Item */
        .iq-submenu li.active a {
            background-color: #ffcc80 !important; /* Light orange background */
            color: #212121 !important;
            font-weight: 600;
        }

        /* Sidebar Text */
        .iq-sidebar-menu ul li a span,
        .iq-sidebar-menu ul li a i,
        .iq-sidebar-menu ul li a svg {
            color: inherit;
            transition: color 0.3s ease;
        }
        .iq-sidebar-menu i {
        font-size: 18px;
        color: #444;
        transition: color 0.3s ease;
    }

    .iq-sidebar-menu li.active i,
    .iq-sidebar-menu li:hover i {
        color: #fffff !important;
    }
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

</style>