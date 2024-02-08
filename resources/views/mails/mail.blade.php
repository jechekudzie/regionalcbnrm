<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Account Created</title>
    <script src="../assets/js/color-modes.js"></script>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">

<main style="padding: 20px;">

    <div class="row" style="padding: 20px;">
        <div class="col-md-12" style="padding: 16px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-wrap: wrap; align-items: center;">
            <div style="padding: 20px; flex-basis: 70%;">
                <h5 style="font-size: 18px; font-weight: bold; line-height: 1.2; margin: 0 0 20px;">New Account
                    Created</h5>
                <p style="font-size: 1rem; line-height: 1.5; margin: 0 0 20px; color: black;">
                    Good day,
                    <br/>
                    <br/>

                    An account has been created for Organisation: {{$userOrganisation->name}}
                    <br/>
                    <br/>

                    Your default login credentials are:
                    <br/>
                    <br/>
                    Email: {{$user->email}} <br/>
                    Password: {{'password@1'}} <br/>
                </p>
                <div style="margin-bottom: 20px;">
                    <a href="{{url('/login')}}" class="btn btn-primary" role="button">
                        Click Here To LogIn
                    </a>
                </div>
                <br/>
                <img src="{{asset('/logo/logo.png')}}" alt="" style="width: 350px; border-radius: 0 8px 8px 0;">


            </div>
        </div>

    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
