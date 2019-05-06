import EventBus from '../components/event-bus';
import {HTTP} from '../http-common';
export default {
//module.exports = {
    data() {
        return {
            role: {
                id: '',
                name: '',
            },
            system_year: "",
            persmission: "null",
            isLoggedIn: false,
            isBackend: false,
        }
    },
    created() {
        /*console.log("mixin created");*/
    },
    beforeMount() {

    },
    mounted: function () {
        $("html, body").animate({scrollTop: 0}, 10);
    },
    methods: {
        getPermissions: function () {
            var self = this;
            var config = {
                headers: {Authorization: "Bearer " + localStorage.getItem("api_token")}
            };
            /*var fields = {
             
             };*/
            HTTP.post("user/permission", '', config)
                    .then(function (response) {
                        if (response.data.status == 'success') {
                            self.role.id = response.data.roles.id;
                            self.role.name = response.data.roles.name;
                            self.system_year = response.data.system_year;
                            EventBus.$emit('role', false, response.data.roles.id, response.data.roles.name, response.data.system_year);
                        }
                    })
                    .catch(function (err) {
                        if (err.response.status == 0) {
                            self.error = "Remote server can not be reachable";
                        } else {
                            //redirect to login page if user not authenticated
                            if (err.response.status == 401) {
                                localStorage.removeItem('user_obj');
                                localStorage.removeItem('api_token');
                                self.$router.push("/login");
                            }
                        }
                    });
        },
        MenuClose: function () {
            var self = this;
            $('#toggle').removeClass('active');
            $('#overlay').removeClass('open');
            $('.middle-menu').removeClass("menu-toggle")
            var expiry = localStorage.getItem("expiry");
            if (expiry != null) {
                if (new Date(expiry) < new Date()) {
                    self.logout();
                }
            } else {
                self.logout();
            }
        },
        checkLogin: function () {
            /* Check Login */
            var check = window.localStorage.getItem("api_token");
            if (check != null) {
                this.isLoggedIn = true;
            } else {
                this.$router.push("/login");
            }
            //console.log("Checking user session status")
            this.persmission = "data";
            return "data";
        },
        logout: function () {
            localStorage.clear();
            this.isBackend = false;
            this.$router.push("/login");
        },
    }
}