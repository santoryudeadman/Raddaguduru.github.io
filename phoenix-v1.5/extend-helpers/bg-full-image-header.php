<section id="intro" class="group">

            <div class="black-overlay"></div>
            <div class="container valign">
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-title">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="post-info">
                            <div class="postBy">
                                <p><i class="fa fa-pencil"></i> <?php _e('Posted by','fastwp'); ?> <?php the_author_meta( 'display_name' ); ?> <?php _e('in','fastwp') ?> <?php fastwp_category_list(true);?> <?php _e('on','fastwp'); ?>  <?php the_time( get_option( 'date_format' ) ); ?></p>
                            </div>
                        </div>
                       
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/lineSeparatorWhite.png" class="img-responsive blogSeparator" alt="separator">
                    </div>

                </div>
            </div>

        </section>
