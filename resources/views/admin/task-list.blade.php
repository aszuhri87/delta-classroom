@extends('admin.layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Task List</h5>
            <div>
                {{-- <a href="{{url('admin/student/export')}}" class="btn btn-success m-0">Export</a> --}}
                {{-- <a href="{{url('admin/presence/list')}}" class="btn btn-primary m-0">Presence</a> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Add
                </button>
            </div>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Teacher Name</th>
                    <th scope="col" class="text-center">Group Name</th>
                    <th scope="col" class="text-center">Task Name</th>
                    <th scope="col" class="text-center">Expired at</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $item)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$item->teacher_name}}</td>
                    <td class="text-center">{{$item->group_name}}</td>
                    <td class="text-center">{{$item->task_name}}</td>
                    <td class="text-center">{{$item->expired_at}}</td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-success m-0" target="_blank" href="{{url('/admin/task/'.$item->id)}}">Detail</a>
                        <a class="btn btn-sm btn-danger m-0" href="{{url('/admin/task/delete/'.$item->id)}}">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 w-100">
            {{ $list->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('admin/task')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number-input">Name</label>
                        <input type="text" required class="form-control" placeholder="Task Name" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="group">Group</label>
                        <select class="form-control" name="group" id="group">
                            <option value="">-- Select Group --</option>
                                @foreach ($group as $g)
                                    <option value="{{$g->id}}" data-id="{{$g->id}}"> {{$g->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <textarea name="detail" required class="form-control" placeholder="Write here ..." id="detail" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="number-input">Expired at</label>
                        <input type="datetime-local" required name="expired_at" class="form-control">
                    </div>
                    <label for="number-input">Task File</label>
                    <div class="custom-file mb-2">
                        <input type="file" name="file_path" class="dropify">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        $('.btn-save').click(function() {
            $('.modal').modal('hide');

            $.blockUI({
                message:
                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Mohon Tunggu...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                css: {
                backgroundColor: 'transparent',
                color: '#fff',
                border: '0'
                },
                overlayCSS: {
                opacity: 0.5
                },
                timeout: 1000,
            });
            });
    </script>
@endpush
