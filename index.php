
<?php get_header(); ?>
<main>
<div id="overlay"></div>

	<div class="fv" id="fv">
		<div class="fv__main-visual">
			<ul class="fv__slider" id="fv__slider">
				<li class="fv__slider-item"><img src="<?php echo get_template_directory_uri();?>/img/top/kv-img-pc.jpg" alt="" /></li>
				<!-- <li class="fv__slider-item"><img src="<?php echo get_template_directory_uri();?>/img/top/kv-img-pc.jpg" alt="" /></li>
				<li class="fv__slider-item"><img src="<?php echo get_template_directory_uri();?>/img/top/kv-img-pc.jpg" alt="" /></li> -->
			</ul>
		</div>
	<!-- end of fv__main-visual -->
		<div class="fv__lead-wrap">
			<h2 class="fv__lead">
				<p class="fv__lead--small">デザインで人を笑顔にする会社<br>DIGSMILE INC.</p>
				DESIGN<br>
				FOR<br>
				SMILE.<br>
			</h2>
		</div>
	<!-- end of fv__lead-wrap -->
	</div>
	<!-- end of fv -->

	<?php if( !is_user_logged_in() ) : //ユーザーがログインしていなかったらログインフォームを表示 ?>
	<div class="login-form">
		<h3 class="login-form__tit">会員限定ページ</h3>
		<p>会員様限定の物件を掲載中</p>
		<p>会員登録を希望される方は、<span>お問い合わせフォーム</span>より、会員登録希望を記述の上お問い合わせください。</p>
		<form  name="my_login_form" id="my_login_form" action="" method="post">
		<div>
			<label for="login_user_name">ユーザ名</label>
			<input id="login_user_name" name="user_name" type="text" required>
		</div>
		<div>
			<label for="login_password">パスワード</label>
			<input id="login_password" name="user_pass" id="user_pass" type="password" required>
		</div>
		<button class="link-btn" type="submit" name="my_submit" class="my_submit_btn" value="login">ログイン</button>
		<p class="my_forgot_pass">
			<a href="/wp-login.php?action=lostpassword">パスワードを忘れた方はこちらから</a>
		</p>
		<?php wp_nonce_field( 'my_nonce_action', 'my_nonce_name' );  //nonceフィールド設置 ?>
		</form>
	</div>
	<!-- end of login-form -->
	<?php endif; ?>


	<section class="section about">
		<div class="section__inner">
		<div class="about__lead">
			<h2 class="section__tit">ABOUT US</h2>
			<p class="section__txt">DIGSMILEは、デザインで人を笑顔にする会社。<br>
				なんでもない日常に少しのワクワクと遊び心を提供します。笑顔には世界を変える力がある、デザインには人を幸せにする力がある。毎日に幸せを感じて生きていきたい。<br>
				DIGSMILEの社名にはそんな想いが込められています。
			</p>
			<a href="/" class="link-btn">READ MORE</a>
		</div>
		</div>
	</section>
	<!-- end of about -->

	<section class="section works-culture">
		<div class="section__inner">
		<div class="works">
			<h2 class="section__tit">WORKS</h2>
			<img src="<?php echo get_template_directory_uri() ?>/img/top/works-img.jpg" alt="">
			<p class="section__txt">DIGSMILEの制作実績を紹介します。</p>
			<a href="/" class="link-btn">READ MORE</a>
		</div>
	<!-- end of works -->
		<div class="culture">
			<h2 class="section__tit">CULTURE</h2>
			<img src="<?php echo get_template_directory_uri() ?>/img/top/culture-img.jpg" alt="">
			<p class="section__txt">DIGSMILEの社内文化について紹介します。</p>
			<a href="/" class="link-btn">READ MORE</a>
		</div>
	<!-- end of culture -->
		</div>
	</section>
	<!-- end of works-culture -->

	<section class="section property">
		<div class="section__inner">
	<!-- カスタム投稿propertyのデータを配列で指定 -->
	<?php
		$args      = array(
		'post_type'   => 'property',
		'posts_per_page' => 3,
		'orderby'     => 'date',
		'post_status' => 'publish',
		'order'       => 'DESC', //昇順
	);
	//propertyデータを取得
	$the_query = new WP_Query( $args );?>
	<h2 class="section__tit">PROPERTY LIST</h2>
	<div class="property__inner">
	<?php if ( $the_query->have_posts() ) : ?>

		<?php
		while ( $the_query->have_posts() ) :
		$the_query->the_post(); 
		?>
			<a href="<?php the_permalink(); ?>" >
			<div class="property__content-block">
				<?php if (has_post_thumbnail()) :
					$thumbnailID = get_post_thumbnail_id($postID);
					$alt = get_post_meta($thumbnailID, '_wp_attachment_image_alt', true); ?>
						<?php if( !is_user_logged_in() ) : //ユーザーが未ログイン時の画像処理 ?>
								<?php $terms = get_the_terms($post->ID, 'sales'); ?>
								<?php if($terms[0]->slug == 'only_member') : //only_memberのタームがついた記事はモザイク処理をする ?>
								<img class="property__<?php echo $terms[0]->slug; ?>-mosaic" src="<?php the_post_thumbnail_url(); ?>" alt="$alt">
								<?php else : //only_memberがついていない記事は通常表示 ?>
								<img  src="<?php the_post_thumbnail_url(); ?>" alt="$alt">
								<?php endif; ?>
						<?php else: //ログイン時は通常表示 ?>
							<img  src="<?php the_post_thumbnail_url(); ?>" alt="$alt">
						<?php endif; ?>
				<?php endif; ?>
			 
				<div class="property__desc">
					<div class="property__term-wrap">
					<?php
					// 記事に紐付いた'series'タクソノミーを取得、全タームを表示
					$terms = get_the_terms($post->ID, 'series');
					if ($terms) : ?>
						<?php foreach ($terms as $term) : ?>
							<span class="property__term-series"><?php echo $term->name; ?></span>
						<?php endforeach; ?>	
					<?php endif; ?>
					<!-- <br> -->
					<?php
					// 記事に紐付いた'sales'タクソノミーを取得、全タームを表示
					$terms = get_the_terms($post->ID, 'sales');
					if ($terms) : ?>
						<?php foreach ($terms as $term) : ?>
							<span class="property__<?php echo $term->slug; ?> property__term-sales"><?php echo $term->name; ?></span>
						<?php endforeach; ?>	
					<?php endif; ?>
					</div>
				
					<h2 class="property__tit">
						<?php the_title();?>
					</h2>
					<dl>
						<?php // 各カスタムフィールドのラベル名、入力値を表示 ?>
						<dt><?php echo get_field_object('address')['label']; ?></dt>
						<dd><?php the_field('address'); ?></dd><br>
						<dt><?php echo get_field_object('land-area')['label']; ?></dt>
						<dd><?php the_field('land-area'); ?>&#13217;</dd><br>
						<dt><?php echo get_field_object('floor-plan')['label']; ?></dt>
						<dd><?php the_field('floor-plan'); ?></dd>
					</dl>
				</div>
			</div>
			<!-- end of property__content-block -->
			</a>
		<?php
			endwhile;
			wp_reset_postdata();
		?>
	<?php endif; ?>
		</div>
		
		</div>
		<!-- end of property__content-block -->
		 
		</div>
	</section>
	<!-- end of property -->

	<section class="section topics">
		<div class="section__inner">
		<!-- カスタム投稿topicsのデータを配列で指定 -->
		<?php
			$args      = array(
			'post_type'   => 'topics',
			'posts_per_page' => 3,
			'orderby'     => 'date',
			'post_status' => 'publish',
			'order'       => 'DESC', //昇順
		);
		//topicsデータを取得
		$the_query = new WP_Query( $args );?>
		<h2 class="section__tit">LATEST TOPICS</h2>
		 
		<?php if ( $the_query->have_posts() ) : ?>
		<div class="topics__list">
		<?php
		while ( $the_query->have_posts() ) :
		$the_query->the_post(); 
		?>
			<a href="<?php the_permalink(); ?>" class="topics__list-link">
				<p class="topics__date">
					<time datetime="<?php echo get_the_date( 'Y.m.d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time>
				</p>
				<h2 class="topics__tit">
					<?php the_title(); ?>
				</h2>					
			</a>
		<?php
			endwhile;
			wp_reset_postdata();
		?>
	   <?php endif; ?>
		</div>
		<!-- end of topics-list -->
		<a href="/" class="link-btn">READ MORE</a>
		</div>
	</section>
	<!-- end of topics -->

	<section class="section contact">
		<div class="section__inner">
			<div class="contact__lead">
			<h2 class="section__tit">CONTACT</h2>
			<p class="section__txt">
				制作の依頼、取材の依頼、IRや採用についての連絡・お問い合わせはコンタクトページから承っております。<br>
				まずはお気軽にご連絡ください。担当者から改めて返信いたします。
			</p>
			<a href="/" class="link-btn">READ MORE</a>
			</div>
			<img src="<?php echo get_template_directory_uri() ?>/img/top/recruit-img.jpg" alt="contact">
		</div>
	</section>
	<!-- end of contact -->

</main>

<?php get_footer(); ?>