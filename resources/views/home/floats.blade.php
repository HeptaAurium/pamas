<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <div class="card card-stats shadow-lg bg-dark">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-user-cog" aria-hidden="true"></i>
                        </div>
                        <p class="card-category">Number of Users</p>
                        <h3 class="card-title"> {{ count($users) }} </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <div class="card card-stats shadow-lg bg-dark">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <p class="card-category">No. of Staff Members</p>
                        <h3 class="card-title">{{ count($staff) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <div class="card card-stats shadow-lg bg-dark">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-money-bill    "></i>
                        </div>
                        <p class="card-category">Latest Taxation Computed</p>
                        <h3 class="card-title">KSH {{ number_format($latest->tax) }}</h3>
                    </div>
                </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <div class="card card-stats shadow-lg bg-dark">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-money-bill    "></i>
                        </div>
                        <p class="card-category">Latest Payout Computed</p>
                        <h3 class="card-title">KSH {{ number_format($latest->payout) }}</h3>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
