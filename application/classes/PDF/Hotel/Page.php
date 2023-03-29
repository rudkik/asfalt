<?php defined('SYSPATH') or die('No direct script access.');

class PDF_Hotel_Page extends PDF_Page
{
    public $footerHtml = '';
    public $headerHtml = '';

    function __construct($title, $author = 'Er2003')
    {
        parent::__construct($title, $author, FALSE);

        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP - 5, PDF_MARGIN_RIGHT);
    }

    function setHeaderTitle($title)
    {
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->setHeaderFont(Array('BookAntiquaB', '', 9));
        $this->setHeaderData('', 0, '', $title);
    }

    /**
     * This method is used to render the page header.
     * It is automatically called by AddPage() and could be overwritten in your own inherited class.
     * @public
     */
    public function Header() {
        if ($this->header_xobjid === false) {
            // start a new XObject Template
            $this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
            $headerfont = $this->getHeaderFont();
            $headerdata = $this->getHeaderData();
            $this->y = $this->header_margin;
            if ($this->rtl) {
                $this->x = $this->w - $this->original_rMargin;
            } else {
                $this->x = $this->original_lMargin;
            }
            if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
                $imgtype = TCPDF_IMAGES::getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
                if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
                    $this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                } elseif ($imgtype == 'svg') {
                    $this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                } else {
                    $this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
                }
                $imgy = $this->getImageRBY();
            } else {
                $imgy = $this->y;
            }
            $cell_height = $this->getCellHeight($headerfont[2] / $this->k);
            // set starting margin for text data cell
            if ($this->getRTL()) {
                $header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
            } else {
                $header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
            }
            $cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
            $this->SetTextColorArray($this->header_text_color);
            // header title
            $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
            $this->SetX($header_x);
            $this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
            // header string
            $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
            $this->SetX($header_x);
            $this->MultiCell($cw, $cell_height, $headerdata['string'], 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
            // print an ending header line
            $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
            $this->endTemplate();
        }
        // print header template
        $x = 0;
        $dx = 0;
        if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
            // adjust margins for booklet mode
            $dx = ($this->original_lMargin - $this->original_rMargin);
        }
        if ($this->rtl) {
            $x = $this->w + $dx;
        } else {
            $x = 0 + $dx;
        }
        $this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
        if ($this->header_xobj_autoreset) {
            // reset header xobject template at each page
            $this->header_xobjid = false;
        }

        if(!empty($this->headerHtml)){
            $this->SetFont('BookAntiqua','',9);
            $this->SetY($this->tMargin - 18);
            $this->SetX($this->lMargin);
            $this->writeHTML($this->headerHtml, true, false, true, false, '');
        }
    }

    public function Footer() {
        $this->SetY(-15);
        $this->writeHTML($this->footerHtml, true, false, true, false, '');

       // $this->Cell(0, 10, $title, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function headerHTML($data) {
        $this->headerHtml = $data;
    }

    public function footerHtml($data) {
        $this->footerHtml = $data;
    }
}