<?php
/**
 * Post Loop Template Part of Katawara
 *
 * @package katawara
 */

get_template_part( 'template-parts/post/loop-layout', 'card' );

/*
======================
Post Type Template
======================
If you set the file name as follows, you can create your original layout for each post type.

loop-[post-type-slug].php


======================
Use components sample
======================
You can use several variation post layout by VK_Component_Posts.
See follow sample code.
*/

// get_template_part( 'template-parts/post/loop-layout', 'use-component-sample' );.
