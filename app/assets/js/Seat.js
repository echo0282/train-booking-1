define(["jquery"], function($) {

    /**
     * This is the module which defines a seat
     * @author Laurence Hammond
     * @param options
     * @constructor
     */
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

    /**
     * Get ID
     * @returns {number}
     */
    Seat.prototype.getID = function() {
        return this.options.id;
    };

    /**
     * Get is vacant
     * @returns {boolean}
     */
    Seat.prototype.isVacant = function() {
        return this.options.vacant;
    };

    /**
     * Get is active
     * @returns {boolean}
     */
    Seat.prototype.isActive = function() {
        return this.options.active;
    };

    /**
     * Get position
     * @returns {string}
     */
    Seat.prototype.getPosition = function() {
        return this.options.position;
    };

    /**
     * Get is start of row
     * @returns {boolean}
     */
    Seat.prototype.isStartOfRow = function() {
        return this.options.startOfRow;
    };

    /**
     * Get is end of row
     * @returns {boolean}
     */
    Seat.prototype.isEndOfRow = function() {
        return this.options.endOfRow;
    };

    return Seat;
});