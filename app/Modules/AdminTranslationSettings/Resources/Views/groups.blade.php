@extends('admin::main')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Управление группами переводов</h4>
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('adminTranslationSetting') }}
                </ol>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">Список групп</div>
                            <a href="{{ route('adminTranslationAdd') }}" class="btn btn-outline-primary btn-sm">Добавить</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped m-0 p-0">
                                    <thead>
                                    <tr>
                                        <th>Группа</th>
                                        <th>Использование</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($groups as $group)
                                        <tr>
                                            <td>{{ $group->group }}</td>
                                            <td>{{ $group->group.'.*' }}</td>
                                            <td class="align-middle text-right">
                                                <a href="{{ route('adminTranslationGroup', ['group' => $group->group]) }}" class="fa fa-pencil-square-o" style="font-size: 19px"></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Список групп пуст</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
{{--                                <ul class="pagination justify-content-center">{{ $groups->links() }}</ul>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection