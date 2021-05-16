@include('admin.blocks.head-links')
<body class="">
<div id="global-loader"></div>
<div class="page">
    <div class='page-main'>
        @include('admin.blocks.header')
        @include('admin.blocks.menu')
        @yield('content')
    </div>
    @include('admin.blocks.footer')
</div>
@include('admin.blocks.scripts')
<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Подтверждение удаления</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Я в здравом уме, твердой памяти, при ясном сознании, действую добровольно, понимаю значение своих действий. Все действия <strong></strong> Вы делаете на свой страх и риск :)
                <div class="alert alert-danger mt-3">После удаления данные <strong>не подлежат</strong> восстановлению</div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</a>
                <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-item">Удалить</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>