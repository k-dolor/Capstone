<div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex flex-column align-items-center">
        <a href="{{ route('dashboard') }}" class="header-logo text-center">
            <img src="{{ asset('assets/images/ln_logo.png') }}" class="img-fluid normal light-logo" alt="logo" style="width: 100px; height: auto;">

        </a>
        <div class="text-center mt-2" style="color: #0064a7">
            <h5 class="logo-title light-logo">Supply Management System</h5>
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
                        <span class="ml-3">Sales</span>
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

                        {{-- <li class="{{ Request::is('orders/pending*') ? 'active' : '' }}">
                            <a href="{{ route('order.pendingOrders') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Pending</span>
                            </a>
                        </li> --}}
                        <li class="{{ Request::is('orders/complete*') ? 'active' : '' }}">
                            <a href="{{ route('order.completeOrders') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Complete</span>
                            </a>
                        </li>
                        {{-- <li class="{{ Request::is('pending/due*') ? 'active' : '' }}">
                            <a href="{{ route('order.pendingDue') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Pending Due</span>
                            </a>
                        </li> --}}
                        {{-- <li class="{{ Request::is(['stock*']) ? 'active' : '' }}">
                            <a href="{{ route('order.stockManage') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Stock Management</span>
                            </a>
                        </li> --}}
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
                        {{-- <li class="{{ Request::is(['products/create']) ? 'active' : '' }}">
                            <a href="{{ route('products.create') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Add Product</span>
                            </a>
                        </li> --}}
                        <li class="{{ Request::is(['categories*']) ? 'active' : '' }}">
                            <a href="{{ route('categories.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Categories</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('delivery*') ? 'active' : '' }}">
                    <a href="{{ route('delivery.index') }}" class="svg-icon">
                        <i class="fa-solid fa-truck"></i>
                        <span class="ml-3">Delivery</span>
                    </a>
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
                

                {{-- @if (auth()->user()->can('sales.menu'))
                <li class="{{ Request::is('sales*') ? 'active' : '' }}">
                    <a href="{{ route('sales.index') }}" class="svg-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span class="ml-3">Sales</span>
                    </a>
                </li>
                @endif --}}

                @if (auth()->user()->can('transactions.menu'))
                <li class="{{ Request::is('transactions*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}" class="svg-icon">
                        <i class="fa-solid fa-exchange-alt"></i>
                        <span class="ml-3">Transactions</span>
                    </a>
                </li>
                @endif

                {{-- <li class="{{ Request::is('reports*') ? 'active' : '' }}">
                    <a href="{{ route('reports.stock') }}" class="svg-icon">
                        <i class="fa-solid fa-file-alt"></i>
                        <span class="ml-3">Reports</span>
                    </a>
                </li> --}}

                {{-- @if (auth()->user()->can('report.menu')) --}}
                <li>
                    <a href="#report" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-file-alt"></i>
                        <span class="ml-3">Reports</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="report" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                        
                        <li class="{{ Request::is('income-report') ? 'active' : '' }}">
                            <a href="{{ route('reports.income') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Income Reports</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('reports/products') ? 'active' : '' }}">
                            <a href="{{ route('reports.products') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Product Reports</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('reports/stock') ? 'active' : '' }}">
                            <a href="{{ route('reports.stock') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Stock Reports</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('reports/sales') ? 'active' : '' }}">
                            <a href="{{ route('reports.sales') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Sales Report</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('deliveries') ? 'active' : '' }}">
                            <a href="{{ route('reports.deliveries') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Delivery Reports</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                {{-- @endif --}}

                <hr>

                <li>
                    <a href="{{ route('employees.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Employees</span>
                    </a>
                </li>

                @if (auth()->user()->can('customer.menu'))
                <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Customers</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole('SuperAdmin'))
                <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Suppliers</span>
                    </a>
                </li>
            @endif

                {{-- @if (auth()->user()->can('salary.menu'))
                <li>
                    <a href="#advance-salary" class="collapsed" data-toggle="collapse" aria-expanded="false">
                    <i class="fa-solid fa-cash-register"></i>
                        <span class="ml-3">Salary</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="advance-salary" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">

                        <li class="{{ Request::is(['advance-salary', 'advance-salary/*/edit']) ? 'active' : '' }}">
                            <a href="{{ route('advance-salary.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>All Advance Salary</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('advance-salary/create*') ? 'active' : '' }}">
                            <a href="{{ route('advance-salary.create') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Create Advance Salary</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('pay-salary') ? 'active' : '' }}">
                            <a href="{{ route('pay-salary.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Pay Salary</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('pay-salary/history*') ? 'active' : '' }}">
                            <a href="{{ route('pay-salary.payHistory') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>History Pay Salary</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif --}}

                {{-- @if (auth()->user()->can('attendence.menu'))
                <li>
                    <a href="#attendence" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span class="ml-3">Attendence</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline><path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="attendence" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">

                        <li class="{{ Request::is(['employee/attendence']) ? 'active' : '' }}">
                            <a href="{{ route('attendence.index') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>All Attedence</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('employee/attendence/*') ? 'active' : '' }}">
                            <a href="{{ route('attendence.create') }}">
                                <i class="fa-solid fa-arrow-right"></i><span>Create Attendence</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif --}}

                <hr>


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

                @if (auth()->user()->can('user.menu'))
                <li class="{{ Request::is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="svg-icon">
                        <i class="fa-solid fa-users"></i>
                        <span class="ml-3">Users</span>
                    </a>
                </li>
                @endif

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
    background-color: #1E1E2D;
    color: #ffffff;
    transition: all 0.3s ease-in-out;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    height: 100vh; /* Full viewport height */
    display: flex;
    flex-direction: column;
}

/* Sidebar Logo */
.iq-sidebar-logo {
    padding: 20px;
    text-align: center;
}

.iq-sidebar-logo .header-logo img {
    /* border-radius: 50%; */
    transition: transform 0.3s ease;
}

.iq-sidebar-logo .header-logo img:hover {
    transform: scale(1.1);
}

.logo-title {
    font-size: 16px;
    font-weight: 600;
    color: #00aaff;
    letter-spacing: 1px;
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

.iq-sidebar-menu ul li {
    position: relative;
    margin-bottom: 10px;
}

.iq-sidebar-menu ul li a {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 10px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.iq-sidebar-menu ul li a:hover,
.iq-sidebar-menu ul li.active a {
    background-color: #00aaff;
    color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.iq-sidebar-menu ul li a svg {
    margin-right: 15px;
    transition: transform 0.3s ease;
}

.iq-sidebar-menu ul li a:hover svg {
    transform: rotate(20deg);
}

/* Submenu */
.iq-submenu {
    background-color: #515187;
    margin-left: 20px;
    border-left: 2px solid #00aaff;
}

.iq-submenu li a {
    padding: 8px 20px;
    font-size: 13px;
    color: #ededed;
    border-radius: 8px;
}

.iq-submenu li a:hover {
    background-color: #00aaff;
    color: #ffffff;
}


/* Sidebar Divider */
hr {
    border-color: rgba(255, 255, 255, 0.1);
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
    fill: #ffffff;
}

.iq-sidebar-menu ul li a:hover .svg-icon {
    fill: #ffffff;
}

/* Scrollbar */
.data-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #00aaff #1E1E2D;
}

.data-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.data-scrollbar::-webkit-scrollbar-thumb {
    background-color: #00aaff;
    border-radius: 10px;
}

</style>