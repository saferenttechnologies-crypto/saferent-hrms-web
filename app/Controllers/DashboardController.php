<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller; use App\Services\DashboardService;

final class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboard) {}
    public function index(): void { $this->view('dashboard/index', ['title'=>'Executive Dashboard','metrics'=>$this->dashboard->metrics()]); }
}
