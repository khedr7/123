@extends('admin.layouts.master')
@section('title','All Private Course')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Private Courses') }}
@endslot

@slot('menu1')
   {{ __('Private Course') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
      @can('private-course.delete')
      <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete"><i
        class="feather icon-trash mr-2"></i> Delete Selected</button>
        @endcan
        @can(' private-course.create')
        <a href="{{ route('private-course.create') }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>Add Private Course</a>
    @endcan
    </div>                        
</div>

@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">All Courses</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                value="all" />
                            <label for="checkboxAll" class="material-checkbox"></label> #</th>
                              <th>{{ __('adminstaticword.Course') }}</th>
                              <th>{{ __('adminstaticword.Status') }}</th>
                             
                              <th>{{ __('adminstaticword.Action') }}</th>
                            </tr>
                          </thead>
            
                          <tbody>
                            <?php $i=0;?>
                              
                                @foreach($private_courses as $course)
                                  <?php $i++;?>
                                  <tr>
                                    <td> <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                      name='checked[]' value={{ $course->id }} id='checkbox{{ $course->id }}'>
                                  <label for='checkbox{{ $course->id }}' class='material-checkbox'></label>
                                  <?php echo $i; ?>
                              <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                  <div class="modal-dialog modal-sm">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <div class="delete-icon"></div>
                                          </div>
                                          <div class="modal-body text-center">
                                              <h4 class="modal-heading">Are You Sure ?</h4>
                                              <p>Do you really want to delete selected item names here? This process
                                                  cannot be undone.</p>
                                          </div>
                                          <div class="modal-footer">
                                              <form id="bulk_delete_form" method="post"
                                                  action="{{ route('privatecourse.bulk_delete') }}">
                                                  @csrf
                                                  @method('POST')
                                                  <button type="reset" class="btn btn-gray translate-y-3"
                                                      data-dismiss="modal">No</button>
                                                  <button type="submit" class="btn btn-danger">Yes</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div></td>
                                   
                                    <td>{{$course->courses->title}}</td>
                                   <td>
                                    <label class="switch">
                                      <input class="privatecourse" type="checkbox"  data-id="{{$course->id}}" name="status"  {{ $course->status ==1 ? 'checked' : ''}}>
                                      <span class="knob"></span>
                                    </label>
                                    </td>

                                    <td>
                                  
                                      <div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                          @can('private-course.edit')
                                            <a class="dropdown-item" href="{{ route('private-course.show',$course->id) }}}"><i class="feather icon-edit mr-2"></i>Edit</a>
                                            @endcan
                                            @can('private-course.delete')
                                            <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                              </div>
                                              <div class="modal-footer">
                                                <form  method="post" action="{{url('private-course/'.$course->id)}}
                                                  "data-parsley-validate class="form-horizontal form-label-left">
                                                  {{ csrf_field() }}
                                                  {{ method_field('DELETE') }}
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                                  <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
                                              </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                    </td>
                                   
                                  </tr>
                                @endforeach
                             
                      
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      <!-- End col -->
  </div>
<!-- End row -->
</div>
@endsection

@section('scripts')
<script>
  "use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $(function() {
    $(document).on("change",".privatecourse",function() {
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('quickupdate/privatecourse')}}",
            data: {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
                var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
            });
                warning.get().click(function() {
                    warning.remove();
                });
            }
        });
    })
   
  })
</script>


@endsection
