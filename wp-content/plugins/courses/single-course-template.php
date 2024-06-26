<?php
get_header();

global $post;


if (!empty($post->post_content)) {
    ?>
    <div class="single-course-container">
        <div class="title"><?= $post->post_title; ?></div>
        <div class="content"><?= $post->post_content; ?></div>
    </div>
<?php }

get_footer();
