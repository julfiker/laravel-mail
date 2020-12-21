<?php



namespace App\Jobs;



use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Queue\SerializesModels;

use Mail;



class SendEmailJob implements ShouldQueue

{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**

     * Create a new job instance.

     *

     * @return void

     */

    public function __construct($details)
    {
        $this->details = $details;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailLog = $this->details['emailLog'];
        $email = new SendEmail($emailLog);
        Mail::send($email);
        if(count(Mail::failures()) > 0){
            $emailLog->status = 'Failed';
            $emailLog->save();
        }
        else {
            $emailLog->status = 'Sent';
            $emailLog->save();
        }
    }

}
