<?php

namespace Dawnstar\Exception;

use Exception;

class PermissionException extends Exception
{
    public function render($request)
    {
        return response()->view('DawnstarView::pages.permission.error', [], 403);
    }
}
