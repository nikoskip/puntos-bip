var PuntosBip = (function () {

    'use strict';

    /**
     * Puntos Bip! obtenidos de la búsqueda
     */
    var _records;

    /**
     * Listado DOM de resultados
     */
    var _$resultList;

    /**
     * Boton que realiza la búsqueda
     */
    var _$searchButton;

    var _init = function () {
        _$resultList = $('#result-list');
        _$searchButton = $('#search');

        _$searchButton.click(_searchHandler);
    };

    /**
     * Handler para botón de búsqueda
     * @param e
     * @private
     */
    var _searchHandler = function (e) {
        var address = $.trim($('#address').val());

        if (address === '') {
            alert('Por favor ingresa una dirección');
            return;
        }

        _$resultList.css('opacity', 0.1);

        // Deshabilitamos el botón
        _disableButton();

        $.when(_find(address)).then(function (data) {
            _records = data.results;
            $('#results-info').text('Se encontraron ' + data.results.length + ' Puntos Bip!');
            // Limpaimos resultados por si existen previamente
            _clearResults();
            // Listamos resultados
            _listResults();
            // Habilitamos el botón
            _activateButton();
        }, function () {
            // Habilitamos el botón
            _activateButton();
            alert('Algo sucedió al obtener los resultados. Vuelve a intentarlo.')
        });
    };

    /**
     * Busca los Puntos Bip! para una dirección dada
     * @param address
     * @returns {*}
     * @private
     */
    var _find = function (address) {
        return $.getJSON('/api/getByAddress', {address: address});
    };

    /**
     * Lista los resultados
     * @private
     */
    var _listResults = function () {
        var templateContent = $('#template-record').html();
        $.each(_records, function () {
            var template = _.template(templateContent);
            _$resultList.append(template(this));
        });
        _$resultList.css('opacity', 1);
        $('#results').show();
    };

    /**
     * Elimina todos los resultados en pantalla
     * @private
     */
    var _clearResults = function () {
        _$resultList.find('li').remove();
    };

    var _disableButton = function (){
        _$searchButton.prop('disabled', true).html('<span>||</span><span>||</span><span>||</span>').addClass('saving');
    };

    var _activateButton = function () {
        _$searchButton.prop('disabled', false).text('Buscar').removeClass('saving');
    }

    return {
        init: _init
    }

})();

$(function () {
    PuntosBip.init();
});
//# sourceMappingURL=app.js.map
