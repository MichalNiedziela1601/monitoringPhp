(function ()
{
    'use strict';

    function MenuSideController($uibModalInstance,$localStorage)
    {
        var ctrl = this;
        function getStations()
        {
            StationsFactory.getStations().then(function (data)
            {
                ctrl.stations = data;
            });
        }

        function init()
        {
            ctrl.stations = $localStorage.stations;
        }
        ctrl.ok = function (e)
        {
            console.log('ok');
            $uibModalInstance.close();
            e.stopPropagation();
        };
        ctrl.cancel = function (e)
        {
            $uibModalInstance.dismiss();
            e.stopPropagation();
        };

        ////////
        init();
    }

    angular.module('monitoring')
            .controller('MenuSideController', MenuSideController);


})();
