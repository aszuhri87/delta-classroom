@extends('layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        @if($errors->has('message'))
            <div class="alert alert-danger mt-3" style="text-align: left;" role="alert">
                {{ $errors->first('message') }}
            </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success mt-3" style="text-align: left;" role="alert">
            {{ 'Presensi berhasil!' }}
        </div>
        @endif
        <div class="d-flex justify-content-center mb-3">
            <h5>Silahkan Presensi</h5>
        </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#presenceModal">
                    Presensi sekarang
                </button>
            </div>
            <!-- Modal Edit-->
            <div class="modal fade" id="presenceModal" tabindex="-1" aria-labelledby="presenceModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{url('/classroom/presence')}}" id="form-edit" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="presenceModalLabel"><i class="fa fa-address-card" aria-hidden="true"></i>Masukkan Kode Presensi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" required class="form-control" placeholder="Kode Presensi" name="presence_code" id="presence_code">
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
        <div class="mt-4 w-100">
            {{ $list->links() }}
        </div>
    </div>
</div>

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Histori Presensi</h5>
        </div>
        <div class="table-responsive">
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col" class="text-center">Divisi</th>
                    <th scope="col" class="text-center">Tanggal Presensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $index => $list)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$list->class_name}}</td>
                    <td class="text-center">{{$list->division}}</td>
                    <td class="text-center">{{$list->datetime}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mt-4 w-100">
            {{ $history->links() }}
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
