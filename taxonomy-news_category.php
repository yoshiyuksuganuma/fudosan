<?php get_header(); ?>

<h1 class=""><?php single_term_title(); ?>の一覧</h1>

<?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
							<article class="clm-list__posts">
								<a href="<?php the_permalink(); ?>" class="clm-list__link">
									<p class="clm-list__date">
										<time datetime="<?php echo get_the_date( 'Y.m.d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time>
									</p>
									<h2 class="clm-list__ttl"><?php the_title();?></h2>
								</a>
							</article>
                            <?php endwhile; else: ?>
            <p><?php echo "お探しの記事、ページは見つかりませんでした。"; ?></p>
            <?php endif; ?>

            <?php get_footer(); ?>