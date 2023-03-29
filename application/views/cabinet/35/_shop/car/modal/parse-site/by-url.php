<div id="parse-site-car-by-url" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Парсинг данных с сайтов (загрузка ссылок)</h4>
            </div>
            <div class="modal-body">
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
                            <option data-id="efa-germany.com/efa-en" value="efa-germany.com/efa-en">Efa-germany.com (англиская версия) запрос по ссылкам. Дата обновления: 12.02.2019</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <span for="input-name" class="control-label">Список ссылок для загрузки</span>
                    <div class="input-group input-group-select">
                        <textarea name="urls" placeholder="Список ссылок" rows="3" class="form-control"></textarea>
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
                <button type="button" class="btn btn-default pull-left" onclick="parseSiteURLStop()">Отмена</button>
                <button data-id="button-parse" type="button" class="btn btn-primary" onclick="parseSiteURLStart()">Парсинг</button>
            </div>
        </div>
    </div>
    <script>
        var urls = [];
        var count = 0;
        var index = 0;

        function parseSiteURL() {
            if ($('#parse-site-car-by-url').attr('start') != 1){
                return false;
            }

            if (urls.length < 1){
                $('#parse-site-car-by-url [data-id="button-parse"]').text('Парсинг');
                return true;
            }
            var url = $.trim(urls.pop());
            index = index + 1;
            if(url == ''){
                parseSiteURL();
                return false;
            }

            var shopID = <?php echo $siteData->shopID; ?>;
            var type = <?php echo Request_RequestParams::getParamInt('type'); ?>;
            var site = $('#parse-site-car-by-url [name="site"]').val();
            var isReplace = $('#parse-site-car-by-url [name="is_replace"]').val();

            jQuery.ajax({
                url: '/cabinet/shopcar/parse_site_by_url',
                data: ({
                    'url': (url),
                    'shop_branch_id': (shopID),
                    'site': (site),
                    'type': (type),
                    'is_replace': (isReplace),
                }),
                type: "POST",
                success: function (data) {
                    $('#parse-site-car-by-url [data-id="progress"]').attr('style', 'width:'+(100 / count * index)+'%');
                    $('#parse-site-car-by-url [data-id="progress-status"]').text('Обработано ' + index + ' записей(ь)');
                    parseSiteURL();
                },
                error: function (data) {
                    console.log(data.responseText);
                    $('#parse-site-car-by-url [data-id="button-parse"]').text('Продолжить парсинг');
                }
            });
        }

        function parseSiteURLStart() {
            urls = $.trim($('#parse-site-car-by-url [name="urls"]').val()).split("\n");
            count = urls.length;

            $('#parse-site-car-by-url').attr('start', 1);
            $('#parse-site-car-by-url [data-id="button-parse"]').text('Идет парсинг');
            parseSiteURL();
        }
        function parseSiteURLStop() {
            $('#parse-site-car-by-url').attr('start', 0);
            $('#parse-site-car-by-url').modal('hide');
        }
    </script>
</div>