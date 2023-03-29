<?php defined('SYSPATH') or die('No direct script access.');

class GlobalData{
    /** @var null | SitePageData */
    static $siteData = null;

    public static function newSitePageData($isAddGlobal = true){
        $result = new SitePageData();
        if($isAddGlobal){
            self::$siteData = $result;
        }

        return $result;
    }

    const DB_TYPE = 'pgsql';
   // const DB_TYPE = 'mysql';
	
	public static function newModelDriverDBSQL(){
        switch (self::DB_TYPE) {
            case 'pgsql':
                return new Model_Driver_PgSQL_DBPgSQLSQL();
                break;
            case 'mysql':
                return new Model_Driver_MySQL_DBMySQLSQL();
                break;
        }
        return FALSE;
	}

    public static function newModelDriverDBSQLMem(){
        switch (self::DB_TYPE) {
            case 'pgsql':
                return new Model_Driver_MemPgSQL_DBMemPgSQLDriver();
                break;
            case 'mysql':
                return new Model_Driver_MemMySQL_DBMemMySQLDriver();
                break;
        }
        return FALSE;
    }
}