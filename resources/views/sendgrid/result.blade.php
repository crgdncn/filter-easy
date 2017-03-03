<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="widtd=device-widtd, initial-scale=1">

        <title>Sendgrid</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            tr {
                height: 45px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title m-b-md">
                SendGrid Result
        </div>

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

            <table align="center" widtd="700" style="text-align: left;">
                <tr >
                    <td width="100">
                        {{ Form::label('to', "To") }}
                    </td>
                    <td width="600">
                        {{ $to }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::label('from', "From") }}
                    </td>
                    <td>
                        {{ $from }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::label('subject', "Subject") }}
                    </td>
                    <td>
                        {{ $subject }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::label('body', "Body") }}
                    </td>
                    <td>
                        {{ $body }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::label('attachment', "Attachment") }}
                    </td>
                    <td>
                        {{ $attachment }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ Form::label('statuscode', "Status") }}
                    </td>
                    <td>
                         @if ($sg_status_code)
                         {{ ($sg_status_code == '202') ? 'Email sent.':'email failed to send, please review configuration, or talk to someone smart enough to figure out the issue.' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; padding-right: 50">
                        {{ link_to_action('SendgridController@form', $title = 'Send another email', [], $attributes = ['class' => 'btn btn-primary']) }}
                    </td>
                </tr>
            </table>

        </div>

        <!--

        Response Body: {{ var_export($sg_body, true) }}



        Response Headers: {{ var_export($sg_headers, true) }}

        -->

    </body>
</html>
