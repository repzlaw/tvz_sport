@if (count($errors) > 0)
    @foreach ($errors->all() as $error )
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12 col-md-9"></div>
            <div class="col-12 col-md-3">
                <div class="alert alert-danger float-right">
                    {{$error}}
                </div>

            </div>
        </div>
    </div>
    @endforeach
@endif

@if (session('success'))
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12 col-md-9"></div>
            <div class="col-12 col-md-3">
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12 col-md-9"></div>
            <div class="col-12 col-md-3">
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            </div>
        </div>
    </div>
@endif


@if (session('message'))
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12 col-md-9"></div>
            <div class="col-12 col-md-3">
                <div class="alert alert-info">
                    {{session('message')}}
                </div>
            </div>
        </div>
    </div>
@endif