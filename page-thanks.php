<?php
/*
Template Name: コンタクトフォームのサンクスページ
*/
?>
<!-- 直打ち禁止のリファラチェック -->
<?php
$referer = $_SERVER["HTTP_REFERER"];
$url = 'contact';
if(!strstr($referer,$url)){
    header('refresh:5;url=contact');
 die("アクセスできません<br>５秒後にお問い合わせフォームへ移動します。");
 exit;
}
 ?>

<?php get_header(); ?>



<main>
<section class="section thanks-page">
    <div class="section__inner">
    <h1 class="thanks-page__tit"><?php the_title(); ?></h1>
    <p class="thanks-page__txt">
        ご入力いただいたメールアドレスに自動送信メールをお送り致しました。
    </p>
        <a  href="<?php echo esc_url( home_url( '/' ) ); ?>">トップに戻る</a>
    </div>
</section>
</main>

<?php get_footer();