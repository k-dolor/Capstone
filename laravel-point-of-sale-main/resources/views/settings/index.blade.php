@extends('dashboard.body.main')

@section('container')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4 no-print" style="font-family: 'Poppins', sans-serif; color:#02011a;">Administration Panel</h1>
            <div class="card-body">
                {{-- <div class="row text-center"> --}}
                    {{--  BUTTONS   --}}
                    <div class="row text-center">
                        <div class="col">
                            <a href="{{ route('settings.index') }}" class="modern-btn btn-panel-tab active">
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

                    
                    <div class="row mt-3">
                        <!-- Left Side: Database Backups & User List -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header" >
                                    <h5><i class="fas fa-database"></i> Database Backups</h5>
                                </div>
                                <div class="card-body" style="max-height: 330px; overflow-y: auto;"> <!-- Scrollable -->
                                    @if ($backups->isEmpty())
                                        <p class="text-center">No backups available.</p>
                                    @else
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="custom-table-header">
                                                    <th>File Name</th>
                                                    <th>Size</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($backups as $index => $backup)
                                                    <tr>
                                                        <td>{{ $backup['filename'] }}</td>
                                                        <td>{{ $backup['size'] }}</td>
                                                        <td>{{ $backup['date'] }}</td>
                                                        <td>
                                                            <a href="{{ route('database.download', ['filename' => $backup['filename']]) }}" class="btn btn text-white" style="background-color: #e58200;"> 
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif            
                                </div>
                            </div>
                    
                            <!-- User List Table Below Database Backups -->
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5><i class="fas fa-user"></i> User List</h5>
                                </div>
                                <div class="card-body" style="max-height: 450px; overflow-y: auto;"> <!-- Scrollable -->
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                                <tr>
                                                    <td>
                                                        <img class="rounded-square" width="50" height="50"
                                                             src="{{ $user->photo ? asset('storage/profile/'.$user->photo) : asset('assets/images/user/1.png') }}" 
                                                             alt="Profile Picture">
                                                    </td>
                                                    
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">No users found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Right Side: Total Users, System Info, & Notification History -->
                        <div class="col-md-5">
                            <div class="card text-white mb-3" style="background-color: #ba6a00;">
                                <div class="card-header" style="font-size: 16px;">
                                    <i class="fas fa-users"></i> Total Users
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title">{{ $totalUsers ?? 0 }}</h3>
                                    <p class="card-text">Number of registered users in the system.</p>
                                </div>
                            </div>
                    
                            <div class="card text-white bg-dark">
                                <div class="card-header"><i class="fas fa-server"></i> System Information</div>
                                <div class="card-body">
                                    <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                                    <p><strong>PHP Version:</strong> {{ phpversion() }}</p>
                                </div>
                            </div>
                    
                            <!-- Low Stock Notification History Below System Info -->
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5><i class="fas fa-history"></i> Low Stock Notification History</h5>
                                </div>
                                <div class="card-body">
                                    @if($notifications->isEmpty())
                                        <p class="text-center text-muted">No low stock notifications available.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach ($notifications as $notification)
                                                <li class="list-group-item">
                                                    <strong>{{ $notification->created_at->format('m-d-Y | H:i') }}</strong> - 
                                                    {{ $notification->message }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
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


     /* Custom Header Style */
     .custom-table-header {
        /* background: linear-gradient(45deg, #ff6600, #cc5200); Orange Gradient */
        background: #444;
        color: white; 
        font-weight: bold;
        font-size: 16px;
        /* text-transform: uppercase; */
        text-align: center;
        border-radius: 8px 8px 0 0;
    }
</style>

@endsection
