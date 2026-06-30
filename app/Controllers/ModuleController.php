<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
final class ModuleController extends Controller { public function index(): void { $this->view('modules/index', ['title'=>'Enterprise Modules']); } public function notFound(): void { http_response_code(404); $this->view('modules/404', ['title'=>'Not Found']); } }
