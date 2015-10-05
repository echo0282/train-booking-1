define(function () {

    /**
     * This is the AJAX handler
     * @author Laurence Hammond
     * @param handle
     * @constructor
     */
    function AjaxHandler(handle) {
        this.handle = handle;
        this.url = "";
        this.params = [];
    }

    /**
     * Query the AJAX endpoint with the handler
     * @returns {*}
     */
    AjaxHandler.prototype.get = function() {
        var deferred = new this.handle.Deferred(),
            _this = this;

        this.handle.ajax({
                dataType: "json",
                url: this.buildURL(),
                success: onResponse,
                error: onError
            }
        );

        /**
         * Return a successful promise
         * @param response
         */
        function onResponse(response) {
            deferred.resolve(response);
        }

        /**
         * Return a rejected promise
         * @param response
         */
        function onError(response) {
            deferred.reject(_this.createGenericErrorResponse(response));
        }

        return deferred.promise();
    };

    /**
     * Post data using the handler
     *
     * @param data
     * @returns {*}
     */
    AjaxHandler.prototype.post = function(data) {
        var deferred = new this.handle.Deferred(),
            _this = this;

        this.handle.ajax({
            type: "POST",
            url: this.buildURL(),
            data: data,
            success: onResponse,
            error: onError
        });

        /**
         * Return a successful promise
         * @param response
         */
        function onResponse(response) {
            deferred.resolve(response);
        }

        /**
         * Return a rejected promise
         * @param response
         */
        function onError(response) {
            deferred.reject(_this.createGenericErrorResponse(response));
        }

        return deferred.promise();
    };

    /**
     * Set any parameters required for the endpoint
     * @param params
     */
    AjaxHandler.prototype.setParams = function(params) {
        this.params = params;
    };

    /**
     * Set URL
     * @param url
     */
    AjaxHandler.prototype.setURL = function(url) {
        this.url = url;
    };

    /**
     * Build the URL
     * @returns {*}
     */
    AjaxHandler.prototype.buildURL = function() {
        if (this.params.length === 0) {
            return this.url;
        }

        return this.url + "?" + this.params.join("&");
    };

    /**
     * Create a generic error response
     * @returns {{status: number, error: string}}
     */
    AjaxHandler.prototype.createGenericErrorResponse = function(response) {
        return {
            "status": response.status,
            "code": 1, // app specific code
            "error": "There was a problem retrieving the data",
            "responseText": response.responseText
        };
    };

    return AjaxHandler;
});