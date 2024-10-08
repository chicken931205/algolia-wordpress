<?php
/*
*
* Page Header template
*
*/
?>

<?php
$ht_page_for_posts = get_option( 'page_for_posts' );
if ( false != $ht_page_for_posts && ! is_front_page() ) :
	?>
	<div class="ht-pageheader">
	<div class="ht-container">

	<svg class="ht-pageheader__backicon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1025.4 1407"><path d="M16.2,406l320-384c12-14.7,28.3-22,49-22c20.7,0,37,7.3,49,22l320,384c17.3,20.7,20.3,43.3,9,68c-12,24.7-31.3,37-58,37 h-192v640h320c10.7,0,19,3.7,25,11l160,192c8,10,9.3,21.7,4,35c-5.3,12-15,18-29,18h-704c-9.3,0-17-3-23-9s-9-13.7-9-23V511h-192 c-26.7,0-46-12.3-58-37C-4.8,450-1.8,427.3,16.2,406z"/></svg>

		<a class="ht-pageheader__backlink" href="<?php echo esc_url( get_permalink( $ht_page_for_posts ) ); ?>"><?php printf( esc_html( 'Back to %s', 'knowall' ), esc_html( get_the_title( $ht_page_for_posts ) ) ); ?></a>

	</div>
	</div>
<?php endif; ?>
