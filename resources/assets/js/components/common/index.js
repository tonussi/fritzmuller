import Vue from 'vue';
import Card from './Card';
import Child from './Child';
import Button from './Button';
import Checkbox from './Checkbox';
import VueRecaptcha from 'vue-recaptcha';
import { HasError, AlertError, AlertSuccess } from 'vform';

// Components that are registered globally.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  VueRecaptcha
].forEach(Component => {
  Vue.component(Component.name, Component)
})
