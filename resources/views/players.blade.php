@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
                <div class="row">
                    <div class="col-7">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                football
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6>JUNE 2021</h6>
                                    <p> UEFA EURO</p>
                                </div>
                                <div class="mb-2">
                                    <h6>JULY 2021</h6>
                                    <p> Champions league</p>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                BasketBall
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6>JUNE 2021</h6>
                                    <p> NBA Finals</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-5 mt-5">
                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                latest football matches
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    <p> Realmadrid vs Chelsea, June 24, 2021</p>
                                </div>
                                <div class="mb-2">
                                    <p> Arsenal vs Liverpool, June 24, 2021</p>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-hover-shadow-2x mb-3 mt-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                latest basket ball matches
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="mb-4">
                                    <p> LA Lakers vs Clevland Cavaliers,  June 24, 2021</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <!-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
