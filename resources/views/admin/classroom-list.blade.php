@extends('admin.layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Classroom List</h5>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                Add
            </button>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Class Name</th>
                    <th scope="col" class="text-center">Teacher Name</th>
                    <th scope="col" class="text-center">Presence code</th>
                    <th scope="col" class="text-center">Division</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $classroom)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$classroom->class_name}}</td>
                    <td>{{$classroom->teacher_name}}</td>
                    <td class="text-center">{{$classroom->presence_code}}</td>
                    <td class="text-center">{{$classroom->division}}</td>
                    <td>
                        <div class="text-center">
                            <a type="button" class="btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#editModal{{$classroom->id}}">
                                Edit
                            </a>
                            <a class="btn btn-sm btn-success m-0" href="{{url('/admin/master/presence/'.$classroom->id)}}">Presence List</a>

                            <a class="btn btn-sm btn-danger m-0" href="{{url('/admin/classroom/delete/'.$classroom->id)}}">Delete</a>
                        </div>
                        <!-- Modal Edit-->
                        <div class="modal fade" id="editModal{{$classroom->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$classroom->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{url('admin/master/classroom/update/'.$classroom->id)}}" id="form-edit" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel"><i class="fa fa-address-card" aria-hidden="true"></i>Edit Clasroom</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="number-input">Name</label>
                                                <input type="text" required class="form-control" placeholder="Class Name" name="class_name" id="class_name" value="{{$classroom->class_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="division">Division</label>
                                                <select class="form-control" name="division" id="division" value="{{$classroom->division}}">
                                                    <option value="">-- Select Division --</option>
                                                    <option value="Web"> Web </option>
                                                    <option value="A.I"> A.I </option>
                                                    <option value="Mobile"> Mobile </option>
                                                    <option value="Security"> Security </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
            {{ $list->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('admin/master/classroom')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel"><i class="fa fa-address-card" aria-hidden="true"></i> Clasroom</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number-input">Name</label>
                        <input type="text" required class="form-control" placeholder="Class Name" name="class_name" id="class_name">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {
    var data_unit = <?php echo json_encode($classroom)?>;
    $(document).ready(function() {
        $(document).on('click', '.edit-btn', function(event){
            $('#form-edit').find('select[name="division"]').find('option[value="'+ data_unit.division+'"]').prop('selected', true);
        });
    });
});
</script>
@endpush

