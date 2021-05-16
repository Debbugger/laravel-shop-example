@extends('admin::main')

@section('title', 'Пользователи')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Пользователи</h4>
                @include('admin.blocks.breadcrumbs')
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Таблица пользователей</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users" class="table table-striped table-bordered w-100 table-responsive">
                                    <thead>
                                    <tr>
                                        <th class="wd-15p">#</th>
                                        <th class="wd-25p">Имя</th>
                                        <th class="wd-20p">Почта</th>
                                        <th class="wd-20p">Зарегисрирован</th>
                                        <th class="wd-10p">Редактировать</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="{{ asset('admin-styles/plugins/datatable/dataTables.bootstrap4.min.css') }}">
    <script src="{{ asset('admin-styles\plugins\datatable\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-styles\plugins\datatable\dataTables.bootstrap4.min.js') }}"></script>

    <script>

        let docs = $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('adminUsersTable')}}',
            columns: [
                {data: 'id', 'title': '#'},
                {data: 'name', 'title': 'Имя'},
                {data: 'email', 'title': 'Почта'},
                {data: 'created_at', 'title': 'Зарегисрирован'},
                {data: 'edit', 'title': 'Редактировать',"searchable": false,"ordering": false}
            ],
            language: lang,
            "order": [[0, "desc"]],
        });

    </script>
@endpush