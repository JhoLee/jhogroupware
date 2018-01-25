import Vue from 'vue';
import VueI18n from 'vue-i18n';

const data = require('./message.json');

// 언어설정
Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: 'ko', // 기본언어는 ko로 유지하지만 브라우저 언어를 체크해서 변경
    messages: data
});

// Vue
const app = new Vue({
    el: '#app',
    i18n: i18n,
    data: {},
    created() {
    },
    methods: {
        handleClick_changeLanguage(lang) {
            this.$i18n.locale = lang;
        }
    }
});