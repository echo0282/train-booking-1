define(["jquery", "SeatingPlan", "AjaxHandler"], function($, SeatingPlan, Handle) {

    /**
     * Entry point into the JS modules
     * @author Laurence Hammond
     * @param options
     * @constructor
     */
    function TrainBooking(options) {
        this.options = $.extend(options, this.options, {});
        this.choices = [];

        this.init();
    }

    TrainBooking.prototype.init = function() {
        var _this = this;

        return $.when(
            this.getTrainConfig(),
            this.getBookings()
        ).done(
            function(config, bookings) {
                var bookingsArray = [];

                if (bookings) {
                    if (bookings.bookings) {
                        for (var i = 0; i < bookings.bookings.length; i++) {
                            if (bookings.bookings[i].seatNumbers) {
                                for (var j = 0; j < bookings.bookings[i].seatNumbers.length; j++) {
                                    bookingsArray.push(bookings.bookings[i].seatNumbers[j]);
                                }
                            }
                        }
                    }
                }

                var options = {
                    "cols": config.cols,
                    "inactive": config.inactive,
                    "bookings": bookingsArray
                };

                new SeatingPlan(options);

                _this.addSeatListeners();
                _this.addSubmitListener();
            },
            function () {}
        );
    };

    TrainBooking.prototype.getTrainConfig = function() {
        var handle = new Handle($);
        handle.setURL("/config");
        return handle.get();
    };

    TrainBooking.prototype.getBookings = function() {
        var handle = new Handle($);
        handle.setURL("/get");
        return handle.get();
    };

    TrainBooking.prototype.addSeatListeners = function() {
        var seats = document.querySelectorAll(".seat");

        for (var i = 0; i < seats.length; i++) {
            seats[i].addEventListener("click", onClick.bind(this));
        }

        function onClick(e) {
            var element = e.target,
                seatNo = element.getAttribute('data-seat-id');

            if ($(element).hasClass('active')) {
                if ($(element).hasClass('selected')) {
                    var index = this.choices.indexOf(seatNo);

                    if (index > -1) {
                        this.choices.splice(index, 1);
                    }

                    element.classList.remove('selected');
                } else if ($(e.target).hasClass('vacant')) {
                    if (this.choices.length < 5) {
                        element.classList.add('selected');
                        this.choices.push(seatNo);
                    }
                }
            }
        }
    };

    TrainBooking.prototype.addSubmitListener = function() {
        var submit = document.querySelector('.train-booking_submit');

        submit.addEventListener("click", onClick.bind(this));

        function onClick() {
            var handle = new Handle($);
            handle.setURL("/post");
            handle.post({"choices": this.choices});
            this.init();
        }
    };

    return TrainBooking;
});