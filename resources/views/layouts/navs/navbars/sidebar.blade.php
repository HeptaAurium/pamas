<div class="sidebar-main shadow-sm d-none d-md-block">
    <div class="side-top">
        <div class="d-flex flex-column justify-content-center text-center">
            <span class="logo-text">{{ config('app.name') }}</span> <br>
            {{-- <span>{{ $setting->business_name }}</span>
            --}}
        </div>
    </div>

    <hr style="border-top:1px solid #ddd;width: 90%; margin: 20px auto;">

    <ul class="nav justify-content-center flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/">
                <i class="fa fa-home" aria-hidden="true"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#staff_dd" aria-expanded="true">
                <i class="fa fa-users" aria-hidden="true"></i>
                {{ __('Staff Management') }}
                <i class="fa fa-caret-down float-right" aria-hidden="true" style="padding: 5px;"></i>

            </a>
            <div class="collapse" id="staff_dd">
                <ul class="nav">
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/staff">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('List Staff Members') }} </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/staff/create">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('Add Staff Member') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#departments" aria-expanded="true">
                <i class="fa fa-building" aria-hidden="true"></i>
                {{ __('Departments') }}
                <i class="fa fa-caret-down float-right" aria-hidden="true" style="padding: 5px;"></i>

            </a>
            <div class="collapse" id="departments">
                <ul class="nav">
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/staff">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('List Staff Members') }} </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/staff/create">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('Add Staff Member') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#allowances" aria-expanded="true">
                <i class="fa fa-building" aria-hidden="true"></i>
                {{ __('Allowances') }}
                <i class="fa fa-caret-down float-right" aria-hidden="true" style="padding: 5px;"></i>

            </a>
            <div class="collapse" id="allowances">
                <ul class="nav">
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/allowance">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('List Allowances') }} </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/allowance/create">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('Configure Allowances') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>

    <hr>

    <ul class="nav justify-content-center flex-column position-relative" style="top:40vh">
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="true">
                <i class="fas fa-cogs    "></i>
                {{ __('Set Up') }}
                <i class="fa fa-caret-down float-right" aria-hidden="true" style="padding: 5px;"></i>

            </a>
            <div class="collapse" id="settings">
                <ul class="nav">
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/settings/business">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('Business Settings') }} </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown-item">
                        <a class="nav-link" href="/settings/taxation">
                            <span class="sidebar-mini"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="sidebar-normal">{{ __('Taxation') }} </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
