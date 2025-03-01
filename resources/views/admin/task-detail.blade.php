@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('admin/task')}}" class="btn btn-danger m-0">Back</a>
    <div>

        <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal{{$task->id}}">
            Edit
        </button>
    </div>
</div>
<div class="print-place">
    <div class="card w-100 mb-5" >
        <div class="card-body">
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col">Name</th>
                        <td scope="col">{{ $task->task_name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Group Name</th>
                        <td scope="col">{{ $task->group_name }}</td>
                    <tr>
                        <th scope="col">Teacher Name</th>
                        <td scope="col">{{$task->teacher_name}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Detail</th>
                        <td scope="col">{{$task->detail}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Created at</th>
                        <td scope="col">{{$task->created_at}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Expired at</th>
                        <td scope="col">{{$task->expired_at}}</td>
                    </tr>
                    <tr>
                        <th scope="col">File</th>
                        <td scope="col"> <a target="_blank" href="{{asset($task->file_path)}}"> {{$task->task_file}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Student Assignment list</h5>
        </div>
        <table class="table mb-0 table-bordered" width="100%" id="table_assign">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col" class="text-center">Submitted At</th>
                    <th scope="col" class="text-center">Score</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignment as $index => $list)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$list->student_name}}</td>
                    <td class="text-center">{{$list->submitted_at}}</td>
                    <td class="text-center">{{$list->score}}</td>
                    <td>
                        <center>
                            <button type="button" class="btn btn-primary show-btn" data-toggle="modal" data-target="#showModal{{$list->assignment_id}}">
                                Show
                            </button>
                        </center>
                        <div class="modal fade" id="showModal{{$list->assignment_id}}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{url('admin/assignment/score')}}" id="form-{{$list->assignment_id}}" method="post">
                                        @csrf
                                        <input type="hidden" name="assignment_id" value="{{$list->assignment_id}}">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="number-input">Name</label>
                                                <input class="form-control" placeholder="Task Name" name="name" id="assignName" value="{{$list->assignment_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="detail">Detail</label>
                                                <textarea name="detail" id="assignmentDetail" required class="form-control" placeholder="Write here ..." id="detail" rows="3">{{$list->detail}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="number-input">Attachment : </label>
                                                <a target="_blank" name="filepath" id="filepath" href="{{ asset($list->file_path)}}"> <input type="text" id="assignFile" disabled class="form-control text-primary" value="{{$list->file_path}}"> </a>
                                            </div>
                                            <div class="form-group">
                                                <label for="number-input">Give Score</label>
                                                <input type="number" class="form-control" placeholder="Give your score" name="score" max="100" id="score" value="{{$list->score}}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary btn-save">Submit Score</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 w-100">
            {{ $assignment->links() }}
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="editModal{{$task->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$task->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('admin/task/update/'.$task->id)}}" id="form-edit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{$task->id}}">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number-input">Name</label>
                        <input type="text" required class="form-control" placeholder="Task Name" name="name" id="name" value="{{$task->task_name}}">
                    </div>
                    @if (Auth::guard('admin')->user()->division_id == null)
                    <div class="form-group">
                        <label for="division">Division</label>
                        <select class="form-control" name="division" id="division">
                            <option value="">-- Select Division --</option>
                                @foreach ($division as $g)
                                    <option value="{{$g->id}}" data-id="{{$g->id}}"> {{$g->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    @endif
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
                        <textarea name="detail" required class="form-control" placeholder="Write here ..." id="detail" rows="3" value="{{$task->detail}}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="number-input">Expired at</label>
                        <input type="datetime-local" required name="expired_at" class="form-control" value="{{$task->expired_at}}">
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
        var data_unit2 = <?php echo json_encode($assignment)?>;
        var data_unit = <?php echo json_encode($task)?>;

        $('.dropify').dropify();

        $(document).on('click', '.edit-btn', function(event){
            $('#form-edit').find('select[name="division"]').find('option[value="'+ data_unit.division_id+'"]').prop('selected', true);
            $('#form-edit').find('select[name="group"]').find('option[value="'+ data_unit.group_id+'"]').prop('selected', true);
            $('#form-edit').find('textarea[name="detail"]').val(data_unit.detail);
            $('#form-edit').find('input[name="file_path", type="file"]').val(data_unit.file_path);
            $('#form-edit').find('input[name="expired_at", type="datetime-local"]').val(data_unit.expired_at);
        });

        // $(document).on('click', '.show-btn', function(event){
        //     var i= null;
        //     i =  $(this).closest("tr").find('th:eq(0)').text()-1;

        //     $('#assignmentDetail').val(data_unit2.data[i].detail);
        //     $('#assignName').val(data_unit2.data[i].assignment_name);
        //     $('#assignFile').val(data_unit2.data[i].assignment_name);
        //     $('#score').val(data_unit2.data[i].score);
        //     $('#filepath').attr("href", "/"+ data_unit2.data[i].file_path);
        // });

        $('.btn-save').click(function() {
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
                baseZ: 2000
            });
        });
    });
    </script>
@endpush

