<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Images extends Controller_BasicControler {

    public function action_process()
    {
        $id = $this->request->param('id');

        $m = strpos($id, '-');
        $n = -1;
        while ($m !== FALSE) {
            $n = $m + 1;
            $m = strpos($id, '-', $n);
        }

        if ($n < 0) {
            throw new HTTP_Exception_404('File is not found.');
        }
        $m = strpos($id, 'x', $n);
        if ($m < 0) {
            throw new HTTP_Exception_404('File is not found.');
        }

        $width = substr($id, $n, $m - $n);

        $height = substr($id, $m + 1);

        $id = substr($id, 0, $n - 1);

        $tmpFile = $this->request->param('table_id') . '/';
        if ($this->request->param('year') != '') {
            $tmpFile = $tmpFile . $this->request->param('year') . '/';
        }

        if ($this->request->param('month') != '') {
            $tmpFile = $tmpFile . $this->request->param('month') . '/';
        }

        if ($this->request->param('day') != '') {
            $tmpFile = $tmpFile . $this->request->param('day') . '/';
        }

        if ($this->request->param('tmp_id') != '') {
            $tmpFile = $tmpFile . $this->request->param('tmp_id') . '/';
        }

        if ($this->request->param('files') != '') {
            $tmpFile = $tmpFile . $this->request->param('files') . '/';
        }

        if ($this->request->param('index') != '') {
            $tmpFile = $tmpFile . $this->request->param('index') . '/';
        }

        $FileName = $tmpFile
            . $id . '.'
            . $this->request->param('ext');

        $FileNew = $tmpFile
            . $id . '-' . $width . 'x' . $height . '.'
            . $this->request->param('ext');


        if (file_exists(DOCROOT . 'img'. DIRECTORY_SEPARATOR . $FileName)) {
            $tmp = DOCROOT . 'img'. DIRECTORY_SEPARATOR . $FileName;
            $FileNew = DOCROOT . 'img'. DIRECTORY_SEPARATOR . $FileNew;
        } elseif (file_exists(DOCROOT . 'uploads'. DIRECTORY_SEPARATOR . $FileName)) {
            $tmp = DOCROOT . 'uploads'. DIRECTORY_SEPARATOR . $FileName;
            $FileNew = DOCROOT . 'uploads'. DIRECTORY_SEPARATOR . $FileNew;
        } elseif (file_exists(DOCROOT . 'css'. DIRECTORY_SEPARATOR . $FileName)) {
            $tmp = DOCROOT . 'css'. DIRECTORY_SEPARATOR . $FileName;
            $FileNew = DOCROOT . 'css'. DIRECTORY_SEPARATOR . $FileNew;
        } elseif (file_exists(DOCROOT . 'tmp_files'. DIRECTORY_SEPARATOR . $FileName)) {
            $tmp = DOCROOT . 'tmp_files'. DIRECTORY_SEPARATOR . $FileName;
            $FileNew = DOCROOT . 'tmp_files'. DIRECTORY_SEPARATOR . $FileNew;
        } elseif (file_exists(DOCROOT . 'files'. DIRECTORY_SEPARATOR . $FileName)) {
            $tmp = DOCROOT . 'files'. DIRECTORY_SEPARATOR . $FileName;
            $FileNew = DOCROOT . 'files'. DIRECTORY_SEPARATOR . $FileNew;
        } else {
            throw new HTTP_Exception_404('File is not found.');
        }

        $image = Image::factory($tmp, 'GD');
        try {
            if ($height < 1){
                $image->resize($width, NULL, Image::AUTO, TRUE)->save($FileNew, 100);
            }else{
                $image->resize($width, $height, Image::AUTO, TRUE)->save($FileNew, 100);
            }
        }catch(Exception $e){
            throw new HTTP_Exception_500($e->getMessage());
        }

        //перенести в view
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: image/jpeg');
        header('Content-Disposition: filename=' . basename($FileNew));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($FileNew));
        readfile($FileNew);
        exit;
    }
}
