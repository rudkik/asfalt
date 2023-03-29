<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Synchronization extends Controller_BasicControler
{
    /**
     * Синхронизация
     * @throws HTTP_Exception_500
     */
    public function action_sync() {
        $this->_sitePageData->url = '/ab1/synchronization/sync';

        $dateFrom = Request_Request::findOneNotShop(
            DB_Ab1_TableUpdateDate::NAME, $this->_sitePageData, $this->_driverDB
        );
        if($dateFrom != null){
            $dateFrom = $dateFrom->values['created_at'];
        }else{
            $dateFrom = '2020-01-01';
        }

        $dateTo = Helpers_DateTime::minusMinutes(date('Y-m-d H:i:s'), 1);

        $dbs = include Helpers_Path::getPathFile(APPPATH, ['config'], 'database_sync.php');

        $list = [];
        foreach ($dbs as $db){
            $query = Database::instance($db)->query(
                Database::SELECT,
                'SELECT "sql", "created_at" FROM "ab_table_updates" WHERE "created_at" > \'' . $dateFrom . '\' AND "created_at" <= \'' . $dateTo . '\' ORDER BY "created_at";'
            );

            $data = $query->as_array();
            foreach($data as $one){
                $list[] = $one;
            }
        }

        uasort($list, function ($x, $y) {
            return strcasecmp($x['created_at'], $y['created_at']);
        });

        $sql = 'BEGIN;' . "\r\n";
        foreach ($list as $one){
            $sql .= $one['sql'] . ";\r\n";
        }
        $sql .= 'DELETE FROM "ab_table_update_dates" WHERE "id" = 1;' . "\r\n";
        $sql .= 'INSERT INTO "ab_table_updates"("id", "update_user_id", "updated_at", "create_user_id", "created_at", "global_id") VALUES (1, :user, :date, :user, :date, 1);' . "\r\n";

        $sql .= 'COMMIT;';

        $query = DB::query(Database::UPDATE, $sql);
        $query->param(':date', $dateTo);
        $query->param(':user', GlobalData::$siteData->userID);

        try
        {
            $query->execute();
        }
        catch (Exception $e)
        {
            DB::query(Database::UPDATE, 'ROLLBACK')->execute();

            Helpers_File::saveInFile(
                APPPATH, ['logs', 'sync'],
                str_replace(':', '-', $dateTo) . '_' . rand(10000, 99999) .'.txt',
                $e->getMessage() . "\r\n\r\n" . $sql
            );

            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }

        $this->response->body('ok');
    }
}