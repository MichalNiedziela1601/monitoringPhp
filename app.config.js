(function(){
    'use strict';

    function config(uiGmapGoogleMapApiProvider,$compileProvider){
        $compileProvider.preAssignBindingsEnabled(true);
        uiGmapGoogleMapApiProvider.configure({
               key: 'AIzaSyCL-hXVIkk2-l82wKDWpoggVcXrjslm7Bo',
            v: '3.25', //defaults to latest 3.X anyhow
            libraries: 'geometry,visualization'
        });
    }

    angular.module('monitoring')
        .config( config);


})();
