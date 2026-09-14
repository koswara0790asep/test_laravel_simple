<?php

namespace App\Helpers;

use App\Models\LogActivity;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    /**
     * Catat Aktivitas ke Database
     */
    public static function record($subject, $userId = null)
    {
        LogActivity::create([
            'user_id'    => $userId ?? (Auth::check() ? Auth::id() : null),
            'subject'    => $subject,
            'url'        => Request::fullUrl(),
            'method'     => Request::method(),
            'ip_address' => Request::ip(),
            'agent'      => Request::header('user-agent'),
        ]);
    }
}
