<?php

namespace App\Mailboxes;

use BeyondCode\Mailbox\InboundEmail;

class CryptoMailbox
{
    public function __invoke(InboundEmail $email)
    {
        $html = $email->html();

        $match = preg_match('/\[([^"]*)\]/', $html, $matches);
        if ($match) {

            $split = preg_split('/\] - \[{1}/', $matches[1]);

            if ($split) {
                $dashboard = $split[0];
                $category = $split[1];
                $widget = $split[2];
                $data = $split[3];
            }
        }
    }
}