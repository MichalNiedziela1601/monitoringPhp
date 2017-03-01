(function ()
{
    'use strict';

    function MainViewController($location, uiGmapGoogleMapApi)
    {
        var ctrl = this;
        var id = 1;
        ctrl.markers = [{
            latitude: 49.975806, longitude: 21.564205, options: {title: 'Glinik'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.010451, longitude: 21.551644, options: {title: 'Laczki'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.030305, longitude: 21.548985, options: {title: 'Okonin'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.095789, longitude: 21.629038, options: {title: 'Kozodrza'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.015363, longitude: 21.674870, options: {title: 'Zagorzyce'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.002837, longitude: 21.757700, options: {title: 'Olimpów'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.035315, longitude: 21.747457, options: {title: 'Iwierzyce'}, id: id++, icon: 'assets/img/water-sensor.png'
        }, {
            latitude: 50.019173, longitude: 21.676637, options: {title: 'Zagorzyce Górne'}, id: id++, icon: 'assets/img/rain-station.png'
        }, {
            latitude: 49.945675, longitude: 21.662576, options: {title: 'Nawsie Górne'}, id: id++, icon: 'assets/img/rain-station.png'
        }, {
            latitude: 49.987401, longitude: 21.507231, options: {title: 'Niedziedzia Górna'}, id: id++, icon: 'assets/img/rain-station.png'
        }, {
            latitude: 49.931082, longitude: 21.553746, options: {title: 'Brzeziny'}, id: id++, icon: 'assets/img/rain-station.png'
        }, {
            latitude: 49.984487, longitude: 21.726102, options: {title: 'Bystrzca'}, id: id++, icon: 'assets/img/rain-station.png'
        }


        ];



        //////////////////////////
        function getStations()
        {
            StationsFactory.getStations().then(function (data)
            {
                ctrl.stations = data;
            }).catch(function(err){
                console.log(err);
            });
        }

        function init()
        {
            // getStations();
            uiGmapGoogleMapApi.then(function (maps)
            {
                ctrl.map = {center: {latitude: 50.015294, longitude: 21.673048}, zoom: 11};
                ctrl.markersEvents = {
                click: function(marker, eventName, model){
                    // console.log('Marker clicked ',marker);
                    // console.log('Event clicked ',eventName);
                    // console.log('Model clicked ',model);
                    $location.path('/measure/'+model.options.title);
                }
            }
            });
        }

        //////////////////////
        init();

    }

    angular.module('monitoring').controller('MainViewController', MainViewController);


})();
