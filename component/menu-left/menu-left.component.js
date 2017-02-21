/**
 * Created by sunday on 2/14/17.
 */
(function(){
    'use strict';

    angular.module('monitoring')
        .component('menuStations', {
        templateUrl: 'component/menu-left/menu-left.tpl.html',
            bindings: {
            stations: '='
            }
    });

})();
