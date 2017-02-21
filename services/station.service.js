(function () {
    'use strict';

    function StationsFactory($http) {

        return {
            getStations: function () {
                return $http.get('services/php/station.php?action=getStations').then(function (result) {
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
            },

            checkObsadzona: function (nazwa_punktu,typ) {
                var data = {
                    'typ' : typ,
                    'nazwa_punktu' : nazwa_punktu
                };
                return $http.post('services/php/station.php?action=checkObsadzona', data).then(function (result) {
                    console.log(result);

                    return result;
                })
            }


        };

    }

    angular.module('monitoring')
        .service('StationsFactory', StationsFactory);


})();