<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Created</title>
    <style>
        body, html {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .email-content {
            margin: 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        img.responsive-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="email-content">
        <h4 style="color:black;">New Account</h4>
            <p style="color:black;">
                Good day,<br><br>
                An account has been created for Organisation: {{$userOrganisation->name}}<br><br>
                Your default login credentials are:<br><br>
                Email: {{$user->email}} <br>
                Password: password@1 <br>
            </p>
            <a href="{{url('/login')}}" class="btn-primary" role="button">
                Click Here To LogIn
            </a>
            <br>
            <img src="{{asset('/logo/logo.png')}}" style="width:300px;" alt="" class="responsive-img">
    </div>
</div>
</body>
</html>
