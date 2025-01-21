<?php
/**
* Template Name: privacy
 */

get_header();
?>

<!--Табы Кнопки-->
<section class="f fac gap8 f_f tab_buttons">
    <a href="https://vol-k.fun" id="" class="btn_tab pad8t pad8b">
            <span class="tab_chapter">
                Редагування
            </span>
        <img class="tab_img" src="<?php echo get_template_directory_uri(); ?>/img/tab7.png" alt="">
    </a>
</section>
<!--Время-->
<section class="f gap8 fac">
    <span id="currentDateTime">

    </span>
</section>
<!--Таб 1 (ОФОРМЛЕНИЕ)-->
<section class="f fc gap60">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'cup_theme' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'cup_theme' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

</section>

<?php
get_footer();
?>

