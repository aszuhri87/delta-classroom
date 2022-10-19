@extends('layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Daftar Tugas</h5>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 table-bordered" width="100%">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Nama Pengajar</th>
                        <th scope="col" class="text-center">Group</th>
                        <th scope="col" class="text-center">Tugas</th>
                        <th scope="col" class="text-center">Tanggal Berakhir</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $index => $item)
                    <tr>
                        <th scope="row" class="text-center">{{$index + 1}}</th>
                        <td>{{$item->teacher_name}}</td>
                        <td class="text-center">{{$item->group_name}}</td>
                        <td class="text-center">{{$item->task_name}}</td>
                        <td class="text-center">{{$item->expired_at}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-success m-0" href="{{url('task/'.$item->id)}}">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 w-100">
            {{ $list->links() }}
        </div>
    </div>
</div>

@endsection
