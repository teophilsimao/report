// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import hello from './js/hello.js';
import setCurrentYear from './js/year.js';
import fornav from './js/fornav.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
console.log(hello());
setCurrentYear();
fornav();
