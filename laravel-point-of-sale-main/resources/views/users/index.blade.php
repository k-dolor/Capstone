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
                                        Create User</a>
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
                            <div id="deleteSuccessMessage" class="alert alert-success text-center" style="display: none; position: fixed; top: 20px; right: 10px; z-index: 1050;">
                                ✅ User deleted successfully!
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="card">
                                </div>
                                <div class="card-body"  style="background: white;">
                                <div class="table-responsive rounded mb-3">
                                    <table class="table table-bordered table-striped">
                                        <thead style="background-color: #dbe5f1;">
                                            <tr>
                                                <th>No.</th>
                                                <th>Photo</th>
                                                <th>@sortablelink('name')</th>
                                                <th>@sortablelink('username')</th>
                                                <th>Email</th>
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
                                                        @if($role->name === 'SuperAdmin')
                                                            <span class="custom-badge super-admin">{{ $role->name }}</span>
                                                        @else
                                                            <span class="custom-badge user-role">{{ $role->name }}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                 
                                                <td>
                                                    <div class="d-flex align-items-center list-action">
                                                        <!-- View Button (Triggers Modal) -->
                                                        <a href="javascript:void(0);" class="btn btn-primary mr-2 viewUser" data-id="{{ $item->id }}" title="View">
                                                            <i class="ri-eye-line mr-0"></i>
                                                        </a>
                                                        <!-- Edit Button -->
                                                        <a class="btn btn-success mr-2" href="{{ route('users.edit', $item->username) }}">
                                                            <i class="ri-pencil-line mr-0"></i>
                                                        </a>
                                                
                                                        <!-- Delete Form -->
                                                        {{-- <form action="{{ route('users.destroy', $item->id) }}" method="POST" style="margin-bottom: 5px;">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')">
                                                                <i class="ri-delete-bin-line mr-0"></i>
                                                            </button>
                                                        </form> --}}
                                                        <!-- Delete Button -->
<a href="javascript:void(0);" class="btn btn-danger deleteUser" data-id="{{ $item->id }}" title="Delete">
    <i class="ri-delete-bin-line mr-0"></i>
</a>

                                                    </div>
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


<!-- Modern User Details Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-orange text-white">
                <h5 class="modal-title"><i class="fas fa-user-circle"></i> User Details</h5>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="modalUserPhoto" src="/user.png" alt="User Photo"
                        class="img-fluid rounded-circle shadow-sm border border-3 border-light" width="100">
                </div>
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr><td><strong><i class="fas fa-id-badge"></i> ID:</strong></td><td id="modalUserId"></td></tr>
                        <tr><td><strong><i class="fas fa-user"></i> Name:</strong></td><td id="modalUserName"></td></tr>
                        <tr><td><strong><i class="fas fa-user-tag"></i> Username:</strong></td><td id="modalUserUsername"></td></tr>
                        <tr><td><strong><i class="fas fa-envelope"></i> Email:</strong></td><td id="modalUserEmail"></td></tr>
                        <tr><td><strong><i class="fas fa-user-shield"></i> Role:</strong></td><td id="modalUserRole"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm User Deletion</h5>
                <button type="button" class="close text-white cancelDelete" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="deleteUserPhoto" src="" alt="User Photo" class="rounded-circle mb-3" width="100" height="100">
                <h5 id="deleteUserName"></h5>
                <p><strong>Username:</strong> <span id="deleteUserUsername"></span></p>
                <p><strong>Email:</strong> <span id="deleteUserEmail"></span></p>
                <p class="text-danger">Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancelDelete" data-dismiss="modal">Cancel</button>
                <button id="confirmDeleteUser" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>





<!-- AJAX Script -->
<!-- Ensure jQuery is loaded -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).on('click', '.viewUser', function () {
        let userId = $(this).data('id');
        console.log("Fetching user with ID:", userId);

        $.ajax({
            url: `/users/${userId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("User data received:", data);

                // Check if data contains an error
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Update modal content
                $('#modalUserId').text(data.id);
                $('#modalUserName').text(data.name);
                $('#modalUserUsername').text(data.username || 'N/A'); // Handle null values
                $('#modalUserEmail').text(data.email || 'N/A');
                $('#modalUserRole').text(data.role || 'No Role Assigned');

                // Handle missing photos
                let photoUrl = data.photo ? data.photo : '/default-user.png';
                $('#modalUserPhoto').attr('src', photoUrl);

                $('#viewUserModal').modal('show');
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                alert("User details could not be loaded.");
            }
        });
    });
   

    $(document).on('click', '.deleteUser', function () {
        let userId = $(this).data('id');

        $.ajax({
            url: `/users/${userId}`,
            type: 'GET',
            success: function (data) {
                $('#deleteUserPhoto').attr('src', data.photo ? data.photo : '/default-user.png');
                $('#deleteUserName').text(data.name);
                $('#deleteUserUsername').text(data.username);
                $('#deleteUserEmail').text(data.email);
                $('#confirmDeleteUser').data('id', userId);
                $('#deleteUserModal').modal('show');
            },
            error: function () {
                alert('Error fetching user details.');
            }
        });
    });

    // Confirm delete
    $('#confirmDeleteUser').on('click', function () {
        let userId = $(this).data('id');

        $.ajax({
            url: `/users/${userId}`,
            type: 'POST',
            data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
            success: function () {
                $('#deleteUserModal').modal('hide');

                // Show success message
                $('#deleteSuccessMessage').fadeIn().delay(3000).fadeOut();
                
                // Reload after short delay
                setTimeout(() => {
                    location.reload();
                }, 2000);
            },
            error: function () {
                alert('Error deleting user.');
            }
        });
    });

    // Cancel delete button fix
    $('.cancelDelete').on('click', function () {
        $('#deleteUserModal').modal('hide');
    });


</script>





    

<style>
        .custom-badge {
        font-size: 0.9rem;         /* Adjust the font size */
        font-weight: 600;                   /* Bold text for emphasis */
        letter-spacing: 0.5px;              /* Slight spacing between letters */
        padding: 0.4em 0.6em;               /* Padding for space */       /* Adjust the padding */
        border-radius: 12px;         /* Rounded corners */
        transition: all 0.3s ease;   /* Smooth hover transition */
        color: #ffffff !important;                 /* White text */
        display: inline-block;
    }

    /*  */

    /* Specific colors for roles */
    .super-admin {
        background-color: rgb(230, 82, 9);
    }

    .user-role {
        background-color: navy;
    
    }

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
