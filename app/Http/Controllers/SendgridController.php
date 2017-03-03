<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendgridController extends Controller
{
    /*
     * Initial form to gather data to be "mailed"
     *
     * @return Illuminate\View\View
     */
    public function form()
    {
        $field_values = ['to' => '', 'from' => '', 'subject' => '', 'body' => ''];
        return view('sendgrid.form', $field_values);
    }

    /**
     * Validate and process data via sendgrid API
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        // Validation max lengths are random and are here to show valdation in action,
        // not to enforce some standard
        $this->validate($request, ['to' => 'required|max:64',
                                    'from' => 'required|max:64',
                                    'subject' => 'required|max:128',
                                    'body' => 'required|max:1024',
                                    // 'attachment' => 'required',
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->getClientOriginalName();
        } else {
            $attachment = 'none';
        }

        $field_values = ['to' => $request->to,
                        'from' => $request->from,
                        'subject' => $request->subject,
                        'body' => $request->body,
                        'attachment' => $attachment];

        $sg_response = $this->sendgrid($request);

        return redirect()->action('SendgridController@result')->with(array_merge($field_values, $sg_response));
    }

    /**
     * Display results
     *
     * @return Illuminate\View\View
     */
    public function result(Request $request)
    {
        $field_values = $request->session()->all();
        // If not a redirect, set default values for form fields (choose random field to test for)
        if (!array_key_exists('subject', $field_values)) {
            $field_values = ['to' => '', 'from' => '', 'subject' => '', 'body' => '', 'attachment' => '', 'sg_status_code' => '', 'sg_headers' => '', 'sg_body' => ''];
        }
        return view('sendgrid.result', $field_values);
    }

    /**
     * Do the heavy lifting here, ...
     *
     * @param Request $request
     * @return array Sendgrid response detail
     */
    final protected function sendgrid(Request $request) {
        $to = new \SendGrid\Email("FilterEasy", $request->to);
        $from = new \SendGrid\Email("Sendgrid Code Assignment", $request->from);
        $content = new \SendGrid\Content("text/plain", $request->body);
        $subject = $request->subject;
        $send_time = time() + (5*60);

        $mail = new \SendGrid\Mail($from, $subject, $to, $content);
        $mail->addCustomArg('Developer', 'Craig Duncan');
        $mail->addCustomArg('Company', 'FilterEasy');
        $mail->addCustomArg('Email_Name', 'test@filtereasy.com');
        $mail->setSendAt($send_time);

        if ($request->hasFile('attachment')) {
            $file_path = $request->file('attachment')->getPathname();
            $file_encoded = base64_encode(file_get_contents($file_path));
            $attachment = new \SendGrid\Attachment();
            $attachment->setDisposition('attachment');
            $attachment->setContent($file_encoded);
            $attachment->setType($request->file('attachment')->getClientMimeType());
            $attachment->setFilename($request->file('attachment')->getClientOriginalName());
            $mail->addAttachment($attachment);
        }

        $api_key = getenv('SENDGRID_API_KEY');
        $sg = new \SendGrid($api_key);

        $sg_response = $sg->client->mail()->send()->post($mail);

        return ['sg_status_code' => $sg_response->statusCode(), 'sg_headers' => $sg_response->headers(), 'sg_body' => $sg_response->body()];
    }

}
