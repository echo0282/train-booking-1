define(["jquery"], function($) {

    function Seat(options) {
        this.options = {
            "id": 0,
            "active": false,
            "vacant": true,
            "position": "",
            "firstOfColumn": false,
            "endOfColumn": false,
            "startOfRow": false,
            "endOfRow": false
        };

        this.options = $.extend(this.options, options, {});
        Object.freeze(this); // Make immutable
    }

    Seat.prototype.getID = function() {
        return this.options.id;
    };

    Seat.prototype.isVacant = function() {
        return this.options.vacant;
    };

    Seat.prototype.isActive = function() {
        return this.options.active;
    };

    Seat.prototype.getPosition = function() {
        return this.options.position;
    };

    Seat.prototype.isStartOfRow = function() {
        return this.options.startOfRow;
    };

    Seat.prototype.isEndOfRow = function() {
        return this.options.endOfRow;
    };

    return Seat;
});