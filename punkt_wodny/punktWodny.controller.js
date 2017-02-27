/**
 * Created by sunday on 2/14/17.
 */
(function(){
    'use strict';
    function MeasurePointController($routeParams, Przekroj){
        var ctrl = this;
        ctrl.id = $routeParams.id;

        Przekroj.getImage(ctrl.id).then(function (data) {
            ctrl.image = data;
        }).catch(function(error){
            console.log(error);
        })
    }
    angular.module('monitoring')
        .controller('MeasurePointController', MeasurePointController);


})();
