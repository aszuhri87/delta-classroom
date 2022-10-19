@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('admin/student')}}" class="btn btn-danger m-0">Back</a>
    <div>
        <button type="button" class="btn btn-sm edit-btn btn-primary" data-toggle="modal" data-target="#editModal">
            Edit
        </button>
        <a class="btn btn-sm btn-danger m-0" href="{{url('/admin/student/delete/'.$student->id)}}">Delete</a>
    </div>
</div>
<div class="print-place">
    <div class="card w-100 mb-5" >
        <div class="card-body">
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col">Name</th>
                        <td scope="col">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Group Name</th>
                        <td scope="col">{{ $student->group_name }}</td>
                    <tr>
                        <th scope="col">Phone Number</th>
                        <td scope="col">{{$student->phone_number}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Email</th>
                        <td scope="col">{{$student->email}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Date of bith</th>
                        <td scope="col">{{$student->birth}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Number</th>
                        <td scope="col">{{$student->number}}</td>
                    </tr>
                    <tr>
                        <th scope="col">School Origin</th>
                        <td scope="col">{{$student->school_origin}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Student History Presence</h5>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Class Name</th>
                    <th scope="col" class="text-center">Presence Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $index => $list)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$list->class_name}}</td>
                    <td class="text-center">{{$list->datetime}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 w-100">
            {{ $history->links() }}
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{url('admin/student/update/'.$student->id)}}" method="post" id="form-edit">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="number-input">Name</label>
                            <input type="text"  class="form-control" placeholder="Student Name" name="name" id="name" value="{{$student->name}}">
                        </div>
                        <div class="form-group">
                            <label for="group">Group</label>
                            <select class="form-control" name="group" id="group" value="{{$student->group_id}}">
                                <option value="">-- Select Group --</option>
                                    @foreach ($group as $g)
                                        <option value="{{$g->id}}" data-id="{{$g->id}}"> {{$g->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text"  class="form-control" placeholder="Student Phone Number" name="phone_number" id="phone_number"  value="{{$student->phone_number}}">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Email</label>
                            <input type="email"  class="form-control" placeholder="Student Email" name="email" id="email"  value="{{$student->email}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="phone_number">Password</label>
                            <input type="password"  class="form-control" placeholder="Password" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="number-input">Date of birth</label>
                            <input type="date" name="birth" class="form-control value="{{$student->birth}}"">
                        </div>
                        <div class="form-group">
                            <label for="number-input">Number</label>
                            <input type="text"  class="form-control" placeholder="Student Number" name="number" id="number"  value="{{$student->number}}">
                        </div>
                        <div class="form-group">
                            <label for="number-input">School Origin</label>
                            <input type="text"  class="form-control" placeholder="School Origin" name="school_origin" id="school_origin"  value="{{$student->school_origin}}">
                        </div>
                    </div>
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
        var data_unit = <?php echo json_encode($student)?>;

        $(document).on('click', '.edit-btn', function(event){
            $('#form-edit').find('select[name="group"]').find('option[value="'+ data_unit.group_id+'"]').prop('selected', true);
        });

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

