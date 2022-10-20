@extends('admin.layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Division List</h5>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Add
                </button>
            </div>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th width="80%" scope="col">Name</th>
                    <th width="20%" scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $item)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$item->name}}</td>
                    <td class="text-center">
                        @if (Auth::guard('admin')->user()->division_id == $item->id || Auth::guard('admin')->user()->division_id == null)
                        <a type="button" class="btn edit-btn btn-primary" data-toggle="modal" data-target="#editModal">
                            Edit
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <form action="{{url('admin/master/division/update/'.$item->id)}}" method="post" id="form-edit">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Edit Division</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="number-input">Name</label>
                                                <input type="text"  class="form-control" placeholder="Student Name" name="name" id="name" value="{{$item->name}}">
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
                        <a class="btn btn-danger m-0" href="{{url('/admin/master/division/delete/'.$item->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        @endif
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{url('admin/master/division/')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="number-input">Name</label>
                        <input type="text" required class="form-control" placeholder="Division Name" name="name" id="name">
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
