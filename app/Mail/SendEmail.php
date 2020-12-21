<?php

namespace App\Mail;

use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $emailLog;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailLog $emailLog)
    {
        $this->emailLog = $emailLog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $email = $this->to($this->emailLog->mail_to)
         ->from($this->emailLog->mail_from)
         ->subject($this->emailLog->mail_subject)
         ->text('mail.text', ['emailLog'=>$this->emailLog])
         ->view('mail.html', ['emailLog'=>$this->emailLog]);

       if (count($this->emailLog->attachments)>0) {
           foreach ($this->emailLog->attachments as $attachment) {
               $email->attachData(base64_decode($attachment->file_content), $attachment->filename, ['mime' => $attachment->file_type]);
           }
       }

       return $email;
    }
}
