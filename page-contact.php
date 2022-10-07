<?php
/*
Template Name: お問い合わせ
*/
?>
 <?php get_header(); ?>
 <?php echo breadcrumb_func(); ?>
    
<main>
    <section class="contact">
<?php echo do_shortcode('[contact-form-7 id="37" title="お問い合わせ"]'); ?>
    </section>
</main>

<? get_footer(); ?>
 

<!-- 
    contactform7 base
    
    <div class="contact__label-wrap">
 <label for="name">お名前</label><span class="contact__required">必須</span>
</div>
 [text* name_1 id:name]
<div class="contact__label-wrap">
 <label for="sex">性別</label><span class="contact__required">必須</span>
</div>
[radio sex id:sex use_label_element default:1 "男" "女"]
 <div class="contact__label-wrap">
 <label for="tel">お電話番号</label><span class="contact__required">必須</span>
 </div>[tel* tel id:tel]
<div class="contact__label-wrap">
 <label for="mail">メールアドレス</label><span class="contact__required">必須</span>
</div>
[email* mail id:mail]
 <div class="contact__label-wrap">
 <label for="qus">ご質問・不明点等</label>
</div>
 [textarea* qus id:qus]
[submit id:submit "送信"]
 -->