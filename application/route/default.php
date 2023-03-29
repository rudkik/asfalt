<?php
include 'telegram'.EXT;
include 'img'.EXT;
include 'config'.EXT;
//*
//include 'smmarket'.EXT;
include 'ab1'.EXT;
include 'sladushka'.EXT;
include 'auto_part'.EXT;
include 'tax'.EXT;
include 'hotel'.EXT;
include 'ads'.EXT;
include 'pyramid'.EXT;
include 'magazine'.EXT;
include 'nur'.EXT;
include 'calendar'.EXT;
include 'smg'.EXT;
include 'trade'.EXT;
include 'finance'.EXT;
//*/

// корзина
Route::set('cart', 'cart/<action>')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopCart',
    ));

// избранное
Route::set('favorite', 'favorite/<action>')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'Favorite',
    ));

// команды основного сайта
Route::set('user', 'user/<action>')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopUser',
    ));
Route::set('site', 'site/<action>')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
    ));
Route::set('system', 'system(/<action>)')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'System',
        'action'     => 'countrating',
    ));
Route::set('command', 'command(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopCommand',
    ));

// кабинет
Route::set('cabinet_shopreport', 'cabinet/shopreport/<type>/<report>')
    ->defaults(array(
        'directory' => 'Cabinet',
        'controller' => 'Shopreport',
        'action'     => 'index',
    ));

Route::set('cabinet', 'cabinet(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Cabinet',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));

// банк
Route::set('bank', 'bank(/<action>(/<bank>(/<bill>)))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'BankPay',
        'action'     => 'pay',
        'bank'     => '',
        'bill'     => '',
    ));


// стили
Route::set('css', 'css/<table_id>(/<year>/<month>/<day>/<tmp_id>)/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('css-addition', 'css/<table_id>/<year>/<month>/<day>/<tmp_id>/<files>/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('css-addition_1', 'css(/<table_id>(/<year>(/<month>(/<day>(/<tmp_id>(/<files>(/<index>)))))))/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));

// поисковые системы
Route::set('google.html', 'google<google_number>.html(/<id>)')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
        'action' => 'auth_google'
    ));
Route::set('yandex.html', 'yandex_<yandex_number>.html(/<id>)')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
        'action' => 'auth_yandex'
    ));
Route::set('sitemap.xml', 'sitemap.xml(/<id>)')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
        'action' => 'sitemap'
    ));
Route::set('yml.xml', 'yml.xml(/<id>)')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
        'action' => 'yml'
    ));

//include 'paradise'.EXT;
//*
// основной сайт
Route::set('action_ten', '(<one>(/<two>(/<tree>(/<four>(/<five>(/<six>(/<seven>(/<eight>(/<nine>(/<ten>(/<id>(.<ext>))))))))))))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'ShopSite',
        'action'     => 'action',
    ));
//*/