@php
    
    $products = \App\Models\Product::where('product_store', '<=', 10)->get();
@endphp




<div class="iq-top-navbar" style="background-color:  #281e32;">
    <div class="iq-navbar-custom" style="background-color:  #281e32;">
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
{{-- //////////////////////////////////////////////////////// --}}
<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown">
        <i class="fas fa-bell"></i>
        <span id="notification-count" class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div id="notifications-list">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <a class="dropdown-item notification-item" href="{{ route('notifications.read', $notification->id) }}">
                    {{ $notification->message }}
                </a>
            @endforeach
        </div>
    </div>
</li>

{{-- //////////////////////////////////                 --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon">
                            <button type="button" class="btn btn-light" id="notificationButton" data-toggle="modal" data-target="#notificationModal">
                                <i class="ri-notification-3-line"></i>
                                @if($notifications->count() > 0)
                                    <span class="badge badge-danger">{{ $notifications->count() }}</span>
                                @endif
                            </button>
                        </li>
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

<!-- Notification Modal -->
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
</div>
<script>
    $(document).ready(function () {
        $('.notification-item').click(function () {
            var notificationCount = $('#notification-count').text();
            notificationCount = notificationCount - 1;
            $('#notification-count').text(notificationCount <= 0 ? '' : notificationCount);
        });
    });
</script>

<style>
    .nav-item .btn-light {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px; /* Adjust width to match profile image size */
        height: 50px; /* Adjust height to match profile image size */
        border-radius: 20%; /* Make it circular */
        padding: 0;
    }
    .nav-item .btn-light i {
        font-size: 24px; /* Adjust icon size */
    }
    .nav-item .badge {
        position: absolute;
        top: 2px; /* Adjust position */
        right: 2px; /* Adjust position */
        font-size: 0.75rem;
        padding: 0.20rem 0.4rem;
        border-radius: 50%;
    }
</style>
