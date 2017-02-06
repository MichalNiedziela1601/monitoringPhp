(function(){

    function config($routerProvider){
        $routerProvider
            .when('/', {
                templateUrl: 'views/mainCtrl.html',
                controller: 'MainController',
                controllerAs: 'mainCtrl'
            })
            .otherwise({redirectTo: '/'});
    }

    angular.module('ropczyceMon')
        .config(config);
})();