<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>myTube</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
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

            <div class="content">
                <div class="title m-b-md">
                    myTUBE
                </div>

                <form method="POST" action="./">
                    {{ csrf_field() }}
                    <label for="basic-url">Defina o tempo gasto para cada dia</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 01</span>
                        <input type="text" name="time_01" class="form-control" placeholder="15">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 02</span>
                        <input type="text" name="time_02" class="form-control" placeholder="120">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 03</span>
                        <input type="text" name="time_03" class="form-control" placeholder="30">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 04</span>
                        <input type="text" name="time_04" class="form-control" placeholder="150">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 05</span>
                        <input type="text" name="time_05" class="form-control" placeholder="20">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 06</span>
                        <input type="text" name="time_06" class="form-control" placeholder="40">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Dia 07</span>
                        <input type="text" name="time_07" class="form-control" placeholder="90">
                        <span class="input-group-addon" id="basic-addon1">min.</span>
                    </div>
                    <br/>
                    <br/>
                    <label for="basic-url">Defina sua busca e filtro</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Ignorar palavras menores que</span>
                        <input type="text" name="q_start" class="form-control" placeholder="4">
                        <span class="input-group-addon" id="basic-addon1">nas palavras mais utilizadas</span>
                    </div>
                    <br/>
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search for..." value="Android">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">buscar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
