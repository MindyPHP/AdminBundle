import "./polyfills";

import "jquery-ui/ui/widget.js";
import "jquery-ui/ui/widgets/sortable.js";
// import './upload';

import $ from 'jquery';
window.$ = $;
import FastClick from 'fastclick';

import './mindy';
import './tab';
import './sorting';
import './product';
import './confirm';
import './file';
import './wysiwyg';

$(() => {
    FastClick.attach(document.body);
});
