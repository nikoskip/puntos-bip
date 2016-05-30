
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Puntos Bip!</title>

    <link href="{{ elixir('css/app.css')  }}" rel="stylesheet">
</head>

<body>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <img src="http://www.transantiago.cl/img/logo_web.png" alt=""/>
            </div>

            <div class="inner cover">
                <div id="address-form">
                    <h1 class="cover-heading">Ingresa una dirección</h1>
                    <div class="form-container">
                        <input type="text" id="address" class="input-direccion" placeholder="Calle 123, Comuna">
                        <button type="button" id="search" class="btn-default">Buscar</button>
                    </div>
                    <p class="info">Se buscarán Puntos Bip! en un radio de {{ number_format(config('app.radio_busqueda'), 0, ',', '.') }} metros</p>
                </div>
                <div id="messages">

                </div>
                <div id="results" class="results-container">
                    <p id="results-info" class="results-info"></p>
                    <ul id="result-list" class="result-list"></ul>
                </div>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a> - Adapted by <a href="https://twitter.com/nikoskip">@nikoskip</a></p>
                </div>
            </div>

        </div>

    </div>

</div>

<script type="text/template" id="template-record">
    <li class="result">
        <div class="result-distance">A <%=distance%> metros</div>
        <h3><%=nombre%></h3>
        <p class="result-address"><%=direccion%>, <%=comuna%></p>
        <p class="result-schedule"><%=horario%></p>
        <div class="result-more-info">
            <h4>Servicios</h4>
            <ul>
                <% _.each(servicios, function (servicio) { print('<li>' + servicio + '</li>'); }) %>
            </ul>
        </div>
    </li>
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="{{ elixir('js/app.js')  }}"></script>
</body>
</html>
