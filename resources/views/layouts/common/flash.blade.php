@if (session()->has('flash_notification.message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session('flash_notification.message') !!}
            </div>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 id="oh-snap!-you-got-an-error!">Oh snap! You got an error!<a
                        class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span
                            class="anchorjs-icon"></span></a></h4>
                <p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </p>
            </div>
        </div>
    </div>
@endif