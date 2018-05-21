<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ads File Dashboard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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

            .alert {
                font-style: italic;
                font-weight: bold;
            }
            .alert-success {
                background-color: lightgreen;
            }

            .alert-danger {
                background-color: lightcoral;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <form action="{{ route('ads-file.post') }}"
                method="post" 
                enctype="multipart/form-data">
                <div>
                    {{ csrf_field() }}
                    <label for="file">Choose Ads.txt file to upload</label>
                    <br><br><br>
                    <input type="file" id="ads-file" name="ads-file">
                </div>
                <div>
                    <button>Upload</button>
                </div>
                <br><br><br>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <br><br><br>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
            </form>
        </div>
    </body>
</html>
