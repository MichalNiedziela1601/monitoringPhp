/**
 * Created by sunday on 2/26/17.
 */
(function () {
    'use strict';

    function Przekroj($http) {
        this.getImage = function (prze) {
            return $http.get('services/php/przekroj5.php', {params: {prze: prze}}).then(function (response) {
                return response.data;
            })
        };

        this.getTable = function (prze) {
            return $http.get('services/php/tabele2.php', {params: {prze: prze}})
                .then(function (response) {
                    return response.data;
                })
        };

        this.getWykresH = function (prze) {
            return $http.get('services/php/wykres_h1.php', {params: {prze: prze}}).then(function (response) {
                return response.data;
            })
        };

        this.getWykresHwithDate = function (prze, year, month, day, hour, minutes) {


            return $http.get('services/php/wykres_h1.php',
                {
                    params: {
                        prze: prze,
                        rok: year,
                        miesiac: month,
                        dzien: day,
                        godzina: hour,
                        minuta: minutes
                    }
                })
                .then(function (response) {
                    return response.data;
                })
        }
    }

    angular.module('monitoring')
        .service('Przekroj', Przekroj);


})();