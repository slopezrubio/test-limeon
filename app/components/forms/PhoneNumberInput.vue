<template>
    <div class="row col s12 phone-number">
        <div class="input-field phone-number__select col s2">
            <select v-model="selected" name="prefixes" id="prefixes">
                <option v-for="(option, key) in prefixes" :value="key">{{ option.value }}</option>
            </select>
        </div>
        <div class="input-field col s10 phone-number__input">
            <input type="tel" id="icon_telephone" :value="input.default" :name="input.id" class="validate" :class="{ invalid: input.error !== '' }">
            <label :class="{ active: input.default !== '' }" for="icon_telephone">{{ input.placeholder }}</label>
            <span class="helper-text" :data-error="input.error"></span>
        </div>
    </div>
</template>

<script>
    import BasicSelector from "./BasicSelector.vue";

    export default {
        name: "PhoneNumberInput",
        components: {
            'basic-selector': BasicSelector
        },
        props: {
            input: Object,
        },
        computed: {
        },
        data() {
            return {
                selected: this.input.selectedPrefix ? this.input.selectedPrefix : Object.keys(this.prefixes)[0],
                selector: null,
                prefixes: {
                    fr: {
                        value: '+33',
                    },
                    es: {
                        value: '+34',
                    }
                }
            }
        },
        methods: {
            initSelect: function() {
                this.selector = this.$el.querySelector('select');
                M.FormSelect.init(this.selector);
            },
        },
        mounted() {
            this.initSelect();
        }
    }
</script>

<style lang="scss" scoped>
    .phone-number {
        &__select {
            padding-left: 0;
        }

        &__input {
            padding-right: 0;
        }
    }
</style>