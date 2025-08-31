@extends('admin.layouts.master')
@section('content')


 <section class="section">
          <div class="section-header">
              <h1>{{ __('Languages') }}</h1>
          </div>

          <div class="card card-primary">
                  <div class="card-header">
                    <h4>{{ __('ALL Languages') }}</h4>
                    <div class="card-header-action">
                      <a href="#" class="btn btn-primary">
                           {{ __('Create New') }}
                      </a>
                    </div>
                  </div>
                  <div class="card-body">
                    <p>{{ __('Write something here') }}</p>
                  </div>
                </div>


      </section>

@endsection
