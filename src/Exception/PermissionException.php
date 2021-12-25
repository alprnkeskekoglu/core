<?php

namespace Dawnstar\Core\Exception;

use Exception;

class PermissionException extends Exception
{
    public function render($request)
    {
        return response()->view('Core::errors.permission', [], 403);
    }
}
