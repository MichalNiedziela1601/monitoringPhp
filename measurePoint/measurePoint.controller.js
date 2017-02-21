/**
 * Created by sunday on 2/14/17.
 */
(function(){
    'use strict';
    function MeasurePointController($routeParams){
        var ctrl = this;
        ctrl.id = $routeParams.id;
    }
    angular.module('monitoring')
        .controller('MeasurePointController', MeasurePointController);


})();
