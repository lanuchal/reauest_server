<?php 
// if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
// require_once 'dompdf/autoload.inc.php';

// use Dompdf\Dompdf;

// class Pdf extends Dompdf
// {
// 	public function __construct()
// 	{
// 		 parent::__construct();
// 	} 
// }

if (!defined('BASEPATH')) exit('No direct script access allowed');  
require_once APPPATH."/third_party/tcpdf/tcpdf.php";
class Pdf extends TCPDF 
{
    public function __construct() {
        parent::__construct();
    }
}

?>