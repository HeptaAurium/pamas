<nav class="navbar navbar-expand navbar-light clear-left top-nav-main shadow fixed-top mb-3 bg-dark text-white">
    <div class="container">
        <a class="navbar-brand logo-text text-white d-md-none" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="sidebar-toggler btn  text-white d-block d-md-none" type="button">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @hasrole('Super-Admin|Admin|Accountant')
                <li class="nav-item dropdown">
                    <a id="btnPayroll" class="nav-link btn btn-success btn-sm mr-3 text-white" href="/payroll" role="">
                        {{ __('Payroll') }}
                    </a>
                </li>
                @endhasrole
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-black" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Profile') }}
                        </a>
                        <a class="dropdown-item text-black" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
