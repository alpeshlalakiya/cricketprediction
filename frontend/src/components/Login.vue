<template>
    <div id="login">
        <!--<h3 class="text-center text-white pt-5">Login form</h3>-->
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input v-model="username" type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input v-model="password" type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input v-on:click="login()" type="button" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var self;
    import { HTTP } from '../http-common';

    export default {
        name: 'Login',
        components: {

        },
        data() {
            return {
                username : '',
                password : '',
            }
        },
        watch : {

        },
        beforeMount: function () {
            self = this;
        },
        mounted: function () {

        },

        methods: {
            login: function () {
                var fields = {
                    username : self.username,
                    password : self.password,
                };
                var config = {
                    headers: {Authorization: "Bearer " + localStorage.getItem("api_token")}
                };
                HTTP.post("login", fields, config)
                    .then(function (response) {
                        return;
                    })
                    .catch(function (err) {
                        if (err.response.status == 0) {
                            self.error = "Remote server can not be reachable";
                        } else {
                            //redirect to login page if user not authenticated
                            if (err.response.status == 401) {
                                //clear previous data
                                localStorage.removeItem("user_obj");
                                localStorage.removeItem("api_token");
                                localStorage.removeItem("profile_image");
                                //EventBus.$emit("logged-in", true, "", "");
                                self.$router.push("/login");
                            }
                            self.error = err.response.data.message;
                        }
                    });

            },
        },

    }
</script>
