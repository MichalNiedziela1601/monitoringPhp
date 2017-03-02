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

        function checkAlarm(wartosc){
            if(wartosc >= parseInt(ctrl.tableResult.p_ostr) && wartosc < parseInt(ctrl.tableResult.p_alar)){
                return 'poziom_ostrz';
            } else if (wartosc >= parseInt(ctrl.tableResult.p_alar)){
                return 'poziom_alarm';
            } else {
                return null;
            }
        }

        function getWykresH(){
            Przekroj.getWykresH(ctrl.id).then(function(data){
                ctrl.wykresH = data;
            })
                .catch(function(error){
                    console.log(error);
                })
        }


        function init() {
            getImage();
            getTable();
            getWykresH();
        }


        function getWykresHwithDate1(){
            Przekroj.getWykresHwithDate(ctrl.id, ctrl.year,ctrl.month, ctrl.day, ctrl.hours, ctrl.minutes)
                .then(function(data){
                    ctrl.wykresH = data;
                })
        }

        function getWykresHwithDate(){
            console.log(ctrl.date);
            Przekroj.getWykresHwithDate(ctrl.id, ctrl.pickerBoth.date.getFullYear(),
                ctrl.pickerBoth.date.getMonth()+1, ctrl.pickerBoth.date.getUTCDate(),
                ctrl.pickerBoth.date.getHours(), ctrl.pickerBoth.date.getMinutes())
                .then(function(data){
                    ctrl.wykresH = data;
                })
        }

         ctrl.isOpen = false;

        ctrl.openCalendar = function(e, picker) {
            ctrl[picker].open = true;
        };

        ctrl.pickerBoth = {
            date: new Date(),
            timepickerOptions : {
                showMeridian: false
            },
            minus30: function () {
                var date = this.date.getTime() - 30*60*1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
            },
            minus1h: function () {
                var date = this.date.getTime() - 60*60*1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
            },
            plus30: function () {
                var date = this.date.getTime() + 30*60*1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
            },
            plus1h: function () {
                var date = this.date.getTime() + 60*60*1000;
                this.date = new Date(date);
                ctrl.getWykresHwithDate();
            }
        };
        // ctrl.pickerDate = {
        //     date: ctrl.date,
        //     datepickerOptions: {
        //         showWeeks: false,
        //         startingDay: 1,
        //         isOpen: false
        //
        //     },
        //     timepickerOptions: {
        //         readonlyInput: false,
        //         showMeridian: false,
        //         isOpen: false
        //     }
        // };
        //
        // ctrl.pickerTime = {
        //     date: ctrl.date,
        //     timepickerOptions: {
        //         readonlyInput: false,
        //         showMeridian: false
        //     }
        // };


        init();

        ctrl.checkAlarm = checkAlarm;
        ctrl.getWykresHwithDate = getWykresHwithDate;
        ctrl.getWykresHwithDate1 = getWykresHwithDate1;
    }

    angular.module('monitoring')
        .controller('MeasurePointController', MeasurePointController);


})();
