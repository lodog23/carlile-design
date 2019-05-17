<?php 

	if(get_option('blog_public')){
		echo get_field('qd_ga_code','option');
	}

?>