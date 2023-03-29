<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Operation extends Model_Shop_Operation
{
    const RUBRIC_ADMIN = 1; // админы
    const RUBRIC_BOOKKEEPING = 2; // бухгалтера
    const RUBRIC_CLIENT = 3; // клиенты
}
