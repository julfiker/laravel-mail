<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;
    protected $fillable = ['mail_to', 'mail_from', 'mail_subject', 'content_html', 'content_plain'];

    public function attachments() {
        return $this->hasMany(EmailAttachment::class, 'email_log_id');
    }
}
