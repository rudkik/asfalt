<div id="parse-site-car" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Парсинг данных с сайтов поиск по артиклу</h4>
            </div>
            <div class="modal-body">
                <h4 class="box-title">В обработке <?php echo Func::getCountElementStrRus(count($data->values['ids']), 'записей', 'запись', 'записи'); ?></h4>
                <div class="form-group">
                    <div class="input-group input-group-select">
                        <label class="span-checkbox">
                            <input name="is_replace" value="0" checked type="checkbox" class="minimal">
                            Заменить не пустые значения?
                        </label
                    </div>
                </div>
                <div class="form-group">
                    <span for="input-name" class="control-label">Сайт</span>
                    <div class="input-group input-group-select">
                        <select class="form-control select2" style="width: 100%;" name="site">
                            <option data-id="0" value="0">Выберите сайт</option>
                            <option data-id="ensto.com" value="ensto.com">Еnsto.com (русская версия) поиск по артиклу. Дата обновления: 18.12.2018</option>
                            <option data-id="phk-holod.ru" value="phk-holod.ru">Phk-holod.ru (русская версия) поиск по артиклу. Дата обновления: 20.12.2018</option>
                            <option data-id="made-in-china.com" value="made-in-china.com">Made-in-china.com (русская версия) поиск по артиклу. Дата обновления: 26.12.2018</option>
                            <option data-id="made-in-china.com" value="made-in-china.com">Stolicaholoda.ru (русская версия) поиск по артиклу. Дата обновления: 27.12.2018</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <span data-id="progress-status" for="input-name" class="control-label">Прогресс</span>
                    <div class="input-group input-group-select">
                        <div class="progress progress-sm active">
                            <div data-id="progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" onclick="parseSiteStop()">Отмена</button>
                <button data-id="button-parse" type="button" class="btn btn-primary" onclick="parseSiteStart()">Парсинг</button>
            </div>
        </div>
    </div>
    <script>
        var ids = <?php echo json_encode($data->values['ids']); ?>;
        var count = <?php echo count($data->values['ids']); ?>;
        var index = 0;

        function parseSite() {
            if ($('#parse-site-car').attr('start') != 1){
                return FALSE;
            }

            if (ids.length < 1){
                return TRUE;
            }
            var id = ids.pop()
            index = index + 1;

            var site = $('#parse-site-car [name="site"]').val();
            var isReplace = $('#parse-site-car [name="is_replace"]').val();

            jQuery.ajax({
                url: '/cabinet/shopcar/parse_site_by_article',
                data: ({
                    'id': (id),
                    'site': (site),
                    'is_replace': (isReplace),
                }),
                type: "POST",
                success: function (data) {
                    $('#parse-site-car [data-id="progress"]').attr('style', 'width:'+(100 / count * index)+'%');
                    $('#parse-site-car [data-id="progress-status"]').text('Обработано ' + index + ' записей(ь)');
                    parseSite();
                },
                error: function (data) {
                    console.log(data.responseText);
                    $('#parse-site-car [data-id="button-parse"]').text('Продолжить парсинг');
                }
            });
        }

        function parseSiteStart() {
            $('#parse-site-car').attr('start', 1);
            $('#parse-site-car [data-id="button-parse"]').text('Идет парсинг');
            parseSite();
        }
        function parseSiteStop() {
            $('#parse-site-car').attr('start', 0);
            $('#parse-site-car').modal('hide');
        }
    </script>
</div>