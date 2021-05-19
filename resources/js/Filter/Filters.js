import Vue from "vue";
import moment from "moment";

Vue.filter('time', function (input) {
    return moment(input).format('DD-MM-YYYY')
})
Vue.filter('slug', function (slug) {
    return slug.replace(/\s+/g, '-').toLowerCase();
});
Vue.filter('timeMoment', function (value) {
    return moment(value).startOf('minute').fromNow();
});
Vue.filter('subString', function (value, length) {
    return value.substring(0, length);
})
Vue.filter('StatusColorType', function (value) {
    const Status = {
        active: 'bg-success',
        inactive: 'bg-success'
    }
    return Status[value];
})
Vue.filter('Capitalize', function (String) {
    return String.charAt(0).toUpperCase() + String.slice(1);
})
// Mixin
Vue.mixin({
    methods: {
        confirm(callback) {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) callback()

            })
        }
    }
})
