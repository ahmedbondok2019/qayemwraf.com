
    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed">
        <thead>
        <tr>
            <th> # </th>
            <th>{{ trans_db('dashboard.Name') }}</th>
            <th>{{ trans_db('dashboard.Total') }}</th>
            <th>{{ trans_db('dashboard.Email') }}</th>
            <th>{{ trans_db('dashboard.Phone') }}</th>
            <th>{{ trans_db('dashboard.Status') }}</th>
            <th>{{ trans_db('dashboard.BookDetails') }}</th>
            <th>{{ trans_db('dashboard.delete') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($reports as $item)
            <tr>
                @php($user = \App\User::where('id' , $item->user_id)->first())
                <td>{{ $item->id }}</td>
                <td>{{ isset($user) && $user != null ? $user->name : trans_db("dashboard.deleted") }}</td>
                <td>{{ $item->sum }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ \App\Http\Controllers\helper\HelperController::orderStatus($item->book_status) }}</td>
                <td><a href="{{ url('admin-2023/' . $route . '/edit') }}/{{$item->id}}" class="btn btn-success">{{ trans_db('dashboard.Show') }}</a></td>
                <td><a href="{{ url('admin-2023/' . $route . '/delete') }}/{{$item->id}}" class="btn btn-danger">{{ trans_db('dashboard.delete') }}</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>#</th>
            <th>{{ trans_db('dashboard.Name') }}</th>
            <th>{{ trans_db('dashboard.Total') }}</th>
            <th>{{ trans_db('dashboard.Email') }}</th>
            <th>{{ trans_db('dashboard.Phone') }}</th>
            <th>{{ trans_db('dashboard.Status') }}</th>
            <th>{{ trans_db('dashboard.BookDetails') }}</th>
            <th>{{ trans_db('dashboard.delete') }}</th>
        </tr>
        </tfoot>
    </table>
