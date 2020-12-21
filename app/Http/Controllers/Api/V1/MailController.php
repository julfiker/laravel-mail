<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\MailerContracts;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

/**
 * Only one time for the application
 * @OA\Info(title="Mailer REST API DOC", version="1.0")
 */
class MailController extends Controller
{


    /**
     * @OA\Post(
     *     path="/v1/mail/send",
     *     tags={"Mailer"},
     *     summary="Mail Send",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="mail_to",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="mail_from",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="mail_subject",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="content_html",
     *                     type="string"
     *                 ),
     *                @OA\Property(
     *                     property="content_plain",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="attachments",
     *                     @OA\Property(
     *                        type="array",
     *                        @OA\Items(
     *                       type="array",
     *                       @OA\Items()
     *                      )
     *                     )
     *                 ),
     *                 example={
     *                        "mail_from": "mail.julfiker@gmail.com",
     *                        "mail_to": "infro.jewel@gmail.com",
     *                       "mail_subject": "Test Email Again",
     *                       "content_plain": "this text content",
     *                       "content_html": "<h1>this <b>html</b> content</h1>",
     *                       "attachments": "[]"
     *                    }
     *             )
     *         )
     *     ),
     *  @OA\Response(response="200", description="Successfully delivered"),
     *  @OA\Response(response="400", description="Bad Request. failed."),
     *  @OA\Response(response="422", description="Unprocessable Entity. mail sending is failed.")
     * )
     *
     * @param Request $request
     * @param MailerContracts $mailer
     * @return string[]
     */
    public function send(Request $request, MailerContracts $mailer) {
        $mailer->sendEmail($request->all());
        return ['message'=>'Email has been posted!!'];
    }

    /**
     * Action method
     * @OA\Get(
     *     path="/v1/mail/logs",
     *     tags={"Mailer"},
     *     summary="Mailer Logs",
     *     @OA\Response(response="200", description="About the resources")
     * )
     */
    public function logs(Request $request, MailerContracts $mailManager) {
        return $mailManager->getMailLogs($request->all());
    }
}
