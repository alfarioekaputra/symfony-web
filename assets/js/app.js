import Vue from 'vue';

import Example from './components/Example';
import Category from './components/Category';

/**
 * create fresh vue instance
 */
new Vue({
    el: '#app',
    components: {Example, Category}
})