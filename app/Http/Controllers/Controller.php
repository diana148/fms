<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // <-- Ensure this alias

class Controller extends BaseController // <-- And this line!
{
    use AuthorizesRequests, ValidatesRequests;
}
