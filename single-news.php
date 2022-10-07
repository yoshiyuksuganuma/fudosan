

<?php
     get_header();
?>

<main>

          <?php echo breadcrumb_func(); ?>

          <?php
				//ターム名を取得
				$terms = get_the_terms($post->ID, 'news_category');
				?>
				<?php if(!empty($terms)): ?>
				<?php foreach( $terms as $term ) : ?>
				<li><a href="<?php echo get_term_link($term->slug,'news_category'); ?>"><?php echo $term->name; ?></a></li>
				<?php endforeach; ?>
				<?php endif; ?>
			    <?php
				//ターム名を取得
				$tags = get_the_terms($post->ID, 'news_tag');
				?>
				<?php if(!empty($tags)):?>
				<?php foreach( $tags as $tag ) : ?>
				<li><?php echo $tag->name; ?></li>
				<?php endforeach; ?>
				<?php endif; ?>
     
                         <time datetime="<?php echo get_the_date( 'Y.m.d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time>
                       
                    <h2 class="news-info-top__ttl"><?php the_title();?></h2>
           
         <?php if (have_posts()): ?>
               <?php while (have_posts()) : the_post(); ?>
                    <div class="news-content">
                         <?php remove_filter('the_content', 'wpautop');?>
                         <?php the_content();?>
                    </div>
                   
               <?php endwhile; ?>
               <?php endif; ?>
     <?php 
     $prev_post = get_previous_post(); 
     $next_post = get_next_post(); 
     if( $prev_post || $next_post ): 
     ?>
     <div class="page-nav">
          <?php if( $prev_post ): // 前の投稿があれば表示 ?>
          <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="prev-link">
          <?php echo get_the_title( $prev_post->ID ); ?>
          </a>
          <?php endif; ?>
          <?php if( $next_post ): // 次の投稿があれば表示 ?>
               <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next-link">
               <?php echo get_the_title( $next_post->ID ); ?>
               </a>
          <?php endif; ?>
          </div>
          <?php endif; ?>
          <a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>" class="post__archive-back">一覧へ戻る</a>

     </div>
     <!-- ./inner -->
</section>

</main>


<?php get_footer(); ?>