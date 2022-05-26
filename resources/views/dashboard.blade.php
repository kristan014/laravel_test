@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5 mr-2">
                    <h5 class="text-dark font-weight-bold"><strong>Knowledge base</strong></h5>

                    <!-- Area Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Statistic</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                      
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5 class="text-dark font-weight-bold"><strong>User Profile</strong></h5>


                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-bar-demo.js') }}"></script>
@endsection
