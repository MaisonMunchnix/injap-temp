<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial
        }

        a {
            text-decoration: none
        }

        .default-text {
            color: #130f40 !important
        }

        .default-background {
            background: #4834d4 !important;
            color: #fff !important;
            padding: 1px 25px;
            border: 1px solid #d5d5d5
        }

        .img-logo {
            max-width: 400px;
            margin: auto
        }

        .signature {
            font-weight: 700
        }

        .signature-logo {
            max-width: 250px
        }

        .text-center {
            text-align: center
        }

        .link-btn {
            padding: 10px;
            background: #3cb5d0;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #3cb5d0
        }

        .panel-body {
            border: 1px solid #d5d5d5;
            padding: 25px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading default-background text-center" style="border-radius: 10px 10px 0px 0px;"></div>
                <div class="panel-body">
                    <table style="width: 60%; margin: auto; border-collapse: collapse; border: 0; font-family: arial;">
                        <tr style="background:#4834d4; height: 100px;">
                            <td width="30%" style="text-align: center; vertical-align: middle;"><img
                                    src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                    style="width: 80%" /></td>
                            <td style="text-align: center; vertical-align: middle; color: #fff; padding: 0">
                                <h1>{{ env('APP_NAME') }}</h1>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 20px; background-color: #ededed;">
                                <h3 style="text-align:text-center !important;">Reset your password</h3>
                                <p>Hi @if (!empty($full_name))
                                        {{ $full_name }}
                                    @else
                                        member
                                    @endif,</p>
                                <p>We have received a request to recover your {{ env('APP_NAME') }} password. To set a
                                    new password, simply click below.<br />
                                <p><a
                                        href="{{ env('APP_URL') }}/password/reset/{{ $reset_code }}?email={{ urlencode($email) }}">Reset
                                        Password</a></p>
                                <p>If you didn’t ask to recover your password, please ignore this email. </p>
                                <br>
                                <p>
                                    Thanks and Best Regards
                                </p><br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
