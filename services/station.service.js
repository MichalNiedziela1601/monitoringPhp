(function () {
    'use strict';

    function StationsFactory($http) {

        return {
            getStations: function () {
                return $http.get('services/php/station.php').then(function (result) {

                    var stations = {
                        wodne: [],
                        opadowe: []
                    };
                    angular.forEach(result.data, function (station) {
                        if (station.typ === '1') {
                            stations.wodne.push(station);
                        } else if (station.typ === '2') {
                            stations.opadowe.push(station)
                        }
                    });
                    return stations;
                })
            }


        };

    }

    angular.module('monitoring')
        .service('StationsFactory', StationsFactory);


})();