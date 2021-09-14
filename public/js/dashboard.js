/**
 * Reusable Toast
 * @param {*} delay_time
 * @param {*} div_color
 * @param {*} uid
 * @param {*} message
 * @param {*} status_code
 * @param {*} CSR_ER (defalut false)
 * @returns
 */
function HandleAjaxResponsesToast(delay_time, div_color, uid, message, status_code, CSR_ER = false, tclass = null) {


    var delay = delay_time;
    color = div_color;
    var toast_class = tclass;
    var toast =
        '<div id="location_toast_' + uid +
        '" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="' +
        delay + '" >' +
        '<div class="toast-header  ' + toast_class + '" style="background-color: ' +
        color +
        ' !important; color:#ffffff !important; "> <i class="bi bi-exclamation-square"></i>&nbsp;' +
        '<strong class="mr-auto">Message:</strong> <small>Just now</small>' +
        '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>' +
        '<div class="toast-body" id="toast_id_body' +
        uid + '">' + message +
        '</div> </div> </div>';
    //Informational responses (100–199)
    // Successful responses (200–299)
    // Redirects (300–399)
    // Client errors (400–499)
    // Server errors (500–599)
    //If the CSRF is mismatched use this script

    if (status_code > 99 && status_code < 600) {
        //logout url
        $("#dashboard_toast").append(toast);
        $('#location_toast_' + uid).toast("show");
        setTimeout(function () {
            $('#location_toast_' + uid)
                .remove();

        }, delay + 600);

        if (CSR_ER) {
            setTimeout(function () {
                window.location.href = '/logout';
                window.location.href = '/login';
            }, delay + 700);

        }

    }

    return toast;
}

/** Bootstrap popover 09-08-2021 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


/**
 * Get a random number max is the number your choose the range for
 * @param {*} max
 * @returns
 */
function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}
