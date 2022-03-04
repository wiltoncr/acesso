<?php
declare(strict_types = 1);

namespace App\Controllers;

use App\Helpers\AnydeskConfig;
use Core\Controller;

class AnydeskController extends Controller
{
    public function index() 
    {   
        $anydesk = new AnydeskConfig();
        $anydesk->getUserConfig();
    }

}
