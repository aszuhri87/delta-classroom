@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('admin/master/user')}}" class="btn btn-danger m-0">Back</a>
    <div>
        @if (Auth::guard('admin')->user()->name == 'Admin' || Auth::guard('admin')->user()->id == $user->id)
        <button type="button" class="btn edit-btn btn-primary" data-toggle="modal" data-target="#editModal">
            Edit
        </button>
        @endif
        @if (Auth::guard('admin')->user()->name == 'Admin')
            <a class="btn btn-danger m-0" href="{{url('/admin/master/user/delete/'.$user->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
        @endif
    </div>
</div>
<div class="print-place">
    <div class="card w-100 mb-5">
        <div class="card-body">
            <h5> User Detail </h5>
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col">Name</th>
                        <td scope="col">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Email</th>
                        <td scope="col">{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Division</th>
                        <td scope="col">{{$user->division}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{url('admin/master/user/update/'.$user->id)}}" method="post" id="form-edit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number-input">Name</label>
                        <input type="text" class="form-control" placeholder="Student Name" name="name" id="name"
                            value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Email</label>
                        <input type="email" class="form-control" placeholder="Student Email" name="email" id="email"
                            value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="new_password"
                            id="password">
                    </div>
                    <div class="form-group">
                        <label for="division">Division</label>
                        <select class="form-control" name="division" id="division">
                            <option value="">-- Select Division --</option>
                                @foreach ($division as $g)
                                    <option value="{{$g->id}}" data-id="{{$g->id}}"> {{$g->name}}</option>
                                @endforeach
                        </select>
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
    $(document).ready(function () {
        var data_unit = <?php echo json_encode($user)?>;

        $('#form-edit').find('select[name="division"]').find('option[value="'+ data_unit.division_id+'"]').prop('selected', true);

        $('.btn-save').click(function () {
            $.blockUI({
                message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Mohon Tunggu...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
