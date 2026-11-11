<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Response;
use App\Models\Category;

class CategoryController extends Controller
{
    public function apiList(): void
    {
        Response::success('OK', (new Category())->activas());
    }
}