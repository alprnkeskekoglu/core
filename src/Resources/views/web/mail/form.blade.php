<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body style="font-family: Calibri;background-color: #ffffff;">
<div class="container" style="width: 720px;border:1px solid #ccc;padding:30px;margin: 0 auto;color:#707070;font-family: Calibri;font-size: 13px;">
    <div class="logo" style="text-align: center;">
        <a href="{!! url("/"); !!}"><img src="{!! asset("images/logo.png") !!}" alt="{{ env('SITE_TITLE') }}"></a>
    </div>
    <div class="body" style="text-align: center;">
        <p style="color:#5C5D5F;font-size: 25px;font-weight: bold;margin: 40px 0 0; display: block;">{!! $form->name !!} </p>
    </div>
    <table>
        @foreach($messages as $key => $value)
            <tr>
                <td><b>{!! custom('form.' . $form->id . '.' . $key, 164) !!}</b></td>
                <td>{!! $value !!}</td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
