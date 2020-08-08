@extends('layouts.admin.app')

@section('content')

<div class="row">
<div class="col-lg-12 col-xl-12">
            <div class="card widget-6">
              <div class="card-header">
                <div class=" align-items-center">

                    <span class="card-title"> القائمة البريدية</span> <br/>
                    <span class="card-subtitle"> {{ __('admin/slider.title.list.sub_value') }}</span>

                </div><!--  -->

              </div><!-- card-header -->
              <div class="card-body pd-25">


        <div class="table-wrapper">
                <table  class="datatable table display responsive nowrap">
                  <thead>
                    <tr>
                      <th class="wd-15p">{{ __('config.id') }}</th>
                      <th class="wd-5p">{{ __('config.email') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                          @foreach($subscribers as $key => $value)
                          <tr>
                              <td>{{ $value->id }}</td>
                              <td>{{ $value->email }}</td>

                          </tr>
                      @endforeach

                  </tbody>
                </table>
              </div><!-- table-wrapper -->

                </div><!-- card-body -->


              </div><!-- card -->
            </div>
            </div>


@include('admin.modal.delete')
@stop



@push('script')
@include('admin.datatable')

@endpush
