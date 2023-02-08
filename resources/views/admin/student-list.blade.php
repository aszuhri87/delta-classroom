@extends('admin.layout')

@section('content')

@if($errors->has('message'))
<div class="alert alert-danger mt-3" style="text-align: left;" role="alert">
    {{ $errors->first('message') }}
</div>
@endif

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Student List</h5>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                    Import
                </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Add
                </button>
            </div>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col" class="text-center">Group Name</th>
                    <th scope="col" class="text-center">Number</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $item)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$item->name}}</td>
                    <td class="text-center">{{$item->group_name}}</td>
                    <td class="text-center">{{$item->number}}</td>
                    <td class="text-center">
                        <a class="btn btn-success m-0"  href="{{url('/admin/student/'.$item->id)}}">Detail</a>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{url('admin/student/')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Student</h5>
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
                                <label for="number-input">Date of birth</label>
                                <input type="date" required name="birth" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="number-input">Number</label>
                                <input type="text" required class="form-control" placeholder="Student Number" name="number" id="number">
                            </div>
                            <div class="form-group">
                                <label for="number-input">School Origin</label>
                                <input type="text"  class="form-control" placeholder="School Origin" name="school_origin" id="school_origin">
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

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{url('admin/student/import')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Import Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="number-input">Excel File</label>
                    <div class="custom-file mb-2">
                        <input type="file" name="file" class="dropify" data-allowed-file-extensions="xls xlsx csv">
                    </div>
                    <span class="text-primary">*Minimum row of spreadsheet table is 2 row data!</span>
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
