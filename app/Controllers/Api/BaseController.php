<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use App\Traits\ApiResponseTrait;

class BaseController extends Controller
{
    use ApiResponseTrait;
    
    public function __construct()
    {
        // Initialization operations for API can be done here
    }
}
