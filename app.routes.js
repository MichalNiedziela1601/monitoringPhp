(function ()
{
    'use strict';

    function route($routeProvider,$locationProvider)
    {
        $locationProvider.hashPrefix('');
        $locationProvider.html5Mode({
            enabled: true, requireBase: false
        });

        $routeProvider
                .when('/', {
                    templateUrl: 'mainView/mainView.controller.html', controller: 'MainViewController', controllerAs: 'mainViewCtrl'
                })
                .when('/punkt_wodny/:id', {
                    templateUrl: '/punkt_wodny/punktWodny.tpl.html', controller: 'MeasurePointController', controllerAs: 'measurePointCtrl'
                });


        // .otherwise({ redirectTo: '/'});
    }

    angular.module('monitoring')
            .config(route);
})();
