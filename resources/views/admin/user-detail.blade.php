@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('admin/master/user')}}" class="btn btn-danger m-0">Back</a>
    <div>
        <button type="button" class="btn btn-sm edit-btn btn-primary" data-toggle="modal" data-target="#editModal">
            Edit
        </button>
        <a class="btn btn-sm btn-danger m-0" href="{{url('/admin/master/user/delete/'.$user->id)}}">Delete</a>
    </div>
</div>
<div class="print-place">
    <div class="card w-100 mb-5" >
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="class-list">
    <div class="card w-100 mb-5" >
        <div class="card-body">
            <h5> CLassroom List </h5>
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Division</th>
                    </tr>
                    @foreach ($classroom  as $index => $class)
                    <tr>
                        <th scope="row" class="text-center">{{$index + 1}}</th>
                        <td scope="col">{{ $class->class_name }}</td>
                        <td scope="col">{{$class->division}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 w-100">
                {{ $classroom->links() }}
            </div>
        </div>
    </div>
</div>

<div class="class-list">
    <div class="card w-100 mb-5" >
        <div class="card-body">
            <h5> Task List </h5>
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Task Name</th>
                        <th scope="col">Group</th>
                        <th scope="col">Expired at</th>
                    </tr>
                    @foreach ($task  as $index => $item)
                    <tr>
                        <th scope="row" class="text-center">{{$index + 1}}</th>
                        <td scope="col">{{ $item->name }}</td>
                        <td scope="col">{{$item->group}}</td>
                        <td scope="col">{{$item->expired_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 w-100">
                {{ $task->links() }}
            </div>
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
                    <input type="text"  class="form-control" placeholder="Student Name" name="name" id="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Email</label>
                    <input type="email"  class="form-control" placeholder="Student Email" name="email" id="email"  value="{{$user->email}}">
                </div>
                <div class="form-group">
                    <label for="phone_number">Password</label>
                    <input type="password"  class="form-control" placeholder="Password" name="password" id="password">
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

