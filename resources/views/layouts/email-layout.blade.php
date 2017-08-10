<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /* Este estilo e para colocar na pasta public quando o site estiver online */
        p {
            line-heightheight: 20px;
            font-weight: 400;
            font-size: 18px;
            color: rgb(12, 12, 12);
            padding: 10px 10px 10px 10px;
            margin: 10px 10px 10px 10px;
        }

        h1 {
            line-height: 40px;
            font-weight: 100;
            font-size: 30px;
            color: rgb(255, 255, 255);
            padding: 10px 10px 10px 10px;
            margin: 10px 10px 10px 10px;
            text-shadow: 1px 1px 2px #121212;
        }

        a {
            color: rgb(11,101,75);
            text-decoration: double;
            font-weight: 400;
            text-shadow: 0px 0px 1px #333333;
        }

        a:hover {
            color: rgb(11, 79, 255);
            text-shadow: 0px 0px 6px #333333;
        }

        a:focus {
            outline: none;
        }

        .email-head {
            position: relative;
            padding: 5px;
            width: 100%;
            background-color: rgb(11,101,75);
            font-weight: 300;
        }

        .email-body {
            position: relative;
            padding: 5px;
            width: 100%;
            background-color: rgb(249, 249, 249);
        }

        .email-footer {
            position: relative;
            width: 100%;
            padding: 5px;
            background-color: rgb(226, 226, 226);
        }

        .email-footer p {
            font-size: 14px;
            color: rgb(49, 49, 49);
        }

        .botao {
            -webkit-border-radius: 2;
            -moz-border-radius: 2;
            border: none;
            border-radius: 2px;
            color: #ffffff;
            font-size: 20px;
            background: #3e9444;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

    </style>
    @yield('head')
</head>

<body>
@yield('body')
</body>
</html>