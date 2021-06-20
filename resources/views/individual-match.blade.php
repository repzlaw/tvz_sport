@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            Poland vs Belguim, 16th jun 2021
                            </div>
                        </div> 
                        <div class="card-body">
                            <!-- <div class="row first"> -->
                                <div class="col-12">
                                    <p>Date: 16/06/21</p>
                                </div>
                                <!-- matches -->
                                <div class="row ml-3">
                                    <div class="col-md-4 col-12">
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <p><Strong>Poland</Strong></p>
                                            </div>
                                            <div class="col-md-1 col-12">
                                                <p><Strong>1</Strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <p><Strong>Belguim</Strong></p>
                                            </div>
                                            <div class="col-md-1 col-12">
                                                <p><Strong>3</Strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div> -->
                            
                        </div>
                    </div>

                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            Odds
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="row mb-3 ">
                                <div class="col-md-3 col-12">
                                    <h6>odd</h6>
                                </div>

                                <div class="col-md-3 col-12">
                                    <h6>odd type</h6>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <h6> <strong>Tip </strong> </h6>
                                <p> Belguim wins 3 : 2 by roma</p>
                                <p> Poland wins 3 : 2 by marca</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-hover-shadow-2x mb-3 mt-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            Match Commentary
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="mb-3">
                                <h6> <strong>4 mins ago </strong> </h6>
                                <h6>Pogba passes the ball</h6>
                            </div>

                            <div class="mb-3">
                                <h6> <strong>5 mins ago </strong> </h6>
                                <h6>Benzema's shot saved by kahn</h6>
                            </div>
                            
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
