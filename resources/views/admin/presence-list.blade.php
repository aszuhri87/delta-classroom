@extends('admin.layout')

@section('content')

<div class="card w-100 mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Student Presence List</h5>
        </div>
        <table class="table mb-0 table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Student Name</th>
                    <th scope="col" class="text-center">Group Name</th>
                    <th scope="col" class="text-center">Presence Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $classroom)
                <tr>
                    <th scope="row" class="text-center">{{$index + 1}}</th>
                    <td>{{$classroom->student_name}}</td>
                    <td>{{$classroom->group_name}}</td>
                    <td>{{$classroom->presence_date}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 w-100">
            {{ $list->links() }}
        </div>
    </div>
</div>


@endsection


