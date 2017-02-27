/**
 * Created by sunday on 2/26/17.
 */
(function(){
    'use strict';

    function Przekroj($http){
        this.getImage = function (prze) {
            return $http.get('php/przekroj.php', { params: { prze: prze}}).then(function (response) {
                console.log(response);
                return response;
            })
        }
    }
    angular.module('monitoring')
        .service('Przekroj', Przekroj);



})();