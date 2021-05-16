var lang = {
    "processing": "Подождите...",
    "search": "Поиск:",
    "lengthMenu": "Показать _MENU_ записей",
    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
    "infoEmpty": "Записи с 0 до 0 из 0 записей",
    "infoFiltered": "(отфильтровано из _MAX_ записей)",
    "infoPostFix": "",
    "loadingRecords": "Загрузка записей...",
    "zeroRecords": "Записи отсутствуют.",
    "emptyTable": "В таблице отсутствуют данные",
    "paginate": {
        "first": "Первая",
        "previous": "Предыдущая",
        "next": "Следующая",
        "last": "Последняя"
    },
    "aria": {
        "sortAscending": ": активировать для сортировки столбца по возрастанию",
        "sortDescending": ": активировать для сортировки столбца по убыванию"
    }
};

function changeStatus() {
    $('.changeStatus').off().on('click', function () {
        id = $(this).data('id');
        $(this).parent().html('<div class="dimmer active mx-auto "><div class="my-0 lds-ring"><div></div><div></div><div></div><div></div></div></div>');
        $('.form-edit-show').find('[name=id]').val($(this).data('id'));
        $('#changeShow').trigger('editShow');
    });
}

function changeStatusModal() {
    $('.changeStatusModal').off().on('click', function () {
        $('[name=status]').val(1 - $('[name=status]').val());
        if ($('[name=status]').val() == 1)
            $(this).html('<i class="far fa-2x fa-check-circle show-icon "></i>');
        else
            $(this).html('<i  class="fas fa-2x fa-ban unshow-icon"></i>');
    });
}

function changeImage() {

    let img = $('.edit-img');
    let editImg = $('.hover-img');
    let input = $('[name=image]');
    let formTable = $('#edit-form-img');

    img.next().css('margin-left', -img.width() / 2 - 10);
    img.next().css('margin-top', img.height() / 2 - 10);
    img.on('load', function () {
        $(this).next().css('margin-left', -$(this).width() / 2 - 10);
        $(this).next().css('margin-top', $(this).height() / 2 - 10);
    });
    editImg.off().click(function (e) {
        let id = null;
        let type = $(this).data('type');
        let inpImage = $('[name=image][data-type=' + type + ']');
        if (type === 'table') {
            id = $(this).parent().parent().data('id');
            inpImage.attr('data-id', id);
            inpImage.data('id', id);
        }
        if ((type === 'edit') || ((type === 'add'))) {
            id = $(this).data('id');
            inpImage.attr('data-id', id);
            inpImage.data('id', id);
        }
        $('[name=image][data-type=' + $(this).data('type') + '][data-id=' + id + ']').trigger('click');
    });

    input.off().on('change', function (e) {
        let id = $(this).data('id');
        let data_type = $(this).data('type');
        $('input[name=id][data-type=' + data_type + ']').val(id);
        if (data_type === 'table')
            formTable.trigger('sendImage');
        if (e.target.files && e.target.files[0].type.match('image')) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('[data-id=' + id + ']').find('.edit-img[data-type=' + data_type + ']').attr('src', e.target.result).on('load', function () {
                    let loadFile = $('.loader-file[data-id=' + id + '][data-type=' + data_type + ']');
                    loadFile.css('margin-left', -this.width / 2 - 10);
                    loadFile.css('margin-top', this.height / 2 - 10);
                });
            };
            reader.readAsDataURL($(this)[0].files[0]);
        }
    });
}

function deleteModal() {
    $(".delete").click(function () {
        $('#form-delete').find('input[name="delete"]').val($(this).parent().parent().data('id'));
    });

    $("#delete").click(function () {
        $('#delete-modal').modal('toggle');

    });
}

