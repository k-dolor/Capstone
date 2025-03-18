@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif; color:#02011a;">Administration Panel</h1>
                <div class="card-body">
                       {{--  BUTTONS   --}}
                    <div class="row text-center">
                        <div class="col">
                            <a href="{{ route('settings.index') }}" class="modern-btn btn-panel w-100 mb-4">
                                <i class="fas fa-home"></i> Main
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('backup.index') }}" class="modern-btn btn-panel w-100 mb-4">
                                <i class="fas fa-database"></i> Database Backup
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('users.index') }}" class="modern-btn btn-panel-tab active w-100 mb-4">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <button class="modern-btn btn-panel w-100 mb-4 dropdown-toggle" type="button" id="rolesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-shield"></i> Roles & Permissions
                                </button>
                                <ul class="dropdown-menu w-100 mt-5" aria-labelledby="rolesDropdown">
                                    <li><a class="dropdown-item" href="{{ route('role.index') }}">Manage Roles</a></li>
                                    <li><a class="dropdown-item" href="{{ route('permission.index') }}">Manage Permissions</a></li>
                                    <li><a class="dropdown-item" href="{{ route('rolePermission.index') }}">Role in Permissions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                       

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                @if (session()->has('success'))
                                    <div class="alert text-white bg-success" role="alert">
                                        <div class="iq-alert-text">{{ session('success') }}</div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="ri-close-line"></i>
                                        </button>
                                    </div>
                                
                                @endif
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                                    <div>
                                        <h2 class="mb-0" style="color: #02011a">User List</h2>
                                    </div>
                                    <div>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary add-list" style="border-radius: 2; background-color: #1f61d2; color: white; border: none; ">
                                        {{-- <i class="fa-solid fa-plus mr-3"></i> --}}
                                        Create User</a>
                                    {{-- <a href="{{ route('users.index') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash mr-3"></i>Clear Search</a> --}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mb-2">
                                <form action="{{ route('users.index') }}" method="get">
                                    <div class="row">
                                        <!-- Rows per Page -->
                                        <div class="col-md-2 mb-2">
                                            <label for="row" class="form-label">Page Rows:</label>
                                            <select class="form-control page-rows" name="row">
                                                <option value="5" @if(request('row') == '5') selected @endif>5</option>
                                                <option value="10" @if(request('row') == '10') selected @endif>10</option>
                                                <option value="20" @if(request('row') == '20') selected @endif>20</option>
                                                <option value="30" @if(request('row') == '30') selected @endif>30</option>
                                            </select>
                                        </div>
                                        
                            
                                        <!-- Search and Order Date Filter -->
                                        <div class="col-md-12 d-flex justify-content-end align-items-end">
                                            <div class="form-group mb-0 flex-grow-1 me-2">
                                                <input type="text" id="search" class="form-control search-input" name="search" placeholder="Search by Name/Username" value="{{ request('search') }}">
                                            </div>
                                            
                                            
                                            
                            
                            
                                            <div class="form-group mb-0 d-flex">
                                                <button type="submit" class="btn btn-custom-search me-2">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Search
                                                </button>
                                                <a href="{{ route('users.index') }}" class="btn btn-custom-clear">
                                                    Clear
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-12">
                                <div class="card">
                                </div>
                                <div class="card-body"  style="background: white;">
                                <div class="table-responsive rounded mb-3">
                                    <table class="table table-bordered table-striped">
                                        <thead style="background-color: #dfe3e8;">
                                            <tr>
                                                <th>No.</th>
                                                <th>Photo</th>
                                                <th>@sortablelink('name')</th>
                                                <th>@sortablelink('username')</th>
                                                <th>@sortablelink('email')</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ligth-body">
                                            @forelse ($users as $item)
                                            <tr>
                                                <td>{{ (($users->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                                                <td>
                                                    <img class="avatar-60 rounded" src="{{ $item->photo ? asset('storage/profile/'.$item->photo) : asset('assets/images/user/1.png') }}">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @foreach ($item->roles as $role)
                                                        <span class="badge bg-danger">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form action="{{ route('users.destroy', $item->username) }}" method="POST" style="margin-bottom: 5px">
                                                        @method('delete')
                                                        @csrf
                                                        <div class="d-flex align-items-center list-action">
                                                            {{-- <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"
                                                                href="{{ route('users.show', $item->username) }}"><i class="ri-eye-line mr-0"></i>
                                                            </a> --}}
                                                            <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ route('users.edit', $item->username) }}"><i class="ri-pencil-line mr-0"></i>
                                                            </a>
                                                            <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line mr-0"></i></button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <div class="alert text-white bg-danger" role="alert">
                                                <div class="iq-alert-text">Data not Found.</div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="ri-close-line"></i>
                                                </button>
                                            </div>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $users->links() }}
                            </div>
                        </div>
                        <!-- Page end  -->
                    </div>
                </div>
            </div>
        </div>

    

<style>
    .modern-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 22px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: scale(1);
    }

    .modern-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    
    /* Unique styles for each button */
    .btn-panel {
        /* background: linear-gradient(135deg, #4CAF50, #2E7D32); */
        background: #4d4641;
        color: white;
    }

    .btn-panel:hover {
        /* background: linear-gradient(135deg, #2E7D32, #1B5E20); */
        background: #01497c;
        color: white;
    }

    .btn-panel-tab.active {
        background-color: #003459;
        color: aliceblue;
    }

     /* Dropdown menu customization */
     .dropdown-menu {
        border-radius: 8px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /*SEARCH AND CLEAR */
    .btn-custom-search {
        background-color: #007bff !important;
        color: #fff !important;
        border: none;
        border-radius: 0% !important;
        padding: 7px 8px !important;
        transition: background-color 0.3s ease !important;
    }

    .btn-custom-search:hover {
        background-color: #0056b3 !important;
    }

    .btn-custom-clear {
        background-color: #6c757d !important;
        color: #fff !important;
        border: none;
        border-radius: 0% !important;
        padding: 7px 8px !important;
        transition: background-color 0.3s ease !important;
    }

    .btn-custom-clear:hover {
        background-color: #495057 !important;
    }

    .search-input {
        width: 100% !important;
        height: 40px !important;
        font-size: 14px !important;
        padding: 8px 15px !important;
        border-radius: 0px !important;
    }


/* Styles for Filter Form */
.page-rows {
    width: 40% !important;
    height: 40px !important;
    font-size: 13px !important;
    padding: 8px 15px !important;
    border-radius: 0px !important;
    border: 1px solid #ced4da !important;
    background-color: #f8f9fa !important;
    color: #495057 !important;
    transition: border-color 0.3s ease !important;
}

.rows-per-page:focus {
    border-color: #007bff !important;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.25) !important;
}


</style>
                
@endsection
