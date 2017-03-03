(function () {
    "use strict";

    function PunktOpadowyController($routeParams, PunktOpad){
        var ctrl = this;
        ctrl.id = $routeParams.id;
        ctrl.isOpen = false;

        function getOpadInt() {
            PunktOpad.getOpadInt(ctrl.id).then(function (data) {
                ctrl.image = data;
            }).catch(function (error) {
                console.log(error);
            });
        }

        function getTable() {
            PunktOpad.getTable(ctrl.id)
                .then(function (result) {
                    ctrl.tableResult = result;
                    ctrl.tableResult.wyniki.map(function (obj, index) {
                        var wynik = parseFloat(obj.wartosc);
                        var przedzial = parseFloat(obj.przedzial);
                        if (index < 9) {
                            var intensywnosc = 60.0 * wynik/(przedzial < 1 ? 0.5 : przedzial);
                            obj.intensywnosc = intensywnosc;
                        }

                    })

                })
                .catch(function (error) {
                    console.log(error);
                })
        }
        
        

        function checkAlarm(wartosc) {
            if (wartosc >= parseInt(ctrl.tableResult.p_ostr) && wartosc < parseInt(ctrl.tableResult.p_alar)) {
                return 'poziom_ostrz';
            } else if (wartosc >= parseInt(ctrl.tableResult.p_alar)) {
                return 'poziom_alarm';
            } else {
                return null;
            }
        }

        function getTableWithDate(){
            PunktOpad.getTableWithDate(ctrl.id, ctrl.pickerBoth.date.getFullYear(),
                ctrl.pickerBoth.date.getMonth() + 1, ctrl.pickerBoth.date.getUTCDate(),
                ctrl.pickerBoth.date.getHours(), ctrl.pickerBoth.date.getMinutes())
                .then(function(result){
                    ctrl.tableResult = result;
                    ctrl.tableResult.wyniki.map(function (obj, index) {
                        var wynik = parseFloat(obj.wartosc);
                        var przedzial = parseFloat(obj.przedzial);
                        if (index < 9) {
                            var intensywnosc = 60.0 * wynik/(przedzial < 1 ? 0.5 : przedzial);
                            obj.intensywnosc = intensywnosc;
                        }

                    });
                })
        }

        function getWykresH() {
            PunktOpad.getWykresH(ctrl.id).then(function (data) {
                ctrl.wykresH = data;
            })
                .catch(function (error) {
                    console.log(error);
                })
        }

        function getWykresHwithDate() {
            PunktOpad.getWykresHwithDate(ctrl.id, ctrl.pickerBoth.date.getFullYear(),
                ctrl.pickerBoth.date.getMonth() + 1, ctrl.pickerBoth.date.getUTCDate(),
                ctrl.pickerBoth.date.getHours(), ctrl.pickerBoth.date.getMinutes())
                .then(function (data) {
                    ctrl.wykresH = data;
                })
        }

        function getWykresD() {
            PunktOpad.getWykresD(ctrl.id).then(function (data) {
                ctrl.wykresD = data;
            })
                .catch(function (error) {
                    console.log(error);
                })
        }

        function getWykresDwithDate() {
            PunktOpad.getWykresDwithDate(ctrl.id, ctrl.pickerBoth.date.getFullYear(),
                ctrl.pickerBoth.date.getMonth() + 1, ctrl.pickerBoth.date.getUTCDate(),
                ctrl.pickerBoth.date.getHours(), ctrl.pickerBoth.date.getMinutes())
                .then(function (data) {
                    ctrl.wykresD = data;
                })
        }


        ctrl.openCalendar = function (e, picker) {
            ctrl[picker].open = true;
        };
        
        ctrl.pickerBoth = {
            date: new Date(),
            timepickerOptions: {
                showMeridian: false
            },
            minus30: function () {
                var date = this.date.getTime() - 30 * 60 * 1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
                ctrl.getWykresDwithDate();

            },
            minus1h: function () {
                var date = this.date.getTime() - 60 * 60 * 1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
                ctrl.getWykresDwithDate();
            },
            plus30: function () {
                var date = this.date.getTime() + 30 * 60 * 1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
                ctrl.getWykresDwithDate();
            },
            plus1h: function () {
                var date = this.date.getTime() + 60 * 60 * 1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
                ctrl.getWykresDwithDate();
            }
        };

        function submit(){
            ctrl.getWykresHwithDate();
            ctrl.getWykresDwithDate();
            ctrl.getTableWithDate();
        }

        function minus30(){

            ctrl.pickerBoth.minus30();
            ctrl.getTableWithDate();
        }

        function minus1h(){
            ctrl.pickerBoth.minus1h();
            ctrl.getTableWithDate();
        }

        function plus30() {
            ctrl.pickerBoth.plus30();
            ctrl.getTableWithDate();
        }

        function plus1h(){
            ctrl.pickerBoth.plus1h();
            ctrl.getTableWithDate();
        }

        function now() {
            ctrl.getTable();
            ctrl.getWykresH();
            ctrl.getWykresD();
            ctrl.pickerBoth.date = new Date();
        }

        function init(){
            getOpadInt();
            getTable();
            getWykresD();
            getWykresH();
        }

        init();

        ctrl.getOpadInt = getOpadInt;
        ctrl.checkAlarm = checkAlarm;
        ctrl.getWykresHwithDate = getWykresHwithDate;
        ctrl.getTableWithDate = getTableWithDate;
        ctrl.getTable = getTable;
        ctrl.getWykresH = getWykresH;
        ctrl.getWykresD = getWykresD;
        ctrl.getWykresDwithDate = getWykresDwithDate;
        ctrl.minus30 = minus30;
        ctrl.minus1h = minus1h;
        ctrl.plus30 = plus30;
        ctrl.plus1h = plus1h;
        ctrl.now = now;
        ctrl.submit = submit;
    }

    angular.module('monitoring')
        .controller('PunktOpadowyController', PunktOpadowyController);

})();