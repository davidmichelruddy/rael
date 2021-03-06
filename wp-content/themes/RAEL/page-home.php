<?php
/**
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php
$query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => '348', 'post', 'posts_per_page' => '4','order' =>'ASC' ) ); 
if ( $query->have_posts() ) {
  $i=0;
  $feature_buttons='<div id="feature_buttons" class="row hidden-xs hidden-sm">';
?>
<div id="feature_box" class="row">
  <div id="feature_carousel" class="carousel carousel slide col-md-12" data-interval="10000">
    <!-- Indicators -->
    <ol class="carousel-indicators hidden-md hidden-lg">
      <li data-target="#feature_carousel" data-slide-to="0" class="carousel-indicator active"></li>
      <li data-target="#feature_carousel" data-slide-to="1" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="2" class="carousel-indicator"></li>
      <li data-target="#feature_carousel" data-slide-to="3" class="carousel-indicator"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<?php	
while ( $query->have_posts() ) { 
  $query->the_post(); 
	if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  } else $imgurl="";

?>      

      <div class="item background-carousel<?php if($i==0) echo " active"; ?>" style="background-image:url(<?php echo $imgurl; ?>);">
        <!-- <img src="http://erg.berkeley.edu/wp2013/wp-content/uploads/2013/08/DSC1211-2048.jpg" alt="1"> -->
        <div class="carousel-caption ">
          <h3 class="visible-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?> </a></h3>
          <p class="hidden-xs"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_content($post->ID); ?></a></p>
          <span class="read_more_link"><a href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a></span>
        </div>
        <div class="carousel_bottom">&nbsp;</div>
      </div>

<?php 
  $feature_buttons.='<div id="feature'.$i.'" class="col-sm-3 feature_button';
  if($i==0) $feature_buttons.=' active';
  $feature_buttons.=' data-target="#feature_carousel" data-slide-to="'.$i.'"><a href="'. get_permalink($post->ID) .'"><div class="feature_button_content">';
  if($thumbnail=get_post_meta($post->ID,'thumbnail',true)) $feature_buttons.='<div class="thumbnail" style="background-image:url('.$thumbnail.');"></div>';
  $feature_buttons.='<span class="title">'. get_the_title($post->ID) .'</span><span class="blurb">'. get_the_excerpt() .'</span>';
  $feature_buttons.='</a></div></div>';
  $i++;
}
$feature_buttons.='</div>'; 
?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#feature_carousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#feature_carousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
<?php echo $feature_buttons; ?>
</div>
<?php } else { ?>
	<div class="alert alert-danger">Content not found.</div>
<?php } wp_reset_postdata(); ?>
<div id="thefold" class="row">&nbsp;</div>
<div id="belowthefold" class="row">
      <?php
        $query = new WP_Query( array( 'post_type' => 'page', 'post_parent' => $post->ID, 'posts_per_page' => '-1', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'menu_order' ));
        if ( $query->have_posts() ) {
          $i=1;
        	while ( $query->have_posts() ) {
        		$query->the_post();
            if($i==1) {
              echo '<div id="top_welcome" class="row ">';
              // echo '<h'.$i.' class="section_heading">'. get_the_title($post->ID) .'</h'.$i.'>';
            	echo '</div>';
              echo '<div class="col-sm-8 col-md-9">';
              echo '<div class="row"><div id="welcome" class="col-md-8 col-md-push-4 col-lg-6 col-lg-push-6 content">';
              echo '<div class="section ">';
          		echo '<h2 class="section_heading">'. get_the_title($post->ID) .'</h2>';
          		the_content();
            	echo '</div>';
            }
            else {
              echo '<div class="section ">';
          		echo '<h2 class="section_heading">'. get_the_title($post->ID) .'</h2>';
          		the_content();
              echo '</div>';
            }
          	$i++;
        	}
          // echo '</div>';
        } else { ?>
        	<div class="alert alert-danger">Content not found.</div>
        <?php }
        wp_reset_postdata();
      ?>
    </div>
    
    <div class="col-lg-6 col-lg-pull-6 hidden-md">
      <div class="row">

      <div id="news_cols" class="col-lg-6 content">
        <h3 class="section_heading">News</h3>
            <?php
              // category__not_in is 'spotlight'
              $query = new WP_Query( array( 'category_name' => 'news', 'category__not_in' => array( 6 ), 'posts_per_page' => '4' ));
              if ( $query->have_posts() ) {
              	while ( $query->have_posts() ) {
              		$query->the_post(); 
            ?>
              		<div <?php post_class("post_preview news_item"); ?>><h5 class="post_title"><a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h4>
              		  <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?></time> 
                    <p>
                  		<?php echo get_the_excerpt(); ?>
                  		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
                    </p>                  
              		</div>
            <?php }
              } else { ?>
              	<div class="alert alert-danger">Content not found.</div>
              <?php }
              wp_reset_postdata();
            ?>
      </div>
      <div id="events_cols" class="col-lg-6 content">
        <h3 class="section_heading">Events</h3>
            <?php 
            $args = array(
              'post_status'=>'publish',
              'post_type'=>array(TribeEvents::POSTTYPE),
              'posts_per_page'=>4,
              //order by startdate from newest to oldest
              'meta_key'=>'_EventStartDate',
              'orderby'=>'_EventStartDate',
              'order'=>'DESC',
              //required in 3.x
              'eventDisplay'=>'custom'
              //query events by category
              // 'tax_query' => array(
              //     array(
              //         'taxonomy' => 'tribe_events_cat',
              //         'field' => 'slug',
              //         'terms' => 'featured',
              //         'operator' => 'IN'
              //     ),
              // )
            );
            $get_posts = null;
            $get_posts = new WP_Query();

            $get_posts->query($args);
            if($get_posts->have_posts()) : while($get_posts->have_posts()) : $get_posts->the_post();

						if( tribe_get_start_date($post->ID, true, 'U')-strtotime('now') < 86400) {
							if( tribe_get_end_date($post->ID, true, 'U') < strtotime('now') ) $eventstatus="passed"; // event is over
							elseif( tribe_get_start_date($post->ID, true, 'U') < strtotime('now')) $eventstatus="now"; // event is happening now
							else /*if( tribe_get_start_date($post->ID, true, 'Ymdhi') <= date('Ymdhi', time('now')) )*/ $eventstatus="soon"; // event is upcoming within the next 24 hours
						}
						else $eventstatus="future";
          ?>
          <div class="post_preview event_item event_<?php echo $eventstatus; ?>">
            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?><?php if($eventstatus!="future") echo '<span class="event_status">('. $eventstatus .')</span>'; ?></div>
              <p>
            		<?php echo get_the_excerpt(); ?>
            		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
              </p>                  
          </div>
            <?php
              endwhile;
              endif;
              wp_reset_query();
            ?>        
      </div>
    </div>
    <div class="row">
    <button id="link_to_news_page" type="button" class="btn btn-link btn-block">
      <a href="./news-events/">Go to the News &amp; Events Page <span class="glyphicon glyphicon-chevron-right"></span></a>
    </button>
  </div>
  </div>
      <div id="news_tabs" class=" col-md-4 col-md-pull-8 hidden-xs hidden-sm visible-md hidden-lg hidden-xl">
        <ul class="nav nav-tabs" id="news_events_tabs">
          <li class="active"><a href="#news_tab" data-toggle="pill">News <span class="glyphicon glyphicon-bullhorn"></span></a></li>
          <li><a href="#events_tab" data-toggle="pill">Events <span class="glyphicon glyphicon-calendar"></span></a></li>
        </ul>
        <div class="tab-content content">
          <div class="tab-pane active" id="news_tab">
            <?php
              // category__not_in is 'spotlight'
              $query = new WP_Query( array( 'category_name' => 'news', 'category__not_in' => array( 6 ), 'posts_per_page' => '4' ));
              if ( $query->have_posts() ) {
              	while ( $query->have_posts() ) {
              		$query->the_post(); 
            ?>
              		<div <?php post_class('post_preview news_item'); ?>><h5 class="post_title"><a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h5>
              		  <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?></time> 
                    <p>
                  		<?php echo get_the_excerpt(); ?>
                  		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
                    </p>                  
              		</div>
            <?php }
              } else { ?>
              	<div class="alert alert-danger">Content not found.</div>
              <?php }
              wp_reset_postdata();
            ?>
          </div><!-- #news -->
          <div class="tab-pane " id="events_tab">
            <?php 
            $args = array(
              'post_status'=>'publish',
              'post_type'=>array(TribeEvents::POSTTYPE),
              'posts_per_page'=>4,
              //order by startdate from newest to oldest
              'meta_key'=>'_EventStartDate',
              'orderby'=>'_EventStartDate',
              'order'=>'DESC',
              //required in 3.x
              'eventDisplay'=>'custom'
              //query events by category
              // 'tax_query' => array(
              //     array(
              //         'taxonomy' => 'tribe_events_cat',
              //         'field' => 'slug',
              //         'terms' => 'featured',
              //         'operator' => 'IN'
              //     ),
              // )
            );
            $get_posts = null;
            $get_posts = new WP_Query();

            $get_posts->query($args);
            if($get_posts->have_posts()) : while($get_posts->have_posts()) : $get_posts->the_post(); 

    						if( tribe_get_start_date($post->ID, true, 'U')-strtotime('now') < 86400) {
    							if( tribe_get_end_date($post->ID, true, 'U') < strtotime('now') ) $eventstatus="passed"; // event is over
    							elseif( tribe_get_start_date($post->ID, true, 'U') < strtotime('now')) $eventstatus="now"; // event is happening now
    							else /*if( tribe_get_start_date($post->ID, true, 'Ymdhi') <= date('Ymdhi', time('now')) )*/ $eventstatus="soon"; // event is upcoming within the next 24 hours
    						}
    						else $eventstatus="future";
              ?>
              <div class="post_preview event_item event_<?php echo $eventstatus; ?>">
                <div class="event_status event_<?php echo $eventstatus; ?>">
                  <div class="event_status_container"><?php if($eventstatus!="future") echo $eventstatus; ?></div>
                </div>
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?></div>
                  <p>
                		<?php echo get_the_excerpt(); ?>
                		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
                  </p>                  
              </div>
            <?php
              endwhile;
              endif;
              wp_reset_query();
            ?>        
          </div><!-- #events -->
        </div><!-- .tab-content -->
        <div class="row">
        <button id="link_to_news_page" type="button" class="btn btn-link btn-block">
          <a href="./news-events/">Go to the News &amp; Events Page <span class="glyphicon glyphicon-chevron-right"></span></a>
        </button>
      </div>
      </div><!-- #news -->
    </div>
  </div>
  <div id="spotlight" class="content col-sm-4 col-md-3">
    <h3 class="section_heading">Spotlight</h3>
    <?php
      $query = new WP_Query( array( 'category_name' => 'spotlight', 'posts_per_page' => '2' ));
      if ( $query->have_posts() ) {
      	while ( $query->have_posts() ) {
      		$query->the_post();
      		echo '<div class="spotlight_item post_preview">';
      		echo '<h4><a href=' . get_permalink($post->ID) . '>' . get_the_title() . '</a></h3>';
      		echo get_preview_image();
    ?>
          <p>
        		<?php echo get_the_excerpt(); ?>
        		<a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-arrow-right"></span></a>
          </p>
    <?php
      		echo '</div>';
      	}
      } else { ?>
      	<div class="alert alert-danger">Content not found.</div>
      <?php }
      wp_reset_postdata();
    ?>
    <button type="button" class="btn btn-link btn-block"><a class="" href="<?php echo get_category_link( get_cat_ID( 'spotlight' ) ); ?>">Go to Spotlight Archive <span class="glyphicon glyphicon-chevron-right"></span></a></button>
  </div>
</div><!-- #belowthefold -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<script>
function check_for_active_slide(){
  var which_slide_is_active = $('.carousel-indicator.active').attr('data-slide-to');
  if(which_slide_is_active!=null){
    // alert(which_slide_is_active);
    $('.feature_button').removeClass('active');
    $('#feature'+which_slide_is_active).addClass('active');
  }
  else {
    setTimeout(check_for_active_slide, 100); // check again in .1 seconds
  }
}

$('#feature_carousel').on('slid.bs.carousel', function(){ check_for_active_slide(); });
$("#feature0").hover(function(){
  $('.carousel').carousel(0);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature1").hover(function(){
  $('.carousel').carousel(1);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature2").hover(function(){
  $('.carousel').carousel(2);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
$("#feature3").hover(function(){
  $('.carousel').carousel(3);
}).click(function(){
  window.location = $(this).children('a').attr('href');
});
</script>