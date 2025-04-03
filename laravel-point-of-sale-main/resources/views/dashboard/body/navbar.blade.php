@php
    $notifications = \App\Models\Notification::where('is_read', false)->latest()->get();
    $products = \App\Models\Product::where('product_store', '<=', 10)->get();
@endphp




{{-- <div class="iq-top-navbar" style="background-color:  #281e32;">
    <div class="iq-navbar-custom" style="background-color:  #281e32;"> --}}
        <div class="iq-top-navbar" style="background-color:  #df7204;">
            <div class="iq-navbar-custom" style="background-color:  #df7204;">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                <i class="ri-menu-line wrapper-menu"></i>
                <a href="{{ route('dashboard') }}" class="header-logo">
                    <img src="../assets/images/ln_logo.png" class="img-fluid rounded-normal" alt="logo">
                    <h5 class="logo-title ml-3">L&N GAS</h5>
                </a>
            </div>
            <div class="iq-search-bar device-search">
                {{-- <form action="#" class="searchbox">
                    <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                    <input type="text" class="text search-input" placeholder="Search here...">
                </form> --}}
            </div>
            <div class="d-flex align-items-center">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">

                        
{{-- //*********************nOTIFICATION BELL******************************************* --}}
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell fa-lg"></i>  
                                @if($notifications->count() > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-circle">
                                        {{ $notifications->count() }}
                                    </span>
                                @endif
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="notificationDropdown">
                                <li><h5 class="dropdown-header">Notifications</h5></li>
                                
                                @foreach($notifications as $notification)
                                    <li>
                                        <a href="/inventory" class="dropdown-item notification-item d-flex align-items-center" data-id="{{ $notification->id }}">
                                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                                            <span class="text-truncate" style="max-width: 400px; ">{{ $notification->message }}</span>
                                        </a>                                      
                                    </li>
                                    <hr class="dropdown-divider">
                                @endforeach
                                
                                @if($notifications->isEmpty())
                                    <li><a class="dropdown-item text-center text-muted">No new notifications</a></li>
                                @endif
                            </ul>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-bell fa-lg"></i>  
                                <span class="badge badge-danger" id="notificationCount">{{ count($notifications) }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(count($notifications) > 0)
                                    @foreach($notifications as $notification)
                                        <a class="dropdown-item" href="/inventory" onclick="markAsRead({{ $notification->id }})">
                                            {{ $notification->message }}
                                        </a>
                                    @endforeach
                                @else
                                    <a class="dropdown-item">No new notifications</a>
                                @endif
                            </div>
                        </li>
                        
                        
                        
                                              
                        {{-- //PROFILE --}}
                        <li class="nav-item nav-icon dropdown caption-content">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton4"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ auth()->user()->photo ? asset('storage/profile/'.auth()->user()->photo) : asset('assets/images/user/1.png') }}" class="img-fluid rounded" alt="user">
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="card shadow-none m-0">
                                    <div class="card-body p-0 text-center">
                                        <div class="media-body profile-detail text-center">
                                            <img src="{{ asset('assets/images/page-img/profile-bg.jpg') }}" alt="profile"
                                                class="rounded-top img-fluid mb-4">
                                            <img src="{{ auth()->user()->photo ? asset('storage/profile/'.auth()->user()->photo) : asset('assets/images/user/1.png') }}" alt="profile-img"
                                                class="rounded profile-img img-fluid avatar-70">
                                        </div>
                                        <div class="p-3">
                                            <h5 class="mb-1">{{  auth()->user()->name }}</h5>
                                            <p class="mb-0">Since {{ date('d M, Y', strtotime(auth()->user()->created_at)) }}</p>
                                            <div class="d-flex align-items-center justify-content-center mt-3">
                                                <a href="{{ route('profile') }}" class="btn border mr-2">Profile</a>
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn border">Sign Out</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

{{-- <!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Notification content goes here -->
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_store}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<style>

.notification-item {
    font-size: 14px;
    padding: 10px 15px !important;
    transition: background 0.3s ease !important; 
    border-radius: 5px;
}

.notification-item:hover {
    background: rgba(0, 0, 0, 0.05);
}

.dropdown-menu {
    border-radius: 10px;
}

.dropdown-item i {
    font-size: 18px;
}

.dropdown-menu {
    left: 100% !important;
    transform: translateX(-100%) !important;
    width: 450px; /* Adjust width as needed */
    max-height: 500px; /* Set max height */
    overflow-y: auto; /* Enable scrolling if too many notifications */
}
</style>

<script>
 
// document.addEventListener("DOMContentLoaded", function() {
//     document.querySelectorAll('.mark-as-read').forEach(item => {
//         item.addEventListener('click', function(event) {
//             event.preventDefault();
//             let notificationId = this.dataset.id;

//             fetch(`/notifications/${notificationId}/mark-read`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//                     'Content-Type': 'application/json'
//                 },
//                 body: JSON.stringify({})
//             }).then(response => {
//                 if (response.ok) {
//                     this.parentElement.remove();
                    
//                     // Update notification count
//                     let badge = document.querySelector('#notificationDropdown .badge');
//                     let count = parseInt(badge.textContent) - 1;
//                     badge.textContent = count > 0 ? count : '';
//                 }
//             });
//         });
//     });
// });
// document.addEventListener("click", function(event) {
//     if (event.target.classList.contains("mark-as-read")) {
//         event.preventDefault();
        
//         let notificationId = event.target.getAttribute("data-id");
        
//         fetch(`/mark-notification/${notificationId}`, {
//             method: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content,
//                 "Content-Type": "application/json"
//             },
//             body: JSON.stringify({ id: notificationId })
//         }).then(response => {
//             if (response.ok) {
//                 event.target.closest(".dropdown-item").remove();
//                 fetchNotifications(); // Refresh notifications count
//             }
//         }).catch(error => console.error("Error marking as read:", error));
//     }
// });


// $('.notification-item').click(function() {
//         let notificationId = $(this).data('id');

//         $.ajax({
//             url: "/notifications/read/" + notificationId,
//             type: "POST",
//             data: {
//                 _token: "{{ csrf_token() }}",
//             },
//             success: function(response) {
//                 console.log(response);
//                 alert('Notification marked as read!');
//             },
//             error: function(xhr) {
//                 console.log(xhr.responseText);
//                 alert('Error marking notification as read.');
//             }
//         });
//     });

    

// 

function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                let notificationList = document.getElementById('notificationList');
                let notificationCount = document.getElementById('notificationCount');
                
                notificationList.innerHTML = '';
                
                if (data.length > 0) {
                    notificationCount.innerText = data.length;
                    
                    data.forEach(notification => {
                        let listItem = document.createElement('li');
                        listItem.innerHTML = `<a href="/inventory" class="dropdown-item" onclick="markAsRead(${notification.id})">${notification.message}</a>`;
                        notificationList.appendChild(listItem);
                    });
                } else {
                    notificationCount.innerText = '0';
                    notificationList.innerHTML = '<li><a class="dropdown-item">No new notifications</a></li>';
                }
            });
    }

    function markAsRead(id) {
        fetch(`/notifications/read/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => {
            loadNotifications();
        });
    }

    document.addEventListener('DOMContentLoaded', loadNotifications);
    document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ Navbar script is running!");
    loadNotifications(); // This function should be running
});

                       
</script>