/**
 * Created by sunday on 03.03.17.
 */
(function(){
    'use strict';

    function PunktOpad($http){

        this.getOpadInt = function(prze){
            return $http.get('services/php/opadint.php', { params: { prze: prze}})
                .then(function(response){
                    return response.data;
                })
        };

        this.getTable = function(prze){
            return $http.get('services/php/tabeleo.php', { params: { prze: prze}})
                .then(function(response){
                    console.log('response', response.data);
                    return response.data
                })
        };
        this.getTableWithDate = function(prze, year,month,day,hour,minutes){
            return $http.get('services/php/tabeleo.php', {
                params: {
                    prze: prze,
                    rok: year,
                    miesiac: month,
                    dzien: day,
                    godzina: hour,
                    minuta: minutes
                }
            }).then(function(response){
                return response.data;
            })
        };

        this.getWykresH = function (prze) {
            return $http.get('services/php/wykres_o1.php', {params: {prze: prze}}).then(function (response) {
                return response.data;
            })
        };

        this.getWykresHwithDate = function (prze, year, month, day, hour, minutes) {


            return $http.get('services/php/wykres_o1.php',
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
        };

        this.getWykresD = function (prze) {
            return $http.get('services/php/wykres_o2h.php', {params: {prze: prze}}).then(function (response) {
                return response.data;
            })
        };

        this.getWykresDwithDate = function (prze, year, month, day, hour, minutes) {


            return $http.get('services/php/wykres_o2h.php',
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
        .service('PunktOpad',  PunktOpad);

})();