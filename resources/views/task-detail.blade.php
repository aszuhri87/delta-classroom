@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{url('dashboard')}}" style="z-index: 99;" class="btn btn-danger m-0">Kembali</a>
</div>
    <div class="card w-100 mb-5" >
        <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th width="40%" scope="col">Nama Tugas</th>
                        <td width="60%" scope="col">{{ $task->task_name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Group</th>
                        <td scope="col">{{ $task->group_name }}</td>
                    <tr>
                        <th scope="col">Nama Guru</th>
                        <td scope="col">{{$task->teacher_name}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Detail</th>
                        <td scope="col">{{$task->detail}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Dibuat Tanggal</th>
                        <td scope="col">{{$task->created_at}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Batas Waktu pengumpulan</th>
                        <td scope="col">{{$task->expired_at}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Lampiran Tugas</th>
                        <td scope="col"> <a href="{{asset($task->file_path)}}"> {{$task->task_file}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
            <br>
            <div>
                @if (!$assignment)
                <center>
                    <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#addModal">
                        Kumpulkan Tugas
                    </button>
                </center>
                @endif
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('assignment')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="task_id" id="task_id" value="{{$task->id}}">
                    <label for="number-input">File Tugas Kamu</label>
                    <div class="custom-file mb-2">
                        <input type="file" name="file_path" class="dropify">
                    </div>
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <textarea name="detail" required class="form-control" placeholder="Write here ..." id="detail" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($assignment != null)

<hr>
<!-- Modal -->
<div class="modal fade" id="editModal{{$assignment->assignment_id}}" tabindex="-1" aria-labelledby="editModalLabel{{$assignment->assignment_id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('assignment/update/'.$assignment->assignment_id)}}" method="post" id="form-edit" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Edit Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="task_id" id="task_id" value="{{$task->id}}">

                    <label for="number-input">File Tugas Kamu</label>
                    <div class="custom-file mb-2">
                        <input type="file" name="file_path" class="dropify">
                    </div>
                    <div class="form-group">
                        <label for="detail">Detail</label>
                        <textarea name="detail" required class="form-control" placeholder="Write here ..." id="detail" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="assignment-place">
    <div class="card w-100 mb-5" >
        <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th width="40%" scope="col">File Tugas</th>
                        <td width="60%" scope="col"> <a href="{{url('/assignment/download/'.$assignment->id)}}"> {{$assignment->assign_name}}</a></td>
                    </tr>
                    <tr>
                        <th scope="col">Tanggal Submit</th>
                        <td scope="col">{{$assignment->created_at}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Detail</th>
                        <td scope="col">{{ $assignment->detail }}</td>
                    </tr>
                </tbody>
            </table>

            @if (!$assignment->score)

            <center>
                <button type="button" class="btn btn-primary edit-btn mt-3" data-toggle="modal" data-target="#editModal{{$assignment->assignment_id}}">
                    Edit Tugas
                </button>
            </center>

            @endif

            <table class="table mb-0 table-bordered mt-5" width="100%">
                <tr>
                    <th width="40%" scope="col">Nilai</th>
                    <td width="60%" scope="col">{{ $assignment->score }}</td>
                </tr>
            </table>
        </div>
        </div>
    </div>
</div>

@endif

@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
        var data_unit = <?php echo json_encode($assignment)?>;
        $(document).on('click', '.edit-btn', function(event){
            $('#form-edit').find('textarea[name="detail"]').val(data_unit.detail);
            $('#form-edit').find('input[name="file_path", type="file"]').val(data_unit.file_path);
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

