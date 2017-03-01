(function () {
    'use strict';
    function MeasurePointController($routeParams, Przekroj) {
        var ctrl = this;
        ctrl.id = $routeParams.id;

        function getImage() {
            Przekroj.getImage(ctrl.id).then(function (data) {
                ctrl.image = data;
            }).catch(function (error) {
                console.log(error);
            });
        }

        function dateResolver(date) {
            var d = new Date(date * 1000);
            console.log(d.getUTCDate());
        }

        function getTable() {
            Przekroj.getTable(ctrl.id)
                .then(function (result) {
                    ctrl.tableResult = result;
                    ctrl.tableResult.wyniki.map(function (obj, index) {
                        var wynik = parseInt(obj.wartosc);
                        if(index < 9) {
                            var delta = wynik - parseInt(ctrl.tableResult.wyniki[index + 1].wartosc);
                            obj.delta = delta;
                        }

                    })

                })
                .catch(function (error) {
                    console.log(error);
                })
        }


        function init() {
            getImage();
            getTable();
        }


        init();
    }

    angular.module('monitoring')
        .controller('MeasurePointController', MeasurePointController);


})();
