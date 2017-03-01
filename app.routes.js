(function ()
{
    'use strict';

    function route($routeProvider,$locationProvider)
    {
        $locationProvider.hashPrefix('');
        $locationProvider.html5Mode({
            enabled: true
        });

        $routeProvider
                .when('/', {
                    templateUrl: 'mainView/mainView.controller.html', controller: 'MainViewController', controllerAs: 'mainViewCtrl'
                })
                .when('/punkt_wodny/:id', {
                    templateUrl: '/punkt_wodny/punktWodny.tpl.html',
                    controller: 'MeasurePointController',
                    controllerAs: 'measurePointCtrl'
                })
            .when('/punkt_opadowy/:id', {
                templateUrl: '/punkt_opadowy/punkt_opadowy.tpl.html',
                controller: 'PunktOpadowyController',
                controllerAs: 'punkOpadCtrl'
            });


        // .otherwise({ redirectTo: '/'});
    }

    angular.module('monitoring')
            .config(route);
})();
