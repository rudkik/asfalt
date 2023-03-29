<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Const  {

    /** минимальный расчетный показатель **/
    const MRP = array(
        2019 => 2525,
        2018 => 2405,
        2017 => 2269,
        2016 => 2121,
        2015 => 1982,
        2014 => 1852,
        2013 => 1731,
        2012 => 1618,
        2011 => 1512,
        2010 => 1413,
        2009 => 1273,
        2008 => 1168,
        2007 => 1092,
        2006 => 1030,
        2005 => 971,
        2004 => 919,
        2003 => 872,
        2002 => 823,
        2001 => 775,
        2000 => 725,
    );
    /** минимальная зарплата **/
    const MIN_WAGE = array(
        2019 => 42500,
        2018 => 28284,
        2017 => 24459,
        2016 => 22859,
        2015 => 21364,
        2014 => 19966,
        2013 => 18660,
        2012 => 17439,
        2011 => 15999,
        2010 => 14952,
        2009 => 13470,
        2008 => 10515,
        2007 => 9752,
        2006 => 9200,
        2005 => 7000,
        2004 => 6600,
        2003 => 5000,
        2002 => 4181,
        2001 => 3484,
        2000 => 2680,
    );
    /** максимальная зарплата для обязательных пенсионных отчислений **/
    const MAX_WAGE_FOR_OPV = array(
        2019 => 75,
        2018 => 75,
        2017 => 75,
        2016 => 75,
        2015 => 75,
        2014 => 75,
        2013 => 75,
        2012 => 75,
        2011 => 75,
        2010 => 75,
        2009 => 75,
        2008 => 75,
        2007 => 75,
        2006 => 75,
        2005 => 75,
        2004 => 75,
        2003 => 75,
        2002 => 75,
        2001 => 75,
        2000 => 75,
    );
    /** максимальная зарплата для социальных отчислений **/
    const MAX_WAGE_FOR_SO = array(
        2019 => 7,
        2018 => 10,
        2017 => 10,
        2016 => 10,
        2015 => 10,
        2014 => 10,
        2013 => 10,
        2012 => 10,
        2011 => 10,
        2010 => 10,
        2009 => 10,
        2008 => 10,
        2007 => 10,
        2006 => 10,
        2005 => 10,
        2004 => 10,
        2003 => 10,
        2002 => 10,
        2001 => 10,
        2000 => 10,
    );
    /** максимальная зарплата для ОСМС **/
    const MAX_WAGE_FOR_OSMS = array(
        2019 => 15,
        2018 => 15,
        2017 => 15,
        2016 => 15,
        2015 => 15,
        2014 => 15,
        2013 => 15,
        2012 => 15,
        2011 => 15,
        2010 => 15,
        2009 => 15,
        2008 => 15,
        2007 => 15,
        2006 => 15,
        2005 => 15,
        2004 => 15,
        2003 => 15,
        2002 => 15,
        2001 => 15,
        2000 => 15,
    );
    /** максимальная зарплата по больничному **/
    const MAX_WAGE_FOR_HOSPITAL = array(
        2019 => 15,
        2018 => 15,
        2017 => 15,
        2016 => 15,
        2015 => 15,
        2014 => 15,
        2013 => 15,
        2012 => 15,
        2011 => 15,
        2010 => 15,
        2009 => 15,
        2008 => 15,
        2007 => 15,
        2006 => 15,
        2005 => 15,
        2004 => 15,
        2003 => 15,
        2002 => 15,
        2001 => 15,
        2000 => 15,
    );

    /** минимальная зарплата по ИПН **/
    const MIN_WAGE_FOR_IPN = array(
        2019 => 25,
    );

    /**
     * Минимальная заработная плата по годам
     * @param $year
     * @return float
     */
    public static function getMinWage($year)
    {
        return self::MIN_WAGE[$year];
    }

    /**
     * Минимальный расчетный показатель по годам
     * @param $year
     * @return float
     */
    public static function getMRP($year)
    {
        return self::MRP[$year];
    }

    /**
     * Максимальная зарплата для обязательных пенсионных отчислений по годам
     * @param $year
     * @return float
     */
    public static function getMaxWageForOPV($year)
    {
        return self::MAX_WAGE_FOR_OPV[$year] * self::getMinWage($year);
    }

    /**
     * Максимальный налог для социальных отчислений по годам
     * @param $year
     * @return float
     */
    public static function getMaxWageForSO($year)
    {
        return self::MAX_WAGE_FOR_SO[$year] * self::getMinWage($year);
    }

    /**
     * Максимальная зарплата по больничному по годам
     * @param $year
     * @return float
     */
    public static function getMaxWageForOSMS($year)
    {
        return self::MAX_WAGE_FOR_OSMS[$year] * self::getMinWage($year);
    }

    /**
     * Максимальная зарплата для ОСМС по годам
     * @param $year
     * @return float
     */
    public static function getMaxWageForHospatal($year)
    {
        return self::MAX_WAGE_FOR_HOSPITAL[$year] * self::getMinWage($year);
    }

    /**
     * Минимальная зарплата для ИПН по годам
     * @param $year
     * @return float
     */
    public static function getMinWageForIPN($year)
    {
        if(key_exists($year, self::MIN_WAGE_FOR_IPN)){
            return self::MIN_WAGE_FOR_IPN[$year] * self::getMRP($year);
        }else{
            return 0;
        }

    }
}
