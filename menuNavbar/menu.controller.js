(function(){
    'use strict';

    function MenuController($aside, StationsFactory){
        var ctrl = this;

        ctrl.asideState = {
            open: false
        };

        ctrl.openAside = function(position, backdrop) {
            ctrl.asideState = {
                open: true,
                position: position
            };

            function postClose() {
                ctrl.asideState.open = false;
            }

            $aside.open({
                templateUrl: 'menuNavbar/menu.tpl.html',
                placement: position,
                size: 'md',
                backdrop: backdrop,
                controller: 'MenuSideController',
                controllerAs: 'menuSide'
            }).result.then(postClose, postClose);
        };
        function getStations()
        {
            StationsFactory.getStations().then(function (data)
            {
                ctrl.stations = data;
            });
        }

        function init()
        {
            ctrl.stations = getStations();
        }
        init();


    }

    angular.module('monitoring')
        .controller('MenuController', MenuController);


})();
