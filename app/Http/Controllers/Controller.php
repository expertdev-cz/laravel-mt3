<?php

namespace App\Http\Controllers;

use App\Services\System\PageService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected PageService $pageService;
    protected Request $request;

    public function __construct(Request $request,PageService $pageSrv){
        $this->pageService = $pageSrv;
        $this->request = $request;
    }

    public function index(): View{
        return $this->pageService->getPageView(
            $this->request->getRequestUri(),
            app()->currentLocale()
        );
    }

}
