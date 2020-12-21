<?php


namespace App\Contracts;


interface MailerContracts
{

    /**
     * Send a email
     *
     * @param array $data
     * @return mixed
     */
    public function sendEmail(array $data);

    public function getMailLogs(array $filter);
}
