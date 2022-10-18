@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('admin/student')}}" class="btn btn-danger m-0">Back</a>
    <div>
        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
            Edit
        </a>
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
                        <th scope="col">Number</th>
                        <td scope="col">{{$student->number}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Division</th>
                        <td scope="col">{{$student->division}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Class Name</th>
                        <td scope="col">{{$student->class_name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{url('admin/tasks/'.$student->id)}}" method="post">
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
                            <input type="text" required class="form-control" placeholder="Student Name" name="name" id="name">
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
                            <label for="phone_number">Phone Number</label>
                            <input type="text" required class="form-control" placeholder="Student Phone Number" name="phone_number" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Email</label>
                            <input type="email" required class="form-control" placeholder="Student Email" name="email" id="email">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="number-input">Number</label>
                            <input type="text" required class="form-control" placeholder="Student Number" name="number" id="number">
                        </div>
                        <div class="form-group">
                            <label for="division">Division</label>
                            <select class="form-control" name="division" id="division">
                                <option value="">-- Select Division --</option>
                                <option value="Web"> Web </option>
                                <option value="A.I"> A.I </option>
                                <option value="Mobile"> Mobile </option>
                                <option value="Security"> Security </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class_name">Classroom</label>
                            <select class="form-control" name="group" id="group">
                                <option value="">-- Select Class --</option>
                                    @foreach ($classroom as $c)
                                        <option value="{{$c->id}}" data-id="{{$c->id}}"> {{$c->class_name}}</option>
                                    @endforeach
                            </select>
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
    });

    </script>
@endpush
