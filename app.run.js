/**
 * Created by sunday on 2/21/17.
 */
(function(){
    'use strict';
    function run(StationsFactory, $localStorage){
        StationsFactory.getStations().then(function(data){
           $localStorage.$default({
               stations: data
           })
       })
        
    }
    angular.module('monitoring')
        .run(run);
    
    
})();