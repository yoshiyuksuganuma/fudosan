
<?php get_header(); ?>
<main>

<!-- <ul class="slider" id="slider">
        <li class="slider__item"><img src="" alt="" /></li>
        <li class="slider__item"><img src="" alt="" /></li>
        <li class="slider__item"><img src="" alt="" /></li>
      </ul> -->

<!-- news -->
<section class="news">
<!-- ほしいカスタム投稿のデータを配列で指定 -->
<?php
	$args      = array(
	'post_type'   => 'news',
	'posts_per_page' => 4,
	'orderby'     => 'date',
	'post_status' => 'publish',
	'order'       => 'DESC', //昇順
);
//データを取得
$the_query = new WP_Query( $args );?>
 <h2 class="section__tit">NEWS</h2>
<?php if ( $the_query->have_posts() ) : ?>

	<?php
	while ( $the_query->have_posts() ) :
	$the_query->the_post(); 
	?>
	<article class="news__list">
		<a href="<?php the_permalink(); ?>" class="news__list-link">
			<p class="news__list-date">
				<time datetime="<?php echo get_the_date( 'Y.m.d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time>
			</p>

			<h3 class="news__tit">
					<?php
					the_title();
					?>
			</h3>
		</a>
	</article>
	<?php
		endwhile;
		wp_reset_postdata();
	?>
<?php endif; ?>

</section>
<!-- news END -->
</main>

<?php get_footer(); ?>