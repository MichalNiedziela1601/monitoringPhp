(function ()
{
    'use strict';

    function MenuSideController($uibModalInstance,StationsFactory)
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
            getStations();
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
