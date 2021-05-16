@extends('admin::main')

@section('content')


    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h4 class="page-title">Управление групой</h4>
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('adminTranslationGroup', $group) }}
                </ol>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="card-title">Список ключей</div>
                            <a href="{{ route('adminTranslationGroupAdd',$group) }}" class="btn btn-outline-primary btn-sm">Добавить</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Группа</th>
                                        <th>Ключ</th>
                                        <th>Перевод</th>
                                        <th>Использование</th>
                                        <th>Создано</th>
                                        <th>Изменено</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $item->group }}</td>
                                            <td>{{ $item->key }}</td>
                                            <td>{!!   mb_substr(parseMultiLanguageString($item->text),0,35) !!}</td>
                                            <td>&#64;lang('{{ $item->group.'.'.$item->key }}')</td>
                                            <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $item->updated_at->format('d.m.Y H:i') }}</td>

                                            <td class="align-middle">
                                                <a href="{{ route('adminTranslationEdit', ['group' => $item->group, 'id' => $item->id]) }}" class="fa fa-pencil-square-o" style="font-size: 19px"></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">Список групп пуст</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{--<ul class="pagination justify-content-center">{{ $items->links() }}</ul>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
