<!DOCTYPE html>
<html>
    <head>
        <title>Águias de São Mamede.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <style>
            html, body {
                height: 100%;
				user-select: none;
            }

            #particles-js {

                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
				z-index: -1;

            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                /*color: #B0BEC5;*/
                background-image: url("imagens/fans-blured.png");
                background-position: center;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
				z-index: 10;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                color: white;
                font-size: 72px;
                margin-bottom: 40px;
            }

            .emblema {
                width: 30%;
            }
        </style>
    </head>
    <body>

    <div id="particles-js"><canvas class="particles-js-canvas-el" style="width: 100%; height: 100%;"></canvas></div>

        <div class="container">
            <div class="content">
                <img src="imagens/emblema-white-border.png" class="emblema">
                <div class="title">Brevemente</div>
            </div>
        </div>


    <script src="/js/particles.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
    <script>
        particlesJS.load('particles-js', '/js/particles-config.json', function() {

            console.log('Loaded Particles!');

        });
    </script>

    </body>
</html>
