<?php get_header(); ?>
<h1 class="archive__tit"><?php echo esc_html(get_post_type_object(get_post_type())->label); ?>一覧</h1>
<?php if (have_posts()) :
                              while (have_posts()) :
                                    the_post();
                        ?>


                                    <?php if (has_post_thumbnail()) :
                                          $thumbnailID = get_post_thumbnail_id($postID);
                                          $alt = get_post_meta($thumbnailID, '_wp_attachment_image_alt', true);
                                    ?>
                                          <li class="card__item mb-50">

                                               
                                          <?php endif; ?>
                                          <a href="<?php the_permalink(); ?>"><img class="card__img border" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $alt ?>">
                                          <h2 class="card__tit "><?php the_title(); ?></h2>
                                          </a>


                                          </li>
                              <?php
                              endwhile;
                        endif;
                              ?>

                  </ul>
              
                 <?php pagination(); ?>
                  <?php get_footer(); ?>