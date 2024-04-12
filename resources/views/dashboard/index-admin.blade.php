@extends('layouts.dashboard')

@section('content')

<input type="hidden" value="{{$totalRegistrants}}" name="totalReg" id="totalReg">
<input type="hidden" value="{{$totalPaidRegistrants }}" name="paidReg" id="paidReg">
<input type="hidden" value="{{$totalUnpaidRegistrants }}" name="unpaidReg" id="unpaidReg">
<input type="hidden" value="{{$totalNotIdentifiedRegistrants}}" name="unidentifiedReg" id="unidentifiedReg">
@foreach(range(1, 12) as $month)
    <input type="hidden" name="registrations_by_month[{{ 0 .$month }}]" value="{{ $month < 10 ? $registrationsByMonth->get(0 . $month, 0) : $registrationsByMonth->get($month, 0) }}">
@endforeach

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Registrants</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalRegistrants}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-users-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Lion</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$Lion_percent . '%'}}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{$Lion_percent . '%'}}" aria-valuenow="{{$Lion_percent}}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-person fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Leo
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$Leo_percent . '%'}}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{$Leo_percent . '%'}}" aria-valuenow="{{$Leo_percent}}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-person fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Adult Guest</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$Adult_percent . '%'}}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                            style="width: {{$Adult_percent . '%'}}" aria-valuenow="{{$Adult_percent}}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-person fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Registration Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Revenue Sources</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Paid
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Unpaid
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle" style="color: #858796"></i> Unidentified
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-md-12 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Participants</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">Council Chairperson <span
                        class="float-right">{{$CC_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: {{$CC_percent . '%'}}; background: #4c076b"
                        aria-valuenow="{{$CC_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">District Governor <span
                        class="float-right">{{$DG_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{$DG_percent . '%'}}"
                        aria-valuenow="{{$DG_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Past Council Chairperson <span
                        class="float-right">{{$PCC_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger " role="progressbar" style="width: {{$PCC_percent . '%'}}"
                        aria-valuenow="{{$PCC_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Past District Governor <span
                        class="float-right">{{$PDG_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$PDG_percent . '%'}}"
                        aria-valuenow="{{$PDG_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Region Chairperson <span
                        class="float-right">{{$RC_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{$RC_percent . '%'}}"
                        aria-valuenow="{{$RC_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Zone Chairperson <span
                        class="float-right">{{$ZC_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$ZC_percent . '%'}}"
                        aria-valuenow="{{$ZC_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Club President <span
                        class="float-right">{{$CP_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: {{$CP_percent . '%'}}; background: #bccc36" aria-valuenow="{{$CP_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Club Secretary <span
                        class="float-right">{{$CS_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{$CS_percent . '%'}}; background: #cc8936"
                        aria-valuenow="{{$CS_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Unknown Title <span
                        class="float-right">{{$Unknown_percent . '%'}}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: {{$Unknown_percent . '%'}}"
                        aria-valuenow="{{$Unknown_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Color System -->
        {{-- <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        Primary
                        <div class="text-white-50 small">#4e73df</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        Success
                        <div class="text-white-50 small">#1cc88a</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        Info
                        <div class="text-white-50 small">#36b9cc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        Warning
                        <div class="text-white-50 small">#f6c23e</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        Danger
                        <div class="text-white-50 small">#e74a3b</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                        Secondary
                        <div class="text-white-50 small">#858796</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-light text-black shadow">
                    <div class="card-body">
                        Light
                        <div class="text-black-50 small">#f8f9fc</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        Dark
                        <div class="text-white-50 small">#5a5c69</div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

    {{-- <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Illustrations</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                        src="img/undraw_posting_photo.svg" alt="...">
                </div>
                <p>Add some quality, svg illustrations to your project courtesy of <a
                        target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                    constantly updated collection of beautiful svg images that you can use
                    completely free and without attribution!</p>
                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                    unDraw &rarr;</a>
            </div>
        </div>

        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Development Approach</h6>
            </div>
            <div class="card-body">
                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                    CSS bloat and poor page performance. Custom CSS classes are used to create
                    custom components and custom utility classes.</p>
                <p class="mb-0">Before working with this theme, you should become familiar with the
                    Bootstrap framework, especially the utility classes.</p>
            </div>
        </div>

    </div> --}}
</div>

@endsection