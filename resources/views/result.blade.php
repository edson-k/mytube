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

            .content {
                text-align: center;
            }

            .result {
                padding-left: 30px;
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

            b {
                font-weight: bold !important;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            
            <div class="content">
                <div class="title m-b-md">
                    myTUBE
                </div>
                <div>
                    Resultado da busca por: <b>{{$data['q']}}</b> exibindo <b>{{sizeof($data['videosList'])}}</b> resultados de 200.
                    <br/><br/>
                    <button class="btn btn-danger" onclick="document.location.href='/';"><< voltar</button>
                    <br/><br/>
                </div>
            </div>
            
            <div class="result">
                @php
                    $time_controll = 0;
                    $contTime = 1;
                    $contDia = 1;
                    $tTime = 0;
                @endphp

                @for ($i=0; $i < sizeof($data['videosList']); $i++)
                    @if ($time_controll === 0)
                        <div class="card">
                            <div class="card-block">
                                <h4>Dia {{ (($contDia<10)?'0'.$contDia:$contDia) }} - {{ $data['time_0'.$contTime] }} min</h4>
                                <ul>
                    @endif
                    @if ( ($time_controll+$data['videosList'][$i]['duration']) <= $data['time_0'.$contTime] )
                        @php 
                            $time_controll += $data['videosList'][$i]['duration']; 
                            $tTime += $data['videosList'][$i]['duration']*60;
                        @endphp
                        <li>
                            {{ (($i<10)?'0'.$i:$i) }} - <a href="https://www.youtube.com/watch?v={{$data['videosList'][$i]['videoId']}}" target="_blank">
                                {{$data['videosList'][$i]['title']}}
                            </a> - {{gmdate("H:i:s",($data['videosList'][$i]['duration']*60))}}
                        </li>
                    @else
                        @if ($time_controll == 0)
                                        <li>nenhum vídeo para este dia!</li>
                                    </ul>
                                </div>
                            </div>
                            <br/>
                        @else
                                    </ul>
                                </div>
                            </div>
                            <br/>
                        @endif

                        @php
                            $time_controll = 0;
                            $contDia++;
                            $i--;
                        @endphp

                        @if ($contTime < 7)
                            @php $contTime++; @endphp
                        @else
                            @php $contTime = 1; @endphp
                        @endif
                    @endif
                    @if ($i == (sizeof($data['videosList'])-1))
                                </ul>
                            </div>
                        </div>
                    @endif
                @endfor

                @if (sizeof($data['videosList']) > 0)
                    @php  $tTime = secondsToTime($tTime); @endphp
                    <br/>
                    <div class="card">
                        <div class="card-block">
                            <h3>Tempo total de videos de todos os dias</h3>
                            <ul>
                                <li>{{$tTime}}</li>
                            </ul>
                        </div>
                    </div>
                    <br/>

                    <div class="card">
                        <div class="card-block">
                            <h3>Total de dias</h3>
                            <ul>
                                <li>{{$contDia}} dias</li>
                            </ul>
                        </div>
                    </div>

                    <br/>
                    <div class="card">
                        <div class="card-block">
                            <h3>5 Palavras mais utilizadas</h3>
                            <ul>
                                @foreach ($data['find_most_used_words'] as $value) 
                                    <li>{{$value['word']}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        nenhum resultado encontrado para sua busca!
                    </div>
                @endif

                <br/>
                <br/>
                <div class="content">
                    <button class="btn btn-danger" onclick="document.location.href='/';"><< voltar</button>
                    <br/><br/>
                </div>
            </div>
        </div>
    </body>
</html>
