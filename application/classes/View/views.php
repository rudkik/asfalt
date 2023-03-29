<?php defined('SYSPATH') or die('No direct script access.');

include_once 'views-fields.php';
include_once 'views-params.php';
include_once 'views-files.php';

// статьи
$shopNew = array(
    'DB_Shop_New_findOne' => array(
        'title' => array(
            'ru' => 'Статья (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopNewFiles,
    ),
    'DB_Shop_New_find' => array(
        'title' => array(
            'ru' => 'Статьи (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopNewFiles,
    ),
    'DB_Shop_New_findBranch' => array(
        'title' => array(
            'ru' => 'Статьи филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopNewFiles,
    ),

    'DB_Shop_Table_Rubric_findOne' => array(
        'title' => array(
            'ru' => 'Рубрика (одна)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Table_Rubric',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Table_View_findAll' => array(
        'title' => array(
            'ru' => 'Рубрики статей (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Table_Rubric',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Table_View_find' => array(
        'title' => array(
            'ru' => 'Рубрики статей (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Table_Rubric',
        'function' => 'find',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_New_findShopNewsGroupRubric' => array(
        'title' => array(
            'ru' => 'Статьи (поиск) группированные по рубрикам'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_New',
        'function' => 'findShopNewsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Статьи',
            ),
            'params' => getTableObjectParams(),
            'fields' => getTableObjectFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopNewFiles,
    ),

    'DB_Shop_Table_Hashtag_findOne' => array(
        'title' => array(
            'ru' => 'Хэштег статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Hashtag',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Hashtag_findAll' => array(
        'title' => array(
            'ru' => 'Хэштеги статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Hashtag',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Hashtag_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Hashtag',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_New_findBranchShopNewsByHashtag' => array(
        'title' => array(
            'ru' => 'Статьи филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'findBranchShopNewsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopNewFiles,
    ),

    'DB_Shop_Table_Filter_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Filter',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Filter_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Filter',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Filter_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Filter',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Table_Child_getShopTableChild' => array(
        'title' => array(
            'ru' => 'Подстатья (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Child',
        'function' => 'getShopTableChild',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Child_getShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подстатьи (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Child',
        'function' => 'getShopTableChilds',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Child_findShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подстатьи (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Child',
        'function' => 'findShopTableChilds',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Table_Brand_findOne' => array(
        'title' => array(
            'ru' => 'Бренд (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Brand',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'View_Shop_New_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Brand',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Brand_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Brand',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Table_Select_findOne' => array(
        'title' => array(
            'ru' => 'Выделение статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Select',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Select_findAll' => array(
        'title' => array(
            'ru' => 'Выделения статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Select',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Select_find' => array(
        'title' => array(
            'ru' => 'Выделения статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Select',
        'function' => 'find',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'View_Shop_Table_Unit_findOne' => array(
        'title' => array(
            'ru' => 'Единица измерения статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Unit',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Unit_findAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Unit',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Table_Unit_find' => array(
        'title' => array(
            'ru' => 'Единицы измерений статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Unit',
        'function' => 'find',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_New_getCountShopNewsCreatedAtYear' => array(
        'title' => array(
            'ru' => 'Статьи (количество сгруппированные по году)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'getCountShopNewsCreatedAtYear',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
    'DB_Shop_New_getCountShopNewsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Статьи (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_New',
        'function' => 'getCountShopNewsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// фотогалереи
$shopGallery = array(
    'DB_Shop_Gallery_getShopGallery' => array(
        'title' => array(
            'ru' => 'Фотогалерея (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopGallery',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopGalleryFiles,
    ),
    'DB_Shop_Gallery_findShopGalleries' => array(
        'title' => array(
            'ru' => 'Фотогалереи (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopGalleries',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopGalleryFiles,
    ),
    'DB_Shop_Gallery_findBranchShopGalleries' => array(
        'title' => array(
            'ru' => 'Фотогалереи филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findBranchShopGalleries',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopGalleryFiles,
    ),

    'DB_Shop_Gallery_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Gallery_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopTableRubrics',
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Gallery_findShopGalleriesGroupRubric' => array(
        'title' => array(
            'ru' => 'Фотогалереи (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopGalleriesGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Фотогалереи',
            ),
            'params' => getTableObjectParams(),
            'fields' => getTableObjectFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopGalleryFiles,
    ),

    'DB_Shop_Gallery_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopTableHashtags',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findBranchShopGalleriesByHashtag' => array(
        'title' => array(
            'ru' => 'Фотогалереи филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findBranchShopGalleriesByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopGalleryFiles,
    ),

    'DB_Shop_Gallery_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр фотогалерей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Gallery_getShopTableChild' => array(
        'title' => array(
            'ru' => 'Подгалерея (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableChild',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_getShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подгалереи (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableChilds',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подгалереи (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopTableChilds',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Gallery_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Gallery_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение фотогалерей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Gallery_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Unit_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений фотогалерей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Unit',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Unit_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений фотогалерей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Unit',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Gallery_getCountShopGalleriesCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Фотогалереи (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Gallery',
        'function' => 'getCountShopGalleriesCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// вопросы / ответы
$shopQuestion = array(
    'DB_Shop_Question_findOne' => array(
        'title' => array(
            'ru' => 'Вопрос / ответ (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getQuestionFields(),
        'files' => $shopQuestionFiles,
    ),
    'DB_Shop_Question_findAll' => array(
        'title' => array(
            'ru' => 'Вопросы / ответы (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findAll',
        'params' => getTableObjectParams(),
        'fields' => getQuestionFields(),
        'files' => $shopQuestionFiles,
    ),
    'DB_Shop_Question_findBranch' => array(
        'title' => array(
            'ru' => 'Вопросы / ответы филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getQuestionFields(),
        'files' => $shopQuestionFiles,
    ),

    'DB_Shop_Question_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Question_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Question',
        'function' => 'findShopTableRubrics',
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Question_findShopQuestionsGroupRubric' => array(
        'title' => array(
            'ru' => 'Вопросы / ответы (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Question',
        'function' => 'findShopQuestionsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Вопросы / ответы',
            ),
            'params' => getTableObjectParams(),
            'fields' => getQuestionFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopQuestionFiles,
    ),

    'DB_Shop_Question_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findShopTableHashtags',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findBranchShopQuestionsByHashtag' => array(
        'title' => array(
            'ru' => 'Вопросы / ответы филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findBranchShopQuestionsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getQuestionFields(),
        'files' => $shopQuestionFiles,
    ),

    'DB_Shop_Question_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр вопросов / ответов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Question_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение вопросов / ответов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Question_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений вопросов / ответов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Question_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений вопросов / ответов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Question_getCountShopQuestionsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Вопросы / ответы (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Question',
        'function' => 'getCountShopQuestionsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// комментарии
$shopComment = array(
    'DB_Shop_Comment_findOne' => array(
        'title' => array(
            'ru' => 'Комментарий (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopCommentFiles,
    ),
    'DB_Shop_Comment_find' => array(
        'title' => array(
            'ru' => 'Комментарии (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopCommentFiles,
    ),
    'DB_Shop_Comment_findBranch' => array(
        'title' => array(
            'ru' => 'Комментарии филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopCommentFiles,
    ),

    'DB_Shop_Comment_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики комментарий (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Comment_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Comment',
        'function' => 'findShopTableRubrics',
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Comment_findShopCommentsGroupRubric' => array(
        'title' => array(
            'ru' => 'Комментарии (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Comment',
        'function' => 'findShopCommentsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Комментарии',
            ),
            'params' => getTableObjectParams(),
            'fields' => getTableObjectFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopCommentFiles,
    ),

    'DB_Shop_Comment_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги комментарий (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findShopTableHashtags',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findBranchShopCommentsByHashtag' => array(
        'title' => array(
            'ru' => 'Комментарии филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findBranchShopCommentsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopCommentFiles,
    ),

    'DB_Shop_Comment_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр комментарий (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры комментарий (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Comment_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды комментарий (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Comment_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение комментарий (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения комментарий (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Comment_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений комментарий (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Comment_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений комментарий (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'View_Shop_Comment_getCountShopCommentsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Комментарии (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Comment',
        'function' => 'getCountShopCommentsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// товары
$shopGood = array(
    'DB_Shop_Good_findOne' => array(
        'title' => array(
            'ru' => 'Товар (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),
    'DB_Shop_Good_find' => array(
        'title' => array(
            'ru' => 'Товары (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),
    'DB_Shop_Good_findBranch' => array(
        'title' => array(
            'ru' => 'Товары филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),
    'DB_Shop_Good_findRubricsByDBObject' => array(
        'title' => array(
            'ru' => 'Товары (поиск) и возвращаем список рубрик найденных товаров'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findRubricsByDBObject',
        'params' => getTableObjectParams(),
        'fields' => getTableRubricFields(),
    ),

    'DB_Shop_Good_findRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики товаров (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findRubrics',
        'params' => getTableObjectParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Good_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики товаров (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableRubrics',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Good_findDBObjectGroupRubrics' => array(
        'title' => array(
            'ru' => 'Товары (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findDBObjectGroupRubrics',
        'groups' => array(
            'title' => array(
                'ru' => 'Товары',
            ),
            'params' => getTableObjectParams(),
            'fields' => getGoodFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopGoodFiles,
    ),

    'DB_Shop_Good_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги товаров (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги товаров (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findBranchShopGoodsByHashtag' => array(
        'title' => array(
            'ru' => 'Товары филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findBranchShopGoodsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),

    'DB_Shop_Good_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Good_getShopTableChild' => array(
        'title' => array(
            'ru' => 'Подтовар (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableChild',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_getShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подтовары (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableChilds',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подтовары (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableChilds',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Good_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды товаров (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды товаров (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Good_findShopTableBrandsWithRubrics' => array(
        'title' => array(
            'ru' => 'Бренды товаров с детворой (рубрики) (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableBrandsWithRubrics',
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрики товаров',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Good_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение товаров (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения товаров (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения товаров (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Good_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений товаров (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений товаров (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Good_getCountShopGoods' => array(
        'title' => array(
            'ru' => 'Товары (количество)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getCountShopGoods',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
    'DB_Shop_Good_findAllWithChildTwoLevel' => array(
        'title' => array(
            'ru' => 'Рубрики товаров с детворой (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findAllWithChildTwoLevel',
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрика товаров',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Good_findWithChildTreeLevel' => array(
        'title' => array(
            'ru' => 'Рубрики товаров с детворой, три уровня (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findWithChildTreeLevel',
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрика товаров',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Good_findRubricsWithDBObjects' => array(
        'title' => array(
            'ru' => 'Рубрики товаров с товарами (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'findRubricsWithDBObjects',
        'groups' => array(
            'title' => array(
                'ru' => 'Товары',
            ),
            'params' => getTableObjectParams(),
            'fields' => getGoodFields(),
            'files' => $shopGoodFiles,
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Good_getHashtagsByDBObject' => array(
        'title' => array(
            'ru' => 'Хэштеги заданного товара (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Good',
        'function' => 'getHashtagsByDBObject',
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
);
// машины
$shopCar = array(
    'DB_Shop_Car_findOne' => array(
        'title' => array(
            'ru' => 'Машина (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getCarFields(),
        'files' => $shopCarFiles,
    ),
    'DB_Shop_Car_find' => array(
        'title' => array(
            'ru' => 'Машины (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'find',
        'params' => getCarParams(),
        'fields' => getCarFields(),
        'files' => $shopCarFiles,
    ),
    'DB_Shop_Car_findBranch' => array(
        'title' => array(
            'ru' => 'Машины филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getCarFields(),
        'files' => $shopCarFiles,
    ),

    'DB_Shop_Car_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики машин (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Car_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики машин (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableRubrics',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Car_findGroupRubric' => array(
        'title' => array(
            'ru' => 'Машины (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Car',
        'function' => 'findGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Машины',
            ),
            'params' => getTableObjectParams(),
            'fields' => getCarFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopCarFiles,
    ),

    'DB_Shop_Car_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги машин (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги машин (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findBranchByHashtag' => array(
        'title' => array(
            'ru' => 'Машины филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findBranchByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getCarFields(),
        'files' => $shopCarFiles,
    ),

    'DB_Shop_Car_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр статей (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры статей (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Car_getShopTableChild' => array(
        'title' => array(
            'ru' => 'Подмашины (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableChild',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_getShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подмашины (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableChilds',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подмашины (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableChilds',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Car_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды машин (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды машин (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Car_findShopTableBrandsWithRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики машин с детворой (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableBrandsWithRubrics',
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрики машин',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Car_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение машин (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения машин (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения машин (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Car_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений машин (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений машин (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Car_getCountShopCarsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Машины (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getCountShopCarsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
    'DB_Shop_Car_getCountShopCars' => array(
        'title' => array(
            'ru' => 'Машины (количество)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getCountShopCars',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
    'DB_Shop_Car_findAllWithChildTwoLevel' => array(
        'title' => array(
            'ru' => 'Рубрики машин с детворой (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findAllWithChildTwoLevel',
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрика машин',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Car_findShopTableRubricsWithCars' => array(
        'title' => array(
            'ru' => 'Рубрики машин с машинами (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'findShopTableRubricsWithCars',
        'groups' => array(
            'title' => array(
                'ru' => 'Машины',
            ),
            'params' => getTableObjectParams(),
            'fields' => getCarFields(),
            'files' => $shopCarFiles,
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Car_getShopTableHashtagsByCar' => array(
        'title' => array(
            'ru' => 'Хэштеги заданной машины (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Car',
        'function' => 'getShopTableHashtagsByCar',
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
);
// операторы
$shopOperation = array(
    'DB_Shop_Operation_findOne' => array(
        'title' => array(
            'ru' => 'Оператор (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopOperationFiles,
    ),
    'DB_Shop_Operation_find' => array(
        'title' => array(
            'ru' => 'Операторы (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopOperationFiles,
    ),
    'DB_Shop_Operation_findBranch' => array(
        'title' => array(
            'ru' => 'Операторы филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findBranch',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopOperationFiles,
    ),

    'DB_Shop_Operation_findAll' => array(
        'title' => array(
            'ru' => 'Рубрики операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Operation_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Operation',
        'function' => 'findShopTableRubrics',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Operation_findShopOperationsGroupRubric' => array(
        'title' => array(
            'ru' => 'Операторы (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Operation',
        'function' => 'findShopOperationsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Операторы',
            ),
            'params' => getTableObjectParams(),
            'fields' => getTableObjectFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopOperationFiles,
    ),

    'DB_Shop_Operation_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findBranchShopOperationsByHashtag' => array(
        'title' => array(
            'ru' => 'Операторы филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findBranchShopOperationsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopOperationFiles,
    ),

    'DB_Shop_Operation_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр операторов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),


    'DB_Shop_Operation_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Operation_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение операторов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Operation_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений операторов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Operation_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений операторов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Operation_getCountShopOperationsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Операторы (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Operation',
        'function' => 'getCountShopOperationsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'operations_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'operations_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'operations_count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// филиалы
$shopBranch = array(
    'DB_Shop_getShop' => array(
        'title' => array(
            'ru' => 'Филиал (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShop',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopBranchFiles,
    ),
    'DB_Shop_findOne' => array(
        'title' => array(
            'ru' => 'Филиал (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getTableObjectFields(),
        'files' => $shopBranchFiles,
    ),
    'DB_Shop_find' => array(
        'title' => array(
            'ru' => 'Филиалы (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopBranchFiles,
    ),
    'DB_Shop_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики филиалов (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop',
        'function' => 'findShopTableRubrics',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_findShopBranchsGroupRubric' => array(
        'title' => array(
            'ru' => 'Филиалы (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findShopBranchsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'Филиалы',
            ),
            'params' => getTableObjectParams(),
            'fields' => getTableObjectFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopBranchFiles,
    ),

    'DB_Shop_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги филиалов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр филиалов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры филиалов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды филиалов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение филиалов (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения филиалов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений филиалов (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_getCountShopBranchsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'Филиалы (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'getCountShopBranchsCreatedAtYearMonth',
        'params' => getTableObjectParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
    'DB_Shop_findShopBranchsWithTableRubrics' => array(
        'title' => array(
            'ru' => 'Филиалы (с рубриками детворы)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop',
        'function' => 'findShopBranchsWithTableRubrics',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'files' => $shopBranchFiles,
        'groups' => array(
            'title' => array(
                'ru' => 'Рубрики',
            ),
            'params' => getTableRubricParams(),
            'fields' => getTableRubricFields(),
        ),
    ),
);
// языки магазина
$shopLanguage = array(
    'DB_Language_findAll' => array(
        'title' => array(
            'ru' => 'Языки магазина (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Language',
        'function' => 'findAll',
        'params' => array(),
        'fields' => getLanguageObjectFields(),
    ),
);
// контакты
$shopAddressContact = array(
    'DB_Shop_AddressContact_find' => array(
        'title' => array(
            'ru' => 'Контакты (поиск)'
        ),
        'class' => 'View_Shop_AddressContact',
        'table' => DB_Shop_AddressContact::NAME,
        'function' => 'find',
        'params' => getShopAddressContactParams(),
        'fields' => getShopAddressContactFields(),
    ),
    'DB_Shop_AddressContact_getShopAddressContacts' => array(
        'title' => array(
            'ru' => 'Контакты (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => DB_Shop_AddressContact::NAME,
        'function' => 'findAll',
        'params' => array(),
        'fields' => getShopAddressContactFields(),
    ),
);
// календарь
$shopCalendar = array(
    'DB_Shop_Calendar_findOne' => array(
        'title' => array(
            'ru' => 'Событие календаря (одно)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findOne',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getShopCalendarFields(),
        'files' => $shopCalendarFiles,
    ),
    'DB_Shop_Calendar_find' => array(
        'title' => array(
            'ru' => 'События календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'find',
        'params' => getShopCalendarParams(),
        'fields' => getShopCalendarFields(),
        'files' => $shopCalendarFiles,
    ),
    'DB_Shop_Calendar_findBranch' => array(
        'title' => array(
            'ru' => 'События календаря филиалов (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findBranch',
        'params' => getShopCalendarParams(),
        'fields' => getShopCalendarFields(),
        'files' => $shopCalendarFiles,
    ),

    'DB_Shop_Calendar_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableRubrics',
        'params' => array(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Calendar_findShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_Rubric',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopTableRubrics',
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
    ),
    'DB_Shop_Calendar_findShopCalendarsGroupRubric' => array(
        'title' => array(
            'ru' => 'События календаря (поиск) группированные по рубриками'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopCalendarsGroupRubric',
        'groups' => array(
            'title' => array(
                'ru' => 'События календаря',
            ),
            'params' => getShopCalendarParams(),
            'fields' => getShopCalendarFields(),
        ),
        'params' => getTableRubricParams(),
        'fields' => getTableRubricFields(),
        'files' => $shopCalendarFiles,
    ),

    'DB_Shop_Calendar_getShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштеги событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableHashtags',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findShopTableHashtags' => array(
        'title' => array(
            'ru' => 'Хэштег событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopTableHashtags',
        'params' => getTableHashtagParams(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findBranchShopCalendarsByHashtag' => array(
        'title' => array(
            'ru' => 'События календаря филиалов (поиск по хэштегу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findBranchShopCalendarsByHashtag',
        'groups' => array(
            'title' => array(
                'ru' => 'Хэштеги',
            ),
            'params' => getObjectParams(),
            'fields' => array(),
        ),
        'params' => getShopCalendarParams(),
        'fields' => getShopCalendarFields(),
        'files' => $shopCalendarFiles,
    ),

    'DB_Shop_Calendar_getShopTableFilter' => array(
        'title' => array(
            'ru' => 'Фильтр событий календаря (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableFilter',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_getShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableFilters',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findShopTableFilters' => array(
        'title' => array(
            'ru' => 'Фильтры событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopTableFilters',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Calendar_getShopTableChild' => array(
        'title' => array(
            'ru' => 'Подсобытия календаря (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableChild',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_getShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подсобытия календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableChilds',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findShopTableChilds' => array(
        'title' => array(
            'ru' => 'Подсобытия календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopTableChilds',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Calendar_findBrandAll' => array(
        'title' => array(
            'ru' => 'Бренды событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findBrandAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findBrands' => array(
        'title' => array(
            'ru' => 'Бренды событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findBrands',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Calendar_getShopTableSelect' => array(
        'title' => array(
            'ru' => 'Выделение событий календаря (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableSelect',
        'is_one' => true,
        'params' => getTableObjectParam(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_getShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getShopTableSelects',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findShopTableSelects' => array(
        'title' => array(
            'ru' => 'Выделения событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findShopTableSelects',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Calendar_findUnitAll' => array(
        'title' => array(
            'ru' => 'Единицы измерений событий календаря (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findUnitAll',
        'params' => array(),
        'fields' => getObjectFields(),
    ),
    'DB_Shop_Calendar_findUnits' => array(
        'title' => array(
            'ru' => 'Единицы измерений событий календаря (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'findUnits',
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),

    'DB_Shop_Calendar_getCountShopCalendarsCreatedAtYearMonth' => array(
        'title' => array(
            'ru' => 'События календаря (количество сгруппированные по году и месяцу)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Calendar',
        'function' => 'getCountShopCalendarsCreatedAtYearMonth',
        'params' => getShopCalendarParams(),
        'fields' => array(
            array(
                'name' => 'created_at_year',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Год',
                ),
            ),
            array(
                'name' => 'created_at_month',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Месяц',
                ),
            ),
            array(
                'name' => 'count',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Количество',
                ),
            ),
        ),
    ),
);
// адрес
$shopAddress = array(
    'DB_Shop_Address_find' => array(
        'title' => array(
            'ru' => 'Адреса (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Address',
        'function' => 'find',
        'params' => getShopAddressParams(),
        'fields' => getShopAddressFields(),
    ),
    'DB_Shop_Address_findOne' => array(
        'title' => array(
            'ru' => 'Адрес (магазина)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Address',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(),
        'fields' => getShopAddressFields(),
    ),
    'DB_Shop_Address_getMainShopAddress' => array(
        'title' => array(
            'ru' => 'Основной адрес (магазина)'
        ),
        'class' => 'View_Shop_Address',
        'table' => 'DB_Shop_Address',
        'function' => 'getMainShopAddress',
        'is_one' => TRUE,
        'params' => array(),
        'fields' => getShopAddressFields(),
    ),


    'DB_Shop_Address_findShopAddressWithContacts' => array(
        'title' => array(
            'ru' => 'Адреса с контактами (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Address',
        'function' => 'findShopAddressWithContacts',
        'groups' => array(
            'title' => array(
                'ru' => 'Контакты',
            ),
            'params' => getShopAddressContactParams(),
            'fields' => getShopAddressContactFields(),
        ),
        'params' => getShopAddressParams(),
        'fields' => getShopAddressFields(),
    ),
);
// заказы
$shopBill = array(
    'DB_Shop_Bill_findOne' => array(
        'title' => array(
            'ru' => 'Заказ (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Bill',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(
            array(
                'name' => 'id',
                'title' => array(
                    'ru' => 'Заказ (id)',
                ),
            ),
            array(
                'name' => Request_RequestParams::IS_NOT_READ_REQUEST_NAME,
                'title' => array(
                    'ru' => 'Не считывать параметры в URL (0 или 1)',
                ),
            ),
            array(
                'name' => 'is_error_404',
                'title' => array(
                    'ru' => 'Выводить 404 ошибку (0 или 1)',
                ),
            ),
            array(
                'name' => 'is_branch',
                'title' => array(
                    'ru' => 'Считывать данные филиала (0 или 1)',
                ),
            ),
            array(
                'name' => 'shop_branch_id',
                'title' => array(
                    'ru' => 'Филиал (id)',
                ),
            ),
        ),
        'fields' => array(
            array(
                'name' => 'id',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'bill_number',
                'title' => array(
                    'ru' => 'Номер заказа',
                ),
            ),
            array(
                'name' => 'amount',
                'title' => array(
                    'ru' => 'Стоимость',
                ),
            ),
            array(
                'name' => 'delivery_amount',
                'title' => array(
                    'ru' => 'Стоимость доставки',
                ),
            ),
            array(
                'name' => 'shop_paid_type_id',
                'title' => array(
                    'ru' => 'Оплата (id)',
                ),
            ),
            array(
                'name' => 'shop_delivery_type_id',
                'title' => array(
                    'ru' => 'Доставка (id)',
                ),
            ),
            array(
                'name' => 'bill_status_id',
                'title' => array(
                    'ru' => 'Cтатус (id)',
                ),
            ),
            array(
                'name' => 'country_id',
                'title' => array(
                    'ru' => 'Страна (id)',
                ),
            ),
            array(
                'name' => 'city_id',
                'title' => array(
                    'ru' => 'Город (id)',
                ),
            ),
            array(
                'name' => 'discount',
                'title' => array(
                    'ru' => 'Скидка',
                ),
            ),
            array(
                'name' => 'is_percent',
                'title' => array(
                    'ru' => 'Скидка в (0 - процент, 1 - в деньгах)',
                ),
            ),
            array(
                'name' => 'shop_coupon_id',
                'title' => array(
                    'ru' => 'Купон (id)',
                ),
            ),

            array(
                'name' => 'cancel_message',
                'title' => array(
                    'ru' => 'Причина отказа',
                ),
            ),
            array(
                'name' => 'client_comment',
                'title' => array(
                    'ru' => 'Комментарий клиента',
                ),
            ),
            array(
                'name' => 'shop_comment',
                'title' => array(
                    'ru' => 'Комментарий магазина',
                ),
            ),
            array(
                'name' => 'is_paid',
                'title' => array(
                    'ru' => 'Оплачен ли (0 или 1)',
                ),
            ),
            array(
                'name' => 'paid_at',
                'title' => array(
                    'ru' => 'Дата оплаты',
                ),
            ),

            array(
                'name' => 'is_delivery',
                'title' => array(
                    'ru' => 'Доставлен ли (0 или 1)',
                ),
            ),
            array(
                'name' => 'delivery_at',
                'title' => array(
                    'ru' => 'Время доставки (фактическое)',
                ),
            ),

            array(
                'name' => 'client_delivery_date',
                'title' => array(
                    'ru' => 'Время доставки (клиентом)',
                ),
            ),
            array(
                'name' => 'client_delivery_time_from',
                'title' => array(
                    'ru' => 'Период доставки (время от)',
                ),
            ),
            array(
                'name' => 'client_delivery_time_to',
                'title' => array(
                    'ru' => 'Период доставки (время до)',
                ),
            ),
            array(
                'name' => 'receiver_name',
                'title' => array(
                    'ru' => 'ФИО получателя',
                ),
            ),
            array(
                'name' => 'receiver_data',
                'title' => array(
                    'ru' => 'Данные получателя (массив)',
                ),
                'is_array' => TRUE,
            ),
            array(
                'name' => 'sender_data',
                'title' => array(
                    'ru' => 'Данные отправителя (массив)',
                ),
            ),
            array(
                'name' => 'data',
                'title' => array(
                    'ru' => 'Дополнительный данные (массив)',
                ),
            ),
            array(
                'name' => 'create_user_id',
                'title' => array(
                    'ru' => 'Кто создал? (id)',
                ),
            ),
            array(
                'name' => 'created_at',
                'title' => array(
                    'ru' => 'Дата создания',
                ),
            ),
            array(
                'name' => 'is_bill_shop',
                'title' => array(
                    'ru' => 'Заказ магазина (0 или 1)',
                ),
            ),
            array(
                'name' => 'shop_id',
                'title' => array(
                    'ru' => 'Магазин (id)',
                ),
            ),

            array(
                'name' => 'update_user_id',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        ),
    ),
    'DB_Hotel_Shop_Bill_findOne' => array(
        'title' => array(
            'ru' => 'Заказ отеля (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Hotel_Shop_Bill',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(),
        'fields' => array(),
    ),
);
// пользователи
$user = array(
    'DB_User_getUserCurrent' => array(
        'title' => array(
            'ru' => 'Пользователь (авторизированный)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_User',
        'function' => 'getUserCurrent',
        'is_one' => true,
        'params' => array(
            array(
                'name' => 'is_error_404',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Выводить 404 ошибку (0 или 1)',
                ),
            ),
        ),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Имя (ФИО)',
                ),
            ),
            array(
                'name' => 'email',
                'type' => 'string',
                'title' => array(
                    'ru' => 'E-mail',
                ),
            ),
            array(
                'name' => 'options',
                'type' => 'array',
                'title' => array(
                    'ru' => 'Дополнительные поля',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
);
// корзина
$shopCart = array(
    'DB_Shop_Good_getCartShopGoods' => array(
        'title' => array(
            'ru' => 'Товары (в корзине)'
        ),
        'class' => 'View_Shop_Cart',
        'table' => 'DB_Shop_Good',
        'function' => 'getCartShopGoods',
        'params' => getTableObjectParams(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),
);
// избранное
$shopFavorite = array(
    'DB_Shop_Good_getShopGoods' => array(
        'title' => array(
            'ru' => 'Товары (в избранном)'
        ),
        'class' => 'View_Favorite',
        'table' => 'DB_Shop_Good',
        'function' => 'getShopGoods',
        'params' => getTableObjectParams(),
        'fields' => getGoodFields(),
        'files' => $shopGoodFiles,
    ),
);
// рубрики
$shopTableRubric = array(
    'DB_Shop_Table_Rubric_findBreadCrumbs' => array(
        'title' => array(
            'ru' => 'Хлебные крошки для рубрики (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Table_Rubric',
        'function' => 'findBreadCrumbs',
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
);
// единицы измерения
$shopTableUnit = array(
    'View_Shop_Table_Unit_findShopTableHashtagsWithUnits' => array(
        'title' => array(
            'ru' => 'Хэштеги единиц изменения с единицами измерения (поиск)'
        ),
        'class' => 'View_Shop_Table_Unit',
        'function' => 'findShopTableHashtagsWithUnits',
        'groups' => array(
            'title' => array(
                'ru' => 'Единицы измерения',
            ),
            'params' => getObjectParams(),
            'fields' => getObjectFields(),
            'files' => array(),
        ),
        'params' => getObjectParams(),
        'fields' => getObjectFields(),
    ),
);
// параметры
$shopTableParam = array(
    'View_Shop_Table_Param_findShopTableParams' => array(
        'title' => array(
            'ru' => 'Параметры (поиск)'
        ),
        'class' => 'View_Shop_Table_Param',
        'function' => 'findShopTableParams',
        'params' => getTableParams(),
        'fields' => getTableRubricFields(),
    ),
);
// марки
$shopMark = array(
    'DB_Shop_Mark_find' => array(
        'title' => array(
            'ru' => 'Марки (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Mark',
        'function' => 'find',
        'params' => getTableObjectParams(),
        'fields' => getTableRubricFields(),
    ),
);
// модели
$shopModel = array(
    'DB_Shop_Model_find' => array(
        'title' => array(
            'ru' => 'Модели (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Shop_Model',
        'function' => 'find',
        'params' => getTableObjectParam(),
        'fields' => getTableRubricFields(),
    ),
);
// города
$city = array(
    'DB_City_findAll' => array(
        'title' => array(
            'ru' => 'Города (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_City',
        'function' => 'findAll',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликован?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_City_getShopCities' => array(
        'title' => array(
            'ru' => 'Города магазина (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_City',
        'function' => 'getShopCities',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликован?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_City_findOne' => array(
        'title' => array(
            'ru' => 'Город (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_City',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Город (id)',
                ),
            ),
            array(
                'name' => Request_RequestParams::IS_NOT_READ_REQUEST_NAME,
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Не считывать параметры в URL (0 или 1)',
                ),
            ),
            array(
                'name' => 'is_error_404',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Выводить 404 ошибку (0 или 1)',
                ),
            ),
        ),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
);
// страны
$land = array(
    'DB_Land_findAll' => array(
        'title' => array(
            'ru' => 'Страны (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Land',
        'function' => 'findAll',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликован?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_Land_getShopLands' => array(
        'title' => array(
            'ru' => 'Страны магазина (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Land',
        'function' => 'getShopLands',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликован?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_Land_findOne' => array(
        'title' => array(
            'ru' => 'Страна (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Land',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Город (id)',
                ),
            ),
            array(
                'name' => Request_RequestParams::IS_NOT_READ_REQUEST_NAME,
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Не считывать параметры в URL (0 или 1)',
                ),
            ),
            array(
                'name' => 'is_error_404',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Выводить 404 ошибку (0 или 1)',
                ),
            ),
        ),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Опубликован?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
);
// валюты
$currency = array(
    'DB_Currency_findAll' => array(
        'title' => array(
            'ru' => 'Валюты (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Currency',
        'function' => 'findAll',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_Currency_getShopCurrencies' => array(
        'title' => array(
            'ru' => 'Валюты магазина (все)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Currency',
        'function' => 'getShopCurrencies',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_Currency_find' => array(
        'title' => array(
            'ru' => 'Валюты (поиск)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Currency',
        'function' => 'find',
        'params' => array(),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'bollean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
    'DB_Currency_findOne' => array(
        'title' => array(
            'ru' => 'Валюта (одна)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Currency',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Город (id)',
                ),
            ),
            array(
                'name' => Request_RequestParams::IS_NOT_READ_REQUEST_NAME,
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Не считывать параметры в URL (0 или 1)',
                ),
            ),
            array(
                'name' => 'is_error_404',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Выводить 404 ошибку (0 или 1)',
                ),
            ),
        ),
        'fields' => array(
            array(
                'name' => 'id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'id',
                ),
            ),
            array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Название',
                ),
            ),
            array(
                'name' => 'is_public',
                'type' => 'boolean',
                'title' => array(
                    'ru' => 'Опубликована?',
                ),
            ),
            array(
                'name' => 'update_user_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Кто отредактировал?',
                ),
            ),
            array(
                'name' => 'updated_at',
                'type' => 'datetime',
                'title' => array(
                    'ru' => 'Дата обновления',
                ),
            ),
        )
    ),
);

// данные Ads
$ads = array(
    'View_Ads_Shop_Client_getShopClientAuthUser' => array(
        'title' => array(
            'ru' => 'Клиент Ads (авторизованный)'
        ),
        'class' => 'View_Ads_Shop_Client',
        'function' => 'getShopClientAuthUser',
        'is_one' => TRUE,
        'params' => array(),
        'fields' => array(),
    ),
    'View_Ads_Shop_Parcel_findShopParcelsAuthUser' => array(
        'title' => array(
            'ru' => 'Посылки Ads авторизированного пользователи (поиск)'
        ),
        'class' => 'View_Ads_Shop_Parcel',
        'function' => 'findShopParcelsAuthUser',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'fields' => array(),
    ),
    'View_Ads_Shop_Invoice_findAuthUser' => array(
        'title' => array(
            'ru' => 'Счета Ads авторизированного пользователи (поиск)'
        ),
        'class' => 'View_Ads_Shop_Invoice',
        'function' => 'findAuthUser',
        'params' => getTableObjectParams(),
        'fields' => getTableObjectFields(),
        'fields' => array(),
    ),
);

// отель
$hotel = array(
    'DB_Hotel_Shop_Client_findOne' => array(
        'title' => array(
            'ru' => 'Клиент отеля (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Hotel_Shop_Client',
        'function' => 'findOne',
        'is_one' => TRUE,
        'params' => array(),
        'fields' => array(),
    ),
    'DB_Hotel_Shop_Client_find' => array(
        'title' => array(
            'ru' => 'Клиент отеля (один)'
        ),
        'class' => 'View_Shop_Table_View',
        'table' => 'DB_Hotel_Shop_Client',
        'function' => 'find',
        'params' => array(),
        'fields' => array(),
    ),
);

return array_merge($hotel, $ads,
    $currency, $city, $land, $user, $shopCart, $shopFavorite,
    $shopTableRubric, $shopTableParam, $shopTableUnit,
    $shopCar, $shopMark, $shopModel,
    $shopBill, $shopCalendar, $shopLanguage, $shopBranch, $shopNew, $shopGood,
    $shopGallery, $shopQuestion, $shopComment, $shopAddressContact, $shopAddress, $shopOperation);