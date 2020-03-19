<?php

namespace App\Modules\Admin\Controllers;

use App\Mail\CryptoData;
use Illuminate\Support\Facades\Mail;

class MailController  extends AdminController
{
    public function send()
    {
        Mail::to('apitester@test.com')->send(new CryptoData());
    }
}