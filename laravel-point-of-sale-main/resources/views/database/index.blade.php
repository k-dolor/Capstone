@extends('dashboard.body.main')
<link rel="stylesheet" href="{{ asset('assets/css/style/backupdb.css') }}">

@section('container')





<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4 no-print">Administration Panel</h1>
                <div class="card-body">
                       {{--  BUTTONS   --}}
                    <div class="row text-center">
                        <div class="col">
                            <a href="{{ route('settings.index') }}" class="modern-btn btn-panel w-100 mb-4">
                                <i class="fas fa-home"></i> Main
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('backup.index') }}" class="modern-btn btn-panel-tab active w-100 mb-4">
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
                                        <h2 class="text-center mb-3">Database Backup List</h2>

                                    </div>
                                    <div>
                                        <a href="{{ route('backup.create') }}" class="btn btn-primary add-list" style="border-radius: 2; background-color: #455fbe; color: white; border: none;">Backup Now</a>
                                    </div>
                                </div>
                            
                                <form method="GET" action="{{ route('backup.index') }}">
                                    <div class="col-md-12 d-flex justify-content-end align-items-end">
                                        <div class="form-group mb-0 flex-grow-1 me-2">
                                            <input type="text" id="search" class="form-control search-input" name="search" placeholder="Search by Database Name" value="{{ request('search') }}">
                                        </div>
                                
                                        <!-- Date Filter -->
                                        <div class="form-group mb-0 me-2">
                                            <label for="backup_date" class="form-label">Filter Date:</label>
                                            <input type="date" id="backup_date" class="form-control" name="backup_date" value="{{ request('backup_date') }}">
                                        </div>
                                
                                        <div class="form-group mb-0 d-flex">
                                            <button type="submit" class="btn btn-custom-search me-2">
                                                <i class="fa-solid fa-magnifying-glass"></i> Search
                                            </button>
                                            <a href="{{ route('backup.index') }}" class="btn btn-custom-clear">
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
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>File Name</th>
                                                <th>File Size</th>
                                                <th>Path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ligth-body">
                                            @forelse ($files as $file)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $file['filename'] }}</td>
                                                <td>{{ $file['size'] }}</td>
                                                <td>{{ $file['path'] }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center list-action">
                                                        <a class="btn btn-success mr-2" href="{{ route('database.download', ['filename' => $file['filename']]) }}" title="Download" style="border-radius: 0; background-color: #3e9b32; color: white; border: none;">Download
                                                            {{-- <i class="fa-solid fa-download"></i> --}}
                                                        </a>
                                                        <form action="{{ route('backup.delete', $file['filename']) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger mr-2" title="Delete" style="border-radius: 0; background-color: #cd3746; color: white; border: none;">
                                                                {{-- <i class="fa-solid fa-trash"></i> --}}
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No backups found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
