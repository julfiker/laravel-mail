<?php


namespace App\Managers;
use App\Contracts\MailerContracts;

use App\Jobs\SendEmailJob;
use App\Models\EmailAttachment;
use App\Models\EmailLog;

class MailManager implements MailerContracts
{

    protected $emailLog;
    protected $emailAttachment;

    public function __construct(EmailLog $emailLog, EmailAttachment $emailAttachment)
    {
        $this->emailLog = $emailLog;
        $this->emailAttachment = $emailAttachment;
    }

    /**
     * Send a email based on data
     *
     * @param $data
     * @return EmailLog
     */
    public function sendEmail(array $data) {

        $this->emailLog->fill($data);
        $this->emailLog->status = 'Posted';
        $a = [];
        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                $emailAttachment = new EmailAttachment();
                $emailAttachment->fill($file);
                $a[] = $emailAttachment;
            }
        }
        $this->emailLog->save();
        if (count($a)>0)
        $this->emailLog->attachments()->saveMany($a);
        $details = ['emailLog' => $this->emailLog];
        SendEmailJob::dispatch($details);
        return $this->emailLog;
    }

    /**
     * Getting mail logs
     *
     * @param array $filter
     * @return mixed
     */
    public function getMailLogs(array $filter)
    {

        $emailLog = $this->emailLog;
        if (isset($filter['subject'])) {
           $emailLog = $emailLog->where('mail_subject', 'like',  "%".$filter['subject']."%");
        }
        if (isset($filter['status'])) {
            $emailLog = $emailLog->where('status', '=',  $filter['status']);
        }

        return $emailLog->paginate(15);
    }
}
