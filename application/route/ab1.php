<?php
Route::set('ab1', 'ab1/<controller>/<action>(/<id>)')
    ->defaults(array(
        'directory' => 'Ab1',
        'controller' => 'File',
        'action'     => '',
    ));
Route::set('aura3', 'ab1(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Ab1',
        'controller' => 'Aura3',
    ));
Route::set('ab1-integration-1c', 'ab1-integration-1c(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Ab1',
        'controller' => 'Integration',
    ));
Route::set('device', 'device(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Ab1',
        'controller' => 'Device',
    ));
Route::set('cash', 'cash(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Cash',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('cashbox', 'cashbox(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Cashbox',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('weighted', 'weighted(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Weighted',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('asu', 'asu(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Asu',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('bookkeeping', 'bookkeeping(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Bookkeeping',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('director', 'director(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Director',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('tunable', 'tunable(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Tunable',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('workflow', 'workflow(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Workflow',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('ballast', 'ballast(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Ballast',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('recipe', 'recipe(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Recipe',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('bid', 'bid(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Bid',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('train', 'train(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Train',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('abc', 'abc(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Abc',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('owner', 'owner(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Owner',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('ogm', 'ogm(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Ogm',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('pto', 'pto(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Pto',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('sbyt', 'sbyt(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Sbyt',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('atc', 'atc(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Atc',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('general', 'general(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/General',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('jurist', 'jurist(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Jurist',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('peo', 'peo(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Peo',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('crusher', 'crusher(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Crusher',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('make', 'make(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Make',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('lab', 'lab(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Lab',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('ecologist', 'ecologist(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Ecologist',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('sge', 'sge(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Sge',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('sales', 'sales(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Sales',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('nbc', 'nbc(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Nbc',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('nbu', 'nbu(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Nbu',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('technologist', 'technologist(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Technologist',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('ab1-admin', 'ab1-admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Admin',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('kpp', 'kpp(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Kpp',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('zhbibc', 'zhbibc(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Zhbibc',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('control', 'control(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ab1/Control',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));