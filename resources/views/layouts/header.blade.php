<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lions MD307 Convention</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    {{-- custom css style --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('additional-styles')

    {{-- feather icons --}}
    <script src="https://unpkg.com/feather-icons"></script>  

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="top-banner">
        <div class="row mt-1 mb-1 pb-2">
            <div class="col-md-10">
                <p>Lions MD307 Convention | Indonesia | June 00-00, 2024</p>
            </div>
            <div class="col-md-2">
                <a href="/register/create"><button class="btn register-button">Register</button></a>
            </div>
        </div>
    </div>

    <div class="top-header bold">
        <div class="header-title">
            <a href="/" class="text-decoration-none text-dark"><h1>Lions MD307 Convention</h1></a>

            <ul class="mt-2">
            @auth
                <li class="dropdown">
                    <a class="btn" href="/login" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-lg-inline text-gray-600 bold small">{{auth()->user()->full_name}}</span>
                        <i class="fa-solid fa-user fa-md" style="color: #4c076b"></i>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown shadow fade in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/dashboard">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        @role('admin')
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Manage Admins
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user-group fa-sm fa-fw mr-2 text-gray-400"></i>
                            Manage Participants
                        </a>
                        @endrole
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
                @endauth
                @guest
                <li class="nav-item d-flex justify-content-center">
                    <a href="/login" class="navbar-text btn bold small" style="color: black">Login <i class="fa-solid fa-user fa-md"></i></a>
                </li>
                @endguest
            </ul> 
        </div>

        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <!-- <a class="" href="login.html">Logout</a> -->
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="top-navigation">
        <div class="topnav" id="myTopnav">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Registration <br> Information
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="/register/information">Individual Registration</a></li> <hr>
                        <li><a class="dropdown-item" href="/register/information/group-organizers">Group Organizers & Tour Operators</a></li> <hr>
                        <li><a class="dropdown-item" href="/register/information/ticketed-events">Ticketed Events</a></li>
                    </ul>
                    </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        About <br> LionsCon
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Why Attend</a></li> <hr>
                        <li><a class="dropdown-item" href="#">City Attractions</a></li>
                    </ul>
                    </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Event <br> Experience
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Schedule</a></li> <hr>
                        <li><a class="dropdown-item" href="#">What Happens at MD-307 Convention</a></li> <hr>
                        <li><a class="dropdown-item" href="#">Exhibit Hall</a></li>
                    </ul>
                    </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Get <br> Involved
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Parade of Nations</a></li> <hr>
                        <li><a class="dropdown-item" href="#">Stage Presentations</a></li> <hr>
                        <li><a class="dropdown-item" href="#">Delegation Events</a></li> <hr>
                        <li><a class="dropdown-item" href="#">Pin Traders</a></li>
                    </ul>
                    </div>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        News & <br> Resources
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Event FAQs</a></li> <hr>
                        <li><a class="dropdown-item" href="#">News Blog</a></li> <hr>
                        <li><a class="dropdown-item" href="#">Promotional Tools</a></li>
                    </ul>
                    </div>
        </div>
    </div>
        <div class="mobile-navigation d-none">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReginfo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <span>Registration <br> Information</span>
                    </a>
                    <div id="collapseReginfo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white collapse-inner rounded">
                            <hr>
                            <a class="collapse-item" href="/register/information">Individual Registration</a> <hr>
                            <a class="collapse-item" href="/register/information/group-organizers">Group Organizers & Tour Operators</a> <hr>
                            <a class="collapse-item" href="/register/information/ticketed-events">Ticketed Events</a>
                            <hr>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAbout"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <span>About <br> LionsCon</span>
                    </a>
                    <div id="collapseAbout" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white collapse-inner rounded">
                        <hr>
                            <a class="collapse-item" href="#">Why Attend</a> <hr>
                            <a class="collapse-item" href="#">City Attractions</a>
                        <hr>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExp"
                        aria-expanded="true" aria-controls="collapseTwo">
                        Event <br> Experience
                    </a>
                    <div id="collapseExp" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white collapse-inner rounded">
                            <hr>
                            <a class="collapse-item" href="#">Schedule</a> <hr>
                            <a class="collapse-item" href="#">What Happens at MD-307 Convention</a> <hr>
                            <a class="collapse-item" href="#">Exhibit Hall</a>
                            <hr>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInv"
                        aria-expanded="true" aria-controls="collapseTwo">
                        Get <br> Involved
                    </a>
                    <div id="collapseInv" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white collapse-inner rounded">
                        <hr>
                            <a class="collapse-item" href="#">Parade of Nations</a> <hr>
                            <a class="collapse-item" href="#">Stage Presentations</a> <hr>
                            <a class="collapse-item" href="#">Delegation Events</a> <hr>
                            <a class="collapse-item" href="#">Pin Traders</a>
                        <hr>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNews"
                        aria-expanded="true" aria-controls="collapseTwo">
                        News & <br> Resources
                    </a>
                    <div id="collapseNews" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white collapse-inner rounded">
                        <hr>
                            <a class="dropdown-item" href="#">Event FAQs</a> <hr>
                            <a class="dropdown-item" href="#">News Blog</a> <hr>
                            <a class="dropdown-item" href="#">Promotional Tools</a>
                        <hr>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="event-content">
        @yield('content')
    </div>
    <div class="mt-3 mb-1" style="width: 100%; max-width: 1080px; margin: 0 auto;" align="center">
        <h1>MD-307 Convention</h1>
    </div>
    
    <div class="top-banner">
        <h3>June 00-00, 2024</h3>
    </div>
    
    <div class="footer">
        <div class="row">
            <div class="col-md-5 footer-section">
                <h3>MD-307 International</h3>
                <h3>Contact Us</h3>
                <ul>
                    <li>+1 (630) 571-5466</li>
                    <li class="bold">convention@lionsclubs.org</li>
                    <li>300 W. 22nd Street <br> Oak Brook, IL 60523-8842 USA</li>
                </ul>
            </div>
            <div class="col-md-4 footer-section">
                <h3>General <br> Information</h3>
                <ul class="bold">
                    <li><a>About LionsCon</a></li>
                    <li><a>City Attractions</a></li>
                    <li><a>Event FAQs</a></li>
                </ul>
                <div class="row">
                    <div class="col-md-12 footer-section">
                        <h3>Attending LionsCon</h3>
                        <ul class="bold">
                            <li>Registration Information</li>
                            <li>Exhibit Hall</li>
                            <li>Group Organizers & <br> Tour Operators</li>
                        </ul>
                    </div>
                    <div class="col-md-12 footer-section">
                        <h3>Travel Information</h3>
                        <ul class="bold">
                            <li>Air Travel</li>
                            <li>Hotel Information</li>
                            <li>Country Entry Requirements</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 footer-section">
                <h3>Latest News</h3>
                <div class="row">
                    <div class="col-md-4">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                            class="rounded-circle img-fluid bg-white" style="width: 150px;">
                    </div>
                    <div class="col-md-8 bold">
                        <p>Exploring Indonesia like a local</p>
                    </div>
                </div>
            </div>
        </div>
        </ul>
    </div>

    {{-- custom js styles --}}
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    

    @stack('body-scripts')
</body>
</html>