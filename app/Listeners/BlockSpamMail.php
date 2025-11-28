<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;

final class BlockSpamMail
{
    public function handle(MessageSending $event): bool|null
    {
        // Symfony Mailer (Laravel 9+)
        $msg = $event->message;

        // Safely read subject/text/html (works for Symfony Mailer)
        $subject = method_exists($msg,'getSubject')  ? (string) $msg->getSubject()  : '';
        $text    = method_exists($msg,'getTextBody') ? (string) $msg->getTextBody() : '';
        $html    = method_exists($msg,'getHtmlBody') ? (string) $msg->getHtmlBody() : '';

        $blob = strtolower($subject.' '.$text.' '.$html);

        // ultra-short heuristic — tweak anytime
        if (preg_match('/\b(select|union|sleep|benchmark|load_file|outfile|<script|http:\/\/)\b/i', $blob)) {
            // returning false cancels the send
            return false;
        }

        return null; // allow
    }
}
