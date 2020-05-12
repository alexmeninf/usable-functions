<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
		<?php

			if( $terms = get_terms('product_cat', 'orderby=name' ) ) : // to make it simple I use default categories
				echo '<select name="categoryfilter"><option>All categories...</option>';
				foreach ( $terms as $term ) :
					echo '<option id="video-option" name="video-option" value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
				endforeach;
				echo '</select>';
      endif;
      
      // Adicione aqui os 3 select

		?>
		<?php wp_nonce_field( 'my_nonce' ); ?>
		<button>SEARCH</button>
		<input type="hidden" name="action" value="myfilter">
	</form>
<div id="response"></div>
<script type="text/javascript">
	jQuery(function($){
		$('#filter').submit(function(){
			var filter = $('#filter');
			$.ajax({
				url:filter.attr('action'),
				data:filter.serialize(), // form data
				type:filter.attr('method'), // POST
				beforeSend:function(xhr){
					filter.find('button').text('Pesquisando...'); // changing the button label
				},
				success:function(data){
					filter.find('button').text('SEARCH'); // changing the button label back
					$('#response').html(data); // insert data
				}
			});
			return false;
		});
	});
</script>



<?php 

// functions.php


function wines_search(){

  if (!check_ajax_referer( 'my_nonce' )){
  wp_die();
  }else{
    $args = array(
      'post_type' => 'vinho',
      'order' => $_POST['date'], 
      'tax_query' => array(
        array(
          'taxonomy' => 'product_cat',
          'field' => 'id',
          'terms' => $_POST['categoryfilter']  // Adicione aqui o post com as 3 categorias, tente usar array()
      )),
    );

  $query = new WP_Query( $args );

  if( $query->have_posts() ) :
    while( $query->have_posts() ): $query->the_post(); ?>
      <div class="item">
        <h2><?php the_title() ?></h2>
      </div>
<?php  
    endwhile;
    wp_reset_postdata();
  else :
    echo 'No posts found';
  endif;
  die();
  }
}

add_action('wp_ajax_myfilter', 'wines_search'); 
add_action('wp_ajax_nopriv_myfilter', 'wines_search');
