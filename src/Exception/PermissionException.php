<?php

namespace Dawnstar\Exception;

use Exception;

class PermissionException extends Exception
{
    public function render($request)
    {
        return response()->view('Dawnstar::errors.permission', [], 403);
    }
}
