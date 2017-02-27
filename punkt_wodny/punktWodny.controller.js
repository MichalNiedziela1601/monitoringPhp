/**
 * Created by sunday on 2/14/17.
 */
(function(){
    'use strict';
    function MeasurePointController($routeParams, Przekroj){
        var ctrl = this;
        ctrl.id = $routeParams.id;

        Przekroj.getImage(ctrl.id).then(function (data) {
            console.log(data);
        })
    }
    angular.module('monitoring')
        .controller('MeasurePointController', MeasurePointController);


})();
