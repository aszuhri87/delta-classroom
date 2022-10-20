@extends('layout')

@section('content')
    <div class="card card-shadow w-100 mb-5" >
        <div class="card-body">
            @if($errors->has('message'))
            <div class="alert alert-danger mt-3" style="text-align: left;" role="alert">
                {{ $errors->first('message') }}
            </div>
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success mt-3" style="text-align: left;" role="alert">
            {{ 'Update password berhasil!' }}
        </div>
        @endif
        <div class="table-responsive">
            <table class="table mb-0 table-bordered" width="100%">
                <tbody>
                    <tr>
                        <th scope="col">Nama</th>
                        <td scope="col">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Nomor Telepon</th>
                        <td scope="col">{{$student->phone_number}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Email</th>
                        <td scope="col">{{$student->email}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Tanggal lahir</th>
                        <td scope="col">{{$student->birth}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Nomor</th>
                        <td scope="col">{{$student->number}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Asal Sekolah</th>
                        <td scope="col">{{$student->school_origin}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
            <br>
            <div>
                <center>
                    <button type="button" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal">
                        Update Password
                    </button>
                </center>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{url('update/password')}}" method="post" id="form-edit">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="number-input">Password Baru</label>
                    <div class="custom-file mb-2">
                        <input type="password" name="password" class="form-control">
                    </div>

                    <label for="number-input">Konfirmasi Password</label>
                    <div class="custom-file mb-2">
                        <input type="password" name="c_password" class="form-control">
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

