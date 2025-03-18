@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif;color:#02011a; ">Administration Panel</h1>
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
                            <a href="{{ route('users.index') }}" class="modern-btn btn-panel w-100 mb-4">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <button class="modern-btn btn-panel-tab active w-100 mb-4 dropdown-toggle" type="button" id="rolesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-shield"></i> Roles
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
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="mb-3" style="color: #02011a">Role List</h2>
                    {{-- <p class="mb-0">A role dashboard lets you easily gather and visualize role data from optimizing <br>
                        the role experience, ensuring role retention. </p> --}}
                </div>
                <div>
                    <a href="{{ route('role.create') }}" class="btn btn-primary add-list"style="border-radius: 2; background-color: #1f61d2; color: white; border: none;"><i class="fa-solid fa-plus mr-3"></i>Add Role</a>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-12">
            <form action="{{ route('customers.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Search:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Search customer" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> --}}

        <div class="col-lg-12">
            <div class="card">
            </div>
            <div class="card-body"  style="background: white; border-radius: 10px; ">
            <div class="table-responsive rounded mb-3">
                <table class="table table-bordered table-striped">
                    <thead style="background-color: #dfe3e8;">
                        <tr>
                            <th>No.</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ (($roles->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"
                                            href="{{ route('role.edit', $role->id) }}""><i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line mr-0"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $roles->links() }}
        </div>
    </div>
    <!-- Page end  -->
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
</style>

@endsection
