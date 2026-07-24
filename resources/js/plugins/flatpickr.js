import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/themes/airbnb.css";

document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".ajeng-datepicker", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        minDate: "today",
        disableMobile: "true"
    });

    flatpickr(".ajeng-timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        altInput: true,
        altFormat: "h:i K",
        disableMobile: "true"
    });
});