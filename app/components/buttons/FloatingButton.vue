<template>
    <header class="row header" :class="{ 'header--hidden': currentScroll == 0 }">
        <div class="container valign-wrapper">
            <a href="/actions/new" class="waves-effect waves-light btn col s3 m2"><i class="material-icons left">add</i>new</a>
            <span class="col s9 m10 right-align">Do you want to create another task?</span>
        </div>
    </header>
</template>

<script>
    export default {
        name: "floating-button",
        data() {
            return {
                currentScroll: 0
            }
        },
        methods: {
            setCurrentScroll: function(e) {
                this.currentScroll = window.scrollY;
            }
        },
        created() {
            window.addEventListener('scroll', this.setCurrentScroll);
        },
        destroyed() {
            window.removeEventListener('scroll', this.setCurrentScroll)
        }
    }
</script>

<style lang="scss" scoped>
    header.header {
        display: block;
        background: white;
        width: 100%;
        position: fixed;
        z-index: 100;
        -moz-transition: all ease-in-out .4s;
        -webkit-transition: all ease-in-out .4s;
        -o-transition: all ease-in-out .4s;
        opacity: 1;
        box-shadow: 1px 1px 10px 1px gray;

        &--hidden {
            display: none;
            opacity: 0;
        }

        .fixed-wrapper {
            position: fixed;
        }

        .btn {
            margin: 1em auto;
        }
    }
</style>