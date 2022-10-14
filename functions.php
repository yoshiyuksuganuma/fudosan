<?php


/*
不要な項目を削除
====================================*/



/*
管理画面
---------------------- */
/** WordPressへようこそ!を削除 */
remove_action( 'welcome_panel', 'wp_welcome_panel' );

/** ウィジェットを削除 */
add_action( 'wp_dashboard_setup', 'remove_dashboard_widget' );

/** アクティビティ、クイックドラフト、WordPressニュースの削除 */
function remove_dashboard_widget() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}

/** コメント機能 */
add_filter( 'comments_open', '__return_false' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/style.css' );
}

/* 不要なtype属性削除 */
function html5_validation( $buffer ) {
	$buffer = preg_replace( '/\s?type=(\'|")text\/(javascript|css)(\'|")/is', '', $buffer );
	return $buffer;
}
function buf_start() {
    ob_start( 'html5_validation' ); }
    add_action( 'after_setup_theme', 'buf_start' );
function buf_end() {
	ob_end_flush(); }
add_action( 'shutdown', 'buf_end' );



/*
フロント,headタグ内
--------------------------- */

/** Emoji系 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/** OEmbed系 */
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/** Wp-json系 */
remove_action( 'wp_head', 'rest_output_link_wp_head' );

/** EditURI */
remove_action( 'wp_head', 'rsd_link' );

/** Wlwmanifest */
remove_action( 'wp_head', 'wlwmanifest_link' );

remove_action( 'wp_head', 'wp_resource_hints', 2 );

remove_action( 'wp_head', 'wlwmanifest_link' );

/** WordPressバージョン出力metaタグ非表示 */
remove_action( 'wp_head', 'wp_generator' );

/* パラメーターも */
function vc_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

/** Rel linkの削除 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


/* サムネイル有効化 */

add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );



/**
 * 
 * 
 * ファイル読み込み
 */

 

/* CSS&JS */

function add_files() {
	wp_enqueue_style( 'abobe-css',  'https://use.typekit.net/cmq7ypr.css', '', mt_rand() );
	wp_enqueue_style( 'main-css', get_template_directory_uri() . '/css/style.css', '', mt_rand() );
	wp_enqueue_style( 'slick-css',  'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', mt_rand() );
	wp_enqueue_style( 'slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css', mt_rand() );
	wp_deregister_script( 'jquery' );
	
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', '', '', true );
	wp_enqueue_script( 'slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', '', '', true );
	 
	wp_enqueue_script(
		'common-script',
		get_template_directory_uri() . '/js/script.js',
		'',
		mt_rand(),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'add_files' );




/*
get_terms 投稿タイプ縛り
---------------------------------*/

function hoge_terms_clauses( $clauses, $taxonomy, $args ) {
	if ( ! empty( $args['post_type'] ) ) {
		global $wpdb;
		$post_types = array();
		if ( $args['post_type'] ) {
			foreach ( $args['post_type'] as $cpt ) {
				$post_types[] = "'" . $cpt . "'";
			}
		}
		if ( ! empty( $post_types ) ) {
			$clauses['fields']  = 'DISTINCT ' . str_replace( 'tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields'] ) . ', COUNT(t.term_id) AS count';
			$clauses['join']   .= ' INNER JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
			$clauses['where']  .= ' AND p.post_type IN (' . implode( ',', $post_types ) . ')';
			$clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
		}
	}
	// print_r($clauses);exit;
	return $clauses;
}
add_filter( 'terms_clauses', 'hoge_terms_clauses', 10, 3 );



/**
 * パンクズjson
 */

function json_breadcrumb() {

	if ( is_admin() || is_home() || is_front_page() ) {
		return; }

	$position  = 1;
	$query_obj = get_queried_object();
	$permalink = ( empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$json_breadcrumb = array(
		'@context'        => 'http://schema.org',
		'@type'           => 'BreadcrumbList',
		'name'            => 'パンくずリスト',
		'itemListElement' => array(
			array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'item'     => array(
					'name' => 'HOME',
					'@id'  => esc_url( home_url( '/' ) ),
				),
			),
		),
	);

	if ( is_page() ) {

		$ancestors   = get_ancestors( $query_obj->ID, 'page' );
		$ancestors_r = array_reverse( $ancestors );
		if ( count( $ancestors_r ) != 0 ) {
			foreach ( $ancestors_r as $key => $ancestor_id ) {
				$ancestor_obj                         = get_post( $ancestor_id );
				$json_breadcrumb['itemListElement'][] = array(
					'@type'    => 'ListItem',
					'position' => $position++,
					'item'     => array(
						'name' => esc_html( $ancestor_obj->post_title ),
						'@id'  => esc_url( get_the_permalink( $ancestor_obj->ID ) ),
					),
				);
			}
		}
		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => esc_html( $query_obj->post_title ),
				'@id'  => $permalink,
			),
		);

	} elseif ( is_post_type_archive() ) {

		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => $query_obj->label,
				'@id'  => esc_url( get_post_type_archive_link( $query_obj->name ) ),
			),
		);

	} elseif ( is_tax() || is_category() ) {

		if ( ! is_category() ) {
			$post_type                            = get_taxonomy( $query_obj->taxonomy )->object_type[0];
			$pt_obj                               = get_post_type_object( $post_type );
			$json_breadcrumb['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'item'     => array(
					'name' => $pt_obj->label,
					'@id'  => esc_url( get_post_type_archive_link( $pt_obj->name ) ),
				),
			);
		}

		$ancestors   = get_ancestors( $query_obj->term_id, $query_obj->taxonomy );
		$ancestors_r = array_reverse( $ancestors );
		foreach ( $ancestors_r as $key => $ancestor_id ) {
			$json_breadcrumb['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'item'     => array(
					'name' => esc_html( get_cat_name( $ancestor_id ) ),
					'@id'  => esc_url( get_term_link( $ancestor_id, $query_obj->taxonomy ) ),
				),
			);
		}

		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => esc_html( $query_obj->name ),
				'@id'  => esc_url( get_term_link( $query_obj ) ),
			),
		);

	} elseif ( is_single() ) {

		if ( ! is_single( 'post' ) ) {
			$pt_obj                               = get_post_type_object( $query_obj->post_type );
			$json_breadcrumb['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'item'     => array(
					'name' => $pt_obj->label,
					'@id'  => esc_url( get_post_type_archive_link( $pt_obj->name ) ),
				),
			);
		}

		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => esc_html( $query_obj->post_title ),
				'@id'  => $permalink,
			),
		);

	} elseif ( is_404() ) {

		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => '404 Not found',
				'@id'  => $permalink,
			),
		);

	} elseif ( is_search() ) {

		$json_breadcrumb['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'item'     => array(
				'name' => '「' . get_search_query() . '」の検索結果',
				'@id'  => $permalink,
			),
		);

	}

	echo '<script type="application/ld+json">' . json_encode( $json_breadcrumb ) . '</script>';
}

add_action( 'wp_head', 'json_breadcrumb' );


 

function breadcrumb_func(){
	global $post;
	$str ='';
	$url = $http .'://'. $_SERVER["HTTP_HOST"] . htmlspecialchars($_SERVER["REQUEST_URI"], ENT_QUOTES, 'UTF-8');
	if(!is_home()&!is_admin()){
	  $str.= '<ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	  $str.= '<a href="'.home_url().'" itemprop="item"><span itemprop="name">'.'TOP'.'</span></a><meta itemprop="position" content="1" /></li>';
	  if( is_post_type_archive() ){
		$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.esc_html(get_post_type_object(get_post_type())->label ).'</span></a><meta itemprop="position" content="2" /></li>';
	  } elseif(is_tax()){
		$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_post_type_archive_link( get_post_type() ).'" itemprop="item"><span itemprop="name">'.esc_html(get_post_type_object(get_post_type())->label ).'</span></a><meta itemprop="position" content="2" /></li>';
		$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.single_term_title( '' , false ).'</span></a><meta itemprop="position" content="3" /></li>';
	  } elseif(is_tag()) {
		$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.single_tag_title( '' , false ).'</span></a><meta itemprop="position" content="2" /></li>';
	  } elseif(is_category()) {
		$cat = get_queried_object();
		if($cat -> parent != 0){
		  $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
		  foreach($ancestors as $ancestor){
			$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($ancestor).'" itemprop="item"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
		  }
		}
		$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.$cat-> cat_name.'</span></a><meta itemprop="position" content="3" /></li>';
	  } elseif(is_page()){
		if($post -> post_parent != 0 ){
		  $ancestors = array_reverse(get_post_ancestors( $post->ID ));
		  foreach($ancestors as $ancestor){
			$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'.get_the_title($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
			$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="3" /></li>';
		  }
		} else {
		  $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="2" /></li>';
		}
	  } elseif(is_single()){
		$categories = get_the_category($post->ID);
		$cat = $categories[0];
		if($cat -> parent != 0){
		  $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
		  foreach($ancestors as $ancestor){
			$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($ancestor).'" itemprop="item"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
		  }
		  $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($cat -> term_id).'" itemprop="item"><span itemprop="name">'.$categories[0]->cat_name.'</span></a><meta itemprop="position" content="3" /></li>';
		  $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="4" /></li>';
		} else {
		  $str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($cat -> term_id).'" itemprop="item"><span itemprop="name">'.$cat-> cat_name.'</span></a><meta itemprop="position" content="2" /></li>';
		  $str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="3" /></li>';
		}
	  }
	  $str.= '</ul>'."\n";
	}
	return $str;
  }
  add_shortcode('breadcrumb', 'breadcrumb_func');


function clm_breadcrumb_func(){
	global $post;
	$str ='';
	$url = $http .'://'. $_SERVER["HTTP_HOST"] . htmlspecialchars($_SERVER["REQUEST_URI"], ENT_QUOTES, 'UTF-8');
	if(!is_home()&!is_admin()){
		$str.= '<ul class="l-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList"><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
		$str.= '<a href="'.home_url().'" itemprop="item"><span itemprop="name">'.'TOP'.'</span></a><meta itemprop="position" content="1" /></li>';
		if( is_post_type_archive() ) {
			$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.esc_html(get_post_type_object(get_post_type())->label ).'</span></a><meta itemprop="position" content="2" /></li>';
		} elseif(is_tax()) {
			$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_post_type_archive_link( get_post_type() ).'" itemprop="item"><span itemprop="name">'.esc_html(get_post_type_object(get_post_type())->label ).'</span></a><meta itemprop="position" content="2" /></li>';
			$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.single_term_title( '' , false ).'</span></a><meta itemprop="position" content="3" /></li>';
		} elseif(is_tag()) {
			$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.single_tag_title( '' , false ).'</span></a><meta itemprop="position" content="2" /></li>';
		} elseif(is_category()) {
			$cat = get_queried_object();
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
				foreach($ancestors as $ancestor) {
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($ancestor).'" itemprop="item"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
				}
			}
			$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$url.'" itemprop="item"><span itemprop="name">'.$cat-> cat_name.'</span></a><meta itemprop="position" content="3" /></li>';
		} elseif(is_page()) {
			if($post -> post_parent != 0 ) {
				$ancestors = array_reverse(get_post_ancestors( $post->ID ));
				foreach($ancestors as $ancestor) {
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'.get_the_title($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
					$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="3" /></li>';
				}
			} else {
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="2" /></li>';
			}
		} elseif(is_single()) {
			$categories = get_the_terms($post->ID,'clm_category');
			$cat = $categories[0];
			if($cat -> parent != 0){
				$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'clm_category' ));
				foreach($ancestors as $ancestor){
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($ancestor).'" itemprop="item"><span itemprop="name">'.get_cat_name($ancestor).'</span></a><meta itemprop="position" content="2" /></li>';
				}
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_category_link($cat -> term_id).'" itemprop="item"><span itemprop="name">'.$categories[0]->cat_name.'</span></a><meta itemprop="position" content="3" /></li>';
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="4" /></li>';
			} else {
				$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_term_link($cat -> term_id).'" itemprop="item"><span itemprop="name">'.$cat-> name.'</span></a><meta itemprop="position" content="2" /></li>';
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.get_the_permalink().'" itemprop="item"><span itemprop="name">'.get_the_title().'</span></a><meta itemprop="position" content="3" /></li>';
			}
		}
		$str.= '</ul>'."\n";
	}
	return $str;
}
add_shortcode('breadcrumb', 'clm_breadcrumb_func');



function my_tiny_mce_before_init( $init_array ) {
    //グローバル変数の宣言
    global $allowedposttags;
    //エディタのビジュアル/テキスト切替でコード消滅を防止（自動整形無効化）
    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    //aタグ内ですべてのタグを仕様可能に
    $init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
    $init_array['indent']                  = true;
    //pタグの自動挿入を無効化
    $init_array['wpautop']                 = false;
    $init_array['force_p_newlines']        = false;
    //改行をbrタグに置き換える
    $init_arrafy['force_br_newlines']       = true;
    $init_array['forced_root_block']       = '';
    return $init_array;
}
add_filter( 'tiny_mce_before_init' , 'my_tiny_mce_before_init' );


function remove_tinymce_buttons( $buttons ) {
  $remove = array( 'wp_more', 'dfw','wp_adv','bullist','numlist' ,'blockquote'); // ここに削除したいものを記述
  return array_diff( $buttons, $remove );
}
add_filter( 'mce_buttons', 'remove_tinymce_buttons' );

// 通常アーカイブを有効にする
function post_has_archive( $args, $post_type ) {
    if ( 'post' == $post_type ) {
        $args['rewrite'] = true;
        $args['has_archive'] = 'post';
    }
    return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );
/* ---------- カスタム投稿タイプを追加 ---------- */
add_action( 'init', 'create_post_type' );

function create_post_type() {

  register_post_type(
    'topics',
    array(
      'label' => 'トピックス',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
	  'show_in_rest' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions'
      ),
    )
  );
  register_post_type(
    'property',
    array(
      'label' => '物件',
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
	  'show_in_rest' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'revisions'
      ),
    )
  );

  register_taxonomy(
    'news_category',
    'news',
    array(
	  'show_in_rest' => true,
      'hierarchical' => true,
      'update_count_callback' => '_update_post_term_count',
      'label' => 'ニュースカテゴリー',
      'singular_label' => 'ニュースカテゴリー',
      'public' => true,
      'show_ui' => true
    )
  );

  register_taxonomy(
    'news_tag',
    'news',
    array(
	'show_in_rest' => true,
      'label' => 'ニュースタグ',
      'hierarchical' => false,
      'public' => true,
    )
  );
}

//投稿タイトル入力欄のプレースホルダ変更
function change_default_title( $title ) {
	$screen = get_current_screen();
	if ( $screen->post_type == 'property' ) {
		  $title = 'ここに物件名を入力';
	}
	
	  return $title;
	}
	add_filter( 'enter_title_here', 'change_default_title' );

//管理画面から通常投稿削除
function unset_menu(){

	global $menu;
	unset($menu[5]); //投稿メニュー
	
	}
	
	add_action("admin_menu","unset_menu");

	//基本機能を追加
add_action('after_setup_theme', function () {
    add_theme_support('title-tag'); // tiltleタグの追加
    add_theme_support('post-thumbnails'); //サムネイル機能の追加
	add_theme_support( 'custom-logo' ); 
    register_nav_menus([//カスタムメニューを追加
        'global_nav' => 'グローバルナビゲーション',
        'footer_nav' => 'フッターメニュー',
        'global_nav_sp' => 'グローバルナビSP',
        'footer_nav_sp' => 'フッターメニューSP'
    ]);
    add_theme_support('widgets'); // ウィジェットの追加
});



//カスタムヘッダーを有効にする
$custom_header_defaults = array(
    'flex-height' => true,
    'flex-width' => true,
    'video' => true,
    'width' => 1800,
    'height' => 400,
    'header-text' => true, //ヘッダー画像上にテキストをかぶせる
    'admin-head-callback' => 'admin_header_style', //管理画面でヘッダープレビューをスタイリングするためのコールバックを指定
);
add_theme_support('custom-header', $custom_header_defaults);

function is_IE() {
    $ua = mb_strtolower( $_SERVER['HTTP_USER_AGENT'] );  //すべて小文字にしてユーザーエージェントを取得
    if ( strpos( $ua,'msie' ) !== false || strpos( $ua, 'trident' ) !== false ) {
        return true;
    }
    return false;
}

//カスタム投稿、投稿アーカイブページの並び順を変更
function change_posts_per_page($query)
{
    //管理画面,メインクエリに干渉しないために必須
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    //カスタム投稿「works」アーカイブページの表示件数を5件、ふりがなの昇順でソート
    if ($query->is_post_type_archive('news')) {
        $query->set('posts_per_page', '2');
        $query->set('order', 'DESC'); //昇順
        return;
    }
    if ($query->is_post_type_archive('カスタム投稿スラッグ名')) {
        $query->set('posts_per_page', '2');
        $query->set('order', 'DESC'); //昇順
        return;
    }
   
}
add_action('pre_get_posts', 'change_posts_per_page'); //pre_get_postsでメインクエリが実行される前のクエリを書き換える

//ページネーションのhtmlカスタマイズ、呼び出し
 function pagination() {
	$args = array (
		'prev_text' => '前へ',
		'next_text' => '次へ',
		'show_all' => false,
		'mid_size' => 3,
		'type' => 'list',
	);
	$pagination = get_the_posts_pagination( $args );
	$pagination = preg_replace( "/<h2[^>]*?>.*?<\/h2>/i", '', $pagination);
	$pagination = preg_replace( array("/<div[^>]*?>/i", "/<\/div>/i") , array('', ''), $pagination);
	echo  $pagination;
 }

 // 購読者がダッシュボードにアクセスできないようにする
add_action( 'auth_redirect', 'subscriber_go_to_home' );
function subscriber_go_to_home( $user_id ) {
    if ( !user_can( $user_id, 'edit_posts' ) ) {
        wp_redirect( get_home_url() );
    }
}

// 購読者のツールバーを非表示にする
add_action( 'after_setup_theme', 'subscriber_hide_admin_bar' );
function subscriber_hide_admin_bar() {
    if ( !current_user_can( 'edit_posts' ) ) {
        show_admin_bar( false );
    }
}

/**
 * ログイン処理をまとめた関数
 */
function my_user_login() {
    $user_name = isset( $_POST['user_name'] ) ? sanitize_text_field( $_POST['user_name'] ) : '';
    $user_pass = isset( $_POST['user_pass'] ) ? sanitize_text_field( $_POST['user_pass'] ) : '';

    // ログイン認証
    $creds = array(
        'user_login' => $user_name,
        'user_password' => $user_pass,
    );
    $user = wp_signon( $creds );

    //ログイン失敗時の処理
    if ( is_wp_error( $user ) ) {
        echo $user->get_error_message();
        exit;
    }

    //ログイン成功時の処理 
    wp_redirect( '/' );
    exit;

    return;
}

/**
 * after_setup_theme に処理をフック
 */
add_action('after_setup_theme', function() {
    if ( isset( $_POST['my_submit'] ) && $_POST['my_submit'] === 'login') {

        // nonceチェック
        if ( !isset( $_POST['my_nonce_name'] ) ) return;
        if ( !wp_verify_nonce( $_POST['my_nonce_name'], 'my_nonce_action' ) ) return;

        // ログインフォームからの送信があれば
        my_user_login();
    }
});