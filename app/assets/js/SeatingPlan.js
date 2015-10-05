define(["jquery", "handlebars", "Seat"], function($, Handlebars, Seat) {

    /**
     * This is the module which configures the seating plan
     * @author Laurence Hammond
     * @param options
     * @constructor
     */
    function SeatingPlan(options) {
        this.hb = Handlebars;
        this.options = {
            "cols" : [{
                "position": "left",
                "perRow": 3,
                "rows": 13
            }, {
                "position": "right",
                "perRow": 2,
                "rows": 14
            }],
            "bookings": [],
            "inactive": []
        };
        this.options = $.extend(this.options, options, {});
        console.log(this.options);

        this.init();
        this.createSeatingMap();
    }

    /**
     * Init function
     */
    SeatingPlan.prototype.init = function() {
        this.seats = {};
        var counter = 1;

        // Much looping...
        for (var i = 0; i < this.options.cols.length; i++) {
            var position = this.options.cols[i].position;
            this.seats[position] = [];

            for (var j = 0; j < this.options.cols[i].rows; j++) {
                for (var k = 0; k < this.options.cols[i].perRow; k++) {

                    this.seats[position].push(new Seat({
                        "id": (counter),
                        "active": (this.options.inactive.indexOf((counter).toString()) !== -1? false: true),
                        "vacant": (this.options.bookings.indexOf((counter).toString()) !== -1? false: true),
                        "position": position,
                        "startOfRow": (k === 0),
                        "endOfRow": ((k + 1) === this.options.cols[i].perRow)
                    }));

                    counter++;
                }
            }
        }
    };

    /**
     * Create the seating map
     */
    SeatingPlan.prototype.createSeatingMap = function() {
        var _this = this,
            tb = document.querySelector(".train-booking"),
            tbHbs = document.querySelector(".train-booking__seats-display");

        tb.innerHTML = "";

        Object.keys(this.seats).forEach(function(key) {
            tb.innerHTML += _this.hb.compile(tbHbs.innerHTML)(_this.seats[key]);
        });
    };

    return SeatingPlan;
});