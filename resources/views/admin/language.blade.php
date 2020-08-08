@extends('layouts.admin.app')

@section('content')

<div class="row mb-2">
        <div class="col-lg-12 col-xl-12">
           <div class="card ">
              <div class="card-header">
                 <div class="form-layout">
                     <div class="row">
                     <div class="col-md-6">
                         <h5 class="card-title mt-2">ثوابت النظام - اللغة</h5>
                         <p class="card-subtitle">إدارة المحتوى</p>
                    </div>
                    <div class="col-md-6">
                <div class="form-group pull-left">

                        <div class="dropdown">
                                <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 {{ __('config.language') }} - {{ucwords($lang)}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                </div>
                              </div>
                    </div>
                    </div>
                    </div>
                 </div>
              </div>
              <!-- card-body -->



<form method="POST"  enctype="multipart/form-data"  action="{{ route('admin.language.update', $name) }}">
    {{method_field('PATCH')}}
@csrf
<input type="hidden" name="lang" value="en">



              <div class="card-body row">
                 <div class="col-md-6">


                    @foreach ($text as $key => $value)
                    @if ($key % 13 != 0)
                        </div>
                        <div class="col-md-6">
                    @endif

                        <div class="form-group">
                            <div class="row col-md-12">
                                <label  class=" col-md-4" for="name">{{ $value->value }} <span class="tx-danger">*</span></label>
                            <input  class=" col-md-8 form-control" type="text" name="{{$value->token}}" value="{{$value->val}}"  >
                            </div>
                        </div>

                    @endforeach





                 </div>

              </div>
           </div>
        </div>
     </div>


     <div class="row mt-2">
            <div class="col-lg-12 col-xl-12">
               <div class="card ">
                  <div class="card-body">
                     <div class="form-layout">

                    <div class="form-group pull-left">
                            <button type="reset" class="btn btn-secondary" >{{ __('config.cancel') }} <i class="icon ion-android-cancel"> </i>  </button>
                            <button type="submit" class="btn btn-primary" >{{ __('config.edit') }} <i class="icon ion-edit"> </i>  </button>
                        </div>
                     </div>
                  </div>
                  <!-- card-body -->
               </div>
               <!-- card -->
            </div>

         </div>

</form>
@stop

